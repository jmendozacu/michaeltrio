<?php

class Trd_Diamond_AjaxController extends Mage_Core_Controller_Front_Action
{

    /**
     * List of params for this method:
     * page - current page for view
     * shape - shape array with values
     * price_from - start price
     * price_to - end price
     * carat_from - carat start value
     * carat_to - carat end value
     * cut_from - cut start value
     * cut_to - cut end value
     * color_from - color start val
     * color_to - color end val
     * clarity_from - clarity start val
     * clarity_to - clarity end val
     * polish_from - polish start val
     * polish_to - polish end val
     * symmetry_from - symmetry start val
     * symmetry_to - symmetry end val
     * fluorescence_from - fluorefiscence start val
     * fluorescence_to  - fluorescence end val
     * depth_from - depth start val
     * depth_to - depth end val
     * table_from - table start val
     * table_to - table end val
     * sort - ASC/DESC values
     * sort_field - column name
     */

    public function filterAction()
    {
        
        if ($data = $this->getRequest()->getParams()) {   // Turn this one ON for GET request
            $page = 1;

            $preparedArr = array();

            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->setCurPage($page)
				->addAttributeToSelect('*')
                ->setPageSize(100);

            if ($data['price_from'] && $data['price_to']) {
                $collection->addFieldToFilter('price', array(
                    'from' => $data['price_from'],
                    'to' => $data['price_to'],
                ));
            }
            if ($data['carat_from'] && $data['carat_to']) {
                $collection->addFieldToFilter('diamond_carat', array(
                    'from' => $data['carat_from'],
                    'to' => $data['carat_to'],
                ));
            }
            if ($data['depth_from'] && $data['depth_to']) {
                $collection->addFieldToFilter('diamond_depth', array(
                    'from' => $data['depth_from'],
                    'to' => $data['depth_to'],
                ));
            }
            if ($data['table_from'] && $data['table_to']) {
                $collection->addFieldToFilter('diamond_table', array(
                    'from' => $data['table_from'],
                    'to' => $data['table_to'],
                ));
            }

            // if ($data['shape']) {
            $collection->addFieldToFilter('diamond_shape', array('in' => $data['shape']));
            // }

            if ($data['cut']) {
                $collection->addFieldToFilter('diamond_cut', array('in' => $data['cut']));
            }

            if ($data['color']) {
                $collection->addFieldToFilter('diamond_color', array('in' => $data['color']));
            }

            if ($data['clarity']) {
                $collection->addFieldToFilter('diamond_clarity', array('in' => $data['clarity']));
            }

            if ($data['polish']) {
                $collection->addFieldToFilter('diamond_polish', array('in' => $data['polish']));
            }

            if ($data['symmetry']) {
                $collection->addFieldToFilter('diamond_symmetry', array('in' => $data['symmetry']));
            }

            if ($data['fluorescence']) {
                $collection->addFieldToFilter('diamond_fluorescence', array('in' => $data['fluorescence']));
            }

            if ($data['sort'] && $data['sort_field']) {
                if ($data['sort_field'] == 'diamond_shape' || $data['sort_field'] == 'diamond_carat' || $data['sort_field'] == 'diamonds_price') {
                    $collection->setOrder($data['sort_field'], $data['sort']);
                } else {
                    $orderString = $this->_getCustomOrderString($data['sort_field'], $data['sort']);
                    $collection->getSelect()->order(new Zend_Db_Expr($orderString));
                }
            }
			 foreach ($collection as $model) {
				 array_push($preparedArr, $model->getData());
			 }
			// print_r($preparedArr);die;
            /*$_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();

            foreach ($collection as $model) {
                if ($_currentCurrencyCode == 'SGD') {
				
                    array_push($preparedArr, $model->getData());
					
                } else if ($_currentCurrencyCode == 'USD') {
				
                    $data = $model->getData();
					
                    $data['diamonds_price'] = number_format(Mage::helper('directory')->currencyConvert($data['diamonds_price'], 'SGD', 'USD'), 2, '.', '');
					
                    array_push($preparedArr, $data);
                }
            }
*/
            $pages = $collection->getLastPageNumber();
			$currencySymbol =Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();	
            echo json_encode(array('data' => $preparedArr, 'pages' => $pages, 'count' => $collection->getSize(),'currencySymbol'=>$currencySymbol));


        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }

    /**
     *  List of params for this method:
     * price_from - start price
     * price_to - end price
     * style - style value
     * shape - shape value
     * page - current page for view
     *
     */

/*    public function filterringAction()
    {
        if ($data = $this->getRequest()->getParams()) {

          /*  $attrSetName = 'ring';
            $attributeSetId = Mage::getModel('eav/entity_attribute_set')
                ->load($attrSetName, 'attribute_set_name')
                ->getAttributeSetId();*/

            $page = 1;
			

            if ($data['page']) {
                $page = (int) $data['page'];
            }



    $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();

//    $attrSetName = 'ring';
  	/*$attributeSetId = Mage::getModel('eav/entity_attribute_set')->load($attrSetName, 'attribute_set_name')->getAttributeSetId();*/
  
	$typeYes = array('asscher'=>97, 'cushion'=>99,'emerald'=>101, 'heart'=>103,  'marquise'=>105,'oval'=>107,'pear'=>109,'princess'=>111,'radiant'=>113,'round'=>115);
//	$attributeId = array(195=>'asscher', 196=>'cushion',197 =>'emerald', 198=>'heart',  199=>'marquise',200=>'oval',201=>'pear',202=>'princess',203=>'radiant',204=>'round');

	$attributeId = array('asscher'=>195, 'cushion'=>196,'emerald'=>197, 'heart'=>198,  'marquise'=>199,'oval'=>200,'pear'=>201,'princess'=>202,'radiant'=>203,'round'=>204);	
	//echo Mage::app()->getStore()->getDefaultCurrencyCode();
//	echo "<br>";
//echo 	Mage::app()->getStore()->getCurrentCurrencyCode();die;
$dataSettingValues = array('Channel set'=>119,'Halo'=>122,'Pave'=>118,'Side stone'=>120,'Solitare'=>117,'Vintage'=>121);
  
		$tempStyleArray = array();
		foreach($data['style'] as $styleVal)
			$tempStyleArray[] = array('finset'=>$dataSettingValues[$styleVal]);			
			

			if(count($_POST['style'])==0){
			//{"objects":[],"total_count":1}
				 $preparedData['total_count'] = count($preparedData);
				echo json_encode($preparedData);
				die;

			}
//		$tempStyleArrayVal = implode(",",$tempStyleArray);
			
	if(Mage::app()->getStore()->getDefaultCurrencyCode()!=Mage::app()->getStore()->getCurrentCurrencyCode())
	{
	$allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();	
	$currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));
			
			$data['price_to']=round($data['price_to']*$currentRate[Mage::app()->getStore()->getDefaultCurrencyCode()]);
			
			$data['price_from']=round($data['price_from']*$currentRate[Mage::app()->getStore()->getDefaultCurrencyCode()]);
	}	
	
    $products = Mage::getModel('catalog/category')->load(4)
            ->getProductCollection()
            ->addAttributeToSelect('*')
			 ->setCurPage($page)
                ->setPageSize($data['limiter'][0])
				->addAttributeToFilter('price', array(
                    'from' => $data['price_from'],
                    'to' => $data['price_to'],
                ))
			->addAttributeToSort($data['sortby'][0], 'asc')
			->addAttributeToFilter($selectedDiamondType,$typeYes[$selectedDiamondType])
			->addAttributeToFilter('style',$tempStyleArray)
			->setStore(Mage::app()->getStore());
       

            $preparedDataVal = array();
 			  $preparedData = array();
			 
         $preparedData['objects'] = array();
			
            foreach ($products as $p) {
			
				$preparedDataVal['entity_id']=$p->getId();
				$preparedDataVal['name']=$p->getName();
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');

               	$preparedDataVal['price'] = Mage::helper('core')->currency($p->getPrice());
                
				$preparedDataVal['product_full_url'] = $p->getProductUrl();

                array_push($preparedData['objects'], $preparedDataVal);
               
            }

            $preparedData['total_count'] = count($preparedData);

            echo json_encode($preparedData);

        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }*/
	
	    public function filterringAction() {
        if ($data = $this->getRequest()->getParams()) {

            /*  $attrSetName = 'ring';
              $attributeSetId = Mage::getModel('eav/entity_attribute_set')
              ->load($attrSetName, 'attribute_set_name')
              ->getAttributeSetId(); */

            $page = 1;

            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();

//    $attrSetName = 'ring';
            /* $attributeSetId = Mage::getModel('eav/entity_attribute_set')->load($attrSetName, 'attribute_set_name')->getAttributeSetId(); */

            $typeYes = array('asscher' => 97, 'cushion' => 99, 'emerald' => 101, 'heart' => 103, 'marquise' => 105, 'oval' => 107, 'pear' => 109, 'princess' => 111, 'radiant' => 113, 'round' => 115);
//	$attributeId = array(195=>'asscher', 196=>'cushion',197 =>'emerald', 198=>'heart',  199=>'marquise',200=>'oval',201=>'pear',202=>'princess',203=>'radiant',204=>'round');

            $attributeId = array('asscher' => 195, 'cushion' => 196, 'emerald' => 197, 'heart' => 198, 'marquise' => 199, 'oval' => 200, 'pear' => 201, 'princess' => 202, 'radiant' => 203, 'round' => 204);
            //echo Mage::app()->getStore()->getDefaultCurrencyCode();
//	echo "<br>";
//echo 	Mage::app()->getStore()->getCurrentCurrencyCode();die;
            $dataSettingValues = array('Channel set' => 119, 'Halo' => 122, 'Pave' => 118, 'Side stone' => 120, 'Solitare' => 117, 'Vintage' => 121);

            $tempStyleArray = array();
            foreach ($data['style'] as $styleVal)
                $tempStyleArray[] = array('finset' => $dataSettingValues[$styleVal]);


            if (count($_POST['style']) == 0) {
                //{"objects":[],"total_count":1}
                $preparedData['total_count'] = count($preparedData);
                echo json_encode($preparedData);
                die;
            }
//		$tempStyleArrayVal = implode(",",$tempStyleArray);

            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));

                $data['price_to'] = round($data['price_to'] * $currentRate[Mage::app()->getStore()->getDefaultCurrencyCode()]);

                $data['price_from'] = round($data['price_from'] * $currentRate[Mage::app()->getStore()->getDefaultCurrencyCode()]);
            }
            
           // print_r($data); die;
            $products = Mage::getModel('catalog/category')->load(4)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->setCurPage($page)
                    ->setPageSize($data['limiter'])
                    ->addAttributeToFilter('price', array(
                        'from' => $data['price_from'],
                        'to' => $data['price_to'],
                    ))
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->addAttributeToFilter($selectedDiamondType, $typeYes[$selectedDiamondType])
                    ->addAttributeToFilter('style', $tempStyleArray)
                    ->setStore(Mage::app()->getStore());


            $preparedDataVal = array();
            $preparedData = array();

            $preparedData['objects'] = array();

            foreach ($products as $p) {

                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = $p->getName();
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');

                $preparedDataVal['price'] = Mage::helper('core')->currency($p->getPrice());

                $preparedDataVal['product_full_url'] = $p->getProductUrl();

                array_push($preparedData['objects'], $preparedDataVal);
            }

            $preparedData['total_count'] = count($preparedData);

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }


    public function getSelectedDiamondAction()
    {
        $data = array();
        $diamondId = Mage::getSingleton('core/session')->getChoiseDiamond();
        $stepOneUrl = Mage::getSingleton('core/session')->getStepOneUrlState();
        $diamondType = Mage::getSingleton('core/session')->getDiamondType();

        $model = Mage::getModel('trd_importxls/importxls')->load($diamondId);

        $data['diamond_data'] = $model->getData();
        $data['step_one_url'] = $stepOneUrl;
        $data['diamond_type'] = $diamondType;

        echo json_encode($data);
    }
	
	public function removeDiamondAction()
    {
		Mage::getSingleton('core/session')->unsChoiseDiamond();
		Mage::getSingleton('core/session')->unsDiamondStep();
		Mage::getSingleton('core/session')->unsStepOneUrlState();

        Mage::getSingleton('core/session')->unsDiamondType();
		echo json_encode(array('status' => 'true', 'message' => 'Successfully Removed.'));
        
	}
	
	
	public function removeSettingAction()
    {
		Mage::getSingleton('core/session')->unsRingId();
		Mage::getSingleton('core/session')->unsRingData();
		echo json_encode(array('status' => 'true', 'message' => 'Successfully Removed.'));
	}
	
	

    public function sidebarInfoAction()
    {
        $data = array();
        $diamondId = Mage::getSingleton('core/session')->getChoiseDiamond();
        $stepOneUrl = Mage::getSingleton('core/session')->getStepOneUrlState();
        $diamondType = Mage::getSingleton('core/session')->getDiamondType();
        $ringId = Mage::getSingleton('core/session')->getRingId();
     //   $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
      //  $data['currency_code'] = $_currentCurrencyCode;

        $data['diamond'] = false;

        if ($diamondId) {
           $product = Mage::getModel('catalog/product')->load($diamondId);

          //  $data['diamond_data'] = $model->getData();
            $data['diamond'] = true;
			$data['diamond_data']['diamonds_name'] = $product->getName();
			$data['diamond_data']['diamonds_model']=$product->getSku();
			$data['diamond_data']['diamonds_price']=Mage::helper('core')->currency($product->getPrice());
			$data['diamond_data']['diamonds_weight']=round($product->getDiamondCarat(),2);
			$data['diamond_data']['shape']=$product->getDiamondShape();
            $data['diamond_url'] = $product->getProductUrl();

            $data['step_one_url'] = $stepOneUrl;
            $data['diamond_type'] = $diamondType;
			$data['diamonds_price_val'] = $product->getPrice();
        }

        if ($ringId) {
            $data['ring'] = true;
            $product = Mage::getModel('catalog/product')->load($ringId);
          //  $origPrice = $product->getPrice();

           /**/
			$ringData = Mage::getSingleton('core/session')->getRingData();
			
			$ringPrice = str_replace(",","", substr($ringData['prprice'],1,strlen($ringData['prprice'])));
				 $_currentCurrencyCode = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
				
            $data['ring_name'] = $product->getName();
            $data['ring_price'] =  $_currentCurrencyCode. $ringPrice;
            $data['ring_price_val'] =$ringPrice;
            $data['ring_url'] = $product->getProductUrl();
            $data['ring_img'] = (string) Mage::helper('catalog/image')->init($product, 'thumbnail');
        } else {
            $data['ring'] = false;
        }
			$data['totalprice']= Mage::helper('core')->currency($data['ring_price_val']+ $data['diamonds_price_val']);
        echo json_encode($data);
    }

    // protected function _prepareCut($from, $to) {
    //     $allValues = array(
    //         'FR', // fair
    //         'GD',  // good
    //         'VG', // very good
    //         'EX', // Excellent
    //         'Signature Ideal',
    //         'H&A'
    //     );

    //     $returned = $this->_findFromTo($allValues, $from, $to);

    //     return $returned;
    // }

    protected function _prepareClarity($from, $to) {
	
        $allValues = array(
            'SI2',
            'SI1',
            'VS2',
            'VS1',
            'VVS2',
            'VVS1',
            'IF',
            'FL'
        );

        $returned = $this->_findFromTo($allValues, $from, $to);

        return $returned;
    }

    protected function _getCustomOrderString($field, $sort)
    {
        $query = '';
        switch (strtolower($field)) {
            case 'cut':
                $query = "CASE WHEN `cut`='GD' THEN 'a' WHEN `cut`='VG' THEN 'b' WHEN `cut`='EX' THEN 'c' WHEN `cut`='Signature Ideal' THEN 'd' WHEN `cut`='H&A' THEN 'd' END " . $sort;
                break;
            case 'color':
                $query = "CASE WHEN `color`='K' THEN 'a' WHEN `color`='J' THEN 'b' WHEN `color`='I' THEN 'c' WHEN `color`='H' THEN 'd' WHEN `color`='G' THEN 'e' WHEN `color`='F' THEN 'g' WHEN `color`='E' THEN 'h' WHEN `color`='D' THEN 'i' END " . $sort;
                break;
            case 'clarity':
                $query = "CASE WHEN `clarity`='SI2' THEN 'a' WHEN `clarity`='SI1' THEN 'b' WHEN `clarity`='VS2' THEN 'c' WHEN `clarity`='VS1' THEN 'd' WHEN `clarity`='VVS2' THEN 'e' WHEN `clarity`='VVS1' THEN 'f' WHEN `clarity`='IF' THEN 'g' WHEN `clarity`='FL' THEN 'h' END " . $sort;
                break;
            case 'polish':
                $query = "CASE WHEN `polish`='GD' THEN 'a' WHEN `polish`='VG' THEN 'b' WHEN `polish`='EX' THEN 'c' END " . $sort;
                break;
            case 'symmetry':
                $query = "CASE WHEN `symmetry`='GD' THEN 'a' WHEN `symmetry`='VG' THEN 'b' WHEN `symmetry`='EX' THEN 'c' END " . $sort;
                break;
            case 'fluorescence':
                $query = "CASE WHEN `fluorescence`='none' THEN 'a' WHEN `fluorescence`='faint' THEN 'b' WHEN `fluorescence`='medium' THEN 'c' WHEN `fluorescence`='strong' THEN 'd' WHEN `fluorescence`='extreme' THEN 'e' END " . $sort;
                break;
        }

        return $query;
    }

    protected function _preparePolish($from, $to) {
        $allValues = array(
            'GD',
            'VG',
            'EX'
        );

        $returned = $this->_findFromTo($allValues, $from, $to);

        return $returned;
    }

    protected function _prepareSymmetry($from, $to) {
        $allValues = array(
            'GD',
            'VG',
            'EX'
        );

        $returned = $this->_findFromTo($allValues, $from, $to);

        return $returned;
    }

    protected function _prepareFluorescence($from, $to) {
        $allValues = array(
            'NONE',
            'FAINT',
            'MEDIUM',
            'STRONG',
            'EXTREME'
        );

        $returned = $this->_findFromTo($allValues, $from, $to);

        return $returned;
    }

    protected function _prepareColor($from, $to) {
        $allValues = array(
            'J',
            'I',
            'H',
            'G',
            'F',
            'E',
            'D'
        );

        $returned = $this->_findFromTo($allValues, $from, $to);

        return $returned;
    }

    protected function _findFromTo($allValues, $from, $to)
    {
        $isFromFinded = false;
        $isToFinded = false;

        foreach ($allValues as $num => $val) {
            if (!$isFromFinded && $from != $val) {
                unset($allValues[$num]);
            } else if (!$isFromFinded && $from == $val) {
                $isFromFinded = true;
            } else if ($isFromFinded && !$isToFinded && $to == $val) {
                $isToFinded = true;
            } else if ($isToFinded && $isFromFinded) {
                unset($allValues[$num]);
            }
        }

        return $allValues;
    }
}