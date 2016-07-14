<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/28/15
 * Time: 4:19 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('trd_engraving/engraving');

$this->run("
CREATE TABLE `{$tableName}` (
`engraving_id` int(10) unsigned NOT NULL auto_increment,
`product_id` int(10) NOT NULL,
`text` varchar(255) NOT NULL,
`font` varchar(255) NULL,
PRIMARY KEY (`engraving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();