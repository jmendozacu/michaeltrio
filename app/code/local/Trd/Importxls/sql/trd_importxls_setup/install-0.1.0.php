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
$tableName = $installer->getTable('trd_importxls/importxls');

$this->run("
CREATE TABLE `{$tableName}` (
`importxls_id` int(10) unsigned NOT NULL auto_increment,
`supplier` varchar(255) NOT NULL,
`cert_url` varchar(255) NOT NULL,
`diamonds_name` varchar(255) NOT NULL,
`diamonds_model` varchar(255) NOT NULL,
`diamonds_price` varchar(255) NOT NULL,
`price_per_carat` varchar(255) NOT NULL,
`quantity` varchar(255) NOT NULL,
`description` varchar(255) NOT NULL,
`diamonds_weight` varchar(255) NOT NULL,
`shape` varchar(255) NOT NULL,
`carat` varchar(255) NOT NULL,
`color` varchar(255) NOT NULL,
`clarity` varchar(255) NOT NULL,
`cut` varchar(255) NOT NULL,
`report_no` varchar(255) NOT NULL,
`cert` varchar(255) NOT NULL,
`polish` varchar(255) NOT NULL,
`symmetry` varchar(255) NOT NULL,
`fluorescence` varchar(255) NOT NULL,
`depth` varchar(255) NOT NULL,
`table_field` varchar(255) NOT NULL,
`girdle` varchar(255) NOT NULL,
`measurement_1` varchar(255) NOT NULL,
`measurement_2` varchar(255) NOT NULL,
`measurement_3` varchar(255) NOT NULL,
`diamonds_image` varchar(255) NOT NULL,
`image` varchar(255) NOT NULL,
PRIMARY KEY (`importxls_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->endSetup();