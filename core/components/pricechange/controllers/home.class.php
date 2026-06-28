<?php

require_once __DIR__ . "/../index.class.php";

/**
 * The home manager controller for pricechange.
 *
 */
class PriceChangeHomeManagerController extends PriceChangeIndexManagerController
{
    /** @var pricechange $pricechange */
    public $pricechange;


    /**
     *
     */
    public function initialize()
    {
        $this->pricechange = $this->modx->getService('PriceChange', 'pricechange', MODX_CORE_PATH . 'components/pricechange/model/');
        parent::initialize();

        $q = $this->modx->newQuery('PriceChangeDefault');
        $q->limit(1);
        $settings = $this->modx->getObject('PriceChangeDefault', $q);

        $this->fields = $settings->toArray();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['pricechange:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('pricechange');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->pricechange->config['jsUrl'] . 'mgr/sections/main.js');

        $this->addJavascript($this->pricechange->config['jsUrl'] . 'mgr/widgets/panel.home.js');
        $this->addJavascript($this->pricechange->config['jsUrl'] . 'mgr/widgets/category.js');
        $this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
		    pricechange.data = '.$this->modx->toJSON($this->fields).';
			MODx.load({xtype: "pricechange-page-home"});
		});
		</script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        //$this->content .= '<div id="pricechange-panel-home-div"></div>';

        return '';
    }
}