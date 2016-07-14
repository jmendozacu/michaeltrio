<?php
class Aitoc_Aitpreorder_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_productBackstockCache = array();
    private $_validController = null;

    /**
     * Gets the order for particular item (if order exists)
     *
     * @param object $item
     * @return object
     */
    public function getOrder($item)
    {
        try
        {
            return $item->getOrder();
        }
        catch (Exception $e) {}

        return null;
    }

    /**
     * Inits product in a "right" way. Tries to add store id to product when loadinig it.
     *
     * @param object $item
     * @param string $sku
     * @return Mage_Catalog_Model_Product
     */
    public function initProduct($item, $sku = null)
    {
        $product = Mage::getModel('catalog/product');
        $order = $this->getOrder($item);

        if ($order)
        {
            $product->setStoreId($order->getStoreId());

            //FIX FOR WRONG STORE ID IN Aitoc_Aitquantitymanager_Model_Rewrite_FrontCatalogInventoryStockItem::loadByProduct
            if (!Mage::registry('aitoc_order_refund_store_id'))
            {
                Mage::register('aitoc_order_refund_store_id', $order->getStoreId());
            }
        }

        $itemData = $item->getData();
        $productId = $sku ? $product->getIdBySku($sku) : $itemData['product_id'];
        $product->load($productId);
        return $product;
    }

    public function bundleHaveReg($_item)
    {
        $haveregular=0;
        $havePreorderInBundle=0;
        $bundleItems=$_item->getChildrenItems();
        foreach ($bundleItems as $bundleItem)
        {
            $original_product = $this->initProduct($bundleItem);
            if($original_product->getPreorder()==1)
            {
                $havePreorderInBundle=1;
            }

        }
        if($havePreorderInBundle==0)
        {
            $haveregular=1;
        }
        return $haveregular;
    }

    public function isHaveReg($_items,$ispending=0)
    {
        $haveregular=0;
        $havepreorder = 0;
        $noparent_item=0;
        $alldownloadable=1;
        $preorderdownloadable=0;
        foreach($_items as $_item)
        {
            $itemInOrderData=$_item->getData();
            $noparent_item=0;
            $isshiped=0;
            // if we here from frontend
            if(isset($itemInOrderData['qty_shipped']) && isset($itemInOrderData['qty_ordered']))
            {
                if(((int)($itemInOrderData['qty_shipped']))==((int)($itemInOrderData['qty_ordered'])))
                {
                    $isshiped=1;
                }
                if(!isset($itemInOrderData['parent_item_id']))
                {
                    $noparent_item=1;
                }
            }
            elseif(!isset($itemInOrderData['parent_item_id']))
            {
                $noparent_item=1;
            }

            if($isshiped==0)
            {
                if($itemInOrderData['product_type']=='grouped')
                {
                    $alldownloadable=0;
                    $_product = $this->initProduct($_item);
                    $preorder=$_product->getPreorder();
                    if($preorder!='1')
                    {
                        $haveregular=1;
                    } else {
                        $havepreorder = 1;
                    }
                }
                elseif($itemInOrderData['product_type']=='configurable')
                {
                    $alldownloadable=0;
                    $item_data=unserialize($_item->getData('product_options'));
                    $original_product = $this->initProduct($_item, $item_data['simple_sku']);
                    if ($original_product->getPreorder()!=1)
                    {
                        $haveregular=1;
                    } else {
                        $havepreorder = 1;
                    }
                }
                elseif($itemInOrderData['product_type']=='bundle')
                {
                    $alldownloadable=0;

                    if(Mage::helper('aitpreorder')->bundleHaveReg($_item)=='1')
                    {
                        $haveregular=1;
                    }

                }
                elseif(($itemInOrderData['product_type']=='virtual')&&($ispending==1)&&($noparent_item==1))
                {
                    $alldownloadable=0;
                    $haveregular=1;
                }
                elseif(($itemInOrderData['product_type']=='downloadable')&&($noparent_item==1))//&&($ispending==1))
                {
                    $_product = $this->initProduct($_item);
                    $preorder=$_product->getPreorder();
                    if($preorder!='1')
                    {
                        if($ispending==1)
                        {
                            $haveregular=1;
                        }
                    }
                    else
                    {
                        $havepreorder = 1;
                        $preorderdownloadable=1;
                    }
                }
                elseif(($itemInOrderData['product_type']=='simple')&&($noparent_item==1))
                {
                    $alldownloadable=0;
                    $_product = $this->initProduct($_item);
                    $preorder=$_product->getPreorder();
                    if($preorder!='1')
                    {
                        $haveregular=1;
                    } else {
                        $havepreorder = 1;
                    }
                }
            }
        }
        if($havepreorder && Mage::getStoreConfig('cataloginventory/aitpreorder/status_change') == 1) {
            $haveregular = 0;
        }
        if($ispending==0)
        {
            if(($alldownloadable==1)&&($preorderdownloadable==1))
            {
                $haveregular=-1;
            }
            elseif(($alldownloadable==1)&&($preorderdownloadable==0))
            {
                $haveregular=-2;
            }
        }
        return $haveregular;

    }

    public function isHavePreorder($order)
    {
        if ($order) {
            $_items = $order->getItemsCollection();
        } else {
            Mage::log('There is no order coming in Aitoc_Aitpreorder_Helper_Data::isHavePreorder() method');
            return $havepreorder = 0;
        }
        $haveregular=0;
        $noparent_item=0;
        $alldownloadable=1;
        $preorderdownloadable=0;
        $havepreorder=0;
        foreach($_items as $_item)
        {
            $itemInOrderData=$_item->getData();
            $noparent_item=0;
            if(!isset($itemInOrderData['parent_item_id']))
            {
                    $noparent_item=1;
            }

            if($itemInOrderData['product_type']=='grouped')
            {
                    $alldownloadable=0;
                    $_product = $this->initProduct($_item);
                    $preorder=$_product->getPreorder();
                    if($preorder!='1')
                    {
                        $haveregular=1;
                    }
                    else
                    {
                        $havepreorder=1;
                    }
            }
            elseif($itemInOrderData['product_type']=='configurable')
            {
                $alldownloadable=0;
                $item_data=unserialize($_item->getData('product_options'));
                $original_product = $this->initProduct($_item, $item_data['simple_sku']);
                if($original_product->getPreorder()!=1)
                {
                    $haveregular=1;
                }
                else
                {
                    $havepreorder=1;
                }
            }
            elseif($itemInOrderData['product_type']=='bundle')
            {
                $alldownloadable=0;
                if(Mage::helper('aitpreorder')->bundleHaveReg($_item)=='1')
                {
                    $haveregular=1;
                }
                else
                {
                    $havepreorder=1;
                }

            }
            elseif(($itemInOrderData['product_type']=='virtual')&&($noparent_item==1))
            {
                $alldownloadable=0;
                $haveregular=1;
            }
            elseif(($itemInOrderData['product_type']=='downloadable')&&($noparent_item==1))
            {
                $_product = $this->initProduct($_item);
                $preorder=$_product->getPreorder();
                if($preorder!='1')
                {
                    $haveregular=1;
                }
                else
                {
                    $preorderdownloadable=1;
                    $havepreorder=1;
                }
            }
            elseif(($itemInOrderData['product_type']=='simple')&&($noparent_item==1))
            {
                $alldownloadable=0;
                $_product = $this->initProduct($_item);
                $preorder=$_product->getPreorder();
                if($preorder!='1')
                {
                    $haveregular=1;
                }
                else
                {
                    $havepreorder=1;
                }
            }
        }

        return $havepreorder;

    }

    public function checkSynchronization($status,$statusPreorder)
    {
    	if(!$statusPreorder)
    	{
            return false;
    	}
    	if($status!=$statusPreorder)
    	{
            if(!(($statusPreorder=='pendingpreorder' && $status=='pending')
            || ($statusPreorder=='processingpreorder' && $status=='processing')))
            {
                return false;
            }
    	}
    	return true;
    }

    /**
     * Checks if Aitoc Multi-Location Inventory module is enabled
     *
     * @return boolean
     */
    public function checkIfMultilocationInventoryIsEnabled()
    {
        $aitocModulesList = Mage::getModel('aitsys/aitsys')->getAitocModuleList();

        if ($aitocModulesList)
        {
            foreach ($aitocModulesList as $aitocModule)
            {
                if ('Aitoc_Aitquantitymanager' == $aitocModule->getKey())
                {
                    return Mage::helper('core')->isModuleEnabled('Aitoc_Aitquantitymanager') && $aitocModule->getValue();
                }
            }
        }

        return false;
    }

    public function retrieveAppropriateVersionClass($modelName)
    {
        switch($modelName)
        {
            case 'mysql4_report_order':
                return $this->_retrieveAppropriateVersionClassSchema1($modelName);
                break;
            case 'mysql4_report_refunded':
            case 'mysql4_report_shipping':
            case 'mysql4_report_invoiced':
                return $this->_retrieveAppropriateVersionClassSchema2($modelName);
                break;
        }
    }

    protected function _retrieveAppropriateVersionClassSchema1($modelName)
    {
        if(version_compare(Mage::getVersion(), '1.5.0.0', '<'))
        {
            $modelName = 'aitpreorder/' . $modelName . '_1410';
            $model = Mage::getModel($modelName);
            return $model;
        }
        elseif(version_compare(Mage::getVersion(), '1.6.0.0', '<'))
        {
            $modelName = 'aitpreorder/' . $modelName . '_1500';
            $model = Mage::getModel($modelName);
            return $model;
        }
        elseif(version_compare(Mage::getVersion(), '1.6.1.0', '<'))
        {
            $modelName = 'aitpreorder/' . $modelName . '_1600';
            $model = Mage::getModel($modelName);
            return $model;
        }

        return false;
    }

    protected function _retrieveAppropriateVersionClassSchema2($modelName)
    {
        if(version_compare(Mage::getVersion(), '1.4.1.0', '<'))
        {
            $modelName = 'aitpreorder/' . $modelName . '_1400';
            $model = Mage::getModel($modelName);
            return $model;
        }
        elseif(version_compare(Mage::getVersion(), '1.6.0.0', '<'))
        {
            $modelName = 'aitpreorder/' . $modelName . '_1410';
            $model = Mage::getModel($modelName);
            return $model;
        }
        $modelName = 'aitpreorder/' . $modelName . '_1600';
        $model = Mage::getModel($modelName);
        return $model;
    }

    public function isAvailableForDownload($item)
    {
        $sku = $item->getData('sku');

        $product = Mage::getModel('catalog/product');
        $product_id = $product->getIdBySku($sku);
        $product->load($product_id);

        if (($product->getPreorder() == 1) &&
            ($product->getData('type_id') == 'downloadable'))
        {
            return false;
        }
        return true;
    }

    public function getPatternInputSubmitShipping()
    {
        if (version_compare(Mage::getVersion(), '1.8.1.0', '<'))
        {
            return 'type="text" class="input-text" ';
        }
        else
        {
            return 'type="text" class="input-text qty-item" ';
        }
    }

    public function isMixedCartAllowed()
    {
        return !(bool)Mage::getStoreConfig('cataloginventory/aitpreorder/deny_mixing_products');
    }

    public function isBackstockPreorderAllowed($product)
    {
        $backstock = false;

        if(!is_object($product)) {
            if(isset($this->_productBackstockCache[$product])) {
                $product = $this->_productBackstockCache[$product];
            } else {
                $product = Mage::getModel('catalog/product')->load($product);
            }
        }

        if (is_null($product->getBackstockPreorders())) {
            $isPreorder = $product
                ->getResource()
                ->getAttributeRawValue(
                    $product->getId(),
                    'backstock_preorders',
                    Mage::app()->getStore()
                );
            $product->setData('backstock_preorders', (bool) $isPreorder);
        }

        if($product->getBackstockPreorders() == 0) {
            $backstock = (bool)Mage::getStoreConfig('cataloginventory/aitpreorder/backstock_preorders');
        } elseif ($product->getBackstockPreorders() == 1) {
            $backstock = true;
        }
        if(!isset($this->_productBackstockCache[$product->getId()])) {
            $this->_productBackstockCache[$product->getId()] = $product;
        }
        if(!$backstock) {
            return false;
        }
        //backstock allowed for this product, validate if product is pre-order and out-of-stock
        $item = $product->getStockItem();
        $out_of_stock = !$item->getData('is_in_stock');

        Mage::getSingleton('aitpreorder/stockloader')->applyStockToProduct($product);
        if($product->getPreorder() && $out_of_stock && $this->_allowToReplaceStock()) {
            return true;
        }
        return false;
    }

    /**
     * Validate if current page is backend and if it load product for edit - then our validation should fail
     *
     * @return bool
     */
    private function _allowToReplaceStock()
    {
        if(is_null($this->_validController)) {
            $this->_validController = true;

            $request = Mage::app()->getRequest();
            $module = $request->getModuleName();
            $controller = $request->getControllerName();
            $notAllowedModules = array('admin');
            $notAllowedControllers = array('catalog_product');

            if(in_array($module, $notAllowedModules) && in_array($controller, $notAllowedControllers)) {
                $this->_validController = false;
            }
        }
        return $this->_validController;
    }

    public function isPreOrder($item)
    {
        if (!isset($item)) {
            $confValue = Mage::getStoreConfig('cataloginventory/item_options/backorders');
            $qty = 0;
            $minQty = 0;
            return false;
        } else {
            $confValue = $item->getBackorders();
            $qty = $item->getQty();
            $minQty =  $item->getMinQty();
        }

        return (Aitoc_Aitpreorder_Model_Rewrite_SourceBackorders::BACKORDERS_YES_PREORDERS == $confValue)
            || (Aitoc_Aitpreorder_Model_Rewrite_SourceBackorders::BACKORDERS_YES_PREORDERS_ZERO == $confValue
                && $qty <= $minQty
                && $item->getTypeId() != Mage_Catalog_Model_Product_Type::TYPE_BUNDLE
                && $item->getTypeId() != Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE
                && $item->getTypeId() != Mage_Catalog_Model_Product_Type::TYPE_GROUPED);
    }
}
