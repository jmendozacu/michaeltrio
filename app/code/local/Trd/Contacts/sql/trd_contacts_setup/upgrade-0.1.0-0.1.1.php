<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 9/1/15
 * Time: 11:43 PM
 *
 * ---------------- Make your own table here
 *
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$tableName = $installer->getTable('trd_contacts/testimonials');

$this->run("
CREATE TABLE `{$tableName}` (
`t_id` int(10) unsigned NOT NULL auto_increment,
`description` varchar(5000) NOT NULL,
`photo` varchar(50000) NOT NULL,
PRIMARY KEY  (`t_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->endSetup();