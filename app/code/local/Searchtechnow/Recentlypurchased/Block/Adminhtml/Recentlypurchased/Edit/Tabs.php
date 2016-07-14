<?php

class Searchtechnow_Recentlypurchased_Block_Adminhtml_Recentlypurchased_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('recentlypurchased_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('recentlypurchased')->__('Recently Purchased Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('recentlypurchased')->__('Recently Purchased Information'),
            'title'     => Mage::helper('recentlypurchased')->__('Recently Purchased Information'),
            'content'   => $this->getLayout()->createBlock('recentlypurchased/adminhtml_recentlypurchased_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}