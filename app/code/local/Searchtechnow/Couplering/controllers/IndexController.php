<?php

class Searchtechnow_Couplering_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction($id) {

        //print_r($_GET);
        $pid = $_GET['pid'];
        if($pid=='')
        {
            $this->_redirect('/');
        }
        //$this->_title($this->__('System'))->_title($this->__('Product'));
        
        $category = Mage::getModel('catalog/category')->load(98);
        Mage::register('current_category', $category);
        Mage::getModel('catalog/layer')->setCurrentCategory($category);
        
        $_product = Mage::getModel('couplering/couplering')->load($pid);
        
        if($_product->getProductId()=='')
        {
            $this->_redirect('/');
        }
        $subcategory = Mage::getModel('catalog/category')->load($_product->getCategoryId());

        $this->loadLayout();
        // get breadcrumbs block
        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        // add first item with link
        $breadcrumbs->addCrumb(
                'home', array(
            'label' => $this->__('Home'),
            'title' => $this->__('Home'),
            'link' => Mage::getBaseUrl()
                )
        );
        // add second item without link
        $breadcrumbs->addCrumb(
                'wedding', array(
            'label' => $this->__('Wedding'),
            'title' => $this->__('Wedding')
                )
        );
        // add third item without link
        $breadcrumbs->addCrumb(
                'couple', array(
            'label' => $this->__('Couple'),
            'title' => $this->__('Couple')
                )
        );
        // add fourth item without link
        $breadcrumbs->addCrumb(
                'subcategory', array(
            'label' => $subcategory->getName(),
            'title' => $subcategory->getName()
                )
        );
        // add fifth item without link
        $breadcrumbs->addCrumb(
                'title', array(
            'label' => $_product->getTitle(),
            'title' => $_product->getTitle()
                )
        );
        $breadcrumbs->toHtml();
        $this->renderLayout();
    }

    public function sayHelloAction() {
        echo 'Hello one more time...';
    }

    public function ajaxloadproductAction() {
        $pid = $_POST['pid'];
        $_product = Mage::getModel('couplering/couplering')->load($pid);
        $p_data = array();
        $p_data['name'] = $_product->getTitle();
        $p_data['menring'] = $_product->getMenring();
        $p_data['womenring'] = $_product->getWomenring();

        if ($_product->getLogopic() != '') {
            $productimg = $_product->getLogopic();
            $productimgmain = Mage::getModel('couplering/couplering')->imgResizeCustom(100, 100, $_product->getLogopic());
            $p_data['galery'] .= '<a class="thumb-link" title="Top view"><img class="img-responsive" src="' . $productimgmain . '" alt="Top view"/></a>';
        } else {
            $productimg = 'couplering/no-image.jpg';
        }

        $setmainimg = Mage::getModel('couplering/couplering')->imgResizeCustom(500, 500, $productimg);
        $p_data['mainimg'] = '<img id="image-main" class="gallery-image visible"  src="' . $setmainimg . '"/>';

        if ($_product->getPic() != '') {
            $productimg1 = Mage::getModel('couplering/couplering')->imgResizeCustom(100, 100, $_product->getPic());
            $p_data['galery'] .= '<a class="thumb-link" title="Top view"><img class="img-responsive" src="' . $productimg1 . '" alt="Top view"/></a>';
        }

        if ($_product->getPic2() != '') {
            $productimg2 = Mage::getModel('couplering/couplering')->imgResizeCustom(100, 100, $_product->getPic2());
            $p_data['galery'] .= '<a class="thumb-link" title="Top view"><img class="img-responsive" src="' . $productimg2 . '" alt="Top view"/></a>';
        }

        echo json_encode($p_data);
    }

}
