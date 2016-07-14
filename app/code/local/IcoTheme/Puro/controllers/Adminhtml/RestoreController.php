<?php
/**
 * @copyright    Copyright (C) 2015 IcoTheme.com. All Rights Reserved.
 */
?>
<?php

class IcoTheme_Puro_Adminhtml_RestoreController extends Mage_Adminhtml_Controller_Action
{

    protected $_stores;
    protected $_clear;

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')
            ->isAllowed('icotheme/puro/restore');
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('icotheme/puro/restore')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Restore Defaults'), Mage::helper('adminhtml')->__('Restore Defaults'));
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__('IcoTheme'))
            ->_title($this->__('Puro'))
            ->_title($this->__('Restore Defaults'));
        $this->_addContent($this->getLayout()->createBlock('puro/adminhtml_restore_edit'));
        $this->renderLayout();
    }

    public function restoreAction()
    {
        $this->_stores = $this->getRequest()->getParam('stores', array(0));
        $this->_clear = $this->getRequest()->getParam('clear_scope', true);
        $cms_block = $this->getRequest()->getParam('cms_block', 0);
        $cms_page = $this->getRequest()->getParam('cms_page', 0);
        $deactivate = $this->getRequest()->getParam('deactivate', 0);
        $config = $this->getRequest()->getParam('config', 0);
        if ($this->_clear) {
            if (!in_array(0, $this->_stores))
                $stores[] = 0;
        }
        try {

            if ($cms_block):
                Mage::getSingleton('puro/import_cms')->importCmsItems('cms/block', 'blocks');
            endif;
            if ($cms_page):
                Mage::getSingleton('puro/import_cms')->importCmsItems('cms/page', 'pages');
            endif;
            if ($deactivate):
                foreach ($this->_stores as $store) {
                    $scope = ($store ? 'stores' : 'default');
                    Mage::getConfig()->saveConfig('design/package/name', 'default', $scope, $store);
                }
            endif;
            if ($config):
                $defaults = new Varien_Simplexml_Config();
                $defaults->loadFile(Mage::getBaseDir() . '/app/code/local/IcoTheme/Puro/etc/config.xml');
                $this->_restoreSettings($defaults->getNode('default/puro_design')->children(), 'puro_design');
            endif;

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Default Settings for Puro Design Theme has been restored.'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while restoring theme settings.'));
        }
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }

    private function _restoreSettings($items, $path)
    {
        $websites = Mage::app()->getWebsites();
        $stores = Mage::app()->getStores();
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->_restoreSettings($item->children(), $path . '/' . $item->getName());
            } else {
                if ($this->_clear) {
                    Mage::getConfig()->deleteConfig($path . '/' . $item->getName());
                    foreach ($websites as $website) {
                        Mage::getConfig()->deleteConfig($path . '/' . $item->getName(), 'websites', $website->getId());
                    }
                    foreach ($stores as $store) {
                        Mage::getConfig()->deleteConfig($path . '/' . $item->getName(), 'stores', $store->getId());
                    }
                }
                foreach ($this->_stores as $store) {
                    $scope = ($store ? 'stores' : 'default');
                    Mage::getConfig()->saveConfig($path . '/' . $item->getName(), (string)$item, $scope, $store);
                }
            }
        }
    }

}