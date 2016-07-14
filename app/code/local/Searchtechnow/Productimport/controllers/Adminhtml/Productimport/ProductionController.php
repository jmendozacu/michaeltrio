<?php
class Searchtechnow_Productimport_Adminhtml_Switch_ProductionController extends Mage_Adminhtml_Controller_Action
{

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('searchtechnow_productimport');
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('searchtechnow_productimport');
        $this->_initLayoutMessages('adminhtml/session');

        //$this->_changeMode();

        $this->renderLayout();
    }



    protected function _changeMode()
    {
        //sets production mode message
        Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__('Production mode enabled.'));
        
        try{
            Mage::getSingleton('core/config')->saveConfig('admin/startup/page', "dashboard", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Startup Page has been saved: (value = Dashboard).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('design/head/demonotice', "0", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Display Demo Store Notice has been saved: (value = Off).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('admin/dashboard/enable_charts', "1", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Enable Charts has been saved: (value = On).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('design/head/default_robots', "INDEX,FOLLOW", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Default Robots has been saved: (value = INDEX,FOLLOW).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }
        
        try{
            Mage::getSingleton('core/config')->saveConfig('admin/security/use_form_key', "1", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Secret Key has been saved: (value = On).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('dev/js/merge_files', "1", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Merge CSS Files has been saved: (value = On).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('dev/css/merge_css_files', "1", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Merge JavaScript Files has been saved: (value = On).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        $this->_redirect('*/switch_index/index');
    }
}
