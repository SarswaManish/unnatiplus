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
class DashboardController  extends AppController
{

    
        public function initialize()
	{
	           parent::initialize();
	   	      $this->loadModel('SkUser');
	   	        $rowUserInfo = $this->getRequest()->getSession()->read('USER');
              if(!isset($rowUserInfo->user_id))
              {
                  return $this->redirect(SITE_URL);  
              }
	}
   function index()
   {
         $strPageTitle='Dashboard';
         if(isset($_POST['user_first_name']))
         {
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['user_id'];
    	
    	$category = $this->SkUser->get($intEditId, [
            'contain' => []
        ]);
       
    	 $category=$this->SkUser->patchEntity($category,$aryPostData);
    	    if($this->SkUser->save($category))
    	    {
                    $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$this->request->getdata('user_id').'\'')->first();

    	       
    	 $this->getRequest()->getSession()->write('USER',$rowUserInfo);
         
         
    	        $this->Flash->success(__('The Profile Updated Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
   
         }
         $this->set(compact('strPageTitle'));
       
   }
   
   function logout($strRedirect='')
   {
       if($strRedirect=='')
       {
         $strRedirect=  base64_encode(SITE_URL);
       }
        $this->request->getSession()->delete('USER');
       $this->redirect(base64_decode($strRedirect));
   }
   
   function changepassword()
   {
       
       if(isset($_POST['old_password']))
         {
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['user_id'];
    	
    	$category = $this->SkUser->get($intEditId, [
            'contain' => []
        ]);
       if($category->user_password!=$_POST['old_password'])
       {
           
                 $this->Flash->error(__('The old password does not match. Please, try again.'));
    	        return $this->redirect(['action' => 'index']);

       }
       $_POST['user_password'] = $_POST['old_password'];
    	 $category=$this->SkUser->patchEntity($category,$aryPostData);
    	    if($this->SkUser->save($category))
    	    {
                $this->Flash->success(__('The Password Change Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
   
         }
   }
   
  
}