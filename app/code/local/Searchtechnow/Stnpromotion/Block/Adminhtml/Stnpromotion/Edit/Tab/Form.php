<?php

class Searchtechnow_Stnpromotion_Block_Adminhtml_Stnpromotion_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareLayout() {
        $return = parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return $return;
    }

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('stnpromotion_form', array('legend' => Mage::helper('stnpromotion')->__('News/Promotion information')));

        $fieldset->addField('promotion_text', 'editor', array(
            'name' => 'promotion_text',
            'label' => Mage::helper('stnpromotion')->__('Promotion Text'),
            'title' => Mage::helper('stnpromotion')->__('Promotion Text'),
            'style' => 'width:400px; height:250px;',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg' => true,
            'required' => true,
        ));


        $fieldset->addField('short_order', 'text', array(
            'label' => Mage::helper('stnpromotion')->__('Short Order'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'short_order',
        ));


        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('stnpromotion')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('stnpromotion')->__('Active'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('stnpromotion')->__('Inactive'),
                ),
            ),
        ));


        if (Mage::getSingleton('adminhtml/session')->getStnpromotionData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getStnpromotionData());
            Mage::getSingleton('adminhtml/session')->setStnpromotionData(null);
        } elseif (Mage::registry('stnpromotion_data')) {
            $form->setValues(Mage::registry('stnpromotion_data')->getData());
        }
        return parent::_prepareForm();
    }

}
