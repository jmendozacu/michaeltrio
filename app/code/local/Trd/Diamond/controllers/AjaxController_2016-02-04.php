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

            $collection = Mage::getModel('catalog/product')
                            ->getCollection()
                            ->setCurPage($page)
                            ->addAttributeToSelect('*')
                            ->addAttributeToFilter('status', 1)->setPageSize(100);

            $collection->joinField('is_in_stock', 'cataloginventory/stock_item', 'is_in_stock', 'product_id=entity_id', 'is_in_stock=1', '{{table}}.stock_id=1', 'left');

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
//	echo "<br>";
//echo 	Mage::app()->getStore()->getCurrentCurrencyCode();die;

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
                
                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from']-2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to']-2, 'USD', 'SGD'));

            }
            else
            {
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
            
            if ($data['price_from'] != '0' && $data['price_to'] != '0') {
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
            foreach ($products as $p) {

                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = $p->getName();
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
                $preparedDataVal['price'] = Mage::helper('core')->currency($p->getPrice());
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
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
            $min_price--;
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
            
            if (!empty($data['style']))
            {
                $maincat_id = $data['style'];
            }

            $attributeStyleArys = array('white-gold', 'yellow-gold', 'rose-gold');
            
            if (Mage::app()->getStore()->getDefaultCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $currentRate = Mage::getModel('directory/currency')->getCurrencyRates(Mage::app()->getStore()->getCurrentCurrencyCode(), array_values($allowedCurrencies));
               
                $dataprice_from = round(Mage::helper('directory')->currencyConvert($data['price_from']-2, 'USD', 'SGD'));
                $dataprice_to = round(Mage::helper('directory')->currencyConvert($data['price_to']-2, 'USD', 'SGD'));
            }
            else
            {
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
            
            if($data['weddingstyle']=='classic')
            {
            $products->groupByAttribute('remark_val');
            $collection->groupByAttribute('remark_val');
            }
            
            if ($data['price_from'] != '0' && $data['price_to'] != '0') {
                $products->addAttributeToFilter('price', array(
                    'from' => $dataprice_from,
                    'to' => $dataprice_to,
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
            }
            else {
                $products->addAttributeToFilter('color_wedding', '115mic');
                $collection->addAttributeToFilter('color_wedding', '115mic');
            }
            
            $preparedDataVal = array();
            $preparedData = array();
            $preparedData['objects'] = array();
            $pages = $products->getLastPageNumber();
            $all_prices = array();
            
            foreach ($products as $p) {
                $preparedDataVal['entity_id'] = $p->getId();
                $preparedDataVal['name'] = $p->getName();
                $preparedDataVal['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');
                $preparedDataVal['price'] = Mage::helper('core')->currency($p->getPrice());
                $preparedDataVal['product_full_url'] = $p->getProductUrl();
                $classhtml="";
                
                if($data['weddingstyle']=='classic')
                {
                $simpleProductId = $p->getId(); 
                $product_name = $p->getName();
                $product_url = $p->getProductUrl(); 
                $remark_val= $p->getResource()->getAttribute('remark_val')->getFrontend()->getValue($p);
                $band_width= $p->getResource()->getAttribute('band_width')->getFrontend()->getValue($p);
                
                $classhtml .='<div class="main-configurable">';
                $classhtml .='<ul class="small-configurable">';
                $classhtml .='<li class="product-img-'.$simpleProductId.'" onmouseover="changedata(this);"><span class="sub-regular-price" style="display:none;">'.Mage::helper('core')->currency($p->getPrice()).'</span><span class="sub-regular-name" style="display:none;">'.$product_name.'</span><span class="sub-regular-id" style="display:none;">'.$p->getId().'</span><a href="'.$product_url.'" title="'.$product_name.'" class="product-sub-image">';
                $classhtml .='<img id="product-sub-collection-image-'.$p->getId().'" data-srcx2="'.Mage::helper('catalog/image')->init($p, 'thumbnail')->keepAspectRatio(true)->resize('270', '270').'" src="'.Mage::helper('catalog/image')->init($p, 'thumbnail')->resize('44', '36').'" class="img-responsive lazy" alt="'.$product_name.'" style="display: block;"><span class="subspan">'.$band_width.'</span></a></li>';

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
                            $band_width= $_subproduct->getResource()->getAttribute('band_width')->getFrontend()->getValue($_subproduct);
                            $classhtml .='<li class="product-img-'.$simpleProductId.'" onmouseover="changedata(this);"><span class="sub-regular-price" style="display:none;">'.Mage::helper('core')->currency($_subproduct->getPrice()).'</span><span class="sub-regular-name" style="display:none;">'.$product_name.'</span><span class="sub-regular-id" style="display:none;">'.$_subproduct->getId().'</span><a href="'.$product_url.'" title="'.$product_name.'" class="product-sub-image">';
                            $classhtml .='<img id="product-sub-collection-image-'.$_subproduct->getId().'" data-srcx2="'.Mage::helper('catalog/image')->init($_subproduct, 'thumbnail')->keepAspectRatio(true)->resize('270', '270').'" src="'.Mage::helper('catalog/image')->init($_subproduct, 'thumbnail')->resize('44', '36').'" class="img-responsive lazy" alt="'.$product_name.'" style="display: block;"><span class="subspan">'.$band_width.'</span></a></li>';
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
            $min_price--;
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



            $data['ring_name'] = $product->getName();
            $data['ring_price'] = $_currentCurrencyCode . number_format($ringPrice, 2, '.', ',');
            $data['ring_price_val'] = number_format($ringPrice, 2, '.', '');
            $data['ring_url'] = $product->getProductUrl();
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

    protected function _getCustomOrderString($field, $sort) {
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
