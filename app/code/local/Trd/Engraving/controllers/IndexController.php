<?php

class Trd_Engraving_IndexController extends Mage_Core_Controller_Front_Action {

    public $status, $message;

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {

            try {
                $resource = Mage::getSingleton('core/resource');
                $writeConnection = $resource->getConnection('core_write');
                $query = "INSERT INTO `engraving` (`engraving_id`, `product_id`, `text`, `font`, `alignment`, `quote_id`, `created_time`) VALUES (NULL, '" . $data['product_id'] . "', '" . $data['text'] . "', '" . $data['font'] . "', '" . $data['alignment'] . "', '', '" . date('Y-m-d H:i:s') . "')";
                $writeConnection->query($query);
//                $model->setProductId($data['product_id']);
//                $model->setText($data['text']);
//                if ($data['font']) {
//                    $model->setFont($data['font']);
//                }
//
//                $model->save();

                $this->lastid = $writeConnection->lastInsertId();
                $this->status = true;
                $this->message = 'success';
            } catch (Exception $e) {
                $this->status = false;
                $this->message = 'problem with saving';
            }
            $this->status = true;
            $this->message = 'success';
        } else {
            $this->status = false;
            $this->message = 'no params';
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('status' => $this->status, 'message' => $this->message, 'lastid' => $this->lastid)));
    }

}
