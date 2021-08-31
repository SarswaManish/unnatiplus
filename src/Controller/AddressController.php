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
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AddressController  extends AppController
{

    
        public function initialize()
	{
	           parent::initialize();
	   	      $this->loadModel('SkUser');
                      $this->loadModel('SkAddressBook');
              $rowUserInfo = $this->getRequest()->getSession()->read('USER');
              if(!isset($rowUserInfo->user_id))
              {
                  return $this->redirect(SITE_URL);  
              }
           
	}
   function index()
   {
         $strPageTitle ='Address';
         $this->set(compact('strPageTitle'));
       
   }
   
   function addressProcessRequest()
   {
       
		 if ($this->request->is(['patch', 'post', 'put']))  {

		  $postData=$this->request->getData();

                 if($postData['ab_id']>0)
                     {
                    $coupon= $this->SkAddressBook->get($postData['ab_id'], ['contain' => []]);
                      }else{
		  $coupon= $this->SkAddressBook->newEntity();
                     }
	       $rowCountData = $this->SkAddressBook->find('all')->where(['ab_user_id'=>(int)$postData['ab_user_id']])->count();   
               if($rowCountData<=0)
               {
                   $postData['ab_default']=1;
                   
               }
           $coupon= $this->SkAddressBook->patchEntity($coupon, $postData);
           if ($this->SkAddressBook->save($coupon)) {
               $this->Flash->success(__('The Address has been saved.'));
              if(isset($_POST['from']))
              {
               return $this->redirect(SITE_URL.'cart/checkout');
              }else{
                   return $this->redirect(['action' => 'index']);
              }
           }
           $this->Flash->error(__('The Address could not be saved. Please, try again.'));
     
		 }
      
   }
   
}