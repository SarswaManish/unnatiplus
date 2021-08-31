<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;

class BlogController extends AppController
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
	      $this->loadModel('SkAdmin');
	      $this->loadModel('SkBcategory');
	      $this->loadModel('SkBlog');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index($strStatus=null)
     {
          $resProductList = $this->paginate($this->SkBlog->find('all')->where(['blog_status IN '=>array(0,1)]));
         if($strStatus=='active')
         {
             $resProductList = $this->paginate($this->SkBlog->find('all',array('order'=>array('blog_id ASC')))->where(['blog_status'=>1]));
         }
         if($strStatus=='inactive')
         {
              $resProductList = $this->paginate($this->SkBlog->find('all',array('order'=>array('blog_id ASC')))->where(['blog_status'=>0]));

         }
         if($strStatus=='trash')
         {
              $resProductList = $this->paginate($this->SkBlog->find('all',array('order'=>array('blog_id ASC')))->where(['blog_status'=>2]));

         }
         
          $resProductListForCount = $this->SkBlog->find('all');
          $resProductListForCount2 = $this->SkBlog->find('all');
          $resProductListForCount3 = $this->SkBlog->find('all');
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Manage Blog';
         $this->set(compact('strPageTitle','resProductList','resProductListForCount','resProductListForCount2','resProductListForCount3','strStatus'));
     }
     
      function addBlog($intEditId=null,$strCopyStatus=null)
     {
         $rowProductInfo=array();
         $resProductBusinessArray =array();
          $resProductFixedArray =array();
        if($intEditId>0)
         {
              $rowProductInfo = $this->SkBlog->get($intEditId, [
            'contain' => []  ]);
         }
         $strCategory =array();
         if(isset($rowProductInfo->blog_category))
         {
             $strCategory = explode(',',$rowProductInfo->blog_category);
             
         }
        
         $this->viewBuilder()->setLayout('sideBarLayout');
         $resParentCategoryList = $this->SkBcategory->find('all',array('order'=>array('category_name ASC')))->toArray();
         $aryCategoryList = $this->buildTree($resParentCategoryList,0);
         $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);
         $strPageTitle='Add Blog';
         
      
         $this->set(compact('strPageTitle','connectionManager','strCategoryTreeStructure','rowProductInfo','strCopyStatus'));
     }
     
        function blogprocessrequest()
     {
     
        
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['blog_id'];
    
    	if($intEditId>0)
    	{
    	   $category = $this->SkBlog->get($intEditId, [
            'contain' => []
        ]);
       
    	}else{
    	    unset($aryPostData['blog_id']);
    	  $category=$this->SkBlog->newEntity();   
    	  $aryPostData['blog_status']=1;
    	  $aryPostData['blog_created_date']=date('Y-m-d h:i:s');
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
             
            if(isset($aryPostData['blog_category_']) && count($aryPostData['blog_category_'])>0)
            {
                
                $aryPostData['blog_category']=implode(',',$aryPostData['blog_category_']);
            }
            
            
             if(isset($_FILES['blog_featured_image_']['name']) && $_FILES['blog_featured_image_']['name']!='')
            { 
                
 $filename =time().str_replace(' ','',$_FILES['blog_featured_image_']['name']);
$filename  =str_replace('&','',$filename);
$acctualfilepath = SITE_UPLOAD_PATH.SITE_BLOG_IMAGE_PATH.$filename;
move_uploaded_file($_FILES['blog_featured_image_']['tmp_name'], $acctualfilepath);

$aryPostData['blog_featured_image'] = $filename;

            }

    	    $category=$this->SkBlog->patchEntity($category,$aryPostData);
    	    if($this->SkBlog->save($category))
    	    {
    	     $intInsertId = $category->product_id;
        	 
        	 
        	 
    	        
    	        $this->Flash->success(__('The Blog has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Blog could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
      function trash($intTrashId)
 {
    // echo $intTrashId;die();
   $this->request->allowMethod(['get']);
   $category = $this->SkBlog->get($intTrashId);
   $aryPostData['blog_status'] = 2;
   $category =$this->SkBlog->patchEntity($category,$aryPostData);
  if($this->SkBlog->save($category))
    	    {
    	        $this->Flash->success(__('Blog Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkBlog->get($intTrashId);
        if ($this->SkBlog->delete($category))
        {
             $this->Flash->success(__('The Blog has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Blog could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }
 public function buildTree($ar, $pid = null) {
    $this->loadModel('SkBcategory');
    $op = array();
    foreach($ar as $item) {
       
      if ($item->category_parent == $pid) {
        $op[$item->category_id] = $item;
        // using recursion
        $children = $this->buildTree($ar, $item->category_id);
        if ($children) {
          $op[$item->category_id]['children'] = $children;
        }
      }
    }
    return $op;
  }
  function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array())
  {
      $strHtml='';
      foreach($aryCategoryTree as $key=>$label)
      {
          if($label->category_parent==0)
          {
              $intLevel=0;
          }
          $strChecked='';
          $strExtraChecked ='';
          if(in_array($label->category_id,$strSelectCategory))
          {
              
              $strChecked = 'checked="checked"';
              $strExtraChecked ='checked';
          }
          $margin =$intLevel*20;
          $strLevelByMargin = 'margin-left:'.$margin.'px;';
         $strHtml .='<div class="checkbox"   style="'.$strLevelByMargin.'"><label><div class="checker"><span class="'.$strExtraChecked.'"><input onclick="setcheckedstatus($(this))" class="styled" name="blog_category_[]" '.$strChecked.' value="'.$label->category_id.'" type="checkbox"></span></div>'.$label->category_name.'</label></div>'; 
          if(isset($label->children))
          {
              $intLevel++;
          $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
          }
      }
      
      return $strHtml;
  }
  

     public function status($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkBlog->get($id);
   $aryPostData =array();
   if($category->get('blog_status')==1)
      {
         $aryPostData['blog_status'] = 0;
      }
   else if($category->get('blog_status')==2)
      {
         $aryPostData['blog_status'] = 0;
    
      }else{
          $aryPostData['blog_status'] = 1;
      }
  $category =$this->SkBlog->patchEntity($category,$aryPostData);
  if($this->SkBlog->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}

 
 }
 