<?php namespace Webapi\Controller;

use Webapi\Controller\AppController;
use Cake\Utility\Security;
use  Cake\Event\Event;
use Admin\View\Helper\ManishdbHelper;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

class CartController  extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
$this->getEventManager()->off($this->Csrf);
}
public function initialize()
{
parent::initialize();
    Configure::write('debug', 2);

$this->loadComponent('Csrf');
$this->loadModel('Admin.SkProduct');
$this->loadModel('Admin.SkAddressBook');
$this->loadModel('Admin.Coupon');
$this->loadModel('Admin.Transactions');
 if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {

  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}
}


public function index()
{
$aryResponse=array();
if ($this->request->is(['patch', 'post', 'put'])) 
{
  
 $aryResponse['message']='ok';
 $aryResponse['user_balance'] =0;
}
else
{
$aryResponse['message']='Failed';
$aryResponse['notification']='Some error occur';
}
 $aryResponse['minorder'] = 100;

echo json_encode($aryResponse);
exit;
}

function updatetocartcouponbyname()
{
$intCouponName =$this->request->getData('coupon_code');
$intGrandTotal =$this->request->getData('cartamount');
$intUserId =$this->request->getData('user_id');
$intUserId=0;
$strField =' 1 AND coupon_status=1 AND coupon_code=\''.$intCouponName.'\' AND \''.date('Y-m-d').'\' BETWEEN coupon_active_from AND coupon_active_to  ';
$rowCouponInfo = $this->Coupon->find("all")->where($strField)->first();
$aryResponse = array();


if(isset($rowCouponInfo->coupon_id))
{

if($rowCouponInfo->minimum_cart_amount<=$intGrandTotal)
{

if($rowCouponInfo->coupon_discount_mode==1)
{
$strDiscountAmount = $rowCouponInfo->coupon_discount;

}else{
$strDiscountAmount = ($intGrandTotal*($rowCouponInfo->coupon_discount/100));
if($strDiscountAmount>$rowCouponInfo->coupon_max_discount)
{
$strDiscountAmount=$rowCouponInfo->coupon_max_discount;
}

}
$aryResponse =$_POST; 
$aryResponse['cart_coupon_id']=$rowCouponInfo->coupon_id;
$aryResponse['discount_amount']=$strDiscountAmount;
$aryResponse['coupon_id'] = $rowCouponInfo->coupon_id;
$aryResponse['notification'] ='Coupon applied successfully';
$aryResponse['coupon'] =$rowCouponInfo;


$aryResponse['message']='ok';
}else{
    

$aryResponse['message']='failed';
$aryResponse['notification']='Minimum cart value '.$rowCouponInfo->minimum_cart_amount.' required';    
}

}else{

$aryResponse['message']='failed';
$aryResponse['notification']='Invalid Promo code';

}


echo json_encode($aryResponse);
exit;
}





function applypromocode()
{
$aryResponse=array();
if ($this->request->is(['patch', 'post', 'put'])) 
{
$aryResponse['message']='ok';
$intUserId = $this->request->getData("user_id");
$intCouponId = $this->request->getData("coupon_code");
$intGrandTotal = $this->request->getData("cartamount");

 
$strField =' 1 AND coupon_status=1 AND coupon_code=\''.$intCouponId.'\' AND \''.date('Y-m-d').'\' BETWEEN coupon_active_from AND coupon_active_to  ';
$rowCouponInfo = $this->Coupon->find("all")->where($strField)->first();


if(isset($rowCouponInfo->coupon_apply_on) && $rowCouponInfo->coupon_apply_on==0)
{

if($rowCouponInfo->coupon_discount_mode==1)
{
$strDiscountAmount = $rowCouponInfo->coupon_discount;

}else{
$strDiscountAmount = ($intGrandTotal*($rowCouponInfo->coupon_discount/100));
if($strDiscountAmount>$rowCouponInfo->coupon_max_discount)
{
$strDiscountAmount=$rowCouponInfo->coupon_max_discount;
}

}
$postData =$_POST; 
$postData['cart_coupon_id']=$rowCouponInfo->coupon_id;
$postData['cart_coupon_amount']=$strDiscountAmount;


$aryResponse['discount_amount']=$strDiscountAmount;
$aryResponse['cashback_amount']=0;


$aryResponse['coupon_id'] = $rowCouponInfo->coupon_id;
$aryResponse['notification'] ='coupon applied successfully';
}else if(isset($rowCouponInfo->coupon_apply_on) && $rowCouponInfo->coupon_apply_on==1)
{
$intTransactionInfo = $this->Transactions->find('all')->where(['trans_user_id'=>$intUserId,'trans_status'=>1])->count();
 if($intTransactionInfo>0)
{


$aryResponse['message']='failed';
$aryResponse['notification']='Coupon Apply Only On First Order';
}else{


if($rowCouponInfo->coupon_discount_mode==1)
{
$strDiscountAmount = $rowCouponInfo->coupon_discount;

}else{
$strDiscountAmount = ($intGrandTotal*($rowCouponInfo->coupon_discount/100));
if($strDiscountAmount>$rowCouponInfo->coupon_max_discount)
{
$strDiscountAmount=$rowCouponInfo->coupon_max_discount;
}

}


$aryResponse['discount_amount']=$strDiscountAmount;
$aryResponse['cashback_amount']=0;



$aryResponse['coupon_id'] = $rowCouponInfo->coupon_id;
$aryResponse['notification'] ='coupon applied successfully';

}
    
}else if(isset($rowCouponInfo->coupon_apply_on) && $rowCouponInfo->coupon_apply_on==2)
{ 
/*$strProductId =explode(',',$rowCouponInfo->coupon_discount_product);
$explodeProduct =explode(',',$strProductIdArray);
$strExplode =explode(',',$strQty);
$strDiscountAmount = 0; 
$totalValue= 0;
foreach($explodeProduct as $key=>$label)
{
 if(in_array($label,$strProductId))
{
$rowProductInfo = $this->SKProduct->find('all')->where(['product_id'=>$label])->first();

$intProductMrp = $rowProductInfo->product_net_price;
$intProductQty = $strExplode[$key];

$totalValue += $intProductMrp*$intProductQty;


}

}


if($rowCouponInfo->coupon_discount_mode==1)
{
if($totalValue>$rowCouponInfo->coupon_discount)
{

$strDiscountAmount = $rowCouponInfo->coupon_discount;
}else{

$strDiscountAmount = $totalValue;
}

}else{

$intDiscountValue = ($totalValue*$rowCouponInfo->coupon_discount)/10;
if($intDiscountValue>$rowCouponInfo->coupon_max_discount)
{

$strDiscountAmount = $rowCouponInfo->coupon_max_discount;
}else{

$strDiscountAmount =$intDiscountValue;
}
}



$aryResponse['discount_amount']=$strDiscountAmount;
$aryResponse['cashback_amount']=0;





$aryResponse['coupon_id'] = $rowCouponInfo->coupon_id;
$aryResponse['notification'] ='coupon applied successfully';
*/
}else if(isset($rowCouponInfo->coupon_apply_on) && $rowCouponInfo->coupon_apply_on==3){
$strUserId =explode(',',$rowCouponInfo->coupon_discount_user);

if(in_array($intUserId ,$strUserId))
{


if($rowCouponInfo->coupon_discount_mode==1)
{
$strDiscountAmount = $rowCouponInfo->coupon_discount;

}else{
$strDiscountAmount = ($intGrandTotal*($rowCouponInfo->coupon_discount/100));
if($strDiscountAmount>$rowCouponInfo->coupon_max_discount)
{
$strDiscountAmount=$rowCouponInfo->coupon_max_discount;
}

}


$aryResponse['discount_amount']=$strDiscountAmount;
$aryResponse['cashback_amount']=0;


$aryResponse['coupon_id'] = $rowCouponInfo->coupon_id;
$aryResponse['notification'] ='coupon applied successfully';

}else{


$aryResponse['message']='failed';
$aryResponse['notification']='Not a Valid Promo code';

}



}else{

$aryResponse['message']='failed';
$aryResponse['notification']='Promo Code Invalid';
}

$aryResponse['result'] =$rowCouponInfo;

}else{



$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';

}
echo json_encode($aryResponse);
exit;
}
}