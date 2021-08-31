<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;
use Cake\Core\Configure;

class AddressbookController extends AppController
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
     $this->loadModel("SkAddressBook");
                $this->loadModel("SkState");
    $this->loadModel("Cities");
    $this->loadModel("SkShipping");

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
     if($this->request->is(['patch', 'post', 'put'])) 
{

 $connection = ConnectionManager::get('default');

  $strSelect ='SELECT * FROM sk_address_book   WHERE 1 AND ab_user_id='.$this->request->getData("ab_user_id");
$brandCout = $connection->execute($strSelect)->fetchAll('assoc');

if(count($brandCout)>0)
{
$aryResponse['message']='ok';

  
 foreach($brandCout as $rowAddressInfo)
 {
     $rowCityInfo = $this->SkState->find('all')->where(['state_name'=>$rowAddressInfo['ab_state']])->first();
         $rowShippingInfo = $this->SkShipping->find('all')->where(['shipping_state'=>$rowCityInfo->state_id])->first();
  $rowAddressInfo['shipping'] = $rowShippingInfo;
     $aryResponse['result'][]=$rowAddressInfo;

 }

$rowAddressBookInfo = $this->SkAddressBook->find("All")->where(['ab_user_id'=>$this->request->getData("ab_user_id"),'ab_default'=>1])->first();
$aryResponse['address_status'] =0;

if(isset($rowAddressBookInfo->ab_id) && $rowAddressBookInfo->ab_id>0)
{
$aryResponse['address_status']=1;
$aryResponse['address_result'] = $rowAddressBookInfo;
}



}else{
    
    
$aryResponse['message']='failed';
}
 $connection = ConnectionManager::get('default');
$strSelect ='SELECT * FROM sk_state ORDER BY state_name ASC';
$resMerchantListData = $connection->execute($strSelect)->fetchAll('assoc');
$aryResponse['states'] = $resMerchantListData;

$aryResponse['notification']='Please Wait,While Loading Data';
}else{

$aryResponse['message']='failed';
$aryResponse['message']='Method Not Allowed';

}
 echo json_encode($aryResponse);
exit;    
    }


    public function addaddress()
{
$aryResponse =array();
     if($this->request->is(['patch', 'post', 'put'])) 
{
$postData = $this->request->getData();
$intEditId =isset($postData['ab_id'])?$postData['ab_id']:0;
$rowCountBook = $this->SkAddressBook->find('all')->where(['ab_user_id'=>$postData['ab_user_id']])->count();
if($rowCountBook==0)
{
$postData['ab_default']=1;
}
if($intEditId>0)
{
$brand = $this->SkAddressBook->get($intEditId, ['contain' => []]);
}
else
{
$brand=$this->SkAddressBook->newEntity();
}

$brand=$this->SkAddressBook->patchEntity($brand,$postData);
if($this->SkAddressBook->save($brand))
{
$aryResponse['message'] = 'ok';
$aryResponse['notification'] = 'Addressbook Updated Successfully';
$brandCout = $this->SkAddressBook->find("all")->where(['ab_user_id'=>$this->request->getData("ab_user_id")])->toArray();

$aryResponse['result'] = $brandCout;


$rowAddressBookInfo = $this->SkAddressBook->find("All")->where(['ab_user_id'=>$this->request->getData("ab_user_id"),'ab_default'=>1])->first();
$aryResponse['address_status'] =0;

if(isset($rowAddressBookInfo->ab_id) && $rowAddressBookInfo->ab_id>0)
{
$aryResponse['address_status']=1;
$aryResponse['address_result'] = $rowAddressBookInfo;
}



}else{
$aryResponse['message'] = 'failed';
$aryResponse['notification'] = 'Some Error Occur';
}

}else{


$aryResponse['message'] = 'failed';
$aryResponse['notification'] = 'Methoid Not Allowed';
}
echo json_encode($aryResponse);
exit;
}

public function removeaddress()
{
$aryResponse =array();
     if($this->request->is(['patch', 'post', 'put'])) 
{
    $this->SkAddressBook->deleteAll(['ab_user_id'=>$this->request->getData("ab_user_id"),'ab_id'=>$this->request->getData("ab_id")]);

    if($this->request->getData("ab_default")==true)
    {
        $rowAddressBookInfo = $this->SkAddressBook->find("All")->where(['ab_user_id'=>$this->request->getData("ab_user_id"),'ab_default'=>0])->first();
        if(isset($rowAddressBookInfo->ab_id))
        {
$updatequery = $this->SkAddressBook->query();

    $updatequery->update()->set(['ab_default'=>'1'])->where(['ab_id'=>$rowAddressBookInfo->ab_id])->execute();
        }
        
    }
$aryResponse['message'] = 'ok';
$aryResponse['notification'] = 'Address Remove Successfully';
}else{

$aryResponse['message'] = 'failed';
$aryResponse['notification'] = 'Method Not Allowed';

}
echo json_encode($aryResponse);
exit;
}


function setDefaultAddress()
{
$aryResponse =array();
$intabId = $this->request->getData('ab_id');
$intUserId = $this->request->getData('user_id');
$updatequery = $this->SkAddressBook->query();
$updatequery->update()->set(['ab_default'=>'0'])->where(['ab_user_id'=>$intUserId])->execute();

$postData['ab_default']=1;
$brand = $this->SkAddressBook->get($intabId , ['contain' => []]);
$brand=$this->SkAddressBook->patchEntity($brand,$postData);
$this->SkAddressBook->save($brand);

$aryResponse['message']='ok';
echo json_encode($aryResponse);
exit;
}
 public function statelist()
{
     $connection = ConnectionManager::get('default');
 
   $strSelect ='SELECT * FROM sk_state ORDER BY state_name ASC';
$resMerchantListData = $connection->execute($strSelect)->fetchAll('assoc'); 
$aryResponse =array();
$aryResponse['message']='ok';
$aryResponse['result'] = $resMerchantListData;
echo json_encode($aryResponse);
exit;
}
  public function citylist()
{
    if($this->request->is('post'))
    {
     $connection = ConnectionManager::get('default');
$intabId = $this->request->getData('state_name');

     $strSelect ='SELECT * FROM cities WHERE 1 AND state_id= (SELECT state_id FROM sk_state WHERE 1 AND state_name=\''.$intabId.'\')';
$resMerchantListData = $connection->execute($strSelect)->fetchAll('assoc'); 
$aryResponse =array();
$aryResponse['message']='ok';
$aryResponse['result'] = $resMerchantListData;
}else{
 $aryResponse['message']='failed';

  
}
echo json_encode($aryResponse);
exit;
}
}