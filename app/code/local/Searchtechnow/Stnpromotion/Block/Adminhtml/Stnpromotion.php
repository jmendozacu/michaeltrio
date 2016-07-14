<?php
class Searchtechnow_Stnpromotion_Block_Adminhtml_Stnpromotion extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_stnpromotion';
        $this->_blockGroup = 'stnpromotion';
        $this->_headerText = Mage::helper('stnpromotion')->__('News/Promotion Manager');
        $this->_addButtonLabel = Mage::helper('stnpromotion')->__('Add News/Promotion');
        parent::__construct();
    }
}