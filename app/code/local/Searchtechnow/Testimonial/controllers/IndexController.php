<?php

class Searchtechnow_Testimonial_IndexController extends Mage_Core_Controller_Front_Action {

    public function IndexAction() {
          $this->loadLayout();   
		  $this->getLayout()->getBlock("head")->setTitle($this->__("Testimonial"));
				
		  $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
		  
		  $breadcrumbs->addCrumb("home", array(
					"label" => $this->__("Home"),
					"title" => $this->__("Home"),
					"link"  => Mage::getBaseUrl()
			   ));
	
		// add second item without link
		  $breadcrumbs->addCrumb(
		  'custpmer_media', array(
		  'label' => $this->__('Media'),
		  'title' => $this->__('Media')
		  )
		  );
		  
		  $breadcrumbs->addCrumb("custpmer_testimonial", array(
					"label" => $this->__("Customer Testimonial"),
					"title" => $this->__("Customer Testimonial")
			   ));
/*$jkl="";
for ($x = 1; $x <= 60; $x++) {
if($x % 2==0)
{
  $jkl .=$x. " ";
  echo $jkl.'<br>';
  }
}
exit;*/

		  $this->renderLayout(); 
    }

}
