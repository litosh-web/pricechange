<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modx->addPackage('pricechange', MODX_CORE_PATH . 'components/pricechange/model/');

            //add settings
            $manager = $modx->getManager();
            $objects = [];

            $arr_default = [
                'type' => 'ms',
                'tv_name' => '',
                'scope' => 10,
                'categories' => ''
            ];

            if (!$modx->getCount('PriceChangeDefault')) {
                $default = $modx->newObject('PriceChangeDefault', $arr_default);
                if ($default->save()) {
                    $modx->log(xPDO::LOG_LEVEL_INFO, '[Tables] Successfully add Default fields!');
                }
            }

            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;