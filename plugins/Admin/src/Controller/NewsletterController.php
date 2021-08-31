<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class NewsletterController  extends AppController
{
public function initialize()
{ 

    parent::initialize();
     $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }
       $this->loadModel('SkNewsletter');
              $this->loadModel('SkRequestcallback');

}

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resCouponInfo = $this->paginate($this->SkNewsletter->find('all'));
           	$strPageTitle ='Newsletter';
    	         $this->set(compact('resCouponInfo','strPageTitle'));
    }
	

public function bulkaction()
{ 
    
    if ($this->request->is(['patch', 'post', 'put'])) 
        {
    $aryPostData =$_POST;
   $intBulkAction = $aryPostData['bulkaction'];
   
   if($intBulkAction==1)
   {
       
      
    $this->SkNewsletter->deleteAll( [
        'newsletter_id IN' =>$aryPostData['newsletter_id']]);
     $this->Flash->success(__('The Newsletter Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
 
            

   
        }
     
}

public function bulkactionrequest()
{ 
    
    if ($this->request->is(['patch', 'post', 'put'])) 
        {
    $aryPostData =$_POST;
   $intBulkAction = $aryPostData['bulkaction'];
   
   if($intBulkAction==1)
   {
       
      
    $this->SkRequestcallback->deleteAll( [
        'rcb_id IN' =>$aryPostData['rcb_id']]);
     $this->Flash->success(__('The Enquiry Deleted Successfully'));
    return $this->redirect(['action' => 'requestcallback']);
     
   }
 
            

   
        }
     
}


function requestcallback()
{
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resCouponInfo = $this->paginate($this->SkRequestcallback->find('all'));
     	$strPageTitle ='Request a Call Back';
    	         $this->set(compact('resCouponInfo','strPageTitle')); 
    
}
	
 
    

	
}