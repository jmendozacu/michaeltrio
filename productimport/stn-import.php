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
ini_set('max_execution_time', -1);
ini_set('memory_limit', '1024M');
umask(0);
$resource = Mage::getSingleton('core/resource');
$readConnection = $resource->getConnection('core_write');
$deletereadConnection = $resource->getConnection('core_read');

/*Mage::app('admin')->setUseSessionInUrl(false);                                                                                                                 
//replace your own orders numbers here:
$test_order_ids=array(
  '10000000133',
  '10000000132',
  '10000000131',
  '10000000130',
  '10000000129',
  '10000000127',
  '10000000125'
);
foreach($test_order_ids as $id){
echo $id;
    try{
        Mage::getModel('sales/order')->loadByIncrementId($id)->delete();
        echo "order #".$id." is removed".PHP_EOL;
    }catch(Exception $e){
        echo "order #".$id." could not be remvoved: ".$e->getMessage().PHP_EOL;
    }
}
echo "complete.";
exit;*/
/*
Mage::app('default');
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
    try{
        $indexerByShell = '../shell/indexer.php';
        if(file_exists($indexerByShell))  
        {  
            $indexListByCode = array(
                           "catalog_product_attribute",
                           "catalog_product_price",
                           "catalog_product_flat",
                           "catalog_category_flat",
                           "catalog_category_product",
                           "catalog_url",
                           "catalogsearch_fulltext",
                           "cataloginventory_stock"
                    );
            //reindex using magento command line  
            foreach($indexListByCode as $indexer)  
            {  
                echo "reindex $indexer \n ";  
                exec("php $indexerByShell --reindex $indexer");  
            }
        }
    }catch(Exception $e){
        echo $e;
    }
	
	
	
	
	die;

*/
$prdIdsas=array();

	
$category = new Mage_Catalog_Model_Category();
$category->load(3); //My cat id is 10
$prodCollection = $category->getProductCollection();
$prdIds = array();
$prdSkuIds = array();
$bhdfbv='1';
foreach ($prodCollection as $product) {
//echo $product->getId();echo "<br>";

$prdIdsas[] = $product->getId();
$prdIds[] = array("sku"=>$product->getSku()); ///Store all th eproduct id in $prdIds array
}
/*echo implode(",",$prdIdsas);

exit;*/
//echo count($prdIds);die;


/*
$data = array();
for ($i = 1; $i <= 10; $i++) {

    $data[] = array(
        'sku' => $i,
    );
}
*/
$time = microtime(true);

//echo 'delete >> Elapsed time: ' . round(microtime(true) - $time, 2) . 's' . "\n";
/*Mage::getModel('fastsimpleimport/import')
    ->setPartialIndexing(true)
    ->setBehavior(Mage_ImportExport_Model_Import::BEHAVIOR_DELETE)
    ->processProductImport($prdIds);
	
//$deletereadConnection->query('DELETE FROM `core_url_rewrite` WHERE `product_id` IN ("'.implode(",",$prdIdsas).'")');
	
echo 'delete >> Elapsed time: ' . round(microtime(true) - $time, 2) . 's' . "\n";
exit;*/

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

function findFiles($directory, $extensions = array()) {

    function glob_recursive($directory, &$directories = array()) {
        foreach (glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder) {
            $directories[] = $folder;
            glob_recursive("{$folder}/*", $directories);
        }
    }
    glob_recursive($directory, $directories);

    return $directories;
}

$originalxlsx = __DIR__ . "/../productimport/JULY_2016_Diamond_list_sample_for_new_website_Old_version.xlsx";
$originalxls = __DIR__ . "/../productimport/stnimport.xls";
$originalcsv = __DIR__ . "/../productimport/stnimport.csv";

function get_product($sku) {
    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
    return $product;
}

if (file_exists($originalxlsx)) {
    $fileextension = strtolower(pathinfo($originalxlsx, PATHINFO_EXTENSION));
    $path = Mage::getBaseDir() . '/productimport';

  
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

function getUniqueCode($length = "")
{
    $code = md5(uniqid(rand(), true));
    if ($length != "") return substr($code, 0, $length);
    else return $code;
}


    $error = 'none';
    $index_time = 0;
	$productData = array();
		foreach ($data as $Key => $row) {
$randomString = getUniqueCode(20);
            
			$dcut = $row[10];
			
            if (isset($row[22])) {
                if ($row[22] == '') { $qty = 10; } else {  $qty = $row[22];}
            } else {  $qty = 10;}
            if ($Key != 0  && trim($row[5]) != '') {
				//product data array start from here 
				  $productData[] = array(
				  'store_id' => '1',
        'sku' => trim($row[2]),
        '_type' => 'simple',
		'attribute_set_id' => '4',
		'created_at' => strtotime('now'),
        '_attribute_set' => 'Default',
        '_product_websites' => 'base',
        '_category' => 3,
        'name' => trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond',
        'price' => $row[3],
		'final_price' => $row[3],
		'min_price' => $row[3],
		'max_price' => $row[3],
        'special_price' => '',
        'description' => trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond',
        'short_description' => trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond',
        'meta_title' => 'Default',
        'meta_description' => trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond',
        'meta_keyword' => trim($row[5]) . ' Carat ' . trim($shapeArr[$row[6]]) . ' Diamond',
        'weight' =>$row[5],
        'status' => 1,
        'visibility' => 3,
        'qty' => 10,
		'manage_stock'=>1,
		'use_config_manage_stock'=>0,
		'stock_id'=>1,
        'is_in_stock' =>  $qty ? 1 : 0,
        'enable_googlecheckout' => '1',
		'tax_class_id' => '0',
        'gift_message_available' => '0',
        'url_key' => strtolower(trim($row[5]) . '_carat_' . trim($shapeArr[$row[6]]) . '_diamond'),
		'diamond_price_per_carat'=>$row[4],
		'diamond_weight'=>$row[5],
		'diamond_table'=>$row[17],
		'diamond_cert'=>$row[12],
		'diamond_supplier'=>$row[0],
		'diamond_symmetry'=>$row[14],
		'diamond_gridle'=>$row[18],
		'diamond_color'=>$row[8],
		'diamond_clarity'=>$row[9],
		'diamond_certificate_url'=>$row[1],
		'diamond_fluorescence'=>$row[15],
		'diamond_cut'=>$dcut ? $dcut : '',
		'diamond_carat'=>$row[7],
		'diamond_depth'=>$row[16],
		'diamond_measurement3'=>$row[21],
		'diamond_measurement1'=>$row[19],
		'diamond_measurement2'=>$row[20],
		'diamond_diamond_model'=>$row[2],
		'diamond_report_number'=>$row[11],
		'diamond_polish'=>$row[13],
		'diamond_shape'=>$row[6]
		
		
		
    );
				
			}
            $prdSkuIds[] = trim($row[2]);
            $bhdfbv++;
        }
		
		$time = microtime(true);

try {
   
  $import = Mage::getModel('fastsimpleimport/import');
    $allget=$import->setBehavior(Mage_ImportExport_Model_Import::BEHAVIOR_APPEND)
	->processProductImport($productData);
	
} catch (Exception $e) {
    print_r($import->getErrorMessages());
}


  

echo 'insert >> Elapsed time: ' . round(microtime(true) - $time, 2) . 's' . "\n";
exit;
//DELETE FROM catalog_category_product where product_id NOT IN (SELECT entity_id FROM (catalog_product_entity))
/*$category = new Mage_Catalog_Model_Category();
$category->load(3); //My cat id is 10
//$prodCollection = $category->getProductCollection();
$prdIds = array();

foreach ($prodCollection as $product) {
if(!in_array($product->getSku(),$prdSkuIds)){
$product = Mage::getModel('catalog/product')->load($product->getId())->delete();
echo "successfully deleted product with ID: ". $product->getId() ."<br>";
}
}*/
	
	

$updatetime = microtime(true);


$prodCollection = $category->getProductCollection();
$prdIds = array();
$bhdfbv='1';
foreach ($prodCollection as $product) {
echo $product->getId().'__'.$product->getPrice().'<br>';
$prdIdsss=$product->getId();
/*$skutext = $readConnection->fetchall('SELECT * FROM `catalog_product_index_price` WHERE `entity_id` ="'.$prdIdsss.'" LIMIT 1');
if(empty($skutext))
{
}*/
/*	foreach($skutext as $key=>$skutextdata)
	{
$readConnection->insert("catalog_product_index_price",array("final_price" => $skutextdata['price'], "min_price" => $skutextdata['price'], "max_price" => $skutextdata['price']),"entity_id='".$prdIdsss."'");
	}*/
}
echo 'update >> Elapsed time: ' . round(microtime(true) - $updatetime, 2) . 's' . "\n";
  
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
    
	
	
} elseif (file_exists($originalxls)) {
    echo 'File "' . $originalxls . '_' . strtolower(pathinfo($originalxls, PATHINFO_EXTENSION));
} elseif (file_exists($originalcsv)) {
    echo 'File "' . $originalcsv . '_' . strtolower(pathinfo($originalcsv, PATHINFO_EXTENSION));
}


exit;

?>
