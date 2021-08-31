<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\PaytmHelper;
use Cake\View\Helper\PayumoneyHelper;

use  Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CartController  extends AppController
{

    public function beforeFilter(Event $event)
{
    parent::beforeFilter($event);
    $this->getEventManager()->off($this->Csrf);
} 
public $rowAdminInfo =array();
        public function initialize()
	{
	           parent::initialize();
	   	      $this->loadModel('SkUser');
	   	      $this->loadModel('SkProduct');
	   	      $this->loadModel('SkProductbusinessprice');
	   	      $this->loadModel('Transactions');
	   	      $this->loadModel('Coupon');
	   	      $this->loadModel('SkWishlist');
	   	      $this->loadModel('SkCart');
 	   	      $this->loadModel('SkSize');
 	   	      $this->loadModel('SkUnit');
 	   	      $this->loadModel('SkState');
 	   	      $this->loadModel('SkShipping');
 	   	      $this->loadModel('SkAddressBook');
 	   	      $this->loadModel('SkUniqueIds');
 	   	      $this->loadComponent('Cookie');
               
              $this->rowAdminInfo = $this->request->getSession()->read('USER');
	}
	
	
   function index()
   {
     //$this->request->getSession()->delete('cart_items');
  ////  pr($this->request->getSession()->read('cart_items'));
       $strPageTitle='Cart';
        $this->SkProduct->belongsTo('SkTaxes', [
                            'foreignKey' => 'product_tax_class', //for foreignKey
                            'joinType' => 'LEFT' //join type
                        ]);
       $resCartInfo =  $this->request->getSession()->read('cart_items');
       $intCartCount = self::getCartCount($resCartInfo);
       $resProdutObject = $this->SkProduct;
       $this->SkProductbusinessprice->belongsTo('SkSize', [
            'foreignKey' => 'pu_size', //for foreignKey
            'joinType' => 'LEFT' //join type
        ]);
         $this->SkProductbusinessprice->belongsTo('SkUnit', [
            'foreignKey' => 'pu_unit', //for foreignKey
            'joinType' => 'LEFT' //join type
        ]);

       $resBusinessPrice = $this->SkProductbusinessprice;
       $this->set(compact('strPageTitle','resCartInfo','resProdutObject','resBusinessPrice'));
   }
   function wishlist($intEditId=null)
   {
       $rowproInfo=array();
        $aryPostData=array();
        if($intEditId>0)
        {   
            $rowproInfo = $this->SkWishlist->get($intEditId, [
            'contain' => []  ]);
        }
    
       if($this->request->is(['patch', 'post', 'put']))
       {
    
            $aryPostData=$_POST;
            
            $aryPostData=$this->request->getdata();
            if($intEditId<=0)
            {
                $product = $this->SkWishlist->newEntity();
            }else{
                $product = $this->SkWishlist->get($intEditId, ['contain' => []]);
            }
         
                $product = $this->SkWishlist->newEntity();
                $user = $this->SkWishlist->patchEntity($product,$aryPostData); 
            if($this->SkWishlist->save($product))
            {
                $this->Flash->success(__('Successfully added'));
                return $this->redirect(['action' => 'categories']);
            }
        }
       $strPageTitle='Wish List';
       $this->set(compact('strPageTitle'));
   }
   function addtocart()
   {
       $aryResponse =array();
        //$resCartInfo =  $this->request->getSession()->read('CART');
       $postData = $this->request->getData();
       
       if($postData['action'] == 1){
            
            $rowAdminInfo =  $this->request->getSession()->read('USER');
            if(!isset($rowAdminInfo->user_id)){
              $user_id = 0;  
            }else{
              $user_id = $rowAdminInfo->user_id;
            }
            if($this->Cookie->read('unique_session')){
                 $unique =  $this->Cookie->read('unique_session');  
            }else{
                $unique = 0;
            }
            $tableData = array(
                'cart_user_id'=>$user_id,
                'unique_code'=>($user_id==0)?$unique:"",
                'cart_product_id'=>$postData['product_id'],
                'cart_product_attributes'=>serialize($postData['attrs']),
                'cart_status'=>1
            );
            $new = $this->SkCart->newEntity();
            $newEntry = $this->SkCart->patchEntity($new,$tableData);
            $this->SkCart->save($newEntry);
            
            $data = $this->request->getSession()->read('cart_items');
            $add[$postData['product_id']] = $postData['attrs'];
            if(!isset($data[$postData['product_id']])){
               
                foreach($postData['attrs'] as $key=>$label)
                {
                $data[$postData['product_id']][$label['size']] = $label;
                }
                
                $this->request->getSession()->write('cart_items', $data);
                $aryResponse['cartcount'] =self::getCartCount($data);

            }else{
                 
                $dataextra = array();
                foreach($data as $key=>$label){
                    if($key==$postData['product_id'])
                    {
                        foreach($postData['attrs'] as $key=>$label)
                        {
                            $dataextra[$postData['product_id']][$label['size']] = $label;
                        }
                    }else{
                        
                       $dataextra[$key] = $label;
                    }
                }
      
            
            $this->request->getSession()->write('cart_items', $dataextra);
            $aryResponse['cartcount'] =self::getCartCount($dataextra);

            }
           /// echo json_encode($data[$postData['product_id']]);
        }
        
          $aryResponse['cartamount'] = self::getcartTotal();
       echo json_encode($aryResponse);
       exit;
   }
   
   function removefromcart()
   {
        $aryResponse =array();
        if($this->request->is('post')){
            $aryResponse['message']='ok';
            $cartItem =   $this->request->getSession()->read('cart_items');
            $aryPostData = $this->request->getData();
            $aryExtraCartData =array();
            foreach($cartItem as $key=>$label){
                if($aryPostData['product_id']==$key){
                    if(count($label)>1){
                        foreach($label as $a=>$b){
                            if($b['pu_id']==$aryPostData['puid']){
                            
                            }else{
                                $aryExtraCartData[$key][$a]= $b;
                            }
                        }
                    }
                }else{
                    $aryExtraCartData[$key]= $label;
                }
            }
            $this->request->getSession()->write('cart_items',$aryExtraCartData);
            $aryResponse['cartcount'] =self::getCartCount($aryExtraCartData);
        }else{
            $aryResponse['message']='failed';
            $aryResponse['cartcount']  =0;
        }
    echo json_encode($aryResponse);
    exit;
    }
   function plustocart()
   {
       $aryResponse =array();
                  $resCartInfo =  $this->request->getSession()->read('CART');

       if(isset($_POST['product_id']) && isset($_POST['u']))
       {
           $aryResponse['message']='ok';
           
           if(isset($resCartInfo[$_POST['product_id']][$_POST['u']]))
           {
               
              $resCartInfo[$_POST['product_id']][$_POST['u']] +=1;  
             $this->request->getSession()->write('CART',$resCartInfo);
             
               $aryResponse['qty'] =$resCartInfo[$_POST['product_id']][$_POST['u']];
           }
           
       }else{
           
     $aryResponse['message']='failed';       
           
       }
       
        $aryResponse['cartcount'] =self::getCartCount($resCartInfo);
        $aryResponse['cartamount'] = self::getcartTotal();
       echo json_encode($aryResponse);
       exit;
   }
   
   function getCartCount($resCartInfo)
   {
       $counter =0;
       if(isset($resCartInfo))
       {
      foreach($resCartInfo as $key=>$label)
      {
          foreach($label as $k=>$l)
          {
             $counter++; 
          }
      }
       }
      return $counter;
   }
     function minustocart()
   {
       $aryResponse =array();
                  $resCartInfo =  $this->request->getSession()->read('CART');

       if(isset($_POST['product_id']) && isset($_POST['u']))
       {
           $aryResponse['message']='ok';
           
           if(isset($resCartInfo[$_POST['product_id']][$_POST['u']]) && $resCartInfo[$_POST['product_id']][$_POST['u']]>0)
           {
               
              $resCartInfo[$_POST['product_id']][$_POST['u']] -=1;  
               if($resCartInfo[$_POST['product_id']][$_POST['u']] ==0)
           {
           unset($resCartInfo[$_POST['product_id']][$_POST['u']]);
           }
             $this->request->getSession()->write('CART',$resCartInfo);
             
           }
           if(isset($resCartInfo[$_POST['product_id']][$_POST['u']]) && $resCartInfo[$_POST['product_id']][$_POST['u']] >0)
           {
           $aryResponse['qty'] =(int)$resCartInfo[$_POST['product_id']][$_POST['u']];
           }else{
             $aryResponse['qty'] =0;  
               
           }
           

       }else{
           
     $aryResponse['message']='failed';       
           
       }
       
         $aryResponse['cartcount'] =self::getCartCount($resCartInfo);;
          $aryResponse['cartamount'] = self::getcartTotal();
       echo json_encode($aryResponse);
       exit;
   }
   
   function deletetocart()
   {
       $aryResponse =array();
                  $resCartInfo =  $this->request->getSession()->read('CART');

       if(isset($_POST['product_id']))
       {
           $aryResponse['message']='ok';
           
           if(isset($resCartInfo[$_POST['product_id']]) && $resCartInfo[$_POST['product_id']]>0)
           {
               
              $resCartInfo[$_POST['product_id']] =0;  
               if($resCartInfo[$_POST['product_id']] ==0)
           {
           unset($resCartInfo[$_POST['product_id']]);
           }
             $this->request->getSession()->write('CART',$resCartInfo);
             
           }
           if(isset($resCartInfo[$_POST['product_id']]) && $resCartInfo[$_POST['product_id']] >0)
           {
           $aryResponse['qty'] =(int)$resCartInfo[$_POST['product_id']];
           }else{
             $aryResponse['qty'] =0;  
               
           }
           

       }else{
           
     $aryResponse['message']='failed';       
           
       }
       
         $aryResponse['cartcount'] =count($resCartInfo);
          $aryResponse['cartamount'] = self::getcartTotal();
       echo json_encode($aryResponse);
       exit;
   }
   function getcartTotal()
   {
             $resCartInfo =  $this->request->getSession()->read('CART');
             $conn = ConnectionManager::get('default');

             $intTotal =0; 
             if(isset($resCartInfo))
             {
             foreach($resCartInfo as $key=>$label)
             {
                  foreach($label as $k=>$l)
             {
                             $rowProductInfo =$conn->execute('SELECT * FROM sk_product INNER JOIN sk_productbusinessprice ON pu_product_id=product_id INNER JOIN sk_unit ON unit_id=pu_unit WHERE 1  AND product_id='.$key.' AND pu_unit='.$k)->fetch('assoc');
                 $intTotal +=  $rowProductInfo['pu_net_price']*$l;
             }
             }
             }
        
       return number_format($intTotal,2,'.','');
   }
   
     function checkout()
   {
    
               /// $this->viewBuilder()->setLayout('checkoutlayout');
    $rowCartItem =    $this->request->getSession()->read('cart_items');
    if(count($rowCartItem)<=0){
        $this->redirect(SITE_URL);
    }
      
$resAddressList = $this->SkAddressBook->find('all')->where(['ab_user_id'=>$this->rowAdminInfo['user_id']]);

             $resCartInfo =  $this->request->getSession()->read('cart_items');
           $cartcount =self::getCartCount($resCartInfo);

$resShippingRate =$this->SkShipping; 
   $this->SkProduct->belongsTo('SkTaxes', [
                            'foreignKey' => 'product_tax_class', //for foreignKey
                            'joinType' => 'LEFT' //join type
                        ]);
       $resCartInfo =  $this->request->getSession()->read('cart_items');
       $intCartCount = self::getCartCount($resCartInfo);
       $resProdutObject = $this->SkProduct;
       $this->SkProductbusinessprice->belongsTo('SkSize', [
    'foreignKey' => 'pu_size', //for foreignKey
    'joinType' => 'LEFT' //join type
]);
 $this->SkProductbusinessprice->belongsTo('SkUnit', [
    'foreignKey' => 'pu_unit', //for foreignKey
    'joinType' => 'LEFT' //join type
]);

       $resBusinessPrice = $this->SkProductbusinessprice;
        
         $strPageTitle='checkout';
         $this->set(compact('strPageTitle','resAddressList','cartcount','resCartInfo','resProdutObject','resBusinessPrice','resShippingRate'));
       
   }
   function getorderUniqueId()
    { 
        $this->rowUniqueId = $this->SkUniqueIds->find('all')->where(['ui_id'=>4])->first();
        $intCurrentCounter =$this->rowUniqueId['ui_current']+1;
        $strCustomeId =$this->rowUniqueId['ui_prefix'].''. sprintf('%04d',$intCurrentCounter);
        $this->SkUniqueIds->updateAll(['ui_current'=>$intCurrentCounter],['ui_id'=>4]);
        return $strCustomeId;
    }
   function paymentprocessing()
   {
            if($this->request->is(['patch', 'post', 'put'])) 
        {
            $this->SkProduct->belongsTo('SkTaxes', [
                            'foreignKey' => 'product_tax_class', //for foreignKey
                            'joinType' => 'LEFT' //join type
                        ]); 
    	        $resCartInfo =  $this->request->getSession()->read('cart_items');
    	        $rowUserInfo =  $this->request->getSession()->read('USER');
////pr($resCartInfo);die();
                if($_POST['trans_address_id']!='' && $_POST['trans_payment_method']>0 && count($resCartInfo)>0 && isset($rowUserInfo))
                {
                    
          $tableRegObj = TableRegistry::get('sk_address_book');
        $sk_shipping = TableRegistry::get('sk_shipping');
        
        $getAllResults = $tableRegObj->find()->select(['ab_state'])->where(['ab_id' => $_POST['trans_address_id_data']])->first();   
        
        $queryJoin = $sk_shipping->find()->select(['sk_shipping.shipping_state','sk_shipping.shipping_rate'])->join([
            'table' => 'sk_state',
            'alias' => 'sks',
            'type' => 'INNER',
            'conditions' => 'sks.state_id = sk_shipping.shipping_state',
        ])->where(['sks.state_name'=>$getAllResults->ab_state])->first();
        
                  $shippingRate = $queryJoin->shipping_rate;

        
                    $aryTransIds =array();
                    $counter =0;
                    $intProductOldId =0; 
                                                                $intParentId =0;
                     $cntone=0;
                    foreach($resCartInfo as $key=>$label)
                    {
 $cntone=0;
 $counter =0;
     $rowProductInfo =$this->SkProduct->find('all',['contain'=>['SkTaxes']])->where(['product_id'=>$key])->first();
$intTotalGst =0;
$intDeliveryCharge = 0;
  foreach($label as $unit=>$lab)
{
    
    $rowBusinessPriceData =$this->SkProductbusinessprice->find('all')->Where(['pu_id'=>$lab['pu_id']])->first();
  ///  pr($rowBusinessPriceData);
    $intTotal =$rowBusinessPriceData->pu_net_price*$lab['qty'];
    $intDeliveryCharge +=($lab['qty']*$lab['ItemInPack']*$shippingRate);
     if(isset($rowProductInfo->sk_tax->tax_title)){
         
         if($rowProductInfo->sk_tax->tax_igst_percent>0)
         {
    $intGst = ($intTotal*$rowProductInfo->sk_tax->tax_igst_percent)/100;
         }else{
             $intGst =0;
         }
     } 
     ////$intTotalDiscount +=$rowBusinessPriceData->pu_discount*$lab['qty'];
   ////  $intSubTotal +=$intTotal;
     $intTotalGst +=$intGst;
 }
 
 
 
 
                         foreach($label as $k=>$l)
                    {
                        $counter++;
                        if($cntone==0)
                        {
                            $intParentId=0;
                        }
                        
                       
                    $rowProductInfo =$this->SkProduct->find('all',['contain'=>['SkTaxes']])->where(' 1 AND product_id='.$key)->first();
                    
                     $rowProductBusinessInfo =$this->SkProductbusinessprice->find('all')->where(' 1 AND pu_product_id='.$key.' AND pu_id='.$l['pu_id'])->first();

                      $aryPostData =array();
                       if($counter==1)
                        {
                       $aryPostData['trans_main_id']=0;   
                          $aryPostData['trans_coupon_id']  = $_POST['trans_coupon_id'];
                            $aryPostData['trans_discount_amount']  = $_POST['trans_discount_amount'];
                                 $aryPostData['trans_delivery_amount']  = $intDeliveryCharge;
                       
                        }else{
                           $aryPostData['trans_main_id'] = $intParentId;
                            
                        }
                      $aryPostData['trans_datetime']=date('Y-m-d h:i:s');
                      $aryPostData['trans_type']='P';   
                                          $intOrderId =self::getorderUniqueId();

                      $aryPostData['trans_purpose']='P';    
                      $aryPostData['trans_user_id']=$rowUserInfo['user_id'];   
                                 $aryPostData['trans_order_number']=$intOrderId;   
        
                      $aryPostData['trans_status']=0;  
                     if($_POST['trans_payment_method']==1)
                     {
                         $aryPostData['trans_method']='Cash on Delivery'; 
                         
                           $aryPostData['trans_status']=1;
                     }else if($_POST['trans_payment_method']==2)
                     {
                          $aryPostData['trans_method']='Razorpay';  
                     }
                     $aryPostData['trans_billing_address']=$_POST['trans_address_id'];  
                     $aryPostData['trans_item_id']=$key;  
                       $aryPostData['trans_unit_id']=$rowProductBusinessInfo->pu_unit;  
                   $aryPostData['trans_quantity']=$l['qty'];  
                    $aryPostData['trans_size']=$l['size'];  
                                        $aryPostData['trans_gst_detail']=$_POST['trans_gst_detail'];  
                                        $aryPostData['trans_gst_number']=$_POST['trans_gst_number'];  
 
                    $aryPostData['trans_unit_price']=$rowProductBusinessInfo->pu_net_price;  
                     $aryPostData['trans_actual_price']=$rowProductBusinessInfo->pu_selling_price; 
                     
                   if($counter==1)
                        {  
                                                                                         $aryPostData['trans_igst']=$intTotalGst;  

                        $aryPostData['trans_total_amt']=($rowProductBusinessInfo->pu_net_price*$l['qty']); 
                     
                        $aryPostData['trans_amt']=($rowProductBusinessInfo['pu_net_price']*$l['qty'])+$intTotalGst+$intDeliveryCharge;  

                        }else{
                            
                          $aryPostData['trans_total_amt']=($rowProductBusinessInfo->pu_net_price*$l['qty']); 
                     
                        $aryPostData['trans_amt']=($rowProductBusinessInfo['pu_net_price']*$l['qty']);    
                            
                        }
                        
                  ////   $aryPostData['trans_delivery_amount'] = $_POST['trans_delivery_amount'];
                                     $aryPostData['trans_delivery_address'] = $_POST['trans_address_id'];
     
                     	  $category=$this->Transactions->newEntity();   
       	    $category=$this->Transactions->patchEntity($category,$aryPostData);
$category = $this->Transactions->save($category);
    	     $aryTransIds[] = $category->trans_order_number;
    	      
    	      if($cntone==0)
                        {
                           $intParentId =$category->trans_id;
                            
                        }
    	     $cntone++;
                    }
                        
                        
                    }
                   if($_POST['trans_payment_method']==2)
                     {
                         
                    $intTransId = implode(',',$aryTransIds);
                                 $this->request->getSession()->write('tarns_booking_id',$intTransId);
                                 
                 ////   $this->request->getSession()->write('tarns_delivery_amount',$aryPostData['trans_delivery_amount']);  
                    if(isset($aryPostData['trans_discount_amount']))
                    {
                    $this->request->getSession()->write('trans_discount_amount',$aryPostData['trans_discount_amount']);
                    }else{
                                     $this->request->getSession()->write('trans_discount_amount',0);
       
                    }

    	      return $this->redirect(['action' => 'thankyou']);    
                     }else{
                            $this->request->getSession()->delete('cart_items');

    	        $this->Flash->success(__('Thank You| Order Successfully Palaced.'));
    	         $intTransId = implode(',',$aryTransIds);
                                 $this->request->getSession()->write('tarns_booking_id',$intTransId);
    	        return $this->redirect(SITE_URL.'cart/thankyou');   
                     }
                    
                }else{
                     $this->Flash->error(__('Sorry order can not process. Please, try again.'));
    	             return $this->redirect(['action' => 'checkout']);
                }
                
        }
            
       
   }
   
   
   function paytmredirect()
{
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
$strTransId = $this->request->getSession()->read('tarns_booking_id');
$intDeliveryAmount = $this->request->getSession()->read('tarns_delivery_amount');
$intDiscountAmount = $this->request->getSession()->read('trans_discount_amount');

$rowBookingInfo=$this->Transactions->find('all',['conditions'=>['trans_id IN'=>explode(',',$strTransId)]]);
$rowUserInfo =  $this->request->getSession()->read('USER');
$checkSum = "";
$firstorderid =explode(',',$strTransId);
$paramList = array();
$ORDER_ID =$firstorderid[0];
$CUST_ID = $rowUserInfo['user_id'];
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = CHANNEL_ID;
$paramList["TXN_AMOUNT"] = self::getcartTotal()+$intDeliveryAmount-$intDiscountAmount;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
$paramList["CALLBACK_URL"] = CALLBACK_URL;
$checkSum = PaytmHelper::getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
$this->viewBuilder()->setLayout('default');
$title = 'Please wait while we are redirecting to payment page';
$this->set(compact('title','paramList','checkSum'));
}


   function payumoneyredirect()
{
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
$strTransId = $this->request->getSession()->read('tarns_booking_id');
$intDeliveryAmount = $this->request->getSession()->read('tarns_delivery_amount');
$rowBookingInfo=$this->Transactions->find('all',['conditions'=>['trans_id IN'=>explode(',',$strTransId)]]);
$rowUserInfo =  $this->request->getSession()->read('USER');
$intDiscountAmount = $this->request->getSession()->read('trans_discount_amount');

$payu['txnid'] = $strTransId;                                                  //Transaction Id
  $payu['firstname'] = $rowUserInfo['user_first_name'];
  $payu['email'] = $rowUserInfo['user_email_id'];
  $payu['phone'] = $rowUserInfo['user_mobile'];
  
  $payu['productinfo'] = 'Order - '. $strTransId;         // Product Info
  
  $payu['surl'] = SITE_URL.'cart/payumoneyresponse';   // Success Url
  $payu['furl'] =  SITE_URL.'cart/failure'; // Fail Url
  $payu['curl'] = SITE_URL.'cart/failure'; // Fail Url 
  $payu['amount'] = self::getcartTotal()+$intDeliveryAmount-$intDiscountAmount;                                         
  
  //Call Vendor function for send to payu
  PayumoneyHelper::send($payu);
  
  
  
$checkSum = "";

$this->viewBuilder()->setLayout('default');
$title = 'Please wait while we are redirecting to payment page';
$this->set(compact('title','paramList','checkSum'));
}


  function paytmresponse()
{
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
   $this->viewBuilder()->setLayout('default');
$title = 'Cancel payment '.SITE_TITLE;
$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; 
$path = $_SERVER['DOCUMENT_ROOT'].'paytmresponse/';
$folder = new Folder($path);
if (!is_null($folder->path))
{
$strFile =$path.$_POST["ORDERID"].'.txt';
    $file = new File($strFile);
    $contents = $file->read();
$strData='';
    foreach($_POST as $key=>$label)
    {
    $strData .= $key.'=>'.$label.',';
    }
    $file->write($strData);
   $file->close(); 
}

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = PaytmHelper::verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		

$ORDER_ID = "";
$requestParamList = array();
$responseParamList = array();

$requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $_POST["ORDERID"]);  

$checkSum = PaytmHelper::getChecksumFromArray($requestParamList,'dHVQWXz&n&Pqg&Z2');
$requestParamList['CHECKSUMHASH'] = urlencode($checkSum);

$responseParamList =  PaytmHelper::getTxnStatus($requestParamList);


$strFile =$path.$_POST["ORDERID"].'-status.txt';
    $file = new File($strFile);
    $contents = $file->read();
$strData=json_encode($responseParamList);
    $strData .='#####'.json_encode($requestParamList);

    $file->write($strData);
   $file->close(); 


if($responseParamList['STATUS']=='TXN_SUCCESS')
{
$articles = $this->Transactions;
$query = $articles->query();
$query->update()
    ->set(['trans_payment_status' => 1,'trans_ref_id' => $_POST['TXNID']])
    ->where(['trans_id IN' => explode(',',$_POST["ORDERID"])])
    ->execute();
             $this->request->getSession()->delete('CART');


return $this->redirect(     ['controller' => 'Cart', 'action' => 'thankyou']      );
      
}else{

return $this->redirect(
     ['controller' => 'Cart', 'action' => 'failure']
      );
}

	}
	else {
		echo "<b>Transaction status is failure</b>" . "<br/>";
return $this->redirect(
     ['controller' => 'Cart', 'action' => 'failure']
      );
	}

	
	

}
else {
	return $this->redirect(
     ['controller' => 'Cart', 'action' => 'cancel']
      );
}



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
    
                 $this->request->getSession()->delete('CART');

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
}
exit(0);
}

function thankyou()
{
   $this->viewBuilder()->setLayout('default');
$title = 'Thank you'.SITE_TITLE;
$orderId=$this->request->getSession()->read('tarns_booking_id');
$this->request->getSession()->delete('trans_discount_amount');
$this->request->getSession()->delete('tarns_delivery_amount');

$resProductInfo=$this->Transactions->find('all')->where(['trans_id IN '=>explode(',',$orderId)]);
$strProductName='';
foreach($resProductInfo as $rowProductInfo)
{
$rowProductInfos =$this->SkProduct->find('all')->where(' 1 AND product_id='.$rowProductInfo->trans_item_id)->first();
$strProductName .= $rowProductInfos->product_name.', ';
}

$rowUserInfo =  $this->request->getSession()->read('USER');

if($rowUserInfo->user_mobile!='')
{
  $strMessage = 'Confirmed: Order For '.$strProductName.' is successfully placed.It Will be dispatch as soon as possible.We will send you an SMS with tracking details when the package is dispatched.';
SmsHelper::sendSms($rowUserInfo->user_mobile,$strMessage);
}

}

function failure()
{
    
}
 
function updatetocartcouponbyname()
{
   $this->viewBuilder()->setLayout('ajax');
   $aryResponse =array();
   $couponCode=$_POST['promocode'];
   $amount=$_POST['totalAmount'];
   $proId=$_POST['productId'];
      $proqty=$_POST['productqty'];

   $strField =' 1 AND coupon_status=1 AND coupon_code=\''.$couponCode.'\' AND \''.date('Y-m-d').'\' BETWEEN coupon_active_from AND coupon_active_to ';
   
   
   
   $resCouponInfo=$this->Coupon->find('all',['conditions'=>[$strField]])->first();
   $rowUserInfo=$this->request->getSession()->read('USER');
		$userId=$rowUserInfo['user_firstname'];
  // print_r($resCouponInfo);
   
   if(isset($resCouponInfo->coupon_id) && 0<$resCouponInfo->coupon_id)
   { 
     if($resCouponInfo->coupon_apply_on==0)
	{
		/* This section is used for where no condition in Coupon */
    
          if($resCouponInfo->coupon_discount_mode=="1")
          {   /* This section is used for calculate the amount in Rupess */
	         
              $discountAmount=$resCouponInfo->coupon_discount;
              $actualAmount= $amount-$discountAmount;
              $aryResponse['actualAmount']=$actualAmount+$_POST['delvrycharge'];
              $aryResponse['discountAmount']=$discountAmount;
              
             		  			    $aryResponse['message']="ok";
                 $aryResponse['notification']=$couponCode." Coupon Code Successfully Applied.";

             
          }else{
        
         	  $maxDisAmount=$resCouponInfo->coupon_max_discount;
             $remainingPercent= 100-$resCouponInfo->coupon_discount;
             $actualAmount= $amount*$remainingPercent/100;
             $aryResponse['actualAmount']=$actualAmount+$_POST['delvrycharge'];
			 $totalDis=$amount-$actualAmount;
			 if($totalDis<$maxDisAmount)
			 {
             $aryResponse['discountAmount']=$amount-$actualAmount;
			 }
			 else{
                                   $actualAmount=$amount-$maxDisAmount;
 $aryResponse['actualAmount']=$actualAmount+$_POST['delvrycharge'];
				   $aryResponse['discountAmount']=$maxDisAmount;
			 }
                $aryResponse['notification']=$couponCode." Coupon Code Successfully Applied.";
			     $aryResponse['coupon_id']=$resCouponInfo->coupon_id;
		                 $aryResponse['notification']=$couponCode." Coupon Code Successfully Applied.";

       		  			    $aryResponse['message']="ok";

		  }

   }
  else if($resCouponInfo->coupon_apply_on==1)
   {
	   /* This section is used for where day condition in Coupon */
	   	   $aryResponse['message']="fail";
$aryResponse['notification'] ="Invalid Coupon Code";
   }
   else if($resCouponInfo->coupon_apply_on==2)
   {
	  
		   $aryResponse['message']="fail";
$aryResponse['notification'] ="Invalid Coupon Code";
	   
   }
    else if($resCouponInfo->coupon_apply_on==3)
   {
	   /* This section is used for where product condition in Coupon */
	   $data = $this->Coupon->find('all',array('conditions' => array('Coupon.coupon_code' => $couponCode ,'FIND_IN_SET(\''. $userId .'\',Coupon.coupon_discount_user)')));
	   if(0<count($data))
	   {
		   if($resCouponInfo->coupon_discount_mode=="1")
          {   /* This section is used for calculate the amount in Rupess */
	        
	         
              $discountAmount=$resCouponInfo->coupon_discount;
              $actualAmount= $amount-$discountAmount;
              $aryResponse['actualAmount']=$actualAmount+$_POST['delvrycharge'];
              $aryResponse['discountAmount']=$discountAmount;
			    
          }
		  if($resCouponInfo->coupon_discount_mode=="0")
          {
			   
			  $maxDisAmount=$resCouponInfo->coupon_max_discount;
             $remainingPercent= 100-$resCouponInfo->coupon_discount;
             $actualAmount= $amount*$remainingPercent/100;
             $aryResponse['actualAmount']=$actualAmount+$_POST['delvrycharge'];
			 $totalDis=$amount-$actualAmount;
			 if($totalDis<$maxDisAmount)
			 {
             $aryResponse['discountAmount']=$amount-$actualAmount;
			 }
			 else{
				   $aryResponse['discountAmount']=$maxDisAmount;
			 }
			    $aryResponse['message']="ok";
			    			    $aryResponse['coupon_id']=$resCouponInfo->coupon_id;

                $aryResponse['notification']=$couponCode." Coupon Code Successfully Applied.";
			
			
		 
       
		  }
	   }
	   else{
		   $aryResponse['message']="fail";
$aryResponse['notification'] ="Invalid Coupon Code";
	   }
	   

	  
	   
   }
   }
   else
   {
   
       $aryResponse['message']="fail";
$aryResponse['notification'] ="Invalid Coupon Code";
   }
   

   echo json_encode($aryResponse);
   exit();  
   

}
  function getshipping(){
    
    $addressId = $this->request->getData('state');
    if($addressId > 0){
        $tableRegObj = TableRegistry::get('sk_address_book');
        $sk_shipping = TableRegistry::get('sk_shipping');
        
        $getAllResults = $tableRegObj->find()->select(['ab_state'])->where(['ab_id' => $addressId])->first();   
        
        $queryJoin = $sk_shipping->find()->select(['sk_shipping.shipping_state','sk_shipping.shipping_rate'])->join([
            'table' => 'sk_state',
            'alias' => 'sks',
            'type' => 'INNER',
            'conditions' => 'sks.state_id = sk_shipping.shipping_state',
        ])->where(['sks.state_name'=>$getAllResults->ab_state])->first();
          $shippingRate = $queryJoin->shipping_rate;
        $totalShipping = 0;
        $CartInfo =  $this->request->getSession()->read('cart_items');
        foreach($CartInfo as $cartItems){
            foreach($cartItems as $sets){
                $totalShipping = $totalShipping+ ($sets['qty']*$sets['ItemInPack']*$shippingRate);
            }
        }
        echo $totalShipping;   
    }else{
       echo 0; 
    }
    exit;
  } 
}

