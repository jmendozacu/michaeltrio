<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 9/1/15
 * Time: 11:43 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$tableName = $installer->getTable('trd_contacts/list');

$this->run("
CREATE TABLE `{$tableName}` (
`list_id` int(10) unsigned NOT NULL auto_increment,
`phone` varchar(50) NOT NULL,
`email` varchar(50) NOT NULL,
`map` varchar(50) NOT NULL,
`long` varchar(1500) NOT NULL,
`lat` varchar(1500) NOT NULL,
PRIMARY KEY  (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->endSetup();