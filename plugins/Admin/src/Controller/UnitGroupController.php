<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class UnitGroupController extends AppController
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
	      $this->loadModel('SkUnitGroup');
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
           $this->SkUnitGroup->deleteAll(['unit_group_id IN' => $_POST['unit_group_id']]);
             $this->Flash->success(__('Unit Group Deleted Successfully.'));
    	        return $this->redirect(['action' => 'index']);
           }
            if($strType==2)
           {
              $this->SkUnitGroup->updateAll(array("unit_group_status" => 1),array("unit_group_id IN" => $_POST['unit_group_id']) );  
              $this->Flash->success(__('Status Change Successfully.'));
    	        return $this->redirect(['action' => 'index']);
           }
            if($strType==3)
           {
               $this->SkUnitGroup->updateAll(array("unit_group_status" =>0),array("unit_group_id IN" => $_POST['unit_group_id']) );  
              $this->Flash->success(__('Status Change Successfully.'));
    	        return $this->redirect(['action' => 'index']);  
           }
             
         }
       if($intCatId!=null)
        {
         $rowCategoryInfo = $this->SkUnitGroup->get($intCatId, ['contain' => []]);
        }else{
          $rowCategoryInfo =array();  
        }
         $resCategoryList = $this->paginate($this->SkUnitGroup->find('all')->where(['unit_group_status IN'=>array(0,1)]));
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Unit Group';
         $this->set(compact('strPageTitle','rowCategoryInfo','resCategoryList'));
     }
     
     function unitProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['unit_group_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkUnitGroup->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkUnitGroup->newEntity();   
    	  $aryPostData['unit_group_status']=1;
    	}
    	
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    
            
    	    $category=$this->SkUnitGroup->patchEntity($category,$aryPostData);
    	    if($this->SkUnitGroup->save($category))
    	    {
    	        $this->Flash->success(__('The Unit Group has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Unit Group could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }

     
 function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkUnitGroup->get($intTrashId);
   $aryPostData['unit_group_status'] = 2;
   $category =$this->SkUnitGroup->patchEntity($category,$aryPostData);
  if($this->SkUnitGroup->save($category))
    	    {
    	        $this->Flash->success(__('Unit Group Deleted Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }

 
 public function status($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkUnitGroup->get($id);
   $aryPostData =array();
   if($category->get('unit_group_status')==1)
      {
         $aryPostData['unit_group_status'] = 0;
      }
   else
      {
         $aryPostData['unit_group_status'] = 1;
    
      }
  $category =$this->SkUnitGroup->patchEntity($category,$aryPostData);
  if($this->SkUnitGroup->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
    
}
 