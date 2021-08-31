<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class CustomerController  extends AppController
{
    public $paginate = ['limit' => 100  ];
public function initialize()
{
    parent::initialize();
    $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
            {
            return $this->redirect(SITE_URL.'admin');
            }
        $this->loadModel('SkUser');
        $this->loadModel('SkFeedback');
}

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resCouponInfo = $this->paginate($this->SkFeedback->find('all'));
           	$strPageTitle ='Customer Feedback';
    	         $this->set(compact('resCouponInfo','strPageTitle'));
    }
	
 
    public function userView($userId=null)
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	$rowUserInfo = $this->SkFeedback->find('all')->where(['feedback_id'=>$userId])->first();
        $strPageTitle ='Customer Feedback';
    	$this->set(compact('strPageTitle','rowUserInfo'));
    }

    
    public function bulkaction()
    { 
        
        if ($this->request->is(['patch', 'post', 'put'])) 
            {
                $aryPostData =$_POST;
                $intBulkAction = $aryPostData['bulkaction'];
                if($intBulkAction==1)
                {
                    $this->SkFeedback->deleteAll( ['feedback_id IN'=>$aryPostData['feedback_id']]);
                    $this->Flash->success(__('The Feedback Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $coupon= $this->SkFeedback->get($id);
        if ($this->SkFeedback->delete($coupon)) 
        {            
            $this->Flash->success(__('The Feedback has been deleted.'));
        } else {
            $this->Flash->error(__('The Feedback could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
	
}