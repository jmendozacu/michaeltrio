<?php

class Searchtechnow_Couplering_Block_Adminhtml_Couplering_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('couplering_form', array('legend' => Mage::helper('couplering')->__('Couple Ring information')));


        $category = new Mage_Catalog_Model_Category();
        $category->load(94);
        //$category->load(4);
        $collection = $category->getProductCollection();
        $collection->addAttributeToSelect('*');
        $menproduct = array();
        $menproduct[] = array('value' => '', 'label' => "Select Man's Ring");
        foreach ($collection as $_product) {
            $menproduct[] = array('value' => $_product->getId(), 'label' => $_product->getName());
        }

        $category->load(88);
        //$category->load(4);
        $collection = $category->getProductCollection();
        $collection->addAttributeToSelect('*');
        $womenproduct = array();
        $womenproduct[] = array('value' => '', 'label' => "Select Woman's Ring");
        foreach ($collection as $_product) {
            $womenproduct[] = array('value' => $_product->getId(), 'label' => $_product->getName());
        }

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('couplering')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
        
        $category = Mage::getModel('catalog/category')->load(98);
        $subcategories = $category->getChildrenCategories();
        $couplecategory[] = array('value' => '', 'label' => "Select Category");
        if (count($subcategories) > 0) {
            foreach ($subcategories as $subcategory) {
                $couplecategory[] = array('value' => $subcategory->getId(), 'label' => $subcategory->getName());
            }
        }

        $fieldset->addField('category_id', 'select', array(
            'label' => Mage::helper('couplering')->__("Category"),
            'class' => 'required-entry',
            'name' => 'category_id',
            'required' => true,
            'values' => $couplecategory,
        ));
        
        $fieldset->addField('menring', 'select', array(
            'label' => Mage::helper('couplering')->__("Men's Ring"),
            'class' => 'required-entry',
            'name' => 'menring',
            'required' => true,
            'values' => $menproduct,
        ));

        $fieldset->addField('womenring', 'select', array(
            'label' => Mage::helper('couplering')->__("Women's Ring"),
            'class' => 'required-entry',
            'name' => 'womenring',
            'required' => true,
            'values' => $womenproduct,
        ));

        $fieldset->addField('logopic', 'image', array(
            'label' => Mage::helper('couplering')->__('Main Image'),
            'title' => Mage::helper('couplering')->__('Main Image'),
            'required' => true,
            'name' => 'logopic',
        ));

        $fieldset->addField('pic', 'image', array(
            'label' => Mage::helper('couplering')->__('Image'),
            'title' => Mage::helper('couplering')->__('Image'),
            'required' => true,
            'name' => 'pic',
        ));

        $fieldset->addField('pic2', 'image', array(
            'label' => Mage::helper('couplering')->__('Image'),
            'title' => Mage::helper('couplering')->__('Image'),
            'required' => true,
            'name' => 'pic2',
        ));


        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('couplering')->__('Status'),
            'name' => 'status',
            'required' => true,
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('couplering')->__('Active'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('couplering')->__('Inactive'),
                ),
            ),
        ));

        if (Mage::getSingleton('adminhtml/session')->getCoupleringData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCoupleringData());
            Mage::getSingleton('adminhtml/session')->setCoupleringData(null);
        } elseif (Mage::registry('couplering_data')) {
            $form->setValues(Mage::registry('couplering_data')->getData());
        }
        return parent::_prepareForm();
    }

}
