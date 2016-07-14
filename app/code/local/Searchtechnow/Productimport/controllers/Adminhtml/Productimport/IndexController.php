<?php
class Searchtechnow_Productimport_Adminhtml_Productimport_IndexController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
	
		$this->_title($this->__('System'))->_title($this->__('Searchtechnow Productimport'));        
		$this->loadLayout();
        $this->_initLayoutMessages('adminhtml/session');		
		$this->_setActiveMenu('searchtechnow_productimport');
        //$this->_addContent($this->getLayout()->createBlock('searchtechnow_productimport/adminhtml_productimport_index'));
        $this->renderLayout();
	}	
	public function importAction()
	{
		
		if($this->getRequest()->getPost()){
			$fileextension = pathinfo($_FILES['import_file']['name']);
			$allowedtype = array('application/vnd.ms-excel',
								 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
								 'application/csv','application/excel','text/csv');
								 
$temp = explode(".", $_FILES["import_file"]["name"]);
echo $newfilename = round(microtime(true)) . '.' . end($temp);

echo Mage::getBaseDir('var').'/productimport/' . $newfilename;

if (move_uploaded_file($_FILES["import_file"]["tmp_name"], Mage::getBaseDir('var').'/productimport/' . $newfilename)) {
    echo "Uploaded";
} else {
   echo "File was not uploaded";
}
exit;
			if($_FILES['import_file']['name'] != '' && ($fileextension['extension'] == 'xlsx' || $fileextension['extension'] == 'xls' || $fileextension['extension'] == 'csv')){
			

               /* switch ($fileextension['extension']) {
				case "xlsx":
				$fileextensionname="stnimport.xlsx";
				break;
				case "xls":
				$fileextensionname="stnimport.xls";
				break;
				case "csv":
				$fileextensionname="stnimport.csv";
				break;				
				}

				Mage::getSingleton('core/session')->addSuccess('Product import successful');
				$path = Mage::getBaseDir().'/productimport';				
				if(!is_dir($path)) {
					mkdir($path, 0777, true);
				}
				
				if (file_exists($path.'/'.$fileextensionname))
				{
				echo $_FILES["import_file"]["name"] . " already exists. ";
				exit;
				}
			    else
				{
				//move_uploaded_file($_FILES["file"]["tmp_name"], "../img/imageDirectory/" . $_FILES["file"]["name"]);
				//echo "Stored in: " . "../img/imageDirectory/" . $_FILES["import_file"]["name"];
				echo $filepath = $path.'/'.$_FILES["import_file"]["name"];
			    move_uploaded_file($_FILES['import_file']['tmp_name'], $filepath);
				chmod($filepath,0777);
				}
				exit;
*/
				Mage::getSingleton('core/session')->addSuccess('Product import successful');
				$path = Mage::getBaseDir('var').'/productimport';				
				if(!is_dir($path)) {
					mkdir($path, 0777, true);
				}
				echo $filepath = $path.'/'.$_FILES['import_file']['name'];
				move_uploaded_file($_FILES['import_file']['tmp_name'], $filepath);
				chmod($filepath,0777);
				exit;
				//$manufacturer = array();
				/*$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'manufacturer');
				foreach ( $attribute->getSource()->getAllOptions(true, true) as $option)
				{
					$manufacturer[$option['label']] = $option['value'];
				}*/
				/*$arrayFluorescence = array('NONE'=>81,'FAINT'=>82,'SLIGHT'=>83,'MEDIUM'=>84,'STRONG'=>85,'EXTREME'=>86);
				$arrayClarity=array('I3'=>96,'I2'=>95,'I1'=>94,'SI2'=>44,'SI1'=>45,'VS2'=>46,'VS1'=>47,'VVS2'=>48,'VVS1'=>49,'IF'=>50,'FL'=>51);
				$arrayColor = array('J'=>37,'I'=>38,'H'=>39,'G'=>40,'F'=>41,'E'=>42,'D'=>43);		
				$arrayCut = array('FR'=>63,'GD'=>36,'VG'=>35,'EX'=>62,'H&A'=>87);
				$arrayPolish = array('EP'=>88,'VP'=>89,'PO'=>90,'FR'=>68,'GD'=>73,'VG'=>72,'EX'=>67);
				$arraySymmetry = array('EP'=>91,'VP'=>92,'PO'=>93,'FR'=>75,'GD'=>80,'VG'=>79,'EX'=>74);
				$arrayShape = array('RD'=>25,'PS'=>61,'EC'=>59,'HS'=>23,'PR'=>24,'CU'=>58,'RA'=>56,'OV'=>26,'AS'=>57,'MQ'=>60);*/
				$shapeArr = array('RD'=>'Round','PS'=>'Princess','EC'=>'Emerald','HS'=>'Heart','PR'=>'Pear','CU'=>'Cushion','RA'=>'Radiant','OV'=>'Oval','AS'=>'Asscher','AC'=>'Asscher','MQ'=>'Marquise');
				if($fileextension['extension'] != 'csv'){
				require_once($path.'/excel_reader2.php');
				require_once($path.'/SpreadsheetReader.php');
				$data = new SpreadsheetReader($filepath);
				$data -> ChangeSheet(0);
				foreach ($data as $Key => $row)
				{
					$chkexist = $this->get_product($row[2]);
					if(isset($row[22])){
						if($row[22] == ''){
							$qty = 1; 
						} else { 
							$qty = $row[22]; 
						}
					} else { 
						$qty = 1; 
					}
					if($Key != 0 && !$chkexist && trim($row[5]) != ''){
						echo $Key.'<br>'; 
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
							->setName($row[5].' Carat '.$shapeArr[$row[6]].' Diamond' )
							->setWeight($row[5])
							->setStatus(1)
							->setPrice($row[3])
							->setTaxClassId(0) 
							->setVisibility(3)
							->setDescription($row[5].' Carat '.$shapeArr[$row[6]].' Diamond')
							->setShortDescription($row[5].' Carat '.$shapeArr[$row[6]].' Diamond')
							->setStockData(	array('use_config_manage_stock'=>0,	'manage_stock'=>1,'is_in_stock'=>1,'min_sale_qty'=>1,	'max_sale_qty'=>1,	'qty'=>$qty	))
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
					}
				}  //die('123 Success');
				} else {			
					$filepath = fopen($filepath,"r");
					 if($row[22]==''){ $qty=10; } else { $qty=$row[22]; }
					$count  = 0;
					while (($row = fgetcsv($filepath)) !== FALSE) {
						$chkexist = $this->get_product($Row[2]);
						if($count != 0 && $chkexist){
							$product = Mage::getModel('catalog/product');
							$product->setStoreId(1)
								->setWebsiteIds(array(1))
								->setAttributeSetId(4)
								->setTypeId('simple')
								->setCreatedAt(strtotime('now'))
								->setSku($row[2])
								->setName($row[5].' Carat '. $this->_prepareDiamondType($row[6]).' Diamond' )
								->setWeight($row[5])
								->setStatus(1)
								->setPrice($row[3])
								->setTaxClassId(0) 
								->setVisibility(   Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
								->setDescription($row[5].' Carat '. $this->_prepareDiamondType($row[6]).' Diamond')
								->setShortDescription($row[5].' Carat '. $this->_prepareDiamondType($row[6]).' Diamond')
								->setStockData(	array('use_config_manage_stock'=>0,	'manage_stock'=>1,'is_in_stock'=>1,'min_sale_qty'=>1,	'max_sale_qty'=>1,	'qty'=>$qty	))
								->setCategoryIds(array(3))
								->setDGirdle('test');
								$product->save();
								$entityId = $product->getId();
								$resource = Mage :: getSingleton('core/resource');
								$readConnection = $resource->getConnection('core_read');
								$writeConnection = $resource->getConnection('write_read');
								$arrayCatProEnVarchar = array('145'=>$arrayShape[$row[6]],'176'=>	$row[1],'174'=> $row[5],'173'=>$row[4],'172'=>$row[2],'175'=>$row[11],'171'=>$row[1],'177'=>$row[18],'178'=>$row[19],'179'=>$row[20],'180'=>$row[21],'170'=>$row[0]);
								foreach($arrayCatProEnVarchar  as $aryKey=>$aryVal)
								{
									$query ="select * from catalog_product_entity_varchar where `entity_type_id`='4' and 	`attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ";	
									$results	= $readConnection->fetchAll($query);
									if(count($result)>0){
										$writeConnection->query("update into catalog_product_entity_varchar set `value`='$aryVal' where `entity_type_id`='4' and `attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ");
									}else{
										$writeConnection->query("insert into catalog_product_entity_varchar set `entity_type_id`='4' , 	`attribute_id`='$aryKey' , `store_id`='0' , `entity_id` ='$entityId', `value`='$aryVal'");
									}
								}
								$arrayCatProEnInt = array('153'=>$arrayCut[$row[10]],'154'=>$arrayColor[$row[8]],'155'=> $arrayClarity[$row[9]],'165'=>$arrayPolish[$row[13]],'167'=>$arrayFluorescence[$row[15]],'166'=>$arraySymmetry[$row[14]]);
								foreach($arrayCatProEnInt  as $aryKey=>$aryVal)
								{
									$query ="select * from catalog_product_entity_int where `entity_type_id`='4' and 	`attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ";	
									$results	= $readConnection->fetchAll($query);
									if(count($result)>0){
										$writeConnection->query("update into catalog_product_entity_int set `value`='$aryVal' where `entity_type_id`='4' and `attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ");
									}else{
										$writeConnection->query("insert into catalog_product_entity_int set `entity_type_id`='4' , 	`attribute_id`='$aryKey' , `store_id`='0' , `entity_id` ='$entityId', `value`='$aryVal'");
									}
								}
								$arrayCatProEnDecimal = array('152'=>$row[7],'168'=>$row[16],'169'=> $row[17]);
								foreach($arrayCatProEnVarchar  as $aryKey=>$aryVal)
								{
									$query ="select * from catalog_product_entity_decimal where `entity_type_id`='4' and 	`attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ";
									$results	= $readConnection->fetchAll($query);
									if(count($result)>0){
										$writeConnection->query("update into catalog_product_entity_decimal set `value`='$aryVal' where `entity_type_id`='4' and `attribute_id`='$aryKey' and `store_id`='0' and `entity_id`='$entityId' ");
									}else{
										$writeConnection->query("insert into catalog_product_entity_decimal set `entity_type_id`='4' , 	`attribute_id`='$aryKey' , `store_id`='0' , `entity_id` ='$entityId', `value`='$aryVal'");
									}
								}
						}
						$count++;
					}
					
					fclose($filepath);
				}
				unlink($filepath);
				$this->_redirect('adminhtml/productimport_index');       		
			} else {
				Mage::getSingleton('core/session')->addError('Please upload only csv, xlsx, xls file !!');
				$this->_redirect('adminhtml/productimport_index');	
			}
		} else {
			$this->_redirect('adminhtml/productimport_index');
		}
	}
	protected function _save_image($img) {
		$imageFilename      = basename($img);
		$filename           = strtotime('now').'.jpg'; 
		$filepath           = Mage::getBaseDir('media') . DS . 'import'. DS . $filename; 
		$path = Mage::getBaseDir('media') . DS . 'import';
		if(!is_dir($path)) {
			mkdir($path, 0777, true);
		}
		$newImgUrl          = file_put_contents($filepath, file_get_contents(trim($img)));
		return $filepath;	
	}
	protected function get_product($sku){
		$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku); 
		return $product;        
	}
	protected function _prepareDiamondType($shape)
    {
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
