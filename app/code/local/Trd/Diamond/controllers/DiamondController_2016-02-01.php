<?php

class Trd_Diamond_DiamondController extends Mage_Core_Controller_Front_Action {

    public $status = false, $message;

    public function addtocartAction() {
        if ($data = $this->getRequest()->getPost()) {
            if ($data['pid']) {
                $importXlsModel = Mage::getModel('catalog/product')->load($data['pid'], 'diamond_diamond_model');
                $tempProdId = Mage::getModel('trd_diamond/diamondprod')->load($data['pid']);

                if ($this->_checkExistDiamondProduct($data['pid'])) {
                    if ($importXlsModel && $tempProdId) {
                        try {
                            $product = Mage::getModel('catalog/product')->load($data['pid']);

                            $diamond_base_image = strtolower($product->getDiamondShape()) . '_t.jpg';
                            $filepath = Mage::getBaseDir('media') . '/wysiwyg/icotheme/diamonds_pics/' . $diamond_base_image;

                            if (file_exists($filepath)) {
                                // get file extension 
                                $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                                // get file's name 
                                $filename = pathinfo($filepath, PATHINFO_FILENAME);
                                // get file's directory
                                $directory = Mage::getBaseDir('media') . '/catalog/product/diamonds_pics';
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
                                  $image->save($directory. '/' .$new_filename); */
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

        // $result = ['status' => $this->status, 'message' => $this->message];
        $result = array('status' => $this->status, 'message' => $this->message);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function updatecartAction() {
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
			
                $_product = $product;
                $ids = $_product->getCategoryIds();

                if (in_array('103', $ids)) {
                    $jklm = '0';
                    $mainliarray = array();
                    foreach ($_product->getOptions() as $o) {
                        $values = $o->getValues();

                        foreach ($values as $v) {
                            if ($o->getTitle() != 'Engraving' && $v->getTitle() != '' && $o->getTitle() != 'Product_A' && $o->getTitle() != 'Product_B') {
                                if ($o->getTitle() == 'EngravingText') {
                                    $titl = 'Engraving';
                                } else {
                                    $titl = $o->getTitle();
                                }
                                $mainliarray[] = $titl . " : " . $v->getTitle();
                            } elseif ($o->getTitle() != 'Engraving' && $v->getTitle() != '' && ($o->getTitle() == 'Product_A' || $o->getTitle() == 'Product_B')) {
                                $mainarray[$o->getTitle()] = array('title' => $o->getTitle(), 'id' => $v->getTitle(), 'price' => $v->getPrice());
                            }
                        }
                    }
                    if (!empty($mainarray)) {
                        $forlistcart = "";
                        $product_url = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                        foreach ($mainarray as $mainarraydata) {
                            $Diamondproduct = Mage::getModel('catalog/product');
                            $Diamondproduct->load($mainarraydata['id']);
                            $forlistcart .='<div class="carttopmenu">';
                            $forlistcart .='<a href="' . $product_url . '">' . $Diamondproduct->getName() . '</a>';
                            
                            if ($mainarraydata['title'] == 'Product_A') {
                                $_resource = Mage::getResourceSingleton('catalog/product');
                                $pid = $mainarraydata['id'];
                                $cutval = $_resource->getAttributeRawValue($pid, 'diamond_cut', Mage::app()->getStore());
                                if ($cutval == 'H&A') {
                                    $cutval = "Signature Ideal";
                                }

                                $itemorigPrice = $mainarraydata['price'];
                                if ($_currentCurrencyCode == 'USD') {
                                    $itemorigPrice = number_format(Mage::helper('directory')->currencyConvert($itemorigPrice, 'SGD', 'USD'), 2, '.', '');
                                    $curr_prefix = 'USD ';
                                }

                                $itemconvertedPrice = Mage::helper('checkout')->formatPrice($itemorigPrice);
                                $forlistcart .='<ul>
                                    <li>Carat : ' . $_resource->getAttributeRawValue($pid, 'diamond_weight', Mage::app()->getStore()) . '</li>
                                    <li>Cut : ' . $cutval . '</li>
                                    <li>Color : ' . $_resource->getAttributeRawValue($pid, 'diamond_color', Mage::app()->getStore()) . '</li>
                                    <li>Clarity : ' . $_resource->getAttributeRawValue($pid, 'diamond_clarity', Mage::app()->getStore()) . '</li> 
                                    <li>' . $itemconvertedPrice . '</li> 
                                </ul>';
                            } else {
                                $itemorigPrice = $mainarraydata['price'];
                                if ($_currentCurrencyCode == 'USD') {
                                    $itemorigPrice = number_format(Mage::helper('directory')->currencyConvert($itemorigPrice, 'SGD', 'USD'), 2, '.', '');
                                    $curr_prefix = 'USD ';
                                }

                                $itemconvertedPrice = Mage::helper('checkout')->formatPrice($itemorigPrice);

                                $forlistcart .='<ul>';
                                if (!empty($mainliarray)) {
                                    foreach ($mainliarray as $mainliarraydata) {
                                        $forlistcart .='<li>' . $mainliarraydata . '</li>';
                                    }
                                }

                                $forlistcart .='<li>' . $itemconvertedPrice . '</li>';
                                $forlistcart .='</ul>';
                            }
                            $forlistcart .='</div>';
                        }
                    }
                } else {
                    $nameofpro = ($product->getId() == $tempProdId->getProductId() ? $item->getCustomProductName() : $product->getName());
                    $product_url = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                    $forlistcart = '<div class="carttopmenu clearfix">';

                    $forlistcart .='<a href="' . $product_url . '">' . $nameofpro . '</a>';

                    if (in_array('3', $ids)) {
                        $_resource = Mage::getResourceSingleton('catalog/product');
                        $pid = $productId;
                        $cutval = $_resource->getAttributeRawValue($pid, 'diamond_cut', Mage::app()->getStore());
                        if ($cutval == 'H&A') {
                            $cutval = "Signature Ideal";
                        }

                        $itemorigPrice = $_item->getProduct()->getFinalPrice();
                        if ($_currentCurrencyCode == 'USD') {
                            $itemorigPrice = number_format(Mage::helper('directory')->currencyConvert($itemorigPrice, 'SGD', 'USD'), 2, '.', '');
                            $curr_prefix = 'USD ';
                        }

                        $itemconvertedPrice = Mage::helper('checkout')->formatPrice($itemorigPrice);

                        $forlistcart .='<ul>
                        <li>Carat : ' . $_resource->getAttributeRawValue($pid, 'diamond_weight', Mage::app()->getStore()) . '</li>
                        <li>Cut : ' . $cutval . '</li>
                        <li>Color : ' . $_resource->getAttributeRawValue($pid, 'diamond_color', Mage::app()->getStore()) . '</li>
                        <li>Clarity : ' . $_resource->getAttributeRawValue($pid, 'diamond_clarity', Mage::app()->getStore()) . '</li> 
                        <li>' . $itemconvertedPrice . '</li> 
                    </ul>';
                    }
                    $forlistcart .='</div>';
                }

                if ($_currentCurrencyCode == 'SGD') {
                    $price = number_format($item->getCustomPrice(), 2, '.', '');
                } else if ($_currentCurrencyCode == 'USD') {
                    $price = number_format(Mage::helper('directory')->currencyConvert($item->getCustomPrice(), 'SGD', 'USD'), 2, '.', '');
                }

                $data['product_name'] = ($product->getId() == $tempProdId->getProductId() ? $item->getCustomProductName() : $product->getName());
                //$data['image_url'] = $item->getCustomProductImage();

                $data['image_url'] = (string) Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail');
                $data['product_url'] = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                $data['price'] = $price;
                $data['product_otherdetail'] = $forlistcart;
                $data['getQty'] = $item->getQty();
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
                $data['image_url'] = (string) Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail');
                $data['product_url'] = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                $data['price'] = $price;
                $data['getQty'] = $item->getQty();
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
				
				$mainitemorigPrice = $product->getFinalPrice();
				if ($_currentCurrencyCode == 'USD') {
				$mainitemorigPrice = number_format(Mage::helper('directory')->currencyConvert($mainitemorigPrice, 'SGD', 'USD'), 2, '.', '');
				$curr_prefix = 'USD ';
				}
				$mainitemconvertedPrice = Mage::helper('checkout')->formatPrice($mainitemorigPrice);
				
				
                $_product = $product;
                $ids = $_product->getCategoryIds();
                $forlistcart = "";
                if (in_array('103', $ids)) {
                    $jklm = '0';
                    $mainliarray = array();
                    foreach ($_product->getOptions() as $o) {
                        $values = $o->getValues();

                        foreach ($values as $v) {
                            if ($o->getTitle() != 'Engraving' && $v->getTitle() != '' && $o->getTitle() != 'Product_A' && $o->getTitle() != 'Product_B') {
                                if ($o->getTitle() == 'EngravingText') {
                                    $titl = 'Engraving';
                                } else {
                                    $titl = $o->getTitle();
                                }
                                $mainliarray[] = $titl . " : " . $v->getTitle();
                            } elseif ($o->getTitle() != 'Engraving' && $v->getTitle() != '' && ($o->getTitle() == 'Product_A' || $o->getTitle() == 'Product_B')) {
                                $mainarray[$o->getTitle()] = array('title' => $o->getTitle(), 'id' => $v->getTitle(), 'price' => $v->getPrice());
                            }
                        }
                    }
                    if (!empty($mainarray)) {
                        $forlistcart = "";
                        $product_url = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                        foreach ($mainarray as $mainarraydata) {
                            $Diamondproduct = Mage::getModel('catalog/product');
                            $Diamondproduct->load($mainarraydata['id']);
                            $forlistcart .='<div class="carttopmenu">';
                            $forlistcart .='<a href="' . $product_url . '">' . $Diamondproduct->getName() . '</a>';

                            if ($mainarraydata['title'] == 'Product_A') {
                                $_resource = Mage::getResourceSingleton('catalog/product');
                                $pid = $mainarraydata['id'];
                                $cutval = $_resource->getAttributeRawValue($pid, 'diamond_cut', Mage::app()->getStore());
                                if ($cutval == 'H&A') {
                                    $cutval = "Signature Ideal";
                                }

                                $itemorigPrice = $mainarraydata['price'];
                                if ($_currentCurrencyCode == 'USD') {
                                    $itemorigPrice = number_format(Mage::helper('directory')->currencyConvert($itemorigPrice, 'SGD', 'USD'), 2, '.', '');
                                    $curr_prefix = 'USD ';
                                }

                                $itemconvertedPrice = Mage::helper('checkout')->formatPrice($itemorigPrice);
                                $forlistcart .='<ul>
                                    <li>Carat : ' . $_resource->getAttributeRawValue($pid, 'diamond_weight', Mage::app()->getStore()) . '</li>
                                    <li>Cut : ' . $cutval . '</li>
                                    <li>Color : ' . $_resource->getAttributeRawValue($pid, 'diamond_color', Mage::app()->getStore()) . '</li>
                                    <li>Clarity : ' . $_resource->getAttributeRawValue($pid, 'diamond_clarity', Mage::app()->getStore()) . '</li> 
                                    <li>' . $itemconvertedPrice . '</li> 
                                </ul>';
                            } else {
                                $itemorigPrice = $mainarraydata['price'];
                                if ($_currentCurrencyCode == 'USD') {
                                    $itemorigPrice = number_format(Mage::helper('directory')->currencyConvert($itemorigPrice, 'SGD', 'USD'), 2, '.', '');
                                    $curr_prefix = 'USD ';
                                }

                                $itemconvertedPrice = Mage::helper('checkout')->formatPrice($itemorigPrice);

                                $forlistcart .='<ul>';
                                if (!empty($mainliarray)) {
                                    foreach ($mainliarray as $mainliarraydata) {
                                        $forlistcart .='<li>' . $mainliarraydata . '</li>';
                                    }
                                }

                                $forlistcart .='<li>' . $itemconvertedPrice . '</li>';
                                $forlistcart .='</ul>';
                            }
                            $forlistcart .='</div>';
                        }
                    }
                } else {
                    $nameofpro = ($product->getId() == $tempProdId->getProductId() ? $item->getCustomProductName() : $product->getName());
                    $product_url = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                    $forlistcart = '<div class="carttopmenu clearfix">';

                    $forlistcart .='<a href="' . $product_url . '">' . $nameofpro . '</a>';

                    if (in_array('3', $ids)) {
                        $_resource = Mage::getResourceSingleton('catalog/product');
                        $pid = $productId;
                        $cutval = $_resource->getAttributeRawValue($pid, 'diamond_cut', Mage::app()->getStore());
                        if ($cutval == 'H&A') {
                            $cutval = "Signature Ideal";
                        }

                        $itemorigPrice = $product->getFinalPrice();
                        if ($_currentCurrencyCode == 'USD') {
                            $itemorigPrice = number_format(Mage::helper('directory')->currencyConvert($itemorigPrice, 'SGD', 'USD'), 2, '.', '');
                            $curr_prefix = 'USD ';
                        }

                        $itemconvertedPrice = Mage::helper('checkout')->formatPrice($itemorigPrice);

                        $forlistcart .='<ul>
                        <li>Carat : ' . $_resource->getAttributeRawValue($pid, 'diamond_weight', Mage::app()->getStore()) . '</li>
                        <li>Cut : ' . $cutval . '</li>
                        <li>Color : ' . $_resource->getAttributeRawValue($pid, 'diamond_color', Mage::app()->getStore()) . '</li>
                        <li>Clarity : ' . $_resource->getAttributeRawValue($pid, 'diamond_clarity', Mage::app()->getStore()) . '</li> 
                        <li>' . $itemconvertedPrice . '</li> 
                    </ul>';
                    }
                    $forlistcart .='</div>';
                }
                $data['product_otherdetail'] = '';

                if ($_currentCurrencyCode == 'SGD') {
                    $price = number_format($item->getCustomPrice(), 2, '.', '');
                } else if ($_currentCurrencyCode == 'USD') {
                    $price = number_format(Mage::helper('directory')->currencyConvert($item->getCustomPrice(), 'SGD', 'USD'), 2, '.', '');
                }

                $proname=($product->getId() == $tempProdId->getProductId() ? $item->getCustomProductName() : $product->getName());;
                $data['product_name'] = $proname;
                //$data['image_url'] = $item->getCustomProductImage();
                 if (in_array('103', $ids)) {
                   $_images = $_product->getMediaGalleryImages();

                   if ($_images) {
                       $i = 0;
                       $_productImage = '';
                       $allimage = '';
                       foreach ($_images as $_image) {
                           $allimage .='<img src="'.Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->resize(83, 83).'" alt="'.$proname.'" title="'.$proname.'" />';
                        
                        if ($i == 1) {
                            break;
                        }
                        $i++;
                    }
                }
            } else {
                $_productImage = (string) Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail');
                $allimage ='<img src="'.$_productImage.'" alt="'.$proname.'"/>';
            }
                $data['image_url'] = $allimage;
                $data['product_url'] = ($product->getId() == $tempProdId->getProductId() ? '#' : $product->getProductUrl());
                $data['price'] = $mainitemconvertedPrice;
                $data['product_otherdetail'] = $forlistcart;
                $data['getQty'] = $item->getQty();
                $data['delete_url'] = Mage::getUrl('checkout/cart/delete', array('id' => $item->getId()));

                array_push($preparedData['other_products'], $data);
            }
        }

        $preparedData['subtotal'] = Mage::helper('checkout')->formatPrice($quote->getSubtotal());;

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($preparedData));
    }

    public function addcustomproductAction() {

        $diamondId = Mage::getSingleton('core/session')->getChoiseDiamond();
        $ringId = Mage::getSingleton('core/session')->getRingId();
        $ringData = Mage::getSingleton('core/session')->getRingData();

        if ($diamondId > 0 && $ringId > 0) {

            /* get last custom product sku-id code start from here */
            $resource = Mage::getSingleton('core/resource');

            $readConnection = $resource->getConnection('core_read');

            $query = "SELECT * from customproductid ";
            $results = $readConnection->fetchAll($query);

            $arraySort = array();

            $customProductSkuId = '';
            $max = $results[0]['id'] + 1;
            $customProductSkuId = 'custom-sku-' . $max;

            $writeConnection = $resource->getConnection('core_write');

            $query = "update customproductid set id=id+1 ";

            $writeConnection->query($query);


            //	die;
//echo   $customProductSkuId;die;
            /**//*             * ring product data get end at here */
            $ringengravingAttrbute = "";
            if ($ringData['ring_engraving'] != '') {
                $ringengravingAttrbute .= 'Engraving Text : ' . $ringData['ring_engraving'] . "/n ";
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
                    ->setUrlKey($customProductSkuId)
                    ->setStatus(1)
                    ->setTaxClassId(0)
                    ->setVisibility(3)
                    ->setStockData(array('use_config_manage_stock' => 0, 'manage_stock' => 1, 'is_in_stock' => 1, 'min_sale_qty' => 1, 'max_sale_qty' => 1, 'qty' => 5))
                    ->setCategoryIds(array(103));

            /* get last custom product sku-id code end at here */
            /*             * ring product data get from here */

            $ringproduct = Mage::getModel('catalog/product');

            $ringproduct->load($ringId);
            $ringDataVal = '';

            $ringAttrbute = '';
            $ringName = $ringproduct->getName();

            $ringWeight = $ringproduct->getWeight();

            //protected base image

            if ($ringproduct->getImage() != 'no_selection') {
                $new_full_filename = $ringproduct->getImage();
            } elseif ($ringproduct->getThumbnail() != 'no_selection') {
                $new_full_filename = $ringproduct->getThumbnail();
            } elseif ($ringproduct->getSmallImage() != 'no_selection') {
                $new_full_filename = $ringproduct->getSmallImage();
            } else {
                $new_full_filename = $ringproduct->getImage();
            }

            $ringAttrbute.='Ring Name : ' . $ringproduct->getName() . "<br> <hr>";
            $style = explode(",", $ringproduct->getStyle());

            $dataSettingValues = array(119 => 'Channel set', 122 => 'Halo', 118 => 'Pave', 120 => 'Side stone',
                117 => 'Solitare', 121 => 'Vintage');

            $ringAttrbute .= 'Style : ';

            $styleAry = array();

            foreach ($style as $val) {
                $styleAry[] = $dataSettingValues[$val];
            }

            $ringAttrbute .= '(' . implode(",", $styleAry) . ') <br>';
            $allproductdata = array();

            if ($ringproduct->getSst1Gemstone() != '') {
                $ringAttrbute .= 'Side Stone (1) Gemstone : ' . $ringproduct->getSst1Gemstone() . "<br>";
                $product->setSst1Gemstone($ringproduct->getSst1Gemstone());
            }

            if ($ringproduct->getSst1Shape() != '') {
                $ringAttrbute .= 'Side Stone (1) Shape : ' . $ringproduct->getSst1Shape() . "<br>";
                $product->setSst1Shape($ringproduct->getSst1Shape());
            }

            if ($ringproduct->getSst1NumberDiamonds() != '') {
                $ringAttrbute .= 'Side Stone (1) Number of Diamonds : '
                        . $ringproduct->getSst1NumberDiamonds() . "<br>";
                $product->setSst1NumberDiamonds($ringproduct->getSst1NumberDiamonds());
            }

            if ($ringproduct->getSst1WeightEstimated() != '') {
                $ringAttrbute .= 'Side Stone (1) Total Carat Weight Estimated : ' .
                        $ringproduct->getSst1WeightEstimated() . "<br>";
                $product->setSst1WeightEstimated($ringproduct->getSst1WeightEstimated());
            }

            if ($ringproduct->getSst1AverageColor() != '') {
                $ringAttrbute .= 'Side Stone (1) Average Color : ' .
                        $ringproduct->getSst1AverageColor() . "<br>";
                $product->setSst1AverageColor($ringproduct->getSst1AverageColor());
            }

            if ($ringproduct->getSst1AverageClarity() != '') {
                $ringAttrbute .= 'Side Stone (1) Average Clarity : ' .
                        $ringproduct->getSst1AverageClarity() . "<br>";
                $product->setSst1AverageClarity($ringproduct->getSst1AverageClarity());
            }

            if ($ringproduct->getSst1AverageCut() != '') {
                $ringAttrbute .= 'Side Stone (1) Average Cut : ' .
                        $ringproduct->getSst1AverageCut() . "<br>";
                $product->setSst1AverageCut($ringproduct->getSst1AverageCut());
            }

            if ($ringproduct->getSst2Gemstone() != '') {
                $ringAttrbute .= 'Side Stone (2) Gemstone : ' .
                        $ringproduct->getSst2Gemstone() . "<br>";
                $product->setSst2Gemstone($ringproduct->getSst2Gemstone());
            }

            if ($ringproduct->getSst2Shape() != '') {
                $ringAttrbute .= 'Side Stone (2) Shape : ' . $ringproduct->getSst2Shape() . "<br>";
                $product->setSst2Shape($ringproduct->getSst2Shape());
            }

            if ($ringproduct->getSst2NumberDiamonds() != '') {
                $ringAttrbute .= 'Side Stone (2) Number of Diamonds : '
                        . $ringproduct->getSst2NumberDiamonds() . "<br>";
                $product->setSst2NumberDiamonds($ringproduct->getSst2NumberDiamonds());
            }

            if ($ringproduct->getSst2WeightEstimated() != '') {
                $ringAttrbute .= 'Side Stone (2) Total Carat Weight Estimated : '
                        . $ringproduct->getSst2WeightEstimated() . "<br>";
                $product->setSst2WeightEstimated($ringproduct->getSst2WeightEstimated());
            }

            if ($ringproduct->getSst2AverageColor() != '') {
                $ringAttrbute .= 'Side Stone (2) Average Color : '
                        . $ringproduct->getSst2AverageColor() . "<br>";
                $product->setSst2AverageColor($ringproduct->getSst2AverageColor());
            }

            if ($ringproduct->getSst2AverageClarity() != '') {
                $ringAttrbute .= 'Side Stone (2) Average Clarity : '
                        . $ringproduct->getSst2AverageClarity() . "<br>";
                $product->setSst2AverageClarity($ringproduct->getSst2AverageClarity());
            }

            if ($ringproduct->getSst2AverageCut() != '') {
                $ringAttrbute .= 'Side Stone (2) Average Cut : '
                        . $ringproduct->getSst2AverageCut() . "<br>";
                $product->setSst2AverageCut($ringproduct->getSst2AverageCut());
            }


            if ($ringproduct->getAsscher() == 98) {
                $ringAttrbute .= 'Asscher : No <br>';
            } else {
                $ringAttrbute .= 'Asscher : Yes <br>';
            }

            $product->setAsscher($ringproduct->getAsscher());

            if ($ringproduct->getCushion() == 100) {
                $ringAttrbute .= 'Cushion : No <br>';
            } else {
                $ringAttrbute .= 'Cushion : Yes <br>';
            }

            $product->setCushion($ringproduct->getCushion());

            if ($ringproduct->getEmerald() == 102) {
                $ringAttrbute .= 'Emerald : No <br>';
            } else {
                $ringAttrbute .= 'Emerald : Yes <br>';
            }
            $product->setEmerald($ringproduct->getEmerald());

            if ($ringproduct->getHeart() == 104) {
                $ringAttrbute .= 'Heart : No <br>';
            } else {
                $ringAttrbute .= 'Heart : Yes <br>';
            }
            $product->setHeart($ringproduct->getHeart());

            if ($ringproduct->getMarquise() == 106) {
                $ringAttrbute .= 'Marquise : No <br>';
            } else {
                $ringAttrbute .= 'Marquise : Yes <br>';
            }
            $product->setMarquise($ringproduct->getMarquise());

            if ($ringproduct->getOval() == 108) {
                $ringAttrbute .= 'Oval : No <br>';
            } else {
                $ringAttrbute .= 'Oval : Yes <br>';
            }
            $product->setOval($ringproduct->getOval());

            if ($ringproduct->getPear() == 110) {
                $ringAttrbute .= 'Pear : No <br>';
            } else {
                $ringAttrbute .= 'Pear : Yes <br>';
            }
            $product->setPear($ringproduct->getPear());

            if ($ringproduct->getPrincess() == 112) {
                $ringAttrbute .= 'Princess : No <br>';
            } else {
                $ringAttrbute .= 'Princess : Yes <br>';
            }
            $product->setPrincess($ringproduct->getPrincess());

            if ($ringproduct->getRadiant() == 114) {
                $ringAttrbute .= 'Radiant : No <br>';
            } else {
                $ringAttrbute .= 'Radiant : Yes <br>';
            }
            $product->setRadiant($ringproduct->getRadiant());

            if ($ringproduct->getRound() == 116) {
                $ringAttrbute .= 'Round : No <br>';
            } else {
                $ringAttrbute .= 'Round : Yes <br>';
            }
            $product->setRound($ringproduct->getRound());

            $ringPrice = $ringproduct->getPrice();

            /* ring product details end here* */

            /* diamond product details start from here* */
            /* Diamond attrbute* */
            $Diamondproduct = Mage::getModel('catalog/product');
            $Diamondproduct->load($diamondId);
            $diamondName = $Diamondproduct->getName();
            $diamondWeight = $Diamondproduct->getWeight();
            $diamondPrc = $Diamondproduct->getPrice();

            $alloption[] = array('title' => 'Product_A', 'title_child' => $diamondId, 'price' => $diamondPrc);
            $alloption[] = array('title' => 'Product_B', 'title_child' => $ringId, 'price' => $ringPrice);

            foreach ($ringproduct->getOptions() as $o) {
                $values = $o->getValues();
                foreach ($values as $v) {
                    foreach ($ringData['options'] as $key => $value) {
                        if ($key == $v->getOptionId() && $value == $v->getOptionTypeId()) {
                            $ringDataVal .= $o->getTitle() . " : " . $v->getDefaultTitle() . "<br>";
                            $ringPrice += $v->getPrice();
                            if ($o->getTitle() == 'Engraving') {
                                $alloption[] = array('title' => $o->getTitle(), 'title_child' => $v->getDefaultTitle(), 'price' => $v->getPrice());
                                $alloption[] = array('title' => 'EngravingText', 'title_child' => $ringData['ring_engraving'], 'price' => '0.00');
                            } else {
                                $alloption[] = array('title' => $o->getTitle(), 'title_child' => $v->getDefaultTitle(), 'price' => $v->getPrice());
                            }
                        }
                    }
                }
                $i++;
            }

            $diamondAttrbute = '';
            $diamondAttrbute .= '<br>Diamond Details <br><hr>';
            if ($Diamondproduct->getDiamondPricePerCarat() != '') {
                $diamondAttrbute .= 'Diamond Price Per Carat : ' . $Diamondproduct->getDiamondPricePerCarat() . "<br>";
                $product->setDiamondPricePerCarat($Diamondproduct->getDiamondPricePerCarat());
            }

            if ($Diamondproduct->getDiamondWeight() != '') {
                $diamondAttrbute .= 'Diamond Weight : ' . $Diamondproduct->getDiamondWeight() . "<br>";
                $product->setDiamondWeight($Diamondproduct->getDiamondWeight());
            }

            if ($Diamondproduct->getDiamondTable() != '') {
                $diamondAttrbute .= 'Diamond Table : ' . $Diamondproduct->getDiamondTable() . "<br>";
                $product->setDiamondTable($Diamondproduct->getDiamondTable());
            }

            if ($Diamondproduct->getDiamondCert() != '') {
                $diamondAttrbute .= 'Diamond Cert : ' . $Diamondproduct->getDiamondCert() . "<br>";
                $product->setDiamondCert($Diamondproduct->getDiamondCert());
            }

            if ($Diamondproduct->getDiamondSupplier() != '') {
                $diamondAttrbute .= 'Diamond Supplier : ' . $Diamondproduct->getDiamondSupplier() . "<br>";
                $product->setDiamondSupplier($Diamondproduct->getDiamondSupplier());
            }

            if ($Diamondproduct->getDiamondSymmetry() != '') {
                $diamondAttrbute .= 'Diamond Symmetry : ' . $Diamondproduct->getDiamondSymmetry() . "<br>";
                $product->setDiamondSymmetry($Diamondproduct->getDiamondSymmetry());
            }

            if ($Diamondproduct->getDiamondGridle() != '') {
                $diamondAttrbute .= 'Diamond Gridle : ' . $Diamondproduct->getDiamondGridle() . "<br>";
                $product->setDiamondGridle($Diamondproduct->getDiamondGridle());
            }

            if ($Diamondproduct->getDiamondColor() != '') {
                $diamondAttrbute .= 'Diamond Color : ' . $Diamondproduct->getDiamondColor() . "<br>";
                $product->setDiamondColor($Diamondproduct->getDiamondColor());
            }

            if ($Diamondproduct->getDiamondClarity() != '') {
                $diamondAttrbute .= 'Diamond Clarity : ' . $Diamondproduct->getDiamondClarity() . "<br>";
                $product->setDiamondClarity($Diamondproduct->getDiamondClarity());
            }

            if ($Diamondproduct->getDiamondCertificateUrl() != '') {
                $diamondAttrbute .= 'Diamond Certificate Url : ' . $Diamondproduct->getDiamondCertificateUrl() . "<br>";
                $product->setDiamondCertificateUrl($Diamondproduct->getDiamondCertificateUrl());
            }

            if ($Diamondproduct->getDiamondFluorescence() != '') {
                $diamondAttrbute .= 'Diamond Fluorescence : ' . $Diamondproduct->getDiamondFluorescence() . "<br>";
                $product->setDiamondFluorescence($Diamondproduct->getDiamondFluorescence());
            }

            if ($Diamondproduct->getDiamondCut() != '') {
                $diamondAttrbute .= 'Diamond Cut : ' . $Diamondproduct->getDiamondCut() . "<br>";
                $product->setDiamondCut($Diamondproduct->getDiamondCut());
            }

            if ($Diamondproduct->getDiamondCarat() != '') {
                $diamondAttrbute .= 'Diamond Carat : ' . $Diamondproduct->getDiamondCarat() . "<br>";
                $product->setDiamondCarat($Diamondproduct->getDiamondCarat());
            }

            if ($Diamondproduct->getDiamondDepth() != '') {
                $diamondAttrbute .= 'Diamond Depth : ' . $Diamondproduct->getDiamondDepth() . "<br>";
                $product->setDiamondDepth($Diamondproduct->getDiamondDepth());
            }
            if ($Diamondproduct->getDiamondMeasurement1() != '') {
                $diamondAttrbute .= 'Diamond Measurement1 : ' . $Diamondproduct->getDiamondMeasurement1() . "<br>";
                $product->setDiamondMeasurement1($Diamondproduct->getDiamondMeasurement1());
            }

            if ($Diamondproduct->getDiamondMeasurement2() != '') {
                $diamondAttrbute .= 'Diamond Measurement2 : ' . $Diamondproduct->getDiamondMeasurement2() . "<br>";
                $product->setDiamondMeasurement2($Diamondproduct->getDiamondMeasurement2());
            }

            if ($Diamondproduct->getDiamondMeasurement3() != '') {
                $diamondAttrbute .= 'Diamond Measurement3 : ' . $Diamondproduct->getDiamondMeasurement3() . "<br>";
                $product->setDiamondMeasurement3($Diamondproduct->getDiamondMeasurement3());
            }


            if ($Diamondproduct->getDiamondDiamondModel() != '') {
                $diamondAttrbute .= 'Diamond Diamond Model : ' . $Diamondproduct->getDiamondDiamondModel() . "<br>";
                $product->setDiamondDiamondModel($Diamondproduct->getDiamondDiamondModel());
            }

            if ($Diamondproduct->getDiamondReportNumber() != '') {
                $diamondAttrbute .= 'Diamond Report Number : ' . $Diamondproduct->getDiamondReportNumber() . "<br>";
                $product->setDiamondReportNumber($Diamondproduct->getDiamondReportNumber());
            }

            if ($Diamondproduct->getDiamondPolish() != '') {
                $diamondAttrbute .= 'Diamond Polish : ' . $Diamondproduct->getDiamondPolish() . "<br>";
                $product->setDiamondPolish($Diamondproduct->getDiamondPolish());
            }

            if ($Diamondproduct->getDiamondShape() != '') {
                $diamondAttrbute .= 'Diamond Shape : ' . $Diamondproduct->getDiamondShape() . "<br>";
                $product->setDiamondShape($Diamondproduct->getDiamondShape());
            }

            $diamond_base_image = strtolower($Diamondproduct->getDiamondShape()) . '_t.jpg';
            $filepath = Mage::getBaseDir('media') . '/wysiwyg/icotheme/diamonds_pics/' . $diamond_base_image;

            if (file_exists($filepath)) {
                // get file extension 
                $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                // get file's name 
                $filename = pathinfo($filepath, PATHINFO_FILENAME);
                // get file's directory
                $directory = Mage::getBaseDir('media') . '/catalog/product/diamonds_pics';
                // add and combine the filename, iterator, extension 
                $new_filename = $filename . '_' . $max . '.' . $extension;
                // add file name to the end of the path to place it in the new directory; the while loop will check it again 
                $new_path = $directory . '/' . $new_filename;
                @copy($filepath, $new_path);
                $diamond_new_full_filename = 'diamonds_pics/' . $new_filename;
            }

            if ($Diamondproduct->getDiamondCertifiedBy() != '') {
                $diamondAttrbute .= 'Certified By : ' . $Diamondproduct->getDiamondCertifiedBy() . "<br>";
                $product->setDiamondCertifiedBy($Diamondproduct->getDiamondCertifiedBy());
            }

            if ($Diamondproduct->getDiamondSetCertifiedDetail() != '') {
                $diamondAttrbute .= 'Diamond Certified Detail : ' . $Diamondproduct->getDiamondSetCertifiedDetail() . "<br>";
                $product->setDiamondSetCertifiedDetail($Diamondproduct->getDiamondSetCertifiedDetail());
            }

            if ($Diamondproduct->getDiamondSetOrderby() != '') {
                $diamondAttrbute .= 'Order by : ' . $Diamondproduct->getDiamondSetOrderby() . "<br>";
                $product->setDiamondSetOrderby($Diamondproduct->getDiamondSetOrderby());
            }

            if ($Diamondproduct->getDiamondSetShipDate() != '') {
                $diamondAttrbute .= 'Ship date : ' . $Diamondproduct->getDiamondSetShipDate() . "<br>";
                $product->setDiamondSetShipDate($Diamondproduct->getDiamondSetShipDate());
            }

            if ($Diamondproduct->getDiamondSetFreeShipping() != '') {
                $diamondAttrbute .= 'Free shipping via : ' . $Diamondproduct->getDiamondSetFreeShipping() . "<br>";
                $product->setDiamondSetFreeShipping($Diamondproduct->getDiamondSetFreeShipping());
            }

            $dataRng = Mage::getSingleton('core/session')->getRingData();
            $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
            $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));
            $prcSetting = $ringPrice + $diamondPrc;

            $product->setName($diamondName . ' & ' . $ringName);
            $product->setWeight((int) $diamondWeight + (int) $ringWeight);
            $product->setDescription($ringAttrbute . $diamondAttrbute);
            $product->setShortDescription('Custom ring made by diamond and setting. /n Ring Engraving <hr>' . $ringengravingAttrbute);
            $product->setPrice($prcSetting);

            //echo "<pre>";
            //print_r($allproductdata);
            if ($allproductdata) {
                foreach ($allproductdata as $key => $allproductdataval) {
                    $product->$key . '(' . $allproductdataval . ')';
                }
            }

            $product->setImage($diamond_new_full_filename);
            $product->addImageToMediaGallery('media/catalog/product/' . $diamond_new_full_filename, array('image', 'thumbnail', 'small_image'), false, false); //assigning image, thumb and small image to media gallery

            $product->save();

            $value = $product->getData('small_image');
            if ($value) {
                Mage::getSingleton('catalog/product_action')
                        ->updateAttributes(array($product->getId()), array(
                            'image' => $value,
                            'small_image' => $value,
                            'thumbnail' => $value,
                                ), 0);  // 0 specifies the Default
            }


            //	$product->getResource()->save($product);
            //	$productAdd->save();
            $entityId = $product->getId();
            if ($new_full_filename != 'no_selection') {

                $newproduct = Mage::getModel('catalog/product');
                $newproduct->load($entityId);
                $newproduct->addImageToMediaGallery('media/catalog/product/' . $new_full_filename, array('image'), false, false); //assigning image, thumb and small image to media gallery
                $newproduct->save();
            }
            if (!empty($alloption)) {
                $productoption = Mage::getModel('catalog/product')->load($entityId);
                $ji = '0';
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
            try {
                $cart->addProduct($productModel, array('qty' => '1'));  //qty is hard coded
            } catch (Exception $e) {
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
            Mage::getSingleton('core/session')->unsSettingStyle();
            Mage::getSingleton('core/session')->unsLastViewedDiamondId();
            Mage::getSingleton('core/session')->unsDiamondProdId();
            Mage::getSingleton('core/session')->unsRingId();
            Mage::getSingleton('core/session')->unsRingData();
        } else {
            $this->status = false;
            $this->message = 'Bad request.';
        }

        $result = array('status' => $this->status, 'message' => $this->message);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function setRingToSettingAction() {

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

    public function gotostepAction() {
        if ($data = $this->getRequest()->getPost()) {
            switch ($data['step']) {
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
                        else
                        {
                            Mage::getSingleton('core/session')->unsSettingStyle();
                        }
						
                        $this->message = 'success';
                        $this->status = 'true';
                    } else {

                        if ($data['style']) {
                            Mage::getSingleton('core/session')->setSettingStyle($data['style']);
                        }
						else
                        {
                            Mage::getSingleton('core/session')->unsSettingStyle();
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
                    if ($data['shape']) {
                        Mage::getSingleton('core/session')->setSDiamondShape($data['shape']);
                    } else {
                        Mage::getSingleton('core/session')->unsSDiamondShape();
                    }
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

        //$result = ['status' => $this->status, 'message' => $this->message];
        $result = array('status' => $this->status, 'message' => $this->message);
        if ($url) {
            $result['url'] = $url;
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * List of params
     * product_id - product id val
     */
    public function addRingToCartAction() {
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

        //$result = ['status' => $this->status, 'message' => $this->message];
        $result = array('status' => $this->status, 'message' => $this->message);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    protected function _addDiamondToCart($diamondId) {
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
                        x));
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

    protected function _checkExistDiamondProduct($importxls_id) {
        $cart = Mage::getModel('checkout/cart')->getQuote();
        $status = true;
        foreach ($cart->getAllItems() as $item) {
            if ($item->getImportxlsId() == $importxls_id) {
                $status = false;
            }
        }

        return $status;
    }

    protected function _prepareDiamondType($diamondId) {
        $model = Mage::getModel('catalog/product')->load($diamondId);
        $shape = $model->getDiamondShape();
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

    protected function _prepareCustomOptionIds($product, $importXlsModel) {
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
