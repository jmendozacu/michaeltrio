<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/6/15
 * Time: 7:57 PM
 */ 
class Trd_Diamond_Block_Checkout_Cart_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer {

    /**
     * Get item product name
     *
     * @return string
     */
    public function getProductName()
    {
        if ($this->hasProductName()) {
            return $this->getData('product_name');
        }
        return $this->getProduct()->getName();
    }

}