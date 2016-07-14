<?php

class Searchtechnow_Couplering_Adminhtml_CoupleringController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('couplering/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Couple Ring Manager'), Mage::helper('adminhtml')->__('Couple Ring Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('couplering/adminhtml_couplering'));
        $this->renderLayout();
    }

    public function editAction() {
        $coupleringId = $this->getRequest()->getParam('id');
        $coupleringModel = Mage::getModel('couplering/couplering')->load($coupleringId);

        if ($coupleringModel->getId() || $coupleringId == 0) {

            Mage::register('couplering_data', $coupleringModel);

            $this->loadLayout();
            $this->_setActiveMenu('couplering/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Couple Ring Manager'), Mage::helper('adminhtml')->__('Couple Ring Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Couple Ring News'), Mage::helper('adminhtml')->__('Couple Ring News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('couplering/adminhtml_couplering_edit'))
                    ->_addLeft($this->getLayout()->createBlock('couplering/adminhtml_couplering_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('couplering')->__('Couple Ring does not exist'));
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
                $coupleringModel = Mage::getModel('couplering/couplering');
                if (isset($_FILES['logopic']['name']) and ( file_exists($_FILES['logopic']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('logopic');
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);
                        $path = Mage::getBaseDir('media') . DS . 'couplering' . DS;
                        $destFile = $path . $_FILES['logopic']['name'];
                        $filename = $uploader->getNewFileName($destFile);
                        $uploader->save($path, $filename);
                        $postData['logopic'] = 'couplering/' . $filename;
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

                        $path = Mage::getBaseDir('media') . DS . 'couplering' . DS;
                        $destFile = $path . $_FILES['pic']['name'];
                        $filename = $uploader->getNewFileName($destFile);

                        $uploader->save($path, $filename);
                        $postData['pic'] = 'couplering/' . $filename;
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

                $product = Mage::getModel('catalog/product')->load($postData['menring']);

                if (isset($_FILES['pic2']['name']) and ( file_exists($_FILES['pic2']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('pic2');
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png')); // or pdf or anything

                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        $path = Mage::getBaseDir('media') . DS . 'couplering' . DS;
                        $destFile = $path . $_FILES['pic2']['name'];
                        $filename = $uploader->getNewFileName($destFile);

                        $uploader->save($path, $filename);
                        $postData['pic2'] = 'couplering/' . $filename;
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

                $menringproduct = Mage::getModel('catalog/product')->load($postData['menring']);
                $womenringproduct = Mage::getModel('catalog/product')->load($postData['womenring']);
//                echo $menringproduct->getPrice().'<br>';
//                echo $womenringproduct->getPrice().'<br>';
                $combineprice = $menringproduct->getPrice() + $womenringproduct->getPrice();
//                echo $womenringmenringprice;
//                exit;
                $coupleringModel->setId($this->getRequest()->getParam('id'))
                        ->setTitle($postData['title'])
                        ->setCategoryId($postData['category_id'])
                        ->setMenring($postData['menring'])
                        ->setWomenring($postData['womenring'])
                        ->setPrice($combineprice)
                        ->setLogopic($postData['logopic'])
                        ->setPic($postData['pic'])
                        ->setPic2($postData['pic2'])
                        ->setCreatedTime(date('Y-m-d H:i:s'))
                        ->setUpdateTime(date('Y-m-d H:i:s'))
                        ->setStatus($postData['status'])
                        ->save();

                /* Rewrite */
//                $isSystem = 0; // set 0 for custom url as we have created custom for profile extension
//
//                $_itemId = $model->getModuleItemId(); //module_item_id field
//                $_itemName = $model->getTitle(); //title field
//                $_itemName = strtolower(str_replace(" ", "", $_itemName));



//                // save profile view url rewrite
//                $viewIdPath = 'item/id' . '/' . $_itemId;
//                $viewRequestPath = 'items/' . $_itemName;
//                $viewTargetPath = 'items/index/item/id/' . $_itemId; //controller is itemsController.php, Action is itemAction() 
//
//                $_coreUrlRewrite = Mage::getModel('core/url_rewrite');
//                $_coreUrlRewrite->load($viewIdPath, 'id_path'); // check if item path already saved? If yes, $_coreUrlRewrite will contain existing data.
//
//                $_coreUrlRewrite->setStoreId($_storeId)
//                        ->setIdPath($viewIdPath)
//                        ->setRequestPath($viewRequestPath)
//                        ->setTargetPath($viewTargetPath)
//                        ->setIsSystem($isSystem)
//                        ->save();
//                
//                if (isset($viewRequestPath)) {
//                    $coupleringModel->setUrl($viewRequestPath);
//                    $coupleringModel->save();
//                }

                /* Rewrite End */

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Couple Ring was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setCoupleringData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCoupleringData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function removeFile($file) {

        $_helper = Mage::helper('couplering');
        $file = $_helper->updateDirSepereator($file);
        @unlink(Mage::getBaseDir('media') . '/' . $file);
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {

            try {
                $coupleringModeldata = Mage::getModel('couplering/couplering')->load($this->getRequest()->getParam('id'));
                $coupleringModel = Mage::getModel('couplering/couplering');

                $coupleringModel->setId($this->getRequest()->getParam('id'))->delete();

                if ($coupleringModeldata->getLogopic() != '') {
                    $this->removeFile($coupleringModeldata->getLogopic());
                }
                if ($coupleringModeldata->getPic() != '') {
                    $this->removeFile($coupleringModeldata->getPic());
                }
                if ($coupleringModeldata->getPic2() != '') {
                    $this->removeFile($coupleringModeldata->getPic2());
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Couple Ring was successfully deleted'));
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
                $this->getLayout()->createBlock('couplering/adminhtml_couplering_grid')->toHtml()
        );
    }

}
