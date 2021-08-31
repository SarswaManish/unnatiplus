<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;

class SellerController  extends AppController
{
public function initialize()
{
    parent::initialize();
    $this->loadComponent('Csrf');
    
}
public function index($id=null)
       {
		   $strLoadSearch='';
		   $strSearchVal='';
		   if(isset($_POST['searchval']))
		   {
			   $strLoadSearch=' 1 AND seller_name LIKE \'%'.$_POST['searchval'].'%\'';
			   $strSearchVal=$_POST['searchval'];
		   }
           if($id=='publish')
		   {
			    $rowSellerInfo =$this->Seller->find('all')->where(['seller_status'=>1]);
		   }
		   else if($id=='active')
		   {
			    $rowSellerInfo =$this->Seller->find('all')->where(['seller_status'=>1]);
		   }
		   else if($id=='inactive')
		   {
			    $rowSellerInfo =$this->Seller->find('all')->where(['seller_status'=>0]);
		   }
		   else
		   {
		   $rowSellerInfo =$this->Seller->find('all')->where($strLoadSearch);
		   }
		   $countSeller=$this->Seller->find();
		   $inactiveSellerCount=$this->Seller->find('all')->where(['seller_status'=>0])->count();
             $resSellerInfo = $this->paginate($rowSellerInfo); 
    	   $this->viewBuilder()->setLayout('defaultAdmin');
           
    	   $title ='Manage Sellers | Leaf Disposal';
           $this->set(compact('title','resSellerInfo','strSearchVal','inactiveSellerCount','countSeller'));
       }

public function addseller($EditId=null)
       {
if($EditId>0)
{
$seller = $this->Seller->get($EditId, ['contain' => []]);
}
else
{
	$seller = $this->Seller->newEntity();
}
if($this->request->is(['patch', 'post', 'put']))
{       $currentDate= date('Y-m-d h:i:s');
	$postData =$this->request->getData();
	$postData['seller_status']=1;
    $postData['seller_registered_date']=$currentDate;
	$seller = $this->Seller->patchEntity($seller,$postData);
	if($this->Seller->save($seller))
	{
		 $this->Flash->success(__('The seller has been saved.'));
         return $this->redirect(['action' => 'index']);
	}
	else{
		
		$this->Flash->error(__('The product could not be saved. Please, try again.'));
		return $this->redirect(['action' => 'index']);
	}
	
}
    	     $this->viewBuilder()->setLayout('defaultAdmin');
    	     $title ='Add Seller | Leaf Disposal';
             $this->set(compact('title','seller'));
        }
        
        public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seller = $this->Seller->get($id);
        if ($this->Seller->delete($seller)) {
            $this->Flash->success(__('The Seller has been deleted.'));
        } else {
            $this->Flash->error(__('The Seller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    } 
    
    public function status($id=null)
{
   $this->request->allowMethod(['post', 'status']);
   $seller = $this->Seller->get($id);
$postdata =$this->request->getData();
   if($seller->get('seller_status')==1)
     {
       $postdata['seller_status'] = 0;
     }
   else
     {
       $postdata['seller_status'] = 1;
    
     }
   $seller =$this->Seller->patchEntity($seller,$postdata);
   if($this->Seller->save($seller))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
}