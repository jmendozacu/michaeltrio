<?php

class Trd_Importxls_ManageController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('importxls');

        $this->getLayout()->getBlock('head')->setTitle($this->__('Import Data'));
        $block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'Trd_Contacts_Block_Contact',
            array(
                'template' => 'trd/importdata.phtml',
            )
        );

        $this->getLayout()->getBlock('content')->append($block);

        $this->renderLayout();
    }

    public function uploadAction()
    {
        $this->_clearFolder();
        $uploader = new Varien_File_Uploader('uploadfile');
        $uploader->setAllowedExtensions(array('xlsx'));

        $path = Mage::getBaseDir('media') . DS . 'xlsx' . DS;
        $fileName = $_FILES['uploadfile']['name'];
        $uploader->save($path, 'parsedfile.xls');

        echo json_encode(array('success' => true));
    }

    public function startimportAction()
    {
        $post = $this->getRequest()->getPost();
        if ($post) {
            $fileName = 'parsedfile.xls';
            $path = Mage::getBaseDir('media') . DS . 'xlsx' . DS . $fileName;
            $folderPath = Mage::getBaseDir('media') . DS . 'xlsx' . DS;
            exec('unzip ' . $path . ' -d ' . $folderPath, $result);

            try {
                $this->_clearTable();
                $preparedFiles = $this->_prepareXLfiles();
                unset($preparedFiles[0]);


                echo json_encode(
                    array(
                        'success' => true,
                        'products' => $preparedFiles,
                        'count' => count($preparedFiles)
                    )
                );
            } catch (Exception $e) {
                echo json_encode(array('success' => false));
            }
        }
    }

    public function saveimportedAction()
    {
        $post = $this->getRequest()->getPost();
        if ($post) {
            try {
                $parsedArr = json_decode($post['json']);

                foreach ($parsedArr as $num => $stdClass) {

                    $carat = number_format($stdClass->carat, 2, '.', '');
                    $diamondName = $carat . ' Carat ' . $this->_getFullShapeName($stdClass->shape) . ' Diamond';
                    $canSaveDiamond = $this->_checkFilledProperties($stdClass);

                    if ($canSaveDiamond) {
                        $model = Mage::getModel('trd_importxls/importxls');
                        $model->setSupplier($stdClass->supplier);
                        $model->setCertUrl($stdClass->cert_url);
                        $model->setDiamondsName($diamondName);
                        $model->setDiamondsModel($stdClass->diamonds_model);
                        $model->setDiamondsPrice(number_format($stdClass->diamonds_price, 2, '.', ''));
                        $model->setPricePerCarat(number_format($stdClass->price_per_carat, 2, '.', ''));
                        $model->setQuantity('1');
                        $model->setDescription('');
                        $model->setDiamondsWeight(number_format($stdClass->diamonds_weight, 2, '.', ''));
                        $model->setShape($stdClass->shape);
                        $model->setCarat($carat);
                        $model->setColor($stdClass->color);
                        $model->setClarity($stdClass->clarity);
                        $model->setCut($stdClass->cut);
                        $model->setReportNo($stdClass->report_no);
                        $model->setCert($stdClass->cert);
                        $model->setPolish($stdClass->polish);
                        $model->setSymmetry($stdClass->symmetry);
                        $model->setFluorescence($stdClass->fluorescence);
                        $model->setDepth(number_format($stdClass->depth, 1, '.', ''));
                        $model->setTableField($stdClass->table_field);
                        $model->setGirdle($stdClass->girdle);
                        $model->setMeasurement_1(number_format($stdClass->measurement_1, 2, '.', ''));
                        $model->setMeasurement_2(number_format($stdClass->measurement_2, 2, '.', ''));
                        $model->setMeasurement_3(number_format($stdClass->measurement_3, 2, '.', ''));
                        $model->setDiamondsImage('');
                        $model->setImage('');

                        $model->save();
                    }
                }

                echo json_encode(array('success' => true));
            } catch (Exception $e) {
                echo json_encode(array('success' => false));
            }
        }
    }

    protected function _checkFilledProperties($stdClass)
    {
        $status = true;

        if (!$stdClass->shape || $stdClass->shape == '') {
            $status = false;
        }
        if (!$stdClass->carat || $stdClass->carat == '') {
            $status = false;
        }
        if (!$stdClass->color || $stdClass->color == '') {
            $status = false;
        }
        if (!$stdClass->clarity || $stdClass->clarity == '') {
            $status = false;
        }
        /*if (!$stdClass->cut || $stdClass->cut == '') {
            $status = false;
        }*/
        if (!$stdClass->polish || $stdClass->polish == '') {
            $status = false;
        }
        if (!$stdClass->symmetry || $stdClass->symmetry == '') {
            $status = false;
        }
        if (!$stdClass->diamonds_price || $stdClass->diamonds_price == '') {
            $status = false;
        }

        return $status;
    }

    protected function _prepareXLfiles()
    {
        $folderPath = Mage::getBaseDir('media') . DS . 'xlsx' . DS;
        $xml = simplexml_load_file($folderPath . 'xl/sharedStrings.xml');
        $sharedStringsArr = array();
        foreach ($xml->children() as $item) {
            $sharedStringsArr[] = (string)$item->t;
        }

        $handle = @opendir($folderPath . 'xl/worksheets');
        $out = array();
        while ($file = @readdir($handle)) {
            if ($file == 'sheet1.xml') {
                $xml = simplexml_load_file($folderPath . 'xl/worksheets/' . $file);
                $row = 0;
                foreach ($xml->sheetData->row as $item) {
                    $att = 'hidden';
                    $isHidden = $item->attributes()->$att;
                    $out[$file][$row] = array();
                    // every rows
                    $cell = 0;

                    if (is_null($isHidden)) {
                        foreach ($item as $child) {
                            $attr = $child->attributes();
                            $value = isset($child->v) ? (string)$child->v : false;
                            $out[$file][$row][$cell] = isset($attr['t']) ? $sharedStringsArr[$value] : $value;
                            $cell++;
                        }
                        $row++;
                    }
                }
            }
        }
        return $out['sheet1.xml'];
    }

    protected function _getFullShapeName($shape) {
        $fullShape = '';
        switch ($shape) {
            case 'RD': $fullShape = 'Round'; break;
            case 'CU': $fullShape = 'Cushion'; break;
            case 'EC': $fullShape = 'Emerald'; break;
            case 'HS': $fullShape = 'Heart'; break;
            case 'MQ': $fullShape = 'Marquise'; break;
            case 'PR': $fullShape = 'Pear'; break;
            case 'PS': $fullShape = 'Princess'; break;
            case 'RA': $fullShape = 'Radiant'; break;
            case 'AC': $fullShape = 'Asscher'; break;
        }

        return $fullShape;
    }

    protected function _clearTable()
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $read->query("truncate table importxls");
    }

    protected function _clearFolder()
    {
        system('rm -rf ' . Mage::getBaseDir('media') . DS . 'xlsx' . DS . '*');
    }

    public function datamanageAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('trd_importxls/managedata'));
        $this->renderLayout();
    }

    public function exportCsvAction()
    {
        $fileName = 'Manage Importxls_export.csv';
        $content = $this->getLayout()->createBlock('trd_importxls/managedata_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportExcelAction()
    {
        $fileName = 'Manage Importxls_export.xml';
        $content = $this->getLayout()->createBlock('trd_importxls/managedata_grid')->getExcel();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('ids');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select Manage Importxls(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('trd_importxls/importxls')->load($id);
                    $model->delete();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('trd_importxls')->__('An error occurred while mass deleting items. Please review log and try again.')
                );
                Mage::logException($e);
                return;
            }
        }
        $this->_redirect('*/*/datamanage');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('trd_importxls/importxls');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('trd_importxls')->__('This Manage Importxls no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('managedata_model', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('trd_importxls/managedata_edit'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', false);
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('importxls_id');
            $model = Mage::getModel('trd_importxls/importxls');
            if ($id) {
                $model->load($id);
                if (!$model->getImportxlsId()) {
                    $this->_getSession()->addError(
                        Mage::helper('trd_importxls')->__('This data no longer exists.')
                    );
                    $this->_redirect('*/*/datamanage');
                    return;
                }
            }

            // save model
            try {
                $model->addData($data);
                $this->_getSession()->setFormData($data);
                $model->save();
                $this->_getSession()->setFormData(false);
                $this->_getSession()->addSuccess(
                    Mage::helper('trd_importxls')->__('The Data has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('trd_importxls')->__('Unable to save the data.'));
                $redirectBack = true;
                Mage::logException($e);
            }

            if ($redirectBack) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
        }
        $this->_redirect('*/*/datamanage');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('trd_importxls/importxls');
                $model->load($id);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('trd_importxls')->__('Unable to find a Manage Importxls to delete.'));
                }
                $model->delete();
                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('trd_importxls')->__('The Manage Importxls has been deleted.')
                );
                // go to grid
                $this->_redirect('*/*/datamanage');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('trd_importxls')->__('An error occurred while deleting Manage Importxls data. Please review log and try again.')
                );
                Mage::logException($e);
            }
            // redirect to edit form
            $this->_redirect('*/*/edit', array('id' => $id));
            return;
        }
        // display error message
        $this->_getSession()->addError(
            Mage::helper('trd_importxls')->__('Unable to find a Manage Importxls to delete.')
        );
        // go to grid
        $this->_redirect('*/*/datamanage');
    }
}