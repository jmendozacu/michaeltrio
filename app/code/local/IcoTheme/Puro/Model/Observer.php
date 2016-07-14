<?php
/**
 * @copyright    Copyright (C) 2015 IcoTheme.com. All Rights Reserved.
 */
?>
<?php

/**
 * Call actions after configuration is saved
 */
class IcoTheme_Puro_Model_Observer
{
    /**
     * After any system config is saved
     */
    public function configSave()
    {
        $section = Mage::app()->getRequest()->getParam('section');
        if ($section == 'puro_design') {
            $websiteCode = Mage::app()->getRequest()->getParam('website');
            $storeCode = Mage::app()->getRequest()->getParam('store');

            Mage::getSingleton('puro/cssgen_generator')->generateCss('color', $websiteCode, $storeCode);
        } else if ($section == 'puro') {
            $websiteCode = Mage::app()->getRequest()->getParam('website');
            $storeCode = Mage::app()->getRequest()->getParam('store');

            Mage::getSingleton('puro/cssgen_generator')->generateCss('layout', $websiteCode, $storeCode);
        }
    }

    /**
     * After store view is saved
     */
    public function storeEdit(Varien_Event_Observer $observer)
    {
        $store = $observer->getEvent()->getStore();
        $storeCode = $store->getCode();
        $websiteCode = $store->getWebsite()->getCode();

        Mage::getSingleton('puro/cssgen_generator')->generateCss('color', $websiteCode, $storeCode);
        Mage::getSingleton('puro/cssgen_generator')->generateCss('layout', $websiteCode, $storeCode);
    }

    public function catalogBlockProductCollectionBeforeToHtml(Varien_Event_Observer $observer)
    {
        $productCollection = $observer->getEvent()->getCollection();
        if ($productCollection instanceof Varien_Data_Collection) {
            $productCollection->load();
            Mage::getModel('puro/collection')->appendType($productCollection);
        }

        return $this;
    }

    public function setPrevNextProductCollection()
    {
        if (Mage::app()->getRequest()->getControllerName() == 'category' && Mage::app()->getRequest()->getActionName() == 'view') {

            $products = Mage::app()->getLayout()
                ->getBlockSingleton('Mage_Catalog_Block_Product_List')
                ->getLoadedProductCollection()
                ->getColumnValues('entity_id');
            Mage::getSingleton('core/session')->setPrevNextProductCollection($products);
            unset($products);
        }
        return $this;
    }

}
