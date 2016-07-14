<?php

class Krunal_Packer_Model_Observer {

    public function track($observer) {

        if (Mage::registry('current_category') && !Mage::registry('current_product') && Mage::getDesign()->getArea() != 'adminhtml') {
            $_CurrCat = Mage::registry('current_category')->getId();

            if ($_CurrCat == 3) {
                $layout = $observer->getAction()->getLayout();
                $product_info = $layout->getBlock('product_list');

                $step = Mage::getSingleton('core/session')->getDiamondStep();

               // if (!$step || $step == '1') {
                    $product_info->setTemplate('packer/choose-diamond.phtml');
                /*} else if ($step == '2') {
                    $product_info->setTemplate('packer/choose-diamond-step2.phtml');
                }*/

                $toolbar = $observer->getAction()->getLayout()->getBlock('product_list_toolbar');
                if ($toolbar) {
                    $listMode = $toolbar->getCurrentMode();
                    $toolbar = $toolbar->addPagerLimit($listMode, 100);
                }
            } elseif ($_CurrCat == 4) {

                $layout = $observer->getAction()->getLayout();
                $product_info = $layout->getBlock('product_list');

                $step = Mage::getSingleton('core/session')->getDiamondStep();

                $product_info->setTemplate('packer/choose-diamond-step2.phtml');

                $toolbar = $observer->getAction()->getLayout()->getBlock('product_list_toolbar');
                if ($toolbar) {
                    $listMode = $toolbar->getCurrentMode();
                    $toolbar = $toolbar->addPagerLimit($listMode, 100);
                }
            }
			 elseif ($_CurrCat == 5) {
                $layout = $observer->getAction()->getLayout();
                $product_info = $layout->getBlock('product_list');

                $step = Mage::getSingleton('core/session')->getWeddingStep();

                if ($_GET['weddingstyle'] != '') {
                    $weddingstyle = $_GET['weddingstyle'];
                } else {
                    $weddingstyle = Mage::getSingleton('core/session')->getWeddingStyle();
                }
                if ($_GET['maincat'] != '') {
                    $weddingmaincat = $_GET['maincat'];
                } else {
                    $weddingmaincat = Mage::getSingleton('core/session')->getWeddingMaincat();
                }
                
                if ($weddingmaincat == 'men') {
                    $product_info->setTemplate('packer/choose-ring-wedding.phtml');
                } else if ($weddingmaincat == 'women') {
                    $product_info->setTemplate('packer/choose-ring-wedding.phtml');
                } else if ($weddingmaincat == 'couple') {
                    $product_info->setTemplate('packer/choose-ring-wedding-couple.phtml');
                }

                $toolbar = $observer->getAction()->getLayout()->getBlock('product_list_toolbar');
                if ($toolbar) {
                    $listMode = $toolbar->getCurrentMode();
                    $toolbar = $toolbar->addPagerLimit($listMode, 100);
                }
            }
			elseif ($_CurrCat == 6 || $_CurrCat == 29 || $_CurrCat == 27) {
                $layout = $observer->getAction()->getLayout();
                $product_info = $layout->getBlock('product_list');
                $step = Mage::getSingleton('core/session')->getJewellerygiftStep();
				if ($_GET['styletype'] != '') {
						$jewellerygiftsale = $_GET['styletype'];
					} else {
						$jewellerygiftsale=Mage::getSingleton('core/session')->getJewellerygiftStyletype();
					}
				
                /*echo $_CurrCat;
				echo $jewellerygiftsale.'<br>';
				exit; */ 
				$maincat='';
				switch ($_CurrCat) {
					case '29':
					$selectedJewellerygiftMaincat = Mage::getSingleton('core/session')->getJewellerygiftMaincat();
					$selectedJewellerygiftStyle = Mage::getSingleton('core/session')->getJewellerygiftStyle();
					
					if ($_GET['maincat'] != '') {
						$maincat = $_GET['maincat'];
					} else {
						$maincat = $selectedJewellerygiftMaincat;
					}
					if($maincat=='' || $maincat!='bracelet')
					{
					Mage::getSingleton('core/session')->setJewellerygiftMaincat('bracelet');
					Mage::getSingleton('core/session')->setJewellerygiftStyle('diamond');
					}
					break;
					case '27':
					$selectedJewellerygiftMaincat = Mage::getSingleton('core/session')->getJewellerygiftMaincat();
					$selectedJewellerygiftStyle = Mage::getSingleton('core/session')->getJewellerygiftStyle();
					
					if ($_GET['maincat'] != '') {
						$maincat = $_GET['maincat'];
					} else {
						$maincat = $selectedJewellerygiftMaincat;
					}
					if($maincat=='' || $maincat!='necklace')
					{
					Mage::getSingleton('core/session')->setJewellerygiftMaincat('necklace');
					Mage::getSingleton('core/session')->setJewellerygiftStyle('diamond');
					}
					break;
				}  
				
				if ($_GET['styletype'] != '') {
						$product_info->setTemplate('packer/choose-ring-jewellerygift-sale.phtml');
					} 
				else {
					if ($_GET['style'] != '') {
						$style = $_GET['style'];
					} else {
						$style = Mage::getSingleton('core/session')->getJewellerygiftStyle();
					}
					if ($_GET['maincat'] != '') {
						$jewellerygiftmaincat = $_GET['maincat'];
					} 
					else {
						/*if ($jewellerygiftmaincat == '' && $_CurrCat == 27) {
							Mage::getSingleton('core/session')->unsJewellerygiftMaincat();
							Mage::getSingleton('core/session')->unsJewellerygiftStyle();
							Mage::getSingleton('core/session')->setJewellerygiftMaincat('necklace');
							Mage::getSingleton('core/session')->setJewellerygiftStyle('diamond');
						}
						elseif ($jewellerygiftmaincat == '' && $_CurrCat == 29) {
							Mage::getSingleton('core/session')->unsJewellerygiftMaincat();
							Mage::getSingleton('core/session')->unsJewellerygiftStyle();
							Mage::getSingleton('core/session')->setJewellerygiftMaincat('bracelet');
							Mage::getSingleton('core/session')->setJewellerygiftStyle('diamond');
						}
						else
						{*/
							$jewellerygiftmaincat = Mage::getSingleton('core/session')->getJewellerygiftMaincat();
						/*}*/
					}	
					
					if($style=='luxury' || $style=='gift-under-$150')
					{
					$product_info->setTemplate('packer/choose-ring-jewellerygift-luxury-under-150.phtml');
					}
					else
					{								   
					$product_info->setTemplate('packer/choose-ring-jewellerygift.phtml');
					}
				}
                $toolbar = $observer->getAction()->getLayout()->getBlock('product_list_toolbar');
                if ($toolbar) {
                    $listMode = $toolbar->getCurrentMode();
                    $toolbar = $toolbar->addPagerLimit($listMode, 100);
                }
            }
			elseif ($_CurrCat == 105) {
				$layout = $observer->getAction()->getLayout();
                $product_info = $layout->getBlock('product_list');
                $step = Mage::getSingleton('core/session')->getJewellerygiftStep();
				$product_info->setTemplate('packer/choose-ring-jewellerygift-sale.phtml');
				$toolbar = $observer->getAction()->getLayout()->getBlock('product_list_toolbar');
                if ($toolbar) {
                    $listMode = $toolbar->getCurrentMode();
                    $toolbar = $toolbar->addPagerLimit($listMode, 100);
                }
			}
			elseif ($_CurrCat == 118) {
				$layout = $observer->getAction()->getLayout();
                $product_info = $layout->getBlock('product_list');
                $step = Mage::getSingleton('core/session')->getFancydiamondStep();
				$product_info->setTemplate('packer/choose-fancy-diamond.phtml');
				$toolbar = $observer->getAction()->getLayout()->getBlock('product_list_toolbar');
                if ($toolbar) {
                    $listMode = $toolbar->getCurrentMode();
                    $toolbar = $toolbar->addPagerLimit($listMode, 100);
                }
			}
        }
    }

    public function block($observer) {
        
    }

    public function fullBreadcrumbCategoryPath(Varien_Event_Observer $observer) {
        $current_product = Mage::registry('current_product');

        if ($current_product) {
            $categories = $current_product->getCategoryCollection()->addAttributeToSelect('name')->setPageSize(1);
            foreach ($categories as $category) {
                Mage::unregister('current_category');
                Mage::register('current_category', $category);
            }
        }
    }

}
