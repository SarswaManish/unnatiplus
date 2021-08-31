<?php namespace Cake\View\Helper;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;
use Cake\Network\Http\Client;
use Cake\Mailer\Email;

/**
 * Html Helper class for easy use of HTML widgets.
 *
 * HtmlHelper encloses all methods needed while working with HTML pages.
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 * @link https://book.cakephp.org/3.0/en/views/helpers/html.html
 */
class G99emailHelper extends Helper
{
  
 public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);
    }

public static function sendTestEmail($useremail,$userName,$message)
{
$strMessage = self::emailTemplate($userName,$message);
 //$email = new Email('default');
//$email->from(['info@memoctor.com' => 'Memoctor'])->emailFormat('html')->to($useremail)->subject('Email Verification')->send($strMessage);
///$http = new Client();
$subject = 'Unnatiplus - Forgot Password';

$email = new Email('default');
$email->setFrom(['info@unnatiplus.com' => 'Unnatiplus'])->setEmailFormat('html')->setTo($useremail)->setSubject('Unnatiplus - Forgot Password')->send($strMessage);



///$http->post('https://testscorner.com/angular/testmail.php', ['emailid'=>$useremail,'message'=>$strMessage,'Subject'=>$subject]);


}

 
public static function welcomeMail($useremail,$userName,$message)
{
	$strMessage = self::emailTemplate($userName,$message);
$to = $useremail;
$subject = 'Welcome to Memoctor';
$from = 'info@memoctor.com';
$http = new Client();

$http->post('https://testscorner.com/angular/testmail.php', ['emailid' => $to,'message'=>$strMessage,'Subject'=>$subject]);
	
}

public  static  function emailTemplate($userName,$message)
{


$strTime = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting">  
    <title>Memoctor</title> 
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }
        /* If the above doesn\'t work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        /* What it does: Prevents underlining the button text in Windows 10 */
        .button-link {
            text-decoration: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you\'d like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            .email-container {
                min-width: 414px !important;
            }
        }

    </style>
    <style>

	    /* What it does: Hover styles for buttons */
	    .button-td,
	    .button-a {
	        transition: all 100ms ease-in;
	    }
	    .button-td-primary:hover,
	    .button-a-primary:hover {
	        background: #555555 !important;
	        border-color: #555555 !important;
	    }

	    /* Media Queries */
	    @media screen and (max-width: 600px) {

	        /* What it does: Adjust typography on small screens to improve readability */
	        .email-container p {
	            font-size: 17px !important;
	        }

	    }

    </style>
</head>
<body width="100%" style="margin: 0; mso-line-height-rule: exactly; background-color: #fff;">
    <center style="width: 100%; background-color: #fff; text-align: left;">
	<div style="max-width: 600px; margin: 20px auto; border:1px solid #ccc;padding:10px;" class="email-container">
	        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 auto;">
		        <!-- Email Header : BEGIN -->
	            <tr>
	                <td style="padding: 20px 0px 10px; text-align: center">
	                    <img src="https://codexosoftware.live/unnatiplus/webroot/assets/img/uploads/theme_image/1577183312logo.png" width="200" height="61" alt="alt_text" border="0" style="height: auto; font-family: sans-serif;">
	                </td>
	            </tr>
				 <tr>
	                <td style="padding:10px 0; text-align: center;color:#2e8e71;font-family: sans-serif; font-weight:bold">
	                    Hi! '.$userName.'
	                </td>
	            </tr>
				<tr>
	                <td style="padding:10px 0; text-align: center;color:#333;font-family: sans-serif; ">
	                   '.$message.'
	                </td>
	            </tr>
				

            </table>
            <!-- Email Body : END -->

            

            <!--[if mso]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </div>

      

    <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </center>
</body>
</html>';

return $strTime; 
}

}