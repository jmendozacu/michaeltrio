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
        //if ($data = $this->getRequest()->getPost()) {
        if ($data = $this->getRequest()->getParams()) {   // Turn this one ON for GET request
            $page = 1;

            $preparedArr = array();

            if ($data['page']) {
                $page = (int) $data['page'];
            }

            $collection = Mage::getModel('trd_importxls/importxls')
                ->getCollection()
                ->setCurPage($page)
                ->setPageSize(100);

            if ($data['price_from'] && $data['price_to']) {
                $collection->addFieldToFilter('diamonds_price', array(
                    'from' => $data['price_from'],
                    'to' => $data['price_to'],
                ));
            }
            if ($data['carat_from'] && $data['carat_to']) {
                $collection->addFieldToFilter('carat', array(
                    'from' => $data['carat_from'],
                    'to' => $data['carat_to'],
                ));
            }
            if ($data['depth_from'] && $data['depth_to']) {
                $collection->addFieldToFilter('depth', array(
                    'from' => $data['depth_from'],
                    'to' => $data['depth_to'],
                ));
            }
            if ($data['table_from'] && $data['table_to']) {
                $collection->addFieldToFilter('table_field', array(
                    'from' => $data['table_from'],
                    'to' => $data['table_to'],
                ));
            }

            // if ($data['shape']) {
            $collection->addFieldToFilter('shape', array('in' => $data['shape']));
            // }

            if ($data['cut']) {
                $collection->addFieldToFilter('cut', array('in' => $data['cut']));
            }

            if ($data['color']) {
                $collection->addFieldToFilter('color', array('in' => $data['color']));
            }

            if ($data['clarity']) {
                $collection->addFieldToFilter('clarity', array('in' => $data['clarity']));
            }

            if ($data['polish']) {
                $collection->addFieldToFilter('polish', array('in' => $data['polish']));
            }

            if ($data['symmetry']) {
                $collection->addFieldToFilter('symmetry', array('in' => $data['symmetry']));
            }

            if ($data['fluorescence']) {
                $collection->addFieldToFilter('fluorescence', array('in' => $data['fluorescence']));
            }

            if ($data['sort'] && $data['sort_field']) {
                if ($data['sort_field'] == 'shape' || $data['sort_field'] == 'carat' || $data['sort_field'] == 'diamonds_price') {
                    $collection->setOrder($data['sort_field'], $data['sort']);
                } else {
                    $orderString = $this->_getCustomOrderString($data['sort_field'], $data['sort']);
                    $collection->getSelect()->order(new Zend_Db_Expr($orderString));
                }
            }

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();

            foreach ($collection as $model) {
                if ($_currentCurrencyCode == 'SGD') {
                    array_push($preparedArr, $model->getData());
                } else if ($_currentCurrencyCode == 'USD') {
                    $data = $model->getData();
                    $data['diamonds_price'] = number_format(Mage::helper('directory')->currencyConvert($data['diamonds_price'], 'SGD', 'USD'), 2, '.', '');
                    array_push($preparedArr, $data);
                }
            }

            $pages = $collection->getLastPageNumber();

            echo json_encode(array('data' => $preparedArr, 'pages' => $pages, 'count' => $collection->getSize()));


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

    public function filterringAction()
    {
        if ($data = $this->getRequest()->getParams()) {

            $attrSetName = 'ring';
            $attributeSetId = Mage::getModel('eav/entity_attribute_set')
                ->load($attrSetName, 'attribute_set_name')
                ->getAttributeSetId();

            $page = 1;

            if ($data['page']) {
                $page = (int) $data['page'];
            }

            //Load product model collecttion filtered by attribute set id
            $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('attribute_set_id', $attributeSetId)
                ->addAttributeToSelect('asscher')
                ->addAttributeToSelect('cushion')
                ->addAttributeToSelect('emerald')
                ->addAttributeToSelect('heart')
                ->addAttributeToSelect('marquise')
                ->addAttributeToSelect('oval')
                ->addAttributeToSelect('pear')
                ->addAttributeToSelect('princess')
                ->addAttributeToSelect('radiant')
                ->addAttributeToSelect('round')
                ->addAttributeToSelect('style')
                ->setCurPage($page)
                ->setPageSize(18);

            if ($data['price_from'] && $data['price_to']) {
                $products->addFieldToFilter('price', array(
                    'from' => $data['price_from'],
                    'to' => $data['price_to'],
                ));
            } else if( !$data['price_to'] ) {
                $products->addFieldToFilter('price', array(
                    'from' => $data['price_from'],
                ));
            }

            $allowedProducts = array();

            foreach ($products as $p) {
                if ($p->isSalable()) {
                    $allowedProducts[$p->getId()] = $p;
                }
            }

            if ($data['shape'] && is_array($data['shape'])) {
                foreach ($allowedProducts as $key => $p) {
                    $compareType = false;
                    foreach ($data['shape'] as $shape) {
                        $isShapeAllowed = $p->getAttributeText($shape);
                        if ($isShapeAllowed == 'Yes') {
                            $compareType = true;
                        }
                    }

                    if (!$compareType) {
                        unset($allowedProducts[$key]);
                    }
                }
            }

            if ($data['style'] && is_array($data['style'])) {
                foreach ($allowedProducts as $key => $p) {
                    $compareType = false;
                    foreach ($data['style'] as $style) {
                        $isStyleAllowed = $p->getAttributeText('style');
                        if (strtolower($isStyleAllowed) == strtolower($style)) {
                            $compareType = true;
                        }
                    }

                    if (!$compareType) {
                        unset($allowedProducts[$key]);
                    }
                }
            }

            $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();

            $preparedData = array();
            $preparedData['objects'] = array();
            foreach ($allowedProducts as $p) {
                $data = $p->getData();
                $data['product_image_url'] = (string) Mage::helper('catalog/image')->init($p, 'thumbnail');

                if ($_currentCurrencyCode == 'USD') {
                    $data['price'] = number_format(Mage::helper('directory')->currencyConvert($data['price'], 'SGD', 'USD'), 2, '.', '');
                }

                $data['product_full_url'] = $p->getProductUrl();

                array_push($preparedData['objects'], $data);
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

    public function sidebarInfoAction()
    {
        $data = array();
        $diamondId = Mage::getSingleton('core/session')->getChoiseDiamond();
        $stepOneUrl = Mage::getSingleton('core/session')->getStepOneUrlState();
        $diamondType = Mage::getSingleton('core/session')->getDiamondType();
        $ringId = Mage::getSingleton('core/session')->getRingId();
        $_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        $data['currency_code'] = $_currentCurrencyCode;

        $data['diamond'] = false;

        if ($diamondId) {
            $model = Mage::getModel('trd_importxls/importxls')->load($diamondId);

            $data['diamond_data'] = $model->getData();
            $data['diamond'] = true;

            if ($_currentCurrencyCode == 'USD') {
                $data['diamond_data']['diamonds_price'] = number_format(Mage::helper('directory')->currencyConvert($data['diamond_data']['diamonds_price'], 'SGD', 'USD'), 2, '.', '');
            }

            $tempProdId = Mage::getModel('trd_diamond/diamondprod')->load(1);

            $data['diamond_url'] = Mage::getBaseUrl() . 'diamond-' . $tempProdId->getProductId() . '-' . $model->getImportxlsId() . '-' . str_replace(' ', '-', strtolower($model->getDiamondsName())) . '.html';

            $data['step_one_url'] = $stepOneUrl;
            $data['diamond_type'] = $diamondType;
        }

        if ($ringId) {
            $data['ring'] = true;
            $product = Mage::getModel('catalog/product')->load($ringId);
            $origPrice = $product->getPrice();

            if ($_currentCurrencyCode == 'SGD') {
                $price = number_format($origPrice, 2, '.', '');
            } else {
                $price = number_format(Mage::helper('directory')->currencyConvert($origPrice, 'SGD', 'USD'), 2, '.', '');
            }

            $data['ring_name'] = $product->getName();
            $data['ring_price'] = $_currentCurrencyCode . ' $' . $price;
            $data['ring_price_val'] = $price;
            $data['ring_url'] = $product->getProductUrl();
            $data['ring_img'] = (string) Mage::helper('catalog/image')->init($product, 'thumbnail');
        } else {
            $data['ring'] = false;
        }

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