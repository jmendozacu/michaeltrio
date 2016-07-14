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

$installer->run("ALTER TABLE ".$tableName." ADD proposal_ring int(1)");
$installer->run("ALTER TABLE ".$tableName." ADD wedding_ring int(1)");
$installer->run("ALTER TABLE ".$tableName." ADD other int(1)");

$installer->endSetup();