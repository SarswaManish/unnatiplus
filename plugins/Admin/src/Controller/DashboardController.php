<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;

class DashboardController extends AppController
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
	      $this->loadModel('ThemeSetting');
	      $this->loadModel('SkSeller');
	      $this->loadModel('SkProduct');
	      $this->loadModel('SkUser');
	      $this->loadModel('Transactions');
	      
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	    //pr($rowAdminInfo);exit;
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
	
     function index()
     {
        $rowThemeInfo =  $this->ThemeSetting->find('all')->first();
        $this->viewBuilder()->setLayout('sideBarLayout');
        $sellerCountInfo = $this->SkSeller->find('all',array('order'=>array('seller_id ASC')))->where(['seller_status'=>1])->count();
        $sellerInfo = $this->SkSeller->find('all',array('order'=>array('seller_id ASC')))->where(['seller_status'=>1,'DATE(created_date)'=>date('Y-m-d')])->toArray();
       
        $productInfo = $this->SkProduct->find('all',array('order'=>array('product_id ASC')))->where(['product_status'=>1]);
        $userInfo = $this->SkUser->find('all',array('order'=>array('user_id DESC')))->where(['DATE(user_created_datetime)'=>date('Y-m-d')]);
        $userCountInfo = $this->SkUser->find('all',array('order'=>array('user_id ASC')))->count();
        $ordercountInfo = $this->Transactions->find('all',array('order'=>array('trans_id ASC')))->count();
        
        $this->Transactions->belongsTo('SkUser', [
            'foreignKey' => 'trans_user_id', //for foreignKey
            'joinType' => 'LEFT' //join type
        ]);
        $orderInfo = $this->Transactions->find('all',['contain'=>['SkUser'],'order'=>array('trans_id DESC')])->where(['DATE(trans_datetime)'=>date('Y-m-d')]);
      
        $strPageTitle='Dashboard | Ecommerce';
        $this->set(compact('strPageTitle','rowThemeInfo','sellerInfo','productInfo','userInfo','orderInfo','ordercountInfo','userCountInfo','sellerCountInfo'));
     }
     function logout()
     {
         $this->getRequest()->getSession()->delete('ADMIN');
         return $this->redirect(SITE_URL.'admin');

     }
     
   
    
 }
 

 


