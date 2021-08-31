<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\View\Helper\RecursHelper;

use Cake\Datasource\ConnectionManager;
class CustomerFeedbackController extends AppController
{
    public function initialize()
	{
        parent::initialize();
        $this->loadModel('SkUser');
        $this->loadModel('SkFeedback');
        $this->loadModel('SkRequirement');
        $this->loadModel('SkProduct');
        $this->loadModel('SkSlider');
        $this->loadModel('SkAddressBook');
     
        $this->loadModel('SkWishlist');
       
        $rowAdminInfo = $this->rowAdminInfo = $this->request->getSession()->read('USER');
        
             
	}

    function index($strApp='')
    { 
         $feedback =array();
         if($this->request->is(['POST'])) {
            $aryPostData  =$this->request->getData(); 
              
             
            $feedback = $this->SkFeedback->newEntity();
            $feedback = $this->SkFeedback->patchEntity($feedback,$aryPostData);
            if($this->SkFeedback->save($feedback))
            { 
                $this->getRequest()->getSession()->write('USER',$feedback);
                $this->Flash->success(__('Feedback Sent.'));
                return $this->redirect(['action' => 'index',$strApp]);

       }else{
                $this->Flash->error(__('Failed try again'));
                return $this->redirect(['action' => 'index',$strApp]);
       }
       
    }
       
        $strPageTitle = 'Customer Registration'; 
        $this->set(compact('strPageTitle','strApp'));
    }
    
    function postYourRequirement($strApp='')
    { 
         $feedback =array();
         if($this->request->is(['POST'])) {
            $aryPostData  =$this->request->getData(); 

                if(isset($_FILES['req_image_']['name']) && $_FILES['req_image_']['name']!='')
            { 
                
             $filename =time().str_replace(' ','',$_FILES['req_image_']['name']);
            $filename  =str_replace('&','',$filename);
            $acctualfilepath = SITE_UPLOAD_PATH.SITE_PRODUCT_IMAGE_PATH.$filename;
            move_uploaded_file($_FILES['req_image_']['tmp_name'], $acctualfilepath);
            
            $aryPostData['req_image'] = $filename;

            }
             
            $feedback = $this->SkRequirement->newEntity();
            $feedback = $this->SkRequirement->patchEntity($feedback,$aryPostData);
            if($this->SkRequirement->save($feedback))
            { 
                $this->getRequest()->getSession()->write('USER',$feedback);
                $this->Flash->success(__('Requirement Sent.'));
                return $this->redirect(['action' => 'post-your-requirement',$strApp]);

       }else{
                $this->Flash->error(__('Failed try again'));
                return $this->redirect(['action' => 'post-your-requirement',$strApp]);
       }
       
    }
       
        $strPageTitle = 'Customer Registration'; 
        $this->set(compact('strPageTitle', 'buyer','strApp'));
    }
    
     function storeLocator($strApp='')
    { 
         $feedback =array();
         if($this->request->is(['POST'])) {
            $aryPostData  =$this->request->getData(); 
             $aryPostData=$this->request->getdata(); 
             
            $feedback = $this->SkRequirement->newEntity();
            $feedback = $this->SkRequirement->patchEntity($feedback,$aryPostData);
            if($this->SkRequirement->save($feedback))
            { 
                $this->getRequest()->getSession()->write('USER',$feedback);
                $this->Flash->success(__('Feedback Sent.'));
                return $this->redirect(['action' => 'post-your-requirement',$strApp]);

       }else{
                $this->Flash->error(__('Failed try again'));
                return $this->redirect(['action' => 'post-your-requirement',$strApp]);
       }
       
    }
       
        $strPageTitle = 'Customer Registration'; 
        $this->set(compact('strPageTitle', 'buyer','strApp'));
    }
    
   
     
     public function deleteAddress($intTrashId)
    {
        $aryPostData= array();
        $this->request->allowMethod(['get']);
        $category = $this->SkAddressBook->get($intTrashId);
        if ($this->SkAddressBook->delete($category))
        {
            $this->Flash->success(__('The address has been deleted'));
            return $this->redirect(['action' => 'manage-address']);
        } else{
            $this->Flash->error(__('The  could not be deleted. Please, try again.'));
            return $this->redirect(['action' => 'manage-address']);
        }
            
    } 
}