<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class RolesController  extends AppController
{
public function initialize()
{ 

    parent::initialize();
     $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }
       $this->loadModel('SkRoles');
       $this->loadModel('SkPermission');
       $this->loadModel('SkPermissionData');

}

 public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	$resRolesList = $this->paginate($this->SkRoles->find('all')->where(['role_id!=3']));

           	$strPageTitle ='Manage Roles';
    	         $this->set(compact('strPageTitle','resRolesList'));
    }
 public function addrole()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');

           	$strPageTitle ='Add Roles';
    	         $this->set(compact('strPageTitle'));
    }
    
    public function RolesProcessRequest()
    {
        
          $this->viewBuilder()->setLayout('sideBarLayout');
 if($this->request->is(['patch', 'post', 'put'])) 
        {
        $aryPostData = $this->request->getData();
        $category=$this->SkRoles->newEntity();

        $category=$this->SkRoles->patchEntity($category,$aryPostData);
    	    if($this->SkRoles->save($category))
    	    {
    	        $this->Flash->success(__('Role Created Successfully'));
    	        
                  
                         return $this->redirect(['action' => 'index']);
                    
                    
    	       
    	    }
    	    $this->Flash->error(__('The Roles  could not be saved. Please, try again.'));
    	    
    	        
                         return $this->redirect(['action' => 'index']);
                    

    	} 
    }

  function managepermission($intRoleId=null)
  {
      
      if(isset($_POST['permission']))
      {
             $intRoleId =$_POST['role_id'];
            $this->SkPermissionData->deleteAll( [
        'pd_role ' =>$intRoleId]);
        
        
       
          foreach($_POST['permission'] as $key=>$label)
          {
              
        $aryPostData = array();
        $aryPostData['pd_role']=$intRoleId;
        $aryPostData['pd_permission_id']=$key;
        if(in_array(1,$label))
        {
         $aryPostData['pd_entry']=1;
        }else{
            $aryPostData['pd_entry']=0;
        }
        if(in_array(2,$label))
        {
         $aryPostData['pd_delete']=1;
        }else{
            $aryPostData['pd_delete']=0;
        }
        if(in_array(3,$label))
        {
         $aryPostData['pd_view']=1;
        }else{
            $aryPostData['pd_view']=0;
        }
        $category=$this->SkPermissionData->newEntity();
        $category=$this->SkPermissionData->patchEntity($category,$aryPostData);
    	$this->SkPermissionData->save($category);
              
          }
          
          $this->Flash->success(__('Permission Change Successfully'));
    	        
                  
                         return $this->redirect(['action' => 'index']); 
      }
       $rowRoleInfo=$this->SkRoles->find('all')->where(['role_id'=>$intRoleId])->first();
      	$this->viewBuilder()->setLayout('sideBarLayout');
        $resPermission =$this->SkPermission->find('all');
        $resPermissionData =$this->SkPermissionData;
           	$strPageTitle ='Manage Roles';
    	         $this->set(compact('strPageTitle','resPermission','rowRoleInfo','resPermissionData'));
  }



	


	
}