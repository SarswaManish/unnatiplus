<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class FaqController  extends AppController
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
        $this->loadModel('SkFaq');
        $this->loadModel('SkPermission');
        $this->loadModel('SkPermissionData');
    }

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	$resRolesList = $this->paginate($this->SkFaq->find('all')->where(['faq_id!=3']));
        $strPageTitle ='Manage FAQ';
    	$this->set(compact('strPageTitle','resRolesList'));
    }
    
    public function addfaq($intEditId=null)
    {
        $rowFaqInfo=array();
        if($intEditId>0)
        {
            $rowFaqInfo = $this->SkFaq->get($intEditId, [ 'contain' => []  ]);
        }
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle ='Add FAQ';
        $this->set(compact('strPageTitle','rowFaqInfo'));
    }
    
    function faqdelete($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $faqInfo = $this->SkFaq->get($intTrashId);
        if ($this->SkFaq->delete($faqInfo))
        {
            $this->Flash->success(__('The FAQ has been deleted'));
        } else
        {
            $this->Flash->error(__('The FAQ could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'index']);
    }
    public function FaqProcessRequest()
    {
        
        $this->viewBuilder()->setLayout('sideBarLayout');
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData = $this->request->getData();
            $category=$this->SkFaq->newEntity();

            $category=$this->SkFaq->patchEntity($category,$aryPostData);
    	    if($this->SkFaq->save($category))
    	    {
    	        $this->Flash->success(__('FAQ Created Successfully'));
                return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The FAQ  could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
    	} 
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
                    $this->SkFaq->deleteAll( ['faq_id IN' =>$aryPostData['faq_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->SkFaq->updateAll(['faq_status'=>'1'],['faq_id IN' =>$aryPostData['faq_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->SkFaq->updateAll(['faq_status'=>'0'],['faq_id  IN' =>$aryPostData['faq_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }
}