<?php

class Searchtechnow_Stnpromotion_Helper_Data extends Mage_Core_Helper_Abstract {

    public function updateDirSepereator($path) {
        return str_replace('\\', DS, $path);
    }

}
