<?php

class PriceChange
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/pricechange/';
        $assetsUrl = MODX_ASSETS_URL . 'components/pricechange/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('pricechange', $this->config['modelPath']);
        $this->modx->lexicon->load('pricechange:default');
    }

    public function checkProduct($id)
    {
        if ($this->modx->getObject('msProduct', $id)) {
            return true;
        } else {
            $this->modx->log(1, $this->modx->lexicon('pricechange_error_not_a_product') . '. ID: ' . $id);
            return false;
        }
    }

    

}