<?php
class Searchtechnow_Couplering_Block_Product extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{	
	public function render(Varien_Object $row)
	{
		$productId =  $row->getData($this->getColumn()->getIndex());
		$product = Mage::getModel('catalog/product')->load($productId);		
		$value = $product->getName();
		return $value;
	}
}