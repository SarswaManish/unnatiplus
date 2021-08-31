<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\View\Helper\SmsHelper;
use Cake\View\View;
use Cake\View\ViewBuilder;
use Cake\View\Helper\NumberToWordHelper;
use Cake\Core\Configure;

class OrderController extends AppController
{
    public $components = array('Admin.Mpdf');
    
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('SkUser');
        $this->loadModel('SkProduct');
        $this->loadModel('SkProductbusinessprice');
        $this->loadModel('Transactions');
        $this->loadModel('SkAddressBook');
        $this->loadModel('SkSize');
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }     
    }
	
    function index($strType='all')
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
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
        if($strType=='confirm')
        {
            $resTransList = $this->paginate($this->Transactions->find('all')->where(['1 AND trans_main_id=0 AND trans_status=1']));
        }
        if($strType=='pending')
        {
            $resTransList = $this->paginate($this->Transactions->find('all')->where(' 1 AND trans_main_id=0 AND trans_status!=2 AND trans_status=0 AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\')'));
        }
        if($strType=='dispatched')
        {
	        $resTransList = $this->paginate($this->Transactions->find('all')->where(' 1 AND trans_main_id=0 AND trans_status=3'));
        }
        if($strType=='all')
        {
    	    $resTransList = $this->paginate($this->Transactions->find('all')->where(['1 AND trans_main_id=0 AND trans_status!=2 AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\')']));
        }
        if($strType=='delivered')
        {
    	    $resTransList = $this->paginate($this->Transactions->find('all')->where(['1 AND trans_main_id=0 AND trans_status=4 ']));
        }
        $resUserInfo =$this->SkUser;
        $resProductInfo =$this->SkProduct;
        $resCountOrder = $this->Transactions;
        $this->set(compact('strPageTitle','resTransList','resUserInfo','resCountOrder','strType','resProductInfo'));
    }
     
    function orderdetail($intTransId)
    {

        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Order Detail';
        $rowTransactionInfo =$this->Transactions->find('all')->where(['trans_id'=>$intTransId])->first();
        $rowUserInfo =$this->SkUser->find('all')->where(['user_id'=>$rowTransactionInfo->trans_user_id])->first();
        $resProductObject = $this->SkProduct;
        $resSizeObject = $this->SkSize;
        //pr($resSizeObject);
        $rowAddressInfo =$this->SkAddressBook->find('all')->where(['ab_id'=>$rowTransactionInfo->trans_billing_address])->first();
        $this->set(compact('strPageTitle','rowTransactionInfo','rowUserInfo','resProductObject','rowAddressInfo','resSizeObject'));
    }
     
    function cancelorder($intTransId=0)
    {
        $this->request->allowMethod(['get']);
        $coupon= $this->Transactions->get($intTransId);
        $aryPostData['trans_status'] = 2;
        $coupon=$this->Transactions->patchEntity($coupon,$aryPostData);
        if($this->Transactions->save($coupon))
        {
            $rowUserInfo =$this->SkUser->find('all')->where(['user_id'=>$coupon->trans_user_id])->first();
            if($rowUserInfo->user_mobile!='')
            {
                $strMsg=" We Have Cancel Your from  one of your order ".$coupon->trans_id.". This message is to confirmed we have successfully cancelled the following order.";
                SmsHelper::sendSms($rowUserInfo->user_mobile, $strMsg);
            }
            $this->Flash->success(__('Order Canceled.'));
            return $this->redirect(['action' => 'index']);
        } 
    }
     
    function deliverorder($intTransId=0)
    {
        $this->request->allowMethod(['get']);
        $coupon= $this->Transactions->get($intTransId);
        $aryPostData['trans_status'] = 4;
        $aryPostData['trans_delivery_date'] = date('Y-m-d h:i:s');
        $aryPostData['trans_payment_status'] = 1;
        $coupon=$this->Transactions->patchEntity($coupon,$aryPostData);
        if($this->Transactions->save($coupon))
        {
            $this->Flash->success(__('Order Delivered.'));
            return $this->redirect(['action' => 'index']);
        } 
    }
    
    function returnrequestorder($intTransId=0){
        $this->request->allowMethod(['get']);
        $coupon= $this->Transactions->get($intTransId);
        $aryPostData['trans_status'] = 5;
        $coupon=$this->Transactions->patchEntity($coupon,$aryPostData);
        if($this->Transactions->save($coupon))
        {
            $this->Flash->success(__('Order Returned Requested.'));
            return $this->redirect(['action' => 'index']);
        } 
    }
    
    function returnorder($intTransId=0)
    {
        $this->request->allowMethod(['get']);
        $coupon= $this->Transactions->get($intTransId);
        $aryPostData['trans_status'] = 6;
        $coupon=$this->Transactions->patchEntity($coupon,$aryPostData);
        if($this->Transactions->save($coupon))
        {
            $this->Flash->success(__('Order Returned.'));
            return $this->redirect(['action' => 'index']);
        } 
    }
    
    function intransitorder($intTransId=0){
        $this->request->allowMethod(['get']);
        $coupon= $this->Transactions->get($intTransId);
        $aryPostData['trans_status'] = 7; 
        $coupon=$this->Transactions->patchEntity($coupon,$aryPostData);
        if($this->Transactions->save($coupon))
        {
            $this->Flash->success(__('Order status is set to intransit'));
            return $this->redirect(['action' => 'index']);
        } 
    }
     
    function cancelorderlist()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Cancel Order';
        $this->paginate = ['order' => ['trans_id' => 'DESC']];
        $resTransList = $this->paginate($this->Transactions->find('all')->where(['trans_status'=>2,'trans_main_id'=>0]));
        $resUserInfo =$this->SkUser;
        $resProductInfo =$this->SkProduct;
        $resCountOrder = $this->Transactions;
        $this->set(compact('strPageTitle','resTransList','resUserInfo','resCountOrder','strType','resProductInfo'));
    }
    function rejectorderlist()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Rejected Order';
        $this->paginate = ['order' => ['trans_id' => 'DESC']];
        $resTransList = $this->paginate($this->Transactions->find('all')->where([['1 AND trans_main_id=0 AND trans_status=0 AND ( trans_payment_status!=1 OR trans_method!=\'Cash on Delivery\')']]));
        $resUserInfo =$this->SkUser;
        $resProductInfo =$this->SkProduct;
        $resCountOrder = $this->Transactions;
        $this->set(compact('strPageTitle','resTransList','resUserInfo','resCountOrder','strType','resProductInfo'));
    }
     
    public function export() 
    {
        $conn = ConnectionManager::get('default');
        $delimiter = ",";
        $filename = "orders_" . date('Y-m-d') . ".csv";
        $f = fopen('php://memory', 'w');
        $fields = array('Date','Order Id', 'Customer Name', 'Customer Phone', 'Order Detail', 'Amount', 'Payment Status', 'Payment Method','Order Status');
        fputcsv($f, $fields, $delimiter);   
        $data =$conn->execute('SELECT * FROM transactions INNER JOIN sk_user ON user_id=trans_user_id WHERE 1  AND trans_main_id=0 AND trans_status!=2 AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\') ORDER BY trans_id Desc')->fetchAll('assoc');
        foreach($data as $row)
        {
            $resProductName =$conn->execute('SELECT GROUP_CONCAT(CONCAT(product_name,\' X \',trans_quantity) SEPARATOR \',\') as productname FROM transactions INNER JOIN sk_product ON product_id=trans_item_id WHERE 1  AND (trans_main_id='.$row['trans_id'].' OR trans_id='.$row['trans_id'].')')->fetch('assoc');
            $paymentstatus = ($row['trans_payment_status'] == '1')?'Confirm':'Pending';
            $deliverystatus =  ($row['trans_status']==1)?'Delivered':($row['trans_status']==3)?'Dispatched':'Pending';
            $lineData = array($row['trans_datetime'],'#'.$row['trans_id'], $row['user_first_name'].' '.$row['user_last_name'], $row['user_mobile'], $resProductName['productname'], $row['trans_amt'], $paymentstatus, $row['trans_method'],$deliverystatus);
            fputcsv($f, $lineData, $delimiter);
        }
        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
        exit;
    }
    public function invoice($intTransId) 
    {
        /*  
        Configure::write('CakePdf', [
        'engine' => 'CakePdf.DomPdfEngine',
        'margin' => [
        'bottom' => 15,
        'left' => 50,
        'right' => 30,
        'top' => 45
        ],
        'orientation' => 'landscape',
        'download' => true
        ]);
        */
        //App::import('vendor/MPDF57', 'mpdf.php');
        //     $this->viewBuilder()->setLayout('ajax');
        $strPageTitle='Order Detail';
        $rowTransactionInfo =$this->Transactions->find('all')->where(['trans_id'=>$intTransId])->first();
        $rowUserInfo =$this->SkUser->find('all')->where(['user_id'=>$rowTransactionInfo->trans_user_id])->first();
        $resProductObject = $this->SkProduct;
        $rowAddressInfo =$this->SkAddressBook->find('all')->where(['ab_id'=>$rowTransactionInfo->trans_billing_address])->first();
        /*	 
        $this->viewBuilder()->getOptions([
        'pdfConfig' => [
        'orientation' => 'portrait', 
        'download' => true,
        'filename' => 'Invoice_' . $rowTransactionInfo->trans_id
        ]
        ]);*/
        $this->set('rowAddressInfo', $rowAddressInfo);
        $this->set('rowUserInfo', $rowUserInfo);
        $this->set('rowTransactionInfo', $rowTransactionInfo);
        $this->set('resProductObject', $resProductObject);
        $this->set('rowAddressInfo', $rowAddressInfo);
        $this->set(compact('strPageTitle','rowTransactionInfo','rowUserInfo','resProductObject','rowAddressInfo'));
        //  $html=$view->render('invoice'); 
        //   $conn = ConnectionManager::get('default');
    }
       
    public function testpdf() 
    {
        // initializing mPDF
        $this->Mpdf->init();
        
        // setting filename of output pdf file
        $this->Mpdf->setFilename('file.pdf');
        
        // setting output to I, D, F, S
        $this->Mpdf->setOutput('D');
        
        // you can call any mPDF method via component, for example:
        $this->Mpdf->SetWatermarkText("Draft");
    }
    
    public function bulkaction()
    {
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $intBulkAction = $_POST['bulkaction'];
            if($intBulkAction>0)
            {
                $aryPostData =$_POST;
                $intBulkAction = $aryPostData['bulkaction'];
                if($intBulkAction==1)
                {
                    $this->Transactions->deleteAll( ['trans_id IN' =>$aryPostData['trans_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->Transactions->updateAll(['trans_status'=>'1'],['trans_id IN' =>$aryPostData['trans_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->Transactions->updateAll(['trans_status'=>'0'],['trans_id  IN' =>$aryPostData['trans_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }
}