<?php

class Searchtechnow_Testimonial_Block_Adminhtml_Testimonial_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('testimonial_form', array('legend' => Mage::helper('testimonial')->__('Testimonial information')));

        $fieldset->addField('author', 'text', array(
            'label' => Mage::helper('testimonial')->__('Author name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'author',
        ));
		
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('testimonial')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('logopic', 'image', array(
            'label' => Mage::helper('testimonial')->__('Main Image'),
            'title' => Mage::helper('testimonial')->__('Main Image'),
            'required' => true,
            'name' => 'logopic',
        ));
		
        $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'label' => Mage::helper('testimonial')->__('Content'),
            'title' => Mage::helper('testimonial')->__('Content'),
            'style' => 'width:98%; height:250px;',
            'wysiwyg' => false,
            'required' => true,
        ));
		
		

		$fieldset->addField('date_of_testimonial', 'date', array(
			'name'               => 'date_of_testimonial',
			'label'              => Mage::helper('testimonial')->__('Date Of Testimonial'),
			'tabindex'           => 1,
			'image'              => $this->getSkinUrl('images/grid-cal.gif'),
			'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
			'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
										  strtotime('next weekday') )
		));



        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('testimonial')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('testimonial')->__('Active'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('testimonial')->__('Inactive'),
                ),
            ),
        ));


        if (Mage::getSingleton('adminhtml/session')->getTestimonialData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getTestimonialData());
            Mage::getSingleton('adminhtml/session')->setTestimonialData(null);
        } elseif (Mage::registry('testimonial_data')) {
            $form->setValues(Mage::registry('testimonial_data')->getData());
        }
        return parent::_prepareForm();
    }

}
