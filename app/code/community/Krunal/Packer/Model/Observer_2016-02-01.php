<?php
class Krunal_Packer_Model_Observer {

    public function track($observer) {

		if (Mage::registry('current_category') && !Mage::registry('current_product') && Mage::getDesign()->getArea() != 'adminhtml') {
			$_CurrCat = Mage::registry('current_category')->getId();
			if($_CurrCat == 3) {
				$layout = $observer->getAction()->getLayout();
				$product_info = $layout->getBlock('product_list');

				$step = Mage::getSingleton('core/session')->getDiamondStep();

				if (!$step || $step == '1') {
					$product_info->setTemplate('packer/choose-diamond.phtml');
				} else if ($step == '2') {
					$product_info->setTemplate('packer/choose-diamond-step2.phtml');
				}

				$toolbar =  $observer->getAction()->getLayout()->getBlock('product_list_toolbar');
				if($toolbar) {
					$listMode = $toolbar->getCurrentMode();
					$toolbar = $toolbar->addPagerLimit($listMode , 100);
				}
			}
		}
    }
	
	public function block($observer) {
		
	}
	
	public function fullBreadcrumbCategoryPath(Varien_Event_Observer $observer) {
        $current_product = Mage::registry('current_product');

        if( $current_product ) {
            $categories = $current_product->getCategoryCollection()->addAttributeToSelect('name')->setPageSize(1);
            foreach( $categories as $category ) {
                Mage::unregister('current_category');
                Mage::register('current_category', $category);
            }
        }
    }
}