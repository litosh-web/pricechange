<?php

require_once 'update.class.php';

class CheckPriceChangeDefault extends UpdatePriceChangeDefault
{

    public function process()
    {
        $file = $this->dir . $this->filename;

        if (@file_get_contents($file)) {
            return $this->success();
        } else {
            return $this->failure();
        }

    }
}

return 'CheckPriceChangeDefault';