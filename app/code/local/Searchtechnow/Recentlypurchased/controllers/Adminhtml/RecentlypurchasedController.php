<?php

class Searchtechnow_Recentlypurchased_Adminhtml_RecentlypurchasedController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('recentlypurchased/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Recently Purchased Manager'), Mage::helper('adminhtml')->__('Recently Purchased Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('recentlypurchased/adminhtml_recentlypurchased'));
        $this->renderLayout();
    }

    public function editAction() {
        $recentlypurchasedId = $this->getRequest()->getParam('id');
        $recentlypurchasedModel = Mage::getModel('recentlypurchased/recentlypurchased')->load($recentlypurchasedId);

        if ($recentlypurchasedModel->getId() || $recentlypurchasedId == 0) {

            Mage::register('recentlypurchased_data', $recentlypurchasedModel);

            $this->loadLayout();
            $this->_setActiveMenu('recentlypurchased/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Recently Purchased Manager'), Mage::helper('adminhtml')->__('Recently Purchased Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Recently Purchased News'), Mage::helper('adminhtml')->__('Recently Purchased News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('recentlypurchased/adminhtml_recentlypurchased_edit'))
                    ->_addLeft($this->getLayout()->createBlock('recentlypurchased/adminhtml_recentlypurchased_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('recentlypurchased')->__('Recently Purchased does not exist'));
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
                $recentlypurchasedModel = Mage::getModel('recentlypurchased/recentlypurchased');

                if (isset($_FILES['logopic']['name']) and ( file_exists($_FILES['logopic']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('logopic');
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png')); // or pdf or anything


                        $uploader->setAllowRenameFiles(false);

                        // setAllowRenameFiles(true) -> move your file in a folder the magento way
                        // setAllowRenameFiles(true) -> move your file directly in the $path folder
                        $uploader->setFilesDispersion(false);

                        $path = Mage::getBaseDir('media') . DS . 'recentlypurchased' . DS;
                        $destFile = $path . $_FILES['logopic']['name'];
                        $filename = $uploader->getNewFileName($destFile);

                        $uploader->save($path, $filename);
                        $postData['logopic'] = 'recentlypurchased/' . $filename;
                    } catch (Exception $e) {
                        
                    }
                } else {
                    if (isset($postData['logopic']['delete']) && $postData['logopic']['delete'] == 1) {
                        if ($postData['logopic']['value'] != '')
                            $this->removeFile($postData['logopic']['value']);
                        $postData['logopic'] = '';
                    }
                    else {
                        unset($postData['logopic']);
                    }
                }


                if (isset($_FILES['pic']['name']) and ( file_exists($_FILES['pic']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('pic');
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png')); // or pdf or anything

                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        $path = Mage::getBaseDir('media') . DS . 'recentlypurchased' . DS;
                        $destFile = $path . $_FILES['pic']['name'];
                        $filename = $uploader->getNewFileName($destFile);

                        $uploader->save($path, $filename);
                        $postData['pic'] = 'recentlypurchased/' . $filename;
                    } catch (Exception $e) {
                        
                    }
                } else {
                    if (isset($postData['pic']['delete']) && $postData['pic']['delete'] == 1) {
                        if ($postData['pic']['value'] != '')
                            $this->removeFile($postData['pic']['value']);
                        $postData['pic'] = '';
                    }
                    else {
                        unset($postData['pic']);
                    }
                }


                if (isset($_FILES['pic2']['name']) and ( file_exists($_FILES['pic2']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('pic2');
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png')); // or pdf or anything

                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        $path = Mage::getBaseDir('media') . DS . 'recentlypurchased' . DS;
                        $destFile = $path . $_FILES['pic2']['name'];
                        $filename = $uploader->getNewFileName($destFile);

                        $uploader->save($path, $filename);
                        $postData['pic2'] = 'recentlypurchased/' . $filename;
                    } catch (Exception $e) {
                        
                    }
                } else {
                    if (isset($postData['pic2']['delete']) && $postData['pic2']['delete'] == 1) {

                        if ($postData['pic2']['value'] != '')
                            $this->removeFile($postData['pic2']['value']);
                        $postData['pic2'] = '';
                    }
                    else {
                        unset($postData['pic2']);
                    }
                }

                $recentlypurchasedModel->setId($this->getRequest()->getParam('id'))
                        ->setTitle($postData['title'])
                        ->setShape($postData['shape'])
                        ->setColour($postData['colour'])
                        ->setCarat($postData['carat'])
                        ->setClarity($postData['clarity'])
                        ->setCut($postData['cut'])
                        ->setSetting($postData['setting'])
                        ->setPrice($postData['price'])
                        ->setLogopic($postData['logopic'])
                        ->setPic($postData['pic'])
                        ->setPic2($postData['pic2'])
                        ->setCreatedTime(date('Y-m-d H:i:s'))
                        ->setUpdateTime(date('Y-m-d H:i:s'))
                        ->setStatus($postData['status'])
                        ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Recently Purchased was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setRecentlypurchasedData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setRecentlypurchasedData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function removeFile($file) {

        $_helper = Mage::helper('recentlypurchased');
        $file = $_helper->updateDirSepereator($file);
        @unlink(Mage::getBaseDir('media') . '/' . $file);
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {

            try {
                $recentlypurchasedModeldata = Mage::getModel('recentlypurchased/recentlypurchased')->load($this->getRequest()->getParam('id'));
                $recentlypurchasedModel = Mage::getModel('recentlypurchased/recentlypurchased');

                $recentlypurchasedModel->setId($this->getRequest()->getParam('id'))->delete();

                if ($recentlypurchasedModeldata->getLogopic() != '') {
                    $this->removeFile($recentlypurchasedModeldata->getLogopic());
                }
                if ($recentlypurchasedModeldata->getPic() != '') {
                    $this->removeFile($recentlypurchasedModeldata->getPic());
                }
                if ($recentlypurchasedModeldata->getPic2() != '') {
                    $this->removeFile($recentlypurchasedModeldata->getPic2());
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Recently Purchased was successfully deleted'));
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
                $this->getLayout()->createBlock('recentlypurchased/adminhtml_recentlypurchased_grid')->toHtml()
        );
    }

}
