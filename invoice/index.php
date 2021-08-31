<?php ini_set('max_execution_time', 900); session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
date_default_timezone_set('Asia/Kolkata');
/*********************************db connections**************************/

define('DB_HOST','localhost');
define('DB_USER','epub2019');
define('DB_PASSWORD','vYZXA4nDU%Ou');
define('DB_NAME','2019');

$hostname=DB_HOST;
$username=DB_USER;
$password=DB_PASSWORD;
$dbName = DB_NAME;
try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbName",$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=""'));

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
   // echo 'Connected to Database<br/>';
      $conn->query('SET time_zone=\'+05:30\'');

   
	
    }
catch(PDOException $e)
    {
	echo $e->getMessage();
    }
    
    $intUserId =0;
    
    if(isset($_GET['trans_id']))
    {
        $intUserId=$_GET['trans_id'];
        
    }
    
  $sqlSelectTransactionInfo = $conn->query('SELECT * FROM transactions WHERE 1 AND trans_id='.$intUserId);
  $resTransactionInfo = $sqlSelectTransactionInfo->fetch();
  $rowTransactionInfo =(object)$resTransactionInfo;


    
  $sqlSelectUserInfo = $conn->query('SELECT * FROM sk_user WHERE 1 AND user_id='.$rowTransactionInfo->trans_user_id);
  $resTransactionInfo = $sqlSelectUserInfo->fetch();
  $rowUserInfo =(object)$resTransactionInfo;


  $sqlSelectUserInfo = $conn->query('SELECT * FROM sk_address_book WHERE 1 AND ab_id='.$rowTransactionInfo->trans_billing_address);
  $resTransactionInfo = $sqlSelectUserInfo->fetch();
  $rowAddressInfo =$resTransactionInfo;

function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}







//Save the image
ob_start();
include_once 'invoice.php';
$html = ob_get_contents();
ob_clean();
$strPdffilename= $intUserId.'.pdf';
$strPdfSavePath = $_SERVER['DOCUMENT_ROOT']."/webroot/pdf/".$strPdffilename;
include("MPDF57/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->mirrorMargins = true;

$mpdf->WriteHTML($html);
$mpdf->Output($strPdfSavePath,"F");

 $update = ' UPDATE transactions SET invoice_pdf_file=\''.$strPdffilename.'\' WHERE 1 AND trans_id='.$intUserId;
$conn->query($update);

header('location:https://www.eapublications.org/pdf/'.$strPdffilename);
?>