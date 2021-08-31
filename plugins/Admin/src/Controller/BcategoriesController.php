<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class BcategoriesController extends AppController
 {
      public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
      }
     public function initialize()
	{
	     parent::initialize();
	      $this->loadModel('SkAdmin');
	      $this->loadModel('SkBcategory');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
	
     function index($intCatId =null)
     {
       if($intCatId!=null)
        {
         $rowCategoryInfo = $this->SkBcategory->get($intCatId, ['contain' => []]);
        }else{
          $rowCategoryInfo =array();  
        }
         $resParentCategoryList = $this->SkBcategory->find('all',array('order'=>array('category_id DESC')))->where(['category_parent'=>0]);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Blog Categories';
         $resCategoryListData =$this->SkBcategory->find('all')->toArray();

  
         $this->set(compact('strPageTitle','rowCategoryInfo','resCategoryList','resParentCategoryList','resCategoryListData'));
     }
     public function bulkaction()
{ 
    
    if ($this->request->is(['patch', 'post', 'put'])) 
        {
    $aryPostData =$_POST;

   $intBulkAction = $aryPostData['bulkaction'];
   
   if($intBulkAction==1)
   {
       
      
    $this->SkBcategory->deleteAll( [
        'category_id IN' =>$aryPostData['category_id']]);
     $this->Flash->success(__('The Category Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
   if($intBulkAction==2)
   {
       $this->SkBcategory->updateAll(['category_status'=>1],[
        'category_id IN' =>$aryPostData['category_id']]);
       $this->Flash->success(__('Selected Entry Active Successfully'));
          return $this->redirect(['action' => 'index']);
   }
   if($intBulkAction==3)
   {
         $this->SkBcategory->updateAll(['category_status'=>'0'],[
        'category_id  IN' =>$aryPostData['category_id'] ]);
       $this->Flash->success(__('Selected Entry Inactive Successfully'));
          return $this->redirect(['action' => 'index']);
          
   }
            

   
        }
        exit;
     
}
     function categoryProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['category_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkBcategory->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkBcategory->newEntity();   
    	  $aryPostData['category_status']=1;
    	  $aryPostData['category_created_datetime']=date('Y-m-d h:i:s');
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    	  if(isset($_FILES['category_icon_']['name']) && $_FILES['category_icon_']['name']!='')
            { 
                
 $filename =time().str_replace(' ','',$_FILES['category_icon_']['name']);
$filename  =str_replace('&','',$filename);
$acctualfilepath = SITE_UPLOAD_PATH.SITE_CATEGORY_ICON_PATH.$filename;
move_uploaded_file($_FILES['category_icon_']['tmp_name'], $acctualfilepath);

$aryPostData['category_icon'] = $filename;

            }
            
             if(isset($_FILES['category_banner_']['name']) && $_FILES['category_banner_']['name']!='')
            { 
                
 $filename =time().str_replace(' ','',$_FILES['category_banner_']['name']);
$filename  =str_replace('&','',$filename);
$acctualfilepath = SITE_UPLOAD_PATH.SITE_CATEGORY_ICON_PATH.$filename;
move_uploaded_file($_FILES['category_banner_']['tmp_name'], $acctualfilepath);

$aryPostData['category_banner'] = $filename;

          }
            if(!isset($aryPostData['category_show_menu']))
            {
                $aryPostData['category_show_menu']=0;
            }
            
    	    $category=$this->SkBcategory->patchEntity($category,$aryPostData);
    	    if($this->SkBcategory->save($category))
    	    {
    	        $this->Flash->success(__('The Category has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Category could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }

     
 function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkBcategory->get($intTrashId);
   $aryPostData['category_status'] = 2;
   $category =$this->SkBcategory->patchEntity($category,$aryPostData);
  if($this->SkBcategory->save($category))
    	    {
    	        $this->Flash->success(__('Category Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkBcategory->get($intTrashId);
        if ($this->SkBcategory->delete($category))
        {
            
             $this->SkBcategory->updateAll(['category_parent'=>'0'],[
        'category_parent' =>$intTrashId]);
        
             $this->Flash->success(__('The category has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The category could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }
 
 public function status($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkBcategory->get($id);
   $aryPostData =array();
   if($category->get('category_status')==1)
      {
         $aryPostData['category_status'] = 0;
      }
   else
      {
         $aryPostData['category_status'] = 1;
    
      }
  $category =$this->SkBcategory->patchEntity($category,$aryPostData);
  if($this->SkBcategory->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
}
 