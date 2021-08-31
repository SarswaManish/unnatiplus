<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class BrandController extends AppController
 {
     public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
      }
      public function initialize()
	{
	     parent::initialize();
	      $this->loadModel('SkBrand');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index($intTagId=null)
     {
         if($intTagId!=null)
        {
         $rowTagInfo = $this->SkBrand->get($intTagId, ['contain' => []]);
        }else{
          $rowTagInfo =array();  
        }
         $resTagList = $this->paginate($this->SkBrand);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Brand';
         $this->set(compact('strPageTitle','rowTagInfo','resTagList'));
         $this->set(compact('strPageTitle'));
     }
     function tagProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['brand_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkBrand->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkBrand->newEntity();   
    	  $aryPostData['brand_status']=1;
    	  $aryPostData['brand_created_date']=date('Y-m-d h:i:s');
    	}
    	
    	
       if($this->request->is(['patch', 'post', 'put'])) 
        {
            if(isset($_FILES['brand_image_']['name']) && $_FILES['brand_image_']['name']!='')
            { 
                
 $filename =time().str_replace(' ','',$_FILES['brand_image_']['name']);
$filename  =str_replace('&','',$filename);
$acctualfilepath = SITE_UPLOAD_PATH.SITE_CATEGORY_ICON_PATH.$filename;
move_uploaded_file($_FILES['brand_image_']['tmp_name'], $acctualfilepath);

$aryPostData['brand_image'] = $filename;

            }
            
    	 
    	    $category=$this->SkBrand->patchEntity($category,$aryPostData);
    	    if($this->SkBrand->save($category))
    	    {
    	        $this->Flash->success(__('The Brand has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Brand could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
     
   function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkBrand->get($intTrashId);
   $aryPostData['brand_status'] = 2;
   $category =$this->SkBrand->patchEntity($category,$aryPostData);
  if($this->SkBrand->save($category))
    	    {
    	        $this->Flash->success(__('Brand Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 
 
  function status($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkBrand->get($intTrashId);
   if($category->get('brand_status')==1)
   {
      $aryPostData['brand_status'] = 0;
    
   }else{
   $aryPostData['brand_status'] = 1;
   }
   $category =$this->SkBrand->patchEntity($category,$aryPostData);
  if($this->SkBrand->save($category))
    	    {
    	        $this->Flash->success(__('Brand Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkBrand->get($intTrashId);
        if ($this->SkBrand->delete($category))
        {
             $this->Flash->success(__('The Brand has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Brand could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }
    
 }
 