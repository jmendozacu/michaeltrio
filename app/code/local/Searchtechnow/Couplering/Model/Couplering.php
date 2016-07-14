<?php

class Searchtechnow_Couplering_Model_Couplering extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('couplering/couplering');
    }

    public function imgResizeCustom($w, $h, $url) {

        $img = explode('/', $url);
        
        $media_dir = Mage::getBaseDir('media') . DS . $img[0] . DS;
        $cache_dir = $media_dir . 'cache' . DS;
        $cache_url = Mage::getUrl('media') . $img[0] . '/cache/';
        $image = new Varien_Image($media_dir . $img[1]);
        $image->constrainOnly(true);
        $image->keepAspectRatio(true);
        $image->keepFrame(true);
        $image->keepTransparency(false);
        $image->backgroundColor(array(255, 255, 255));
        $image->resize($w, $h);
        $image->save($cache_dir . $w . $url);
        $url = $cache_url . $w . $url; //die;
        return $url;
    }

    public function imgResizeCustomshape($w, $h, $url) {

        $img = explode('/', $url);
        $media_dir = Mage::getBaseDir('media') . DS . $img[0] . DS . 'main' . DS;
        $cache_dir = $media_dir . 'cache' . DS;
        $cache_url = Mage::getUrl('media') . $img[0] . '/main/cache/';
        $image = new Varien_Image($media_dir . $img[1]);
        $image->constrainOnly(true);
        $image->keepAspectRatio(true);
        $image->keepFrame(true);
        $image->keepTransparency(false);
        $image->backgroundColor(array(255, 255, 255));
        $image->resize($w, $h);
        $image->save($cache_dir . $w . $url);
        $url = $cache_url . $w . $url; //die;
        return $url;
    }
	
	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

}
