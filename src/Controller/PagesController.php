<?php namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;

class PagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadModel('SkHelpSupport');
        $this->loadModel('SkFaq');
    }
     
    function aboutus()
    {
        $strPageTitle="About Us";
        $this->set(compact('strPageTitle'));  
    }

    function specialoffer(){}
    
    function howtopurchase(){}
    
    function faq()
    {
        $resFaqInfo = $this->SkFaq->find('all',['order'=>['faq_id'=>'ASC']]);
        $strPageTitle="Faq";
        $this->set(compact('strPageTitle','resFaqInfo'));  
    }
   
    function termsandcondition($strApp='')
    {
        $strPageTitle="Terms & conditions";
        $this->set(compact('strPageTitle','strApp'));  
    }

    function helpandsupport($strApp='')
    {
        $hsInfo = array();
        if($this->request->is(['patch', 'post', 'put']))  
        {
            $aryPostData  =$this->request->getData(); 
            $hsInfo = $this->SkHelpSupport->newEntity();
            $hsInfo = $this->SkHelpSupport->patchEntity($hsInfo,$aryPostData);
            if($this->SkHelpSupport->save($hsInfo))
            { 
                $this->Flash->success(__('Sent Successfully.'));
                return $this->redirect(['action' => 'helpandsupport',$strApp]);
            }else{
                $this->Flash->error(__('Failed try again'));
                return $this->redirect(['action' => 'helpandsupport',$strApp]);
            }
        }
        $strPageTitle="Help & Support";
        $this->set(compact('strPageTitle','strApp'));  
    }
    
    function returnpolicy(){}
    
    function contactus()
    {
        $strPageTitle="Contact Us";
        $this->set(compact('strPageTitle'));  
    }
    function privacypolicy($strApp='')
    {
        $strPageTitle="";
        $this->set(compact('strPageTitle','strApp'));     
    }
   
    function shippingpolicy()
    {
        $strPageTitle="Shipping Policy";
        $this->set(compact('strPageTitle'));     
    }
    
    function cancellationandreturns()
    {
        $strPageTitle="Cancellation & Returns";
        $this->set(compact('strPageTitle'));     
    }

    function ajaxcreatecallbackgreques()
    {
        $aryResponse =array();
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $postData['rcb_fullname'] =$_POST['fullname'];
            $postData['rcb_mobile'] =$_POST['mobile'];
            $postData['rcb_date'] =date('Y-m-d h:i:s');
            $coupon= $this->SkRequestcallback->newEntity();
            $coupon= $this->SkRequestcallback->patchEntity($coupon, $postData);
            $this->SkRequestcallback->save($coupon);
            $aryResponse['message']='ok'; 
            $strMsg=' Thankyou for contact eapublications.Soon we will Contact you.';
            SmsHelper::sendSms($_POST['mobile'], $strMsg);
        }else{
            $aryResponse['message']='failed'; 
        }
        echo json_encode($aryResponse);
        exit;
    }
}
