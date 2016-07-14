<?php

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
/**
 * Adding Different Attributes
 */

// adding attribute group
$setup->addAttributeGroup('catalog_product', 'Default', 'Ring Options', 1000);

// the attribute added will be displayed under the group/tab Special Attributes in product edit page
$setup->addAttribute('catalog_product', 'sst1_gemstone', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (1) Gemstone',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst1_shape', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (1) Shape',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst1_number_diamonds', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (1) Number of Diamonds',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst1_weight_estimated', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (1) Total Carat Weight Estimated',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst1_average_color', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (1) Average Color',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst1_average_clarity', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (1) Average Clarity',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst1_average_cut', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (1) Average Cut',
    'backend'       => '',
    'visible'       => 1,
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

// ----------------        Side Stone 2     ----------------------
$setup->addAttribute('catalog_product', 'sst2_gemstone', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (2) Gemstone',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst2_shape', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (2) Shape',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst2_number_diamonds', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (2) Number of Diamonds',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst2_weight_estimated', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (2) Total Carat Weight Estimated',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst2_average_color', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (2) Average Color',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst2_average_clarity', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (2) Average Clarity',
    'backend'       => '',
    'visible'       => 1,
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

$setup->addAttribute('catalog_product', 'sst2_average_cut', array(
    'group'     	=> 'Ring Options',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Side Stone (2) Average Cut',
    'backend'       => '',
    'visible'       => 1,
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


// Compare with Diamonds
$setup->addAttribute('catalog_product', 'asscher', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Asscher',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'cushion', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Cushion',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'emerald', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Emerald',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'heart', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Heart',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'marquise', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Marquise',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'oval', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Oval',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'pear', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Pear',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'princess', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Princess',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'radiant', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Radiant',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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

$setup->addAttribute('catalog_product', 'round', array(
    'group'     	=> 'Ring Options',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Round',
    'backend'       => 'eav/entity_attribute_backend_array',
    'visible'       => 1,
    'option'        => array (
        'value' => array(
            'yes' => array('Yes'),
            'no' => array('No'),
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