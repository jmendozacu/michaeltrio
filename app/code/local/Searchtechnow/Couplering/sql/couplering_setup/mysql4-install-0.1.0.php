<?php
$installer = $this;
$installer->startSetup();
$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('couplering')} (
  `product_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `menring` varchar(255) NOT NULL default '',
  `womenring` varchar(255) NOT NULL default '',
  `logopic` varchar(255) NOT NULL default '',
  `pic` varchar(255) NOT NULL default '',
  `pic2` varchar(255) NOT NULL default '',
  `status` int(11) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup(); 
