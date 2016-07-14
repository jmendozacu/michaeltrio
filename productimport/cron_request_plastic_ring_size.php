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
$readConnection = $resource->getConnection('core_read');
// Retrieve the write connection
$writeConnection = $resource->getConnection('core_write');

// Compose a simple HTML email message

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
            <table style="background-color: #fafafa; height: 100%;margin: 0;padding: 0;width: 100%;" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td style="border-top: 0 none; height: 100%;
margin: 0;
width: 100%; padding: 10px;" align="center" valign="top" id="bodyCell">
                        
                        <table style="width: 600px !important;" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            
                            <tr>
                                <td valign="top" style="background-color: #ffffff;
border-bottom: 0 none;
border-top: 0 none;
padding-bottom: 0;
padding-top: 9px;" id="templateHeader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:13px"><span style="line-height:22.4px"><img align="none" height="49" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c27f1aab-5932-443a-b53a-01d41e2c966a.png" style="width: 260px; height: 49px; margin: 0px;" width="260"></span></span></span>
                        </td>
                    </tr>
                </tbody></table>
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <h4 class="null" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;text-align: right; display: block;
margin: 0;
padding: 0;"><span style="font-size:13px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span class="mc-toc-title">(65) 6299 0110<br>
service@michaeltrio.com</span></span></span></h4>

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
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <br>
<span style="font-size:13px"><span style="color: #202020;
font-family: Helvetica;
line-height: 150%;
text-align: left;font-family:lucida sans unicode,lucida grande,sans-serif">Hi&nbsp;</span></span>
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
                        
                        <td  valign="top" class="mcnTextContent" style="color: #202020;
font-family: Helvetica;
font-size: 16px;
line-height: 150%;
text-align: left;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <span style="font-size:13px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif">My name is Gin, a diamond and jewellery consultant at Michael Trio. I received your request for a ring sizer. I am very pleased to assist you.<br>
<br>
We have processed your request and the ring sizer will be shipped to you soon. Please give it 1-2 weeks as we will be shipping the ring sizer from our corporate office.&nbsp;<br>
<br>
Have you already selected specific styles from our collection? Please do not hesitate to contact me directly so that I can assist you further!<br>
<br>
Making a jewellery purchase is a big deal, especially when you are selecting an engagement ring. We want you to be sure that what you buy exactly what you want. Make your jewellery as beautiful as it can be.<br>
<br>
Best Regards,<br>
Gin<br>
service@michaeltrio.com<br>
(65) 6299 0110</span></span>
                        </td>
                    </tr>
                </tbody></table>
			
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffffff;
border-bottom: 2px solid #eaeaea;
border-top: 0 none;
padding-bottom: 9px;
padding-top: 0;" valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                   
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                        <a href="https://www.facebook.com/michaeltriojewels" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-facebook-96.png" alt="Facebook" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                    </td>
                                                </tr>
                                                
                                                
                                            </tbody></table>
                                        
                                        
                                       
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                        <a href="https://www.instagram.com/michaeltrio/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-instagram-96.png" alt="Instagram" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                    </td>
                                                </tr>
                                                
                                                
                                            </tbody></table>
                                        
                                        
                                      
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                        <a href="mailto:service@michaeltrio.com" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-forwardtofriend-96.png" alt="Email" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                    </td>
                                                </tr>
                                                
                                                
                                            </tbody></table>
                                        
                                        
                                       
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                 
                                                <tbody><tr>
                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:0; padding-bottom:9px;">
                                                        <a href="https://www.youtube.com/watch?v=jt6xoxg0vXo" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/light-youtube-96.png" alt="YouTube" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
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
                                <td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="color: #656565;
font-family: Helvetica;
font-size: 12px;
line-height: 150%;
text-align: center;padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <span style="font-family:arial,helvetica neue,helvetica,sans-serif"><em>Copyright � 2012-2016&nbsp;MICHAEL TRIO PTE LTD, All rights reserved.</em><br>
<br>
<strong>Visit us at: Michael Trio Showroom</strong><br>
91 Tanjong Pagar Road Singapore 088512<br>
<br>
Send us an email at <a style="color: #656565;
font-family: Helvetica;
font-size: 12px;
line-height: 150%;
text-align: center;" href="mailto:service@michaeltrio.com?subject=Enquiry" target="_blank">service@michaeltrio.com</a>.<br>
All questions will be answered within two (2) business days.<br>
<br>
Want to change how you receive these emails?<br>
You can <a style="color: #656565;
font-family: Helvetica;
font-size: 12px;
line-height: 150%;
text-align: center;" href="http://www.michaeltrio.com/">update your preferences</a> or <a style="color: #656565;
font-family: Helvetica;
font-size: 12px;
line-height: 150%;
text-align: center;" href="http://www.michaeltrio.com/">unsubscribe from this list</a></span>
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

        $datechk=date('Y-m-d H:i:s');
		/* Sender Name */
		$storeadminname = Mage::getStoreConfig('trans_email/ident_general/name');
		/* Sender Email */
		$storeadminemail = Mage::getStoreConfig('trans_email/ident_general/email');
		// SQL command
		$sql = 'Select * from free_plastic_ring_sizer where datetimecol <= "'.$datechk.'"';
		// Query data
		$sqlQuery = $readConnection->query($sql);
		
		// Fetch  Array
		while ($row = $sqlQuery->fetch() ) {
		//do something
		//print_r($row);
		    $id=$row['id'];
			$to = $row['email'];
			$subject = '(Ready) Your Ring Sizer Is On The Way.';
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
					
		$where = 'id = "'.$id.'"'; 
		$writeConnection->delete("free_plastic_ring_sizer", $where);
		
		}
	
		$currency_rate = $readConnection->query('SELECT * FROM `directory_currency_rate_stn` WHERE DATE(`created`) = CURDATE()');
		$row_currency_rate = $currency_rate->fetchAll();
		
		if(empty($row_currency_rate))
		{
		$currency_rate_old = $readConnection->query('SELECT * FROM `directory_currency_rate_stn` WHERE id = 1');
		$row_currency_rate_old = $currency_rate_old->fetch();
		
		$latest_currency= get_currency('SGD', 'USD', 1);
		$current_datetime=now();
		
		$readConnection->query('UPDATE `directory_currency_rate_stn` SET `rate` = "'.$latest_currency.'", `created` = "'.$current_datetime.'" WHERE `id` =1');
		$readConnection->query("UPDATE `directory_currency_rate` SET `rate` = '".$latest_currency."' WHERE `currency_from`='SGD' && `currency_to`='USD' ");
		}

		
		function get_currency($from_Currency, $to_Currency, $amount) {
			$amount = urlencode($amount);
			$from_Currency = urlencode($from_Currency);
			$to_Currency = urlencode($to_Currency);
		
			$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
		
			$ch = curl_init();
			$timeout = 0;
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		
			curl_setopt ($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			$data = explode('bld>', $rawdata);
			$data = explode($to_Currency, $data[1]);
			//print_r($data);
			return $data[0];
		}
		
				// Compose a simple HTML email message

$messagereminderemail = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Jewellery Singapore | Online Jewellery Shop Singapore - Michael Trio</title>
                  </head>
    <body style="background-color: #fafafa; height: 100%; margin: 0; padding: 0; width: 100%;">
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="  background-color: #fafafa;height: 100%;margin: 0;    padding: 0;
    width: 100%;">
	<tbody style="border-collapse: collapse;">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="border-top: 0 none; padding: 10px;  height: 100%; margin: 0; padding: 0; width: 100%;">
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="width: 600px !important;border: 0 none; max-width: 600px !important;">
                           <tr>
                                <td valign="top" id="templatePreheader" style="  background-color: #fafafa;
    border-bottom: 0 none;
    border-top: 0 none;
    padding-bottom: 9px;
    padding-top: 9px; border-collapse: collapse;"><table class="mcnTextBlock" style="min-width:100%; border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" style="padding-top:9px;" valign="top">
                <table style="max-width:210px;border-collapse: collapse;" class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
					<tr>
                        <td class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;   color: #656565;
    font-family: Helvetica;
    font-size: 12px;
    line-height: 150%;
    text-align: left;" valign="top">
                        </td>
                    </tr>
                </tbody>
				</table>
            </td>
        </tr>
    </tbody>
</table>
</td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader" style="   background-color: #ffffff;
    border-bottom: 0 none;
    border-top: 0 none;
    padding-bottom: 0;
    padding-top: 9px;border-collapse: collapse;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%; border-collapse: collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;  border-collapse: collapse;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;   color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;">
                        
                            <span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:13px"><span style="line-height:22.4px ">
							<img align="none" style="height: auto !important; border: 0 none; height: auto;outline: medium none;text-decoration: none;" height="49" src="http://www.michaeltrio.com/media/wysiwyg/mailmictrio.png" style="width: 260px; height: 49px; margin: 0px;" width="260">
							</span>
							</span>
							</span>
                        </td>
                    </tr>
                </tbody></table>
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;  border-collapse: collapse;" width="100%" class="mcnTextContentContainer">
                    <tbody>
					<tr>
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;">
                        
                            <h4 class="null" style="text-align: right;     color: #202020;
    font-family: Helvetica;
    font-size: 18px;
    font-style: normal;
    font-weight: bold;
    letter-spacing: normal;
    line-height: 125%;
    display: block;
    margin: 0;
    padding: 0;"><span style="font-size:13px"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span class="mc-toc-title">(65) 6299 0110<br>
service@michaeltrio.com</span></span></span></h4>

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
    padding-top: 0;  border-collapse: collapse;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%; border-collapse: collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%; border-collapse: collapse;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-family: &quot;Lucida Sans Unicode&quot;, &quot;Lucida Grande&quot;, sans-serif; line-height: 125%; color: #202020; font-size: 16px;  text-align: left;">
                        
                            <h1 class="null" style="text-align: left; color: #202020;
    font-family: Helvetica;
    font-size: 26px;
    font-style: normal;
    font-weight: bold;
    letter-spacing: normal;
    line-height: 125%;  display: block;
    margin: 0;
    padding: 0;"><br>
<span class="mc-toc-title"><span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:40px"><span style="line-height:67.2px">DID YOU FORGET<br>
SOMETHING<br>
IN YOUR<br>
SHOPPING BAG?</span></span></span></span></h1>

                        </td>
                    </tr>
                </tbody></table>
			
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;  border-collapse: collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;   border-collapse: collapse;" width="100%" class="mcnT000extContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;  color: #202020;
    font-family: Helvetica;
    font-size: 16px;
    line-height: 150%;
    text-align: left;">
                        
                            <span style="font-size:14px">
							<span style="font-family:lucida sans unicode,lucida grande,sans-serif">We noticed that you have the following </span>
							<a  style=" color: #2baadf; font-weight: normal;text-decoration: none; "href="http://www.michaeltrio.com/checkout/cart/" target="_blank">
							<span style="color:#7498b3">
							<span style="font-family:arial,helvetica neue,helvetica,sans-serif">
							<strong>[!PRODUCT_NAMES!]</strong></span>
							</span>
							</a>
							<span style="font-family:lucida sans unicode,lucida grande,sans-serif">&nbsp;in your shopping basket. Would you like to complete your purchase?<br>
<br>
Product availability can change at any time, so we invite you to return to Michael Trio and complete your purchase.<br>
<br>
Every order at Michael Trio includes free FedEx shipping*, elegant gift packaging, 14-day returns, plus financing options. (*T&amp;C applies)</span></span><br>
&nbsp;
                        </td>
                    </tr>
                </tbody></table>
			
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;  table-layout: fixed !important;  border-collapse: collapse;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EAEAEA;  border-collapse: collapse;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock" style=" border-collapse: collapse;">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
	          [!PRODUCT_DATA!]
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;border-collapse: collapse; table-layout: fixed !important;">
    <tbody class="mcnDividerBlockOuter" >
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EAEAEA;  border-collapse: collapse;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;  border-collapse: collapse;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="left" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-radius: 0px;background-color: #7498B3; border-collapse: collapse;">
                    <tbody style="  border-collapse: collapse;">
                        <tr>
                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: &quot;Lucida Sans Unicode&quot;, &quot;Lucida Grande&quot;, sans-serif; font-size: 13px; padding: 15px;">
  <a style="display: block;  color: #fff; display: block;  text-decoration: none;" class="mcnButton " title="RESUME YOUR ORDER" href="http://www.michaeltrio.com/checkout/cart/" target="_blank" style="font-weight: bold;letter-spacing: 1px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">RESUME YOUR ORDER</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr style="border-collapse: collapse;">
                                <td valign="top" id="templateFooter" style="  background-color: #fafafa;
    border-bottom: 0 none;
    border-top: 0 none;
    padding-bottom: 9px;
    padding-top: 9px; border-collapse: collapse;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%; border-collapse: collapse;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%; border-collapse: collapse;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;  color: #656565;
    font-family: Helvetica;
    font-size: 12px;
    line-height: 150%;
    text-align: center;">
                        
                            <span style="font-family:arial,helvetica neue,helvetica,sans-serif"><em>Copyright © 2012-2016&nbsp;MICHAEL TRIO PTE LTD, All rights reserved.</em><br>
<br>
<strong>Visit us at: Michael Trio Showroom</strong><br>
91 Tanjong Pagar Road Singapore 088512<br>
<br>
Send us an email at <a style=" color: #656565;
    font-weight: normal;
    text-decoration: underline;" href="mailto:service@michaeltrio.com?subject=Enquiry" target="_blank">service@michaeltrio.com</a>.<br>
All questions will be answered within two (2) business days.<br>
<br>
Want to change how you receive these emails?<br>
You can <a style="color: #656565;
    font-weight: normal;
    text-decoration: underline;" href="http://www.michaeltrio.com/">update your preferences</a> or <a style="    color: #656565;
    font-weight: normal;
    text-decoration: underline;" href="http://www.michaeltrio.com/">unsubscribe from this list</a></span>
                        </td>
                    </tr>
                </tbody></table>
			
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
							</tbody>
                        </table>
						
                    </td>
                </tr>
				</tbody>
            </table>
        </center>
    </body>
</html>';

$reminder_cart = $readConnection->query("SELECT `main_table` . * , (main_table.base_subtotal_with_discount * main_table.base_to_global_rate) AS `subtotal` , `cust_email`.`email` , `cust_fname`.`value` AS `firstname` , `cust_lname`.`value` AS `lastname` , CONCAT_WS( ' ', cust_fname.value, cust_lname.value ) AS `customer_name` FROM `sales_flat_quote` AS `main_table` INNER JOIN `customer_entity` AS `cust_email` ON cust_email.entity_id = main_table.customer_id INNER JOIN `customer_entity_varchar` AS `cust_fname` ON cust_fname.entity_id = main_table.customer_id AND cust_fname.attribute_id =5 INNER JOIN `customer_entity_varchar` AS `cust_lname` ON cust_lname.entity_id = main_table.customer_id AND cust_lname.attribute_id =7 WHERE (items_count != '0') AND (main_table.is_active = '1') AND DATE(main_table.updated_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
		
/*	$reminder_cart = $readConnection->query("SELECT `main_table` . * , (main_table.base_subtotal_with_discount * main_table.base_to_global_rate) AS `subtotal` , `cust_email`.`email` , `cust_fname`.`value` AS `firstname` , `cust_lname`.`value` AS `lastname` , CONCAT_WS( ' ', cust_fname.value, cust_lname.value ) AS `customer_name` FROM `sales_flat_quote` AS `main_table` INNER JOIN `customer_entity` AS `cust_email` ON cust_email.entity_id = main_table.customer_id INNER JOIN `customer_entity_varchar` AS `cust_fname` ON cust_fname.entity_id = main_table.customer_id AND cust_fname.attribute_id =5 INNER JOIN `customer_entity_varchar` AS `cust_lname` ON cust_lname.entity_id = main_table.customer_id AND cust_lname.attribute_id =7 WHERE (items_count != '0') AND (main_table.is_active = '1') AND (cust_email.entity_id = '2')");*/


        //echo "<pre>";
        //$quote = Mage::getModel('sales/quote')->load($quoteId);
		/*$store = Mage::getSingleton('core/store')->load(2);
		$quote = $this->_getModel('sales/quote')->loadByIdWithoutStore($quoteId)
		print_r($quote); // empty
		
		exit;
*/
		$row_reminder_cart = $reminder_cart->fetchAll();
		
		if(!empty($row_reminder_cart))
		{
		    
			foreach($row_reminder_cart as $row_reminder_cartdata)
			{
			 $productIds=array();
			 $productNames=array();
			 
			 $quote_id= $row_reminder_cartdata['entity_id'];
			 $quote_updated_at= $row_reminder_cartdata['updated_at'];
			 $quote_created_at= $row_reminder_cartdata['created_at'];
			 
			 $customer_name= $row_reminder_cartdata['customer_name'];
			 $customer_email= $row_reminder_cartdata['email'];
			 
			 $row_reminder_cart_product = $readConnection->query('SELECT `product_id`,`item_id` FROM `sales_flat_quote_item` WHERE quote_id = "'.$quote_id.'"');
		     $row_reminder_cart_product_data = $row_reminder_cart_product->fetchAll();
             
			$currency_reminder_chk = $readConnection->query('SELECT * FROM `stn_sales_flat_quote` WHERE DATE(`updated_at`) = DATE("'.$quote_updated_at.'") && entity_id = "'.$quote_id.'"');
			$row_reminder_chk = $currency_reminder_chk->fetchAll();
			
			if(empty($row_reminder_chk))
			{		 
				
			 if(!empty($row_reminder_cart_product_data))
			 {
			 $allproductdata="";
			 foreach($row_reminder_cart_product_data as $cart_product_data)
			 {
			 $productIds[]=$cart_product_data['product_id'];
			 
			 $info_buyRequest='info_buyRequest';
			 $product = Mage::getModel('catalog/product')->load($cart_product_data['product_id']);
			 
			 if(!empty($product))
			 {
			   $ids = $product->getCategoryIds();
			   $productNames[]=$product->getName();
			   
			 	$allproductdata .='	
				        <table border="0" cellpadding="0" cellspacing="0" class="mcnCaptionRightContentOuter" width="100%" style="border-collapse: collapse;">
    <tbody>
	<tr>
        <td valign="top" class="mcnCaptionRightContentInner" style="padding:0 9px ; ">					
						<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionRightImageContentContainer" style="border-collapse: collapse;">
							<tbody>				
							<tr>
								<td class="mcnCaptionRightImageContent" valign="top">
								<img alt="" src="'.Mage::getModel('catalog/product_media_config')->getMediaUrl($product->getThumbnail()).'" width="264" style="max-width:1000px;border: 0 none; height: auto; outline: medium none; text-decoration: none;" class="mcnImage">                       
								</td>
							</tr>				
						</tbody>
						</table>
						
					';
				
			 $row_reminder_cart_product = $readConnection->query('SELECT `value` FROM `sales_flat_quote_item_option` WHERE item_id = "'.$cart_product_data['item_id'].'" && product_id = "'.$cart_product_data['product_id'].'" &&  `code` = "'.$info_buyRequest.'"');
		     $row_reminder_cart_product_data = $row_reminder_cart_product->fetchAll();
			 
			 foreach($row_reminder_cart_product_data as $row_reminder_cart_product_datas)
			 {
			 $buyRequest = new Varien_Object(unserialize($row_reminder_cart_product_datas['value']));
			 $buyRequest_options =$buyRequest['options'];
			 }	 
			 
			 $allproductdata .='						
						<table class="mcnCaptionRightTextContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="264" style="border-collapse: collapse;">
							<tbody>
							<tr>
							 <td valign="top" class="mcnTextContent" style="color: #202020; font-family: Helvetica; font-size: 16px; line-height: 150%; text-align: left;">
								<span style="font-size:16px">	
								'.$product->getName().'							
								<br>
								<br>
						';
						
				if (in_array('3', $ids)) {
				
				    $allproductdata .='Carat: '.$product->getDiamondWeight().'<br><br>';
					$cutval = $product->getDiamondCut();
					if ($cutval == 'H&A') {
						$allproductdata .='Cut: Signature Ideal<br><br>';
					} else {
						$allproductdata .='Cut: '.$product->getDiamondCut().'<br><br>';
                    } 
				    $maintitlename= $product->getDiamondColor();
					switch ($maintitlename) {
					case "Bronze":
						$allproductdata .='Color: Rose Gold<br><br>';
						break;
					case "Gold":
						$allproductdata .='Color: Yellow Gold<br><br>';
						break;
					case "Silver":
						$allproductdata .='Color: White Gold<br><br>';
						break;
					default:
						$allproductdata .='Color: '.$maintitlename.'<br><br>';
				    }
				   $allproductdata .='Clarity: '.$product->getDiamondClarity().'<br><br>';
				}
				else
				{
				 foreach($product->getOptions() as $options)
					{
					   //echo 
					   $options->getTitle().'<br>'; 
	
						if (array_key_exists($options->getId(), $buyRequest_options)) {
						
						
							$optionValues = $options->getValues();
							$ab='1'; 
							foreach($optionValues as $optVal)
							{
							   $alloption=$optVal->getData();
							  
							   if($alloption['option_type_id']==$buyRequest_options[$options->getId()])
							   {
								 //echo $alloption['option_type_id'].'<br>';
								 $allproductdata .=$options->getTitle().': '.$alloption['title'].'<br><br>';
								 $ab++;
							   }
							   //print_r($alloption);
							   
							}
						}
						
					}
				}
				
				$allproductdata .='
								</td>
							</tr>
						</tbody>
						</table>
					</td>
				</tr>
				</tbody>
				</table>';
			  }	
				//echo $allproductdata;
				

			 }
			 
			 $toRepArray = array('[!PRODUCT_NAMES!]','[!PRODUCT_DATA!]');
             $fromRepArray = array(implode(", ",$productNames),$allproductdata);
             $messageToreminderSend = str_replace($toRepArray, $fromRepArray, $messagereminderemail);
			
			//for User email
			$remindeto = $customer_email;
			$remindesubject = 'OOPS! You left something in your cart.';
			$from = $storeadminemail; 
			
			// To send HTML mail, the Content-type header must be set
			
			$remindeheaders  = 'MIME-Version: 1.0' . "\r\n";
			$remindeheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Create email headers
			
			$remindeheaders .= 'From: Michael Trio Jewellery '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			// Sending email
			@mail($remindeto, $remindesubject, $messageToreminderSend, $remindeheaders);
	        $readConnection->query('INSERT INTO `stn_sales_flat_quote` (`entity_id`, `updated_at`, `created_at`) VALUES ("'.$quote_id.'", "'.$quote_updated_at.'", "'.$quote_created_at.'") ');
			 
			 }		 
            }
			}
		}
?>
