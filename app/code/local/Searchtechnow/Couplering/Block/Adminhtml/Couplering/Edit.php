<?php
class Searchtechnow_Couplering_Block_Adminhtml_Couplering_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'couplering';
        $this->_controller = 'adminhtml_couplering';
 
        $this->_updateButton('save', 'label', Mage::helper('couplering')->__('Save Couple Ring'));
        $this->_updateButton('delete', 'label', Mage::helper('couplering')->__('Delete Couple Ring'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('couplering_data') && Mage::registry('couplering_data')->getId() ) {
            return Mage::helper('couplering')->__("Edit Couple Ring '%s'", $this->htmlEscape(Mage::registry('couplering_data')->getTitle()));
        } else {
            return Mage::helper('couplering')->__('Add Couple Ring');
        }
    }
}
