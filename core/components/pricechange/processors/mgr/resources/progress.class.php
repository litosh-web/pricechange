<?php

require_once 'update.class.php';

class ProgressPriceChangeDefault extends UpdatePriceChangeDefault
{

    public function process()
    {
        $file = $this->dir . $this->filename;
        $content = @file_get_contents($file);

        $content = $this->modx->fromJSON($content);
        if (!$content) {
            $content = [];
        }

        $content['success'] = true;

        $content = $this->modx->toJSON($content);
        //$this->modx->log(1, print_r($content, 1));

        return $content;
    }
}

return 'ProgressPriceChangeDefault';