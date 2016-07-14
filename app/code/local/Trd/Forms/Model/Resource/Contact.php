<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 11/6/15
 * Time: 6:49 PM
 */ 
class Trd_Forms_Model_Resource_Contact extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('trd_forms/formcontact', 'formcontact_id');
    }

}