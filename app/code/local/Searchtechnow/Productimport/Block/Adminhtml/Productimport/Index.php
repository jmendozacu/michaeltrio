<?php
class Searchtechnow_Productimport_Block_Adminhtml_Switch_Index extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('productimport/form.phtml');
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
	public function getHandleUpdates()
	{
		Zend_Debug::dump($this->getLayout()->getUpdate()->getHandles());
	}

}
	