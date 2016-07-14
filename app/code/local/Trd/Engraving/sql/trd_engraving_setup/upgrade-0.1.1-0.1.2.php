<?php

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$setup->addAttribute('catalog_product', 'style', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Style',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'solitare' => array('Solitare'),
            'pave' => array('Pave'),
            'channel_set' => array('Channel set'),
            'side_stone' => array('Side stone'),
            'vintage' => array('Vintage'),
            'halo' => array('Halo'),
        )
    ),
    'required'		=> 0,
    'user_defined' => 1,
    'searchable' => 1,
    'filterable' => 0,
    'comparable'	=> 1,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$installer->endSetup();