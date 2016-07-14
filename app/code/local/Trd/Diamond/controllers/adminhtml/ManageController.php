<?php

class Trd_Diamond_Adminhtml_ManageController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog');

        $model = Mage::getModel('trd_diamond/diamondprod')->load(1);
        $this->getLayout()->getBlock('head')->setTitle($this->__('Manage Diamond Product'));
        $block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'Trd_Diamond_Block_Diamondprod',
            array(
                'template' => 'trd/managediamondprod.phtml',
                'model' => !$model ? false : $model
            )
        );

        $this->getLayout()->getBlock('content')->append($block);

        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $id = 1;
            $model = Mage::getModel('trd_diamond/diamondprod');
            if ($id) {
                $model->load($id);
            }

            // save model
            try {
                $model->setProductId($data['product_id']);
                $this->_getSession()->setFormData($data);
                $model->save();
                $this->_getSession()->setFormData(false);
                $this->_getSession()->addSuccess(
                    Mage::helper('trd_diamond')->__('The Product Id has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('trd_diamond')->__('Unable to save the Product Id.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
}