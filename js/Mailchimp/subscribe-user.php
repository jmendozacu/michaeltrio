<?php

if (!empty($_GET['mc']) && $_GET['mc'] === "1") {

	$mageFilename = __DIR__.'/../../app/Mage.php';
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
	/* Sender Name */
	$storeadminname = Mage::getStoreConfig('trans_email/ident_general/name');
	/* Sender Email */
	$storeadminemail = Mage::getStoreConfig('trans_email/ident_general/email');

    $email = $_GET['email'];

    $output = array(
        'error' => "0",
        'result' => "null"
    );

						
    if ( empty($email) ) {
        $output['error'] = 1;
    } else {

        require_once('mailchimp.php');

        $MailChimp = new MailChimp('3743bddb701145916dcce4068657fe1e-us11');

        $merge =  array(
            'EMAIL'     => $email,
			'MERGE3' => 'Direct Subscriber',
        );

        $result = $MailChimp->call('lists/subscribe', array(
            'id' => '12880e1233',
            'email' => array('email' => $email),
            'merge_vars' => $merge,
            'double_optin' => false,
            'update_existing' => true,
            'replace_interests' => false,
            'send_welcome' => false,
        ));

$emailchimp_id=$result['euid'];

$messagebefpremail = '<!doctype html>
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
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="height:100%;margin:0;padding:0;width:100%;background-color: #fafafa;border-collapse: collapse;">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="height:100%;margin:0;padding:0;width:100%;padding:10px;width:100%;border-top: 0 none;">

                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="max-width:600px !important;max-width:600px;border:0;width: 600px !important;">
                            
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
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;word-break:break-word;">
                        
                            <span style="font-family:lucida sans unicode,lucida grande,sans-serif"><span style="font-size:13px"><span style="line-height:22.4px"><img align="none" height="49" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/c27f1aab-5932-443a-b53a-01d41e2c966a.png" style="width: 260px; height: 49px; margin: 0px;" width="260"></span></span></span>
                        </td>
                    </tr>
                </tbody></table>

                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;word-break:break-word;">
                        
                            <h4 class="null" style="text-align: right;color: #202020;
font-family: Helvetica;
font-size: 18px;
font-style: normal;
font-weight: bold;
letter-spacing: normal;
line-height: 125%; margin:0"><span style="font-size:13px;">
<span style="text-align: right;font-family:lucida sans unicode,lucida grande,sans-serif;">
<span style="float: right;" class="mc-toc-title">(65) 6299 0110<br>
service@michaeltrio.com</span>
</span>
</span>
</h4>

                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table class="mcnImageBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td style="padding:9px" class="mcnImageBlockInner" valign="top">
                    <table class="mcnImageContentContainer" style="min-width:100%;" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">
                                
                                    <a href="http://www.michaeltrio.com" title="" class="" target="_blank">
                                        <img alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/9f3dbd35-9882-47f2-b31c-80ef6189ac18.jpg" style="max-width:600px; padding-bottom: 0; display: inline !important; vertical-align: bottom;vertical-align:bottom;" class="mcnImage" align="middle" width="564">
                                    </a>
                                
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
padding-top: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://gallery.mailchimp.com/e8d96232202faf40650998a75/images/a8a2b534-aa79-4f1d-b511-4877f99b1674.jpg" width="564" style="max-width:800px; padding-bottom: 0; display: inline !important; vertical-align: bottom;vertical-align:bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;table-layout:fixed">
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
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
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
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;word-break:break-word;color: #656565;
font-family: Helvetica;
font-size: 12px;
line-height: 150%;
text-align: center;">
                        
                            <em>Copyright � 2012-2016&nbsp;MICHAEL TRIO PTE LTD, All rights reserved.</em><br>
<br>
<strong>Visit us at: Michael Trio Showroom</strong><br>
91 Tanjong Pagar Road Singapore 088512<br>
<br>
**Looking for your perfect Engagement Ring / Wedding Bands? Make an appointment <a href="http://www.michaeltrio.com/make-an-appointment" target="_blank" style="color: #656565;
font-weight: normal;
text-decoration: underline;"><strong>here</strong></a>.**<br>
<br>
Send us an email at <a href="mailto:service@michaeltrio.com?subject=Enquiry" target="_blank" style="color: #656565;
font-weight: normal;
text-decoration: underline;">service@michaeltrio.com</a>.<br>
All questions will be answered within two (2) business days.<br>
<br>
Want to change how you receive these emails?<br>
You can <a href="http://michaeltrio.us11.list-manage.com/profile/?u=e8d96232202faf40650998a75&id=12880e1233&e='.$emailchimp_id.'" style="color: #656565; font-weight: normal; text-decoration: underline;">update your preferences</a> or <a href="http://michaeltrio.us11.list-manage.com/unsubscribe?u=e8d96232202faf40650998a75&id=12880e1233&e='.$emailchimp_id.'" style="color: #656565;font-weight: normal;text-decoration: underline;">unsubscribe from this list</a>         </td>
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
		$from_email_address = $storeadminemail;
		$to = $email;
		$subject = 'You’ve got the $50 coupon now. What would you like to do next?';
		$from = $from_email_address; 
		
		// To send HTML mail, the Content-type header must be set
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Create email headers
		
		$headers .= 'From: Service MT '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		// Sending email
		@mail($to, $subject, $messagebefpremail, $headers);
					
        if ($result) :
            $output['result'] = $result;
        endif;
    }
	

    // Success response emulation
    // $output = array(
    //     'error' => "0",
    //     'result' => "null"
    // );

    // $output['result'] = array(
    //     'email' => $_GET['email'],
    // );
    // Success response emulation END
    
 
    header('Content-type: application/json');
    echo json_encode($output);

    exit;

}


// Tests 
// $email = $_GET['email'];

// $output = array('error'=>'0','result'=>array('email'=>$email));
// header('Content-type: application/json');
// echo json_encode($output);