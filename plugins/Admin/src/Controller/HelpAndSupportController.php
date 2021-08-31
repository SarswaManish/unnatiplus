<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class HelpAndSupportController  extends AppController
{
    public $paginate = ['limit' => 100  ];
public function initialize()
{ 

    parent::initialize();
  /*   $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }*/
       $this->loadModel('SkHelpSupport');
}

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resCouponInfo = $this->paginate($this->SkHelpSupport->find('all'));
           	$strPageTitle ='Manage Help & Support';
    	         $this->set(compact('resCouponInfo','strPageTitle'));
    }
	
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkHelpSupport->get($intTrashId);
        if ($this->SkHelpSupport->delete($category))
        {
             $this->Flash->success(__('The Help & Support has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Help & Support could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }
    /* This function is done by Harsh Lakhera 11/01/2020*/
    public function bulkaction()
    {
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $intBulkAction = $_POST['bulkaction'];
            if($intBulkAction>0)
            {
                $aryPostData =$_POST;
                $intBulkAction = $aryPostData['bulkaction'];
                if($intBulkAction==1)
                {
                    $this->SkHelpSupport->deleteAll( ['hs_id IN' =>$aryPostData['hs_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->SkHelpSupport->updateAll(['hs_status'=>'1'],['hs_id IN' =>$aryPostData['hs_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->SkHelpSupport->updateAll(['hs_status'=>'0'],['hs_id  IN' =>$aryPostData['hs_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }


	
 
    

	
}