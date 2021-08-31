<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\PaytmHelper;
use Cake\View\Helper\PayumoneyHelper;

use  Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class BlogDetailsController  extends AppController
{

    public function beforeFilter(Event $event)
{
    parent::beforeFilter($event);
    $this->getEventManager()->off($this->Csrf);
} 
        public function initialize()
	{
	           parent::initialize();
	   	      $this->loadModel('SkUser');
	   	      $this->loadModel('SkProduct');
	   	      $this->loadModel('SkProductbusinessprice');
	   	      $this->loadModel('Transactions');
	   	      	   	      $this->loadModel('Coupon');

	}
	
	
   function index($strBlogSlug)
   {
         $strPageTitle='Cart';
         $this->set(compact('strBlogSlug'));
       
   }
   
  
 
   
}

