<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('sales/quote_item'),'importxls_id', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => true,
        'length'    => 11,
        'comment'   => 'Importxls id'
    ));
$installer->endSetup();