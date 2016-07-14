<?php
class Searchtechnow_Couplering_Block_Adminhtml_Couplering extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_couplering';
        $this->_blockGroup = 'couplering';
        $this->_headerText = Mage::helper('couplering')->__('Couple Rings Manager');
        $this->_addButtonLabel = Mage::helper('couplering')->__('Add Couple Ring');
        parent::__construct();
    }
}