<?php

class Trd_Engraving_IndexController extends Mage_Core_Controller_Front_Action
{

    public $status, $message;

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('trd_engraving/engraving');
			
            /*try {
                $model->setProductId($data['product_id']);
                $model->setText($data['text']);
                if ($data['font']) {
                    $model->setFont($data['font']);
                }

                $model->save();

                $this->status = true;
                $this->message = 'success';
            } catch (Exception $e) {
                $this->status = false;
                $this->message = 'problem with saving';
            }*/
			$this->status = true;
			$this->message = 'success';
        } else {
            $this->status = false;
            $this->message = 'no params';
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('status' => $this->status, 'message' => $this->message)));
    }

}