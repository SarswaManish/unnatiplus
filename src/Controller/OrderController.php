<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\Datasource\ConnectionManager;

class OrderController  extends AppController
{
    public function initialize()
	{
        parent::initialize();
        $this->loadModel('SkUser');
        $this->loadModel('Transactions');
        $rowUserInfo = $this->getRequest()->getSession()->read('USER');
        if(!isset($rowUserInfo->user_id))
        {
            return $this->redirect(SITE_URL);  
        }
	}
	
    function index()
    {
        $resUserInfo =  $this->request->getSession()->read('USER');
        $strPageTitle ='My Order';
          $str = ' 1 AND trans_main_id=0 AND trans_user_id='.$resUserInfo->user_id.'  AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\')';
        $resTransactionList = $this->Transactions->find('all')->where($str)->order(['trans_id'=>'DESC']);
        $this->set(compact('strPageTitle','resTransactionList'));      
    }
    
    function cancelorder(){
        $this->request->allowMethod(['post']);
        $rowUserInfo  = $this->SkUser->find('all')->where(['user_id'=>$_POST['user_id']])->first();  
        $aryResponse =array();
        if($rowUserInfo->user_otp==$_POST['user_otp']) 
        {
            $aryResponse['message']='ok';
            $coupon= $this->Transactions->get($_POST['trans_id']);
            $aryPostData['trans_status'] = 2;
            $coupon=$this->Transactions->patchEntity($coupon,$aryPostData);
            $this->Transactions->save($coupon);
            $strCancelMessage = '';  
            $strMsg=" Your order has canceled. Order Id is ".$coupon->trans_id." ";
            SmsHelper::sendSms($rowUserInfo->user_mobile, $strMsg);
            $aryResponse['notification'] = 'Order Canceled';
        }else{
            $aryResponse['message']='failed';  
            $aryResponse['notification'] = 'Otp Does Not Match';
        }
        echo json_encode($aryResponse);
        exit;  
    }
    
    function initiatereturn(){
        $this->request->allowMethod(['post']);
        $rowUserInfo  = $this->SkUser->find('all')->where(['user_id'=>$_POST['user_id']])->first();  
        $aryResponse =array();
        if($rowUserInfo->user_otp==$_POST['user_otp']) 
        {
            $aryResponse['message']='ok';
            $coupon= $this->Transactions->get($_POST['trans_id']);
            $aryPostData['trans_status'] = 5;// here 5 is  = return policy initialize not returned yet
            $coupon=$this->Transactions->patchEntity($coupon,$aryPostData);
            $this->Transactions->save($coupon);
            $strCancelMessage = '';  
            $strMsg=" Your order is requested for return. Order Id is ".$coupon->trans_id." ";
            SmsHelper::sendSms($rowUserInfo->user_mobile, $strMsg);
            $aryResponse['notification'] = 'Order Return applied';
        }else{
            $aryResponse['message']='failed';  
            $aryResponse['notification'] = 'Otp Does Not Match';
        }
        echo json_encode($aryResponse);
        exit;  
    }
    
}