<?php
/*echo phpinfo();
exit;*/
$mageFilename = __DIR__.'/../app/Mage.php';
if (!file_exists($mageFilename)) {
    echo $mageFilename . " was not found";
    exit;
}
else
{
    $mageFilename . " was found";
}

require_once $mageFilename;
Mage::app();

Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

function findFiles($directory, $extensions = array()) {

    function glob_recursive($directory, &$directories = array()) {
        foreach (glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder) {
            $directories[] = $folder;
            glob_recursive("{$folder}/*", $directories);
        }
    }

    glob_recursive($directory, $directories);
//    $files = array();
//    foreach ($directories as $directory) {
//        foreach ($extensions as $extension) {
//            foreach (glob("{$directory}/*.{$extension}") as $file) {
//                $files[$extension][] = $file;
//            }
//        }
//    }
    return $directories;
}

$originalxlsx = __DIR__ . "/../productimport/stnimport.xlsx";
$originalxls = __DIR__ . "/../productimport/stnimport.xls";
$originalcsv = __DIR__ . "/../productimport/stnimport.csv";

function get_product($sku) {
    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
    return $product;
}

if (file_exists($originalxlsx)) {
    $fileextension = strtolower(pathinfo($originalxlsx, PATHINFO_EXTENSION));
    $path = Mage::getBaseDir() . '/productimport';

    /** Babulal Start
    $category_id = 3;
    $category = Mage::getModel('catalog/category')->load($category_id);
    $collection = Mage::getResourceModel('catalog/product_collection')
    ->setStoreId(Mage::app()->getStore()->getId())
    ->addCategoryFilter($category);

    $jk = '1';
    if ($collection->count() > 0) {
    echo "<pre>";
    foreach ($collection as $productdata) {
    $productId = $productdata->getId();
    $allproductIds[] = $productId;
    echo $jk . '--' . $productdata->getId().'__'.$productdata->getSku() . '<br>';
    //            $product = Mage::getModel('catalog/product')->load($productId);
    //            $customOptions = $product->getOptions();
    //            foreach ($customOptions as $option) {
    //                $option->delete();
    //            }
    //            $product->setHasOptions(0);
    //            $product->save();
    //            Mage::getModel("catalog/product")->load($productId)->delete();
    $jk++;
    }
    }

    $allproductIdss = implode(',', $allproductIds);
    //$query = "SELECT value FROM catalog_product_entity_media_gallery WHERE `entity_id` =$productId";
    set_time_limit(0);
    ini_set('memory_limit', '1024M');

    $media = Mage::getBaseDir('media') . '/catalog/product';

    echo "Query database for images …<br>";
    $query = "SELECT value FROM catalog_product_entity_media_gallery WHERE `entity_id` IN($allproductIdss)";
    $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

    $images = findFiles($media, array('jpg'));
    $dbData = array();
    foreach ($data as $item) {
    foreach($images as $image)
    {
    echo $image.$item['value']. "<br>";
    @unlink($image.$item['value']);
    }
    }
    //exit;
    echo "Images found in database:" . count($dbData) . "<br>";

    echo "Search images in media directory …<br>";

    echo "Images found under directory ($media):" . count($images['jpg']) . "<br>";
    echo "<pre>";
    print_r($images);
    Babulal End
     */
//exit;
//    echo "Start removing images …<br>";
//    $removedCount = 0;
//    $skippedCount = 0;
//    foreach ($images['jpg'] as $image) {
//
//        $imageCleanup = str_replace($media, "", $image);
//        if (strpos($image, 'cache') !== false && isset($dbData[$imageCleanup])) {
//            echo "Skip cached image : $image<br>";
//            continue;
//        }
//
//
//        //echo "Skip image is in database : $imageCleanup<br>";
//        if (isset($dbData[$imageCleanup])) {
//            echo "Skip image is in database : $image<br>";
//            $skippedCount++;
//            continue;
//        } else {
//            echo "Remove image : $image<br>";
//            //if($testrun==false) unlink($image);
//            $removedCount++;
//        }
//    }
//
//    echo "Done, removed $removedCount images and skipped $skippedCount images.<br>";
//DELETE FROM catalog_category_product where product_id NOT IN (SELECT entity_id FROM (catalog_product_entity))

    $filepath = $originalxlsx;

    require_once('../productimport/excel_reader2.php');
    require_once('../productimport/SpreadsheetReader.php');
    $data = new SpreadsheetReader($filepath);
    $allnewproduct = array();
    $alloldproduct = array();
    $allupdatenewproduct = array();

    $shapeArr = array('RD' => 'Round', 'PS' => 'Princess', 'EM' => 'Emerald', 'EC' => 'Emerald', 'HS' => 'Heart', 'PR' => 'Pear', 'CU' => 'Cushion', 'RA' => 'Radiant', 'OV' => 'Oval', 'AS' => 'Asscher', 'AC' => 'Asscher', 'MQ' => 'Marquise');

    $bhdfbv = 1;

    // stop indexer for speed save() product
/*
    $processCollection = Mage::getSingleton('index/indexer')->getProcessesCollection();
    foreach($processCollection as $process) {
        $process
            ->setMode(Mage_Index_Model_Process::MODE_MANUAL)
            ->save();
    }
*/
    $error = 'none';
    $index_time = 0;
    try {
        foreach ($data as $Key => $row) {

            $chkexist = get_product(trim($row[2]));
            if (isset($row[22])) {
                if ($row[22] == '') {
                    $qty = 10;
                } else {
                    $qty = $row[22];
                }
            } else {
                $qty = 10;
            }
            if ($Key != 0 && !$chkexist && trim($row[5]) != '') {
                /*echo $Key . '___' . $row[2] . '<br>';
                echo trim($row[6]) . '<br>';
                echo trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond';
                exit;*/
                //echo $row[5].' Carat '. $this->_prepareDiamondType($row[6]).' Diamond';
                //$urlkey = Mage::getModel('catalog/product_url')->formatUrlKey( $row[5].' Carat '. $this->_prepareDiamondType($row[6]).' Diamond' );
                //echo  '<br>'.$urlkey.'<br>';
                //print_r($row); //die;

                $product = Mage::getModel('catalog/product');
                $product->setStoreId(1)
                    ->setWebsiteIds(array(1))
                    ->setAttributeSetId(4)
                    ->setTypeId('simple')
                    ->setCreatedAt(strtotime('now'))
                    ->setSku($row[2])
                    ->setName(trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond')
                    ->setWeight($row[5])
                    ->setStatus(1)
                    ->setPrice($row[3])
                    ->setTaxClassId(0)
                    ->setVisibility(3)
                    ->setDescription(trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond')
                    ->setShortDescription(trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond')
                    //->setStockData(array('use_config_manage_stock' => 0, 'manage_stock' => 1, 'is_in_stock' => 1, 'min_sale_qty' => 1, 'max_sale_qty' => 1, 'qty' => $qty))
                    ->setCategoryIds(array(3))
                    ->setDiamondGridle($row[18])
                    ->setDiamondClarity($row[9])
                    ->setDiamondCertificateUrl($row[1])
                    ->setDiamondColor($row[8])
                    ->setDiamondCut($row[10])
                    ->setDiamondCarat($row[7])
                    ->setDiamondDepth($row[16])
                    ->setDiamondFluorescence($row[15])
                    ->setDiamondMeasurement1($row[19])
                    ->setDiamondMeasurement2($row[20])
                    ->setDiamondMeasurement3($row[21])
                    ->setDiamondReportNumber($row[11])
                    ->setDiamondDiamondModel($row[2])
                    ->setDiamondPolish($row[13])
                    ->setDiamondSymmetry($row[14])
                    ->setDiamondShape($row[6])
                    ->setDiamondSupplier($row[0])
                    ->setDiamondPricePerCarat($row[4])
                    ->setDiamondWeight($row[5])
                    ->setDiamondTable($row[17])
                    ->setDiamondCert($row[12]);
                $product->save(); //die('12345');

                // Check if there is a stock item object
                $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product->getId());
                $stockItemData = $stockItem->getData();
//if (empty($stockItemData)) {
                // Create the initial stock item object
                $stockItem->setData('manage_stock', 1);
                $stockItem->setData('is_in_stock', $qty ? 1 : 0);
                $stockItem->setData('use_config_manage_stock', 0);
                $stockItem->setData('stock_id', 1);
                $stockItem->setData('product_id', $product->getId());
                $stockItem->setData('qty', $qty);
                $stockItem->save();

                // Init the object again after it has been saved so we get the full object
                //$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product->getId());
//}
// Set the quantity
                //$stockItem->setData('qty', $qty);
                //$stockItem->save();


                $allnewproduct[] = $product->getId();
                $allupdatenewproduct[] = $product->getId();
                echo $Key . '_' . $product->getId() . '_New___' . $row[2] . '<br>'.PHP_EOL;

            } elseif ($chkexist) {
                //echo $chkexist->getDescription();
                echo $Key . '_' . $chkexist->getId() . '_Old___' . $row[2] . 'Description___' . $chkexist->getDescription() . '<br>'. PHP_EOL;

                $alloldproduct[] = $chkexist->getId();
                $allupdatenewproduct[] = $chkexist->getId();
                $chkexist->setName($row[5] . ' Carat ' . $shapeArr[$row[6]] . ' Diamond')
                    ->setWeight($row[5])
                    ->setStatus(1)
                    ->setPrice($row[3])
                    ->setTaxClassId(0)
                    ->setVisibility(3)
                    ->setDescription($row[5] . ' Carat ' . $shapeArr[$row[6]] . ' Diamond')
                    ->setShortDescription($row[5] . ' Carat ' . $shapeArr[$row[6]] . ' Diamond')
                    //->setStockData(array('use_config_manage_stock' => 0, 'manage_stock' => 1, 'is_in_stock' => 1, 'min_sale_qty' => 1, 'max_sale_qty' => 1, 'qty' => $qty))
                    ->setDiamondGridle($row[18])
                    ->setDiamondClarity($row[9])
                    ->setDiamondCertificateUrl($row[1])
                    ->setDiamondColor($row[8])
                    ->setDiamondCut($row[10])
                    ->setDiamondCarat($row[7])
                    ->setDiamondDepth($row[16])
                    ->setDiamondFluorescence($row[15])
                    ->setDiamondMeasurement1($row[19])
                    ->setDiamondMeasurement2($row[20])
                    ->setDiamondMeasurement3($row[21])
                    ->setDiamondReportNumber($row[11])
                    ->setDiamondDiamondModel($row[2])
                    ->setDiamondPolish($row[13])
                    ->setDiamondSymmetry($row[14])
                    ->setDiamondShape($row[6])
                    ->setDiamondSupplier($row[0])
                    ->setDiamondPricePerCarat($row[4])
                    ->setDiamondWeight($row[5])
                    ->setDiamondTable($row[17])
                    ->setDiamondCert($row[12]);

                // Check if there is a stock item object
                $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($chkexist->getId());
                $stockItemData = $stockItem->getData();
//if (empty($stockItemData)) {
                // Create the initial stock item object
                $stockItem->setData('manage_stock', 1);
                $stockItem->setData('is_in_stock', $qty ? 1 : 0);
                $stockItem->setData('use_config_manage_stock', 0);
                $stockItem->setData('stock_id', 1);
                $stockItem->setData('product_id', $chkexist->getId());
                $stockItem->setData('qty', $qty);
                $stockItem->save();

                // Init the object again after it has been saved so we get the full object
                $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($chkexist->getId());
//}
// Set the quantity
                $stockItem->setData('qty', $qty);
                $stockItem->save();

                $chkexist->save(); //die('12345');
            }
            /*if ($bhdfbv%5 == 0) {
                 break;

             }*/
            $bhdfbv++;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    } finally {
        // restart indexer
/*
	echo "Start Indexer".PHP_EOL;
	$time = microtime(true);
        // reindex all manually
        $processCollection = Mage::getSingleton('index/indexer')->getProcessesCollection();
        foreach($processCollection as $process) {
            echo "process ".$process->getIndexer()->getName().PHP_EOL;
            $process->reindexEverything();
            $process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME);
            $process->save();
        }
        $index_time = microtime(true) - $time;
	echo "End Indexer in ".$index_time.PHP_EOL;
*/
    }



/*    echo "<pre>";
    echo "New Data<br>";
    //print_r($allnewproduct);
    echo "Old Data<br>";
    //print_r($alloldproduct);

    $to = "babulal.baburaj.jangir@gmail.com";
    $name="jason";
    $subject="test message";
    $header="From: $name";
    $message="Error: ".$error."<br>ReIndex Time: ".$index_time."<br><br>".implode(',',$allnewproduct).'<br>Old_'.implode(',',$alloldproduct);
    $sentmail=mail($to,$subject,$message,$header);
    echo $sentmail;

    $category = new Mage_Catalog_Model_Category();
    $category->load(3); //My cat id is 10
    $prodCollection = $category->getProductCollection();
    $prdIds = array();
    foreach ($prodCollection as $product) {
        $prdIds[] = $product->getId(); ///Store all th eproduct id in $prdIds array
        if(!in_array($product->getId(),$allupdatenewproduct)){
            $product = Mage::getModel('catalog/product')->load($product->getId())->delete();
            echo "successfully deleted product with ID: ". $product->getId() ."<br>";
        }
    }

    $to = "babulal.baburaj.jangir@gmail.com";
    $subject = "My subject : michaeltrio add diamonds";
    $txt = "Hello world!";
    $headers = "From: service@michaeltrio.com" . "\r\n" .
        "CC: ajaymanitripathi@gmail.com";

    @mail($to,$subject,$txt,$headers);

    print_r($prdIds);*/
    //$prdIds=array_diff($allnewproduct,$prdIds);
//    $result=array_diff($prdIds,$allnewproduct,$alloldproduct);
//    echo 'jhgdasgh hdasdjk ashdjhasdhjdgasjhd asjhasdkjashdjkasdhkjash';
//    print_r($result);

//    foreach ($prdIds as $key => $pId)
//        {
//            try
//            {
//                if(!in_array($pId,$allnewproduct) && !in_array($pId,$alloldproduct)){
//                $product = Mage::getModel('catalog/product')->load($pId)->delete();
//                echo "successfully deleted product with ID: ". $pId ."<br>";
//                }
//            }
//            catch (Exception $e)
//            {
//                echo "Could not delete product with ID: ". $pId ."<br>";
//            }
//        }
    if (unlink($originalxlsx)) {
        echo "success";
    } else {
        echo "fail";
    }
    exit;
} elseif (file_exists($originalxls)) {
    echo 'File "' . $originalxls . '_' . strtolower(pathinfo($originalxls, PATHINFO_EXTENSION));
} elseif (file_exists($originalcsv)) {
    echo 'File "' . $originalcsv . '_' . strtolower(pathinfo($originalcsv, PATHINFO_EXTENSION));
}


exit;

if ($fileextension['extension'] != 'csv') {
    //die('123 Success');
} else {
    echo "gbhfgb";
    exit;
    $filepath = fopen($filepath, "r");
    if ($row[22] == '') {
        $qty = 10;
    } else {
        $qty = $row[22];
    }
    $count = 0;
    while (($row = fgetcsv($filepath)) !== FALSE) {
        $chkexist = $this->get_product($Row[2]);
        if ($count != 0 && $chkexist) {
            $product = Mage::getModel('catalog/product');
            $product->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(4)
                ->setTypeId('simple')
                ->setCreatedAt(strtotime('now'))
                ->setSku($row[2])
                ->setName($row[5] . ' Carat ' . $this->_prepareDiamondType($row[6]) . ' Diamond')
                ->setWeight($row[5])
                ->setStatus(1)
                ->setPrice($row[3])
                ->setTaxClassId(0)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setDescription($row[5] . ' Carat ' . $this->_prepareDiamondType($row[6]) . ' Diamond')
                ->setShortDescription($row[5] . ' Carat ' . $this->_prepareDiamondType($row[6]) . ' Diamond')
                ->setStockData(array('use_config_manage_stock' => 0, 'manage_stock' => 1, 'is_in_stock' => 1, 'min_sale_qty' => 1, 'max_sale_qty' => 1, 'qty' => $qty))
                ->setCategoryIds(array(3))
                ->setDGirdle('test');
            $product->save();
            $entityId = $product->getId();
            $resource = Mage :: getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');
            $writeConnection = $resource->getConnection('write_read');
            $arrayCatProEnVarchar = array('145' => $arrayShape[$row[6]], '176' => $row[1], '174' => $row[5], '173' => $row[4], '172' => $row[2], '175' => $row[11], '171' => $row[1], '177' => $row[18], '178' => $row[19], '179' => $row[20], '180' => $row[21], '170' => $row[0]);
            foreach ($arrayCatProEnVarchar as $aryKey => $aryVal) {
                $query = "select * from catalog_product_entity_varchar where `entity_type_id`='4' and 	`attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ";
                $results = $readConnection->fetchAll($query);
                if (count($result) > 0) {
                    $writeConnection->query("update into catalog_product_entity_varchar set `value`='$aryVal' where `entity_type_id`='4' and `attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ");
                } else {
                    $writeConnection->query("insert into catalog_product_entity_varchar set `entity_type_id`='4' , 	`attribute_id`='$aryKey' , `store_id`='0' , `entity_id` ='$entityId', `value`='$aryVal'");
                }
            }
            $arrayCatProEnInt = array('153' => $arrayCut[$row[10]], '154' => $arrayColor[$row[8]], '155' => $arrayClarity[$row[9]], '165' => $arrayPolish[$row[13]], '167' => $arrayFluorescence[$row[15]], '166' => $arraySymmetry[$row[14]]);
            foreach ($arrayCatProEnInt as $aryKey => $aryVal) {
                $query = "select * from catalog_product_entity_int where `entity_type_id`='4' and 	`attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ";
                $results = $readConnection->fetchAll($query);
                if (count($result) > 0) {
                    $writeConnection->query("update into catalog_product_entity_int set `value`='$aryVal' where `entity_type_id`='4' and `attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ");
                } else {
                    $writeConnection->query("insert into catalog_product_entity_int set `entity_type_id`='4' , 	`attribute_id`='$aryKey' , `store_id`='0' , `entity_id` ='$entityId', `value`='$aryVal'");
                }
            }
            $arrayCatProEnDecimal = array('152' => $row[7], '168' => $row[16], '169' => $row[17]);
            foreach ($arrayCatProEnVarchar as $aryKey => $aryVal) {
                $query = "select * from catalog_product_entity_decimal where `entity_type_id`='4' and 	`attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ";
                $results = $readConnection->fetchAll($query);
                if (count($result) > 0) {
                    $writeConnection->query("update into catalog_product_entity_decimal set `value`='$aryVal' where `entity_type_id`='4' and `attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ");
                } else {
                    $writeConnection->query("insert into catalog_product_entity_decimal set `entity_type_id`='4' , 	`attribute_id`='$aryKey' , `store_id`='0' , `entity_id` ='$entityId', `value`='$aryVal'");
                }
            }
        }
        $count++;
    }

    fclose($filepath);
}
unlink($filepath);
?>
