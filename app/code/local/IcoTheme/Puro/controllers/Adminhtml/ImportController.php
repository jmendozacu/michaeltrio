<?php
/**
 * @copyright    Copyright (C) 2015 IcoTheme.com. All Rights Reserved.
 */
?>
<?php
class IcoTheme_Puro_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/puro/"));
    }
    public function blocksAction() {
        $config = Mage::helper('puro')->getCfg('puro_install/install/overwrite_blocks');
        Mage::getSingleton('puro/import_cms')->importCmsItems('cms/block', 'blocks');
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/puro_install/"));
    }
    public function pagesAction() {
        $config = Mage::helper('puro')->getCfg('install/overwrite_pages');
        Mage::getSingleton('puro/import_cms')->importCmsItems('cms/page', 'pages');
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/puro_install/"));
    }
    public function widgetsAction() {
        Mage::getSingleton('puro/import_cms')->importWidgetItems('widget/widget_instance', 'widgets', false);
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/puro_install/"));
    }
}
