<?php
class Searchtechnow_Testimonial_Block_Adminhtml_Testimonial_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'testimonial';
        $this->_controller = 'adminhtml_testimonial';
 
        $this->_updateButton('save', 'label', Mage::helper('testimonial')->__('Save Testimonial'));
        $this->_updateButton('delete', 'label', Mage::helper('testimonial')->__('Delete Testimonial'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('testimonial_data') && Mage::registry('testimonial_data')->getId() ) {
            return Mage::helper('testimonial')->__("Edit Testimonial '%s'", $this->htmlEscape(Mage::registry('testimonial_data')->getTitle()));
        } else {
            return Mage::helper('testimonial')->__('Add Testimonial');
        }
    }
}
