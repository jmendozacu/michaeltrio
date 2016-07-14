<?php

class Searchtechnow_Recentlypurchased_Block_Adminhtml_Recentlypurchased_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('recentlypurchased_form', array('legend' => Mage::helper('recentlypurchased')->__('Recently Purchased information')));


        $categoryid = 4;
        $category = new Mage_Catalog_Model_Category();
        $category->load($categoryid);
        $collection = $category->getProductCollection();
        $collection->addAttributeToSelect('*');
        $catproduct = array();
        foreach ($collection as $_product) {
            //echo $_product->getId().'<br/>';
            $catproduct[] = array('value' => $_product->getId(), 'label' => $_product->getSku());
        }

        $shapearray = array(
            array(
                'value' => 'AS',
                'label' => Mage::helper('recentlypurchased')->__('Asscher'),
            ),
            array(
                'value' => 'CU',
                'label' => Mage::helper('recentlypurchased')->__('Cushion'),
            ),
            array(
                'value' => 'EC',
                'label' => Mage::helper('recentlypurchased')->__('Emerald'),
            ),
            array(
                'value' => 'HS',
                'label' => Mage::helper('recentlypurchased')->__('Heart'),
            ),
            array(
                'value' => 'MQ',
                'label' => Mage::helper('recentlypurchased')->__('Marquise'),
            ),
            array(
                'value' => 'OV',
                'label' => Mage::helper('recentlypurchased')->__('Oval'),
            ),
            array(
                'value' => 'PR',
                'label' => Mage::helper('recentlypurchased')->__('Pear'),
            ),
            array(
                'value' => 'PS',
                'label' => Mage::helper('recentlypurchased')->__('Princess'),
            ),
            array(
                'value' => 'RA',
                'label' => Mage::helper('recentlypurchased')->__('Radiant'),
            ),
            array(
                'value' => 'RD',
                'label' => Mage::helper('recentlypurchased')->__('Round'),
            ),
        );

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('recentlypurchased')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('shape', 'select', array(
            'label' => Mage::helper('recentlypurchased')->__('Shape'),
            'class' => 'required-entry',
            'name' => 'shape',
            'values' => $shapearray,
        ));
        $fieldset->addField('colour', 'text', array(
            'label' => Mage::helper('recentlypurchased')->__('Colour'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'colour',
        ));
        $fieldset->addField('carat', 'text', array(
            'label' => Mage::helper('recentlypurchased')->__('Carat'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'carat',
        ));
        $fieldset->addField('clarity', 'text', array(
            'label' => Mage::helper('recentlypurchased')->__('Clarity'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'clarity',
        ));
        $fieldset->addField('cut', 'text', array(
            'label' => Mage::helper('recentlypurchased')->__('Cut'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'cut',
        ));

        $fieldset->addField('setting', 'select', array(
            'label' => Mage::helper('recentlypurchased')->__('Product Sku'),
            'class' => 'required-entry',
            'name' => 'setting',
            'values' => $catproduct,
        ));

        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('recentlypurchased')->__('Price'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'price',
        ));

        $fieldset->addField('logopic', 'image', array(
            'label' => Mage::helper('recentlypurchased')->__('Main Image'),
            'title' => Mage::helper('recentlypurchased')->__('Main Image'),
            'required' => true,
            'name' => 'logopic',
        ));

        $fieldset->addField('pic', 'image', array(
            'label' => Mage::helper('recentlypurchased')->__('Image'),
            'title' => Mage::helper('recentlypurchased')->__('Image'),
            'required' => true,
            'name' => 'pic',
        ));

        $fieldset->addField('pic2', 'image', array(
            'label' => Mage::helper('recentlypurchased')->__('Image'),
            'title' => Mage::helper('recentlypurchased')->__('Image'),
            'required' => true,
            'name' => 'pic2',
        ));


        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('recentlypurchased')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('recentlypurchased')->__('Active'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('recentlypurchased')->__('Inactive'),
                ),
            ),
        ));

//        $fieldset->addField('content', 'editor', array(
//            'name' => 'content',
//            'label' => Mage::helper('recentlypurchased')->__('Content'),
//            'title' => Mage::helper('recentlypurchased')->__('Content'),
//            'style' => 'width:98%; height:400px;',
//            'wysiwyg' => false,
//            'required' => true,
//        ));

        if (Mage::getSingleton('adminhtml/session')->getRecentlypurchasedData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getRecentlypurchasedData());
            Mage::getSingleton('adminhtml/session')->setRecentlypurchasedData(null);
        } elseif (Mage::registry('recentlypurchased_data')) {
            $form->setValues(Mage::registry('recentlypurchased_data')->getData());
        }
        return parent::_prepareForm();
    }

}
