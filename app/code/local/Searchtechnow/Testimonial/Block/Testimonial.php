<?php

class Searchtechnow_Testimonial_Block_Testimonial extends Mage_Customer_Block_Account_Dashboard {

    
    public function __construct() {
        parent::__construct();

        $collection = Mage::getModel('testimonial/testimonial')->getCollection()
                ->addFieldToFilter('status', '1');
//        $collection->setPageSize(5);
//        $collection->setCurPage(2);
//        $size = $collection->getSize();
//        $cnt = count($collection);
//        foreach ($collection as $item) {
//            $i = $i + 1;
//            $item->setTitle($i);
//            echo $item->getTitle();
//        }
        


        $this->setCollection($collection);
    }
	
	public function getTestimonialmenuProducts()
	{
		$collection = Mage::getModel('testimonial/testimonial')->getCollection()
		->addFieldToFilter('status', '1')
		->setOrder('date_of_testimonial', 'DESC')->setPageSize(5);
		
		return $collection;
	}
	
	public function getTestimonialProducts()
	{
		$collection = Mage::getModel('testimonial/testimonial')->getCollection()
		->addFieldToFilter('status', '1')
		->setOrder('date_of_testimonial', 'DESC')->setPageSize(5);;
		return $collection;
	}

}
