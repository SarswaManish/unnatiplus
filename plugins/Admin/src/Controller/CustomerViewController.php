<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class CustomerViewController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    public function initialize()
	{
        parent::initialize();
        $this->loadModel('SkAdmin');
        $this->loadModel('SkCategory');
        $this->loadModel('SkCustomerView');
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }
	}
	
    function index($intCatId =null)
    {
        if(isset($_POST['bulkaction']))
        {
            $strType =  $_POST['bulkaction'];
            if($strType==1)
            {
                $this->SkCustomerView->deleteAll(['customer_id IN' => $_POST['customer_id']]);
                $this->Flash->success(__('Customer View Deleted Successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            if($strType==2)
            {
                $this->SkCustomerView->updateAll(array("customer_status" => 1),array("customer_id IN" => $_POST['customer_id']) );  
                $this->Flash->success(__('Status Change Successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            if($strType==3)
            {
                $this->SkCustomerView->updateAll(array("customer_status" =>0),array("customer_id IN" => $_POST['customer_id']) );  
                $this->Flash->success(__('Status Change Successfully.'));
                return $this->redirect(['action' => 'index']);  
            }
        }
        if($intCatId!=null)
        {
            $rowCategoryInfo = $this->SkCustomerView->get($intCatId, ['contain' => []]);
        }else{
            $rowCategoryInfo =array();  
        }
        $resCategoryList = $this->paginate($this->SkCustomerView->find('all')->where(['customer_status IN'=>array(0,1)]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Customer Review';
        $this->set(compact('strPageTitle','rowCategoryInfo','resCategoryList'));
    }
     
    function unitProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['customer_id'];
    	if($intEditId>0)
    	{
            $category = $this->SkCustomerView->get($intEditId, [
                'contain' => []
            ]);
    	}else{
    	  $category=$this->SkCustomerView->newEntity();   
    	  $aryPostData['customer_status']=1;
    	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkCustomerView->patchEntity($category,$aryPostData);
            if($this->SkCustomerView->save($category))
            {
                $this->Flash->success(__('The Customer View has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Customer View could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
         
    }

    function trash($intTrashId)
    {
        $this->request->allowMethod(['get']);
          if($this->SkCustomerView->deleteAll($intTrashId))
        {
            $this->Flash->success(__('Customer review Deleted Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function status($id=null)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkCustomerView->get($id);
        $aryPostData =array();
        if($category->get('customer_status')==1)
        {
            $aryPostData['customer_status'] = 0;
        }else{
            $aryPostData['customer_status'] = 1;
        }
        $category =$this->SkCustomerView->patchEntity($category,$aryPostData);
        if($this->SkCustomerView->save($category))
        {
            $this->Flash->success(__('Status Update Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }
}
 