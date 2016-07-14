<?php

class Searchtechnow_Testimonial_Adminhtml_TestimonialController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('testimonial/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Testimonial Manager'), Mage::helper('adminhtml')->__('Testimonial Manager'));
        return $this;
    }

    public function indexAction() {

        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('testimonial/adminhtml_testimonial'));
        $this->renderLayout();
    }

    public function editAction() {
        $testimonialId = $this->getRequest()->getParam('id');
        $testimonialModel = Mage::getModel('testimonial/testimonial')->load($testimonialId);

        if ($testimonialModel->getId() || $testimonialId == 0) {

            Mage::register('testimonial_data', $testimonialModel);

            $this->loadLayout();
            $this->_setActiveMenu('testimonial/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Testimonial Manager'), Mage::helper('adminhtml')->__('Testimonial Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Testimonial News'), Mage::helper('adminhtml')->__('Testimonial News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('testimonial/adminhtml_testimonial_edit'))
                    ->_addLeft($this->getLayout()->createBlock('testimonial/adminhtml_testimonial_edit_tabs'));

            $this->renderLayout();
        } else {
		
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonial')->__('Testimonial does not exist'));
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
                $testimonialModel = Mage::getModel('testimonial/testimonial');

                if (isset($_FILES['logopic']['name']) and ( file_exists($_FILES['logopic']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('logopic');
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png')); // or pdf or anything


                        $uploader->setAllowRenameFiles(false);

                        // setAllowRenameFiles(true) -> move your file in a folder the magento way
                        // setAllowRenameFiles(true) -> move your file directly in the $path folder
                        $uploader->setFilesDispersion(false);

                        $path = Mage::getBaseDir('media') . DS . 'testimonial' . DS;
						$name = preg_replace("/[^A-Z0-9._-]/i", "_", $_FILES['logopic']['name']);
                        $destFile = $path . time().'_'.str_replace(' ', '_', $name);
						 
                        $filename = $uploader->getNewFileName($destFile);

                        $uploader->save($path, $filename);
                        $postData['logopic'] = 'testimonial/' . str_replace(' ', '_', $filename);
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

                $testimonialModel->setId($this->getRequest()->getParam('id'))
				        ->setAuthor($postData['author'])
                        ->setTitle($postData['title'])
                        ->setLogopic($postData['logopic'])
                        ->setContent($postData['content'])
						->setDateOfTestimonial(date('Y-m-d',strtotime($postData['date_of_testimonial'])))
                        ->setCreatedTime(date('Y-m-d H:i:s'))
                        ->setUpdateTime(date('Y-m-d H:i:s'))
                        ->setStatus($postData['status'])
                        ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Testimonial was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setTestimonialData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setTestimonialData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function removeFile($file) {

        $_helper = Mage::helper('testimonial');
        $file = $_helper->updateDirSepereator($file);
        @unlink(Mage::getBaseDir('media') . '/' . $file);
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {

            try {
                $testimonialModeldata = Mage::getModel('testimonial/testimonial')->load($this->getRequest()->getParam('id'));
                $testimonialModel = Mage::getModel('testimonial/testimonial');

                $testimonialModel->setId($this->getRequest()->getParam('id'))->delete();

                if ($testimonialModeldata->getLogopic() != '') {
                    $this->removeFile($testimonialModeldata->getLogopic());
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Testimonial was successfully deleted'));
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
                $this->getLayout()->createBlock('testimonial/adminhtml_testimonial_grid')->toHtml()
        );
    }

}
