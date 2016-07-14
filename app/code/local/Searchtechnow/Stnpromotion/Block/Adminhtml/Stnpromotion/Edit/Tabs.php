<?php

class Searchtechnow_Stnpromotion_Block_Adminhtml_Stnpromotion_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('stnpromotion_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('stnpromotion')->__('News/Promotion Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('stnpromotion')->__('News/Promotion Information'),
            'title'     => Mage::helper('stnpromotion')->__('News/Promotion Information'),
            'content'   => $this->getLayout()->createBlock('stnpromotion/adminhtml_stnpromotion_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}