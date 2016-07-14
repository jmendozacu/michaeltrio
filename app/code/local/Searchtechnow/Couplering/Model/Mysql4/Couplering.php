<?php
class Searchtechnow_Couplering_Model_Mysql4_Couplering extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('couplering/couplering', 'product_id');
    }
}