<?php
class Searchtechnow_Stnpromotion_Block_Adminhtml_Stnpromotion_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'stnpromotion';
        $this->_controller = 'adminhtml_stnpromotion';
 
        $this->_updateButton('save', 'label', Mage::helper('stnpromotion')->__('Save News/Promotion'));
        $this->_updateButton('delete', 'label', Mage::helper('stnpromotion')->__('Delete News/Promotion'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('stnpromotion_data') && Mage::registry('stnpromotion_data')->getId() ) {
            return Mage::helper('stnpromotion')->__("Edit News/Promotion '%s'", $this->htmlEscape(Mage::registry('stnpromotion_data')->getTitle()));
        } else {
            return Mage::helper('stnpromotion')->__('Add News/Promotion');
        }
    }
}
