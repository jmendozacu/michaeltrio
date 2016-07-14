<?php

class Trd_Diamond_AjaxController extends Mage_Core_Controller_Front_Action {

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
    public function filterAction() {

        if ($data = $this->getRequest()->getParams()) {   // Turn this one ON for GET request
            $page = 1;

            $preparedArr = array();

            if ($data['page']) {
                $page = (int) $data['page'];
            }

/*            $collection = Mage::getModel('catalog/product')
                            ->getCollection()
                            ->setCurPage($page)
                            ->addAttributeToSelect('*')
                            ->addAttributeToFilter('status', 1)->setPageSize(100);*/
							
			$category_id = 3; # Change category ID here.
			
			$category = Mage::getModel('catalog/category')->load($category_id);
			
			$collection = Mage::getModel('catalog/product')
			->getCollection()
			->addAttributeToSelect('*')
			->addCategoryFilter($category)
			->addAttributeToFilter('status', 1)->setPageSize(100);				

            $collection->joinField('is_in_stock', 'cataloginventory/stock_item', 'is_in_stock', 'product_id=entity_id', 'is_in_stock=1', '{{table}}.stock_id=1', 'left');


            if ($data['price_from']!='' && $data['price_to']!='') {
                $collection->addFieldToFilter('price', array(
                    'from' => number_format($data['price_from'], 2, '.', ''),
                    'to' => number_format($data['price_to'], 2, '.', ''),
                ));
            }
            if ($data['carat_from'] && $data['carat_to']) {
                $collection->addFieldToFilter('diamond_carat', array(
                    'from' => number_format($data['carat_from'], 2, '.', ''),
                    'to' => number_format($data['carat_to'], 2, '.', ''),
                ));
            }
            if ($data['depth_from'] && $data['depth_to']) {
                $collection->addFieldToFilter('diamond_depth', array(
                    'from' => number_format($data['depth_from'], 2, '.', ''),
                    'to' => number_format($data['depth_to'], 2, '.', ''),
                ));
            }
            if ($data['table_from'] && $data['table_to']) {
                $collection->addFieldToFilter('diamond_table', array(
                    'from' => number_format($data['table_from'], 2, '.', ''),
                    'to' => number_format($data['table_to'], 2, '.', ''),
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
/*                if ($data['sort_field'] == 'diamond_shape' || $data['sort_field'] == 'diamond_carat' || $data['sort_field'] == 'diamonds_price') {
                    $collection->setOrder($data['sort_field'], $data['sort']);
                } 
				if ($data['sort_field'] == 'shape' || $data['sort_field'] == 'carat' || $data['sort_field'] == 'clarity' || $data['sort_field'] == 'cut' || $data['sort_field'] == 'polish' || $data['sort_field'] == 'symmetry' || $data['sort_field'] == 'color' || $data['sort_field'] == 'diamond_shape' || $data['sort_field'] == 'diamond_carat' || $data['sort_field'] == 'diamonds_price') {
                    
                    switch ($data['sort_field']) {
                        case "diamonds_price":
                            $shortfield = 'price';
                            break;
                        case "shape":
                            $shortfield = 'diamond_shape';
                            break;
                        case "color":
                            $shortfield = 'diamond_color';
                            break;
                        case "carat":
                            $shortfield = 'diamond_carat';
                            break;
                        case "symmetry":
                            $shortfield = 'diamond_symmetry';
                            break;
                        case "polish":
                            $shortfield = 'diamond_polish';
                            break;
                        case "cut":
                            $shortfield = 'diamond_cut';
                            break;
                        case "clarity":
                            $shortfield = 'diamond_clarity';
                            break;
                        default:
                            $shortfield = $data['sort_field'];
                    }
                    $collection->setOrder($shortfield, $data['sort']);
                }
				else {
                    $orderString = $this->_getCustomOrderString($data['sort_field'], $data['sort']);
                    $collection->getSelect()->order(new Zend_Db_Expr($orderString));
                }
				*/
				

				if ($data['sort_field'] == 'clarity' || $data['sort_field'] == 'cut' || $data['sort_field'] == 'polish' || $data['sort_field'] == 'symmetry' || $data['sort_field'] == 'color' || $data['sort_field'] == 'diamond_carat') {
                    
                    switch ($data['sort_field']) {
                        case "diamond_color":
                            $shortfield = 'color';
                            break;
                        case "diamond_carat":
                            $shortfield = 'carat';
                            break;
                        case "diamond_symmetry":
                            $shortfield = 'symmetry';
                            break;
                        case "diamond_polish":
                            $shortfield = 'polish';
                            break;
                        case "diamond_cut":
                            $shortfield = 'cut';
                            break;
                        case "diamond_clarity":
                            $shortfield = 'clarity';
                            break;
						case "cut":
                            $cut_array=array('GD','VG','EX','Signature Ideal','H&A');				            
                            //$collection->addFieldToFilter('diamond_cut', array('in' => $cut_array));
							$collection->addAttributeToFilter(
								array(
								array('attribute'=> 'diamond_cut',array('null' => true)),
								array('attribute'=> 'diamond_cut',array('in' => $cut_array)),								
								)
							);
							$shortfield = $data['sort_field'];
                            break;	
                        default:
                            $shortfield = $data['sort_field'];
                    }
					$orderString = $this->_getCustomOrderString($shortfield, $data['sort']);
                    $collection->getSelect()->order(new Zend_Db_Expr($orderString));
                }
				elseif($data['sort_field'] == 'diamonds_price'|| $data['sort_field'] == 'shape' || $data['sort_field'] == 'diamond_shape' || $data['sort_field'] == 'carat' || $data['sort_field'] == 'depth' || $data['sort_field'] == 'table_field') {
				
				    switch ($data['sort_field']) {
                        case "diamonds_price":
                            $shortfield = 'price';
                            break;
						case "diamond_shape":
                            $shortfield = 'shape';
                            break;
                        case "carat":
                            $shortfield = 'diamond_carat';
                            break;
						case "depth":
                            $shortfield = 'diamond_depth';
                            break;
						case "table_field":
                            $shortfield = 'diamond_table';
                            break;	
                        default:
                            $shortfield = $data['sort_field'];
                    }
					
                    $collection->setOrder($shortfield, $data['sort']);
                }
				else {
                    $collection->setOrder($data['sort_field'], $data['sort']);
                }
            
            }
			
			//echo  $collection->getSelect();
			$ipk="0";
            foreach ($collection as $model) {
                array_push($preparedArr, $model->getData());
				$preparedArr[$ipk]['price']=Mage::helper('core')->currency($model->getPrice());
				$ipk++;
            }
			//echo "<pre>";
            // print_r($preparedArr);die;
            /* $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();

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
//            echo "<pre>";
//            print_r($preparedArr);
//            exit;
            $pages = $collection->getLastPageNumber();
            $currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
            echo json_encode(array('data' => $preparedArr, 'pages' => $pages, 'count' => $collection->getSize(), 'currencySymbol' => $currencySymbol));
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

            $dataSettingValues = array('Solitare' => 117, 'Pave' => 118, 'Channel-set' => 119, 'Side-stone' => 120, 'Vintage' => 121, 'Halo' => 122);

            $tempStyleArray = array();
            foreach ($data['style'] as $styleVal) {
                if ($styleVal != '') {
                    $tempStyleArray[] = array('finset' => $dataSettingValues[$styleVal]);
                }
            }



            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));

                //$dataprice_from = round($data['price_to'] * $currentRate[Mage::app()->getStore()->getDefaultCurrencyCode()]);
                //$dataprice_to = round($data['price_from'] * $currentRate[Mage::app()->getStore()->getDefaultCurrencyCode()]);

                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from'] - 2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to'] - 2, 'USD', 'SGD'));
            } else {
                $dataprice_from = $data['price_from'];
                $dataprice_to = $data['price_to'];
            }

            $products = Mage::getModel('catalog/category')->load(4)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->setCurPage($page)
                    ->setPageSize($data['limiter'])
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            $collection = Mage::getModel('catalog/category')->load(4)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            if (count($_POST['style']) != 0) {
                //$preparedData['total_count'] = count($preparedData);
                //echo json_encode($preparedData);
                //die;
                $products->addAttributeToFilter('style', $tempStyleArray);
                $collection->addAttributeToFilter('style', $tempStyleArray);
            }

            if ($data['price_to'] != '0') {
                $products->addAttributeToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
                ));
            }

            if (!empty($data['shape'])) {

                foreach (array_filter($data['shape']) as $shapeVal) {
                    if ($shapeVal != '') {
                        $filter[] = array(
                            'attribute' => $shapeVal,
                            'eq' => $typeYes[$shapeVal]
                        );
                    }
                }
                
                if (!empty($filter)) {
                    $products->addAttributeToFilter($filter);
                    $collection->addAttributeToFilter($filter);
                }
            } else {
                //$products->addAttributeToFilter('round', '115mic');
            }
            if (empty($data['shape']) || count($_POST['style']) == 0) {
                $products->addAttributeToFilter('round', '115mic');
                $collection->addAttributeToFilter('round', '115mic');
            }
            $preparedDataVal = array();
            $preparedData = array();

            $preparedData['objects'] = array();

            $pages = $products->getLastPageNumber();
            $all_prices = array();
			
			$productBlock = $this->getLayout()->createBlock('catalog/product_price');
            foreach ($products as $p) {
     
                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = Mage::helper('core/string')->truncate($p->getName(), 65);
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
                $preparedDataVal['price'] = $productBlock->getPriceHtml($p);
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
				$preparedDataVal['product_data_url'] = Mage::getBaseUrl().'ajaxproducts/index/quickview/product_id/'.$p->getId();
				
                array_push($preparedData['objects'], $preparedDataVal);
                //array_push($all_prices, $p->getPrice());
            }

            foreach ($collection as $p) {
                array_push($all_prices, $p->getPrice());
            }

            $min_price = min($all_prices);
            $max_price = max($all_prices);

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            if ($_currentCurrencyCode == 'USD') {
                $min_price = Mage::helper('directory')->currencyConvert($min_price, 'SGD', 'USD');
                $max_price = Mage::helper('directory')->currencyConvert($max_price, 'SGD', 'USD');
            }
            //$min_price--;
			if ($data['price_from'] == '0' ) {
                $min_price='0';
            }
            $max_price++;

            $currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $preparedData['total_count'] = count($preparedData);
            $preparedData['currSymbol'] = $currSymbol;
            $preparedData['min_price'] = number_format($min_price, 0, '', '');
            $preparedData['max_price'] = number_format($max_price, 0, '', '');
            $preparedData['pages'] = $pages;
            $preparedData['ringTotalPages'] = $collection->count();

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }

    public function filterweddingringAction() {
        if ($data = $this->getRequest()->getParams()) {

            $page = 1;
            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();

            $typeYes = array('white-gold' => 123, 'rose-gold' => 124, 'yellow-gold' => 125);
            //$typeYes = array('white-gold' => 129, 'rose-gold' => 130, 'yellow-gold' => 131);

            $attributeId = array('asscher' => 195, 'cushion' => 196, 'emerald' => 197, 'heart' => 198, 'marquise' => 199, 'oval' => 200, 'pear' => 201, 'princess' => 202, 'radiant' => 203, 'round' => 204);

            $dataSettingValues = array('Solitare' => 117, 'Pave' => 118, 'Channel-set' => 119, 'Side-stone' => 120, 'Vintage' => 121, 'Halo' => 122);

            $tempStyleArray = array();

            if (!empty($data['style'])) {
                $maincat_id = $data['style'];
            }

            $attributeStyleArys = array('white-gold', 'yellow-gold', 'rose-gold');

            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));

                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from'] - 2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to'] - 2, 'USD', 'SGD'));
            } else {
                $dataprice_from = $data['price_from'];
                $dataprice_to = $data['price_to'];
            }

            $products = Mage::getModel('catalog/category')->load($maincat_id)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->setCurPage($page)
                    ->setPageSize($data['limiter'])
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            $collection = Mage::getModel('catalog/category')->load($maincat_id)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            if ($data['weddingstyle'] == 'classic') {
                $products->groupByAttribute('remark_val');
                $collection->groupByAttribute('remark_val');
            }

            if ($data['price_to'] != '0') {
                $products->addAttributeToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
                ));
            }
			elseif($data['price_to'] == '0' && $data['price_from'] == '0'){
                $products->addAttributeToFilter('price', array(
                    'from' => '115mic',
                    'to' => '115mic',
                ));
            }

            $tempStyleArray = array();
            foreach ($data['colours'] as $styleVal) {
                if ($styleVal != '') {
                    $tempStyleArray[] = array('finset' => $typeYes[$styleVal]);
                }
            }

            if (count($_POST['colours']) != 0) {

                $products->addAttributeToFilter('color_wedding', $tempStyleArray);
                $collection->addAttributeToFilter('color_wedding', $tempStyleArray);
                //$products->addFieldToFilter('color_wedding', array('finset' => $typeYes[$data['colours']]));
                //$collection->addFieldToFilter('color_wedding', array('finset' => $typeYes[$data['colours']]));
            } else {
                $products->addAttributeToFilter('color_wedding', '115mic');
                $collection->addAttributeToFilter('color_wedding', '115mic');
            }

            $preparedDataVal = array();
            $preparedData = array();
            $preparedData['objects'] = array();
            $pages = $products->getLastPageNumber();
            $all_prices = array();
			
            $productBlock = $this->getLayout()->createBlock('catalog/product_price');

            foreach ($products as $p) {
			
                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = Mage::helper('core/string')->truncate($p->getName(), 65);
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
                $preparedDataVal['price'] = $productBlock->getPriceHtml($p);
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
				$preparedDataVal['product_data_url'] = Mage::getBaseUrl().'ajaxproducts/index/quickview/product_id/'.$p->getId();
                $classhtml = "";

                if ($data['weddingstyle'] == 'classic') {
                    $simpleProductId = $p->getId();
                    $product_name = Mage::helper('core/string')->truncate($p->getName(), 65);
                    $product_url = $p->getProductUrl();
                    $remark_val = $p->getResource()->getAttribute('remark_val')->getFrontend()->getValue($p);
                    $band_width = $p->getResource()->getAttribute('band_width')->getFrontend()->getValue($p);

                    $classhtml .='<div class="main-configurable">';
                    $classhtml .='<ul class="small-configurable">';
                    $classhtml .='<li class="product-img-' . $simpleProductId . '" onmouseover="changedata(this);"><span class="sub-regular-price" style="display:none;">' . Mage::helper('core')->currency($p->getPrice()) . '</span><span class="sub-regular-name" style="display:none;">' . $product_name . '</span><span class="sub-regular-id" style="display:none;">' . $p->getId() . '</span><a href="' . $product_url . '" title="' . $product_name . '" class="product-sub-image">';
                    $classhtml .='<img id="product-sub-collection-image-' . $p->getId() . '" data-srcx2="' . Mage::helper('catalog/image')->init($p, 'thumbnail')->keepAspectRatio(true). '" src="' . Mage::helper('catalog/image')->init($p, 'thumbnail')->resize('29', '29') . '" class="img-responsive lazy" alt="' . $product_name . '" style="display: block;"><span class="subspan">' . $band_width . '</span></a></li>';

                    $_subproductids = Mage::getModel('catalog/category')->load($maincat_id)
                            ->getProductCollection()
                            ->addAttributeToSelect('*')
                            ->addAttributeToSort($orderby, 'asc');
                    $_subproductids->addAttributeToFilter('entity_id', array('neq' => $simpleProductId));
                    $_subproductids->addAttributeToFilter('remark_val', array('eq' => $remark_val));

                    if (!empty($_subproductids)) {
                        $small = '3';
                        foreach ($_subproductids as $_subproductid) {
                            $_subproduct = Mage::getModel('catalog/product')->load($_subproductid->getId());
                            $product_name = $_subproduct->getName();
                            $product_url = $_subproduct->getProductUrl();
                            $product_image = (string) Mage::helper('catalog/image')->init($_subproduct, 'image');
                            $band_width = $_subproduct->getResource()->getAttribute('band_width')->getFrontend()->getValue($_subproduct);
                            $classhtml .='<li class="product-img-' . $simpleProductId . '" onmouseover="changedata(this);"><span class="sub-regular-price" style="display:none;">' . Mage::helper('core')->currency($_subproduct->getPrice()) . '</span><span class="sub-regular-name" style="display:none;">' . $product_name . '</span><span class="sub-regular-id" style="display:none;">' . $_subproduct->getId() . '</span><a href="' . $product_url . '" title="' . $product_name . '" class="product-sub-image">';
                            $classhtml .='<img id="product-sub-collection-image-' . $_subproduct->getId() . '" data-srcx2="' . Mage::helper('catalog/image')->init($_subproduct, 'thumbnail')->keepAspectRatio(true). '" src="' . Mage::helper('catalog/image')->init($_subproduct, 'thumbnail')->resize('29', '29') . '" class="img-responsive lazy" alt="' . $product_name . '" style="display: block;"><span class="subspan">' . $band_width . '</span></a></li>';
                        }
                    }
                    $classhtml .="</ul></div>";
                }

                $preparedDataVal['ringclasshtml'] = $classhtml;
                array_push($preparedData['objects'], $preparedDataVal);
            }

            foreach ($collection as $p) {
                array_push($all_prices, $p->getPrice());
            }

            $min_price = min($all_prices);
            $max_price = max($all_prices);

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            if ($_currentCurrencyCode == 'USD') {
                $min_price = Mage::helper('directory')->currencyConvert($min_price, 'SGD', 'USD');
                $max_price = Mage::helper('directory')->currencyConvert($max_price, 'SGD', 'USD');
            }
            //$min_price--;
			if ($data['price_from'] == '0' ) {
                $min_price='0';
            }
            $max_price++;

            $currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $preparedData['total_count'] = count($preparedData);
            $preparedData['currSymbol'] = $currSymbol;
            $preparedData['min_price'] = number_format($min_price, 0, '', '');
            $preparedData['max_price'] = number_format($max_price, 0, '', '');
            $preparedData['pages'] = $pages;
            $preparedData['ringTotalPages'] = $collection->count();

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }

    public function filtercoupleweddingringAction() {
	
	
        if ($data = $this->getRequest()->getParams()) {
            $page = 1;
            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();

            $typeYes = array('white-gold' => 123, 'rose-gold' => 124, 'yellow-gold' => 125);
            //$typeYes = array('white-gold' => 129, 'rose-gold' => 130, 'yellow-gold' => 131);

            $attributeId = array('asscher' => 195, 'cushion' => 196, 'emerald' => 197, 'heart' => 198, 'marquise' => 199, 'oval' => 200, 'pear' => 201, 'princess' => 202, 'radiant' => 203, 'round' => 204);

            $dataSettingValues = array('Solitare' => 117, 'Pave' => 118, 'Channel-set' => 119, 'Side-stone' => 120, 'Vintage' => 121, 'Halo' => 122);

            $tempStyleArray = array();

            if (!empty($data['style'])) {
                $maincat_id = $data['style'];
            }

            $attributeStyleArys = array('white-gold', 'yellow-gold', 'rose-gold');

            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));

                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from'] - 2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to'] - 2, 'USD', 'SGD'));
            } else {
                $dataprice_from = $data['price_from'];
                $dataprice_to = $data['price_to'];
            }

            $products = Mage::getModel('couplering/couplering')->getCollection()
                    ->addFieldToFilter('status', '1')
                    ->addFieldToFilter('category_id', $maincat_id)
                    ->setCurPage($page)
                    ->setPageSize($data['limiter'])
                    ->setOrder(strtolower($data['sortby']), $data['diraction']);

            $collection = Mage::getModel('couplering/couplering')->getCollection()
                    ->addFieldToFilter('status', '1')
                    ->addFieldToFilter('category_id', $maincat_id)
                    ->setOrder(strtolower($data['sortby']), $data['diraction']);

            if ($data['price_to'] != '0') {
                $products->addFieldToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
                ));
            }
			

            $preparedDataVal = array();
            $preparedData = array();
            $preparedData['objects'] = array();
            $pages = $products->getLastPageNumber();
            $all_prices = array();
            
			//$productBlock = $this->getLayout()->createBlock('catalog/product_price');
            foreach ($products as $p) {
                $preparedDataVal['entity_id'] = $p->getProductId();
                $preparedDataVal['name'] = Mage::helper('core/string')->truncate($p->getTitle(), 65);

				$preparedDataVal['product_image_url'] = Mage::getUrl('media') . str_replace(' ', '_', $p->getLogopic());
                $preparedDataVal['price'] = Mage::helper('core')->currency($p->getPrice());
                $preparedDataVal['product_full_url'] = Mage::getBaseUrl() . 'couplering/index/view?pid=' . $p->getProductId();

                $preparedDataVal['ringclasshtml'] = $classhtml;
                array_push($preparedData['objects'], $preparedDataVal);
            }

            foreach ($collection as $p) {
                array_push($all_prices, $p->getPrice());
            }

            $min_price = min($all_prices);
            $max_price = max($all_prices);

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            if ($_currentCurrencyCode == 'USD') {
                $min_price = Mage::helper('directory')->currencyConvert($min_price, 'SGD', 'USD');
                $max_price = Mage::helper('directory')->currencyConvert($max_price, 'SGD', 'USD');
            }
            //$min_price--;
			if ($data['price_from'] == '0' ) {
                $min_price='0';
            }
            $max_price++;

            $currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $preparedData['total_count'] = count($preparedData);
            $preparedData['currSymbol'] = $currSymbol;
            $preparedData['min_price'] = number_format($min_price, 0, '', '');
            $preparedData['max_price'] = number_format($max_price, 0, '', '');
            $preparedData['pages'] = $pages;
            $preparedData['ringTotalPages'] = $collection->count();

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }

    public function filterjewellerygiftringAction() {
        if ($data = $this->getRequest()->getParams()) {

            $page = 1;
            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();

            $typeYes = array('white-gold' => 123, 'rose-gold' => 124, 'yellow-gold' => 125);
			
            //$typeMetalYes = array('14k' => 128, '18k' => 127, 'platinum' => 126);
			/* Code by aslam */
			$typeMetalYes = array('14k' => 126, '18k' => 127, 'platinum' => 128);
            //$typeYes = array('white-gold' => 129, 'rose-gold' => 130, 'yellow-gold' => 131);

            $attributeId = array('asscher' => 195, 'cushion' => 196, 'emerald' => 197, 'heart' => 198, 'marquise' => 199, 'oval' => 200, 'pear' => 201, 'princess' => 202, 'radiant' => 203, 'round' => 204);

            $dataSettingValues = array('Solitare' => 117, 'Pave' => 118, 'Channel-set' => 119, 'Side-stone' => 120, 'Vintage' => 121, 'Halo' => 122);
            $searchforcolor = 'color_metals';
			
            switch ($data['maincat']) {
                case 'necklace':
                    switch ($data['maincat_name']) {
                        case 'diamond':
                            $dataJewellSettingValues = array('Solitaire' => 134, 'Heart-Shape' => 133, 'Infinity' => 132, 'Eternity' => 131, 'Cross' => 130, 'Others' => 129);
							$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
                            $searchfor = 'pendant_types';
                            break;
                        case 'pearl':
                            $dataJewellSettingValues = array('Water' => 140, 'Akoya' => 139, 'Tahitian' => 138, 'South-Sea-Pearl' => 144);
                            $searchfor = 'pearl_types';
							$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
                            break;
						case 'gold':
						    $typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
						break;
						case 'engravable':
						    $typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
						break;									
                    }
                    break;
                case 'earrings':
                    switch ($data['maincat_name']) {
                        case 'diamond':
                            $dataJewellSettingValues = array('Fancy' => 135, 'Hoops' => 136, 'Stud' => 137, 'Others' => 145);
                            $searchfor = 'earrings_types';
							$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
                            break;
                        case 'pearl':
                            $dataJewellSettingValues = array('Water' => 140, 'Akoya' => 139, 'Tahitian' => 138, 'South-Sea-Pearl' => 144);
                            $searchfor = 'pearl_types';
							$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
                            break;
	
                    }
                    break;
                case 'bracelet':
					switch ($data['maincat_name']) {
                        case 'diamond':
                            //$dataJewellSettingValues = array('Fancy'=>135, 'Hoops'=>136, 'Stud'=>137, 'Others'=>145);
							$dataJewellSettingValues = array('Bangle'=>141, 'Tennis'=>142, 'Others'=>143);
                            $searchfor = 'bracelet_types';
							$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
                            break;
                        case 'pearl':
                            $dataJewellSettingValues = array('Water'=>140, 'Akoya'=>139, 'Tahitian'=>138, 'South Sea Pearl'=>144);
                            $searchfor = 'pearl_types';
                            break;
					    case 'gold':
						    $typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
						break;	
						case 'engravable':
						    $typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
						break;		
                    }
                    break;
			case 'jewellery-rings':
					switch ($data['maincat_name']) {
					  case 'gemstone':
						$dataJewellSettingValues = array('Emerald' => 149, 'Morganite' => 150, 'Ruby' => 151,'Shapphire' => 152, 'Tanzanite' => 153, 'Others' => 154);
						$searchfor = 'ring_gamestone';
						$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
						break;
					  case 'diamond':
						$dataJewellSettingValues = array();
						$searchfor = 'pearl_types';
						$typeYes = array('white-gold' => 123, 'rose-gold' => 124, 'yellow-gold' => 125);
						$searchforcolor = 'color_wedding';
						break;
					 case 'gold':
						$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
						break;		
						}
			        break;	
			case 'gift':
					switch ($data['maincat_name']) {
					  case 'engravable':
						$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
						break;
						}
			        break;			
            }

            $tempStyleArray = array();

            foreach ($data['style'] as $styleVal) {
                if ($styleVal != '' && !empty($dataJewellSettingValues)) {		
                    $tempStyleArray[] = array('finset' => $dataJewellSettingValues[$styleVal]);
                }
            }

            if (!empty($data['maincat_id'])) {
                $maincat_id = $data['maincat_id'];
            }

            $attributeStyleArys = array('white-gold', 'yellow-gold', 'rose-gold');

            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));

                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from'] - 2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to'] - 2, 'USD', 'SGD'));
            } else {
                $dataprice_from = $data['price_from'];
                $dataprice_to = $data['price_to'];
            }

			$products = Mage::getModel('catalog/category')->load($maincat_id)
					->getProductCollection()
					->addAttributeToSelect('*')
					->setCurPage($page)
					->setPageSize($data['limiter'])
					->addAttributeToSort(strtolower($data['sortby']), $data['diraction']);
			
            $collection = Mage::getModel('catalog/category')->load($maincat_id)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

			if ($data['maincat_name'] == 'diamond' && $data['maincat'] == 'earrings') {
				$products->groupByAttribute('remark_val');
				$collection->groupByAttribute('remark_val');
			}

            if($_POST['engravable']==false && !empty($tempStyleArray))
			{
			
				if (count($_POST['style']) != 0) {				
					$products->addAttributeToFilter($searchfor, $tempStyleArray);
					$collection->addAttributeToFilter($searchfor, $tempStyleArray);
				}
				else
				{
					$products->addAttributeToFilter('pendant_types', '115mic');
					$collection->addAttributeToFilter('pendant_types', '115mic');
				}
			}

            if ($data['price_to'] != '0') {
                $products->addAttributeToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
                ));
            }
			elseif($data['price_to'] == '0' && $data['price_from'] == '0'){
                $products->addAttributeToFilter('price', array(
                    'from' => '115mic',
                    'to' => '115mic',
                ));
            }

            $tempColorArray = array();
            foreach ($data['colours'] as $styleVal) {
                if ($styleVal != '') {
                    $tempColorArray[] = array('finset' => $typeYes[$styleVal]);
                }
            }

            $tempMetalsArray = array();
            foreach ($data['metals'] as $metalVal) {
                if ($metalVal != '') {
                    $tempMetalsArray[] = array('finset' => $typeMetalYes[$metalVal]);
                }
            }

            if (count($_POST['colours']) != 0) {
			    $products->addAttributeToFilter($searchforcolor, $tempColorArray);
                $collection->addAttributeToFilter($searchforcolor, $tempColorArray);
            } else {
                $products->addAttributeToFilter('color_metals', '115mic');
                $collection->addAttributeToFilter('color_metals', '115mic');
            }
			if($maincat_id != '108')
			{

            if (count($_POST['metals']) != 0) {
                $products->addAttributeToFilter('metals', $tempMetalsArray);
                $collection->addAttributeToFilter('metals', $tempMetalsArray);
            } else {
                $products->addAttributeToFilter('metals', '115mic');
                $collection->addAttributeToFilter('metals', '115mic');
            }
			}

		
            $preparedDataVal = array();
            $preparedData = array();
            $preparedData['objects'] = array();
            $pages = $products->getLastPageNumber();
            $all_prices = array();

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
			$currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $productBlock = $this->getLayout()->createBlock('catalog/product_price');
            foreach ($products as $p) {
                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = Mage::helper('core/string')->truncate($p->getName(), 65);
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
				$preparedDataVal['price'] = $productBlock->getPriceHtml($p);
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
				$preparedDataVal['product_data_url'] = Mage::getBaseUrl().'ajaxproducts/index/quickview/product_id/'.$p->getId();
				$EarringsTypes = explode(",", $p->getEarringsTypes());
                $classhtml = "";


				$price = $p->getPrice();
				if ($_currentCurrencyCode == 'USD') {
				  $price = Mage::helper('directory')->currencyConvert($price, 'SGD', 'USD');
				}
													
		         
				$simpleProductId = $p->getId();
				$product_name = $p->getName();
				$product_url = $p->getProductUrl();
 
                    $remark_val = $p->getResource()->getAttribute('remark_val')->getFrontend()->getValue($p);
                    $band_width = $p->getResource()->getAttribute('band_width')->getFrontend()->getValue($p);

                    
                    $_subproductids = Mage::getModel('catalog/category')->load($maincat_id)
                            ->getProductCollection()
                            ->addAttributeToSelect('*')
                            ->addAttributeToSort($orderby, 'asc');
                    $_subproductids->addAttributeToFilter('entity_id', array('neq' => $simpleProductId));
                    $_subproductids->addAttributeToFilter('remark_val', array('eq' => $remark_val));
					
					if (count($_subproductids) >0 && $data['maincat_name'] == 'diamond' && $data['maincat'] == 'earrings') {
					
                    $classhtml .='<div class="main-configurable">';
                    $classhtml .='<ul class="small-configurable">';
                    $classhtml .='<li class="product-img-' . $simpleProductId . '" onmouseover="changedata(this);"><span class="sub-regular-price" style="display:none;">' . Mage::helper('core')->currency($p->getPrice()) . '</span><span class="sub-regular-name" style="display:none;">' . $product_name . '</span><span class="sub-regular-id" style="display:none;">' . $p->getId() . '</span><a href="' . $product_url . '" title="' . $product_name . '" class="product-sub-image">';
                    $classhtml .='<img id="product-sub-collection-image-' . $p->getId() . '" data-srcx2="' . Mage::helper('catalog/image')->init($p, 'thumbnail')->keepAspectRatio(true). '" src="' . Mage::getBaseUrl() . 'media/wysiwyg/icotheme/Round1.png" class="img-responsive lazy" alt="' . $product_name . '" style="display: block;"><span class="subspan">' . $band_width . '</span></a></li>';

                    
                        $small = '3';
						$loopsmall = '2';
                        foreach ($_subproductids as $_subproductid) {
                            $_subproduct = Mage::getModel('catalog/product')->load($_subproductid->getId());
                            $product_name = $_subproduct->getName();
                            $product_url = $_subproduct->getProductUrl();
                            $product_image = (string) Mage::helper('catalog/image')->init($_subproduct, 'image');
                            $band_width = $_subproduct->getResource()->getAttribute('band_width')->getFrontend()->getValue($_subproduct);
                            $classhtml .='<li class="product-img-' . $simpleProductId . '" onmouseover="changedata(this);"><span class="sub-regular-price" style="display:none;">' . Mage::helper('core')->currency($_subproduct->getPrice()) . '</span><span class="sub-regular-name" style="display:none;">' . $product_name . '</span><span class="sub-regular-id" style="display:none;">' . $_subproduct->getId() . '</span><a href="' . $product_url . '" title="' . $product_name . '" class="product-sub-image">';
                            $classhtml .='<img id="product-sub-collection-image-' . $_subproduct->getId() . '" data-srcx2="' . Mage::helper('catalog/image')->init($_subproduct, 'thumbnail')->keepAspectRatio(true). '" src="' . Mage::getBaseUrl() . 'media/wysiwyg/icotheme/Round' . $loopsmall . '.png" class="img-responsive lazy" alt="' . $product_name . '" style="display: block;"><span class="subspan">' . $band_width . '</span></a></li>';
							
							$loopsmall++;
                        }
                    
                    $classhtml .="</ul></div>";
					}
               
				
                $preparedDataVal['ringclasshtml'] = $classhtml;
                array_push($preparedData['objects'], $preparedDataVal);
            }

            foreach ($collection as $p) {
                array_push($all_prices, $p->getPrice());
            }

            $min_price = min($all_prices);
            $max_price = max($all_prices);

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            if ($_currentCurrencyCode == 'USD') {
                $min_price = Mage::helper('directory')->currencyConvert($min_price, 'SGD', 'USD');
                $max_price = Mage::helper('directory')->currencyConvert($max_price, 'SGD', 'USD');
            }
            //$min_price--;
			if ($data['price_from'] == '0' ) {
                $min_price='0';
            }
            $max_price++;

            $currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $preparedData['total_count'] = count($preparedData);
            $preparedData['currSymbol'] = $currSymbol;
            $preparedData['min_price'] = number_format($min_price, 0, '', '');
            $preparedData['max_price'] = number_format($max_price, 0, '', '');
            $preparedData['pages'] = $pages;
            $preparedData['ringTotalPages'] = $collection->count();

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }
	
	public function filterjewellerygiftringluxuryAction() {
        if ($data = $this->getRequest()->getParams()) {

            $page = 1;
            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();

            $dataJewellSettingValues = array('Necklaces' => 27, 'Rings' => 106, 'Earrings' => 28, 'Bracelets' => 29); 
			$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
			$typeMetalYes = array('14k' => 126, '18k' => 127, 'platinum' => 128);

            $searchforcolor = 'color_metals';
			

            $tempStyleArray = array();

            foreach ($data['style'] as $styleVal) {
                if ($styleVal != '' && !empty($dataJewellSettingValues)) {		
                    $tempStyleArray[] = array('finset' => $dataJewellSettingValues[$styleVal]);
                }
            }

            if (!empty($data['maincat_id'])) {
                $maincat_id = $data['maincat_id'];
            }

            $attributeStyleArys = array('white-gold', 'yellow-gold', 'rose-gold');

            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));
				
			    if ($data['price_to'] == '0' && $data['price_from'] == '0') {
				$luxuryprice = round(Mage::helper('directory')->currencyConvert(10000 - 2, 'USD', 'SGD'));
				$under150price = round(Mage::helper('directory')->currencyConvert(150 - 2, 'USD', 'SGD'));
				}
				else
				{
                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from'] - 2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to'] - 2, 'USD', 'SGD'));
				}
				
            } else {
			  if ($data['price_to'] == '0' && $data['price_from'] == '0') {
				$luxuryprice = '10000';
				$under150price = '150';
				}
				else
				{
                $dataprice_from = $data['price_from'];
                $dataprice_to = $data['price_to'];
				}
            }

			$products = Mage::getModel('catalog/product')
				->getCollection()
				->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
				->addAttributeToSelect('*')
				->setCurPage($page)
				->addAttributeToFilter('status', 1)
				->setPageSize($data['limiter'])
				->addAttributeToSort(strtolower($data['sortby']), $data['diraction']);
				
						
			$collection = Mage::getModel('catalog/product')
				->getCollection()
				->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
				->addAttributeToSelect('*')
				->addAttributeToFilter('status', 1)
				->addAttributeToSort(strtolower($data['sortby']), $data['diraction']);
	
		
			if ($data['price_to'] == '0' && $data['price_from'] == '0') {
			   switch ($data['maincat_name']) {
                case 'gift-under-$150':
                    $products->addAttributeToFilter('price', array('lt' => $under150price));
	                $collection->addAttributeToFilter('price', array('lt' => $under150price));
                    break;
                case 'luxury':
                    $products->addAttributeToFilter('price', array('gt' => $luxuryprice));
	                $collection->addAttributeToFilter('price', array('gt' => $luxuryprice));
                    break;
                 }
			}
            elseif ($data['price_to'] != '0') {
                $products->addAttributeToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
                ));
            }
			
			if (count($_POST['style']) != 0) {				
				$products->addAttributeToFilter('category_id', $tempStyleArray);
				$collection->addAttributeToFilter('category_id', $tempStyleArray);
			}
			else
			{
				$products->addAttributeToFilter('category_id', '115mic');
				$collection->addAttributeToFilter('category_id', '115mic');
			}

            $tempColorArray = array();
            foreach ($data['colours'] as $styleVal) {
                if ($styleVal != '') {
                    $tempColorArray[] = array('finset' => $typeYes[$styleVal]);
                }
            }

            $tempMetalsArray = array();
            foreach ($data['metals'] as $metalVal) {
                if ($metalVal != '') {
                    $tempMetalsArray[] = array('finset' => $typeMetalYes[$metalVal]);
                }
            }

            if (count($_POST['colours']) != 0) {
			    $products->addAttributeToFilter($searchforcolor, $tempColorArray);
                $collection->addAttributeToFilter($searchforcolor, $tempColorArray);
            } else {
                $products->addAttributeToFilter('color_metals', '115mic');
                $collection->addAttributeToFilter('color_metals', '115mic');
            }
			if($maincat_id != '108')
			{

            if (count($_POST['metals']) != 0) {
                $products->addAttributeToFilter('metals', $tempMetalsArray);
                $collection->addAttributeToFilter('metals', $tempMetalsArray);
            } else {
                $products->addAttributeToFilter('metals', '115mic');
                $collection->addAttributeToFilter('metals', '115mic');
            }
			}
	        //echo $products->getSelect();
            $preparedDataVal = array();
            $preparedData = array();
            $preparedData['objects'] = array();
            $pages = $products->getLastPageNumber();
            $all_prices = array();

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
			$currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $productBlock = $this->getLayout()->createBlock('catalog/product_price');
            
			foreach ($products as $p) {
                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = Mage::helper('core/string')->truncate($p->getName(), 65);
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
				$preparedDataVal['price'] = $productBlock->getPriceHtml($p);
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
				$preparedDataVal['product_data_url'] = Mage::getBaseUrl().'ajaxproducts/index/quickview/product_id/'.$p->getId();
				$EarringsTypes = explode(",", $p->getEarringsTypes());
                $classhtml = "";

				$price = $p->getPrice();
				if ($_currentCurrencyCode == 'USD') {
				  $price = Mage::helper('directory')->currencyConvert($price, 'SGD', 'USD');
				}
		         
				$simpleProductId = $p->getId();
				$product_name = $p->getName();
				$product_url = $p->getProductUrl();
				
                $preparedDataVal['ringclasshtml'] = $classhtml;
                array_push($preparedData['objects'], $preparedDataVal);
            }

            foreach ($collection as $p) {
                array_push($all_prices, $p->getPrice());
            }

            $min_price = min($all_prices);
            $max_price = max($all_prices);

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            if ($_currentCurrencyCode == 'USD') {
                $min_price = Mage::helper('directory')->currencyConvert($min_price, 'SGD', 'USD');
                $max_price = Mage::helper('directory')->currencyConvert($max_price, 'SGD', 'USD');
            }
            //$min_price--;
			if ($data['price_from'] == '0' ) {
                $min_price='0';
            }
            $max_price++;

            $currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $preparedData['total_count'] = count($preparedData);
            $preparedData['currSymbol'] = $currSymbol;
            $preparedData['min_price'] = number_format($min_price, 0, '', '');
            $preparedData['max_price'] = number_format($max_price, 0, '', '');
            $preparedData['pages'] = $pages;
            $preparedData['ringTotalPages'] = $collection->count();

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }
	
	public function filterjewellerygiftsaleAction() {
        if ($data = $this->getRequest()->getParams()) {

            $page = 1;
            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();


            //$typeYes = array('white-gold' => 123, 'rose-gold' => 124, 'yellow-gold' => 125);
			$typeYes = array('white-gold' => 146, 'rose-gold' => 147, 'yellow-gold' => 148);
            //$typeMetalYes = array('14k' => 128, '18k' => 127, 'platinum' => 126);
			/* Code by aslam */
			$typeMetalYes = array('14k' => 126, '18k' => 127, 'platinum' => 128);
			

            $attributeId = array('asscher' => 195, 'cushion' => 196, 'emerald' => 197, 'heart' => 198, 'marquise' => 199, 'oval' => 200, 'pear' => 201, 'princess' => 202, 'radiant' => 203, 'round' => 204);

            $dataSettingValues = array('Solitare' => 117, 'Pave' => 118, 'Channel-set' => 119, 'Side-stone' => 120, 'Vintage' => 121, 'Halo' => 122);

            if (!empty($data['maincat_id'])) {
                $maincat_id = $data['maincat_id'];
            }

            $attributeStyleArys = array('white-gold', 'yellow-gold', 'rose-gold');

            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));

                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from'] - 2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to'] - 2, 'USD', 'SGD'));
            } else {
                $dataprice_from = $data['price_from'];
                $dataprice_to = $data['price_to'];
            }

            $products = Mage::getModel('catalog/category')->load($maincat_id)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->setCurPage($page)
                    ->setPageSize($data['limiter'])
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            $collection = Mage::getModel('catalog/category')->load($maincat_id)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')					
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            if ($data['price_to'] != '0') {
                $products->addAttributeToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
                ));
            }elseif($data['price_to'] == '0' && $data['price_from'] == '0'){
                $products->addAttributeToFilter('price', array(
                    'from' => '115mic',
                    'to' => '115mic',
                ));
            }

            $tempStyleArray = array();
            foreach ($data['colours'] as $styleVal) {
                if ($styleVal != '') {
                    $tempStyleArray[] = array('finset' => $typeYes[$styleVal]);
                }
            }

            $tempMetalsArray = array();
            foreach ($data['metals'] as $metalVal) {
                if ($metalVal != '') {
                    $tempMetalsArray[] = array('finset' => $typeMetalYes[$metalVal]);
                }
            }

            if (count($_POST['colours']) != 0) {
                $products->addAttributeToFilter('color_metals', $tempStyleArray);
                $collection->addAttributeToFilter('color_metals', $tempStyleArray);
            } else {
                $products->addAttributeToFilter('color_metals', '115mic');
                $collection->addAttributeToFilter('color_metals', '115mic');
            }

            if (count($_POST['metals']) != 0) {
                $products->addAttributeToFilter('metals', $tempMetalsArray);
                $collection->addAttributeToFilter('metals', $tempMetalsArray);
            } else {
                $products->addAttributeToFilter('metals', '115mic');
                $collection->addAttributeToFilter('metals', '115mic');
            }

            $preparedDataVal = array();
            $preparedData = array();
            $preparedData['objects'] = array();
            $pages = $products->getLastPageNumber();
            $all_prices = array();

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
			$currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $productBlock = $this->getLayout()->createBlock('catalog/product_price');
            foreach ($products as $p) {
			
                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = Mage::helper('core/string')->truncate($p->getName(), 65);
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
				$preparedDataVal['price'] = $productBlock->getPriceHtml($p);
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
				$preparedDataVal['product_data_url'] = Mage::getBaseUrl().'ajaxproducts/index/quickview/product_id/'.$p->getId();
				$EarringsTypes = explode(",", $p->getEarringsTypes());
                $classhtml = "";

				$price = $p->getPrice();
				if ($_currentCurrencyCode == 'USD') {
				  $price = Mage::helper('directory')->currencyConvert($price, 'SGD', 'USD');
				}
													
		         
				$simpleProductId = $p->getId();
				$product_name = $p->getName();
				$product_url = $p->getProductUrl();
					
                if (in_array('137', $EarringsTypes)) {
				$productss = Mage::getModel("catalog/product")->load($p->getId());

if($productss->getData('has_options')) {
                    $classhtml .='<div class="main-configurable">';
                    $classhtml .='<ul class="small-configurable">';
                    
                        $small = '3';
                        		foreach ($productss->getOptions() as $o) {
		$optionType = $o->getType();        
		if ($optionType == 'drop_down') {
		$values = $o->getValues();
		foreach ($values as $v) {   
		
		$Optionprice = $v->getPrice();
		if ($_currentCurrencyCode == 'USD') {
			$Optionprice =Mage::helper('directory')->currencyConvert($v->getPrice(), 'SGD', 'USD');
		}
		                         
                        $classhtml .='<li class="product-img-' . $simpleProductId . '" onmouseover="changedata(this);">
						<span class="sub-regular-price" style="display:none;">' . $currSymbol.number_format($price+$Optionprice, 2) . '</span><a href="' . $product_url . '?studselect='.$v->getId().'" title="' . $v->getTitle() . '" class="product-sub-image">';
                            $classhtml .='<img src="' . Mage::getUrl('media') .'wysiwyg/icotheme/'. str_replace(' ', '_', str_replace('/', '_', $v->getTitle())).'.png' . '" class="img-responsive lazy" alt="' . $product_name . '" style="width: 29px;display: block;"><span class="subspan">' . $v->getTitle() . '</span></a></li>';
							
                        }
						}
						}
                    
                    $classhtml .="</ul></div>";
                }
				
				}

                $preparedDataVal['ringclasshtml'] = $classhtml;
                array_push($preparedData['objects'], $preparedDataVal);
            }

            foreach ($collection as $p) {
                array_push($all_prices, $p->getPrice());
            }

            $min_price = min($all_prices);
            $max_price = max($all_prices);

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            if ($_currentCurrencyCode == 'USD') {
                $min_price = Mage::helper('directory')->currencyConvert($min_price, 'SGD', 'USD');
                $max_price = Mage::helper('directory')->currencyConvert($max_price, 'SGD', 'USD');
            }
            //$min_price--;
			if ($data['price_from'] == '0' ) {
                $min_price='0';
            }
            $max_price++;

            $currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $preparedData['total_count'] = count($preparedData);
            $preparedData['currSymbol'] = $currSymbol;
            $preparedData['min_price'] = number_format($min_price, 0, '', '');
            $preparedData['max_price'] = number_format($max_price, 0, '', '');
            $preparedData['pages'] = $pages;
            $preparedData['ringTotalPages'] = $collection->count();

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }
	
	public function filterfancydiamondAction() {
        if ($data = $this->getRequest()->getParams()) {

            $page = 1;
            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();

			$typeYes = array('yellow' => 175, 'pink' => 176);
			$typeShapeYes = array('round' => 166, 'cornered-square' => 167, 'cornered-rectangular' => 168,'pear' => 169, 'cushion' => 170, 'heart' => 165);
			
            if (!empty($data['maincat_id'])) {
                $maincat_id = $data['maincat_id'];
            }

            $attributeStyleArys = array('white-gold', 'yellow-gold', 'rose-gold');

            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));

                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from'] - 2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to'] - 2, 'USD', 'SGD'));
            } else {
                $dataprice_from = $data['price_from'];
                $dataprice_to = $data['price_to'];
            }
			
			$datacarat_from = $data['carat_from'];
            $datacarat_to = $data['carat_to'];

            $products = Mage::getModel('catalog/category')->load($maincat_id)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')
                    ->setCurPage($page)
                    ->setPageSize($data['limiter'])
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            $collection = Mage::getModel('catalog/category')->load($maincat_id)
                    ->getProductCollection()
                    ->addAttributeToSelect('*')					
                    ->addAttributeToSort(strtolower($data['sortby']), $data['diraction'])
                    ->setStore(Mage::app()->getStore());

            if ($data['price_to'] != '0') {
                $products->addAttributeToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
                ));
            }elseif($data['price_to'] == '0' && $data['price_from'] == '0'){
                $products->addAttributeToFilter('price', array(
                    'from' => '115mic',
                    'to' => '115mic',
                ));
            }
			
			if ($data['carat_from'] && $data['carat_to']) {
                $products->addFieldToFilter('fancy_diamond_carat', array(
                    'from' => $datacarat_from,
                    'to' => $datacarat_to,
                ));
            }

            $tempStyleArray = array();
            foreach ($data['style'] as $styleVal) {
                if ($styleVal != '') {
                    $tempStyleArray[] = array('finset' => $typeYes[$styleVal]);
                }
            }

            $tempShapesArray = array();
            foreach ($data['shape'] as $shapeVal) {
                if ($shapeVal != '') {
                    $tempShapesArray[] = array('finset' => $typeShapeYes[$shapeVal]);
                }
            }

            if (count($_POST['style']) != 0) {
                $products->addAttributeToFilter('fancy_diamond_types', $tempStyleArray);
                $collection->addAttributeToFilter('fancy_diamond_types', $tempStyleArray);
            } else {
                $products->addAttributeToFilter('fancy_diamond_types', '115mic');
                $collection->addAttributeToFilter('fancy_diamond_types', '115mic');
            }

            if (count($_POST['shape']) != 0) {
                $products->addAttributeToFilter('fancy_shape_cutting', $tempShapesArray);
                $collection->addAttributeToFilter('fancy_shape_cutting', $tempShapesArray);
            } else {
                $products->addAttributeToFilter('fancy_shape_cutting', '115mic');
                $collection->addAttributeToFilter('fancy_shape_cutting', '115mic');
            }

            $preparedDataVal = array();
            $preparedData = array();
            $preparedData['objects'] = array();
            $pages = $products->getLastPageNumber();
            $all_prices = array();
			$all_carats = array();

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
			$currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $productBlock = $this->getLayout()->createBlock('catalog/product_price');
            foreach ($products as $p) {
			
                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = Mage::helper('core/string')->truncate($p->getName(), 65);
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
				$preparedDataVal['price'] = $productBlock->getPriceHtml($p);
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
				$preparedDataVal['product_data_url'] = Mage::getBaseUrl().'ajaxproducts/index/quickview/product_id/'.$p->getId();
				$EarringsTypes = explode(",", $p->getEarringsTypes());
                $classhtml = "";

				$price = $p->getPrice();
				if ($_currentCurrencyCode == 'USD') {
				  $price = Mage::helper('directory')->currencyConvert($price, 'SGD', 'USD');
				}
													
		         
				$simpleProductId = $p->getId();
				$product_name = $p->getName();
				$product_url = $p->getProductUrl();
					
                $preparedDataVal['ringclasshtml'] = $classhtml;
                array_push($preparedData['objects'], $preparedDataVal);
            }

            foreach ($collection as $p) {
                array_push($all_prices, $p->getPrice());
            }
			foreach ($collection as $p) {
			    array_push($all_carats, trim($p->getFancyDiamondCarat()));
			}

            $min_price = min($all_prices);
            $max_price = max($all_prices);
			$minCarat = min($all_carats);
            $maxCarat = max($all_carats);

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            if ($_currentCurrencyCode == 'USD') {
                $min_price = Mage::helper('directory')->currencyConvert($min_price, 'SGD', 'USD');
                $max_price = Mage::helper('directory')->currencyConvert($max_price, 'SGD', 'USD');
            }
            //$min_price--;
			if ($data['price_from'] == '0' ) {
                $min_price='0';
            }
            $max_price++;

            $currSymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

            $preparedData['total_count'] = count($preparedData);
            $preparedData['currSymbol'] = $currSymbol;
            $preparedData['min_price'] = number_format($min_price, 0, '', '');
            $preparedData['max_price'] = number_format($max_price, 0, '', '');
			$preparedData['min_carat'] = $minCarat;
            $preparedData['max_carat'] = $maxCarat;
            $preparedData['pages'] = $pages;
            $preparedData['ringTotalPages'] = $collection->count();

            echo json_encode($preparedData);
        } else {
            echo json_encode(array('status' => 'false', 'message' => 'bad request'));
        }
    }

    public function getcoupledataAction() {
        if ($data = $this->getRequest()->getParams()) {
            //print_r($data['men_options']);
            $returndata = array();
            $mentotalamount = array();
            $womentotalamount = array();

            if (!empty($data['men_color'])) {
                $returndata['men_color'] = $data['men_color'];
                $mentotalamount[] = $data['men_color'];
            } else {
                $returndata['men_color'] = '';
            }

            if (!empty($data['men_metals'])) {
                $returndata['men_metals'] = 'Platinum <span class="price-notice">+<span class="price">' . Mage::helper('core')->currency($data['men_metals'], true, false) . '</span></span></span>';
                $mentotalamount[] = $data['men_metals'];
            } else {
                $returndata['men_metals'] = '';
            }

            if (!empty($data['men_engraving'])) {
                $returndata['men_engraving'] = 'Engraving +<span class="price">' . Mage::helper('core')->currency($data['men_engraving'], true, false) . '</span>';
                $mentotalamount[] = $data['men_engraving'];
            } else {
                $returndata['men_engraving'] = '';
            }

            if (!empty($data['men_ring_size'])) {
                $returndata['men_ring_size'] = 'Ring size +<span class="price">' . Mage::helper('core')->currency($data['men_ring_size'], true, false) . '</span>';
                $mentotalamount[] = $data['men_ring_size'];
            } else {
                $returndata['men_ring_size'] = '';
            }

            if (!empty($data['women_color'])) {
                $returndata['women_color'] = $data['women_color'];
                $womentotalamount[] = $data['women_color'];
            } else {
                $returndata['women_color'] = '';
            }
            if (!empty($data['women_metals'])) {
                $returndata['women_metals'] = 'Platinum <span class="price-notice">+<span class="price">' . Mage::helper('core')->currency($data['women_metals'], true, false) . '</span></span></span>';
                $womentotalamount[] = $data['women_metals'];
            } else {
                $returndata['women_metals'] = '';
            }

            if (!empty($data['women_engraving'])) {
                $returndata['women_engraving'] = 'Engraving +<span class="price">' . Mage::helper('core')->currency($data['women_engraving'], true, false) . '</span>';
                $womentotalamount[] = $data['women_engraving'];
            } else {
                $returndata['women_engraving'] = '';
            }

            if (!empty($data['women_ring_size'])) {
                $returndata['women_ring_size'] = 'Ring size +<span class="price">' . Mage::helper('core')->currency($data['women_ring_size'], true, false) . '</span>';
                $womentotalamount[] = $data['women_ring_size'];
            } else {
                $returndata['women_ring_size'] = '';
            }

            $menringPrice = $data['men_product_price'];
            foreach ($mentotalamount as $menperamount) {
                $menringPrice += $menperamount;
            }

            $womenringPrice = $data['women_product_price'];
            foreach ($womentotalamount as $womenperamount) {
                $womenringPrice += $womenperamount;
            }
            $returndata['couple_women_price'] = '<span class="price">' . Mage::helper('core')->currency($womenringPrice, true, false) . '</span>';
            $returndata['couple_men_price'] = '<span class="price">' . Mage::helper('core')->currency($menringPrice, true, false) . '</span>';
            $returndata['couple_womenmen_price'] = '<span class="price">' . Mage::helper('core')->currency($womenringPrice + $menringPrice, true, false) . '</span>';

            echo json_encode($returndata);
        }
    }
    public function getmendataAction() {
        if ($data = $this->getRequest()->getParams()) {
            //print_r($data['men_options']);
            $returndata = array();
            $mentotalamount = array();

            if (!empty($data['men_color'])) {
                $returndata['men_color'] = $data['men_color'];
                $mentotalamount[] = $data['men_color'];
            } else {
                $returndata['men_color'] = '';
            }

            if (!empty($data['men_metals'])) {
                $returndata['men_metals'] = 'Platinum <span class="price-notice">+<span class="price">' . Mage::helper('core')->currency($data['men_metals'], true, false) . '</span></span></span>';
                $mentotalamount[] = $data['men_metals'];
            } else {
                $returndata['men_metals'] = '';
            }

            if (!empty($data['men_engraving'])) {
                $returndata['men_engraving'] = 'Engraving +<span class="price">' . Mage::helper('core')->currency($data['men_engraving'], true, false) . '</span>';
                $mentotalamount[] = $data['men_engraving'];
            } else {
                $returndata['men_engraving'] = '';
            }

            if (!empty($data['men_ring_size'])) {
                $returndata['men_ring_size'] = 'Ring size +<span class="price">' . Mage::helper('core')->currency($data['men_ring_size'], true, false) . '</span>';
                $mentotalamount[] = $data['men_ring_size'];
            } else {
                $returndata['men_ring_size'] = '';
            }
            $menringPrice = $data['men_product_price'];
            foreach ($mentotalamount as $menperamount) {
                $menringPrice += $menperamount;
            }
            
            $returndata['men_price'] = '<span class="price">' . Mage::helper('core')->currency($menringPrice, true, false) . '</span>';
            echo json_encode($returndata);
        }
    }
    public function getwomendataAction() {
        if ($data = $this->getRequest()->getParams()) {
            //print_r($data['men_options']);
            $returndata = array();
            $womentotalamount = array();

            if (!empty($data['women_color'])) {
                $returndata['women_color'] = $data['women_color'];
                $womentotalamount[] = $data['women_color'];
            } else {
                $returndata['women_color'] = '';
            }
            if (!empty($data['women_metals'])) {
                $returndata['women_metals'] = 'Platinum <span class="price-notice">+<span class="price">' . Mage::helper('core')->currency($data['women_metals'], true, false) . '</span></span></span>';
                $womentotalamount[] = $data['women_metals'];
            } else {
                $returndata['women_metals'] = '';
            }

            if (!empty($data['women_engraving'])) {
                $returndata['women_engraving'] = 'Engraving +<span class="price">' . Mage::helper('core')->currency($data['women_engraving'], true, false) . '</span>';
                $womentotalamount[] = $data['women_engraving'];
            } else {
                $returndata['women_engraving'] = '';
            }

            if (!empty($data['women_ring_size'])) {
                $returndata['women_ring_size'] = 'Ring size +<span class="price">' . Mage::helper('core')->currency($data['women_ring_size'], true, false) . '</span>';
                $womentotalamount[] = $data['women_ring_size'];
            } else {
                $returndata['women_ring_size'] = '';
            }

            $womenringPrice = $data['women_product_price'];
            foreach ($womentotalamount as $womenperamount) {
                $womenringPrice += $womenperamount;
            }
            $returndata['women_price'] = '<span class="price">' . Mage::helper('core')->currency($womenringPrice, true, false) . '</span>';

            echo json_encode($returndata);
        }
    }

    public function getSelectedDiamondAction() {
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

    public function sidebarInfoAction() {

        $data = array();
        $diamondId = Mage::getSingleton('core/session')->getChoiseDiamond();
        $stepOneUrl = Mage::getSingleton('core/session')->getStepOneUrlState();
        $diamondType = Mage::getSingleton('core/session')->getDiamondType();
        $ringId = Mage::getSingleton('core/session')->getRingId();
        //   $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        //  $data['currency_code'] = $_currentCurrencyCode;
        $_currentCurrencyCode = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
        $data['diamond'] = false;

        if ($diamondId) {
            $product = Mage::getModel('catalog/product')->load($diamondId);

            //  $data['diamond_data'] = $model->getData();
            $data['diamond'] = true;
            $data['diamond_data']['diamonds_name'] = $product->getName();
            $data['diamond_data']['diamonds_model'] = $product->getSku();
            $data['diamond_data']['diamonds_price'] = Mage::helper('core')->currency($product->getPrice());
            $data['diamond_data']['diamonds_weight'] = round($product->getDiamondCarat(), 2);
            $data['diamond_data']['shape'] = $product->getDiamondShape();
            $data['diamond_url'] = $product->getProductUrl();

            $data['step_one_url'] = $stepOneUrl;
            $data['diamond_type'] = $diamondType;

            $data['diamonds_price_val'] = Mage::helper('core')->currency($product->getPrice(), false, false);
        }

        if ($ringId) {
            $data['ring'] = true;
            $product = Mage::getModel('catalog/product')->load($ringId);
            //  $origPrice = $product->getPrice();

            /**/
            $ringData = Mage::getSingleton('core/session')->getRingData();

            $ringPrice = Mage::helper('core')->currency($product->getPrice(), false, false);

            foreach ($product->getOptions() as $o) {
                $values = $o->getValues();
                foreach ($values as $v) {
                    foreach ($ringData['options'] as $key => $value) {
                        if ($key == $v->getOptionId() && $value == $v->getOptionTypeId()) {
                            $ringPrice += Mage::helper('core')->currency($v->getPrice(), false, false);
                        }
                    }
                }
                $i++;
            }

/*$bstn=1;
            foreach ($product->getMediaGalleryImages() as $_image)
            {
                $ring_img= Mage::helper('catalog/image')->init($product, 'image', $_image->getFile());
                break;
            }*/

            $data['ring_name'] = $product->getName();
            $data['ring_price'] = $_currentCurrencyCode . number_format($ringPrice, 2, '.', ',');
            $data['ring_price_val'] = number_format($ringPrice, 2, '.', '');
            $data['ring_url'] = $product->getProductUrl();
			//$data['ring_img'] = (string) $ring_img;
            $data['ring_img'] = (string) Mage::helper('catalog/image')->init($product, 'thumbnail');
            
        } else {
            $data['ring'] = false;
        }

        $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
        $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));




        $finalPrc = $ringPrice + $data['diamonds_price_val'];
        //	echo Mage::helper('directory')->currencyConvert($ringPrice, 'USD', 'SGD');
        /* echo Mage::helper('core')->currency($ringPrice,true,false);echo "<br>";
          echo Mage::helper('core')->currency($ringPrice,true,true);echo "<br>";
          echo Mage::helper('core')->currency($ringPrice,false,true);echo "<br>";
         */
        $data['totalprice'] = $_currentCurrencyCode . number_format($finalPrc, 2, '.', ',');
        echo json_encode($data);
    }

    public function leftfilterbarchkAction() {
        $data = array();

        $selectedDiamondType = Mage::getSingleton('core/session')->getDiamondType();
        if ($selectedDiamondType == '') {
            $attributeStyleArys = array('round', 'princess', 'emerald', 'heart', 'pear', 'cushion', 'radiant', 'oval', 'asscher', 'marquise');
            $data['diamond'] = true;
            $shape_list = '';
            foreach ($attributeStyleArys as $key => $value) {
                $data['shape_list_' . $key] = strtolower($value);
            }

            $dataSettingValues = array(117 => 'Solitare', 118 => 'Pave', 119 => 'Channel set', 120 => 'Side stone', 121 => 'Vintage', 122 => 'Halo');
            foreach ($dataSettingValues as $key => $value) {
                $data['style_list']['style_list_' . $key] = str_replace(" ", "-", $value);
            }
        } else {
            $data['diamond'] = false;
        }
        echo json_encode($data);
    }

    public function removeDiamondAction() {
        Mage::getSingleton('core/session')->unsChoiseDiamond();
        Mage::getSingleton('core/session')->unsDiamondStep();
        Mage::getSingleton('core/session')->unsStepOneUrlState();
        Mage::getSingleton('core/session')->unsLastViewedDiamondId();
        Mage::getSingleton('core/session')->unsDiamondProdId();
        Mage::getSingleton('core/session')->unsDiamondType();

        echo json_encode(array('status' => 'true', 'message' => 'Successfully Removed.'));
    }

    public function removeSettingAction() {
        Mage::getSingleton('core/session')->unsRingId();
        Mage::getSingleton('core/session')->unsRingData();
        echo json_encode(array('status' => 'true', 'message' => 'Successfully Removed.'));
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

/*    protected function _getCustomOrderString($field, $sort) {
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
    }*/
	
	protected function _getCustomOrderString($field, $sort) {
        $query = '';
        switch (strtolower($field)) {
            case 'cut':
                $query = "CASE WHEN `at_diamond_cut`.`value`='' THEN 'a' WHEN `at_diamond_cut`.`value`='GD' THEN 'b' WHEN `at_diamond_cut`.`value`='VG' THEN 'c' WHEN `at_diamond_cut`.`value`='EX' THEN 'd' WHEN `at_diamond_cut`.`value`='Signature Ideal' THEN 'e' WHEN `at_diamond_cut`.`value`='H&A' THEN 'e' END " . $sort;
                break;
            case 'color':
                $query = "CASE WHEN `at_diamond_color`.`value`='K' THEN 'a' WHEN `at_diamond_color`.`value`='J' THEN 'b' WHEN `at_diamond_color`.`value`='I' THEN 'c' WHEN `at_diamond_color`.`value`='H' THEN 'd' WHEN `at_diamond_color`.`value`='G' THEN 'e' WHEN `at_diamond_color`.`value`='F' THEN 'g' WHEN `at_diamond_color`.`value`='E' THEN 'h' WHEN `at_diamond_color`.`value`='D' THEN 'i' END " . $sort;
                break;
            case 'clarity':
                $query = "CASE WHEN `at_diamond_clarity`.`value`='SI2' THEN 'a' WHEN `at_diamond_clarity`.`value`='SI1' THEN 'b' WHEN `at_diamond_clarity`.`value`='VS2' THEN 'c' WHEN `at_diamond_clarity`.`value`='VS1' THEN 'd' WHEN `at_diamond_clarity`.`value`='VVS2' THEN 'e' WHEN `at_diamond_clarity`.`value`='VVS1' THEN 'f' WHEN `at_diamond_clarity`.`value`='IF' THEN 'g' WHEN `at_diamond_clarity`.`value`='FL' THEN 'h' END " . $sort;
                break;
            case 'polish':
                $query = "CASE WHEN `at_diamond_polish`.`value`='GD' THEN 'a' WHEN `at_diamond_polish`.`value`='VG' THEN 'b' WHEN `at_diamond_polish`.`value`='EX' THEN 'c' END " . $sort;
                break;
            case 'symmetry':
                $query = "CASE WHEN `at_diamond_symmetry`.`value`='GD' THEN 'a' WHEN `at_diamond_symmetry`.`value`='VG' THEN 'b' WHEN `at_diamond_symmetry`.`value`='EX' THEN 'c' END " . $sort;
                break;
            case 'fluorescence':
                $query = "CASE WHEN `at_diamond_fluorescence`.`value`='none' THEN 'a' WHEN `at_diamond_fluorescence`.`value`='faint' THEN 'b' WHEN `at_diamond_fluorescence`.`value`='medium' THEN 'c' WHEN `at_diamond_fluorescence`.`value`='strong' THEN 'd' WHEN `at_diamond_fluorescence`.`value`='extreme' THEN 'e' END " . $sort;
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


    protected function _findFromTo($allValues, $from, $to) {
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
