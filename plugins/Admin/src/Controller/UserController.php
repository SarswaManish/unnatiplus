<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class UserController  extends AppController
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
        $this->loadModel('SkUser');
        $this->loadModel('SkProduct');
        $this->loadModel('SkCart');
        $this->loadModel('SkWishlist');
        $this->loadModel('Transactions');
        $this->loadModel('SkUniqueIds');
    }

    public function index()
    {
        if($this->request->is('post'))
        {
            $arySessionData =array();
            if($this->request->getData('filter_keyword')!='')
            {
                $arySessionData['KEYWORD'] = $this->request->getData('filter_keyword');  
            }
            $this->getRequest()->getSession()->write('FILTER',$arySessionData); 
        }
        $rowFilterData =  $this->getRequest()->getSession()->read('FILTER');
        $strLoadConditrion =  ' 1 AND user_status=1 ';
        if(isset($rowFilterData['KEYWORD']) && $rowFilterData['KEYWORD']!='')
        {
            $strLoadConditrion .= ' AND user_first_name LIKE \'%'.$rowFilterData['KEYWORD'].'%\' OR user_mobile LIKE \'%'.$rowFilterData['KEYWORD'].'%\' OR user_email_id LIKE \'%'.$rowFilterData['KEYWORD'].'%\' OR user_last_name LIKE \'%'.$rowFilterData['KEYWORD'].'%\'';
        } 
        $this->viewBuilder()->setLayout('sideBarLayout');
        $resCouponInfo = $this->paginate($this->SkUser->find('all')->where($strLoadConditrion));
        $strPageTitle ='Manage User';
        $this->set(compact('resCouponInfo','strPageTitle','rowFilterData'));
    }
	function reset()
    {
        $this->getRequest()->getSession()->delete('FILTER'); 
        return $this->redirect(SITE_URL.'admin/user/');
    }
	public function status($id=null)
    {
        $this->request->allowMethod(['get', 'status']);
        $coupon= $this->SkUser->get($id);
        $aryPostData =$_POST;
        if($coupon->get('user_status')==1)
        {
            $aryPostData['user_status'] = 0;
        }else{
            $aryPostData['user_status'] = 1;
        }
        $coupon=$this->SkUser->patchEntity($coupon,$aryPostData);
        if($this->SkUser->save($coupon))
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
                $this->SkUser->deleteAll( ['user_id IN' =>$aryPostData['user_id']]);
                $this->Flash->success(__('The User Deleted Successfully'));
                return $this->redirect(['action' => 'index']);
            }
            if($intBulkAction==2)
            {
                $this->SkUser->updateAll(['user_status'=>'1'],['user_id IN' =>$aryPostData['user_id']]);
                $this->Flash->success(__('Selected Entry Active Successfully'));
                return $this->redirect(['action' => 'index']);
            }
            if($intBulkAction==3)
            {
                $this->SkUser->updateAll(['user_status'=>'0'],['user_id  IN' =>$aryPostData['user_id'] ]);
                $this->Flash->success(__('Selected Entry Inactive Successfully'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $coupon= $this->SkUser->get($id);
        if ($this->SkUser->delete($coupon)) {
            $this->Flash->success(__('The User has been deleted.'));
        } else {
            $this->Flash->error(__('The User could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }    
    
    public function userView($userId=null,$strType='all')
    {
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
        $strPageTitle='Manage Order';
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
	
	public function export()
	{
        $posts = $this->SkUser->find('all')->toArray();
        //$this->setData();
        foreach($posts as $key=>$val)
        {
            $row['user_id'] = $val->user_id;   
        	$row['user_first_name'] = $val->user_first_name;
        	$row['user_last_name'] = $val->user_last_name;
        	$row['user_mobile'] = $val->user_mobile;
        	$row['user_email_id'] = $val->user_email_id;
        	$row['user_profile'] = $val->user_profile;
        	$row['user_otp'] = $val->user_otp;
        	$row['user_otp_status'] = $val->user_otp_status;
        	$row['user_hash'] = $val->user_hash;
        	$row['user_email_verify_status'] = $val->user_email_verify_status;
        	$row['user_status'] = $val->user_status;
        	$row['user_created_datetime'] = $val->user_created_datetime;
        	$row['user_password'] = $val->user_password;
        	$row['user_share_code'] = $val->user_share_code;
            $records[] = $row;
        } 
        $filename='UserList.xls'; 
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

	    $heading = false;
		if(!empty($records))
	    foreach($records as $row) 
	    {
		    if(!$heading) 
		    {
	            echo implode("\t", array_keys($row)) . "\n";
	            $heading = true;
		    }
		    echo implode("\t", array_values($row)) . "\n";
	    } 
        exit;
	}
}