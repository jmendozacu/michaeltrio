<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/28/15
 * Time: 4:29 PM
 */ 
class Trd_Engraving_Model_Resource_engraving extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('trd_engraving/engraving', 'engraving_id');
    }

}