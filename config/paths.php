<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       MIT License (https://opensource.org/licenses/mit-license.php)
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('ROOT', dirname(__DIR__));

/**
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('APP_DIR', 'src');

/**
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * Path to the config directory.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS', ROOT . DS . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

/**
 * Encode and Title to the cake directory.
 */
define('SITE_TITLE','Unnati+');
define('SITE_ENCODE_SCHEME','wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA');
define('SITE_URL','https://'.$_SERVER['HTTP_HOST'].'/');
/**
 * Encode and Title to the cake directory.
 */
define('SITE_UPLOAD_PATH',WWW_ROOT.'assets/img/uploads/');
define('SITE_UPLOAD_URL',SITE_URL.'webroot/assets/img/uploads/');
define('SITE_CATEGORY_ICON_PATH','category_icon/');
define('SITE_PRODUCT_IMAGE_PATH','product_image/');
define('SITE_BLOG_IMAGE_PATH','blog_image/');
define('SITE_SELLER_IMAGE_PATH','seller_image/');

define('SITE_SLIDER_IMAGE_PATH','slider_image/');
define('SITE_COUPON_IMAGE_PATH','coupon_image/');
define('SITE_THEME_IMAGE_PATH','theme_image/');
 
define('PAYTM_MERCHANT_WEBSITE','WEBPROD');
define('PAYTM_MERCHANT_MID','JIYOHO17622674282762');
define('CALLBACK_URL',SITE_URL."cart/paytmresponse");
define('CHANNEL_ID',"WEB");
define('INDUSTRY_TYPE_ID',"Retail109");
define('PAYTM_MERCHANT_KEY','lH2z0LDKMLsuofdN');

define('PAYTM_ENVIRONMENT',"PROD");
define('PAYUMONEY_ENVIRONMENT',"TEST");


/*$PAYTM_DOMAIN = "pguat.paytm.com";
if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_DOMAIN = 'secure.paytm.in';
}

define('PAYTM_REFUND_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/REFUND');
define('PAYTM_STATUS_QUERY_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/TXNSTATUS');
define('PAYTM_STATUS_QUERY_NEW_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/getTxnStatus');
define('PAYTM_TXN_URL', 'https://'.$PAYTM_DOMAIN.'/oltp-web/processTransaction');*/

$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}
define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);


$PAYTM_TXN_URL='https://test.payu.in';
	$PAYTM_TXN_URL='https://secure.payu.in';

if (PAYUMONEY_ENVIRONMENT == 'PROD') {
	$PAYTM_TXN_URL='https://secure.payu.in';
}


define('PAYU_MERCHANT_KEY', '6yqe7w');
define('PAYU_MERCHANT_SALT', 'JSpesLLi');
define('PAYU_BASE_URL', $PAYTM_TXN_URL);

if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443))
{ 
 
 $strPage = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if($strPage=='https://www.eapublications.org/home/')
{
    header("location:".SITE_URL);
    
    
}

 
}else{
   $strPage = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  
    header("location:".$strPage);
}
