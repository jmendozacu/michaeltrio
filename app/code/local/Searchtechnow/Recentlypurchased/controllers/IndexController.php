<?php

class Searchtechnow_Recentlypurchased_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function sayHelloAction() {
        echo 'Hello one more time...';
    }

    public function ajaxloadproductAction() {
        //$pid = '251';
		$pid = $_POST['pid'];
        $_product = Mage::getModel('recentlypurchased/recentlypurchased')->load($pid);
        $p_data = array();
        $p_data['name'] = $_product->getTitle();
        $p_data['color'] = $_product->getColour();
        $p_data['carat'] = $_product->getCarat();
        $p_data['clarity'] = $_product->getClarity();
        $p_data['cut'] = $_product->getCut();

        switch ($_product->getShape()) {
            case "AS":
                $p_data['shape'] = 'Asscher';
                break;
            case "CU":
                $p_data['shape'] = 'Cushion';
                break;
            case "EC":
                $p_data['shape'] = 'Emerald';
                break;
            case "HS":
                $p_data['shape'] = 'Heart';
                break;
            case "MQ":
                $p_data['shape'] = 'Marquise';
                break;
            case "OV":
                $p_data['shape'] = 'Oval';
                break;
            case "PR":
                $p_data['shape'] = 'Pear';
                break;
            case "PS":
                $p_data['shape'] = 'Princess';
                break;
            case "RA":
                $p_data['shape'] = 'Radiant';
                break;
            case "RD":
                $p_data['shape'] = 'Round';
                break;
        }

        $priceOptTxt = Mage::helper('directory')->currencyConvert($_product->getPrice(), 'SGD', Mage::app()->getStore()->getCurrentCurrencyCode());
        $p_data['subtotal'] = Mage::helper('core')->formatPrice($priceOptTxt, true);
        $p_data['lernurl'] = Mage::getUrl('/');

        $ring_product = Mage::getModel('catalog/product')->load($_product->getSetting());
		$p_data['settingname'] = $ring_product->getName();
		if($ring_product->getStatus()=='1')
		{
        $p_data['selecturl'] = $ring_product->getProductUrl();
		}
		else
		{
		$p_data['selecturl'] = Mage::getBaseUrl().'special-orders';
		}

        $p_data['galery'] = '';

        if ($_product->getLogopic() != '' && file_exists(Mage::getBaseDir('media') . '/'.str_replace(' ', '_', $_product->getLogopic()))) {
            $productimg = str_replace(' ', '_', $_product->getLogopic());
            $productimgmain = Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(100, 100, str_replace(' ', '_', $_product->getLogopic()));
            $setmainimg = Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(500, 500, $productimg);
			$setmainimgmain = "'".Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(500, 500, $productimg)."'";
            $p_data['galery'] .= '<a href="javascript:void(0);" onclick="changeimgrecent(' . $setmainimgmain . ');" data-srcx2="' . $setmainimg . '" class="thumb-link" title="Top view"><img class="img-responsive" src="' . $productimgmain . '" alt="Top view"/></a>';
        } else {
            $productimg = 'recentlypurchased/no-image.jpg';
			$setmainimg = Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(500, 500, $productimg);
        }

        
        $p_data['mainimg'] = '<img id="image-main" class="gallery-image visible"  src="' . $setmainimg . '"/>';


        if ($_product->getShape() != '' && $_product->getShape() != NULL) {

            $setimgm1 = Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustomshape(100, 100, 'recentlypurchased/' . strtolower($_product->getShape()) . '_t.jpg');
            $p_data['setimg'] = '<img src="' . $setimgm1 . '"/>';
        }

        if ($_product->getPic() != '' && file_exists(Mage::getBaseDir('media') . '/'.str_replace(' ', '_', $_product->getPic()))) {
            $setmainimg1 = "'".Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(500, 500, str_replace(' ', '_', $_product->getPic()))."'";
            $productimg1 = Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(100, 100, str_replace(' ', '_', $_product->getPic()));
            $p_data['galery'] .= '<a href="javascript:void(0);" onclick="changeimgrecent(' . $setmainimg1 . ');" data-srcx2="' . $setmainimg1 . '" class="thumb-link" title="Top view"><img class="img-responsive" src="' . $productimg1 . '" alt="Top view"/></a>';
        }

        if ($_product->getPic2() != '' && file_exists(Mage::getBaseDir('media') . '/'.str_replace(' ', '_', $_product->getPic2()))) {
            $setmainimg2 = "'".Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(500, 500, str_replace(' ', '_', $_product->getPic2()))."'";
			$productimg2 = Mage::getModel('recentlypurchased/recentlypurchased')->imgResizeCustom(100, 100, str_replace(' ', '_', $_product->getPic2()));
            $p_data['galery'] .= '<a href="javascript:void(0);" onclick="changeimgrecent(' . $setmainimg2 . ');" data-srcx2="' . $setmainimg2 . '" class="thumb-link" title="Top view"><img class="img-responsive" src="' . $productimg2 . '" alt="Top view"/></a>';
        }

        echo json_encode($p_data);
    }

}
