<?php namespace Seller\Controller;
use Seller\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class UserController  extends AppController
{
    public function initialize(){ 
    
    parent::initialize();
    $this->loadModel('SkUser');
    $this->loadModel('SkProduct');
    $this->loadModel('SkCart');
    $this->loadModel('SkWishlist');
    $this->loadModel('Transactions');
    $this->loadModel('SkUniqueIds');
    $rowAdminInfo =$this->getRequest()->getSession()->read('SELLER');
    if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['seller_id'])){
        return $this->redirect(SITE_URL.'seller');
    }
        $this->loadModel('SkUser');
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $rowAdminInfo =$this->getRequest()->getSession()->read('SELLER');
       
        $resCouponInfo = $this->paginate($this->SkUser->find('all')->where(['user_refer_seller_id'=>$rowAdminInfo->seller_id,'user_status'=>1]));
        $strPageTitle ='Manage User';
        $this->set(compact('resCouponInfo','strPageTitle'));
    }
    
    public function userView($userId=null,$strType='all'){
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	$this->SkCart->belongsTo('SkUser', [
            'foreignKey' => 'cart_user_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        $this->SkCart->belongsTo('SkProduct', [
            'foreignKey' => 'cart_product_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        $this->SkWishlist->belongsTo('SkUser', [
            'foreignKey' => 'wish_user_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        $this->SkWishlist->belongsTo('SkProduct', [
            'foreignKey' => 'wish_product_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        if(isset($_POST['trans_tracking_code']))
        {
            $intEditId = $_POST['trans_id_data'];
            $postData=$this->request->getData();
            $postData['trans_status']=3;
            $resTrans= $this->Transactions->get($intEditId, ['contain' => []]);
            $resTrans= $this->Transactions->patchEntity($resTrans, $postData);
            $resTrans =   $this->Transactions->save($resTrans);
            $rowUserInfo =$this->SkUser->find('all')->where(['user_id'=>$resTrans->trans_user_id])->first();
            if($rowUserInfo->user_mobile!='')
            {
                $strMsg=' Dispatched:  Your Package with tracking id '.$_POST['trans_tracking_code'].' will be delivered in a secure package.Tack at '.$_POST['trans_tacking_url'].' from eapublications.org';
                SmsHelper::sendSms($rowUserInfo->user_mobile, $strMsg);
            }
            $this->Flash->success(__('The Tracking Detail has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->paginate = ['order' => ['trans_id' => 'DESC']];
        $rowUserInfo=$this->SkUser->find('all')->where(['user_id'=>$userId])->first();
        if($strType=='confirm')
        {
            $resTransList = $this->paginate($this->Transactions->find('all')->where(['1 AND trans_main_id=0 AND trans_status=1 AND trans_user_id = \''.$rowUserInfo['user_id'].'\'']));
        }
        if($strType=='pending')
        {
            $resTransList = $this->paginate($this->Transactions->find('all')->where(' 1 AND trans_main_id=0 AND trans_status!=2 AND trans_status=0 AND trans_user_id = \''.$rowUserInfo['user_id'].'\' AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\')'));
        }
        if($strType=='dispatched')
        {
	        $resTransList = $this->paginate($this->Transactions->find('all')->where(' 1 AND trans_main_id=0 AND trans_status=3 AND trans_user_id = \''.$rowUserInfo['user_id'].'\''));
        }
        if($strType=='all')
        {
    	    $resTransList = $this->paginate($this->Transactions->find('all')->where(['1 AND trans_main_id=0 AND trans_status!=2 AND trans_user_id = \''.$rowUserInfo['user_id'].'\' AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\')']));
        }
        $wishlistInfo = $this->paginate($this->SkWishlist->find('all',['contain'=>['SkUser','SkProduct']])->where(['wish_user_id'=>$userId]));
        $cartlistInfo = $this->paginate($this->SkCart->find('all',['contain'=>['SkUser','SkProduct']])->where(['cart_user_id'=>$userId]));
    	$rowUserInfo = $this->SkUser->find('all')->where(['user_id'=>$userId])->first();
    	$resUserInfo =$this->SkUser;
        $resProductInfo =$this->SkProduct;
        $resCountOrder = $this->Transactions;
        $strPageTitle ='Manage User';
    	$this->set(compact('strPageTitle','rowUserInfo','cartlistInfo','wishlistInfo','resTransList','resUserInfo','resCountOrder','strType','resProductInfo'));
    }
}