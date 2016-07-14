<?php
class Searchtechnow_Recentlypurchased_Block_Adminhtml_Recentlypurchased extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_recentlypurchased';
        $this->_blockGroup = 'recentlypurchased';
        $this->_headerText = Mage::helper('recentlypurchased')->__('Recently Purchased Manager');
        $this->_addButtonLabel = Mage::helper('recentlypurchased')->__('Add Recently Purchased');
        parent::__construct();
    }
}