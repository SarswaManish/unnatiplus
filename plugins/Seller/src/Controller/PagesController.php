<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class PagesController extends AppController
 {
     public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
      }
      public function initialize()
	{
	      parent::initialize();
	      $this->loadModel('SkPages');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index()
     {
         
         $resTaxesList = $this->paginate($this->SkPages);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Manage Pages';
         $this->set(compact('strPageTitle','resTaxesList'));
     }
     
     function addpages($intEditId=null,$strCopyStatus=null)
     {
         $rowTaxInfo=array();
         if($intEditId>0)
         {
              $rowTaxInfo = $this->SkPages->get($intEditId, [
            'contain' => []  ]);
         }
        
        
         $this->viewBuilder()->setLayout('sideBarLayout');
     
         $strPageTitle='Add Pages';
         $this->set(compact('strPageTitle','rowTaxInfo'));
     }
     
     
     function pagesProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['page_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkPages->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkPages->newEntity();   
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    	    $category=$this->SkPages->patchEntity($category,$aryPostData);
    	    if($this->SkPages->save($category))
    	    {
    	        $this->Flash->success(__('The Pages has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Pages could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
     
 
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkPages->get($intTrashId);
        if ($this->SkPages->delete($category))
        {
             $this->Flash->success(__('The Page has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Page could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }

 }
 