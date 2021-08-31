<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class EnquiryController  extends AppController
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
        $this->loadModel('SkEnquiry');
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $resCouponInfo = $this->paginate($this->SkEnquiry->find('all'));
        $strPageTitle ='Manage Enquiry';
        $this->set(compact('resCouponInfo','strPageTitle'));
    }
    /* This function is done by Harsh Lakhera 11/01/2020 */
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
                    $this->SkEnquiry->deleteAll( ['enquiry_id IN' =>$aryPostData['enquiry_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->SkEnquiry->updateAll(['enquiry_status'=>'1'],['enquiry_id IN' =>$aryPostData['enquiry_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->SkEnquiry->updateAll(['enquiry_status'=>'0'],['enquiry_id  IN' =>$aryPostData['enquiry_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }
}