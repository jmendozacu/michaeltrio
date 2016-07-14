<?php

class Searchtechnow_Recentlypurchased_Block_Recentlypurchased extends Mage_Customer_Block_Account_Dashboard {

    
    public function __construct() {
        parent::__construct();

        $collection = Mage::getModel('recentlypurchased/recentlypurchased')->getCollection()
                ->addFieldToFilter('status', '1')
                ;
//        $collection->setPageSize(5);
//        $collection->setCurPage(2);
//        $size = $collection->getSize();
//        $cnt = count($collection);
//        foreach ($collection as $item) {
//            $i = $i + 1;
//            $item->setTitle($i);
//            echo $item->getTitle();
//        }
        
//        $collection = Mage::getModel('recentlypurchased/recentlypurchased')->getCollection()
//                ->addAttributeToSelect('*')
//                ->addFieldToFilter('status', array('like' => '1'))
//                ->setOrder('update_time', 'AESC');

        $this->setCollection($collection);
    }
	
	public function getRecentlypurchasedmenuProducts()
	{
		$collection = Mage::getModel('recentlypurchased/recentlypurchased')->getCollection()
		->addFieldToFilter('status', '1')
		->setPageSize(5);
		return $collection;
	}
	
	public function getRecentlypurchasedProducts()
	{
		$collection = Mage::getModel('recentlypurchased/recentlypurchased')->getCollection()
		->addFieldToFilter('status', '1');
		return $collection;
	}

}
