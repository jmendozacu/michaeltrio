<?php
/**
 * @package   Codewix_IPbasedDevmode
 * @author    Ravinder <codewix@gmail.com>
 */

class Codewix_IpbasedDevmode_Model_Observer {

    public function controller_action_predispatch($observer) {
        $helper = Mage::helper('ipbaseddevmode');
        if($helper->getConfig('enable')) {
            $enable = false;
            $ip = $helper->getConfig('ip');
            if(!empty($ip)) {
                $ip = explode(',',$helper->getConfig('ip'));
                $userIp = $_SERVER['REMOTE_ADDR'];
                if(in_array($userIp,$ip)) {
                    $enable=true;
                }
            } else {
                $enable = true;
            }
            $useParam = $helper->getConfig('useparam');
            if($useParam) {
                $param = $helper->getConfig('param');
                $value = Mage::app()->getRequest()->getParam($param);
                if($value == 'true') {
                    $enable=true;;
                } else{
                    $enable=false;
                }
            }
            if($enable) {
                Mage::setIsDeveloperMode(true);
            }

        }

    }

}