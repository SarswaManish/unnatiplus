<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class CouponController  extends AppController
{
public function initialize()
{ 

    parent::initialize();
     $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }
       $this->loadModel('SkProduct');
}

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
 $this->paginate = ['order' => ['coupon_id' => 'DESC']];
    	 $resCouponInfo = $this->paginate($this->Coupon);
           	$strPageTitle ='Manage Coupon';
    	         $this->set(compact('resCouponInfo','strPageTitle'));
    }
	
	public function status($id=null)
{
   $this->request->allowMethod(['post', 'status']);
  $coupon= $this->Coupon->get($id);
  $aryPostData =$_POST;
  if($coupon->get('coupon_status')==1)
  {
     $aryPostData['coupon_status'] = 0;
}else{
      $aryPostData['coupon_status'] = 1;
    
}
  $coupon=$this->Coupon->patchEntity($coupon,$aryPostData);
  if($this->Coupon->save($coupon))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
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
       
      
    $this->Coupon->deleteAll( [
        'coupon.coupon_id IN' =>explode(',',$aryPostData['coupon_id'])]);
     $this->Flash->success(__('The Coupon Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
   if($intBulkAction==2)
   {
       $this->Coupon->updateAll(['coupon.coupon_status'=>'1'],[
        'coupon.coupon_id IN' =>explode(',',$aryPostData['coupon_id'])]);
       $this->Flash->success(__('Selected Entry Active Successfully'));
          return $this->redirect(['action' => 'index']);
   }
   if($intBulkAction==3)
   {
         $this->Coupon->updateAll(['coupon.coupon_status'=>'0'],[
        'coupon.coupon_id  IN' =>explode(',',$aryPostData['coupon_id']) ]);
       $this->Flash->success(__('Selected Entry Inactive Successfully'));
          return $this->redirect(['action' => 'index']);
          
   }
            

   
        }
     
}

public function addcoupon($intEditId=null)
	{
		
		$this->viewBuilder()->setLayout('sideBarLayout');
		 if ($this->request->is(['patch', 'post', 'put']))  {

		  $postData=$this->request->getData();

                 if($intEditId>0)
                     {
                    $coupon= $this->Coupon->get($intEditId, ['contain' => []]);
                      }else{
		  $coupon= $this->Coupon->newEntity();
                     }
		  $couponUser='';
		  if(isset($postData['coupon_discount_user']) && count($postData['coupon_discount_user'])>0)
		  {
			  $couponUser=implode(',',$postData['coupon_discount_user']);
		  }
		  
		   $couponProduct='';
		  if(isset($postData['coupon_discount_product']) && count($postData['coupon_discount_product'])>0)
		  {
			  $couponProduct=implode(',',$postData['coupon_discount_product']);
		  }
		  $couponFeature="";
		  if(isset($postData['coupon_features']) && count($postData['coupon_features'])>0)
		  {
		      foreach($postData['coupon_features'] as $key=>$label)
		      {
		          if($label!='')
		          {
			  $couponFeature=$label.',';
		          }
		      }
		  }
       $couponFeature = rtrim($couponFeature,',');
       $postData['coupon_features']=$couponFeature;
           if(!empty ($postData['coupon_image']['name']))
             {
               $fileName=$postData['coupon_image']['name'];
               $uploadPath=SITE_UPLOAD_PATH.SITE_COUPON_IMAGE_PATH;
               $uploadFile=$uploadPath.$fileName;
               if(move_uploaded_file($this->request->data['coupon_image']['tmp_name'],$uploadFile))
               {
                   $postData['coupon_image']=$fileName;
               }
			  
               
             }
			  else
			   {

                $postData['coupon_image']=$coupon->coupon_image; 
             }
          $postData['coupon_discount_product']=$couponProduct;
		  $postData['coupon_discount_user']=$couponUser;
		  $postData['coupon_features']=$couponFeature;
          $postData['coupon_status']='1';
           $coupon= $this->Coupon->patchEntity($coupon, $postData);
           if ($this->Coupon->save($coupon)) {
               $this->Flash->success(__('The coupon has been saved.'));

               return $this->redirect(['action' => 'index']);
           }
           $this->Flash->error(__('The coupon could not be saved. Please, try again.'));
     
		 }
               

         $resProduct=$this->SkProduct->find('all');
      //   $resUser=$this->User->find('all');
       	$strPageTitle ='Add coupon';
       	$coupon =(object)array();
       if($intEditId>0)
                     {
                    $coupon= $this->Coupon->get($intEditId, ['contain' => []]);
                      }
       $this->set(compact('coupon','strPageTitle','resProduct','resUser'));

	}
	
        
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coupon= $this->Coupon->get($id);
        if ($this->Coupon->delete($coupon)) {
            $this->Flash->success(__('The coupon has been deleted.'));
        } else {
            $this->Flash->error(__('The coupon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }    
    
     public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        
        $coupon= $this->Coupon->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
$postData= $this->request->getData();
 $proAcc="";
          if(isset($postData['coupon_features']) && ''!=$postData['coupon_features'])
          { 
             foreach ($postData['coupon_features'] as $key=>$label)
             {
                if($label!='' )
                {
                   $proAcc.=$label.'#';
                }
             }
             
             $proAcc= rtrim($proAcc,'#');
          }
          $postData['coupon_features']=$proAcc;
                if(!empty ($postData['coupon_image']['name']))
             { 
               $fileName=$postData['coupon_image']['name'];
               $uploadPath=SITE_UPLOAD_PATH.SITE_COUPON_IMAGE_PATH;
               $uploadFile=$uploadPath.$fileName;
               if(move_uploaded_file($postData['coupon_image']['tmp_name'],$uploadFile))
               {
                   $postData['coupon_image']=$fileName;
               }
               
             }else{

                $postData['coupon_image']=$coupon->coupon_image; 
             }
            $coupon= $this->Coupon->patchEntity($coupon, $postData);
            if ($this->Coupon->save($coupon)) {
                $this->Flash->success(__('The coupon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The coupon could not be saved. Please, try again.'));
        }
         	$title ='Add coupon | Memoctor';
        $this->set(compact('coupon','title'));
    }
	
}