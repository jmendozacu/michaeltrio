<?PHP
class Krunal_Packer_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){
		// ini_set('memory_limit','512M');
		// session_start();
		// error_reporting(E_ALL);
		// ini_set('display_errors','on');
		include 'excel/excel_reader.php';
		$excel = new PhpExcelReader;
		echo '<script>setTimeout(function(e){window.location.reload(true);},200000);</script>';
		$excel->read('app/code/community/Krunal/Packer/controllers/excel/alldata.xls');
		
		$lastRead = isset($_SESSION['lr']) ? $_SESSION['lr'] : 2;
		
		$x = $lastRead;
		
		$nr_sheets = count($excel->sheets);
		$sheet = $excel->sheets[0];
		echo '<pre>';
		
		$sheet['cells'][1] = array_values($sheet['cells'][1]);
		print_r($sheet['cells'][1]);
		while($x <= $sheet['numRows']) {
			
			Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
			$product = Mage::getModel('catalog/product');
		try{
			
			$sheet['cells'][$x] = array_values($sheet['cells'][$x]);
			
			$id = Mage::getModel('catalog/product')->getResource()->getIdBySku($sheet['cells'][$x][3]);
			if (!$id) {
				
			
			
			$dshape = $sheet['cells'][$x][9];
		switch($dshape){
			case 'AS':	$dshape = 57;	break;
			case 'CU':	$dshape = 58;	break;
			case 'EC':	$dshape = 59;	break;
			case 'HS':	$dshape = 23;	break;
			case 'MQ':	$dshape = 60;	break;
			case 'OV':	$dshape = 26;	break;
			case 'PR':	$dshape = 24;	break;
			case 'PS':	$dshape = 61;	break;
			case 'RA':	$dshape = 56;	break;
			case 'RD':	$dshape = 25;	break;
		}
		
		$dcolor = $sheet['cells'][$x][11];
		switch($dcolor){
			case 'D':	$dcolor = 43;	break;
			case 'F':	$dcolor = 42;	break;
			case 'F':	$dcolor = 41;	break;
			case 'G':	$dcolor = 40;	break;
			case 'H':	$dcolor = 39;	break;
			case 'I':	$dcolor = 38;	break;
			case 'J':	$dcolor = 37;	break;
		}
		
		$dclarity = $sheet['cells'][$x][12];
		switch($dclarity){
			case 'FL':	$dclarity = 51;	break;
			case 'IF':	$dclarity = 50;	break;
			case 'VVS1':	$dclarity = 49;	break;
			case 'VVS2':	$dclarity = 48;	break;
			case 'VS1':	$dclarity = 47;	break;
			case 'VS2':	$dclarity = 46;	break;
			case 'SI1':	$dclarity = 45;	break;
			case 'SI2':	$dclarity = 44;	break;
			case 'I1':	$dclarity = 94;	break;
			case 'I2':	$dclarity = 95;	break;
			case 'I3':	$dclarity = 96;	break;
		}
		
		$dcut = $sheet['cells'][$x][13];
		switch($dcut){
			case 'H&A':	$dcut = 87;	break;
			case 'EX':	$dcut = 62;	break;
			case 'VG':	$dcut = 35;	break;
			case 'GD':	$dcut = 36;	break;
			case 'FR':	$dcut = 63;	break;
		}
		
		$dpolish = $sheet['cells'][$x][16];
		switch($dpolish){
			case 'EX':	$dpolish = 67;	break;
			case 'VG':	$dpolish = 72;	break;
			case 'GD':	$dpolish = 73;	break;
			case 'FR':	$dpolish = 68;	break;
			case 'PO':	$dpolish = 90;	break;
			case 'VP':	$dpolish = 89;	break;
			case 'EP':	$dpolish = 88;	break;
		}
		
		$dsym = $sheet['cells'][$x][17];
		switch($dsym){
			case 'EX':	$dsym = 74;	break;
			case 'VG':	$dsym = 79;	break;
			case 'GD':	$dsym = 80;	break;
			case 'FR':	$dsym = 75;	break;
			case 'PO':	$dsym = 93;	break;
			case 'VP':	$dsym = 92;	break;
			case 'EP':	$dsym = 91;	break;
		}
		
		$dflur = $sheet['cells'][$x][18];
		switch($dflur){
			case 'NONE':	$dflur = 81;	break;
			case 'FAINT':	$dflur = 82;	break;
			case 'SLIGHT':	$dflur = 83;	break;
			case 'MEDIUM':	$dflur = 84;	break;
			case 'STRONG':	$dflur = 85;	break;
			case 'EXTREME':	$dflur = 86;	break;
		}
		
		
		$product
			->setStoreId(1)
			->setWebsiteIds(array(1))
			->setAttributeSetId(9)
			->setTypeId('simple') //product type
			->setCreatedAt(strtotime('now'))
			->setSku($sheet['cells'][$x][3]) //SKU
			->setName($sheet['cells'][$x][2]) //product name
			->setWeight((float)$sheet['cells'][$x][8])
			->setStatus(1)
			->setTaxClassId(4)
			->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)		 
			->setPrice(substr($sheet['cells'][$x][4],1))
			->setCost(substr($sheet['cells'][$x][4],1))
			->setMetaTitle($sheet['cells'][$x][2])
			->setMetaKeyword($sheet['cells'][$x][2])
			->setMetaDescription($sheet['cells'][$x][7])
			->setDescription($sheet['cells'][$x][7])
			->setShortDescription($sheet['cells'][$x][7])
			->setMediaGallery (array('images'=>array (), 'values'=>array ()))
			->setStockData(array(
							   'use_config_manage_stock' => 0, //'Use config settings' checkbox
							   'manage_stock'=>1, //manage stock
							   'min_sale_qty'=>1, //Minimum Qty Allowed in Shopping Cart
							   'max_sale_qty'=>2, //Maximum Qty Allowed in Shopping Cart
							   'is_in_stock' => 1, //Stock Availability
							   'qty' => $sheet['cells'][$x][6] //qty
						   )
			)
			->setSupplier($sheet['cells'][$x][0])
			->setCert_url($sheet['cells'][$x][1])
			->setD_model($sheet['cells'][$x][3])
			->setPrice_carat($sheet['cells'][$x][5])
			->setD_weight((float)$sheet['cells'][$x][8])
			->setShape($dshape)
			->setD_carat((float)$sheet['cells'][$x][10])
			->setD_color($dcolor)
			->setD_clarity($dclarity)
			->setD_cut($dcut)
			->setD_rep_no($sheet['cells'][$x][14])
			->setD_cert($sheet['cells'][$x][15])
			->setD_polish($dpolish)
			->setD_symmetry($dsym)
			->setD_fluorescence($dflur)
			->setD_depth($sheet['cells'][$x][19])
			->setD_table($sheet['cells'][$x][20])
			->setD_girdle($sheet['cells'][$x][21])
			->setD_m1($sheet['cells'][$x][21])
			->setD_m2($sheet['cells'][$x][22])
			->setD_m3($sheet['cells'][$x][23])
			->setCategoryIds(array(3)); //assign product to categories
			$s = $product->save();
			
			
			$product = Mage::getModel('catalog/product')->load($product->getId());
    		$product->setData('supplier', $sheet['cells'][$x][0])->getResource()->saveAttribute($product, 'supplier');
			$product->setData('cert_url', $sheet['cells'][$x][1])->getResource()->saveAttribute($product, 'cert_url');
			$product->setData('d_model', $sheet['cells'][$x][3])->getResource()->saveAttribute($product, 'd_model');
			$product->setData('price_carat', $sheet['cells'][$x][5])->getResource()->saveAttribute($product, 'price_carat');
			$product->setData('d_weight', $sheet['cells'][$x][8])->getResource()->saveAttribute($product, 'd_weight');
			$product->setData('shape', $dshape)->getResource()->saveAttribute($product, 'shape');
			$product->setData('d_carat', $sheet['cells'][$x][10])->getResource()->saveAttribute($product, 'd_carat');
			$product->setData('d_color', $dcolor)->getResource()->saveAttribute($product, 'd_color');
			$product->setData('d_clarity', $dclarity)->getResource()->saveAttribute($product, 'd_clarity');
			$product->setData('d_cut', $dcut)->getResource()->saveAttribute($product, 'd_cut');
			$product->setData('d_rep_no', $sheet['cells'][$x][14])->getResource()->saveAttribute($product, 'd_rep_no');
			$product->setData('d_cert', $sheet['cells'][$x][15])->getResource()->saveAttribute($product, 'd_cert');
			$product->setData('d_polish', $dpolish)->getResource()->saveAttribute($product, 'd_polish');
			
			
			$product->setData('d_symmetry', $dsym)->getResource()->saveAttribute($product, 'd_symmetry');
			$product->setData('d_fluorescence', $dflur)->getResource()->saveAttribute($product, 'd_fluorescence');
			$product->setData('d_depth', $sheet['cells'][$x][19])->getResource()->saveAttribute($product, 'd_depth');
			$product->setData('d_table', $sheet['cells'][$x][20])->getResource()->saveAttribute($product, 'd_table');
			
			if(is_numeric($sheet['cells'][$x][21])){
				$product->setData('d_girdle','')->getResource()->saveAttribute($product, 'd_girdle');
				$product->setData('d_m1', $sheet['cells'][$x][21])->getResource()->saveAttribute($product, 'd_m1');
				$product->setData('d_m2', $sheet['cells'][$x][22])->getResource()->saveAttribute($product, 'd_m2');
				$product->setData('d_m3', $sheet['cells'][$x][23])->getResource()->saveAttribute($product, 'd_m3');
			}else{
				$product->setData('d_girdle', $sheet['cells'][$x][21])->getResource()->saveAttribute($product, 'd_girdle');
				$product->setData('d_m1', $sheet['cells'][$x][22])->getResource()->saveAttribute($product, 'd_m1');
				$product->setData('d_m2', $sheet['cells'][$x][23])->getResource()->saveAttribute($product, 'd_m2');
				$product->setData('d_m3', $sheet['cells'][$x][24])->getResource()->saveAttribute($product, 'd_m3');
			}
			
			
			
			
			if($s){
				echo 'Product Added Data -><br>';
				print_r($sheet['cells'][$x]);
				
			}
			}else{
				echo '<br> Product with SKU already added. '.$sheet['cells'][$x][3].'<br>';
			}
		}catch(Exception $e){
			echo ($e->getMessage());
		}			
			
	
			echo '<br>';
				$x++;
				$_SESSION['lr'] = $x;
		}
	
		
		
		
		exit;
		
		echo '<pre>';
		var_export($excel->sheets);
		echo '</pre>';
		exit;
    }
	
	public function getProductAction(){
		$pid = $this->getRequest()->getPost('id');
		$_product = Mage::getModel('trd_importxls/importxls')->load($pid);

		if (!Mage::getSingleton('core/session')->getDiamondProdId()) {
			$tempProdId = Mage::getModel('trd_diamond/diamondprod')->load(1);
			Mage::getSingleton('core/session')->setDiamondProdId($tempProdId->getProductId());
		} else {
			$tempProdId = Mage::getSingleton('core/session')->getDiamondProdId();
		}

		$clr = array();
		$clr['AS'] = 'asscher';
		$clr['CU'] = 'cushion';
		$clr['EC'] = 'emerald';
		$clr['HS'] = 'heart';
		$clr['MQ'] = 'marquise';
		$clr['OV'] = 'oval';
		$clr['PR'] = 'pear';
		$clr['PS'] = 'princess';
		$clr['RA'] = 'radiant';
		$clr['RD'] = 'round';

		$_currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();

		$price = $_product->getDiamondsPrice();
		if ($_currentCurrencyCode == 'USD') {
			$price = number_format(Mage::helper('directory')->currencyConvert($price, 'SGD', 'USD'), 2, '.', '');
		}

		$formattedPrice = $_currentCurrencyCode . ' $' . $price;

		$formattedName = strtolower(str_replace(' ', '-', $_product->getDiamondsName()));
		$formattedUrl = Mage::getBaseUrl() . 'diamond-' . $tempProdId . '-' . $pid . '-' . $formattedName . '.html';

		$output = '

		<!-- <div class="item-block-wbtm sidebar-top-buttons">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center" style="border-right: 1px solid rgba(221, 229, 237, 0.4);">
						<a class="fcdark closeItemInfo" href="#">
    					<i class="fa fa-long-arrow-left "></i> CLOSE DETAILS </a>
					</td>
					<td align="center">
						<a class="fcdark more-item-info" href="#"> MORE DETAILS
							<i class="fa fa-long-arrow-right "></i></a>
					</td>
				</tr>
			</table>
    	</div> -->

    <div style="display: none" class="item-block-wbtm text-right">
    	<a class="fcdark" href="'. Mage::getBaseUrl() .'diamond-'.$tempProdId.'-'.$formattedName.'">MORE DETAILS <i class="fa fa-long-arrow-right pl20"></i></a>
    </div>
    <div class="item-details">
    <h1 class="item-name">' . $_product->getDiamondsName() . '</h1>
    <div class="item-price">
    	<h2 data-id="' . $_product->getId() . '" data-price="' . $price . '">'.$formattedPrice.'</h2>
    	<small>PRICE DOES NOT INCLUDE TAX/DUTY</small>
    </div>
    
    <div class="details-img-holder" style="text-align: center;">
    	<img src="media/wysiwyg/icotheme/diamonds_pics/' . strtolower($_product->getShape()) . '_t.jpg" alt="">
    	<img src="media/wysiwyg/icotheme/diamonds_pics/' . strtolower($_product->getShape()) . '_s.jpg" alt="">
    
    </div>
    	
    <div class="item-actions">
    <div class="item-actions-head go-to-step2" diamond="'.$_product->getImportxlsId().'">
    ADD TO YOUR RING <i class="fa fa-long-arrow-down pl20"></i>
    </div>
    <div class="item-action clearfix go-to-step2" diamond="'.$_product->getImportxlsId().'">
    ADD TO YOUR RING <i class="fa fa-long-arrow-right pull-right"></i>
    </div>
    <div class="item-action clearfix">
	<a href="javascript:;" class="add-diamond-to-cart" did="'.$pid.'">ADD TO SHOPPING BASKET 
		
		<span class="spinner-container">
			<div class="spinner">
			  <div class="rect1"></div>
			  <div class="rect2"></div>
			  <div class="rect3"></div>
			  <div class="rect4"></div>
			  <div class="rect5"></div>
			</div>
		</span>

	 <i class="fa fa-long-arrow-right pull-right"></i></a>
    </div>
    <div class="item-action clearfix">
    	<a data-id="'.$_product->getImportxlsId().'" class="addTocomparefromView" href="javascript:void(0);">ADD TO DIAMOND COMPARISON <i class="fa fa-long-arrow-right pull-right"></i></a>
    </div>
   </div>
   
   <div class="item-props">
    <div class="clearfix item-prop">
    	<div class="item-prop-label">Carat

    	<img class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>
                    
            <div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
              <div class="arrow"></div>
              <h3 class="pop-title">Carat (ct.)<a href="#" class="close_pop">&times;</a></h3>
        
              <div class="popover-content text-center">
              <p>
              The international unit of weight, used for measuring diamonds and gemstones. 1 carat is equal to 200 milligrams, or 0.2 grams. 
              </p>
              
              </div>
            </div>

    	</div>
    	<div class="item-prop-value">'.round($_product->getCarat(),2).'</div>
    </div>
    
    <div class="clearfix item-prop">
    	<div class="item-prop-label">Shape

    		<img style="" class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>
                    
            <div class="popover fade bottom in mypop d-shapes-popover" style="position: fixed; width: 260px;">
              <div class="arrow"></div>
              <h3 class="pop-title">DIAMOND SHAPE <a href="#" class="close_pop">&times;</a></h3>
        
              <div class="popover-content pop-diamonds-shape text-center">
               	<table width="100%" cellspacing="0" cellpadding="0" border="0">
               		<tr>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/round.png" alt="">
               					<br>
               					
               				</div>
               				<span>Round</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/princess.png" alt="">
               					<br>
               					
               				</div>
               				<span>Princess</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/emerald.png" alt="">
               					<br>
               					
               				</div>
               				<span>Emerald</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/heart.png" alt="">
               					<br>
               					
               				</div>
               				<span>Heart</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/pear.png" alt="">
               					<br>
               					
               				</div>
               				<span>Pear</span>
               			</td>
               		</tr>
               		<tr>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/cushion.png" alt="">
               					<br>
               					
               				</div>
               				<span>Cushion</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/radiant.png" alt="">
               					<br>
               					
               				</div>
               				<span>Radiant</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/oval.png" alt="">
               					<br>
               					
               				</div>
               				<span>Oval</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/asscher.png" alt="">
               					<br>
               					
               				</div>
               				<span>Asscher</span>
               			</td>
               			<td>
               				<div class="img-holder">
               					<img src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/shape/marquise.png" alt="">
               					<br>
               					
               				</div>
               				<span>Marquise</span>
               			</td>
               		</tr>
               	</table>
              
              </div>
            </div>

    	</div>
    	<div class="item-prop-value sidebar-shape-value ">'. $clr[$_product->getShape()] . '</div>
    </div>';

    $_cut = $_product->getCut();
    switch ($_cut) {
    	case 'Signature Ideal':
    		break;
    	
    	case 'H&A':
    			$_cut = 'Signature Ideal';
    		break;

    	case 'EX':
    			$_cut = 'Excellent';
    		break;

    	case 'VG':
    			$_cut = 'Very Good';
    		break;

    	case 'GD':
    			$_cut = 'Good';
    		break;

    	case 'FR':
    			$_cut = 'Fair';
    		break;
    	
    	default:
    		# code...
    		break;
    }

    $output .= '<div class="clearfix item-prop">
    	<div class="item-prop-label">Cut

    		<img style="" class="info_title it_small" src="'. Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>

            <div class="popover fade bottom in mypop" style="position: fixed; width: 260px;">
              <div class="arrow"></div>
              <h3 class="pop-title">DIAMOND CUT <a href="#" class="close_pop">&times;</a></h3>
        
              <div class="popover-content text-center">
               <img class="cut_show_img" src="'. Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) .'frontend/base/default/packer/images/cut/SIG_ID.png" />
              
              <div class="grey_box_con">
              CHOOSE A CLARITY GRADE:
              </div>
              <div class="btn-grp-con">
              <div class="mbtn mbtn-lg active" data-container=".cut_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/cut/SIG_ID.png">
              SIGNATURE IDEAL
              </div>
              <div class="mbtn mbtn-lg" data-container=".cut_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/cut/EXCELLENT.png">
              EXCELLENT
              </div>
              <div class="mbtn" data-container=".cut_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/cut/VERY_GOOD.png">
              VERY GOOD
              </div>
               <div class="mbtn" data-container=".cut_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/cut/GOOD.png">
              GOOD
              </div>
               <div class="mbtn" data-container=".cut_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/cut/FAIR.png">
              FAIR
              </div>
              </div>
              
              <p>
              	<b>Signature Ideal cut:</b> Top 1% of
				diamond quality - with precise
				proportions, polish and symmetry =
				allowing the diamond to reflect even
				more light than the standard Ideal cut.
              </p>
              
              </div>
            </div>

    	</div>
    	<div class="item-prop-value">'. $_cut .'</div>
    </div>';

    $output .= '<div class="clearfix item-prop">
    <div class="item-prop-label">Color

    	<img style="" class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>

        <div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
          <div class="arrow"></div>
          <h3 class="pop-title">DIAMOND COLOUR <a href="#" class="close_pop">&times;</a></h3>
    
          <div class="popover-content text-center">
           <img class="color_show_img" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/color/color_df.png" />
          
          <div class="grey_box_con">
          CHOOSE A COLOUR GRADE:
          </div>
          <div class="btn-grp-con">
          <div class="mbtn mbtn-lg active" data-container=".color_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/color/color_df.png">
          D-F
          </div>
          <div class="mbtn mbtn-lg" data-container=".color_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/color/color_gi.png">
         	G-I
          </div>
          <div class="mbtn" data-container=".color_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/color/color_jk.png">
          J-K
          </div>
          
          </div>
          
          <p>
          Highest,  absolutely colourless grade,appreciated best set in platinum orwhite gold. Exceptionally rare.
          </p>
          
          </div>
        </div>

    </div>

    <div class="item-prop-value">'.$_product->getColor().'</div>
    </div>

    <div class="clearfix item-prop">
    	<div class="item-prop-label">Clarity

    		<img class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>
                    
            <div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
              <div class="arrow"></div>
              <h3 class="pop-title">DIAMOND CLARITY <a href="#" class="close_pop">&times;</a></h3>
        
              <div class="popover-content text-center">
               <img class="clr_show_img" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/clarity/cl_vfl-tl.png" />
              
              <div class="grey_box_con">
              CHOOSE A CLARITY GRADE:
              </div>
              <div class="btn-grp-con">
              <div class="mbtn mbtn-lg active" data-container=".clr_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/clarity/cl_vfl-tl.png">
              FL-IF
              </div>
              <div class="mbtn mbtn-lg" data-container=".clr_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/clarity/cl_vvs1-vvs2.png">
              VVS1-VVS2
              </div>
              <div class="mbtn" data-container=".clr_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/clarity/cl_vs1-vs2.png">
             VS1-VS2	
              </div>
               <div class="mbtn" data-container=".clr_show_img" data-img="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/clarity/cl_si1-si2.png">
              SI1-SI2
              </div>
               
              </div>
              
              <p>
              <b>FLAWLESS</b>: NO INTERNAL OR EXTERNAL
				CHARACTERISTICS. INTERNALLY FLAWLESS:
				MAY HAVE EXTERNAL BLEMISHES ONLY. BOTH
				EXTREMELY RARE.
              </p>
              
              </div>
            </div>

    	</div>
    	<div class="item-prop-value">'.$_product->getClarity().'</div>
    </div>

    <div class="clearfix item-prop">
    	<div class="item-prop-label">Depth %

    		<img class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>
            <div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
              <div class="arrow"></div>
              <h3 class="pop-title">Depth percentage <a href="#" class="close_pop">&times;</a></h3>
        
              <div class="popover-content text-center">
              <p>
              The height of a diamond, measured from the culet to the table, divided by its average girdle diameter. One of the basic proportions that contributes to a diamond\'s appearance, brilliance and fire. 
              </p>
              
              </div>
            </div>

    	</div>
    	<div class="item-prop-value">'.$_product->getDepth().'</div>
    </div>
    
    <div class="clearfix item-prop">
    	<div class="item-prop-label">Table %

    		<img class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>
            <div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
              <div class="arrow"></div>
              <h3 class="pop-title">Table percentage <a href="#" class="close_pop">&times;</a></h3>
        
              <div class="popover-content text-center">
              <p>
              	The width of the diamond\'s table expressed as a percentage of its average diameter. A component of the overall cut grade, this measurement is critical to a diamond\'s light performance. 
              </p>
              
              </div>
            </div>

    	</div>
    	<div class="item-prop-value">'.$_product->getTableField().'</div>
    </div>

    <div class="clearfix item-prop">
    	<div class="item-prop-label">Polish

    		<img src="' .  Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png" class="info_title it_small">
          	<div style="position: fixed; top: 30px; left: -100px; width: 260px;" class="popover fade bottom in mypop">
            	<div class="arrow"></div>
            	<h3 class="pop-title">Polish <a class="close_pop" href="#">x</a></h3>
            	<div class="popover-content text-center">
              		<p> The overall condition of a finished diamond\'s faceted surfaces, including how smoothly the facets have been polished, whether any marks are visible from the polishing wheel, and how defined the edges of each facet are. Polish marks are almost always invisible to the unaided eye, but good polish is essential for maximum light performance. </p>
            	</div>
          	</div>

    	</div>
    	<div class="item-prop-value">'.$_product->getPolish().'</div>
    </div>
    
    <div class="clearfix item-prop">
    	<div class="item-prop-label">Symmetry

    		<img class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>
                   	
           	<div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
              	<div class="arrow"></div>
              	<h3 class="pop-title">Symmetry <a href="#" class="close_pop">&times;</a></h3>
        
              	<div class="popover-content text-center">
                <p>
                The precision and alignment of a diamond\'s facets and the resulting effects on its brilliance. 
                </p>

              	<img style="width:212px;" src="' . Mage::getBaseUrl() . 'skin/frontend/puro/default/images/diamonds_filter/symmetry.png" alt="">
              
            	</div>
            </div>

    	</div>
    	<div class="item-prop-value">'.$_product->getSymmetry().'</div>
    </div>';
    
    
    $girdle = $_product->getGridle();
    if( !empty($girdle) ) {
    	$output .= '<div class="clearfix item-prop">
	    	<div class="item-prop-label">Girdle</div>
	    	<div class="item-prop-value">'.$_product->getSymmetry().'</div>
	    </div>';
    }

    
    $output .= '

    <div class="clearfix item-prop">
    	<div class="item-prop-label">Fluorescence

    		<img class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>
            <div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
              <div class="arrow"></div>
              <h3 class="pop-title">Fluorescence <a href="#" class="close_pop">&times;</a></h3>
        
              <div class="popover-content text-center">
              <p>
              A measure of the visible light some diamonds emit when exposed to ultraviolet (UV) rays. Diamonds with a strong or very strong fluorescence are a better value because the market prices them slightly lower. It is quite rare for fluorescence to have any visual impact on a diamond\'s appearance, and it does not compromise the gem\'s structural integrity in any way. 
              </p>
              
              </div>
            </div>

    	</div>
    	<div class="item-prop-value">'.$_product->getFluorescence().'</div>
    </div>

    <div class="clearfix item-prop">
    	<div class="item-prop-label">Measurements</div>
    	<div class="item-prop-value"> '.sprintf('%0.2f', $_product->getMeasurement_1()).' x '. sprintf('%0.2f', $_product->getMeasurement_2()).' x '. sprintf('%0.2f', $_product->getMeasurement_3()) .' mm</div>
    </div>

    <!--
    <div class="clearfix item-prop">
    <div class="item-prop-label">Date Added</div>
    </div>
    -->
	
	<div class="clearfix item-prop">
    	<div class="item-prop-label" style="width:100%;">Diamond Grading Report

    		<img style="" class="info_title it_small" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/packer/images/info.png"/>

    		<div class="popover fade bottom in mypop" style="position: fixed; top: 30px; left: -100px; width: 260px;">
				<div class="arrow"></div>
				<h3 class="pop-title">Diamond Grading Report <a href="#" class="close_pop">&times;</a></h3>

				<div class="popover-content text-center">
					<p>
						A report documenting a diamond\'s dimensions, proportions, clarity, color, finish, symmetry and other characteristics. Each loose diamond at Blue Nile is accompanied by one of these reports, created by gemologists from either the Gemological Institute of America (GIA) or the American Gem Society Laboratories (AGSL).
					</p>
				</div>
	        </div>
    	</div>
    	<div class="item-prop-value" style="text-align: center;float: none;">
    		<a target="_blank" href="'.$_product->getCertUrl().'">
    			<img style="margin-top: 8px;" src="media/wysiwyg/icotheme/GIA_200x100.jpg">
    		</a>
    	</div>
    </div>

    
    </div>
    </div>';

    echo json_encode(array('html' => $output, 'diamond_url' => $formattedUrl));
	}
	
	public function getCompareAction(){
		error_reporting(E_ALL);
		ini_set('display_errors','on');
		$clr = array();
		$clr['AS'] = 'asscher';
		$clr['CU'] = 'cushion';
		$clr['EC'] = 'emerald';
		$clr['HS'] = 'heart';
		$clr['MQ'] = 'marquise';
		$clr['OV'] = 'oval';
		$clr['PR'] = 'pear';
		$clr['PS'] = 'princess';
		$clr['RA'] = 'radiant';
		$clr['RD'] = 'round';
		$pid = $this->getRequest()->getPost('id');
		for($pi=0;$pi<count($pid);$pi++){
			$_product = Mage::getModel('catalog/product')->load($pid[$pi]);
			
			echo ' 
        <tr data-id="'.$_product->getId().'" class="item_ajax_get_details" '.($pi % 2 == 0 ? 'class="grey-bg"' : '').'>
        <td><a href="#" class="removeCompare">X</a></td>
        <td class="text-center list-img-label text-uppercase"><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/base/default/packer/images/round-diamod.png" width="auto" height="20"  />
        '.$clr[$_product->getAttributeText('shape')].'
        </td>
        <td>'.round($_product->getResource()->getAttribute('d_carat')->getFrontend()->getValue($_product),2).'</td>
        <td>'.$_product->getAttributeText('d_cut').'</td>
        <td>'.$_product->getAttributeText('d_color').'</td>
        <td>'.$_product->getAttributeText('d_clarity').'</td>
        <td>SGD $ '.sprintf('%0.2f', $_product->getPrice()).'</td>
        </tr>';
		}
	}
	
	public function getProductsAction(){
		$this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        
		error_reporting(E_ALL);
		ini_set('display_errors','on');
		$cid = $this->getRequest()->getPost('category');
		$filters = $this->getRequest()->getPost('filter');
		$products = Mage::getModel('catalog/category')->load($cid)
					 ->getProductCollection()
					 ->addAttributeToSelect('*') // add all attributes - optional
					 ->addAttributeToFilter('status', 1) // enabled
					 
					 ->addAttributeToFilter('visibility', 4); //visibility in catalog,search
					// ->setOrder('price', 'ASC'); //sets the order by price
		
		if(isset($filters['shape'])){
			$products->addAttributeToFilter('shape',array('in' => $filters['shape']));
		}
		if(isset($filters['price'])){
			$fPrice = explode(',',$filters['price']);
			$products->addAttributeToFilter('price',array('from'=>$fPrice[0],'to'=>$fPrice[1]));
		}
		
		if(isset($filters['d_carat'])){
			$fatt = explode(',',$filters['d_carat']);
			$products->addAttributeToFilter('d_carat',array('from'=>$fatt[0],'to'=>$fatt[1]));
		}
		
		if(isset($filters['d_cut'])){
			$fatt = explode(',',$filters['d_cut']);
			$products->addAttributeToFilter('d_cut',array('in' => $fatt));
		}
		
		if(isset($filters['d_color'])){
			$fatt = explode(',',$filters['d_color']);
			$products->addAttributeToFilter('d_color', array('in' => $fatt));
		}
		
		if(isset($filters['d_clarity'])){
			$fatt = explode(',',$filters['d_clarity']);
			$products->addAttributeToFilter('d_clarity', array('in' => $fatt));
		}
		
		if(isset($filters['d_polish'])){
			$fatt = explode(',',$filters['d_polish']);
			$products->addAttributeToFilter('d_polish', array('in' => $fatt));
		}
		
		if(isset($filters['d_symmetry'])){
			$fatt = explode(',',$filters['d_symmetry']);
			$products->addAttributeToFilter('d_symmetry', array('in' => $fatt));
		}
		
		if(isset($filters['d_fluorescence'])){
			$fatt = explode(',',$filters['d_fluorescence']);
			$products->addAttributeToFilter('d_fluorescence', array('in' => $fatt));
		}
		
		if(isset($filters['d_depth'])){
			$fatt = explode(',',$filters['d_depth']);
			$products->addAttributeToFilter('d_depth',array('from'=>$fatt[0],'to'=>$fatt[1]));
		}
		
		if(isset($filters['d_table'])){
			$fatt = explode(',',$filters['d_table']);
			$products->addAttributeToFilter('d_table',array('from'=>$fatt[0],'to'=>$fatt[1]));
		}
		
		$lblVals = array();
		$lblVals['EP'] = 'Extremely Poor';
		$lblVals['VP'] = 'Very Poor';
		$lblVals['PO'] = 'Poor';
		$lblVals['FR'] = 'Fair';
		$lblVals['GD'] = 'Good';
		$lblVals['VG'] = 'Very Good';
		$lblVals['EX'] = 'Excellent';
		$lblVals['H&A'] = 'Signature Ideal';

		$clr = array();
		$clr['AS'] = 'asscher';
		$clr['CU'] = 'cushion';
		$clr['EC'] = 'emerald';
		$clr['HS'] = 'heart';
		$clr['MQ'] = 'marquise';
		$clr['OV'] = 'oval';
		$clr['PR'] = 'pear';
		$clr['PS'] = 'princess';
		$clr['RA'] = 'radiant';
		$clr['RD'] = 'round';

		$html = '';
		 foreach ($products as $_product){
			$dclarity = $_product->getAttributeText('d_clarity');
			$dcut = $_product->getAttributeText('d_cut');
			$dpolish = $_product->getAttributeText('d_polish');
			$dsym = $_product->getAttributeText('d_symmetry');
			
			$html .= ' 
			<tr data-id="'.$_product->getId().'" class="item_ajax_get_details" '.($pi % 2 == 0 ? 'class="grey-bg"' : '').'>
			<td class="cell-compare"><a href="#" class="removeCompare">X</a></td>
			<td class="cell-shape text-center list-img-label text-uppercase"><img src="'.Mage::getDesign()->getSkinUrl('packer/images/diamonds/'.$clr[$_product->getAttributeText('shape')].'.png').'" width="auto" height="20"  />
			'.$clr[$_product->getAttributeText('shape')].'
			</td>
			<td class="cell-carat">'.round($_product->getResource()->getAttribute('d_carat')->getFrontend()->getValue($_product),2).'</td>
			
			<td class="cell-color">'.$_product->getAttributeText('d_color').'</td>
			<td class="cell-clarity">'.(isset($lblVals[$dclarity]) ? $lblVals[$dclarity] : $dclarity).'</td>
			<td class="cell-cut">'.(isset($lblVals[$dcut]) ? $lblVals[$dcut] : $dcut).'</td>
			<td class="cell-polish">'.(isset($lblVals[$dpolish]) ? $lblVals[$dpolish] : $dpolish).'</td>
			<td class="cell-symm">'.(isset($lblVals[$dsym]) ? $lblVals[$dsym] : $dsym).'</td> 
			<td>SGD $ '.sprintf('%0.2f', $_product->getPrice()).' <i class="fa fa-arrow-right pl30"></i></td>
			</tr>';
			
		}
		$response = array('html'=> $html,'count' =>  $products->getSize());
		$this->getResponse()->setBody(json_encode($response));
	}
}