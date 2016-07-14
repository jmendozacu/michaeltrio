<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/2/15
 * Time: 3:26 PM
 */ 
class Trd_Diamond_Model_Resource_Diamondprod_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('trd_diamond/diamondprod');
    }

}