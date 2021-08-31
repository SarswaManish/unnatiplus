<?php namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;

class PostcategoryController  extends AppController
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
    
}

public function index($intCatId =null)
    {
        if($intCatId!=null)
        {
            $rowCategoryInfo = $this->Postcategory->get($intCatId, [
            'contain' => []
        ]);
        }else{
          $rowCategoryInfo =array();  
            
        }
        $options = array(
    'conditions' => array('Postcategory.category_parent'=>0)
       );
    $resCategoryList = $this->Postcategory->find('all', $options);
        
           	$this->viewBuilder()->setLayout('defaultAdmin');
             $resCatInfo = $this->Postcategory->find('all')->where(['category_parent' => 0]);
  		 $connection = ConnectionManager::get('default');
           	$resCatInfo = $this->paginate($resCatInfo);
           	$title ='Postcategory | Leaf Disposal';
    	         $this->set(compact('resCatInfo','rowCategoryInfo','resCategoryList','connection','title'));
    }
    
    
    
    
    
public function addCategory()
{

       
    	$this->viewBuilder()->setLayout('defaultAdmin');
		
       if ($this->request->is(['patch', 'post', 'put'])) 
        {
    	  $postData = $this->request->getData();
         
    	$intEditId =$postData['category_id'];
    	if($intEditId>0)
    	{
       $intotalCategory = $this->Postcategory->find('all')->where(['category_name'=>$postData['category_name'],'category_id !='=>$intEditId])->count();

    	  if($intotalCategory>0)
{

 $this->Flash->error(__('The Category name already exist. Please, try again.'));
    	             return $this->redirect(SITE_URL.'admin/postcategory/index/'.$intEditId);

}else{
     $category = $this->Postcategory->get($intEditId, [
            'contain' => []
        ]);
  }  
    	}else{
       $intotalCategory = $this->Postcategory->find('all')->where(['category_name'=>$postData['category_name']])->count();
       if($intotalCategory>0)
{

 $this->Flash->error(__('The Category name already exist. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

}else{

    	 	$category=$this->Postcategory->newEntity();   

}

    	    
    	}
		  $postData['category_status']=1;
    	    $category=$this->Postcategory->patchEntity($category,$postData);
    	    if($this->Postcategory->save($category))
    	    {
    	        $this->Flash->success(__('The Category has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Category could not be saved. Please, try again.'));
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
       
       
    $this->Postcategory->deleteAll( ['Postcategory.category_id IN' =>$this->request->getData('category_id'),]);
     $this->Flash->success(__('The Category Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
   if($intBulkAction==2)
   {
       
        
         
         $this->Postcategory->updateAll(['category_status'=>'1'],['category.category_id IN' =>$this->request->getData('category_id'),]);
       $this->Flash->success(__('Selected Entry Active Successfully'));
          return $this->redirect(['action' => 'index']);
   }
   if($intBulkAction==3)
   {
         $this->Postcategory->updateAll(['category_status'=>'0'],[
        'category.category_id IN' =>$this->request->getData('category_id'), ]);
          $this->Flash->success(__('Selected Entry Inactive Successfully'));
          return $this->redirect(['action' => 'index']);
          
   }
          return $this->redirect(['action' => 'index']);

   
        }
     
}

public function status($id=null)
{
$this->request->allowMethod(['post', 'status']);
$category= $this->Postcategory->get($id);
$postData = $this->request->getData();
if($category->get('category_status')==1)
{ 
$postData['category_status']=0;
}else{
$postData['category_status']=1;

}
$category=$this->Postcategory->patchEntity($category,$postData);
if($this->Postcategory->save($category))
    {
        $this->Flash->success(__('Status Update Successfully.'));
        return $this->redirect(['action'=>'index']);
    }
}

   
public function delete($id = null)
{
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Postcategory->get($id);
        if ($this->Postcategory->delete($category))
        {
             $this->Flash->success(__('The category has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The category could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
}
public function getCategoryChildList()
{
  /**/
  if ($this->request->is(['post'])) 
    {
          $intParentId =$this->request->getdata('category_id');  
          $resChildCategory =   $this->Postcategory->find()->select(['category_id', 'category_name'])->where(['category_parent =' => $intParentId]);
          $strHtml =''; 
    foreach($resChildCategory as $rowChildCategory)
     {
      $strHtml .='<option value="'.$rowChildCategory->category_id.'">'.$rowChildCategory->category_name.'</option>';
     }
     
     $aryReponse =array();
     $aryResponse['message']='ok';
     $aryResponse['result'] = $resChildCategory;
     $aryResponse['html'] =$strHtml;  
     echo json_encode($aryResponse);  
     exit();
    }
    
    
    
}
        
}