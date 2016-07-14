<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/2/15
 * Time: 3:23 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$tableName = $installer->getTable('trd_diamond/diamondprod');

$this->run("
CREATE TABLE `{$tableName}` (
`diamondprod_id` int(10) unsigned NOT NULL auto_increment,
`product_id` int(10) NOT NULL,
PRIMARY KEY (`diamondprod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->endSetup();