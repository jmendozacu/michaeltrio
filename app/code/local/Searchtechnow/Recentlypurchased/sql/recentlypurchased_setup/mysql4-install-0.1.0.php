<?php
$installer = $this;
$installer->startSetup();
$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('recentlypurchased')} (
  `product_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `shape` varchar(255) NOT NULL default '',
  `colour` varchar(255) NOT NULL default '',  
  `carat` varchar(255) NOT NULL default '',
  `clarity` varchar(255) NOT NULL default '',
  `cut` varchar(255) NOT NULL default '',
  `setting` varchar(255) NOT NULL default '',
  `price` varchar(255) NOT NULL default '',
  `logopic` varchar(255) NOT NULL default '',
  `status` int(11) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup(); 
