<?php
class Searchtechnow_Recentlypurchased_Model_Mysql4_Recentlypurchased extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('recentlypurchased/recentlypurchased', 'product_id');
    }
}