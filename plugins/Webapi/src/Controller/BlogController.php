<?php namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Utility\Security;

class BlogController  extends AppController
{


public function initialize()
{
    parent::initialize();
    $this->loadComponent('Csrf');
$this->loadModel('Admin.Postcategory');
$this->loadModel('Admin.Tag');

 $rowAdminInfo =   $this->request->getSession()->read('ADMIN');
        if($rowAdminInfo['admin_id']<=0)
        {
        return $this->redirect(
      ['controller' => 'Login', 'action' => 'index']
       );
        }

}
public function index($id=null)
{


$strLoadExtraCondiktion='';
$strSearchVal ='';
     if(isset($_POST['searchval']))
{
$strLoadExtraCondiktion = ' 1 AND blog_title LIKE \'%'.$_POST['searchval'].'%\'';
$strSearchVal = $_POST['searchval'];


}
     $this->viewBuilder()->setLayout('defaultAdmin');
     $title ='Manage Post | '.SITE_TITLE;
     $resCategoryInfo =$this->Postcategory;

if($strLoadExtraCondiktion!='')
{
$rowPostCountObject=$this->Blog->find('all')->where($strLoadExtraCondiktion);
$rowPostInactiveCountObject=$this->Blog->find('all')->where($strLoadExtraCondiktion);
$resBlogListInfo =$this->Blog->find('all')->where($strLoadExtraCondiktion);
}else{
	if($id=='active')
	{
	   $resBlogListInfo=$this->Blog->find('all')->where(['Blog.blog_status'=>1]);
	}
	else if($id=='publish')
	{
		 $resBlogListInfo=$this->Blog->find('all')->where(['Blog.blog_status'=>1]);
	}
	else if($id=='inactive')
	{
		 $resBlogListInfo=$this->Blog->find('all')->where(['Blog.blog_status'=>0]);
	}
	else
	{
		$resBlogListInfo =$this->Blog->find('all');
	}
$rowPostCountObject=$this->Blog->find('all');
$rowPostInactiveCountObject=$this->Blog->find('all')->where($strLoadExtraCondiktion);

}
     $rowBlogInfo = $this->paginate($resBlogListInfo); 

     $resTagInfo=$this->Tag;
     $this->set(compact('rowBlogInfo','title','resCategoryInfo','resTagInfo','rowPostCountObject','rowPostInactiveCountObject','strSearchVal','id'));
     
}
    
public function status($id=null)
{
    
   
   $this->request->allowMethod(['post', 'status']);
   $Blog= $this->Blog->get($id);
$postdata =$this->request->getData();
   if($Blog->get('blog_status')==1)
     {
       $postdata['blog_status'] = 0;
     }
   else
     {
       $postdata['blog_status'] = 1;
    
     }
   $Blog=$this->Blog->patchEntity($Blog,$postdata);
   if($this->Blog->save($Blog))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}

public function bulkaction()
{ 
    
    if ($this->request->is(['patch', 'post', 'put'])) 
        {
  
   $intBulkAction = $this->request->getData('bulkaction');
   
   if($intBulkAction==1)
   {
     $this->Blog->deleteAll( ['blog.blog_id IN' =>explode(',',$this->request->getData('blog_id'))]);
     $this->Flash->success(__('The Blog Deleted Successfully'));
     return $this->redirect(['action' => 'index']);
     
   }
   if($intBulkAction==2)
   {
       $this->Blog->updateAll(['blog.Blog_status'=>'1'],['blog.blog_id IN' =>explode(',',$this->request->getData('blog_id'))]);
       $this->Flash->success(__('Selected Entry Active Successfully'));
       return $this->redirect(['action' => 'index']);
   }
   if($intBulkAction==3)
   {
       $this->Blog->updateAll(['blog.Blog_status'=>'0'],['blog.blog_id IN' =>explode(',',$this->request->getData('blog_id')) ]);
       $this->Flash->success(__('Selected Entry Inactive Successfully'));
       return $this->redirect(['action' => 'index']);
          
   }
            

   
}
     
}

public function addBlog($id=null)
{
    $this->viewBuilder()->setLayout('defaultAdmin');
    if($id>0)
{  
$blog = $this->Blog->get($id, [
            'contain' => []
        ]);
}else{
       $blog = $this->Blog->newEntity();
}
       if ($this->request->is(['patch', 'post', 'put'])) 
        {
$postData = $this->request->getData();
	  if(!empty ($postData['blog_image']['name']))
             {
               $fileName=$postData['blog_image']['name'];
               $uploadPath=SITE_UPLOAD_PATH.SITE_BLOG_IMAGE_PATH;
               $uploadFile=$uploadPath.$fileName;
               if(move_uploaded_file($postData['blog_image']['tmp_name'],$uploadFile))
               {
                   $postData['blog_image']=$fileName;
               }
               
             }
		 $currentDate=date("Y-m-d H:i:s");
		 $postData['blog_date']=$currentDate;
         $postData['blog_status']='1';
if(isset($postData['blog_category']) && count($postData['blog_category'])>0)
{
 $postData['blog_category']=implode(',',$postData['blog_category']); 
}else{

$postData['blog_category']='';
}
if(isset($postData['blog_tag']) && count($postData['blog_tag'])>0)
{
 $postData['blog_tag']=implode(',',$postData['blog_tag']); 
}else{
$postData['blog_tag']='';

}
  $blog = $this->Blog->patchEntity($blog, $postData);
          if ($this->Blog->save($blog)) 
          {
               $this->Flash->success(__('The Blog has been saved.'));
               return $this->redirect(['action' => 'index']);
          }
           $this->Flash->error(__('The Blog could not be saved. Please, try again.'));
     
		 }
      	 $title ='Add Post | '.SITE_TITLE;
       	 $rowCatInfo=$this->Postcategory->find('all');
          $resTagInfo =$this->Tag;   
         if($id>0)
{ 
$strExplodeData =explode(',', $blog->blog_category);
$rowSubCategoryInfo =$this->Postcategory->find('all')->where(['category_parent'=>(int)$strExplodeData[0]]);
}else{
$rowSubCategoryInfo =array();

}
         $this->set(compact('Blog','rowCatInfo','title','blog','resTagInfo','rowSubCategoryInfo'));

	}

public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $blog = $this->Blog->get($id);
        if ($this->Blog->delete($blog)) {
            $this->Flash->success(__('The Blog has been deleted.'));
        } else {
            $this->Flash->error(__('The Blog could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }    
    


	
}