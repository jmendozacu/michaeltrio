<?php

class Searchtechnow_Stnpromotion_Block_Stnpromotion extends Mage_Customer_Block_Account_Dashboard {

    
    public function __construct() {
        parent::__construct();

//        $collection = Mage::getModel('stnpromotion/stnpromotion')->getCollection()
//                ->addFieldToFilter('status', '1')
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
        
//        $collection = Mage::getModel('stnpromotion/stnpromotion')->getCollection()
//                ->addAttributeToSelect('*')
//                ->addFieldToFilter('status', array('like' => '1'))
//                ->setOrder('update_time', 'AESC');

        $collection = Mage::getModel('stnpromotion/stnpromotion')->getCollection()
        ->addAttributeToSelect('*')
        ->addFieldToFilter('status', array('like' => '1'))
        ->setOrder('short_order', 'ASC');
echo "<pre>";
print_r($collection);
        $this->setCollection($collection);
    }
	
	public function getStnpromotionmenuProducts()
	{
		$collection = Mage::getModel('stnpromotion/stnpromotion')->getCollection()
		->addFieldToFilter('status', '1')
		->setPageSize(5);
		return $collection;
	}
	
	public function getStnpromotionProducts()
	{
		$collection = Mage::getModel('stnpromotion/stnpromotion')->getCollection()
		->addFieldToFilter('status', '1');
		return $collection;
	}

}
