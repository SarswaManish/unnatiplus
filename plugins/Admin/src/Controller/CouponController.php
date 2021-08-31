<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class CouponController  extends AppController
{
    public $paginate = ['limit' => 100  ];
    public function initialize()
    { 
        parent::initialize();
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }
            $this->loadModel('SkProduct');
            $this->loadModel('Coupon');
            $this->loadModel('SkCategory');
            $this->loadModel('SkUser');
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
            pr($aryPostData);
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction>0)
            {
                if($intBulkAction==1)
                {
                    $this->Coupon->deleteAll( ['coupon_id IN' =>$aryPostData['coupon_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->Coupon->updateAll(['coupon_status'=>'1'],['coupon_id IN' =>$aryPostData['coupon_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->Coupon->updateAll(['coupon_status'=>'0'],['coupon_id  IN' =>$aryPostData['coupon_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }

    public function addcoupon($intEditId=null){
    
        $this->viewBuilder()->setLayout('sideBarLayout');
        if ($this->request->is(['patch', 'post', 'put']))  {
            $postData=$this->request->getData();
            if($intEditId>0){
                $coupon= $this->Coupon->get($intEditId, ['contain' => []]);
            }else{
                $coupon= $this->Coupon->newEntity();
            }
            if(!empty ($postData['coupon_image']['name'])){
                $fileName=$postData['coupon_image']['name'];
                $uploadPath=SITE_UPLOAD_PATH.SITE_COUPON_IMAGE_PATH;
                $uploadFile=$uploadPath.$fileName;
                if(move_uploaded_file($this->request->data['coupon_image']['tmp_name'],$uploadFile)){
                    $postData['coupon_image']=$fileName;
                }
            }else{
                $postData['coupon_image']=$coupon->coupon_image; 
            }
            
            $postData['minimum_order_quantity']     = $postData['minimum_order_quantity'];
            $postData['coupon_category']            = $postData['coupon_category'];
            $postData['coupon_user']                = $postData['coupon_user'];
            $postData['coupons_condition']          = $postData['condition_type'];//1 for user and 2 for category
            $postData['Is_applicable_on_first_order'] = isset($postData['Is_applicable_on_first_order'])?$postData['Is_applicable_on_first_order']:0;
            $postData['coupon_status']='1';
            
            $coupon= $this->Coupon->patchEntity($coupon, $postData);
            if ($this->Coupon->save($coupon)) {
                $this->Flash->success(__('The coupon has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The coupon could not be saved. Please, try again.'));
            }
    
        $categories = $this->SkCategory->find('all')->where(['category_status'=>1])->toArray();
        $users = $this->SkUser->find('all')->toArray();
        $resProduct=$this->SkProduct->find('all');
    //   $resUser=$this->User->find('all');
        $strPageTitle ='Add coupon';
        $coupon =(object)array();
        if($intEditId>0){
            $coupon= $this->Coupon->get($intEditId, ['contain' => []]);
        }
        $this->set(compact('coupon','strPageTitle','resProduct','categories','users'));
    }
	
        
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete','get']);
        $coupon= $this->Coupon->get($id);
        if($this->Coupon->delete($coupon)) {
           $this->Flash->success(__('The coupon has been deleted.'));
        }else{
           $this->Flash->error(__('The coupon could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }    
    
    public function edit($id = null){
        $this->viewBuilder()->setLayout('sideBarLayout');
        $coupon= $this->Coupon->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
             
            $postData['minimum_order_quantity']     = $postData['minimum_order_quantity'];
            $postData['coupon_category']            = $postData['coupon_category'];
            $postData['coupon_user']                = $postData['coupon_user'];
            $postData['coupons_condition']          = $postData['condition_type'];//1 for user and 2 for category
            $postData['Is_applicable_on_first_order'] = isset($postData['Is_applicable_on_first_order'])?$postData['Is_applicable_on_first_order']:0;
             
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