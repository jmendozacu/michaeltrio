<?php
class Searchtechnow_Productimport_Adminhtml_Switch_DevelopmentController extends Mage_Adminhtml_Controller_Action
{

    
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('searchtechnow_productimport');
        $this->_initLayoutMessages('adminhtml/session');

        //$this->_changeMode();

        $this->renderLayout();
    }
    


    /*
     *
     * cache control not implemented yet
     * @todo: cache control implementation needed
     *
     */
    protected function _changeMode()
    {
        //sets developement mode message
        Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__('Developement mode enabled.'));

        try{
            Mage::getSingleton('core/config')->saveConfig('admin/startup/page', "system/config", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Startup Page has been saved: (value = System => Configuration).'));
        }
        catch(Exception $e){
        	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('design/head/demonotice', "1", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Display Demo Store Notice has been saved: (value = On).'));
        }
        catch(Exception $e){
        	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('admin/dashboard/enable_charts', "0", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Enable Charts has been saved: (value = Off).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }


        try{
            Mage::getSingleton('core/config')->saveConfig('design/head/default_robots', "NOINDEX,NOFOLLOW", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Default Robots has been saved: (value = NOINDEX,NOFOLLOW).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('admin/security/use_form_key', "0", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Secret Key has been saved: (value = Off).'));
        }
        catch(Exception $e){
        	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('dev/js/merge_files', "0", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Merge CSS Files has been saved: (value = Off).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        try{
            Mage::getSingleton('core/config')->saveConfig('dev/css/merge_css_files', "0", 'default', 0);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The configuration for Merge JavaScript Files has been saved: (value = Off).'));
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }


        try{
            //cache controller
            //http://mage.com/index.php/admin/system_cache/

            $empty = array();
            $options = array(
                            'layout' => 0,
                            'eav' => 0,
                            );


            $k = new Mage_Core_Model_Mysql4_Cache();

            $k->saveAllOptions($empty);


            Mage::getModel('core/cache')->flush();
            
            //Mage::getSingleton('core/cache_option')->saveAllOptions($options);

            /**
             * Save all options to option table
             *
             * @param   array $options
             * @return  Mage_Core_Model_Mysql4_Cache
             */
            /*
            public function saveAllOptions($options)
            {
                if (!$this->_getWriteAdapter()) {
                    return $this;
                }
                $this->_getWriteAdapter()->delete($this->getMainTable());
                foreach ($options as $code => $value) {
                    $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                        'code'  => $code,
                        'value' => $value
                    ));
                }
                return $this;
            }
             */

        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return;
        }

        $this->_redirect('*/switch_index/index');
        //$this->_returnUrl();
    }


    protected function _refreshCatalogRewrites()
    {
        try {
            Mage::getSingleton('catalog/url')->refreshRewrites();
            $this->_getSession()->addSuccess(
                Mage::helper('adminhtml')->__('The catalog rewrites have been refreshed.')
            );
        }
        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        catch (Exception $e) {
            $this->_getSession()->addException($e, Mage::helper('adminhtml')->__('An error occurred while refreshing the catalog rewrites.'));
        }

        #$this->_redirect('*/switch_index/index');;
    }

    protected function _clearImagesCache()
    {
        try {
            Mage::getModel('catalog/product_image')->clearCache();
            $this->_getSession()->addSuccess(
                Mage::helper('adminhtml')->__('The image cache was cleared.')
            );
        }
        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        catch (Exception $e) {
            $this->_getSession()->addException($e, Mage::helper('adminhtml')->__('An error occurred while clearing the image cache.'));
        }

        #$this->_redirect('*/switch_index/index');;
    }

    protected function _refreshLayeredNavigation()
    {
        try {
            Mage::getSingleton('catalogindex/indexer')->plainReindex();
            $this->_getSession()->addSuccess(
                Mage::helper('adminhtml')->__('The Layered Navigation indices were refreshed.')
            );
        }
        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        catch (Exception $e) {
            $this->_getSession()->addException($e, Mage::helper('adminhtml')->__('An error occurred while refreshing the layered navigation indices.'));
        }

        #$this->_redirect('*/switch_index/index');;
    }

    /**
     * Admin area entry point
     * Always redirects to the startup page url
     */
    protected function _returnUrl()
    {
        $session = Mage::getSingleton('admin/session');
        $url = $session->getUser()->getStartupPageUrl();

        return $this->_redirect($url);
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('inchoo_developers');
    }

}
