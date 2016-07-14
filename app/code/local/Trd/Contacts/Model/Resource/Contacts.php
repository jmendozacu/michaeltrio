<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 9/2/15
 * Time: 12:05 AM
 */ 
class Trd_Contacts_Model_Resource_Contacts extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('trd_contacts/list', 'list_id');
    }

}