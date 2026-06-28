<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('pricechange_core_path', null, $modx->getOption('core_path') . 'components/pricechange/');
require_once $corePath . 'model/pricechange.class.php';
$modx->pricechange = new pricechange($modx);

$modx->lexicon->load('pricechange:default');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->pricechange->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));