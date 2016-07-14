<?php
class Searchtechnow_Stnpromotion_Model_Mysql4_Stnpromotion extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('stnpromotion/stnpromotion', 'promotion_id');
    }
}