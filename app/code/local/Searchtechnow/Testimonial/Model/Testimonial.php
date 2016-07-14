<?php
class Searchtechnow_Testimonial_Model_Testimonial extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('testimonial/testimonial');
    }
	
	
    public function imgResizeCustom($w,$h,$url){
	
	    $img=explode('/',$url);
		$media_dir = Mage::getBaseDir('media').DS.$img[0].DS;
		$cache_dir = $media_dir.'cache'.DS;
		$cache_url = Mage::getUrl('media').$img[0].'/cache/';
		$image = new Varien_Image($media_dir.$img[1]);
		$image->constrainOnly(true);
		$image->keepAspectRatio(true);
		$image->keepFrame(true);
		$image->keepTransparency(false);
		$image->backgroundColor(array(255,255,255));
		$image->resize($w,$h);
		$image->save($cache_dir.$w.$url);
		$url = $cache_url.$w.$url; //die;
		return $url;
		
	}
	
	public function imgResizeCustomshape($w,$h,$url){
	
	    $img=explode('/',$url);
		$media_dir = Mage::getBaseDir('media').DS.$img[0].DS.'main'.DS;
		$cache_dir = $media_dir.'cache'.DS;
		$cache_url = Mage::getUrl('media').$img[0].'/main/cache/';
		$image = new Varien_Image($media_dir.$img[1]);
		$image->constrainOnly(true);
		$image->keepAspectRatio(true);
		$image->keepFrame(true);
		$image->keepTransparency(false);
		$image->backgroundColor(array(255,255,255));
		$image->resize($w,$h);
		$image->save($cache_dir.$w.$url);
		$url = $cache_url.$w.$url; //die;
		return $url;
		
	}

}
