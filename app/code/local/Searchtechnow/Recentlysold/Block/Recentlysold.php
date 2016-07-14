<?php
class Searchtechnow_Recentlysold_Block_Recentlysold extends Mage_Core_Block_Template
{
  public function getRecentlysoldProducts() {
    $arr_products = array();	
    $products = Mage::getModel("recentlysold/recentlysold")->getRecentlysoldProducts();
    return $products;
  }
  public function getRecentlysoldMenuProducts() {
    $arr_products = array();	
    $products = Mage::getModel("recentlysold/recentlysold")->getRecentlysoldMenuProducts();
    return $products;
  }
}