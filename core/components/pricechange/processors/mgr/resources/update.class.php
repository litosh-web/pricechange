<?php

class UpdatePriceChangeDefault extends modProcessor
{

    public $sleep = 0;
    public $dir = MODX_CORE_PATH . 'cache/pricechange/';
    public $filename = 'process.txt';

    public $type;
    public $categories;
    public $tv_name;
    public $scope;
    public $_class;

    public function process()
    {
        $count = 0;
        $file = $this->dir . $this->filename;

        $this->modx->addPackage('pricechange', MODX_CORE_PATH . 'components/pricechange/model/');

        $q = $this->modx->newQuery('PriceChangeDefault');
        $q->limit(1);
        $settings = $this->modx->getObject('PriceChangeDefault', $q);
        $this->type = $settings->get('type');
        $this->_class = ($this->type == 'tv') ? 'modResource' : 'msProduct';
        $this->categories = $this->modx->fromJSON($settings->get('categories'));
        $this->tv_name = $settings->get('tv_name');
        $this->scope = $settings->get('scope');

        $q = $this->modx->newQuery($this->_class);
        $q->where(['parent:IN' => $this->categories]);
        //$q->limit(10);

        $resources = $this->modx->getCollection($this->_class, $q);
        $arr['total'] = count($resources);

        foreach ($resources as $res) {
            $count++;

            $this->modx->invokeEvent('pcBeforeUpdateResource', [
                'resource' => $res,
                'type' => $this->type,
                'scope' => $this->scope,
            ]);

            switch ($this->type) {
                case 'ms':
                    $price = $res->get('price');
                    $old_price = $res->get('old_price');

                    if (!is_numeric($price)) {
                        $this->modx->log(1, '[pricechange] Resource with ID:' . $res->get('id') . ' doesn`t have numeric value');
                        continue 2;
                    }

                    $price = $price + ($price * $this->scope) / 100;
                    $price = round($price);

                    $old_price = $old_price + ($old_price * $this->scope) / 100;
                    $old_price = round($old_price);

                    $res->set('price', $price);
                    $res->set('old_price', $old_price);
                    break;
                case 'tv':
                    $price = $res->getTVValue($this->tv_name);

                    if (!is_numeric($price)) {
                        $this->modx->log(1, '[pricechange] Resource with ID:' . $res->get('id') . ' doesn`t have numeric value');
                        continue 2;
                    }

                    $price = $price + ($price * $this->scope) / 100;
                    $price = round($price);
                    $res->setTVValue($this->tv_name, $price);
                    break;
            }

            //$this->modx->log(1, "[" . $res->id . "] " . $price . " - " . $res->pagetitle);

            $arr['current'] = $count;
            $arr['res_id'] = $res->id;

            if (!is_dir($this->dir)) {
                mkdir($this->dir);
            }

            file_put_contents($file, $this->modx->toJSON($arr));

            $res->save();

            $this->modx->invokeEvent('pcAfterUpdateResource', [
                'resource' => $res,
                'type' => $this->type,
                'scope' => $this->scope,
            ]);

            usleep($this->sleep);

        }

        if (is_file($file)) {
            unlink($file);
        }

        return $this->success();
    }
}

return 'UpdatePriceChangeDefault';