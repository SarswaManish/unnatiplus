<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class TagController extends AppController
 {
     public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
      }
      public function initialize()
	{
	     parent::initialize();
	      $this->loadModel('SkTag');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index($intTagId=null)
     {
         $arypostdata=array();
         if($intTagId!=null)
        {
         $rowTagInfo = $this->SkTag->get($intTagId, ['contain' => []]);
        }else{
          $rowTagInfo =array();
          
           if($this->request->is(['patch', 'post', 'put']))
    {
        $arypostdata=$_POST;
        $arypostdata=$this->request->getdata();
        if(isset($arypostdata['bulkaction']))
            {
                $action = $arypostdata['bulkaction'];
                $ids = $arypostdata['tag_id'];
                if($action=='1')
                {
                    $this->SkTag->deleteAll(['tag_id IN'=>$ids]);
        	        $this->Flash->success(__('Delete Successfully.'));
        	        return $this->redirect(['action' => 'index']);
                }
                elseif($action=='2')
                {
                    $this->SkTag->updateAll(['tag_status'=>1],['tag_id IN'=>$ids]);
        	        $this->Flash->success(__('Active Successfully.'));
        	        return $this->redirect(['action' => 'index']);
                }
                elseif($action=='3')
                {
                    $this->SkTag->updateAll(['tag_status'=>0],['tag_id IN'=>$ids]);
        	        $this->Flash->success(__('Inactive Successfully.'));
        	        return $this->redirect(['action' => 'index']);
                }
            }
            else
            {
                if(isset($arypostdata['tag_id'])&&$arypostdata['tag_id']>0)
                {
                    $tag = $this->SkTag->get($arypostdata['tag_id']);
                }
                else
                {
                    $tag = $this->SkTag->newEntity();
                    /*$arypostdata['tag_status'] = 1;*/
                }
                $tag = $this->SkTag->patchEntity($tag,$arypostdata);
                $tag = $this->SkTag->save($tag);
    	        $this->Flash->success(__('tag has been saved.'));
    	        return $this->redirect(['action' => 'index']);
            }
            
    }
        }
         $resTagList = $this->paginate($this->SkTag);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Tag';
         $this->set(compact('strPageTitle','rowTagInfo','resTagList','tag'));
         $this->set(compact('strPageTitle'));
     }
     function tagProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['tag_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkTag->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkTag->newEntity();   
    	  $aryPostData['tag_status']=1;
    	  $aryPostData['tag_created_date']=date('Y-m-d h:i:s');
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    	    $category=$this->SkTag->patchEntity($category,$aryPostData);
    	    if($this->SkTag->save($category))
    	    {
    	        $this->Flash->success(__('The tag has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The tag could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
     
   function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkTag->get($intTrashId);
   $aryPostData['tag_status'] = 2;
   $category =$this->SkTag->patchEntity($category,$aryPostData);
  if($this->SkTag->save($category))
    	    {
    	        $this->Flash->success(__('Tag Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkTag->get($intTrashId);
        if ($this->SkTag->delete($category))
        {
             $this->Flash->success(__('The Tag has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Tag could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }
    
 }
 