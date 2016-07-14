<?php
/**
 * @package   Codewix_IPbasedDevmode
 * @author    Ravinder <codewix@gmail.com>
 */
class Codewix_IpbasedDevmode_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getConfig($field) {
        return Mage::getStoreConfig("devmode/general/$field");
    }

}