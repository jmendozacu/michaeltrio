<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 11/6/15
 * Time: 6:47 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$tableName = $installer->getTable('trd_forms/formcontact');

$installer->run("
CREATE TABLE `{$tableName}` (
`formcontact_id` int(10) unsigned NOT NULL auto_increment,
`name` varchar(255) NOT NULL,
`email` varchar(255) NULL,
`contact` varchar(255) NULL,
`date` varchar(255) NULL,
`time` varchar(255) NULL,
`text` text NULL,
PRIMARY KEY (`formcontact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();