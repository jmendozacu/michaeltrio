<?php
class Searchtechnow_Productimport_IndexController extends Mage_Core_Controller_Front_Action 
{
	public function indexAction()
	{
		$this->_title($this->__('Searchtechnow Productimport'))->_title($this->__('Frontend Controller'));
		$this->loadLayout();
        $this->_initLayoutMessages('adminhtml/session');
        $this->renderLayout();
		
        Zend_Debug::dump($this->getLayout()->getUpdate()->getHandles());
	}
	
	public function testAction()
	{
        //$this->_redirect('/');
	}

}