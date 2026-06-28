<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/PriceChange/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/pricechange')) {
            $cache->deleteTree(
                $dev . 'assets/components/pricechange/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/pricechange/', $dev . 'assets/components/pricechange');
        }
        if (!is_link($dev . 'core/components/pricechange')) {
            $cache->deleteTree(
                $dev . 'core/components/pricechange/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/pricechange/', $dev . 'core/components/pricechange');
        }
    }
}

return true;