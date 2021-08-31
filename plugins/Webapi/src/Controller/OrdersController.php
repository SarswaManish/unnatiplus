<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;
use Cake\View\Helper\SmsHelper;
use Cake\Filesystem\File;
use Admin\View\Helper\ManishdbHelper;
use Cake\View\Helper\PaytmHelper;
use Cake\View\Helper\FonepaisaHelper;
use Cake\View\Helper\PayumoneyHelper;
use Cake\ORM\TableRegistry;

class OrdersController  extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
    $this->getEventManager()->off($this->Csrf);

}
public function initialize()
{
    parent::initialize();
    
    $this->loadModel('Admin.Transactions');
     $this->loadModel('Admin.SkProduct');
     $this->loadModel('Admin.SkAddressBook');
     $this->loadModel('Admin.SkUser');
     $this->loadModel('Admin.Coupon');
     $this->loadModel('Admin.SkProductReview');
     $this->loadModel('Admin.SkUniqueIds');


if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {

  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}
}

public function index()
    {
          $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{

         $aryResponse['message']='ok';
         $aryResponse['notification']='Please Wait While Loading data';

          
$strWhere = ' 1 AND trans_main_id=0 AND trans_user_id='.$this->request->getdata('user_id').' AND (trans_method=\'Cash on Delivery\' OR trans_payment_status=1)';
$resTransactionList=$this->Transactions->find('all')->where($strWhere)->order(['trans_datetime'=>'DESC']);


$intTransactionList=$resTransactionList->count();
if($intTransactionList>0)
{
foreach($resTransactionList as $rowTransactionList )
{
    //GROUP_CONCAT(CONCAT(td_item_title,\' X \',td_qty),SEPARATOR  \', \')
$rowProductImage = $this->Transactions->find("all",['fields'=>['groupitem'=>'GROUP_CONCAT(CONCAT(trans_item_title,\' X \',trans_quantity))','total'=>'SUM(trans_amt)'],'conditions'=>['trans_main_id'=>$rowTransactionList->trans_id]])->first();

$rowTransactionList['trans_datetime'] =date('d M Y @ h:i A',strtotime($rowTransactionList['trans_datetime']));
if($rowProductImage->groupitem!='')
{
$rowTransactionList['trans_item'] = $rowTransactionList->trans_item_title.' X '.$rowTransactionList->trans_quantity.', '.$rowProductImage->groupitem;
$rowTransactionList['total'] = $rowProductImage->total+$rowTransactionList->trans_amt;

}else{
    $rowTransactionList['trans_item'] = $rowTransactionList->trans_item_title.' X '.$rowTransactionList->trans_quantity;
    $rowTransactionList['total'] = $rowTransactionList->trans_amt;


}


if($rowTransactionList->trans_status==1 || $rowTransactionList->trans_status==0 && $rowTransactionList->trans_payment_status==1 || $rowTransactionList->trans_status==3 || $rowTransactionList->trans_status==0 && $rowTransactionList->trans_method=='Cash on Delivery')
{
        $rowTransactionList['trans_display_status']  = 'Order Confirmed';

    if($rowTransactionList->trans_status==1)
    {
    $rowTransactionList['trans_display_status']  = 'Order Deliverd';
    }else  if($rowTransactionList->trans_status==3)
    {
        
     $rowTransactionList['trans_display_status']  = 'Order Dispatched';
       
    }
}else if($rowTransactionList->trans_status==2)
{
      $rowTransactionList['trans_display_status']  = 'Canceled';
}else{
        $rowTransactionList['trans_display_status']  = 'Pending Confirmation';
}

if($rowTransactionList->trans_payment_status==1)
{
      $rowTransactionList['trans_payment_status']  = '';
}else{
        $rowTransactionList['trans_payment_status']  = 'Payment Pending';
}





$aryResponse['result'][]=$rowTransactionList ;

}

}else{

 $aryResponse['message']='failed';
         $aryResponse['notification']='No Order Yet';

}


         }else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

         }

echo json_encode($aryResponse);
exit; 
    }
 


public function getorderdetail()
    {
          $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{

         $aryResponse['message']='ok';
         $aryResponse['notification']='Please Wait While Loading data';

$rowTransactionList=$this->Transactions->find('all')->where(array('trans_id'=>$this->request->getdata('trans_id')))->first();
   $conn = ConnectionManager::get('default');

$rowTransactionList->trans_datetime_extra =date('d M Y @ h:i A',strtotime($rowTransactionList->trans_datetime));

if(date('Y-m-d',strtotime($rowTransactionList->trans_delivery_date))>0 && $rowTransactionList->trans_delivery_status>0)
{
$rowTransactionList->trans_delivery_date =date('d M Y @ h:i A',strtotime($rowTransactionList->trans_delivery_date));
}else{
    
    $rowTransactionList->trans_delivery_date ='';

}


if($rowTransactionList->trans_status==1 || $rowTransactionList->trans_status==0 && $rowTransactionList->trans_payment_status==1 || $rowTransactionList->trans_status==3 || $rowTransactionList->trans_status==0 && $rowTransactionList->trans_method=='Cash on Delivery')
{
        $rowTransactionList['trans_display_status']  = 'Order Confirmed';

    if($rowTransactionList->trans_status==1)
    {
    $rowTransactionList['trans_display_status']  = 'Order Deliverd';
    }else  if($rowTransactionList->trans_status==3)
    {
        
     $rowTransactionList['trans_display_status']  = 'Order Dispatched';
       
    }
}else if($rowTransactionList->trans_status==2)
{
      $rowTransactionList['trans_display_status']  = 'Canceled';
}else{
        $rowTransactionList['trans_display_status']  = 'Pending Confirmation';
}


if($rowTransactionList->trans_payment_status==1)
{
      $rowTransactionList['trans_payment_status']  = '';
}else{
        $rowTransactionList['trans_payment_status']  = 'Payment Pending';
}


$rowProductImage = $this->Transactions->find("all")->where(['trans_main_id'=>$rowTransactionList->trans_id]);

$rowTransactionList['child']=$rowProductImage;

                        $resProductName = $conn->execute('SELECT GROUP_CONCAT(CONCAT(CONCAT(product_name,\' X \',trans_quantity),\' size \',size_name) SEPARATOR \', \')  as productname FROM transactions INNER JOIN sk_product ON product_id=trans_item_id LEFT JOIN sk_size ON sk_size.size_id = transactions.trans_size WHERE 1  AND ( trans_id='.$rowTransactionList->trans_id.')')->fetch('assoc');

$rowProductImage = $this->Transactions->find("all",['fields'=>['groupitem'=>'GROUP_CONCAT(CONCAT(trans_item_title,\' X \',trans_quantity))','total'=>'SUM(trans_amt)'],'conditions'=>['trans_main_id'=>$rowTransactionList->trans_id]])->first();

$rowTransactionList['trans_datetime'] =date('d M Y @ h:i A',strtotime($rowTransactionList['trans_datetime']));
if($rowProductImage->groupitem!='')
{
$rowTransactionList['total'] = $rowProductImage->total+$rowTransactionList->trans_amt;

}else{
    $rowTransactionList['total'] = $rowTransactionList->trans_amt;


}

$aryResponse['result']=$rowTransactionList ;


         }else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

         }

echo json_encode($aryResponse);
exit; 
    }  

function createTransactionOnCartId()
{
$this->viewBuilder()->setLayout('defaultAdmin');
	    $rwws = file_get_contents('php://input');

     if ($rwws!='') 
	{
//print_r($rwws);exit;

$aryPostData =json_decode($rwws);


$intUserId=$aryPostData->user_id;
$userAddressId=$aryPostData->address_id;
$intDiscountamount=$aryPostData->discount_amount;
 $strFullResponse = $rwws;
$couponId=$aryPostData->coupon_id;
$couponcode = '';
 
$intDeliveryCharge =$aryPostData->delivery_amount;
 $intGst = $aryPostData->gst_amount;
  $intItemSubtToal = $aryPostData->itemsub_amount;
  $intGrandSubtToal = $aryPostData->grandtotal_amount;

    $tableRegObj = TableRegistry::get('sk_address_book');
        $sk_shipping = TableRegistry::get('sk_shipping');
        
        $getAllResults = $tableRegObj->find()->select(['ab_state'])->where(['ab_id' => $userAddressId])->first();   
        
        $queryJoin = $sk_shipping->find()->select(['sk_shipping.shipping_state','sk_shipping.shipping_rate'])->join([
            'table' => 'sk_state',
            'alias' => 'sks',
            'type' => 'INNER',
            'conditions' => 'sks.state_id = sk_shipping.shipping_state',
        ])->where(['sks.state_name'=>$getAllResults->ab_state])->first();
        
                  $shippingRate = $queryJoin->shipping_rate;
                  
                  
$grand_total=$aryPostData->grandtotal_amount;
 $connection = ConnectionManager::get('default');
 $rowUserInfo=$this->SkUser->find("all")->where(['user_id'=>$intUserId])->first();
$strCompleteAddress =$aryPostData->trans_address;
$strBillingAddress =$aryPostData->trans_billing_address;
$strGstDetail = $aryPostData->trans_gst_detail;
$strGstDetailNumber = $aryPostData->trans_gst_number;
 $aryOrderId = array();
 //pr($stringAddonid);exit;
$intTransStatus=0;
  if($aryPostData->payment_method=='Cash on delivery')
  {
     $intTransStatus =1; 
  }
$intPaymentMethod =$aryPostData->payment_method;  
$intGrandTotalPay = 0;
$intGrandTotalItemAmount = 0;
  $intParentId =0;
                    $counter =0;
                    $intTotalAmount =0;
                    $intProductId = 0;
                    
                    $aryData = $aryPostData;
foreach($aryPostData->detail as $key=>$aryid)
{
    
    $counter++;
    $aryPostData =array();
    if($counter==1)
                        {
                            $intProductId  = $aryid->pu_product_id;
                       $aryPostData['trans_main_id']=0;   
 $aryPostData['trans_discount_amount']  =$intDiscountamount;
 
                        }else{
                    
                                $aryPostData['trans_discount_amount']=0;
                           $aryPostData['trans_main_id'] = $intParentId;
                            
                        }
    
    if($aryid->pu_product_id!=$intProductId)
    {
        $intProductId = $aryid->pu_product_id;
    $aryPostData['trans_main_id'] =0;
    }
    
    if($aryPostData['trans_main_id']==0)
{
    $intTotalGst =0;
$intDeliveryCharge = 0;

 foreach($aryData->detail as $unit=>$lab)
{
    if($lab->pu_product_id==$intProductId)
    {
   ///  pr($rowBusinessPriceData);
    $intTotal =$lab->pu_net_price*$lab->cart_qty;
    $intDeliveryCharge +=($lab->cart_qty*$lab->pu_item_pack*$shippingRate);
     if(isset($lab->product_detail->sk_tax->tax_title)){
         
         if($lab->product_detail->sk_tax->tax_igst_percent>0)
         {
    $intTotalGst += ($intTotal*$lab->product_detail->sk_tax->tax_igst_percent)/100;
         }else{
             $intGst =0;
         }
     } 
     ////$intTotalDiscount +=$rowBusinessPriceData->pu_discount*$lab['qty'];
   ////  $intSubTotal +=$intTotal;
   ////  $intTotalGst +=$intGst;
    }
 }
 
 
 
    $aryPostData['trans_delivery_amount']  = $intDeliveryCharge;
 $aryPostData['trans_igst']  = $intTotalGst;
    
}
                      $aryPostData['trans_type']='P';   
                      $aryPostData['trans_purpose']='P';    
                      $aryPostData['trans_user_id']=$intUserId;   
                       $aryPostData['trans_datetime']=date('Y-m-d h:i:s');   
                  
                      $aryPostData['trans_status']=$intTransStatus;  
                    
                                                $aryPostData['trans_size']=$aryid->pu_size;  
   
                    
                               $aryPostData['trans_delivery_address']=$strCompleteAddress;  
             $aryPostData['trans_billing_address']=$strBillingAddress;  
             $aryPostData['trans_gst_detail']=$strGstDetail;  
             $aryPostData['trans_gst_number']=$strGstDetailNumber;  
                     $aryPostData['trans_item_id']=$aryid->pu_product_id;
                     $aryPostData['trans_quantity']=$aryid->cart_qty;
  $aryPostData['trans_unit_price']=$aryid->pu_net_price;  
    $aryPostData['trans_order_number']=self::getorderUniqueId();  

  if(isset($aryid->sk_size))
  {
        $aryPostData['trans_item_title']=$aryid->product_detail->product_name.' '.$aryid->cart_qty.' '.$aryid->sk_unit->unit_name .' SIZE - '.$aryid->sk_size->size_name;  
        $aryPostData['trans_image_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$aryid->product_detail->product_featured_image;  
 }else{
      
         $aryPostData['trans_item_title']=$aryid->product_detail->product_name.' '.$aryid->cart_qty.'  '.$aryid->sk_unit->unit_name;  
                 $aryPostData['trans_image_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$aryid->product_detail->product_featured_image;  

     
  }
        $aryPostData['trans_actual_price']=$aryid->pu_selling_price; 

 if($aryPostData['trans_main_id']==0)
{  
                     $aryPostData['trans_total_amt']=($aryPostData['trans_unit_price']*$aryid->cart_qty); 
 
                        $aryPostData['trans_amt']=$aryPostData['trans_total_amt']+ $aryPostData['trans_delivery_amount']-$intDiscountamount+$aryPostData['trans_igst'];
                        $intTotalAmount +=$aryPostData['trans_amt'];
                        }else{
                            
                          $aryPostData['trans_total_amt']=($aryPostData['trans_unit_price']*$aryid->cart_qty); 
                     
                        $aryPostData['trans_amt']=($aryPostData['trans_unit_price']*$aryid->cart_qty);    
                       $intTotalAmount +=$aryPostData['trans_amt'];
   
                        }
                        
                        $aryPostData['trans_unit_id']=$aryid->pu_unit;
                      
                   $aryPostData['trans_delivery_address'] = $strCompleteAddress;
                   
                        $aryPostData['trans_method']=$intPaymentMethod;  

                     $category=$this->Transactions->newEntity();   
       	    $category=$this->Transactions->patchEntity($category,$aryPostData);
$category = $this->Transactions->save($category);
                   
 $aryTransIds[] = $category->trans_id;
    	      if($aryPostData['trans_main_id']==0)
                        {
                           $intParentId =$category->trans_id;
                            
                        }
   
}
 

 $aryReponse['message'] ='ok';
      $aryReponse['transaction_id'] =$intParentId;
       $aryReponse['total_payble'] =$intTotalAmount;
     

 }else{
 
          $aryReponse['message'] ='failed';
            $aryReponse['transaction_id'] ="0";

       }
       echo json_encode($aryReponse);
       exit();
}    
function getorderUniqueId()
    { 
        $this->rowUniqueId = $this->SkUniqueIds->find('all')->where(['ui_id'=>4])->first();
        $intCurrentCounter =$this->rowUniqueId['ui_current']+1;
        $strCustomeId =$this->rowUniqueId['ui_prefix'].''. sprintf('%04d',$intCurrentCounter);
        $this->SkUniqueIds->updateAll(['ui_current'=>$intCurrentCounter],['ui_id'=>4]);
        return $strCustomeId;
    }
function updatedatatrans()
{
    $aryPostData =array();
    if($this->request->is('post'))
    {
        $aryPostData['message'] ='ok';
        
        $this->Transactions->updateAll(['trans_status'=>1,'trans_payment_status'=>1,'trans_ref_id'=>$this->request->getData('payment_id')],['trans_id'=>$this->request->getData('trans_id')]);
    }else{
           $aryPostData['message'] ='failed';
     
    }
     echo json_encode($aryReponse);
       exit(); 
    
}

function completetransactionpayment()
{
    $aryPostData =array();
    if($this->request->is('post'))
    {
        $aryPostData['message'] ='ok';
        
        $this->Transactions->updateAll(['trans_status'=>1,'trans_payment_status'=>1,'trans_ref_id'=>1],['trans_id'=>$this->request->getData('transaction_id')]);
    }else{
           $aryPostData['message'] ='failed';
     
    }
     echo json_encode($aryReponse);
       exit(); 
    
}

function thankyou()
{
 $this->viewBuilder()->setLayout('defaultAdmin');

if(isset($_POST["status"]))
{

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt=TEST_PAYUMONEY_MERCHANT_SALT;

$query = $this->Transactions->query(); 
$query->update()->set(['trans_status' => 1,'trans_payment_status'=>1,'trans_method'=>'PayuMoney','trans_ref_id'=>$txnid]) ->where(['trans_id IN' => explode(',',$_POST['udf1'])])->execute();
$arYExplode =explode(',',$_POST['udf1']);
$reddemtamount =0;
$cashbackamount=0;
$intUserId =0 ;
$aryOrderId=array();
foreach($arYExplode as $key=>$label)
{

$rowTransactionInfo =$this->Transactions->find('all')->where(['trans_id'=>$label])->first();

$reddemtamount += $rowTransactionInfo->trans_redeem_amount;
$cashbackamount += $rowTransactionInfo->trans_cashback_amount;
$intUserId = $rowTransactionInfo->trans_user_id;
$aryOrderId[] = $rowTransactionInfo->trans_order_number;
}




$userNumber=$_POST["phone"];
 $strMessage ='Order Placed: You Order with order Id : '.$_POST['udf1'].' amounting to Rs.'.$_POST["amount"].' has been received.You can expect delivery by 3-4 days.We will send you an update when your order is packed/dispatch.Thank you.';

SmsHelper::sendSms($userNumber, $strMessage);

}

}

function getinvoiceonemail()
{
$aryResponse =array();
  if ($this->request->is(['get', 'post', 'put'])) 
{
$aryResponse['message']='ok';
$aryResponse['notification'] = 'Invoice email to your register email id.';
}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Some Error Occure';
}
echo json_encode($aryResponse);
exit;
}




   function payumoneyredirect($intTransId,$intUser)
{
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
       $conn = ConnectionManager::get('default');

$strTransId = $intTransId;
$rowBookingInfo=$this->Transactions->find('all',['conditions'=>['trans_id'=>$intTransId]])->first();
$rowUserInfo =  $this->SkUser->find('all')->where(['user_id'=>$intUser])->first();

$payu['txnid'] = $strTransId;        
    $rowProductInfo =$conn->execute('SELECT SUM(trans_amt) as total FROM transactions  WHERE 1  AND (trans_id='.$intTransId.' OR trans_main_id='.$intTransId.')')->fetch('assoc');
 $amount =$rowProductInfo['total'];                                         
  
  //Call Vendor function for send to payu
 // PayumoneyHelper::send($payu);
  $strInvoiceNumber ='RRORDER'.rand(1,100000000);
  		$articles = $this->Transactions;
$query = $articles->query();
$query->update()
    ->set(['trans_invoice_no' => $strInvoiceNumber])
    ->where(['trans_id IN' => explode(',',$strTransId)])
    ->execute();
    

  $payu['txnid'] = $strTransId;                                                  //Transaction Id
  $payu['firstname'] = $rowUserInfo['user_first_name'];
  $payu['email'] = $rowUserInfo['user_email_id'];
  $payu['phone'] = $rowUserInfo['user_mobile'];
  
  $payu['productinfo'] = 'Order - '. $strTransId;         // Product Info
  
  $payu['surl'] = SITE_URL.'webapi/orders/payumoneyresponse';   // Success Url
  $payu['furl'] =  SITE_URL.'webapi/orders/failure'; // Fail Url
  $payu['curl'] = SITE_URL.'webapi/orders/failure'; // Fail Url 
  $payu['amount'] =$amount;                                         
  
  //Call Vendor function for send to payu
  PayumoneyHelper::send($payu);
  
  
  
$checkSum = "";

$this->viewBuilder()->setLayout('default');
$title = 'Please wait while we are redirecting to payment page';
$this->set(compact('title','paramList','checkSum'));


     /* FonepaisaHelper::fonepaisa_forward(array(
			'id'=>'A1544',
			'merchant_id'=>'A1544',
			'merchant_display'=>'Rara Spices',
			'invoice_amt' => number_format($amount,2,'.',''),
			'amount' => number_format($amount,2,'.',''),
			'email'=> $rowUserInfo->user_email_id,
			'mobile_no'=> $rowUserInfo->user_mobile,
			'callback_url'=>SITE_URL.'webapi/orders/payumoneyresponse',
			'callback_failure_url'=> SITE_URL.'webapi/orders/failure',
			'invoice'=>$strInvoiceNumber,
			'api_key'=>'83570EEG2V17I199X34136623G5K1R7',
			'private_key'=>'file://'.$_SERVER['DOCUMENT_ROOT'].'/webroot/priv.pem',
			'public_key'=>'',
			'is_live_env'=>'Y' //The value should be changed to 'Y' when one wants to move to production
		));*/
	///	exit;
  

}


 


  function payumoneyresponse()
{
$postdata = $_POST;
$msg = '';
$salt = PAYU_MERCHANT_SALT;
if (isset($postdata ['key'])) {
	$key				=   $postdata['key'];
	$txnid 				= 	$postdata['txnid'];
    $amount      		= 	$postdata['amount'];
	$productInfo  		= 	$postdata['productinfo'];
	$firstname    		= 	$postdata['firstname'];
	$email        		=	$postdata['email'];
	$udf5				=   $postdata['udf5'];
	$mihpayid			=	$postdata['mihpayid'];
	$status				= 	$postdata['status'];
	$resphash				= 	$postdata['hash'];
	//Calculate response hash to verify	
	$keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
	$keyArray 	  		= 	explode("|",$keyString);
	$reverseKeyArray 	= 	array_reverse($keyArray);
	$reverseKeyString	=	implode("|",$reverseKeyArray);
	$CalcHashString 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString));
	
	
	if ($status == 'success'  && $resphash == $CalcHashString) {
		//Do success order processing here...
	 
   
    
		$articles = $this->Transactions;
$query = $articles->query();
$query->update()
    ->set(['trans_payment_status' => 1,'trans_ref_id' => $_POST['mihpayid']])
    ->where(['trans_id IN' => explode(',',$_POST["txnid"])])
    ->execute();
    
     /// $this->request->getSession()->delete('CART');
      return $this->redirect(
     ['controller' => 'Cart', 'action' => 'thankyou']
      );	
		
	}
	else {
		//tampered or failed
		return $this->redirect(
     ['controller' => 'Cart', 'action' => 'failure']
      );
	} 

/*	$retval=FonepaisaHelper::fonepaisa_verifymsg(array(
			'invoice'=>$_POST["invoice"],
			'payment_reference'=>$_POST["payment_reference"],
			'sign' => $_POST["sign"],
			'public_key' => 'file://'.$_SERVER['DOCUMENT_ROOT'].'/webroot/fonepaisa_public_key.pub'
		));
	if ($retval == true) {
		$articles = $this->Transactions;
$query = $articles->query();
$query->update()
    ->set(['trans_payment_status' => 1,'trans_ref_id' => $_POST['payment_reference']])
    ->where(['trans_invoice_no' => $_POST["invoice"]])
    ->execute();
    
    
		return $this->redirect(
     ['controller' => 'Cart', 'action' => 'thankyou']
      );	
	}
	else {
		return $this->redirect(
     ['controller' => 'Cart', 'action' => 'failure']
      );	
	}
	

exit;*/

}
}





function failure()
{
 $this->viewBuilder()->setLayout('defaultAdmin');
}
function returnorder()
{
  $aryResponse =array();
  if ($this->request->is(['post'])) 
{
$aryResponse['message']='ok';
$aryResponse['notification'] = 'Order Canceled';

  $rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
$query = $this->Transactions->query(); 
$query->update()->set(['trans_status' =>5]) ->where(['trans_id ' => $aryPostData->trans_id])->execute();
}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Some Error Occure';
}
echo json_encode($aryResponse);
exit;  
    
}
function cancelorder()
{
$aryResponse =array();
  if ($this->request->is(['post'])) 
{
$aryResponse['message']='ok';
$aryResponse['notification'] = 'Order Canceled';

  $rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
$query = $this->Transactions->query(); 
$query->update()->set(['trans_status' =>2]) ->where(['trans_id ' => $aryPostData->trans_id])->execute();
/*
$resTransactionList=$this->Transactions->find('all',['contain'=>'Product'])->where(array('trans_user_id'=>$this->request->getdata('user_id'),'trans_status IN '=>array(1,2)))->order(['trans_datetime'=>'DESC']);
$intTransactionList=$resTransactionList->count();
if($intTransactionList>0)
{
foreach($resTransactionList as $rowTransactionList )
{
$rowProductImage = $this->ProductImage->find("all")->where(['pimage_product_id'=>$rowTransactionList->product->product_id,'pimage_base'=>1])->first();

$rowTransactionList['product_image'] =SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductImage->pimage_file;
$rowTransactionList['trans_delivery_date'] ='Delivered on '.date('l M d y',strtotime($rowTransactionList['trans_delivery_date']));
$aryResponse['result'][]=$rowTransactionList ;

}
    
   
}else{

 $aryResponse['message']='failed';
         $aryResponse['notification']='No Order Yet';

}
*/ 
}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Some Error Occure';
}
echo json_encode($aryResponse);
exit;

}
function weightorder()
{
$aryResponse =array();
  if ($this->request->is(['post'])) 
{
$aryResponse['message']='ok';
$aryResponse['notification'] = 'Order updated';
$intcalculate =60; 
$query = $this->Transactions->query(); 
$query->update()->set(['trans_weight' =>$_POST['trans_weight'],'trans_amt'=>$intcalculate*$_POST['trans_weight']]) ->where(['trans_id ' => $_POST['trans_id']])->execute();


$aryReponse['message'] ='ok';
      $aryReponse['order_id'] =$_POST['trans_id'];
       $aryReponse['payment_url'] =SITE_URL.'webapi/orders/paytmredirect/'.$_POST['trans_id'].'/'.$_POST['user_id'];


}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Some Error Occure';
}
echo json_encode($aryResponse);
exit;

}

function updaterating()
{
$rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
    $aryResponse =array();
  if ($this->request->is(['post'])) 
{
$aryResponse['message']='ok';
$aryResponse['notification'] = 'Thank you fo rate us.';
$rowTransactionInfo =$this->Transactions->find('all')->where(['trans_id'=>$aryPostData->order_id])->first();
  $rowUserInfo =$this->SkUser->find('all')->where(['user_id'=>$rowTransactionInfo->trans_user_id])->first();
$query = $this->Transactions->query(); 
$query->update()->set(['trans_rating'=>$aryPostData->driver_rating,'trans_comment'=>$aryPostData->driver_review]) ->where(['trans_id' => $aryPostData->order_id])->execute();
$aryPostDatanew=array();
$aryPostDatanew['pr_message']=$aryPostData->driver_review;
$aryPostDatanew['pr_datetime']=date('Y-m-d h:i:s');
$aryPostDatanew['pr_status']=1;
$aryPostDatanew['pr_rating']=5;
$aryPostDatanew['pr_order_id']=$aryPostData->order_id;

$aryPostDatanew['pr_product_id']=$rowTransactionInfo->trans_item_id;
$aryPostDatanew['pr_user_name']=$rowUserInfo->user_first_name.' '.$rowUserInfo->user_last_name;
$aryPostDatanew['pr_user_id']=$rowUserInfo->user_id;
$user = $this->SkProductReview->newEntity();
$user = $this->SkProductReview->patchEntity($user, $aryPostDatanew);
$this->SkProductReview->save($user);
$aryReponse['message'] ='ok';


}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Some Error Occure';
}
echo json_encode($aryResponse);
exit;
}
}