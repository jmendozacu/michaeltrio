<?php

class Searchtechnow_Productimport_Adminhtml_Productimport_CustomringController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        $this->_title($this->__('Product Custom Options'));
        $this->loadLayout();
        $this->_initLayoutMessages('adminhtml/session');
        $this->_setActiveMenu('searchtechnow_productimport');
        $this->renderLayout();
    }

    public function addcustomAction() {
        $alloptions = array(
            array('title' => 'Color', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '0',
                'values' => array(
                    array('title' => 'Bronze', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Gold', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'), array('title' => 'Silver', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2')))
            , array('title' => 'Metals', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '1',
                'values' => array(
                    array('title' => '18k', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Platinum', 'price' => '300.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1')
                ))
            , array('title' => 'Engraving', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '2',
                'values' => array(
                    array('title' => 'Yes', 'price' => '40.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'No', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1')
                ))
            , array('title' => 'Ring size', 'type' => 'drop_down', 'is_require' => 1, 'sort_order' => '3',
                'values' => array(
                    array('title' => '3', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'),
                    array('title' => '4', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'),
                    array('title' => '5', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2'),
                    array('title' => '6', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '3'),
                    array('title' => '7', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '4'),
                    array('title' => '8', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '5'),
                    array('title' => '9', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '6'),
                    array('title' => '10', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '7'),
                    array('title' => '11', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '8'),
                    array('title' => '12', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '9'),
                    array('title' => '13', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '10'),
                    array('title' => '14', 'price' => '93.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '11'),
                    array('title' => '15', 'price' => '93.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '12'),
                    array('title' => '16', 'price' => '187.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '13'),
                    array('title' => '17', 'price' => '187.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '14'),
                    array('title' => '18', 'price' => '280.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '15'),
                    array('title' => '14', 'price' => '37.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '16'),
                    array('title' => '15', 'price' => '37.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '17'),
                    array('title' => '16', 'price' => '75.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '18'),
                    array('title' => '17', 'price' => '75.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '19'),
                    array('title' => '18', 'price' => '112.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '20')
                ))
        );

        $womenalloptions = array(
            array('title' => 'Color', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '0',
                'values' => array(
                    array('title' => 'Bronze', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Gold', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'), array('title' => 'Silver', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2')))
            , array('title' => 'Metals', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '1',
                'values' => array(
                    array('title' => '18k', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Platinum', 'price' => '300.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1')
                ))
            , array('title' => 'Engraving', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '2',
                'values' => array(
                    array('title' => 'Yes', 'price' => '40.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'No', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1')
                ))
            , array('title' => 'Ring size', 'type' => 'drop_down', 'is_require' => 1, 'sort_order' => '3',
                'values' => array(
                    array('title' => '3', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'),
                    array('title' => '4', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'),
                    array('title' => '5', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2'),
                    array('title' => '6', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '3'),
                    array('title' => '7', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '4'),
                    array('title' => '8', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '5'),
                    array('title' => '9', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '6'),
                    array('title' => '10', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '7'),
                    array('title' => '11', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '8'),
                    array('title' => '12', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '9'),
                    array('title' => '13', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '10'),
                    array('title' => '14', 'price' => '93.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '11'),
                    array('title' => '15', 'price' => '93.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '12'),
                    array('title' => '16', 'price' => '187.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '13'),
                    array('title' => '17', 'price' => '187.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '14'),
                    array('title' => '18', 'price' => '280.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '15'),
                    array('title' => '14', 'price' => '37.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '16'),
                    array('title' => '15', 'price' => '37.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '17'),
                    array('title' => '16', 'price' => '75.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '18'),
                    array('title' => '17', 'price' => '75.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '19'),
                    array('title' => '18', 'price' => '112.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '20')
                ))
        );

        $menalloptions = array(
            array('title' => 'Color', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '0',
                'values' => array(
                    array('title' => 'Bronze', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Gold', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'), array('title' => 'Silver', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2')))
            , array('title' => 'Metals', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '1',
                'values' => array(
                    array('title' => '18k', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Platinum', 'price' => '300.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1')
                ))
            , array('title' => 'Engraving', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '2',
                'values' => array(
                    array('title' => 'Yes', 'price' => '40.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'No', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1')
                ))
            , array('title' => 'Ring size', 'type' => 'drop_down', 'is_require' => 1, 'sort_order' => '3',
                'values' => array(
                    array('title' => '3', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'),
                    array('title' => '4', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'),
                    array('title' => '5', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2'),
                    array('title' => '6', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '3'),
                    array('title' => '7', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '4'),
                    array('title' => '8', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '5'),
                    array('title' => '9', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '6'),
                    array('title' => '10', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '7'),
                    array('title' => '11', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '8'),
                    array('title' => '12', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '9'),
                    array('title' => '13', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '10'),
                    array('title' => '14', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '11'),
                    array('title' => '15', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '12'),
                    array('title' => '16', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '13'),
                    array('title' => '17', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '14'),
                    array('title' => '18', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '15'),
                    array('title' => '19', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '16'),
                    array('title' => '20', 'price' => '140.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '17'),
                    array('title' => '21', 'price' => '140.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '18'),
                    array('title' => '22', 'price' => '280.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '19'),
                    array('title' => '23', 'price' => '280.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '20'),
                    array('title' => '24', 'price' => '420.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '21'),
                    array('title' => '20', 'price' => '56.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '22'),
                    array('title' => '21', 'price' => '56.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '23'),
                    array('title' => '22', 'price' => '112.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '24'),
                    array('title' => '23', 'price' => '112.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '25'),
                    array('title' => '24', 'price' => '168.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '26')
                ))
        );
		
		        $allstudoptions = array(
                
				array('title' => 'Carat', 'type' => 'drop_down', 'is_require' => 1, 'sort_order' => '0',
                'values' => array(
                    array('title' => '1/4ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'),
                    array('title' => '1/3ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'),
                    array('title' => '1/2ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2'),
                    array('title' => '3/4ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '3'),
                    array('title' => '1ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '4'),
                    array('title' => '1 1/2ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '5'),
                    array('title' => '2ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '6'),
                    array('title' => '3ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '7'),
                    array('title' => '4ct', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '8')                    
                ))
        );
		
        if ($this->getRequest()->getPost()) {
            if ($_POST['category'] != '') {

                $category_id = $_POST['category'];
                $category = Mage::getModel('catalog/category')->load($category_id);
                $products = Mage::getResourceModel('catalog/product_collection')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->addCategoryFilter($category);
                $totalprothatcat = $products->count();

                //$products->setPageSize(50);
                Mage::register("isSecureArea", 1);
                foreach ($products as $product) {
                    $products = Mage::getModel('catalog/product')->load($product->getId());
                    $hasOptions = $products->getOptions();
                    switch ($category_id) {
                        case '4':
                            $importalloptions = $alloptions;
                            $msg='Custom Options of Engagement Rings added in Engagement Rings.';
                            break;
                        case '88':
                            $importalloptions = $womenalloptions;
                            $msg='Custom Options of Women Rings added in Engagement Rings.';
                            break;
                        case '94':
                            $importalloptions = $menalloptions;
                            $msg='Custom Options of Men Rings added in Engagement Rings.';
                            break;
						case '34':
                            $importalloptions = $allstudoptions;
                            $msg='Custom Options of Men Rings added in Engagement Rings.';
                            break;
                    }
					$EarringsTypes = explode(",", $products->getEarringsTypes());
					
					if (in_array('137', $EarringsTypes)) {
					//echo implode(",", $EarringsTypes).'<br>';
					//echo $products->getId() . '_' . count($hasOptions) . '<br>';
					if (count($hasOptions) == '0') {
                        //echo $products->getId() . '_not_' . count($hasOptions) . '<br>';
                        if(!empty($importalloptions))
                        {
                        Mage::getSingleton('catalog/product_option')->unsetOptions();
                        $products->setProductOptions($importalloptions);
                        $products->setCanSaveCustomOptions(true);
                        $products->save();
                        }
                    }
					}
					else
					{
					
                    if (count($hasOptions) == '0') {
                        //echo $products->getId() . '_not_' . count($hasOptions) . '<br>';
                        if(!empty($importalloptions))
                        {
                        Mage::getSingleton('catalog/product_option')->unsetOptions();
                        $products->setProductOptions($importalloptions);
                        $products->setCanSaveCustomOptions(true);
                        $products->save();
                        }
                    } else {
                        //echo $products->getId() . '_' . count($hasOptions) . '<br>';
                    }
					}
                }
                //exit;
                Mage::getSingleton('core/session')->addSuccess($msg);
                $this->_redirect('adminhtml/productimport_customring');
            } else {
                Mage::getSingleton('core/session')->addError('Please Select Category !!');
                $this->_redirect('adminhtml/productimport_customring');
            }
        } else {
            $this->_redirect('adminhtml/productimport_customring');
        }
    }

}
