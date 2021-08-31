<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class SizeController extends AppController
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
	      $this->loadModel('SkSize');
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
           $this->SkSize->deleteAll(['size_id IN' => $_POST['size_id']]);
             $this->Flash->success(__('Size Deleted Successfully.'));
    	        return $this->redirect(['action' => 'index']);
           }
            if($strType==2)
           {
              $this->SkSize->updateAll(array("size_status" => 1),array("size_id IN" => $_POST['size_id']) );  
              $this->Flash->success(__('Status Change Successfully.'));
    	        return $this->redirect(['action' => 'index']);
           }
            if($strType==3)
           {
               $this->SkSize->updateAll(array("size_status" =>0),array("size_id IN" => $_POST['size_id']) );  
              $this->Flash->success(__('Status Change Successfully.'));
    	        return $this->redirect(['action' => 'index']);  
           }
             
         }
       if($intCatId!=null)
        {
         $rowCategoryInfo = $this->SkSize->get($intCatId, ['contain' => []]);
        }else{
          $rowCategoryInfo =array();  
        }
         $resCategoryList = $this->paginate($this->SkSize->find('all')->where(['size_status IN'=>array(0,1)]));
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Size';
         $this->set(compact('strPageTitle','rowCategoryInfo','resCategoryList'));
     }
     
     function sizeProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['size_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkSize->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkSize->newEntity();   
    	  $aryPostData['size_status']=1;
    	}
    	
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    
            
    	    $category=$this->SkSize->patchEntity($category,$aryPostData);
    	    if($this->SkSize->save($category))
    	    {
    	        $this->Flash->success(__('The Size has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Size could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }

     
 function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkSize->get($intTrashId);
   $aryPostData['size_status'] = 2;
   $category =$this->SkSize->patchEntity($category,$aryPostData);
  if($this->SkSize->save($category))
    	    {
    	        $this->Flash->success(__('Size Deleted Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }

 
 public function status($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkSize->get($id);
   $aryPostData =array();
   if($category->get('size_status')==1)
      {
         $aryPostData['size_status'] = 0;
      }
   else
      {
         $aryPostData['size_status'] = 1;
    
      }
  $category =$this->SkSize->patchEntity($category,$aryPostData);
  if($this->SkSize->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
    
}
 