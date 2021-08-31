<?php namespace Webapi\Controller;

use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;

class FaqController extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
    $this->getEventManager()->off($this->Csrf);
}
public function initialize()
{
    parent::initialize();
    
	$this->loadModel('Faq');
    	$this->loadModel('SkNotification');
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
   $resBrandInfo=$this->Faq->find("all")->where(['faq_status'=>1]);

$aryResponse['message']='ok';
                 
    $aryResponse['result'] = $resBrandInfo;
    
    	        
echo json_encode($aryResponse);
exit;
    }
    
    function checkinternet()
{
exit;
}
   

function notification()
{
$aryResponse =array();

if ($this->request->is(['patch', 'post', 'put'])) 
{


$aryResponse['message']='failed';
 
$resNotification =$this->SkNotification->find('all')->where(['message_user_id'=>$this->request->getData("user_id")])->order(['message_datetime'=>'DESC']);

if($resNotification->count()>0)
{
$aryResponse['message']='ok';
$aryResponse['result'] = $resNotification;

}else{
$aryResponse['message']='failed';
$aryResponse['notification']='No Notification Yet';

}

}else{


$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';
}

echo json_encode($aryResponse);
exit;
} 
  function contactusenquiry()
{
$aryResponse =array();

if ($this->request->is(['patch', 'post', 'put'])) 
{
$coupon = $this->Contactus->newEntity();
$postData =$this->request->getData();
$postData['cu_datetime']=date('Y-m-d h:i:s');
$coupon = $this->Contactus->patchEntity($coupon,$postData);
$this->Contactus->save($coupon);

$aryResponse['message']='ok';
$aryResponse['notification']='Thankyou for contact with us.We feel free to support you.';
}else{

$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';

}
echo json_encode($aryResponse);
exit;

} 
 
function feedback()
{
$aryResponse =array();

if ($this->request->is(['patch', 'post', 'put'])) 
{
$coupon = $this->Feedback->newEntity();
$postData =$this->request->getData();
$postData['feedback_datetime']=date('Y-m-d h:i:s');
$coupon = $this->Feedback->patchEntity($coupon,$postData);
$this->Feedback->save($coupon);

$aryResponse['message']='ok';
$aryResponse['notification']='Thankyou for feedback';
}else{

$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';

}
echo json_encode($aryResponse);
exit;

}  

}