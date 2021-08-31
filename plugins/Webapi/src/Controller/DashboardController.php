<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\View\Helper\SmsHelper;

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
$this->loadModel('SkCategory');
$this->loadModel('SkSlider');
$this->loadModel('Coupon');
$this->loadModel('SkBrand');
$this->loadModel('SkTag');
$this->loadModel('SkUnit');
$this->loadModel('Cities');
$this->loadModel('SkProductReview');
$this->loadModel('SkCustomerView');
$this->loadModel('SkUser');

$this->loadModel('SkProductbusinessprice');
$this->loadModel('SkUserWallet');
$this->loadModel('SkProduct');
$this->loadModel('ThemeSetting');
$this->loadModel('Transactions');
$this->loadModel('SkCart');

 if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {

  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}


}
function updatecarthistory()
	{
	    
	   $aryResponse = array();
if($this->request->is('post')) 
{
    $aryPostData = $this->request->getData();
 $this->SkCart->deleteAll(['cart_user_id'=>$aryPostData['user_id'],'cart_product_id'=>$aryPostData['product_id']]);
 $aryInsertData =array();
 $aryInsertData['cart_user_id'] = $aryPostData['user_id'];
  $aryInsertData['cart_product_id'] = $aryPostData['product_id'];
  
 $u =$this->SkCart->newEntity();
 $u =$this->SkCart->patchEntity($u,$aryInsertData);
 $this->SkCart->save($u);
       $aryResponse['message']='ok';
 
}else{
    $aryResponse['message']='failed';
    
}
    
     echo json_encode($aryResponse);
exit;      
	}
function getsupport()
{
   $aryResponse = array();
if($this->request->is('post')) 
{
    $intStateId = $this->request->getData();
   $resCityList =  $this->ThemeSetting->find('all')->where(['theme_id'=>1])->first();
        $aryResponse['message']='ok';
        $aryResponse['result']=$resCityList;

}else{
    $aryResponse['message']='failed';
    
}
    
     echo json_encode($aryResponse);
exit;    
    
}
function updateuserprofile()
{
          $aryResponse = array();
if($this->request->is('post')) 
{
    $intStateId = $this->request->getData();
  //// $resCityList =  $this->Cities->find('all')->where(['state_id'=>$intStateId])->order(['cities_name'=>'ASC']);
        $aryResponse['message']='ok';
        $aryResponse['result']=$resCityList;

}else{
    $aryResponse['message']='failed';
    
}
    
     echo json_encode($aryResponse);
exit; 
    
}
function citylist()
{
       $aryResponse = array();
if($this->request->is('post')) 
{
    $intStateId =$this->request->getData('state_id');
   $resCityList =  $this->Cities->find('all')->where(['state_id'=>$intStateId])->order(['cities_name'=>'ASC']);
        $aryResponse['message']='ok';
        $aryResponse['result']=$resCityList;

}else{
    $aryResponse['message']='failed';
    
}
    
     echo json_encode($aryResponse);
exit;
}
function getappversion()
{
    $aryResponse =array();
    $aryResponse['message'] ='ok';
        $aryResponse['version'] ='1.0';
        echo json_encode($aryResponse);
exit;

}
function gettagproduct()
{
   $aryResponse = array();
if($this->request->is('post')) 
{
    $strSelect =' 1 AND product_status=1 AND FIND_IN_SET('.$this->request->getData('product_tag').',product_tag) ';

$this->SkProduct->hasMany('SkProductbusinessprice', [
'foreignKey' => 'pu_product_id',
'sort'=>['SkProductbusinessprice.pu_net_price' => 'ASC']
]);

 $this->SkProductbusinessprice->belongsTo('SkUnit', [
'foreignKey' => 'pu_unit', //for foreignKey
'joinType' => 'INNER' //join type
]);

$resMerchantListData =$this->SkProduct->find('all',['contain'=>['SkProductbusinessprice'=>['SkUnit']]])->where($strSelect);

   $aryResponse['result']=$resMerchantListData;
     $aryResponse['message']='ok';  
          $aryResponse['url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;  


}else{
    
  $aryResponse['message']='failed';  
}
echo json_encode($aryResponse);
exit;
}
public function index()
{
$aryResponse = array();
 $connection = ConnectionManager::get('default');
$aryResponse['notification_count']=0;
$aryResponse['message'] ='ok';
$aryResponse['slider_url']=SITE_UPLOAD_URL.SITE_SLIDER_IMAGE_PATH;
$aryResponse['product_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;

$aryResponse['category_url']=SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH;
   $this->loadModel('SkCategory');
         $this->loadModel('SkTag');
           $this->loadModel('SkBrand');
$this->SkSlider->belongsTo('SkCategory', [
'foreignKey' => 'slider_category', //for foreignKey
'joinType' => 'LEFT' //join type
]);
$this->SkSlider->belongsTo('SkTag', [
'foreignKey' => 'slider_tag', //for foreignKey
'joinType' => 'LEFT' //join type
]);
$this->SkSlider->belongsTo('SkBrand', [
'foreignKey' => 'slider_brand', //for foreignKey
'joinType' => 'LEFT' //join type
]);

$resSliderList=$this->SkSlider->find('all',['contain'=>['SkCategory','SkTag','SkBrand']])->where(['slider_type'=>2,'slider_status'=>1])->order(['slider_id'=>'DESC']);
$aryResponse['slider']=$resSliderList;
$resSliderList=$this->SkSlider->find('all',['contain'=>['SkCategory','SkTag','SkBrand']])->where(['slider_type'=>3,'slider_status'=>1])->first();
$aryResponse['slider_bottom']=$resSliderList;

$resSliderList=$this->SkSlider->find('all',['contain'=>['SkCategory','SkTag','SkBrand']])->where(['slider_type'=>4,'slider_status'=>1])->order(['slider_id'=>'DESC']);
$aryResponse['slider1']=$resSliderList;
$resSliderList=$this->SkSlider->find('all',['contain'=>['SkCategory','SkTag','SkBrand']])->where(['slider_type'=>5,'slider_status'=>1])->order(['slider_id'=>'DESC']);
$aryResponse['slider2']=$resSliderList;
$resSliderList=$this->SkSlider->find('all',['contain'=>['SkCategory','SkTag','SkBrand']])->where(['slider_type'=>6,'slider_status'=>1])->order(['slider_id'=>'DESC']);
$aryResponse['slider3']=$resSliderList;
$resSliderList=$this->SkSlider->find('all',['contain'=>['SkCategory','SkTag','SkBrand']])->where(['slider_type'=>7,'slider_status'=>1])->order(['slider_id'=>'DESC']);
$aryResponse['slider4']=$resSliderList;

$resSliderList=$this->SkCustomerView->find('all')->where(['customer_status'=>1])->order(['customer_id'=>'DESC']);

$aryResponse['reviews']=$resSliderList;


 
$resSelectParentCategory  =$this->SkCategory->find('all',['order'=>['category_name'=>'DESC']])->where(['category_status'=>1,'category_parent'=>0]);
  $aryResponse['category']=$resSelectParentCategory;

 $aryResponse['tag2'] =array();

$resTagIngo =$this->SkTag->find('all')->where(['tag_status'=>1,'tag_show_menu'=>1]);
$counter =0;
foreach($resTagIngo as $rowTagIngo)
{
  $counter++;  
$strSelect =' 1 AND product_status=1 AND FIND_IN_SET('.$rowTagIngo->tag_id.',product_tag) LIMIT 5 ';

$this->SkProduct->hasMany('SkProductbusinessprice', [
'foreignKey' => 'pu_product_id',
'sort'=>['SkProductbusinessprice.pu_net_price' => 'ASC']
]);

 $this->SkProductbusinessprice->belongsTo('SkUnit', [
'foreignKey' => 'pu_unit', //for foreignKey
'joinType' => 'INNER' //join type
]);

$resMerchantListData =$this->SkProduct->find('all',['contain'=>['SkProductbusinessprice'=>['SkUnit']]])->where($strSelect);
if($resMerchantListData->count()>0 && $counter<=2)
{
$rowTagIngo['child'] =$resMerchantListData;
  $aryResponse['tag'][]=$rowTagIngo;
}else if($resMerchantListData->count()>0 && $counter>2)
{
$rowTagIngo['child'] =$resMerchantListData;
$aryResponse['tag2'][]=$rowTagIngo;
}
}
 


$this->SkBrand->hasMany('SkProduct')->setForeignKey([
        'product_brand',
    ])
    ->setBindingKey([
        'brand_id',
    ]);
$resSelectParentCategory  =$this->SkBrand->find('all',['order'=>['brand_name'=>'ASC'],'contain'=>['SkProduct']])->where(['brand_status'=>1]);
foreach($resSelectParentCategory as $rowSelectParentCategory)
{
    if(count($rowSelectParentCategory->sk_product)>0)
    {
$aryResponse['brand'][]=$rowSelectParentCategory;
    }else{
   $aryResponse['brand'][]=$rowSelectParentCategory;
     
    }
}
$aryResponse['brand_url']=SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH;

echo json_encode($aryResponse);
exit;
}

public function getparentcategory()
{
    $aryResponse = array();
$resSelectParentCategory  =$this->SkCategory->find('all',['order'=>['category_name'=>'DESC']])->where(['category_status'=>1,'category_parent'=>0]);
$aryResponse['category']=$resSelectParentCategory;

echo json_encode($aryResponse);
exit;
    
}
function wallethistory()
{
    $aryResponse =array();
    if($this->request->is('post'))
    {
$strField =' 1 AND uw_user_id='.$this->request->getData('user_id');
$resCouponInfo =$this->SkUserWallet->find('all')->where($strField);
 
   $aryResponse['message'] ='ok';
    $aryResponse['results'] = $resCouponInfo;
}else{
    $aryResponse['message'] ='failed';
    
}
 $aryResponse['user_balance'] =self::updatepcbalance($this->request->getData('user_id')); 
  echo json_encode($aryResponse);
exit;  
}

function updatepcbalance($intStaffId)
{
$query = $this->SkUserWallet->find('all');
   $rowTodayPayments =$query->select(['total' => $query->func()->sum('uw_amount')])->where(['uw_user_id'=>$intStaffId])->first();
  $intTodayPayments =$rowTodayPayments->total;
 if($intTodayPayments<=0)
 {
     $intTodayPayments =0;
 }
    return $intTodayPayments;
}


function offerce()
{
    $aryResponse =array();
$strField =' 1 AND coupon_status=1  AND \''.date('Y-m-d').'\' BETWEEN coupon_active_from AND coupon_active_to  ';
$resCouponInfo =$this->Coupon->find('all')->where($strField);
if(count($resCouponInfo)>0)
{
   $aryResponse['message'] ='ok';
    $aryResponse['result'] = $resCouponInfo;
}else{
    $aryResponse['message'] ='failed';
    
}
  echo json_encode($aryResponse);
exit;  
}

function getorderlist($intUserId=0){
    $this
            ->Transactions
            ->belongsTo('SkProduct', ['foreignKey' => 'trans_item_id', //for foreignKey
        'joinType' => 'INNER'
        //join type
        ]);
   $str = ' 1 AND trans_main_id=0 AND trans_user_id='.$intUserId.'  AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\')';

    $resTransactionList = $this->Transactions->find('all', ['contain' => 'SkProduct'])->where($str)->order(['trans_id' => 'DESC']);;
    $this->viewBuilder()->setLayout('ajax');
   
    $rowUserInfo = $this->SkUser->find('all')->where(['user_id'=>$intUserId])->first();
   
    $this->set(compact('resTransInfo','resTransactionList','rowUserInfo'));
}
function sendOtp(){
        $aryResponse = array();
        $strRandomOtp =rand(1000,9999);
        $user_id = $_POST['user_id'];
        $this->SkUser->updateAll(['user_otp' => $strRandomOtp],['user_id' => $user_id]);
        $for_what  = 'to login';
        if(isset($_POST['for_what'])){
            $for_what = $_POST['for_what'];
        }
        
        $rowUserInfo =$this->SkUser->find('all')->where(['user_id'=>$user_id])->first();
        $strMsg=$strRandomOtp." is the OTP that you have requested ".$for_what.". Do not share your OTP with anyone.";
        
        $sms = SmsHelper::sendSms($rowUserInfo->user_mobile, $strMsg);
        $sms = true;
        if($sms){
            $aryResponse['message'] = "OTP send";
            $aryResponse['status'] = "1";
        }else{
            $aryResponse['message'] = "Someting went wrong";
            $aryResponse['status'] = "0";
        }
        echo json_encode($aryResponse);
        exit; 
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