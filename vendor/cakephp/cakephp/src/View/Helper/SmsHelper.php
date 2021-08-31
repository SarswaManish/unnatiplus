<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.9.1
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\View\Helper;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;
use Cake\Http\Client;

/**
 * Html Helper class for easy use of HTML widgets.
 *
 * HtmlHelper encloses all methods needed while working with HTML pages.
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 * @link https://book.cakephp.org/3.0/en/views/helpers/html.html
 */
class SmsHelper extends Helper
{
  


 
 public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);
    }


 public static function sendSms($mobile,$message)
{
    $strUrl ="http://smpp.webtechsolution.co/http-tokenkeyapi.php?authentic-key=3137476f646f64753030313231331579253689&senderid=UNNATI&route=4&number=$mobile&message=$message";
  
$http = new Client();
$response = $http->get($strUrl);
////pr($response);
return 'success'; 


}

}