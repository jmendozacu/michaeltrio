<?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_BundleAdminhtmlSalesOrderItemsRenderer extends Mage_Bundle_Block_Adminhtml_Sales_Order_Items_Renderer
{
    public function getValueHtml($item)
    {
        $product = Mage::getModel('catalog/product');
        
//	$product->setStoreId($item->getOrder()->getStoreId());
        /*
         * * Aitoc fix for bug 'unable to ship or invoice bundle product'
         */
        $product->setStoreId($item->getStoreId());
        
	$product->load($item->getData('product_id'));
		
        return parent::getValueHtml($item) . ($product->getPreorder() ? "<input type=hidden class='bundlepreorder' />" : '');
    }

 
    protected function _toHtml()
    {
        $html = parent::_toHtml();
        $_item = $this->getItem();
        if ($this->isShipmentSeparately($_item))
        {
            $orderItem = $_item->getOrderItem();
            $childrenItems = $orderItem->getChildrenItems();
            $havePreorderInBundle = 0; 
            foreach ($childrenItems as $childrenItem)
            {
                $original_product = Mage::helper('aitpreorder')->initProduct($childrenItem);
                if($original_product->getPreorder()==1)
                {
                    $havePreorderInBundle=1; 
                }    
            }
            if ($havePreorderInBundle)
            {
                $pattern = '/<input type="text" class="input-text" name="shipment\[(.*)\]\[(.*)\]" value="(.*)" \/>/';
                $matches = array();
                if (preg_match($pattern, $html, $matches))
                {
                    $txt = '<input type="hidden" class="input-text" name="shipment[items]['.$matches[2].']" value="0" /><div style="text-align:center;">'.$this->__('This product is Pre-Order and cannot be shipped').'</div>';
                    $html = str_replace($matches[0],$txt,$html);
                }

            }
        }
        return $html;
    }

}