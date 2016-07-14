<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/2/15
 * Time: 3:23 PM
 */ 
class Trd_Diamond_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getDiamondTotalPages()
    {
        $collection = Mage::getModel('trd_importxls/importxls')->getCollection();
        $a=$collection->count();
        if ($collection->count()) {
            return round($collection->count() / 50);
        } else {
            return 0;
        }
    }
}