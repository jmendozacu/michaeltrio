<?PHP
class Krunal_Packer_Model_System_Config_Source_Dropdown_Values{
    public function toOptionArray()
    {
		
		$catArr = array();
		$categories = Mage::getModel('catalog/category')->getCollection()
		->addAttributeToSelect('id')
		->addAttributeToSelect('name')
		->addAttributeToSelect('url_key')
		->addAttributeToSelect('url')
		->addAttributeToSelect('is_active');
		
		foreach ($categories as $category)
		{
			if ($category->getIsActive()) { // Only pull Active categories
				$catArrT['value'] = $category->getId();
				$catArrT['label'] = $category->getName();
				$catArr[] = $catArrT;
			}
		}
		return $catArr;
    }
}