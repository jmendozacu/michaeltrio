<?php

class Searchtechnow_Stnpromotion_Adminhtml_StnpromotionController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('stnpromotion/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('News/Promotion Manager'), Mage::helper('adminhtml')->__('News/Promotion Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('stnpromotion/adminhtml_stnpromotion'));
        $this->renderLayout();
    }

    public function editAction() {
        $stnpromotionId = $this->getRequest()->getParam('id');
        $stnpromotionModel = Mage::getModel('stnpromotion/stnpromotion')->load($stnpromotionId);

        if ($stnpromotionModel->getId() || $stnpromotionId == 0) {

            Mage::register('stnpromotion_data', $stnpromotionModel);

            $this->loadLayout();
            $this->_setActiveMenu('stnpromotion/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Recently Purchased Manager'), Mage::helper('adminhtml')->__('Recently Purchased Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Recently Purchased News'), Mage::helper('adminhtml')->__('Recently Purchased News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('stnpromotion/adminhtml_stnpromotion_edit'))
                    ->_addLeft($this->getLayout()->createBlock('stnpromotion/adminhtml_stnpromotion_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stnpromotion')->__('News/Promotion does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($this->getRequest()->getPost()) {

            try {
                $postData = $this->getRequest()->getPost();
                $stnpromotionModel = Mage::getModel('stnpromotion/stnpromotion');

				
                $stnpromotionModel->setId($this->getRequest()->getParam('id'))
                        ->setTitle($postData['title'])
						->setPromotionText($postData['promotion_text'])
						->setShortOrder($postData['short_order'])						
						->setCreatedTime(date('Y-m-d H:i:s'))
                        ->setUpdateTime(date('Y-m-d H:i:s'))
                        ->setStatus($postData['status'])
                        ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('News/Stnpromotion was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setStnpromotionData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setStnpromotionData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function removeFile($file) {
        
        $_helper = Mage::helper('stnpromotion');
        $file = $_helper->updateDirSepereator($file);
        @unlink(Mage::getBaseDir('media') .'/'.$file);
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
        
            try {
                $stnpromotionModeldata = Mage::getModel('stnpromotion/stnpromotion')->load($this->getRequest()->getParam('id'));
                $stnpromotionModel = Mage::getModel('stnpromotion/stnpromotion');

                $stnpromotionModel->setId($this->getRequest()->getParam('id'))->delete();

				if ($stnpromotionModeldata->getLogopic() != '')
				{
				 $this->removeFile($stnpromotionModeldata->getLogopic());
				}
				if ($stnpromotionModeldata->getPic() != '')
				{
				 $this->removeFile($stnpromotionModeldata->getPic());
				}
				if ($stnpromotionModeldata->getPic2() != '')
				{
				 $this->removeFile($stnpromotionModeldata->getPic2());
				}
							
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('News/Stnpromotion was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('stnpromotion/adminhtml_stnpromotion_grid')->toHtml()
        );
    }

}
