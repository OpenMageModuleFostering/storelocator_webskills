<?php
$installer = $this;
$installer->startSetup();
$installer->run("

CREATE TABLE {$this->getTable('storelocator_information')} (
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(60) NOT NULL,
	`address` varchar(255) NOT NULL,
	`city` varchar(60) NOT NULL,
	`state` varchar(60) NOT NULL,
	`lat` float(10,6) NOT NULL,
	`lng` float(10,6) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup(); 
