<?php
class Trd_Diamond_DiamondController extends Mage_Core_Controller_Front_Action
{
    public $status = false, $message;


    public function addtocartAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            if ($data['pid']) {
                $importXlsModel = Mage::getModel('trd_importxls/importxls')->load($data['pid'],'diamonds_model');
                $tempProdId = Mage::getModel('trd_diamond/diamondprod')->load($data['pid']);

                if ($this->_checkExistDiamondProduct($data['pid'])) {
                    if ($importXlsModel && $tempProdId) {
                        try {
                            $product = Mage::getModel('catalog/product')->load($data['pid']);
                            
							$diamond_base_image=strtolower($product->getDiamondShape()).'_t.jpg';
                            $filepath = Mage::getBaseDir('media').'/wysiwyg/icotheme/diamonds_pics/'. $diamond_base_image;

                            if (file_exists($filepath)) {
                            // get file extension 
                            $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                            // get file's name 
                            $filename = pathinfo($filepath, PATHINFO_FILENAME);
                            // get file's directory
                            $directory = Mage::getBaseDir('media').'/catalog/product/diamonds_pics';
                            // add and combine the filename, iterator, extension 
                            $new_filename = $filename . '_' . time() . '.' . $extension;
                            // add file name to the end of the path to place it in the new directory; the while loop will check it again 
                            $new_path = $directory . '/' . $new_filename;
                            @copy($filepath, $new_path);
                            $diamond_new_full_filename = 'diamonds_pics/' . $new_filename;
/*                            $image = new Varien_Image($filepath);
                            $image->constrainOnly(true);
                            $image->keepAspectRatio(true);
                            $image->keepFrame(true);
                            $image->keepTransparency(false);
                            $image->backgroundColor(array(255,255,255));
                            $image->resize(500,500);
                            $image->save($directory. '/' .$new_filename);*/
                            }                            
                            $product->addImageToMediaGallery('media/catalog/product/' . $diamond_new_full_filename, array('image', 'thumbnail', 'small_image'), false, false); //assigning image, thumb and small image to media gallery
                            $product->save();
							
                            $product_2 = Mage::getModel('catalog/product')->load($data['pid']);
                            $value = $product_2->getData('small_image');
            if ($value) {
                Mage::getSingleton('catalog/product_action')
                        ->updateAttributes(array($product_2->getId()), array(
                            'image' => $value,
                            'small_image' => $value,
                            'thumbnail' => $value,
                                ), 0);  // 0 specifies the Default
            }
			
                            $options = $this->_prepareCustomOptionIds($product, $importXlsModel);

                            Mage::register('diamond_current_model', $importXlsModel);
                            Mage::register('temp_prod_id', $tempProdId->getProductId());
                            Mage::register('importxls_id', $data['pid']);
                            $cart = Mage::getModel('checkout/cart');
                            $cart->init();
                            $cart->addProduct($product, array(
                                'product_id' => $product->getId(),
                                'qty' => 1,
                                'options' => $options
                            ));
                            $cart->save();
                            Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

                            $this->status = true;
                            $this->message = 'success added';
                        } catch (Exception $e) {
                            $this->message = $e->getMessage();
                        }
                    } else {
                        $this->message = 'Invalid product id';
                    }
                } else {
                    $this->status = true;
                    $this->message = 'This product already added in cart';
                }
            } else {
                $this->message = 'Invalid parameters';
            }
        } else {
            $this->message = 'Bad request';
        }

        $result = ['status' => $this->status, 'message' => $this->message];

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function updatecartAction()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $cartItems = $quote->getAllVisibleItems();
        $tempProdId = Mage::getModel('trd_diamond/diamondprod')->load(1);
        $preparedData = array();
        $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();

        $_diamondItems = array();
        $_ringItems = array();
        $_otherProducts = array();

        foreach ($cartItems as $item) {
            $attributeSetName = Mage::getModel('eav/entity_attribute_set')->load($item->getProduct()->getAttributeSetId())->getAttributeSetName();

            if ($item->getCustomProductName() && $item->getCustomProductImage()) {
                array_push($_diamondItems, $item);
            } else if ($attributeSetName == 'ring') {
                array_push($_ringItems, $item);
            } else {
                array_push($_otherProducts, $item);
            }
        }

        if (count($_diamondItems)) {
            $preparedData['diamonds'] = array();
            foreach ($_diamondItems as $item) {
                $data = array();
                $productId = $item->getProductId();
                $product = Mage::getModel('catalog/product')->load($productId);

                if ($_currentCurrencyCode == 'SGD') {
                    $price = number_format($item->getCustomPrice(), 2, '.', '');
                } else if ($_currentCurrencyCode == 'USD') {
                    $price = number_format(Mage::helper('directory')->currencyConvert($item->getCustomPrice(), 'SGD', 'USD'), 2, '.', '');
                }

                $data['product_name'] = ($product->getId() == $tempProdId->getProductId() ? $item->getCustomProductName() : $product->getName());
                //$data['image_url'] = $item->getCustomProductImage();
				
				$data['image_url'] = (string)Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail');
                $data['product_url'] = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                $data['price'] = $price;
                $data['delete_url'] = Mage::getUrl('checkout/cart/delete', array('id' => $item->getId()));

                array_push($preparedData['diamonds'], $data);
            }
        }

        if (count($_ringItems)) {
            $preparedData['rings'] = array();
            foreach ($_ringItems as $item) {
                $data = array();
                $productId = $item->getProductId();
                $product = Mage::getModel('catalog/product')->load($productId);

                if ($_currentCurrencyCode == 'SGD') {
                    $price = number_format($item->getCustomPrice(), 2, '.', '');
                } else if ($_currentCurrencyCode == 'USD') {
                    $price = number_format(Mage::helper('directory')->currencyConvert($item->getCustomPrice(), 'SGD', 'USD'), 2, '.', '');
                }

                $data['product_name'] = ($product->getId() == $tempProdId->getProductId() ? $item->getCustomProductName() : $product->getName());
                $data['image_url'] = (string)Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail');
                $data['product_url'] = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                $data['price'] = $price;
                $data['delete_url'] = Mage::getUrl('checkout/cart/delete', array('id' => $item->getId()));

                array_push($preparedData['rings'], $data);
				
            }
        }

        if (count($_otherProducts)) {
            $preparedData['other_products'] = array();
            foreach ($_otherProducts as $item) {
                $data = array();
                $productId = $item->getProductId();
                $product = Mage::getModel('catalog/product')->load($productId);

                if ($_currentCurrencyCode == 'SGD') {
                    $price = number_format($item->getCustomPrice(), 2, '.', '');
                } else if ($_currentCurrencyCode == 'USD') {
                    $price = number_format(Mage::helper('directory')->currencyConvert($item->getCustomPrice(), 'SGD', 'USD'), 2, '.', '');
                }

                $data['product_name'] = ($product->getId() == $tempProdId->getProductId() ? $item->getCustomProductName() : $product->getName());
                //$data['image_url'] = $item->getCustomProductImage();
				$data['image_url'] = (string)Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail');
                $data['product_url'] = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                $data['price'] = $price;
                $data['delete_url'] = Mage::getUrl('checkout/cart/delete', array('id' => $item->getId()));

                array_push($preparedData['other_products'], $data);
            }
        }

        $preparedData['subtotal'] = number_format($quote->getSubtotal());

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($preparedData));
    }
	
	public function addcustomproductAction(){
		
		$diamondId = Mage::getSingleton('core/session')->getChoiseDiamond();
		 $ringId = Mage::getSingleton('core/session')->getRingId();
		 $ringData = Mage::getSingleton('core/session')->getRingData();
		
	 	if($diamondId> 0 && $ringId>0){
		
		/*get last custom product sku-id code start from here */
			$resource = Mage::getSingleton('core/resource');

			$readConnection = $resource->getConnection('core_read');

			$query ="SELECT * from customproductid ";

			$results = $readConnection->fetchAll($query);

			$arraySort = array();
			
			$customProductSkuId ='';
			$max= $results[0]['id']+1;
			$customProductSkuId	 =	'custom-sku-'.$max;
			

			$writeConnection = $resource->getConnection('core_write');

			$query ="update customproductid set id=id+1 ";

			$writeConnection->query($query);
			
			
			/*get last custom product sku-id code end at here */
			/**ring product data get from here*/
			
            $product = Mage::getModel('catalog/product');
           
			$product->load($ringId);
			$ringDataVal='';
		
			$ringAttrbute='';
			$ringName = $product->getName();
			
			$ringWeight = $product->getWeight();
			
		  //protected base image
          		    
		  if ($product->getImage() != 'no_selection') {
		  $new_full_filename = $product->getImage();
		  }
		  elseif ($product->getThumbnail() != 'no_selection') {
		  $new_full_filename = $product->getThumbnail();
		  }
		  elseif ($product->getSmallImage() != 'no_selection') {
		  $new_full_filename = $product->getSmallImage();
		  }
		  else
		  {
		  $new_full_filename = $product->getImage();
		  }
		  
           
/*            if ($base_image != 'no_selection') {
                $filepath = Mage::getBaseDir('media') . '/catalog/product' . $base_image;
                
                if (file_exists($filepath)) {
                    $mainimgarray = explode('/', $base_image);
                    foreach ($mainimgarray as $base_imageval) {
                        $i = strrpos($base_imageval, ".");
                        if (!$i) {
                            $base_imagearray[]=$base_imageval;
                        }
                    }                    
                    // get file extension 
                    $extension = pathinfo($filepath, PATHINFO_EXTENSION);                    
                    // get file's name 
                    $filename = pathinfo($filepath, PATHINFO_FILENAME);
                    // get file's directory
                    $directory = dirname($filepath);
                    // add and combine the filename, iterator, extension 
                    $new_filename = $filename . '_' . $max . '.' . $extension;
                    // add file name to the end of the path to place it in the new directory; the while loop will check it again 
                    $new_path = $directory . '/' . $new_filename;                    
                    @copy($filepath, $new_path);
                    $new_full_filename = implode('/', $base_imagearray) . '/' . $new_filename; 
                }
            }*/
			
			$ringAttrbute.='Ring Name : ' . $product->getName()."<br> <hr>";
			$style = explode(",",$product->getStyle());
			
			$dataSettingValues = array(119=>'Channel set',122=>'Halo',118=>'Pave',120=>'Side stone',
			117=>'Solitare',121=>'Vintage');
			
			$ringAttrbute .=  'Style : ';
			
			$styleAry =array();
				
				foreach($style as $val){
						$styleAry[] = $dataSettingValues[$val] ;
					}
					
				$ringAttrbute .=  '('.implode(",",$styleAry).') <br>';	
				
				if($product->getSst1Gemstone()!=''){
					$ringAttrbute .= 'Side Stone (1) Gemstone : '.$product->getSst1Gemstone()."<br>";
				}
				
				if($product->getSst1Shape()!=''){
				$ringAttrbute .= 'Side Stone (1) Shape : '.$product->getSst1Shape()."<br>";
				}
				
				if($product->getSst1NumberDiamonds()!=''){
					$ringAttrbute .= 'Side Stone (1) Number of Diamonds : '
					.	$product->getSst1NumberDiamonds()."<br>";
				}
							
			 	if($product->getSst1WeightEstimated()!=''){
					$ringAttrbute .=  'Side Stone (1) Total Carat Weight Estimated : '.	
							$product->getSst1WeightEstimated() ."<br>";
				}
				
				if($product->getSst1AverageColor()!=''){
					$ringAttrbute .=  'Side Stone (1) Average Color : '.
					$product->getSst1AverageColor() ."<br>";
				}
				
				if($product->getSst1AverageClarity()!=''){
					$ringAttrbute .=  'Side Stone (1) Average Clarity : '.
				 	$product->getSst1AverageClarity() ."<br>";
				}
				
				if($product->getSst1AverageCut()!=''){
					$ringAttrbute .=  'Side Stone (1) Average Cut : '	.
					$product->getSst1AverageCut() ."<br>";
				}
				
				if($product->getSst2Gemstone()!=''){
					$ringAttrbute .= 'Side Stone (2) Gemstone : '	.	
					$product->getSst2Gemstone()."<br>";
				}
				
				if($product->getSst2Shape()!=''){
				$ringAttrbute .= 'Side Stone (2) Shape : '.$product->getSst2Shape()."<br>";
				}
				
				if($product->getSst2NumberDiamonds()!=''){
					$ringAttrbute .= 'Side Stone (2) Number of Diamonds : '
					.	$product->getSst2NumberDiamonds()."<br>";
				}
				
				if($product->getSst2WeightEstimated()!=''){
					$ringAttrbute .= 'Side Stone (2) Total Carat Weight Estimated : '
					.	$product->getSst2WeightEstimated()."<br>";
				}
				
				if($product->getSst2AverageColor()!=''){
					$ringAttrbute .= 'Side Stone (2) Average Color : '
					.	$product->getSst2AverageColor()."<br>";
				}
				
				if($product->getSst2AverageClarity()!=''){
					$ringAttrbute .= 'Side Stone (2) Average Clarity : '
					.$product->getSst2AverageClarity()."<br>";
				}
				
				if($product->getSst2AverageCut()!=''){
					$ringAttrbute .= 'Side Stone (2) Average Cut : '
					.	$product->getSst2AverageCut()."<br>";
				}
				
				
				if($product->getAsscher()==98){		$ringAttrbute .=  'Asscher : No <br>';
				}else{								$ringAttrbute .=  'Asscher : Yes <br>';		}
				
				if($product->getCushion()==100){	$ringAttrbute .=  'Cushion : No <br>';
				}else{								$ringAttrbute .=  'Cushion : Yes <br>';		}
				
				if($product->getEmerald()==102){	$ringAttrbute .=  'Emerald : No <br>';
				}else			{					$ringAttrbute .=  'Emerald : Yes <br>';		}
				
				if($product->getHeart()==104){		$ringAttrbute .=  'Heart : No <br>';
				}else{								$ringAttrbute .=  'Heart : Yes <br>';		}
				
				if($product->getMarquise()==106){	$ringAttrbute .=  'Marquise : No <br>';
				}else{								$ringAttrbute .=  'Marquise : Yes <br>';	}
				
				if($product->getOval()==108){		$ringAttrbute .=  'Oval : No <br>';
				}else{								$ringAttrbute .=  'Oval : Yes <br>';		}
				
				if($product->getPear()==110){		$ringAttrbute .=  'Pear : No <br>';
				}else{								$ringAttrbute .=  'Pear : Yes <br>';		}
				
				if($product->getPrincess()==112){	$ringAttrbute .=  'Princess : No <br>';
				}else{								$ringAttrbute .=  'Princess : Yes <br>';	}
				
				if($product->getRadiant()==114){	$ringAttrbute .=  'Radiant : No <br>';
				}else{								$ringAttrbute .=  'Radiant : Yes <br>';		}
				
				if($product->getRound()==116){		$ringAttrbute .=  'Round : No <br>';
				}else{								$ringAttrbute .=  'Round : Yes <br>';		}
				
				
				$ringPrice  = $product->getPrice(); 
			foreach ($product->getOptions() as $o) {
                $values = $o->getValues();
                foreach ($values as $v) {
					foreach ($ringData['options'] as $key=>$value) {
				 		if($key==$v->getOptionId() && $value==$v->getOptionTypeId())
				 		{	
					$ringDataVal .=	 $o->getTitle()." : ". $v->getDefaultTitle()."<br>" ;
					$ringPrice += $v->getPrice();
					if($o->getTitle()=='Engraving')
					{
					$alloption[]=array('title' => $o->getTitle(),'title_child' => $v->getDefaultTitle(),'price' => $v->getPrice());
					$alloption[]=array('title' => 'EngravingText','title_child' => $ringData['ring_engraving'],'price' => '0.00');
					}
					else
					{
					$alloption[]=array('title' => $o->getTitle(),'title_child' => $v->getDefaultTitle(),'price' => $v->getPrice());
					}
							}
				 	}
                }
                $i++;
            }
			/*ring product details end here**/	
			
				/*diamond product details start from here**/	
				// Mage::helper('core')->currency($v->getPrice(),false,false)
				
/*Diamond attrbute**/
				$product = Mage::getModel('catalog/product');
				$product->load($diamondId);
				$diamondName = $product->getName();
				$diamondWeight = $product->getWeight();
				$diamondPrc =  $product->getPrice();
			
                $diamondAttrbute = ''; 
				  $diamondAttrbute .= '<br>Diamond Details <br><hr>'; 
                if($product->getDiamondPricePerCarat()!=''){
				$diamondAttrbute .= 'Diamond Price Per Carat : '.$product->getDiamondPricePerCarat()."<br>";
				}
				
				if($product->getDiamondWeight()!=''){
				$diamondAttrbute .= 'Diamond Weight : '.$product->getDiamondWeight()."<br>";
				}
				
				if($product->getDiamondTable()!=''){
				$diamondAttrbute .= 'Diamond Table : '.$product->getDiamondTable()."<br>";
				}
				
				if($product->getDiamondCert()!=''){
				$diamondAttrbute .= 'Diamond Cert : '.$product->getDiamondCert()."<br>";
				}
				
				if($product->getDiamondSupplier()!=''){
				$diamondAttrbute .= 'Diamond Supplier : '.$product->getDiamondSupplier()."<br>";
				}
				
				if($product->getDiamondSymmetry()!=''){
				$diamondAttrbute .= 'Diamond Symmetry : '.$product->getDiamondSymmetry()."<br>";
				}
				
				if($product->getDiamondGridle()!=''){
				$diamondAttrbute .= 'Diamond Gridle : '.$product->getDiamondGridle()."<br>";
				}
				
				if($product->getDiamondColor()!=''){
				$diamondAttrbute .= 'Diamond Color : '.$product->getDiamondColor()."<br>";
				}
				
				if($product->getDiamondClarity()!=''){
				$diamondAttrbute .= 'Diamond Clarity : '.$product->getDiamondClarity()."<br>";
				}
				
				if($product->getDiamondCertificateUrl()!=''){
				$diamondAttrbute .= 'Diamond Certificate Url : '.$product->getDiamondCertificateUrl()."<br>";
				}
				
				if($product->getDiamondFluorescence()!=''){
				$diamondAttrbute .= 'Diamond Fluorescence : '.$product->getDiamondFluorescence()."<br>";
				}
				
				if($product->getDiamondCut()!=''){
				$diamondAttrbute .= 'Diamond Cut : '.$product->getDiamondCut()."<br>";
				}
				
				if($product->getDiamondCarat()!=''){
				$diamondAttrbute .= 'Diamond Carat : '.$product->getDiamondCarat()."<br>";
				}
				
				if($product->getDiamondDepth()!=''){
				$diamondAttrbute .= 'Diamond Depth : '.$product->getDiamondDepth()."<br>";
				}
				if($product->getDiamondMeasurement1()!=''){
				$diamondAttrbute .= 'Diamond Measurement1 : '.$product->getDiamondMeasurement1()."<br>";
				}
				
				if($product->getDiamondMeasurement2()!=''){
				$diamondAttrbute .= 'Diamond Measurement2 : '.$product->getDiamondMeasurement2()."<br>";
				}
				
				if($product->getDiamondMeasurement3()!=''){
				$diamondAttrbute .= 'Diamond Measurement3 : '.$product->getDiamondMeasurement3()."<br>";
				}
				
				
				if($product->getDiamondDiamondModel()!=''){
				$diamondAttrbute .= 'Diamond Diamond Model : '.$product->getDiamondDiamondModel()."<br>";
				}
				
				if($product->getDiamondReportNumber()!=''){
				$diamondAttrbute .= 'Diamond Report Number : '.$product->getDiamondReportNumber()."<br>";
				}
				
				if($product->getDiamondPolish()!=''){
				$diamondAttrbute .= 'Diamond Polish : '.$product->getDiamondPolish()."<br>";
				}
				
				if($product->getDiamondShape()!=''){
				$diamondAttrbute .= 'Diamond Shape : '.$product->getDiamondShape()."<br>";
				}
				
			$diamond_base_image=strtolower($product->getDiamondShape()).'_t.jpg';
            $filepath = Mage::getBaseDir('media').'/wysiwyg/icotheme/diamonds_pics/'. $diamond_base_image;
            
            if (file_exists($filepath)) {
                
                // get file extension 
                $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                // get file's name 
                $filename = pathinfo($filepath, PATHINFO_FILENAME);
                // get file's directory
                $directory = Mage::getBaseDir('media').'/catalog/product/diamonds_pics';
                // add and combine the filename, iterator, extension 
                $new_filename = $filename . '_' . $max . '.' . $extension;
                // add file name to the end of the path to place it in the new directory; the while loop will check it again 
                $new_path = $directory . '/' . $new_filename;
                @copy($filepath, $new_path);
                $diamond_new_full_filename = 'diamonds_pics/' . $new_filename;
				
								
/*				$image = new Varien_Image($filepath);
				$image->constrainOnly(true);
				$image->keepAspectRatio(true);
				$image->keepFrame(true);
				$image->keepTransparency(false);
				$image->backgroundColor(array(255,255,255));
				$image->resize(500,500);
				$image->save($directory. '/' .$new_filename);*/				

            }
				
				if($product->getDiamondCertifiedBy()!=''){
				$diamondAttrbute .= 'Certified By : '.$product->getDiamondCertifiedBy()."<br>";
				}
				
				if($product->getDiamondSetCertifiedDetail()!=''){
			   $diamondAttrbute .= 'Diamond Certified Detail : '.$product->getDiamondSetCertifiedDetail()."<br>";
				}
				
				if($product->getDiamondSetOrderby()!=''){
				$diamondAttrbute .= 'Order by : '.$product->getDiamondSetOrderby()."<br>";
				}
				
				if($product->getDiamondSetShipDate()!=''){
				$diamondAttrbute .= 'Ship date : '.$product->getDiamondSetShipDate()."<br>";
				}
				
				if($product->getDiamondSetFreeShipping()!=''){
					$diamondAttrbute .= 'Free shipping via : '.$product->getDiamondSetFreeShipping()."<br>";
				}
				$dataRng =  Mage::getSingleton('core/session')->getRingData();
				
			

  $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));
		
 		/* if(Mage::app()->getStore()->getCurrentCurrencyCode()=='USD'){
		
			$rngPrc = str_replace(",","", substr($dataRng['prprice'],1,strlen($dataRng['prprice'])-1));

			$rngPrc = $rngPrc-3.23;
			 $prcSetting = Mage::helper('directory')->currencyConvert($rngPrc,'USD','SGD') + $diamondPrc;
			
		
	
		}else{
				$prcSetting = $dataRng['prprice'] +$diamondPrc ;
		}*/
		$prcSetting = $ringPrice+$diamondPrc;
	//	die;
//echo   $customProductSkuId;die;
				/**//**ring product data get end at here*/
				$ringengravingAttrbute="";
            if ($ringData['ring_engraving'] != '') {
                $ringengravingAttrbute .= 'Engraving Text : '. $ringData['ring_engraving'] . "/n ";
            }

            if ($ringData['ring_font'] != '') {
                $ringengravingAttrbute .= 'Engraving Font : ' . $ringData['ring_font'] . "/n ";
            }
			
			$product = Mage::getModel('catalog/product');
      $product->setStoreId(1)
       ->setWebsiteIds(array(1))
       ->setAttributeSetId(4)
       ->setTypeId('simple')
       ->setCreatedAt(strtotime('now'))
       ->setSku($customProductSkuId)
       ->setName($ringName . ' & '.$diamondName)
       ->setWeight( (int)$diamondWeight +  (int)$ringWeight)
	   ->setUrlKey($customProductSkuId)
       ->setStatus(1)
       ->setPrice($prcSetting)
       ->setTaxClassId(0) 
       ->setVisibility(3)
       ->setDescription($ringAttrbute . $diamondAttrbute)	  
	   ->setShortDescription('Custom ring made by diamond and setting. /n Ring Engraving <hr>'.$ringengravingAttrbute)
       ->setStockData( array('use_config_manage_stock'=>0, 'manage_stock'=>1,'is_in_stock'=>1,'min_sale_qty'=>1, 'max_sale_qty'=>1, 'qty'=>5 ))
       ->setCategoryIds(array(103));
	   
     if ($new_full_filename != 'no_selection') {
	  $product->setImage($new_full_filename);
       $product->addImageToMediaGallery('media/catalog/product/' . $new_full_filename, array('image', 'thumbnail', 'small_image'), false, false); //assigning image, thumb and small image to media gallery
	 }
      $product->save();
	  
	  $value=$product->getData('small_image');
if ($value) {
    Mage::getSingleton('catalog/product_action')
            ->updateAttributes(array($product->getId()), 
                array(
                    'image'=>$value,
                    'small_image'=>$value,
                    'thumbnail'=>$value,
                    ), 
                0);  // 0 specifies the Default
    }
    
	
			//	$product->getResource()->save($product);
			//	$productAdd->save();
			$entityId = $product->getId();	
			$newproduct = Mage::getModel('catalog/product');
			$newproduct->load($entityId);
			$newproduct->addImageToMediaGallery('media/catalog/product/' . $diamond_new_full_filename, array('image'), false, false); //assigning image, thumb and small image to media gallery
			$newproduct->save();
			            
			if(!empty($alloption))
            {
             $productoption = Mage::getModel('catalog/product')->load($entityId);
             $ji='0';
            foreach ($alloption as $value) {
                            
                            $option[] = array(
                                'title' => $value['title'],
                                'type' => 'drop_down', // could be drop_down ,checkbox , multiple
                                'is_require' => 0,
                                'sort_order' => $ji,
                                'values' => array(
                                    array(
                                        'title' => $value['title_child'],
                                        'price' => $value['price'],
                                        'price_type' => 'fixed',
                                        'sku' => '',
                                        'sort_order' => '1'
                                    )
                                )
                            );
                        
                        $ji++;
                    }
					
					            
			$productoption->setProductOptions($option);
			$productoption->setCanSaveCustomOptions(true);
			$productoption->save();
			
            }
			
			$qty = 1;  //used if your qty is not hard coded
            $cart = Mage::getModel('checkout/cart');
            $cart->init();
            if ($entityId == '') {
                continue;
            }
            $productModel = Mage::getModel('catalog/product')->load($entityId);

            //I added only Virtual product here. If no need, remove this condtion
        //    if ($productModel->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL) {
                try
                {
                   $cart->addProduct($productModel, array('qty' => '1'));  //qty is hard coded
                }
                catch (Exception $e) {
                   continue;
                }
         //   }
         $cart->save();
					
		 $this->status = true;
            $this->message = 'product added into cart successfully.';
		
		
		Mage::getSingleton('core/session')->unsDiamondStep();
		Mage::getSingleton('core/session')->unsChoiseDiamond();
		Mage::getSingleton('core/session')->unsStepOneUrlState();
		Mage::getSingleton('core/session')->unsDiamondType();
		Mage::getSingleton('core/session')->unsLastViewedDiamondId();
        Mage::getSingleton('core/session')->unsDiamondProdId();
		Mage::getSingleton('core/session')->unsRingId();
		Mage::getSingleton('core/session')->unsRingData();	
		
		}else {
            $this->status = false;
            $this->message = 'Bad request.';
        }

        $result = array('status' => $this->status, 'message' => $this->message);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	 
	}

    public function setRingToSettingAction()
    {
	
	//Array ( [product] => 27282 [related_product] => [product-price] => 861.96 [color] => Bronze [metals] => [engraving] => [ring_engraving] => [ring_font] => [options] => Array ( [31] => 13 [37] => 50 [36] => 45 [35] => 33 ) ) 
	//print_r($this->getRequest()->getPost());die;
	
        if ($data = $this->getRequest()->getPost()) {
            $ringId = (int) $data['product']; 
			
				
            if ($ringId) {
                Mage::getSingleton('core/session')->setRingId($ringId);
				Mage::getSingleton('core/session')->setRingData($data);
			
				
                $this->status = true;
                $this->message = 'Setting successfully added.';
            } else {
                $this->status = false;
                $this->message = 'bad ring id';
            }
        } else {
            $this->status = false;
            $this->message = 'request without parameters';
        }

        $result = array('status' => $this->status, 'message' => $this->message);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function gotostepAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            switch($data['step']) {
                case '2':
                    if ($data['diamond_id'] && $data['url']) {

                        //$this->_addDiamondToCart($data['diamond_id']);

                        $diamondType = $this->_prepareDiamondType($data['diamond_id']);
                        Mage::getSingleton('core/session')->setDiamondStep($data['step']);
                        Mage::getSingleton('core/session')->setChoiseDiamond($data['diamond_id']);
                        Mage::getSingleton('core/session')->setStepOneUrlState($data['url']);
                        Mage::getSingleton('core/session')->setDiamondType($diamondType);
						
						if ($data['style']) {
                            Mage::getSingleton('core/session')->setSettingStyle($data['style']);
                        }
						
                        $this->message = 'success';
                        $this->status = 'true';
                    } else {
					    
						if ($data['style']) {
                            Mage::getSingleton('core/session')->setSettingStyle($data['style']);
                        }
						
                        $data['url'] = Mage::getBaseUrl() . 'diamonds-1.html';
                        Mage::getSingleton('core/session')->setDiamondStep($data['step']);
                        Mage::getSingleton('core/session')->setStepOneUrlState($data['url']);
                        $this->message = 'success';
                        $this->status = 'true';
                    }
                    $url = Mage::getBaseUrl() . 'diamonds-1.html?step=2';
                    break;
                case '1';
				    Mage::getSingleton('core/session')->unsSettingStyle();
                    Mage::getSingleton('core/session')->setDiamondStep($data['step']);
                    $this->message = 'success';
                    $this->status = 'true';
                    $url = Mage::getSingleton('core/session')->getStepOneUrlState();
                    if (!$url) {
                        $url = Mage::getBaseUrl() . 'diamonds-1.html';
                    }
                    break;
            }
        } else {
            $this->status = 'false';
            $this->message = 'request without parameters';
        }

        $result = ['status' => $this->status, 'message' => $this->message];
        if ($url) {
            $result['url'] = $url;
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * List of params
     * product_id - product id val
     */
    public function addRingToCartAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $productId = $data['product_id'] == 'none' ? Mage::getSingleton('core/session')->getRingId() : (int) $data['product_id'];
            if ($productId) {
                $product = Mage::getModel('catalog/product')->load($productId);
                $cart = Mage::getModel('checkout/cart');
                $cart->init();
                $cart->addProduct($product, array(
                    'product_id' => $product->getId(),
                    'qty' => 1
                ));
                $cart->save();
                Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

                $this->status = true;
                $this->message = 'success added';
            } else {
                $this->status = false;
                $this->message = 'incorrect product id';
            }
        } else {
            $this->status = false;
            $this->message = 'request without parameters';
        }

        $result = ['status' => $this->status, 'message' => $this->message];

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    protected function _addDiamondToCart($diamondId)
    {
        $importXlsModel = Mage::getModel('trd_importxls/importxls')->load($diamondId);
        $tempProdId = Mage::getModel('trd_diamond/diamondprod')->load(1);

        if ($this->_checkExistDiamondProduct($diamondId)) {
            if ($importXlsModel && $tempProdId) {
                try {
                    $product = Mage::getModel('catalog/product')->load($tempProdId->getProductId());

                    $options = $this->_prepareCustomOptionIds($product, $importXlsModel);

                    Mage::register('diamond_current_model', $importXlsModel);
                    Mage::register('temp_prod_id', $tempProdId->getProductId());
                    Mage::register('importxls_id', $diamondId);
                    $cart = Mage::getModel('checkout/cart');
                    $cart->init();
                    $cart->addProduct($product, array(
                        'product_id' => $product->getId(),
                        'qty' => 1,
x                    ));
                    $cart->save();
                    Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
                } catch (Exception $e) {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function _checkExistDiamondProduct($importxls_id)
    {
        $cart = Mage::getModel('checkout/cart')->getQuote();
        $status = true;
        foreach ($cart->getAllItems() as $item) {
            if ($item->getImportxlsId() == $importxls_id) {
                $status = false;
            }
        }

        return $status;
    }

    protected function _prepareDiamondType($diamondId)
    {
        $model = Mage::getModel('trd_importxls/importxls')->load($diamondId);
        $shape = $model->getShape();
        $type = '';

        switch ($shape) {
            case 'CU':
                $type = 'cushion';
                break;
            case 'EC':
                $type = 'emerald';
                break;
            case 'HS':
                $type = 'heart';
                break;
            case 'MQ':
                $type = 'marquise';
                break;
            case 'OV':
                $type = 'oval';
                break;
            case 'PR':
                $type = 'pear';
                break;
            case 'PS':
                $type = 'princess';
                break;
            case 'RA':
                $type = 'radiant';
                break;
            case 'RD':
                $type = 'round';
                break;
            case 'AC':
                $type = 'asscher';
                break;
        }

        return $type;
    }

    protected function _prepareCustomOptionIds($product, $importXlsModel)
    {
        $options = $product->getOptions();
        $prepared = array();
        foreach ($options as $key => $val) {
            switch ($val->getTitle()) {
                case 'supplier':
                    $prepared[$val->getOptionId()] = $importXlsModel->getSupplier();
                    break;
                case 'cert_url':
                    $prepared[$val->getOptionId()] = $importXlsModel->getCertUrl();
                    break;
                case 'diamonds_name':
                    $prepared[$val->getOptionId()] = $importXlsModel->getDiamondsName();
                    break;
                case 'diamonds_model':
                    $prepared[$val->getOptionId()] = $importXlsModel->getDiamondsModel();
                    break;
                case 'diamonds_price':
                    $prepared[$val->getOptionId()] = $importXlsModel->getDiamondsPrice();
                    break;
                case 'price_per_carat':
                    $prepared[$val->getOptionId()] = $importXlsModel->getPricePerCarat();
                    break;
                case 'quantity':
                    $prepared[$val->getOptionId()] = $importXlsModel->getQuantity();
                    break;
                case 'description':
                    $prepared[$val->getOptionId()] = $importXlsModel->getDescription();
                    break;
                case 'diamonds_weight':
                    $prepared[$val->getOptionId()] = $importXlsModel->getDiamondsWeight();
                    break;
                case 'shape':
                    $prepared[$val->getOptionId()] = $importXlsModel->getShape();
                    break;
                case 'carat':
                    $prepared[$val->getOptionId()] = $importXlsModel->getCarat();
                    break;
                case 'color':
                    $prepared[$val->getOptionId()] = $importXlsModel->getColor();
                    break;
                case 'clarity':
                    $prepared[$val->getOptionId()] = $importXlsModel->getClarity();
                    break;
                case 'cut':
                    $prepared[$val->getOptionId()] = $importXlsModel->getCut();
                    break;
                case 'report_no':
                    $prepared[$val->getOptionId()] = $importXlsModel->getReportNo();
                    break;
                case 'polish':
                    $prepared[$val->getOptionId()] = $importXlsModel->getPolish();
                    break;
                case 'symmetry':
                    $prepared[$val->getOptionId()] = $importXlsModel->getSymmetry();
                    break;
                case 'fluorescence':
                    $prepared[$val->getOptionId()] = $importXlsModel->getFluorescence();
                    break;
                case 'depth':
                    $prepared[$val->getOptionId()] = $importXlsModel->getDepth();
                    break;
                case 'table_field':
                    $prepared[$val->getOptionId()] = $importXlsModel->getTableField();
                    break;
                case 'girdle':
                    $prepared[$val->getOptionId()] = $importXlsModel->getGirdle();
                    break;
                case 'measurement_1':
                    $prepared[$val->getOptionId()] = $importXlsModel->getMeasurement_1();
                    break;
                case 'measurement_2':
                    $prepared[$val->getOptionId()] = $importXlsModel->getMeasurement_2();
                    break;
                case 'measurement_3':
                    $prepared[$val->getOptionId()] = $importXlsModel->getMeasurement_3();
                    break;
                case 'diamonds_image':
                    $prepared[$val->getOptionId()] = $importXlsModel->getDiamondsImage();
                    break;
                case 'image':
                    $prepared[$val->getOptionId()] = $importXlsModel->getImage();
                    break;
            }
        }

        return $prepared;
    }
}