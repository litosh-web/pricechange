<?php

class PriceChangeIndexManagerController extends modExtraManagerController
{

    public $pricechange;

    public function initialize()
    {
        $corePath = $this->modx->getOption('pricechange_core_path', null, $this->modx->getOption('core_path') . 'components/pricechange/');

        $this->pricechange = $this->modx->getService('PriceChange', 'PriceChange', MODX_CORE_PATH . 'components/pricechange/model/');
        $this->addJavascript($this->pricechange->config['jsUrl'] . 'mgr/index.js');

        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            pricechange.config = ' . $this->modx->toJSON($this->pricechange->config) . ';
        });
        </script>');
    }

    public function getLanguageTopics()
    {
        return array('pricechange:default');
    }

    public function checkPermissions()
    {
        return true;
    }
}
