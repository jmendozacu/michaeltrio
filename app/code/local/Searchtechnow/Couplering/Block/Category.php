<?php
class Searchtechnow_Couplering_Block_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{	
	public function render(Varien_Object $row)
	{
		$categoryId =  $row->getData($this->getColumn()->getIndex());
		$category =  Mage::getModel('catalog/category')->load($categoryId);		
		$value = $category->getName();
		return $value;
	}
}