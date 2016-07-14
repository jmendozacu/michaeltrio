<?php

class Searchtechnow_Couplering_Block_CoupleProduct extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {


    public function coupleproduct() {
        $category = Mage::getModel('catalog/category')->load(98);
        Mage::register('current_category', $category);
        echo Mage::registry('current_category')->getId();
        exit;
        return 'informations about my block !!';
    }

}
