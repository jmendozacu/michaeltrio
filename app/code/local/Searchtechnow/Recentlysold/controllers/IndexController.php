<?php
class Searchtechnow_Recentlysold_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		 $this->loadLayout();
    	 $this->renderLayout();
    }
	public function ajaxloadproductAction()
    {
		 $pid = $_POST['pid'];
		 $_product = Mage::getModel('catalog/product')->load($pid);
		 $p_data = array();
		 $p_data['name'] = $_product->getName();
		 $p_data['sku'] = $_product->getSku();
		 //$p_data['setimg'] = $_product->getDiamondSetImage();
		 
		 $p_data['color'] = $_product->getDiamondColor();
		 $p_data['carat'] = $_product->getDiamondCarat();
		 $p_data['depth'] = $_product->getDiamondDepth();
		 $p_data['polish'] = $_product->getDiamondPolish();
		 $p_data['shape'] = $_product->getDiamondShape();
		 $p_data['subtotal'] = Mage::helper('core')->formatPrice($_product->getPrice(), true);
		 $p_data['lernurl'] = Mage::getUrl('/');
		 $p_data['selecturl'] = Mage::getUrl('/');
		 if($p_data['shape'] != '' && $p_data['shape'] != NULL){
			 $m1 = strtolower($p_data['shape']).'_t.jpg';
			 $setimgm1 = Mage::getModel('recentlysold/recentlysold')->imgResizeCustm(100,100,$m1);
			 $m1 = Mage::getModel('recentlysold/recentlysold')->imgResizeCustm(500,500,$m1);
			 
			 $p_data['mainimg'] = '<img id="image-main" class="gallery-image visible"  src="'.$m1.'"/>';
			 $p_data['setimg']= '<img src="'.$setimgm1.'"/>';	 
		 
		 } else {
		 	 $p_data['mainimg'] = '<img id="image-main" class="gallery-image visible"  src="'.Mage::helper('catalog/image')->init($_product, 'image')->resize(500, 500).'"/>';  
			 $p_data['setimg']= '<img src="'.Mage::helper('catalog/image')->init($_product, 'image')->resize(100, 100).'"/>';
		 }
		 $p_data['galery'] = '';
		 $i=0;
		 if($p_data['shape'] != '' && $p_data['shape'] != NULL){
				 $g1 = strtolower($p_data['shape']).'_t.jpg';
				 $g2 = strtolower($p_data['shape']).'_s.jpg';
				 $g1 = Mage::getModel('recentlysold/recentlysold')->imgResizeCustm(100,100,$g1);
				 $g2 = Mage::getModel('recentlysold/recentlysold')->imgResizeCustm(100,100,$g2);
				 $p_data['galery'] .= '<a class="thumb-link" title="Top view"><img class="img-responsive" src="'.$g1.'" alt="Top view"/></a>';
				 $p_data['galery'] .= '<a class="thumb-link" title="Side View"><img class="img-responsive" src="'.$g2.'" alt="Side View"/></a>';
		 } else {
			foreach ($_product->getGalleryImages() as $_image) {
				 $i++;
				 $p_data['galery'] .= '<a class="thumb-link" title="'.Mage::escapeHtml($_image->getLabel()).'" data-image-index="'.$i.'"><img class="img-responsive" src="'.Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->resize(100, 100).'" alt="'.Mage::escapeHtml($_image->getLabel()).'"/></a>';
			}
 
		 }
		 echo json_encode($p_data);
    }	
}