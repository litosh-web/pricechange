<?php

class UpdatePriceChangeDefault extends modObjectUpdateProcessor
{
    public $objectType = 'PriceChangeDefault';
    public $classKey = 'PriceChangeDefault';

    //public $permission = 'edit_document';

    public function beforeSet()
    {
        $type = $this->getProperty('type');

        foreach (array('type', 'scope') as $v) {
            if (!$this->getProperty($v)) {
                $this->addFieldError($v);
            }
        }

        if ($type == 'tv') {
            $v = 'tv_name';
            if (!$this->getProperty($v)) {
                $this->addFieldError($v);
            }
        }

        return parent::beforeSet();
    }
}

return 'UpdatePriceChangeDefault';