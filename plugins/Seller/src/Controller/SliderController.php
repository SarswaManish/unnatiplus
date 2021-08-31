<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;

class SliderController extends AppController
 {
    public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
       $this->getEventManager()->off($this->Csrf);
      }
     public function initialize()
	{
	     parent::initialize();
          $this->loadComponent('Csrf');
          $this->loadModel('SkSlider');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index($strStatus=null)
     {
         $resSliderList = $this->paginate($this->SkSlider->find('all'));
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Manage Slider';
         $this->set(compact('strPageTitle','resSliderList'));
     }
     
      function addslider($intEditId=null,$strCopyStatus=null)
     {
         $rowProductInfo=array();
        if($intEditId>0)
         {
              $rowProductInfo = $this->SkSlider->get($intEditId, [
            'contain' => []  ]);
         }
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Add Slider';
         $this->set(compact('strPageTitle','rowProductInfo'));
     }
     
        function SliderProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['slider_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkSlider->get($intEditId, [
            'contain' => []
        ]);
       
    	}else{
    	    unset($aryPostData['slider_id']);
    	  $category=$this->SkSlider->newEntity();   
    	  $aryPostData['slider_status']=1;
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
         if(isset($_FILES['slider_image_']['name']) && $_FILES['slider_image_']['name']!='')
         {
            $filename =time().str_replace(' ','',$_FILES['slider_image_']['name']);
$filename  =str_replace('&','',$filename);
$acctualfilepath = SITE_UPLOAD_PATH.SITE_SLIDER_IMAGE_PATH.$filename;
move_uploaded_file($_FILES['slider_image_']['tmp_name'], $acctualfilepath);
$aryPostData['slider_image']=$filename;
         }
            
            

    	    $category=$this->SkSlider->patchEntity($category,$aryPostData);
    	    if($this->SkSlider->save($category))
    	    {
    	        
    	        $this->Flash->success(__('The slider has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The slider could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
     
     
     public function bulkaction()
{ 
    
    if ($this->request->is(['patch', 'post', 'put'])) 
        {
    $aryPostData =$_POST;
   $intBulkAction = $aryPostData['bulkaction'];
   if($intBulkAction==1)
   {
       
      
    $this->SkSlider->deleteAll( [
        'slider_id IN' =>$aryPostData['slider_id']]);
     $this->Flash->success(__('The Slider Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
   if($intBulkAction==2)
   {
       $this->SkSlider->updateAll(['slider_status'=>'1'],[
        'slider_id IN' =>$aryPostData['slider_id']]);
       $this->Flash->success(__('Selected Entry Active Successfully'));
          return $this->redirect(['action' => 'index']);
   }
   if($intBulkAction==3)
   {
         $this->SkSlider->updateAll(['slider_status'=>'0'],[
        'slider_id  IN' =>$aryPostData['slider_id'] ]);
       $this->Flash->success(__('Selected Entry Inactive Successfully'));
          return $this->redirect(['action' => 'index']);
          
   }
            

   
        }
     
}
      function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkSlider->get($intTrashId);
   $aryPostData['slider_status'] = 2;
   $category =$this->SkSlider->patchEntity($category,$aryPostData);
  if($this->SkSlider->save($category))
    	    {
    	        $this->Flash->success(__('Slider Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkSlider->get($intTrashId);
        if ($this->SkSlider->delete($category))
        {
             $this->Flash->success(__('The Slider has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Slider could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }

 


     public function status($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkSlider->get($id);
   $aryPostData =array();
   if($category->get('slider_status')==1)
      {
         $aryPostData['slider_status'] = 0;
      }
   else if($category->get('slider_status')==2)
      {
         $aryPostData['slider_status'] = 0;
    
      }else{
          $aryPostData['slider_status'] = 1;
      }
  $category =$this->SkSlider->patchEntity($category,$aryPostData);
  if($this->SkSlider->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}

 }
 