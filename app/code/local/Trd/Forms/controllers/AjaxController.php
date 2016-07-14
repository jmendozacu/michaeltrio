<?php

class Trd_Forms_AjaxController extends Mage_Core_Controller_Front_Action {

    /**
     * List of parameters:
     * name
     * email
     * contact
     * text
     * date
     * time
     * proposal_ring - 0/1
     * wedding_ring - 0/1
     * other - 0/1
     */
    public function savecontactsformAction() {

        /* $response_field = $_POST["responseField"];
          $privatekey = "6LcQehATAAAAAMdMT8t6BTp2UpzPuyQgsroIxTpm";
          $resp = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$response_field."&remoteip=".$_SERVER['REMOTE_ADDR']), true); */
        $resp['success'] = true;

        if ($resp['success'] == false) {
            echo json_encode(array("status" => "false",
                "message" => "captcha",
                'response' => $resp,
            ));
        } else {
            if ($data = $this->getRequest()->getPost()) {
                if ($data['name'] && $data['email'] && $data['contact']) {
                    $model = Mage::getModel('trd_forms/contact');
                    try {

// Compose a simple HTML email message

$messagebefpremail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>mailChimp_ProductMail - Responsive E-mail Template</title>
<link href="http://fonts.googleapis.com/css?family=Roboto:300,100,400" rel="stylesheet" type="text/css">

<style type="text/css">
		.ReadMsgBody{
			width:100%;
			background-color:#ffffff;
		}
		.ExternalClass{
			width:100%;
			background-color:#ffffff;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
			line-height:100%;
		}
		#outlook a{
			padding:0;
		}
		html{
			width:100%;
		}
		body{
			-webkit-text-size-adjust:none;
			-ms-text-size-adjust:none;
		}
		html,body{
			background-color:#ffffff;
			margin:0;
			padding:0;
		}
		table{
			border-spacing:0;
		}
		table td{
			border-collapse:collapse;
		}
		br,strong br,b br,em br,i br{
			line-height:100%;
		}
		h1,h2,h3,h4,h5,h6{
			line-height:100% !important;
			-webkit-font-smoothing:antialiased;
		}
		img{
			height:auto !important;
			line-height:100%;
			outline:none;
			text-decoration:none;
			display:block !important;
		}
		span a{
			text-decoration:none !important;
		}
		a{
			text-decoration:none !important;
		}
		table p{
			margin:0;
		}
		.yshortcuts,.yshortcuts a,.yshortcuts a:link,.yshortcuts a:visited,.yshortcuts a:hover,.yshortcuts a span{
			text-decoration:none !important;
			border-bottom:none !important;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		body{
			-webkit-text-size-adjust:100%;
		}
		body{
			-ms-text-size-adjust:100%;
		}
		.default-edit-image{
			height:20px;
		}
		.nav-ul{
			margin-left:-23px !important;
			margin-top:0px !important;
			margin-bottom:0px !important;
		}
		img{
			height:auto !important;
		}
		td[class=image-270px] img{
			width:270px;
			height:auto !important;
			max-width:270px !important;
		}
		td[class=image-170px] img{
			width:170px;
			height:auto !important;
			max-width:170px !important;
		}
		td[class=image-185px] img{
			width:185px;
			height:auto !important;
			max-width:185px !important;
		}
		td[class=image-124px] img{
			width:124px;
			height:auto !important;
			max-width:124px !important;
		}
	@media only screen and (max-width: 640px){
		body{
			width:auto!important;
		}

}	@media only screen and (max-width: 640px){
		table[class=container]{
			width:100%!important;
			padding-left:20px!important;
			padding-right:20px!important;
		}

}	@media only screen and (max-width: 640px){
		td[class=image-270px] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=image-170px] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=image-185px] img{
			width:185px !important;
			height:auto !important;
			max-width:185px !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=image-124px] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=image-100-percent] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=small-image-100-percent] img{
			width:100% !important;
			height:auto !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=full-width]{
			width:100% !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=full-width-text]{
			width:100% !important;
			background-color:#ffffff;
			padding-left:20px !important;
			padding-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=full-width-text2]{
			width:100% !important;
			background-color:#ffffff;
			padding-left:20px !important;
			padding-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-2-3img]{
			width:50% !important;
			margin-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-2-3img-last]{
			width:50% !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-2-footer]{
			width:55% !important;
			margin-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-2-footer-last]{
			width:40% !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-2]{
			width:47% !important;
			margin-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-2-last]{
			width:47% !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-3]{
			width:29% !important;
			margin-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=col-3-last]{
			width:29% !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=row-2]{
			width:50% !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=text-center]{
			text-align:center !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=remove]{
			display:none !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=remove]{
			display:none !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=fix-box]{
			padding-left:20px !important;
			padding-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=fix-box]{
			padding-left:20px !important;
			padding-right:20px !important;
		}

}	@media only screen and (max-width: 640px){
		td[class=font-resize]{
			font-size:18px !important;
			line-height:22px !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=space-scale]{
			width:100% !important;
			float:none !important;
		}

}	@media only screen and (max-width: 640px){
		table[class=clear-align-640]{
			float:none !important;
		}

}	@media only screen and (max-width: 479px){
		body{
			font-size:10px !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=container]{
			width:100%!important;
			padding-left:10px!important;
			padding-right:10px!important;
		}

}	@media only screen and (max-width: 479px){
		table[class=container2]{
			width:100%!important;
			float:none !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=full-width] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
			min-width:124px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=image-270px] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
			min-width:124px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=image-170px] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
			min-width:124px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=image-185px] img{
			width:185px !important;
			height:auto !important;
			max-width:185px !important;
			min-width:124px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=image-124px] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
			min-width:124px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=image-100-percent] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
			min-width:124px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=small-image-100-percent] img{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
			min-width:124px !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=full-width]{
			width:100% !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=full-width-text]{
			width:100% !important;
			background-color:#ffffff;
			padding-left:20px !important;
			padding-right:20px !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=full-width-text2]{
			width:100% !important;
			background-color:#ffffff;
			padding-left:20px !important;
			padding-right:20px !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=col-2-footer]{
			width:100% !important;
			margin-right:0px !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=col-2-footer-last]{
			width:100% !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=col-2]{
			width:100% !important;
			margin-right:0px !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=col-2-last]{
			width:100% !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=col-3]{
			width:100% !important;
			margin-right:0px !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=col-3-last]{
			width:100% !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=row-2]{
			width:100% !important;
		}

}	@media only screen and (max-width: 479px){
		table[id=col-underline]{
			float:none !important;
			width:100% !important;
			border-bottom:1px solid #eee;
		}

}	@media only screen and (max-width: 479px){
		td[id=col-underline]{
			float:none !important;
			width:100% !important;
			border-bottom:1px solid #eee;
		}

}	@media only screen and (max-width: 479px){
		td[class=col-underline]{
			float:none !important;
			width:100% !important;
			border-bottom:1px solid #eee;
		}

}	@media only screen and (max-width: 479px){
		td[class=text-center]{
			text-align:center !important;
		}

}	@media only screen and (max-width: 479px){
		div[class=text-center]{
			text-align:center !important;
		}

}	@media only screen and (max-width: 479px){
		table[id=clear-padding]{
			padding:0 !important;
		}

}	@media only screen and (max-width: 479px){
		td[id=clear-padding]{
			padding:0 !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=clear-padding]{
			padding:0 !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=remove-479]{
			display:none !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=remove-479]{
			display:none !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=clear-align]{
			float:none !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=width-small]{
			width:100% !important;
		}

}	@media only screen and (max-width: 479px){
		table[class=fix-box]{
			padding-left:0px !important;
			padding-right:0px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=fix-box]{
			padding-left:0px !important;
			padding-right:0px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=font-resize]{
			font-size:14px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=increase-Height]{
			height:10px !important;
		}

}	@media only screen and (max-width: 479px){
		td[class=increase-Height-20]{
			height:20px !important;
		}

}	@media only screen and (max-width: 320px){
		table[class=width-small]{
			width:125px !important;
		}

}	@media only screen and (max-width: 320px){
		img[class=image-100-percent]{
			width:100% !important;
			height:auto !important;
			max-width:100% !important;
			min-width:124px !important;
		}

}		.tpl-repeatblock{
			padding:0px !important;
			border:1px dotted rgba(0,0,0,0.2);
		}
</style></head>
<body style="font-size:12px;">
<table id="mainStructure" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#ffffff;"><tbody><tr><td><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" mc:repeatable="">

    <!--START TOP NAVIGATION ?LAYOUT-->
  <tr>
    <td valign="top">
      <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">


      <!-- START CONTAINER NAVIGATION -->
      <tbody><tr>
        <td align="center" valign="top">
          
          <!-- start top navigation container -->
          <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="container">
            
            <tbody><tr>
              <td valign="top">
                  

                <!-- start top navigaton -->
                <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width">

                  <!-- start space -->
                  <tbody><tr>
                    <td valign="top" height="20">
                    </td>
                  </tr>
                  <!-- end space -->

                  <tr>
                    <td valign="middle">
                    
                    <table align="left" border="0" cellspacing="0" cellpadding="0" class="container2">
                     
                      <tbody><tr>
                        <td align="center" valign="top">
                           <a href="http://www.michaeltrio.com/" style="text-decoration: none;">
						   <img style="height: auto !important; border: 0 none;  outline: medium none;
    text-decoration: none;" align="none" height="49" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c27f1aab-5932-443a-b53a-01d41e2c966a.png" style="width: 260px; height: 49px; margin: 0px;" width="260">
						   </a>
                        </td>
                      
                      </tr>


                        <!-- start space -->
                        <tr>
                          <td valign="top" class="increase-Height-20">

                          </td>
                        </tr>
                        <!-- end space -->

                    </tbody></table>

                    <!--start content nav -->
                    <table border="0" align="right" cellpadding="0" cellspacing="0" class="container2">
                      

                       <!--start call us -->
                      <tbody><tr>
                         <td valign="middle" align="center">
                        
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="clear-align" style="height:100%; margin-top: 20px;">
                          <tbody>
						  <tr>
                            <td style="font-size: 13px;  line-height: 18px; color: #a3a2a2;  font-weight:300; text-align: center; font-family:Roboto,Open Sans,Arail,Tahoma, Helvetica, Arial, sans-serif;" mc:edit="top menu tb1">
                              <span style="text-decoration: none; color: #000000;">
							  <a href="http://www.michaeltrio.com/" style="text-decoration: none; color: #000000; ">ABOUT</a></span>  &nbsp;&nbsp;  <span style="text-decoration: none; color: #000000;">
							  <a href="http://www.michaeltrio.com/" style="text-decoration: none; color: #000000; ">SERVICE</a></span>  &nbsp;&nbsp;  <span style="text-decoration: none; color: #000000;">     <a href="http://www.michaeltrio.com/contacts/" style="text-decoration: none; color: #000000; ">CONTACT</a>
							  </span>
                            </td>
                          </tr>
                        </tbody></table>
                        </td>
                      </tr>
                      <!--end call us -->

                    </tbody></table>
                    <!--end content nav -->

                   </td>
                 </tr>

                  <!-- start space -->
                  <tr>
                    <td valign="top" height="20">
                    </td>
                  </tr>
                  <!-- end space -->

               </tbody></table>
               <!-- end top navigaton -->
              </td>
            </tr>
          </tbody></table>
          <!-- end top navigation container -->

        </td>
      </tr>
      

       <!-- END CONTAINER NAVIGATION -->
  
      </tbody></table>
    </td>
  </tr>
   <!--END TOP NAVIGATION ?LAYOUT-->


 </table><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" mc:repeatable="">

  
  <!--START IMAGE HEADER LAYOUT-->


 <tr>
    <td align="center" valign="top" class="fix-box">

     <!-- start HEADER LAYOUT-container width 600px --> 
     <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width">
       <tbody><tr>
         <td valign="top" class="image-100-percent">

           
            <img src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/43ee873a-d6fe-40d6-8ccb-b488f163efc8.png" width="600" alt="header-image" style="display:block !important;  max-width:600px;" mc:edit="header image tb2">
          
         </td>
       </tr>
     </tbody></table>
     <!-- end HEADER LAYOUT-container width 600px --> 
   </td>
 </tr>
  <!--END IMAGE HEADER LAYOUT--> 
  </table><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" mc:repeatable="">
 <!-- Content --> 
 <tr>
    <td align="center" valign="top" class="fix-box">
     <!-- start  container width 600px --> 
     <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="container" style="background-color: #ffffff; border-bottom:1px solid #c7c7c7;">
      <!--start space height --> 
       <tbody><tr>
         <td height="20" valign="top"></td>
       </tr>
       <!--end space height --> 
       <tr>
         <td valign="top">
           <!-- start container width 560px --> 
           <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" bgcolor="#ffffff" style="background-color:#ffffff;">
           <!-- start heading -->               
           <tbody><tr>     
             <td valign="top">
               <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                 <tbody><tr>
                
                   <td align="left" style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;" mc:edit="subject">
                     <span style="color: #555555; font-weight:300;">
                       <a href="#" style="text-decoration: none; color: #555555; font-weight: 300;"><b>APPOINTMENT WITH US</b></a>
                     </span>
                   </td>

                 </tr>
               </tbody></table>
             </td>
           </tr>
           <!-- end heading -->  

            <!--start space height --> 
             <tr>
               <td height="15"></td>
             </tr>
             <!--end space height --> 
            
            <!-- start text content -->
             <tr>
               <td valign="top">
                 <table border="0" cellspacing="0" cellpadding="0" align="left">
                   <tbody>
             <tr>
               <td valign="top">
                 <table border="0" cellspacing="0" cellpadding="0" align="left">
                   <tbody><tr>
                     <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; " >
                         [!content!]
                     </td>
                   </tr>
                 </tbody>
				 </table>
               </td>
             </tr>
             <!-- end text content -->

             <!--start space height --> 
             <tr>
               <td height="15"></td>
             </tr>
             <!--end space height --> 

             <!--start space height --> 
             <tr>
               <td height="20" valign="top"></td>
             </tr>
             <!--end space height --> 
           </tbody>
		   </table>
           <!-- end  container width 560px --> 
         </td>
       </tr>
     </tbody></table>
     <!-- end  container width 600px --> 
   </td>
 </tr>
 <!-- Content --> 
  </tbody></table><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" mc:repeatable="">
 <!-- Appointment Details --> 
 <tr>
    <td align="center" valign="top" class="fix-box">

     <!-- start  container width 600px --> 
     <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="container" bgcolor="#ffffff" style="background-color: #ffffff; border-bottom:1px solid #c7c7c7;">
       <tbody><tr>
         <td valign="top">
         
		<!-- START HEIGHT SPACE 20PX LAYOUT-1 -->
     <table width="600" height="20" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff;" class="full-width">
       <tbody><tr>
         <td valign="top" height="20">  
          <img src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/f9aead7d-0056-4e87-8319-d05bb679f870.png" width="20" alt="space" style="display:block; max-height:20px; max-width:20px;" mc:edit="space layout1 tb0"> </td>
       </tr>
     </tbody></table>
 			 <!-- END HEIGHT SPACE 20PX LAYOUT-1-->
             
           <!-- start  container width 560px --> 
           <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" bgcolor="#f8f8f8" style="background-color:#f8f8f8;">

             <!-- start image and content --> 
             <tbody><tr>
               <td valign="top" width="100%">

                   <!--start space height --> 
                   </td></tr></tbody><tbody><tr>
                     <td height="20"></td>
                   </tr>
                   <!--end space height -->
                   
                   <!--start space height --> 
                   <tr>
                     <td valign="top">
                       <table style="width:100%" border="0" cellspacing="0" cellpadding="0" align="center">

                         <tbody>
                          <tr>
                           <td width="30"></td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             Name : 
                           </td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             [!name!]
                           </td>
                           <td width="30"></td>
                         </tr>
                         <tr>
                           <td width="30"></td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             Email : 
                           </td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             [!email!]
                           </td>
                           <td width="30"></td>
                         </tr>
                         <tr>
                           <td width="30"></td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             Contact info : 
                           </td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             [!contactinfo!]
                           </td>
                           <td width="30"></td>
                         </tr>
                         <tr>
                           <td width="30"></td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             Interested in : 
                           </td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             [!interested_in!]
                            </td>
                            <td width="30"></td>
                         </tr>
                         <tr>
                           <td width="30"></td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             Appointment Date : 
                           </td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             [!appointment_date!]
                           </td>
                           <td width="30"></td>
                         </tr>
                         <tr>
                           <td width="30"></td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             Appointment Time : 
                           </td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             [!appointment_time!]
                           </td>
                           <td width="30"></td>
                         </tr>
                         <tr>
                           <td width="30"></td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             Comments : 
                           </td>
                           <td style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#000000; font-weight:300; text-align:left; ">
                             [!comments!]
                           </td>
                           <td width="30"></td>
                         </tr>
                       </tbody>
                      </table>
                     </td>
                   </tr>
                   <!-- end text content --> 

                   <!--start space height --> 
                   <tr>
                     <td height="20" class="col-underline"></td>
                   </tr>
                   <!--end space height --> 

                 <!-- start space width --> 
                 <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                   <tbody><tr>
                     <td width="0" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                       <p style="padding-left: 20px;">&nbsp;</p>
                     </td>
                   </tr>
                 </tbody></table>
                 <!-- end space width --> 
                 
           <!-- end  container width 560px -->
           
           <!-- START HEIGHT SPACE 20PX LAYOUT-1 -->
     <table width="600" height="20" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff;" class="full-width">
       <tbody><tr>
         <td valign="top" height="20">  
          <img src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/f9aead7d-0056-4e87-8319-d05bb679f870.png" width="20" alt="space" style="display:block; max-height:20px; max-width:20px;" mc:edit="space layout1 tb0"> </td>
       </tr>
     </tbody></table>
 			 <!-- END HEIGHT SPACE 20PX LAYOUT-1-->
             
          </tbody></table></td>
       </tr>
     </tbody></table>
     <!-- end  container width 600px --> 
   </td>
 </tr>

 <!-- Appointment Details --> 



  </table><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" mc:repeatable="">

 <!-- START LAYOUT-16 --> 

    <tr>
        <td align="center" valign="top" class="fix-box">

      <!-- start  container width 600px --> 
      <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="container" style="background-color: #ffffff; border-bottom:1px solid #c7c7c7;">

         <!--start space height -->                      
        <tbody><tr>
          <td height="10"></td>
        </tr>
        <!--end space height --> 

            <tr>
              <td valign="top">


                <!-- start logo footer and address -->  
                <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
                  <tbody><tr>
                    <td valign="top">

                      <!--start icon socail navigation -->  
                      <table border="0" align="center" cellpadding="0" cellspacing="0" class="container">
                        <tbody><tr>
                          <td valign="top" align="left">

                            <table border="0" align="left" cellpadding="0" cellspacing="0" class="container">
                              <tbody><tr>
                                <td height="30" align="center" valign="middle" class="clear-padding">
                                  <a href="#" style="text-decoration: none;">
                                    <img src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/a158db6a-40c6-446e-926c-51d1e2a4dc83.png" width="30" alt="icon-facebook" style="max-width:30px;" border="0" hspace="0" vspace="0" mc:edit="iconfacebookcolor tb9">  
                                  </a>
                                </td>
                                <td style="padding-left:5px; " height="30" align="center" valign="middle" class="clear-padding">

                                  </td><td style="padding-left:5px;" height="30" align="center" valign="middle" class="clear-padding">
                                  <a href="#" style="text-decoration: none;">
                                    <img src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/8307b177-beef-4459-9ce0-e32a7144eeb2.png" width="30" alt="icon-instagram" style="max-width:30px;" border="0" hspace="0" vspace="0" mc:edit="iconinstagramcolor tb16">  
                                  </a>
                                </td>
                                


                              </tr>
                            </tbody></table>

                          </td>
                        </tr>
                      </tbody></table>
                      <!--end icon socail navigation --> 
                    </td>
                  </tr>
                </tbody></table>
                <!-- end logo footer and address --> 

              </td>
            </tr>

            <!--start space height -->                      
            <tr>
              <td height="10"></td>
            </tr>
            <!--end space height --> 

        </tbody></table>

      </td>
    </tr>
      <!-- END LAYOUT-16-->  
  </table><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" mc:repeatable="">
    <!--START FOOTER LAYOUT-->
  <tr>
    <td valign="top">
      <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
      <!-- START CONTAINER  -->
      <tbody><tr>
        <td align="center" valign="top">          
          <!-- start footer container -->
          <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="container">
             <tbody><tr>
              <td valign="top">
                <!-- start footer -->
                <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width">
                  <!-- start space -->
                  <tbody><tr>
                    <td valign="top" height="20">
                    </td>
                  </tr>
                  <!-- end space -->
                  <tr>
                    <td valign="middle">                    
                    <table align="left" border="0" cellspacing="0" cellpadding="0" class="container2">                     
                      <tbody><tr>
                        <td align="center" valign="top">
                           <a href="#" style="text-decoration: none;"><img mc:allowdesigner="" mc:allowtex="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c1f50d25-8fab-4268-bada-85d1d719cdfc.png" width="114" style="max-width:114px;" alt="Logo" border="0" hspace="0" vspace="0" mc:edit="footer logo tb17"></a>
                        </td>                      
                      </tr>
                        <!-- start space -->
                        <tr>
                          <td valign="top" class="increase-Height-20">
                          </td>
                        </tr>
                        <!-- end space -->
                    </tbody></table>
                   </td>
                 </tr>
                  <!-- start space -->
                  <tr>
                    <td valign="top" height="20">
                    </td>
                  </tr>
                  <!-- end space -->
               </tbody></table>
               <!-- end footer -->
              </td>
            </tr>
          </tbody></table>
          <!-- end footer container -->
        </td>
      </tr>    
       <!-- END CONTAINER  -->  
      </tbody></table>
    </td>
  </tr>
   <!--END FOOTER ?LAYOUT-->
  </table><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" mc:repeatable="">

<!--  START FOOTER COPY RIGHT -->

<tr>
    <td align="center" valign="top" style="background-color:#8ea5ba;">
    <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="container" style="background-color:#8ea5ba;">
      <tbody><tr>
        <td valign="top">
          <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="container" style="background-color:#8ea5ba;">

              <!--start space height -->                      
              <tbody><tr>
                <td height="10"></td>
              </tr>
              <!--end space height --> 

            <tr>
              <!-- start COPY RIGHT content -->  
              <td valign="top" style="font-size: 10px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#ffffff; font-weight:300; text-align:center; " mc:edit="company (footer) tb19">
                &copy; Michael Trio Pte. Ltd. 2016. All rights reserved. Michael Trio Showroom is located at 91 Tanjong Pagar Road Singapore 088512.
              </td>
              <!-- end COPY RIGHT content --> 
            </tr>

              <!--start space height -->                      
              <tr>
                <td height="10"></td>
              </tr>
              <!--end space height --> 


          </tbody></table>
        </td>
      </tr>
    </tbody></table>
  </td>
</tr>
<!--  END FOOTER COPY RIGHT -->
  </table></td></tr></table></td></tr></tbody></table></body>
</html>';


                        /* Sender Name */
                        $storeadminname = Mage::getStoreConfig('trans_email/ident_general/name');
                        /* Sender Email */
                        $storeadminemail = Mage::getStoreConfig('trans_email/ident_general/email');
						
                        $data_name = trim($data['name']);
                        $data_email = trim($data['email']);
                        $data_contact = trim($data['contact']);
						
						$storeadminsendifchecked=$storeadminemail;
						$storeadmindata_name = trim($data['name']);
                        $storeadmindata_email = trim($data['email']);
                        $storeadmindata_contact = trim($data['contact']);

                        $model->setName($data_name);
                        $model->setEmail($data_email);
                        $model->setContact($data_contact);
                        $all_interested = array();

                        if ($data['date']) {
                            $data_date = trim($data['date']);
                            $model->setDate($data_date);
                        }

                        if ($data['time']) {
                            $data_time = trim($data['time']);
                            $model->setTime($data_time);
                        }

                        if ($data['text']) {
                            $data_text = trim($data['text']);
                            $model->setText($data_text);
                        }

                        if ($data['proposal_ring']) {
                            $data['proposal_ring'] === 'true' ? $model->setProposalRing(1) : $model->setProposalRing(0);
                            $data['proposal_ring'] === 'true' ? $all_interested[] = 'Engagement Ring' : '';
                        }

                        if ($data['wedding_ring']) {
                            $data['wedding_ring'] === 'true' ? $model->setWeddingRing(1) : $model->setWeddingRing(0);
                            $data['wedding_ring'] === 'true' ? $all_interested[] = 'Wedding Bands' : '';
                        }

                        if ($data['other']) {
                            $data['other'] === 'true' ? $model->setOther(1) : $model->setOther(0);
                            $data['other'] === 'true' ? $all_interested[] = 'Other' : '';
                        }

                        $model->save();
                        //Mage::getModel('newsletter/subscriber')->subscribe($data['email']);

                        $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($data_email);
                        //echo $subscriber->getId();
                        //exit;
                        if (!$subscriber->getId() || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE) {
                            if ($data['cNewsletterSignup']) {

                                Mage::getModel('newsletter/subscriber')->setImportMode(true)->subscribe($data_email);

                                $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($data_email);

                                $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);

                                $subscriber->setSubscriberFirstname($data_name);

                                $subscriber->save();
                            }
                        }


                        require_once Mage::getBaseDir() . '/mailchimp-mandrill-api-php/src/Mandrill.php'; //Not required with Composer
                        $mandrill = new Mandrill('dfw9P0RihHMYhhrGmf_h3A');

                        $recipient_email_address = $data_email;

                        $recipient_name = $data_name; // change this to the recipient name
                        $template_name = 'Newsletter Template Beta'; // change this to the template name to use

					
            $toRepArray = array('[!content!]','[!name!]', '[!email!]', '[!contactinfo!]', '[!interested_in!]', '[!appointment_date!]', '[!appointment_time!]', '[!comments!]');
            $fromRepArray = array('<p>Dear <b>' . $recipient_name . '</b>,</p><p>&nbsp;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We are happy to have received your request to schedule an appointment with our representative at <b>' . $data_time . '</b> on <b>' . $data_date . '</b>. Our sales representative will contact you within 24 hours to confirm your appointment.</p><p>&nbsp;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We thank you for your interest.</p>','<b>' . $data_name . '</b>', '<b>' . $data_email . '</b>', '<b>' . $data_contact . '</b>', '<b>' . implode(', ', $all_interested) . '</b>', '<b>' . $data_date . '</b>', '<b>' . $data_time . '</b>', '<b>' . $data_text . '</b>');
                    $messageToSend = str_replace($toRepArray, $fromRepArray, $messagebefpremail);
					//for User email
					$from_email_address = $storeadminemail;
					$to = $recipient_email_address;
					$subject = 'Appointment with Michael Trio';
					$from = $from_email_address; 
					
					// To send HTML mail, the Content-type header must be set
					
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Create email headers
					
					$headers .= 'From: Michael Trio Jewellery '.$from."\r\n".
					'Reply-To: '.$from."\r\n" .
					'X-Mailer: PHP/' . phpversion();
					// Sending email
					@mail($to, $subject, $messageToSend, $headers);
						

            $toRepArray = array('[!content!]','[!name!]', '[!email!]', '[!contactinfo!]', '[!interested_in!]', '[!appointment_date!]', '[!appointment_time!]', '[!comments!]');
            $fromRepArray = array('<p>Dear <b>' . $storeadminname . '</b>,</p><p>&nbsp;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We are happy to have received your request to schedule an appointment with our representative at <b>' . $data_time . '</b> on <b>' . $data_date . '</b>. Our sales representative will contact you within 24 hours to confirm your appointment.</p><p>&nbsp;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We thank you for your interest.</p>','<b>' . $data_name . '</b>', '<b>' . $data_email . '</b>', '<b>' . $data_contact . '</b>', '<b>' . implode(', ', $all_interested) . '</b>', '<b>' . $data_date . '</b>', '<b>' . $data_time . '</b>', '<b>' . $data_text . '</b>');
                    $messageToSend = str_replace($toRepArray, $fromRepArray, $messagebefpremail);
					
					//for Admin email
					
					$to = $from_email_address;
					$subject = 'Appointment with Michael Trio';
					$from = $recipient_email_address; 
					
					// To send HTML mail, the Content-type header must be set
					
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Create email headers
					
					$headers .= 'From: Michael Trio Jewellery '.$from."\r\n".
					'Reply-To: '.$from."\r\n" .
					'X-Mailer: PHP/' . phpversion();
					// Sending email
					@mail($to, $subject, $messageToSend, $headers);

						
                        if ($data['newsletter_signup']) {
                            require_once Mage::getBaseDir() . '/js/Mailchimp/mailchimp.php';
                            $MailChimp = new MailChimp('3743bddb701145916dcce4068657fe1e-us11');

                            $merge = array(
							    'FNAME' => $data_name,
                                'EMAIL' => $email,
								'MMERGE3' => 'Enquiry (MAP)',
								'MMERGE6' => $data_contact
                            );

                            $result = $MailChimp->call('lists/subscribe', array(
                                'id' => '12880e1233',
                                'email' => array('email' => $data_email),
                                'merge_vars' => $merge,
                                'double_optin' => false,
                                'update_existing' => true,
                                'replace_interests' => false,
                                'send_welcome' => true,
                            ));
$emailchimp_id=$result['euid'];

$messagebeforemailsubscribe = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>*|MC:SUBJECT|*</title>   
</head>
    <body>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse:collapse; background-color:#FAFAFA;height:100%;margin:0;padding:0;width:100%;">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="border-top:0;padding:10px;height:100%;margin:0;padding:0;width:100%;">                       
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse:collapse;width:600px !important;border:0; max-width: 600px !important;">                            
                            <tr>
<td valign="top" id="templateHeader" style="background-color: #ffffff; border-bottom: 0 none; border-top: 0 none;padding-bottom: 0;padding-top: 9px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">              	
<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer" style="border-collapse:collapse;">
                    <tbody>
					<tr>                        
<td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; text-align: center; color: #202020; font-family: Helvetica;font-size: 16px;line-height: 150%; text-align: left;">                        
<span style="font-family:lucida sans unicode,lucida grande,sans-serif">
<span style="font-size:13px"><span style="line-height:22.4px">
<img align="none" height="48" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c27f1aab-5932-443a-b53a-01d41e2c966a.png" style="width: 260px; height: 48px; margin: 0px;" width="260"  height: auto !important; border: 0 none; height: auto; outline: medium none; text-decoration: none;>
</span>
</span>
</span>
                        </td>
                    </tr>
                </tbody></table>
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer" style="border-collapse:collapse;">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; text-align: center; color: #202020;font-family: Helvetica; font-size: 16px; line-height: 150%;
    text-align: left;">
                        
                            <div style="text-align: right;  color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: right; float: right;">
	<span style="font-size:13px color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;">
	<span style="    color: #000;
    font-family: Helvetica;
    font-size: 13px;
    line-height: 150%;
    text-align: left;font-family:lucida sans unicode,lucida grande,sans-serif"><span class="mc-toc-title" style="color: rgb(0, 0, 0) ! important;">(65) 6299 0110<br>
service@michaeltrio.com</span></span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;" style="border-collapse:collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer" style="border-collapse:collapse;">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: center;"><br>
<span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:17px">Thank you for signing up our newsletters.</span><br>
<br>
<span style="font-size:13px">AS A WELCOME GIFT,&nbsp;WE\'D LIKE TO OFFER YOU&nbsp;</span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;" style="border-collapse:collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer" style="border-collapse:collapse;">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style=" color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: center;">&nbsp;</div>

<h3 class="null" style=" display: block;
    margin: 0;
    padding: 0;color:#202020;font-family:Helvetica;font-size:20px;font-style:normal;font-weight:bold;line-height:125%;letter-spacing:normal;
			text-align:left;text-align: center;"><span style="color:#7d9db3"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="color: rgb(0, 0, 0) ! important;" class="mc-toc-title"><span style="font-size:64px">$50 OFF</span></span></span></span></h3>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody" style=" background-color: #ffffff;
    border-bottom: 2px solid #eaeaea;
    border-top: 0 none;
    padding-bottom: 9px;
    padding-top: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
    
	<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer" style="border-collapse:collapse;">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellpadding="18" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;border: 1px solid #000000;background-color: #FFFFFF;">
                                <tbody><tr>
                                    <td valign="top" class="mcnTextContent" style="color: #000000;font-family: Helvetica;font-size: 14px;font-style: normal;font-weight: normal;line-height: 100%;text-align: center;">
                                        <span style="font-family:lucida sans unicode,lucida grande,sans-serif">Enter coupon code at checkout: <span style="color:#7d9db3">NEW50</span></span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;" style="border-collapse:collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer" style="border-collapse:collapse;">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="    color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: center;"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:13px">*Minimum spend&nbsp;$300 &amp; cannot be combined with any other offer.</span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%; border-collapse:collapse; table-layout: fixed !important;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 1px;border-top-style: solid;border-top-color: #EAEAEA; border-collapse:collapse;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%; border-collapse:collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%; border-collapse:collapse;" width="100%" class="mcnTextContentContainer" >
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-family: Tahoma, Verdana, Segoe, sans-serif;color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;">
                        
                            <div style="text-align: center;"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="color:#7d9db3"><span style="font-size:19px">YOU\'VE GOT THE $50 COUPON NOW. WHAT WOULD<br>
YOU LIKE TO DO NEXT?</span></span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock" style="border-collapse:collapse;">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
                

<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent" width="282">
    <tbody><tr>
        <td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">
        
            

            <img alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c8ea2f2c-68e8-416a-b6e8-26e484eae580.jpg" width="264" style="max-width:1000px; vertical-align: bottom;  border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;" class="mcnImage">
            
        
        </td>
    </tr>
    <tr>
        <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;" width="264">
            <div style="text-align: center;"><span style="font-size:19px"><span style="font-family:tahoma,verdana,segoe,sans-serif">Engagement Ring</span></span><br>
&nbsp;</div>

        </td>
    </tr>
</tbody></table>

<table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent" width="282" style="border-collapse:collapse;">
    <tbody><tr>
        <td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">
        
            

            <img alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/faa4a374-4549-45e8-9e41-aa9868a3ce65.jpg" width="264" style="max-width:1000px;  vertical-align: bottom;   border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;" class="mcnImage">
            
        
        </td>
    </tr>
    <tr>
        <td class="mcnTextContent" valign="top" style=" color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;padding:0 9px 0 9px;" width="264">
            <div style="text-align: center;"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:19px">Wedding Bands</span></span></div>

        </td>
    </tr>
</tbody></table>





            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock" style="border-collapse:collapse;">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
                

<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent" width="282" style="border-collapse:collapse;">
    <tbody><tr>
        <td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">
        
            

            <img alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/92b21076-22fb-4b69-a19c-c65cd4c3066a.jpg" width="264" style="vertical-align: bottom; border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;max-width:659px;" class="mcnImage">
            
        
        </td>
    </tr>
    <tr>
        <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;    color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;" width="264">
            <div style="text-align: center;"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:19px">Diamond Pendant</span></span></div>

        </td>
    </tr>
</tbody></table>

<table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent" width="282" style="border-collapse:collapse;">
    <tbody><tr>
        <td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">
        
            

            <img alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/8c9bc0c2-a181-4af4-98e0-b2096581ded8.jpg" width="264" style="vertical-align: bottom; border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;max-width:1000px;" class="mcnImage">
            
        
        </td>
    </tr>
    <tr>
        <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;     color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;" width="264">
            <div style="text-align: center;"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:19px">Diamond Earrings</span></span><br>
&nbsp;</div>

        </td>
    </tr>
</tbody></table>
   </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock" style="border-collapse:collapse;">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">               
<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent" width="282" style="border-collapse:collapse;">
    <tbody><tr>
        <td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">
            <img alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/31488a44-a1b6-4dc9-bb5d-08e631e9a262.jpg" width="264" style="max-width:1000px;vertical-align: bottom;  border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;" class="mcnImage">
        </td>
    </tr>
    <tr>
        <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;    color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;" width="264">
            <div style="text-align: center;"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:19px"><span style="line-height:35.2px">Eternity Ring</span></span></span><br>
&nbsp;</div>
        </td>
    </tr>
</tbody></table>

<table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent" width="282" style="border-collapse:collapse;">
    <tbody><tr>
        <td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">      
            <img alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/a9d35771-c700-4f68-b594-90eb655641da.jpg" width="264" style="max-width:1000px;" class="mcnImage">
        </td>
    </tr>
    <tr>
        <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;" width="264">
            <div style="text-align: center;"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:19px"><span style="line-height:35.2px">Bangle &amp; Bacelet</span></span></span><br>
&nbsp;</div>

        </td>
    </tr>
</tbody>
</table>
       </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%; border-collapse:collapse;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #7D9DB3;">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: lucida sans unicode,lucida grande, sans-serif; font-size: 14px; padding: 15px;">
                                <a class="mcnButton " title="VISIT OUR WEBSITE" href="http://www.michaeltrio.com" target="_blank" style="  display: block;font-weight: normal;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">VISIT OUR WEBSITE</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%; border-collapse:collapse;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; border-collapse:collapse;" class="mcnFollowContent" >
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            <tbody><tr>
                                <td align="center" valign="top">
                                   
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline; border-collapse:collapse;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                        <a href="https://www.facebook.com/michaeltriojewels" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-facebook-96.png" alt="Facebook" class="mcnFollowBlockIcon" width="48" style="border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;width:48px; max-width:48px; display:block;"></a>
                                                    </td>
                                                </tr>                                               
                                            </tbody></table>
                                        
                                        
                                       
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline; border-collapse:collapse;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                        <a href="https://www.instagram.com/michaeltrio/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-instagram-96.png" alt="Instagram" class="mcnFollowBlockIcon" width="48" style="border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;width:48px; max-width:48px; display:block;"></a>
                                                    </td>
                                                </tr>
                                                
                                                
                                            </tbody></table>
                                        
                                                                              
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" display:inline;style="border-collapse:collapse;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                        <a href="mailto:service@michaeltrio.com" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-forwardtofriend-96.png" alt="Email" class="mcnFollowBlockIcon" width="48" style="  border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;width:48px; max-width:48px; display:block;"></a>
                                                    </td>
                                                </tr>                                                
                                                
                                            </tbody></table>
                                        
                                      
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;border-collapse:collapse;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:0; padding-bottom:9px;">
                                                        <a href="https://www.youtube.com/watch?v=jt6xoxg0vXo" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-youtube-96.png" alt="YouTube" class="mcnFollowBlockIcon" width="48" style="  border: 0 none;
    height: auto;
    outline: medium none;
    text-decoration: none;width:48px; max-width:48px; display:block;"></a>
                                                    </td>
                                                </tr>
                                                
                                                
                                            </tbody></table>
                                        
                                       
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateFooter" style="   background-color: #fafafa;
    border-bottom: 0 none;
    border-top: 0 none;
    padding-bottom: 9px;
    padding-top: 9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%; border-collapse:collapse;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style=" color: #656565;
    font-family: Helvetica;
    font-size: 12px;
    line-height: 150%;
    text-align: center;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <em>Copyright © 2012-2016&nbsp;MICHAEL TRIO PTE LTD, All rights reserved.</em><br>
<br>
<strong>Visit us at: Michael Trio Showroom</strong><br>
91 Tanjong Pagar Road Singapore 088512<br>
<br>
Send us an email at <a href="mailto:service@michaeltrio.com?subject=Enquiry" target="_blank" style=" color: #656565;
    font-weight: normal;
    text-decoration: underline;">service@michaeltrio.com</a>.<br>
All questions will be answered within two (2) business days.<br>
<br>
Want to change how you receive these emails?<br>
You can <a style="color: #656565;
font-weight: normal;
text-decoration: underline; " href="http://michaeltrio.us11.list-manage.com/profile/?u=e8d96232202faf40650998a75&id=12880e1233&e='.$emailchimp_id.'">update your preferences</a> or <a style="color: #656565;
font-weight: normal;

text-decoration: underline; " href="http://michaeltrio.us11.list-manage.com/unsubscribe?u=e8d96232202faf40650998a75&id=12880e1233&e='.$emailchimp_id.'">unsubscribe from this list</a>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                        </table>
						
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>';


				//for User email
				$from_email_address = $storeadminsendifchecked;
				$to = $storeadmindata_email;
				$subject = 'Thank You for Subscribe';
				$from = $from_email_address; 
				
				// To send HTML mail, the Content-type header must be set
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Create email headers
				
				$headers .= 'From: Michael Trio Jewellery '.$from."\r\n".
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
				// Sending email
				@mail($to, $subject, $messagebeforemailsubscribe, $headers);

//                            if ($result) :
//                                $output['result'] = $result;
//                            endif;
                        }


                        echo json_encode(array('status' => 'true', 'message' => 'success'));
                    } catch (Exception $e) {
                        echo json_encode(array('status' => 'false', 'message' => $e->getMessage()));
                    }
                } else {
                    echo json_encode(array('status' => 'false', 'message' => 'request without parameters'));
                }
            } else {
                echo json_encode(array('status' => 'false', 'message' => 'bad request'));
            }
        }
    }
	
	public function savefreeplasticringsizerformAction() {

        $resp['success'] = true;

        if ($resp['success'] == false) {
            echo json_encode(array("status" => "false",
                "message" => "captcha",
                'response' => $resp,
            ));
        } else {
            if ($data = $this->getRequest()->getPost()) {
                if ($data['given_name'] && $data['email'] && $data['mobile']) {
                    $model = Mage::getModel('trd_forms/contact');
                    try {

                        /* Sender Name */
                        $storeadminname = Mage::getStoreConfig('trans_email/ident_general/name');
                        /* Sender Email */
                        $storeadminemail = Mage::getStoreConfig('trans_email/ident_general/email');

                        $given_name = trim($data['given_name']);
                        $data_email = trim($data['email']);
                        $mobile = trim($data['mobile']);
						$surname = trim($data['surname']);
						$address = trim($data['address']);
						$gender = trim($data['gender']);
						$age = trim($data['age']);		
						$unit_no = trim($data['unit_no']);
						$postal_code = trim($data['postal_code']);

                        //if ($data['do_agree']) {
						
							$resource = Mage::getSingleton('core/resource');
							$readConnection = $resource->getConnection('core_write');
                            $readConnection->insert("free_plastic_ring_sizer",array("given_name" => $given_name, "surname" => $surname, "mobile" => $mobile, "gender" => $gender, "age" => $age, "email" => $data_email, "address" => $address, "unit_no" => $unit_no, "postal_code" => $postal_code, "do_agree" => '1', "created_time" => date('Y-m-d H:i:s'), "update_time" => date('Y-m-d H:i:s'), "datetimecol" => date("Y-m-d H:i:s", strtotime("+30 minutes"))));
							
                            require_once Mage::getBaseDir() . '/js/Mailchimp/mailchimp.php';
                            $MailChimp = new MailChimp('3743bddb701145916dcce4068657fe1e-us11');

                            $merge = array(
                                'EMAIL' => $data_email,
								'FNAME' => $given_name,
								'LNAME' => $surname,
								'MMERGE3' => 'Ring Sizer Requesters',
								'MMERGE4' => $address,
								'MMERGE5' => $postal_code,
								'MMERGE6' => $mobile,
								'MMERGE7' => $gender,
								'MMERGE8' => $age,
								'MMERGE9' => $unit_no,
								'MMERGE10' => $postal_code,
                            );

                            $result = $MailChimp->call('lists/subscribe', array(
                                'id' => '12880e1233',
                                'email' => array('email' => $data_email),
                                'merge_vars' => $merge,
                                'double_optin' => false,
                                'update_existing' => true,
                                'replace_interests' => false,
                                'send_welcome' => true,
                            ));
$emailchimp_id=$result['euid'];

$messagebeforemail = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>*|MC:SUBJECT|*</title>
        
     
</head>
    <body style="background-color: #fafafa;height: 100%;
margin: 0;
padding: 0;
width: 100%;">
        <center>
            <table style="background-color: #fafafa; height: 100%;
margin: 0;
padding: 0;
width: 100%;" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td style="border-top: 0 none;padding: 10px;height: 100%;
margin: 0;
width: 100%;" align="center" valign="top" id="bodyCell">
                       
                        <table style="width: 600px !important; width: 600px !important; max-width: 600px !important;" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templateHeader" style="background-color: #ffffff;
border-bottom: 0 none;
border-top: 0 none;
padding-bottom: 0;
padding-top: 9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; text-align: center;">
                        
                            <span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:13px"><span style="line-height:22.4px"><img align="none" height="48" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c27f1aab-5932-443a-b53a-01d41e2c966a.png" style="width: 260px; height: 48px; margin: 0px;" width="260"></span></span></span>
                        </td>
                    </tr>
                </tbody></table>
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; text-align: center;">
                        
                            <div style="text-align: right !important;"><span style="font-size:13px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span class="mc-toc-title" style="color: rgb(0, 0, 0) ! important;">(65) 6299 0110<br>
service@michaeltrio.com</span></span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: center;"><br>
<span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:17px">Thank You For Requesting A Ring Sizer</span><br>
<br>
<span style="font-size:13px">You should receive a ring sizer by mail in 1 to 2 weeks.<br>
<br>
While you wait for your ring sizer, feel free to&nbsp;view our <a style="color: #2baadf;

font-weight: normal;

text-decoration: underline; " href="http://www.michaeltrio.com/wedding.php?maincat=men&amp;weddingstyle=alternative-metal-rings" target="_blank">mens wedding bands</a>, <a style="color: #2baadf;

font-weight: normal;

text-decoration: underline; " href="http://www.michaeltrio.com/wedding.php?maincat=women&amp;weddingstyle=diamond" target="_blank">womens wedding bands</a>&nbsp;or our <a style="color: #2baadf;

font-weight: normal;

text-decoration: underline; " href="http://www.michaeltrio.com/engagement.php" target="_blank">engagement rings</a> collection.&nbsp;&nbsp;</span></span><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
			
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody" style="background-color: #ffffff;
border-bottom: 2px solid #eaeaea;
border-top: 0 none;
padding-bottom: 9px;
padding-top: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 1px;border-top-style: solid;border-top-color: #EAEAEA;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;color: #202020;
font-size: 16px;
line-height: 150%;
text-align: left;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-family: Tahoma, Verdana, Segoe, sans-serif;">
                        
                            <div style="text-align: center;"><span style="font-size:17px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif">HOW TO MEASURE RING&nbsp;SIZE</span></span><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><span style="font-size:13px"><span style="font-family:verdana,geneva,sans-serif"><strong>STEP 1</strong></span><span style="font-family:lucida sans unicode,lucida grande,sans-serif"> -&nbsp;Push the end of ring sizer through the bucket to form a ring shape.</span><br>
<span style="font-family:verdana,geneva,sans-serif"><strong>STEP 2</strong></span><span style="font-family:lucida sans unicode,lucida grande,sans-serif"> -&nbsp;Slip the sizer onto your finger and adjust to give a comfortable fit.</span><br>
<span style="font-family:verdana,geneva,sans-serif"><strong>STEP 3</strong></span><span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - Read the indicate number which is the Circumference (mm) of your ring.</span><br>
<span style="font-family:verdana,geneva,sans-serif"><strong>STEP 4</strong></span><span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - Check your ring size with our <a style="color: #2baadf;

font-weight: normal;

text-decoration: underline; " href="http://www.michaeltrio.com/media/wysiwyg/ring_sizer_chart.pdf" target="_blank">International Ring Size Chart</a>.</span></span><br>
<img align="none" height="183" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c2fc335d-ddb0-4c27-a24d-89eed0d6372a.jpg" style="width: 300px; height: 183px; float: left; margin: 0px;" width="300"></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 1px;border-top-style: solid;border-top-color: #EAEAEA;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-size: 16px;
line-height: 150%;
text-align: left;padding: 0px 18px 9px; font-family: Tahoma, Verdana, Segoe, sans-serif;">
                        
                            <div style="text-align: center;"><span style="font-size:17px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif">TIPS FOR MEASURING RING SIZE</span></span><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: left;"><span style="font-size:13px"><strong><span style="font-family:verdana,geneva,sans-serif">Your ring should fit your finger comfortably:</span></strong><span style="font-family:lucida sans unicode,lucida grande,sans-serif">&nbsp;Snug enough so that it will not fall off, but loose enough to slide over your knuckle.</span><br>
<br>
<strong><span style="font-family:verdana,geneva,sans-serif">Finger size change&nbsp;</span></strong><span style="font-family:lucida sans unicode,lucida grande,sans-serif">depending on the time of day and the weather. For best results your finger size:&nbsp;<br>
<br>
&nbsp; &nbsp;1. At the end of the day and when your fingers are warm. (Fingers are smaller in the early morning and when cold)<br>
<br>
&nbsp; 2. Measure finger size 3 to 4 times to eliminate an erroneous reading.&nbsp;</span></span><br>
<br>
<span style="font-size:13px"><strong><span style="font-family:verdana,geneva,sans-serif">Avoid using string or paper </span></strong></span><span style="font-size:13px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif">to measure ring size as these materials can stretch or twist, yielding an inaccurate measurement.</span></span><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 1px;border-top-style: solid;border-top-color: #EAEAEA;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <div style="text-align: center;"><span style="font-size:17px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif">TIPS FOR BUYING THE RING AS A SURPRISE</span></span><br>
&nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <span style="font-size:13px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif">Ask your significant other’s friends or mother if they know her finger size. Borrow one of your significant other’s rings (from the correct finger) and use the <a style="color: #2baadf;

font-weight: normal;

text-decoration: underline; " href="http://www.michaeltrio.com/media/wysiwyg/ring_sizer_chart.pdf" target="_blank">ring measurements chart&nbsp;(option 2)</a> to determine its size.</span></span><br>
&nbsp;
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                        <img align="center" alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/8b943861-d2dc-40ed-b3bb-e1c83f97550e.jpg" width="564" style="max-width:943px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td  valign="top" class="mcnTextBlockInner" style=" padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #656565;
font-family: Helvetica;
font-size: 12px;
line-height: 150%;
text-align: center;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <em>Copyright © 2012-2016&nbsp;MICHAEL TRIO PTE LTD, All rights reserved.</em><br>
<br>
<strong>Visit us at: Michael Trio Showroom</strong><br>
91 Tanjong Pagar Road Singapore 088512<br>
<br>
Send us an email at <a style="color: #656565;
font-weight: normal;
text-decoration: underline;" href="mailto:service@michaeltrio.com?subject=Enquiry" target="_blank">service@michaeltrio.com</a>.<br>
All questions will be answered within two (2) business days.<br>
<br>
Want to change how you receive these emails?<br>
You can <a style="color: #656565;
font-weight: normal;
text-decoration: underline; " href="http://michaeltrio.us11.list-manage.com/profile/?u=e8d96232202faf40650998a75&id=12880e1233&e='.$emailchimp_id.'">update your preferences</a> or <a style="color: #656565;
font-weight: normal;
text-decoration: underline; " href="http://michaeltrio.us11.list-manage.com/unsubscribe?u=e8d96232202faf40650998a75&id=12880e1233&e='.$emailchimp_id.'">unsubscribe from this list</a>
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                        </table>
					
                    </td>
                </tr>
            </table>
        </center>
    </body>

</html>';

$emailtositeadmin = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>*|MC:SUBJECT|*</title>
        
     
</head>
    <body style="background-color: #fafafa;height: 100%;
margin: 0;
padding: 0;
width: 100%;">
        <center>
            <table style="background-color: #fafafa; height: 100%;
margin: 0;
padding: 0;
width: 100%;" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td style="border-top: 0 none;padding: 10px;height: 100%;
margin: 0;
width: 100%;" align="center" valign="top" id="bodyCell">
                       
                        <table style="width: 600px !important; width: 600px !important; max-width: 600px !important;" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templateHeader" style="background-color: #ffffff;
border-bottom: 0 none;
border-top: 0 none;
padding-bottom: 0;
padding-top: 9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; text-align: center;">
                        
                            <span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:13px"><span style="line-height:22.4px"><img align="none" height="48" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c27f1aab-5932-443a-b53a-01d41e2c966a.png" style="width: 260px; height: 48px; margin: 0px;" width="260"></span></span></span>
                        </td>
                    </tr>
                </tbody></table>
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; text-align: center;">
                        
                            <div style="text-align: right !important;"><span style="font-size:13px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span class="mc-toc-title" style="color: rgb(0, 0, 0) ! important;">(65) 6299 0110<br>
service@michaeltrio.com</span></span></span></div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table>
</td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody" style="background-color: #ffffff;
border-bottom: 2px solid #eaeaea;
border-top: 0 none;
padding-bottom: 9px;
padding-top: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 1px;border-top-style: solid;border-top-color: #EAEAEA;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;color: #202020;
font-size: 16px;
line-height: 150%;
text-align: left;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-family: Tahoma, Verdana, Segoe, sans-serif;">
                        
                            <div style="text-align: center;">
							<span style="font-size:17px">
							<span style="font-family:lucida sans unicode,lucida grande,sans-serif">CUSTOMER RING SIZER REQUEST DATA</span>
							</span>
							<br>
                            </div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
<div style="text-align: left;">
<span style="font-size:13px">
	<span style="font-family:verdana,geneva,sans-serif"><strong>Given name</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!given_name!]</span><br>
	<span style="font-family:verdana,geneva,sans-serif"><strong>Surname</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!surname!]</span><br>
	<span style="font-family:verdana,geneva,sans-serif"><strong>Mobile</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!mobile!]</span><br>
	<span style="font-family:verdana,geneva,sans-serif"><strong>Email</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!email!]</span><br>
	<span style="font-family:verdana,geneva,sans-serif"><strong>Address</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!address!]</span><br>
	<span style="font-family:verdana,geneva,sans-serif"><strong>Gender</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!gender!]</span><br>	
	<span style="font-family:verdana,geneva,sans-serif"><strong>Age</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!age!]</span><br>	
	<span style="font-family:verdana,geneva,sans-serif"><strong>Unit No.</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!unit_no!]</span><br>
	<span style="font-family:verdana,geneva,sans-serif"><strong>Postal Code</strong></span>
	<span style="font-family:lucida sans unicode,lucida grande,sans-serif"> - [!postal_code!]</span><br>
</span>
</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 1px;border-top-style: solid;border-top-color: #EAEAEA;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table>
</td>
                            </tr>
                            
                        </table>
					
                    </td>
                </tr>
            </table>
        </center>
    </body>

</html>';


            $toRepArray = array('[!given_name!]','[!surname!]', '[!mobile!]', '[!email!]', '[!address!]', '[!gender!]', '[!age!]', '[!unit_no!]', '[!postal_code!]');
            $fromRepArray = array($given_name,$surname,$mobile,$data_email,$address,$gender,$age,$unit_no,$postal_code);
                   
				    $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtositeadmin);
					//for Admin email
					$adminto = $storeadminemail;
					$adminsubject = 'Customer requests for ring sizer..';
					$adminfrom = $data_email; 
					
					// To send HTML mail, the Content-type header must be set
					
					$adminheaders  = 'MIME-Version: 1.0' . "\r\n";
					$adminheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Create email headers
					
					$adminheaders .= 'From: '.$adminfrom."\r\n".
					'Reply-To: '.$adminfrom."\r\n" .
					'X-Mailer: PHP/' . phpversion();
					// Sending email
					@mail($adminto, $adminsubject, $messageToSend, $adminheaders);
                    //*****-----------------***//


					$to = $data_email;
					$subject = 'What You Can Do While Waiting For Your Ring Sizer?';
					$from = $storeadminemail; 
					
					// To send HTML mail, the Content-type header must be set
					
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Create email headers
					
					$headers .= 'From: '.$from."\r\n".
					'Reply-To: '.$from."\r\n" .
					'X-Mailer: PHP/' . phpversion();
					// Sending email
					@mail($to, $subject, $messagebeforemail, $headers);
                        //}


                        echo json_encode(array('status' => 'true', 'message' => 'success', 'result' => $result));
                    } catch (Exception $e) {
                        echo json_encode(array('status' => 'false', 'message' => $e->getMessage()));
                    }
                } else {
                    echo json_encode(array('status' => 'false', 'message' => 'request without parameters'));
                }
            } else {
                echo json_encode(array('status' => 'false', 'message' => 'bad request'));
            }
        }
    }

}
