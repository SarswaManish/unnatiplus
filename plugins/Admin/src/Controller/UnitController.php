<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class UnitController extends AppController
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
        $this->loadModel('SkUnit');
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
                $this->SkUnit->deleteAll(['unit_id IN' => $_POST['unit_id']]);
                $this->Flash->success(__('Attribute Deleted Successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            if($strType==2)
            {
                $this->SkUnit->updateAll(array("unit_status" => 1),array("unit_id IN" => $_POST['unit_id']) );  
                $this->Flash->success(__('Status Change Successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            if($strType==3)
            {
                $this->SkUnit->updateAll(array("unit_status" =>0),array("unit_id IN" => $_POST['unit_id']) );  
                $this->Flash->success(__('Status Change Successfully.'));
                return $this->redirect(['action' => 'index']);  
            }
        }
        if($intCatId!=null)
        {
            $rowCategoryInfo = $this->SkUnit->get($intCatId, ['contain' => []]);
        }else{
            $rowCategoryInfo =array();  
        }
        $resCategoryList = $this->paginate($this->SkUnit->find('all')->where(['unit_status IN'=>array(0,1)]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Attributes';
        $this->set(compact('strPageTitle','rowCategoryInfo','resCategoryList'));
    }
     
    function unitProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['unit_id'];
    	if($intEditId>0)
    	{
            $category = $this->SkUnit->get($intEditId, [
                'contain' => []
            ]);
    	}else{
    	  $category=$this->SkUnit->newEntity();   
    	  $aryPostData['unit_status']=1;
    	}
    	
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkUnit->patchEntity($category,$aryPostData);
            if($this->SkUnit->save($category))
            {
                $this->Flash->success(__('The Attribute has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Attribute could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
         
    }

     
 function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkUnit->get($intTrashId);
   $aryPostData['unit_status'] = 2;
   $category =$this->SkUnit->patchEntity($category,$aryPostData);
  if($this->SkUnit->save($category))
    	    {
    	        $this->Flash->success(__('Attribute Deleted Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }

 
 public function status($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkUnit->get($id);
   $aryPostData =array();
   if($category->get('unit_status')==1)
      {
         $aryPostData['unit_status'] = 0;
      }
   else
      {
         $aryPostData['unit_status'] = 1;
    
      }
  $category =$this->SkUnit->patchEntity($category,$aryPostData);
  if($this->SkUnit->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
    
}
 