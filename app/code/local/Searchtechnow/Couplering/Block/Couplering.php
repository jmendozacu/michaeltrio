<?php

class Searchtechnow_Couplering_Block_Couplering extends Mage_Customer_Block_Account_Dashboard {

    
    public function __construct() {
        parent::__construct();

        $collection = Mage::getModel('couplering/couplering')->getCollection()
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
        
//        $collection = Mage::getModel('couplering/couplering')->getCollection()
//                ->addAttributeToSelect('*')
//                ->addFieldToFilter('status', array('like' => '1'))
//                ->setOrder('update_time', 'AESC');

        $this->setCollection($collection);
    }
	
	public function getCoupleringmenuProducts()
	{
		$collection = Mage::getModel('couplering/couplering')->getCollection()
		->addFieldToFilter('status', '1')
		->setPageSize(5);
		return $collection;
	}
	
	public function getCoupleringProducts()
	{
		$collection = Mage::getModel('couplering/couplering')->getCollection()
		->addFieldToFilter('status', '1');
		return $collection;
	}

}
