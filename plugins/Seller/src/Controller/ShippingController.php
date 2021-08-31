<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class ShippingController extends AppController
 {
     public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
      }
      public function initialize()
	{
	      parent::initialize();
	      $this->loadModel('SkTaxes');
	       $this->loadModel('SkState');
	       $this->loadModel('SkShipping');
	       
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index()
     {
         
         $resShippingList = $this->paginate($this->SkShipping);
         $resState =$this->SkState;
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Manage Shipping';
         $this->set(compact('strPageTitle','resShippingList','resState'));
     }
     
     function addshipping($intEditId=null,$strCopyStatus=null)
     {
         $rowShippingInfo=array();
         if($intEditId>0)
         {
              $rowShippingInfo = $this->SkShipping->get($intEditId, [
            'contain' => []  ]);
         }
        
         
         $this->viewBuilder()->setLayout('sideBarLayout');
         $resStateList = $this->SkState->find('all')->order(['state_name'=>'ASC']);
         $strPageTitle='Add Shipping Rates';
         $this->set(compact('strPageTitle','rowShippingInfo','resStateList'));
     }
     
     
     function shippingProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['shipping_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkShipping->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkShipping->newEntity();   
    	  $aryPostData['shipping_status']=1;
    	  $aryPostData['shipping_country']='India';
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    	    $category=$this->SkShipping->patchEntity($category,$aryPostData);
    	    if($this->SkShipping->save($category))
    	    {
    	        $this->Flash->success(__('The Shipping Rates has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Shipping could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
     
   function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkTaxes->get($intTrashId);
   $aryPostData['tax_status'] = 2;
   $category =$this->SkTaxes->patchEntity($category,$aryPostData);
  if($this->SkTaxes->save($category))
    	    {
    	        $this->Flash->success(__('Tax Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkShipping->get($intTrashId);
        if ($this->SkShipping->delete($category))
        {
             $this->Flash->success(__('The Shipping Rates has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Shipping Rates could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }
         public function status($id=null)
{

   $this->request->allowMethod(['get','post']);
   $category = $this->SkShipping->get($id);
   $aryPostData =array();
   if($category->get('shipping_status')==1)
      {
         $aryPostData['shipping_status'] = 0;
      }
    else{
          $aryPostData['shipping_status'] = 1;
      }
  $category =$this->SkShipping->patchEntity($category,$aryPostData);
  if($this->SkShipping->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
 }
 