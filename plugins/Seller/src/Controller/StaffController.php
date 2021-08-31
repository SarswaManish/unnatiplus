<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class StaffController  extends AppController
{
public function initialize()
{ 

    parent::initialize();
     $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }
       $this->loadModel('SkUser');
              $this->loadModel('SkAdmin');
                            $this->loadModel('SkRoles');


}

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resCouponInfo = $this->paginate($this->SkAdmin->find('all')->where(['admin_default'=>0]));
           	$strPageTitle ='Manage Staff';
           	 $resRoleInfo =$this->SkRoles;
    	         $this->set(compact('resCouponInfo','strPageTitle','resRoleInfo'));
    }
	
	
    public function addstaff($intNull=0)
    {
	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resRoleInfo =$this->SkRoles->find('all');
    	 $resAdminInfo =array();
    	 if($intNull>0)
    	 {
    	 	 $resAdminInfo =$this->SkAdmin->find('all')->where(['admin_id'=>$intNull])->first()->toArray();
    	 }
    $strPageTitle ='Add Staff';
    $this->set(compact('strPageTitle','resRoleInfo','resAdminInfo'));
    }
    
     
     function staffProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['staff_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkAdmin->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkAdmin->newEntity();   
    	  $aryPostData['admin_status']=1;
    	  $aryPostData['admin_publish_date']=date('Y-m-d h:i:s');
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 $aryPostData['admin_password']=SecurityMaxHelper::encryptIt($aryPostData['admin_password']);
    	    $category=$this->SkAdmin->patchEntity($category,$aryPostData);
    	    if($this->SkAdmin->save($category))
    	    {
    	        $this->Flash->success(__('The Staff has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Staff could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     } 
	public function status($id=null)
{
   $this->request->allowMethod(['get', 'status']);
  $coupon= $this->SkAdmin->get($id);
  $aryPostData =$_POST;
  if($coupon->get('admin_status')==1)
  {
     $aryPostData['admin_status'] = 0;
}else{
      $aryPostData['admin_status'] = 1;
    
}
  $coupon=$this->SkAdmin->patchEntity($coupon,$aryPostData);
  if($this->SkAdmin->save($coupon))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}

public function bulkaction()
{ 
    
    if ($this->request->is(['patch', 'post', 'put'])) 
        {
    $aryPostData =$_POST;
   $intBulkAction = $aryPostData['bulkaction'];
   
   if($intBulkAction==1)
   {
       
      
    $this->SkAdmin->deleteAll( [
        'admin_id IN' =>$aryPostData['admin_id']]);
     $this->Flash->success(__('The User Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
   if($intBulkAction==2)
   {
       $this->SkAdmin->updateAll(['admin_status'=>'1'],[
        'admin_id IN' =>$aryPostData['admin_id']]);
       $this->Flash->success(__('Selected Entry Active Successfully'));
          return $this->redirect(['action' => 'index']);
   }
   if($intBulkAction==3)
   {
         $this->SkAdmin->updateAll(['admin_status'=>'0'],[
        'admin_id  IN' =>$aryPostData['admin_id'] ]);
       $this->Flash->success(__('Selected Entry Inactive Successfully'));
          return $this->redirect(['action' => 'index']);
          
   }
            

   
        }
     
}


	
        
    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $coupon= $this->SkAdmin->get($id);
        if ($this->SkAdmin->delete($coupon)) {
            $this->Flash->success(__('The Staff has been deleted.'));
        } else {
            $this->Flash->error(__('The Staff could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }    
    

	
}