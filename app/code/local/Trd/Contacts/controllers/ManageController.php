<?php

class Trd_Contacts_ManageController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();

        $model = Mage::getModel('trd_contacts/contacts')->load(1);
        $this->getLayout()->getBlock('head')->setTitle($this->__('Manage Contacts'));
        $block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'Trd_Contacts_Block_Contact',
            array(
                'template' => 'trd/contacts.phtml',
                'model' => !$model ? false : $model
            )
        );

        $this->getLayout()->getBlock('content')->append($block);

        $this->renderLayout();
    }

    public function testimonialsAction()
    {
        $this->loadLayout();

        $model = $model = Mage::getModel('trd_contacts/testimonials')->load(1);
        $this->getLayout()->getBlock('head')->setTitle($this->__('Manage Testimonials'));
        $block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'Trd_Contacts_Block_Testimonials',
            array(
                'template' => 'trd/testimonials.phtml',
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
            $model = Mage::getModel('trd_contacts/contacts');
            if ($id) {
                $model->load($id);
            }

            // save model
            try {
                $model->addData($data);
                $this->_getSession()->setFormData($data);
                $model->save();
                $this->_getSession()->setFormData(false);
                $this->_getSession()->addSuccess(
                    Mage::helper('trd_contacts')->__('The Contacts has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('trd_contacts')->__('Unable to save the Contacts.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }


    public function saveTestimonialsAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $id = 1;
            $model = Mage::getModel('trd_contacts/testimonials');
            if ($id) {
                $model->load($id);
            }

            // save model
            try {
                $model->addData($data);
                $this->_getSession()->setFormData($data);
                $model->save();
                $this->_getSession()->setFormData(false);
                $this->_getSession()->addSuccess(
                    Mage::helper('trd_contacts')->__('The Contacts has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('trd_contacts')->__('Unable to save the Contacts.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/testimonials');
    }
}