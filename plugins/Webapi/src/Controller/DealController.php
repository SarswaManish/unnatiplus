<?php namespace Webapi\Controller;

use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;

class DealController extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
    $this->getEventManager()->off($this->Csrf);

}
public function initialize()
{
    parent::initialize();
    
    $this->loadModel('Admin.Deal');
       $this->loadModel('Admin.ProductImage');
 
}

public function index()
    {
      $strCurrentDateTime = date('Y-m-d 23:59:59');
      $strStartCurrentDateTime = date('Y-m-d 00:01:00');

     $resDealsList =$this->Deal->find("all")->where(" 1 AND deal_status=1 AND deal_startdate BETWEEN '$strStartCurrentDateTime' AND '$strCurrentDateTime' ");
     $countDealsList =$this->Deal->find("all")->where(" 1 AND deal_status=1 AND deal_startdate BETWEEN '$strStartCurrentDateTime' AND '$strCurrentDateTime' ")->count();

    $aryResponse =array();
if($countDealsList >0)
{
$aryResponse['message'] = 'ok';

foreach($resDealsList as $rowDealsList)
{
  $strExplode =explode(',',$rowDealsList['deal_product']);
$rowImageInfo = $this->ProductImage->find("all")->where(['pimage_base'=>1,'pimage_product_id IN'=>$strExplode])->first();
$rowDealsList['product_image'] =$rowImageInfo['pimage_file'];


$aryResponse['result'][] = $rowDealsList;
}

}else{

$aryResponse['message'] = 'failed';

}
echo json_encode($aryResponse);
exit;
    }
    
    
    
           
}