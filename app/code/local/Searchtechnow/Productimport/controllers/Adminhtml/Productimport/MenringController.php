<?php

class Searchtechnow_Productimport_Adminhtml_Productimport_MenringController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        $this->_title($this->__('System'))->_title($this->__('Men Ring Product Import'));
        $this->loadLayout();
        $this->_initLayoutMessages('adminhtml/session');
        $this->_setActiveMenu('searchtechnow_productimport');
        $this->renderLayout();
    }

    public function importAction() {
       /* $alloptions = array(array('title' => 'Color', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '0', 'values' => array(array('title' => 'Bronze', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Gold', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'), array('title' => 'Silver', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2'))), array('title' => 'Metals', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '1', 'values' => array(array('title' => '18k', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'Platinum', 'price' => '300.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'))), array('title' => 'Engraving', 'type' => 'radio', 'is_require' => 1, 'sort_order' => '2', 'values' => array(array('title' => 'Yes', 'price' => '40.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => 'No', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'))), array('title' => 'Ring size', 'type' => 'drop_down', 'is_require' => 1, 'sort_order' => '3', 'values' => array(array('title' => '3', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '0'), array('title' => '4', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '1'), array('title' => '5', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '2'), array('title' => '6', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '3'), array('title' => '7', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '4'), array('title' => '8', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '5'), array('title' => '9', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '6'), array('title' => '10', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '7'), array('title' => '11', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '8'), array('title' => '12', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '9'), array('title' => '13', 'price' => '0.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '10'), array('title' => '14', 'price' => '100.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '11'), array('title' => '15', 'price' => '100.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '12'), array('title' => '16', 'price' => '200.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '13'), array('title' => '17', 'price' => '200.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '14'), array('title' => '18', 'price' => '300.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '15'), array('title' => '14', 'price' => '40.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '16'), array('title' => '15', 'price' => '40.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '17'), array('title' => '16', 'price' => '80.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '18'), array('title' => '17', 'price' => '80.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '19'), array('title' => '18', 'price' => '120.00', 'price_type' => 'fixed', 'sku' => '', 'sort_order' => '20'))));*/
        if ($this->getRequest()->getPost()) {
            $fileextension = pathinfo($_FILES['import_file']['name']);
            $allowedtype = array('application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/csv', 'application/excel', 'text/csv');
            if ($_FILES['import_file']['name'] != '' && ($fileextension['extension'] == 'xlsx' || $fileextension['extension'] == 'xls' || $fileextension['extension'] == 'csv')) {
                Mage::getSingleton('core/session')->addSuccess('Product import successful');
                $path = Mage::getBaseDir() . '/productimport';
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $filepath = $path . '/' . $_FILES['import_file']['name'];
                move_uploaded_file($_FILES['import_file']['tmp_name'], $filepath);
                chmod($filepath, 0777);
                $shapeArr = array('RD' => 'Round', 'PS' => 'Princess', 'EC' => 'Emerald', 'HS' => 'Heart', 'PR' => 'Pear', 'CU' => 'Cushion', 'RA' => 'Radiant', 'OV' => 'Oval', 'AS' => 'Asscher', 'AC' => 'Asscher', 'MQ' => 'Marquise');
                if ($fileextension['extension'] != 'csv') {
                    require_once($path . '/excel_reader2.php');
                    require_once($path . '/SpreadsheetReader.php');
                    $data = new SpreadsheetReader($filepath);
                    $data->ChangeSheet(0);
                    echo $filepath; echo '<pre>'; //print_r($data); die;
                    foreach ($data as $Key => $row) {
                        $chkexist = $this->get_product(trim(trim($row[0])) . '-' . $Key);
                        print_r($row); 
                        $qty = 100;
                        /*if (trim(trim(trim($row[0]))) != '') {
                            $price = 0;
                            if (trim(trim($row[3])) != '') {
                                $price = floatval(preg_replace("/[^-0-9\.]/", "", trim($row[3])));
                            }
                            $allcatNames = explode('-', trim($row[4]));
                            $colors = explode('/', trim($row[5]));
                            $alcats = array();
                            $colorAdminar = array('White' => '123', 'Rose' => '124', 'Yellow' => '125');
                            $categoryIds = array();
                            //echo '<pre>';
                            //print_r($row); die;
                            //print_r($allcatNames);
                            if (trim($catName[2]) == 'Alt Meatal Ring') {
                                $catName[2] = 'Alternative Metal Rings';
                            }
                            foreach ($allcatNames as $catName) {
                                $alcats[] = trim($catName);
                            }
                            //print_r($alcats);
                            /* $category = Mage::getResourceModel('catalog/category_collection')
                              ->addFieldToFilter('name', 'Wedding')
                              ->getFirstItem(); */
                            /*$category = Mage::getResourceModel('catalog/category_collection')
                                    ->addFieldToFilter('name', $alcats[0]);
                            $category1 = Mage::getResourceModel('catalog/category_collection')
                                    ->addFieldToFilter('name', $alcats[0])
                                    ->getFirstItem()
                                    ->getChildrenCategories()
                                    ->addFieldToFilter('name', $alcats[1]);
                            $category2 = Mage::getResourceModel('catalog/category_collection')
                                    ->addFieldToFilter('name', $alcats[1])
                                    ->getFirstItem()
                                    ->getChildrenCategories()
                                    ->addFieldToFilter('name', $alcats[2]);
                            $cat_det = $category->getData();
                            $cat1_det = $category1->getData();
                            $cat2_det = $category2->getData();
                            //echo $cat_det[0]['entity_id']; die;
                            $categoryIds[] = $cat_det[0]['entity_id'];
                            $categoryIds[] = $cat1_det[0]['entity_id'];
                            $categoryIds[] = $cat2_det[0]['entity_id'];

//                            print_r($categoryIds);
//                            exit;
                            //print_r($colors);
                            $colorids = array();
                            foreach ($colors as $color) {
                                $colorids[] = $colorAdminar[ucfirst(trim($color))];
                            }
                            //die;
                            if ($chkexist) {
                                $product = Mage::getModel('catalog/product')->load($chkexist->getEntityId());
                            } else {
                                $product = Mage::getModel('catalog/product');
                            }
                            $product->setStoreId(1)
                                    ->setWebsiteIds(array(1))
                                    ->setAttributeSetId(4)
                                    ->setTypeId('simple')
                                    ->setCreatedAt(strtotime('now'))
                                    ->setSku(trim($row[0]) . '-' . $Key)
                                    ->setName(trim($row[0]) . ' ' . trim($row[1]))
                                    ->setWeight(10)
                                    ->setStatus(1)
                                    ->setPrice($price)
                                    ->setTaxClassId(0)
                                    ->setVisibility(3)
                                    ->setDescription(trim($row[2]))
                                    ->setShortDescription(trim($row[2]))
                                    ->setStockData(array('use_config_manage_stock' => 0, 'manage_stock' => 1, 'is_in_stock' => 1, 'min_sale_qty' => 1, 'max_sale_qty' => 1, 'qty' => $qty))
                                    ->setCategoryIds($categoryIds)
                                    ->setSst1Shape(trim($row[7]))
                                    ->setSst1NumberDiamonds(trim($row[8]))
                                    ->setSst1WeightEstimated(trim($row[9]))
                                    ->setSst1AverageColor(trim($row[10]))
                                    ->setSst1AverageClarity(trim($row[11]))
                                    ->setSetting1Type(trim($row[12]))
                                    ->setBandWidth(trim($row[13]))
                                    ->setPairWith(trim($row[16]))
                                    ->setColorWedding($colorids)
                                    ->setRemarkVal(trim($row[0]))
                                    ->setProductOptions($alloptions)
                                    ->setCanSaveCustomOptions(true);
                            $product->save(); //die('12345');
                        }*/
                            die;
                    }  //die('123 Success');
                } else {
                    $filepath = fopen($filepath, "r");
                    if (trim($row[22]) == '') {
                        $qty = 10;
                    } else {
                        $qty = trim($row[22]);
                    }
                    $count = 0;
                    while (($row = fgetcsv($filepath)) !== FALSE) {
                        $chkexist = $this->get_product($Row[2]);
                        if ($count != 0 && $chkexist) {
                            //echo $Key.'<br>'; 	
                            $product = Mage::getModel('catalog/product');
                            $product->setStoreId(1)
                                    ->setWebsiteIds(array(1))
                                    ->setAttributeSetId(4)
                                    ->setTypeId('simple')
                                    ->setCreatedAt(strtotime('now'))
                                    ->setSku(trim($row[2]))
                                    ->setName(trim($row[5]) . ' Carat ' . $shapeArr[trim($row[6])] . ' Diamond')
                                    ->setWeight(trim($row[5]))
                                    ->setStatus(1)
                                    ->setPrice(trim($row[3]))
                                    ->setTaxClassId(0)
                                    ->setVisibility(3)
                                    ->setDescription(trim($row[5]) . ' Carat ' . $shapeArr[trim($row[6])] . ' Diamond')
                                    ->setShortDescription(trim($row[5]) . ' Carat ' . $shapeArr[trim($row[6])] . ' Diamond')
                                    ->setStockData(array('use_config_manage_stock' => 0, 'manage_stock' => 1, 'is_in_stock' => 1, 'min_sale_qty' => 1, 'max_sale_qty' => 1, 'qty' => $qty))
                                    ->setCategoryIds(array(3))
                                    ->setDiamondGridle(trim($row[18]))
                                    ->setDiamondClarity(trim($row[9]))
                                    ->setDiamondCertificateUrl(trim($row[1]))
                                    ->setDiamondColor(trim($row[8]))
                                    ->setDiamondCut(trim($row[10]))
                                    ->setDiamondCarat(trim($row[7]))
                                    ->setDiamondDepth(trim($row[16]))
                                    ->setDiamondFluorescence(trim($row[15]))
                                    ->setDiamondMeasurement1(trim($row[19]))
                                    ->setDiamondMeasurement2(trim($row[20]))
                                    ->setDiamondMeasurement3(trim($row[21]))
                                    ->setDiamondReportNumber(trim($row[11]))
                                    ->setDiamondDiamondModel(trim($row[2]))
                                    ->setDiamondPolish(trim($row[13]))
                                    ->setDiamondSymmetry(trim($row[14]))
                                    ->setDiamondShape(trim($row[6]))
                                    ->setDiamondSupplier(trim($row[0]))
                                    ->setDiamondPricePerCarat(trim($row[4]))
                                    ->setDiamondWeight(trim($row[5]))
                                    ->setDiamondTable(trim($row[17]))
                                    ->setDiamondCert(trim($row[12]));
                            $product->save(); //die('12345');					
                        }
                        $count++;
                    }

                    fclose($filepath);
                }
                unlink($filepath);
                $this->_redirect('adminhtml/productimport_menring');
            } else {
                Mage::getSingleton('core/session')->addError('Please upload only csv, xlsx, xls file !!');
                $this->_redirect('adminhtml/productimport_menring');
            }
        } else {
            $this->_redirect('adminhtml/productimport_menring');
        }
    }

    protected function _save_image($img) {
        $imageFilename = basename($img);
        $filename = strtotime('now') . '.jpg';
        $filepath = Mage::getBaseDir('media') . DS . 'import' . DS . $filename;
        $path = Mage::getBaseDir('media') . DS . 'import';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $newImgUrl = file_put_contents($filepath, file_get_contents(trim($img)));
        return $filepath;
    }

    protected function get_product($sku) {
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
        //var_dump($product);
        //echo '<br><br><br>'.$product->getEntityId();
        return $product;
    }

    protected function _prepareDiamondType($shape) {
        switch ($shape) {
            case 'CU':
                $type = 'cushion';
                break;
            case 'EC':
                $type = 'emerald';
                break;
            case 'HS':
                $type = 'heart';
                break;
            case 'MQ':
                $type = 'marquise';
                break;
            case 'OV':
                $type = 'oval';
                break;
            case 'PR':
                $type = 'pear';
                break;
            case 'PS':
                $type = 'princess';
                break;
            case 'RA':
                $type = 'radiant';
                break;
            case 'RD':
                $type = 'round';
                break;
            case 'AC':
                $type = 'asscher';
                break;
        }
        return $type;
    }

}
