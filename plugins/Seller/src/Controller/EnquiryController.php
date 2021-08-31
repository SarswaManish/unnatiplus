<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class EnquiryController  extends AppController
{
public function initialize()
{ 

    parent::initialize();
     $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }
       $this->loadModel('SkEnquiry');
}

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resCouponInfo = $this->paginate($this->SkEnquiry->find('all'));
           	$strPageTitle ='Manage Enquiry';
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
       
      
    $this->SkEnquiry->deleteAll( [
        'enquiry_id IN' =>$aryPostData['enquiry_id']]);
     $this->Flash->success(__('The Enquiry Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
 
            

   
        }
     
}


	
 
    

	
}