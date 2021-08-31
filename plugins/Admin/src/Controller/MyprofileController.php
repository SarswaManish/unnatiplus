<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;

class MyprofileController extends AppController
 {
    public $STATES;
    public $CITIES;
      
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->getEventManager()->off($this->Csrf);
    }
     public function initialize()
	{
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadModel('SkAdmin');
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }
	}
	
    function index()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='My Profile';
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        $this->set(compact('strPageTitle','rowAdminInfo'));
    }
    
    function profileUpdateProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['admin_id'];
        $category = $this->SkAdmin->get($intEditId, [
            'contain' => []
        ]);
    
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData['admin_password'] = SecurityMaxHelper::encryptIt($aryPostData['admin_password']);
            $category=$this->SkAdmin->patchEntity($category,$aryPostData);
            if($this->SkAdmin->save($category))
            {
                $this->Flash->success(__('The Profile Updated Successfully.'));
                $rowAdminInfo = $this->SkAdmin->find('all')->where(['admin_id'=>$intEditId])->first();
                $this->getRequest()->getSession()->write('ADMIN',$rowAdminInfo);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Profile could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
    	}
    }
}
 

 


