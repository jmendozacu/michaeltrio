<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 9/30/15
 * Time: 9:24 PM
 */ 
class Trd_Importxls_Model_Resource_Importxls_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('trd_importxls/importxls');
    }

}