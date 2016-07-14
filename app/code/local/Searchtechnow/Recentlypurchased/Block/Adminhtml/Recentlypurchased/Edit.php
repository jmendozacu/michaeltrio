<?php
class Searchtechnow_Recentlypurchased_Block_Adminhtml_Recentlypurchased_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'recentlypurchased';
        $this->_controller = 'adminhtml_recentlypurchased';
 
        $this->_updateButton('save', 'label', Mage::helper('recentlypurchased')->__('Save Recently Purchased'));
        $this->_updateButton('delete', 'label', Mage::helper('recentlypurchased')->__('Delete Recently Purchased'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('recentlypurchased_data') && Mage::registry('recentlypurchased_data')->getId() ) {
            return Mage::helper('recentlypurchased')->__("Edit Recently Purchased '%s'", $this->htmlEscape(Mage::registry('recentlypurchased_data')->getTitle()));
        } else {
            return Mage::helper('recentlypurchased')->__('Add Recently Purchased');
        }
    }
}
