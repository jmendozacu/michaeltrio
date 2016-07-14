<?php
$installer = $this;
$installer->startSetup();


$installer->addAttribute("catalog_category", "ispackable",  array(
    "type"     => "int",
    "backend"  => "",
    "frontend" => "",
    "label"    => "Is packable",
    "input"    => "select",
    "class"    => "",
    "source"   => "eav/entity_attribute_source_boolean",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    "visible"  => true,
    "required" => true,
    "user_defined"  => false,
    "default" => "0",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

	));
$installer->endSetup();
	 