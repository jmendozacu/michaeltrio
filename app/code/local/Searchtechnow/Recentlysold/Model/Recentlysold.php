<?php
class Searchtechnow_Recentlysold_Model_Recentlysold extends Mage_Core_Model_Abstract {
  public function getRecentlysoldProducts()
  {
        $storeID = Mage::app()->getStore()->getId();
		$itemsCollection = Mage::getResourceModel('sales/order_item_collection')
		->join('order', 'order_id=entity_id')
		->addFieldToFilter('main_table.store_id', array('eq'=>$storeID))
		->setOrder('main_table.created_at','desc')
		->setPageSize(20);
		$itemsCollection->getSelect()->group(`main_table`.'product_id')->limit(20);
		$products = array();
		if(sizeof($itemsCollection)>0)
		{
		foreach ($itemsCollection as $item) {
		$product = Mage::getModel('catalog/product')
		->setStoreId(Mage::app()->getStore()->getId())
		->load($item->getProductId());
			if($product->getId()){
				$products[] = $product;
				//echo '<br><br>'.$product->getId();
			}
		}
		}
		//die;
		return $products;
  }
  public function getRecentlysoldMenuProducts()
  {
        $storeID = Mage::app()->getStore()->getId();
		$itemsCollection = Mage::getResourceModel('sales/order_item_collection')
		->join('order', 'order_id=entity_id')
		->addFieldToFilter('main_table.store_id', array('eq'=>$storeID))
		->setOrder('main_table.created_at','desc')
		->setPageSize(5);
		$itemsCollection->getSelect()->group(`main_table`.'product_id')->limit(5);
		$products = array();
		if(sizeof($itemsCollection)>0)
		{
		foreach ($itemsCollection as $item) {
		$product = Mage::getModel('catalog/product')
		->setStoreId(Mage::app()->getStore()->getId())
		->load($item->getProductId());
			if($product->getId()){
				$products[] = $product;
				//echo '<br><br>'.$product->getId();
			}
		}
		}
		//die;
		return $products;
  }
  public function imgResizeCustm($w,$h,$url){
		$media_dir = Mage::getBaseDir('media').DS.'wysiwyg'.DS.'icotheme'.DS.'diamonds_pics'.DS;
		$cache_dir = $media_dir.'cache'.DS;
		$cache_url = Mage::getUrl('media').'wysiwyg'.DS.'icotheme'.DS.'diamonds_pics'.DS.'cache'.DS;
		$image = new Varien_Image($media_dir.$url);
		$image->constrainOnly(true);
		$image->keepAspectRatio(true);
		$image->keepFrame(true);
		$image->keepTransparency(false);
		$image->backgroundColor(array(255,255,255));
		$image->resize($w,$h);
		$image->save($cache_dir.$w.$url);
		$url = $cache_url.$w.$url; //die;
		return $url;
	}
}