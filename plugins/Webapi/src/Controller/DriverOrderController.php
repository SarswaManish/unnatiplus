<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;
use Cake\View\Helper\SmsHelper;
use Cake\Filesystem\File;
use Admin\View\Helper\ManishdbHelper;
use Cake\View\Helper\PaytmHelper;

class DriverOrderController  extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
    $this->getEventManager()->off($this->Csrf);

}
public function initialize()
{
    parent::initialize();
    
    $this->loadModel('Admin.SkTransaction');
    $this->loadModel('Admin.SkTransactionDetail');
     $this->loadModel('Admin.SkProduct');
     $this->loadModel('Admin.Addressbook');
     $this->loadModel('Admin.User');
     $this->loadModel('Admin.Coupon');
          $this->loadModel('Admin.Seller');
          $this->loadModel('Admin.SkDriver');

if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {

  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}
}

public function index()
    {
        
       $rwws = file_get_contents('php://input');
          $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{

         $aryResponse['message']='ok';
         $aryResponse['notification']='Please Wait While Loading data';

          $aryPostData =json_decode($rwws);
$aryPostData =(array)$aryPostData;

$resTransactionList=$this->SkTransaction->find('all')->where(array('trans_driver_id'=>$aryPostData['driver_id']))->order(['trans_create_datetime'=>'DESC']);
$intTransactionList=$resTransactionList->count();
if($intTransactionList>0)
{
    $arrayData =array();
    $cnt=0;
foreach($resTransactionList as $rowTransactionList )
{
    
    
$rowProductImage = $this->SkTransactionDetail->find("all")->where(['td_trans_id'=>$rowTransactionList->trans_id]);
$rowSellerInfo=$this->Seller->find('all')->where(array('seller_id'=>$rowTransactionList->trans_type))->first();
$rowTransactionList['trans_create_datetime'] =date('d M Y @ h:i A',strtotime($rowTransactionList['trans_create_datetime']));
$rowTransactionList['trans_item'] = $rowProductImage;
$rowTransactionList['seller'] =$rowSellerInfo;
$rowTransactionList['seller_adress'] =$rowSellerInfo->se_store_address;
$rowUserInfo=$this->User->find('all')->where(array('user_id'=>$rowTransactionList->trans_user_id))->first();
$rowTransactionList['user'] =$rowUserInfo;

$rowTransactionList['seller_id'] =$rowSellerInfo->seller_id;
$rowTransactionList['seller_image'] =SITE_UPLOAD_URL.SITE_SELLER_IMAGE_PATH.$rowSellerInfo->seller_image;
$rowSellerInfo->seller_img_base_url=SITE_UPLOAD_URL.SITE_SELLER_IMAGE_PATH;
$rowTransactionList['seller']=$rowSellerInfo;
if($rowTransactionList->trans_order_status!=4)
{
    $cnt++;
if($cnt==1)
{
$arrayData['current'][]=$rowTransactionList ;
}else{
    $arrayData['requested'][] =$rowTransactionList;
    
}



}else{
    
    $arrayData['completed'][] =$rowTransactionList;
}
}
$aryResponse['result'] = $arrayData;
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
 


function updatestatusandlatlong()
{
$rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
$aryPostData =(array)$aryPostData;
    $aryResponse =array();
  if ($this->request->is(['post'])) 
{
$aryResponse['message']='ok';
$aryResponse['notification'] = 'Thank you fo rate us.';

if(isset($aryPostData['order_status']))
{
  if($aryPostData['order_status']==4)
  {
$query = $this->SkTransaction->query(); 
$query->update()->set(['trans_order_status'=>$aryPostData['order_status'],'trans_payment_status'=>1,'trans_lat'=>$aryPostData['trans_lat'],'trans_long'=>$aryPostData['trans_long']]) ->where(['trans_id' => $aryPostData['order_id']])->execute();
  }else{
      
   $query = $this->SkTransaction->query(); 
$query->update()->set(['trans_order_status'=>$aryPostData['order_status'],'trans_lat'=>$aryPostData['trans_lat'],'trans_long'=>$aryPostData['trans_long']]) ->where(['trans_id' => $aryPostData['order_id']])->execute();
    
  }
    
}else{
    
    
$query = $this->SkTransaction->query(); 
$query->update()->set(['trans_lat'=>$aryPostData['trans_lat'],'trans_long'=>$aryPostData['trans_long']]) ->where(['trans_id' => $aryPostData['order_id']])->execute();
  
}



$aryReponse['message'] ='ok';


}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Some Error Occure';
}
echo json_encode($aryResponse);
exit;
}

public function getorderdetailfortracking()
    {
      $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{

         $aryResponse['message']='ok';
         $aryResponse['notification']='Please Wait While Loading data';

$rowTransactionList=$this->SkTransaction->find('all')->where(array('trans_id'=>$this->request->getdata('order_id')))->first();
 $rowProductImage = $this->SkTransactionDetail->find("all")->where(['td_trans_id'=>$rowTransactionList->trans_id]);
$rowSellerInfo=$this->Seller->find('all')->where(array('seller_id'=>$rowTransactionList->trans_type))->first();
if($rowTransactionList->trans_driver_id>0)
{
$rowDriverInfo=$this->SkDriver->find('all')->where(array('driver_id'=>$rowTransactionList->trans_driver_id))->first();
$rowTransactionList->trans_create_datetime =date('d M Y @ h:i A',strtotime($rowTransactionList->trans_create_datetime));
$rowTransactionList['driver_name'] =$rowDriverInfo->driver_first_name.' '.$rowDriverInfo->driver_last_name;
$rowTransactionList['driver_image_url'] =SITE_UPLOAD_URL.SITE_DRIVER_IMAGE_PATH;
$rowTransactionList['driver_image'] ='';
}

$aryReponse['message'] ='ok';
$aryResponse['result']=$rowTransactionList ;

	}else{
$aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;    
    }
}