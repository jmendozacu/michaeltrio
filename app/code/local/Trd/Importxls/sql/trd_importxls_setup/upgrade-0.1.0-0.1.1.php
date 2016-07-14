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

$this->run("ALTER TABLE `".$tableName."` CHANGE `diamonds_price` `diamonds_price` FLOAT NULL DEFAULT NULL");
$this->run("ALTER TABLE `".$tableName."` CHANGE `price_per_carat` `price_per_carat` FLOAT NULL DEFAULT NULL");
$this->run("ALTER TABLE `".$tableName."` CHANGE `diamonds_weight` `diamonds_weight` FLOAT NULL DEFAULT NULL");
$this->run("ALTER TABLE `".$tableName."` CHANGE `carat` `carat` FLOAT NULL DEFAULT NULL");

$installer->endSetup();