<?php

/* AITOC static rewrite inserts start */
/* $meta=%default,AdjustWare_Deliverydate,AdjustWare_Notification,Aitoc_Aitcheckoutfields% */
if(Mage::helper('core')->isModuleEnabled('Aitoc_Aitcheckoutfields')){
    class Aitoc_Aitpreorder_Model_Rewrite_SalesOrder_Aittmp extends Aitoc_Aitcheckoutfields_Model_Rewrite_FrontSalesOrder {} 
 }elseif(Mage::helper('core')->isModuleEnabled('AdjustWare_Notification')){
    class Aitoc_Aitpreorder_Model_Rewrite_SalesOrder_Aittmp extends AdjustWare_Notification_Model_Rewrite_Sales_Order {} 
 }elseif(Mage::helper('core')->isModuleEnabled('AdjustWare_Deliverydate')){
    class Aitoc_Aitpreorder_Model_Rewrite_SalesOrder_Aittmp extends AdjustWare_Deliverydate_Model_Rewrite_FrontSalesOrder {} 
 }else{
    /* default extends start */
    class Aitoc_Aitpreorder_Model_Rewrite_SalesOrder_Aittmp extends Mage_Sales_Model_Order {}
    /* default extends end */
}

/* AITOC static rewrite inserts end */
class Aitoc_Aitpreorder_Model_Rewrite_SalesOrder extends Aitoc_Aitpreorder_Model_Rewrite_SalesOrder_Aittmp {

    // overwrite parent
    public function addStatusHistoryComment($comment, $status = false)
    {
        if (false === $status) {
            $status = $this->getStatus();
        } elseif (true === $status) {
            $status = $this->getConfig()->getStateDefaultStatus($this->getState());
        } else {
            $this->setStatus($status);
        }

        $tmpstatus = $status;

        $order = $this;
        $orderStatus = $status;
        $haveregular = 0;

        if (($orderStatus == 'processingpreorder') || ($orderStatus == 'processing') || ($orderStatus == 'complete')) {
            $_items = $order->getItemsCollection();
            $haveregular = Mage::helper('aitpreorder')->isHaveReg($_items, 0);
            if (($haveregular == 1) && ($orderStatus == 'processingpreorder' || $orderStatus == 'processing')) {
                $tmpstatus = 'processing';
                $this->setStatusPreorder('processing');
            } elseif (($haveregular == 0) && (($orderStatus == 'processing'))) {
                $tmpstatus = 'processingpreorder';
                $this->setStatusPreorder('processingpreorder');
            } elseif ($haveregular == -2 && $orderStatus == 'processing') {
                $tmpstatus = 'processing';
                $this->setStatusPreorder('processing');
            } elseif ($haveregular == -2 && $orderStatus != 'processing') {
                $tmpstatus = 'complete';
                $this->setStatusPreorder('complete');
            } elseif ($haveregular == -1) {
                $tmpstatus = 'processingpreorder';
                $this->setStatusPreorder('processingpreorder');
            }
        } elseif (($orderStatus == 'pending') || ($orderStatus == 'pendingpreorder')) {
            $_items = $order->getItemsCollection();
            $haveregular = Mage::helper('aitpreorder')->isHaveReg($_items, 1);

            if (($haveregular == 0) && ($orderStatus == 'pending')) {
                $tmpstatus = 'pendingpreorder';
                $this->setStatusPreorder('pendingpreorder');
            } elseif (($haveregular == 1) && ($orderStatus == 'pending')) {
                $tmpstatus = $orderStatus;
                $this->setStatusPreorder($orderStatus);
            } elseif (($haveregular != 0) && ($orderStatus == 'pendingpreorder')) {
                $tmpstatus = 'pending';
                $this->setStatusPreorder('pending');
            }
        } else {
            $this->setStatusPreorder($orderStatus);
        }

        if ($this->getStatusPreorder() == 'holded') {
            $this->setStatusPreorder($orderStatus);
        }

        $history = Mage::getModel('sales/order_status_history')
                ->setStatus($tmpstatus)
                ->setComment($comment);
        $this->addStatusHistory($history);

        if ($this->getStatus() == 'pendingpreorder') {
            $this->setStatus('pending');
        } elseif ($this->getStatus() == 'processingpreorder') {
            $this->setStatus('processing');
        }

        return $history;
    }

    public function selectOrderStatus()
    {
        $orderStatus = $this->getStatus();
        $orderStatusPreorder = $this->getStatusPreorder();
        if (!$orderStatusPreorder) {
            $orderStatusPreorder = $orderStatus;
        }

        if (($orderStatusPreorder == 'processingpreorder') || ($orderStatusPreorder == 'processing') || ($orderStatusPreorder == 'complete')) {
            $_items = $this->getItemsCollection();
            $haveregular = 0;
            $haveregular = Mage::helper('aitpreorder')->isHaveReg($_items, 0);

            if (($haveregular == 1) && ($orderStatusPreorder == 'processingpreorder')) {
                $this->setData('status_preorder', 'processing');
                $this->setData('status', 'processing');
                $this->addStatusHistoryComment('', 'processing');
            } elseif (($haveregular == 0) && ($orderStatusPreorder == 'processing')) {
                $this->setData('status_preorder', 'processingpreorder');
                $this->setData('status', 'processing');
                $this->addStatusHistoryComment('', 'processingpreorder');
            } elseif (($haveregular == -2) && ($orderStatus != 'complete') && ($orderStatusPreorder != 'processing')) {
                $this->setData('status_preorder', 'complete');
                $this->setData('status', 'complete');
                $this->addStatusHistoryComment('', 'complete');
            }

            if (($haveregular == -1) && ($orderStatus != 'processingpreorder')) {
                $this->setData('status_preorder', 'processingpreorder');
                $this->setData('status', 'processing');
                $isCustomerNotified = true;
                $this->addStatusHistoryComment('', 'processingpreorder');
            }
        } elseif (($orderStatusPreorder == 'pending') || ($orderStatusPreorder == 'pendingpreorder')) {
            $haveregular = 0;
            $_items = $this->getItemsCollection();
            $haveregular = Mage::helper('aitpreorder')->isHaveReg($_items, 1);
            if (($haveregular == 0) && ($orderStatusPreorder == 'pending')) {
                $this->setData('status_preorder', 'pendingpreorder');
                $this->setData('status', 'pending');
                $this->addStatusHistoryComment('', 'pendingpreorder');
            } elseif (($haveregular != 0) && ($orderStatusPreorder == 'pendingpreorder')) {
                $this->setData('status_preorder', 'pending');
                $this->setData('status', 'pending');
                $isCustomerNotified = true;
                $this->addStatusHistoryComment('', 'pending');
            }
        }
        return $this;
    }

}