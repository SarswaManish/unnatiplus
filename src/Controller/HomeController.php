<?php namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\View\Helper\RecursHelper;
use Cake\View\Helper\G99emailHelper;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
class HomeController extends AppController
{
    public $intUserId=0;
    public $chachearray = '';
    public $rowUniqueId =array();
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('SkUser');
        $this->loadModel('SkProduct');
        $this->loadModel('SkSlider');
        $this->loadModel('SkCategory');
        $this->loadModel('SkCart');
        $this->loadModel('SkProductbusinessprice');
        $this->loadModel('SkEnquiry');
        $this->loadModel('SkNewsletter');
        $this->loadModel('SkBrand');
        $this->loadModel('SkTag');
        $this->loadModel('SkUnit');
        $this->loadModel('SkWishlist');
        $this->loadModel('SkUniqueIds');
        $this->loadModel('SkCustomerView');
        $this->rowAdminInfo = $this->request->getSession()->read('USER');
        if(isset($this->rowAdminInfo['user_id']))
        {
            $this->intUserId = $this->rowAdminInfo['user_id'];
        }
	                     
        if(isset($_COOKIE['PRODUCT_CACHE'])) 
        {
            $this->chachearray = $_COOKIE['PRODUCT_CACHE'];
        }
        
         header("Access-Control-Allow-Origin: *");
        
        /*if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {
           
        }*/
    }

    function index()
    {
        $this->SkProduct->hasOne('SkWishlist')->setForeignKey(['wish_product_id'])->setBindingKey(['product_id'])->setConditions(['wish_user_id' => $this->intUserId]);
        $resSlider = $this->SkSlider->find('all')->where(['AND' =>['slider_type'=>2,'slider_status'=>1]]);
        $resBrand = $this->SkBrand->find('all')->where(['AND' =>['brand_status'=>1]]);
        $resFeedbackInfo = $this->SkCustomerView->find('all')->where(['AND' =>['customer_status'=>1]])->toArray();
        //pr($resFeedbackInfo);die;
        $resBottomSlider = $this->SkSlider->find('all')->where(['AND' =>['slider_type'=>3,'slider_status'=>1]])->first();
        $resProductData = $this->SkProduct;
        
        $resTagList =$this->SkTag->find('all')->where(['tag_status'=>1,'tag_show_menu'=>1]);
      
        if($this->chachearray!='')
        {
            $resRecentlyViewdProduct = $this->SkProduct->find('all',['contain'=>['SkWishlist']])->where(['product_status'=>1,'product_id IN'=>explode(',',$this->chachearray)]);
        }else{
            $resRecentlyViewdProduct = $this->SkProduct->find('all')->where(['product_id'=>0]);
        }
        $strPageTitle=SITE_TITLE;
        $this->set(compact('strPageTitle','resFeedbackInfo','resBrand','resBottomSlider','resSlider','resProductData','resTagList','resProduct','resRecentlyViewdProduct'));
    }
    
    function wishlist()
    { 
        
        $aryResponse =array();
        if($this->request->is(['POST'])) 
        {
            $intProductId = $this->request->getData('ev');
            $aryResponse['message'] ='ok';
            $intCount =  $this->SkWishlist->find('all')->where(['wish_user_id'=>$this->intUserId,'wish_product_id'=>$intProductId])->count();
            if($intCount>0)
            {
                $aryResponse['status'] =0;
                $this->SkWishlist->deleteAll(['wish_user_id'=>$this->rowAdminInfo->user_id,'wish_product_id'=>$intProductId]);
            }else{
                $aryPostData  =array();
                $aryPostData['wish_user_id'] =$this->rowAdminInfo->user_id; 
                $aryPostData['wish_product_id'] =$intProductId; 
                $fav = $this->SkWishlist->newEntity();
                $fav = $this->SkWishlist->patchEntity($fav,$aryPostData);
                $this->SkWishlist->save($fav);
                $aryResponse['status'] =1;
            } 
        } else{
            $aryResponse['message'] ='failed';
        }
                    $aryResponse['total'] = $this->SkWishlist->find('all')->where(['wish_user_id'=>$this->intUserId])->count();


         echo json_encode($aryResponse);
         exit;
    }
    function resentotp()
    {
        $rowuser =  $this->getRequest()->getSession()->read('TEMP_USER');
        $user  =isset($rowuser->user_id)?$rowuser->user_id:0;
        $aryResponse = array();                 
        if($user>0)
        {
            $randomNum=rand(1000,9999);
            $article=$this->SkUser->find('all',['conditions'=>['user_id'=>$user]])->first();
            $postdata['user_id'] = $article['user_id'];
            $postdata['user_otp'] = $randomNum;
            //$postdata['user_status'] = 1;
            $updateuser = $this->SkUser->query();
            $updateuser->update()
                ->set(['user_otp' => $randomNum])
                ->where(['user_id' => $user])
                ->execute();
            $strMsg=$randomNum." is the OTP that you have reqested to login. Do not share your OTP with anyone.";
            SmsHelper::sendSms($article->user_mobile, $strMsg);
            $strNotificationMessage = 'OTP Resent to your registerd mobile number XXXXXX'.substr($article->user_mobile,6,10);
            $aryResponse['message']='ok';
            $aryResponse['notification']=$strNotificationMessage;
            $this->getRequest()->getSession()->write('TEMP_USER',$postdata);
        }else{
            $aryResponse['message']='failed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function registeruser()
    {
        //SecurityMaxHelper::encryptIt($aryPostData['user_password'])
        $this->request->allowMethod(['post']);
        $aryPostData =$this->request->getData();
        $rowAdminInfo=$this->SkUser->find('all')->where(' 1 AND  user_mobile = \''.$aryPostData['user_mobile'].'\'')->first();
        if(isset($rowAdminInfo->user_id) && $rowAdminInfo->user_id>0 && $rowAdminInfo->user_status==1)
    	{
            $aryResponse['message']='ok';
            $aryResponse['password_status']=1;
            $aryResponse['user_mobile'] = $rowAdminInfo->user_mobile;
            $aryResponse['notification']='Email/Mobile Already Exist';
            $this->getRequest()->getSession()->write('TEMP_USER',$rowAdminInfo);
           
    	}else if(isset($rowAdminInfo->user_id) && $rowAdminInfo->user_id>0 && $rowAdminInfo->user_status==0)
    	{
            $aryResponse['message'] ='ok';
            $aryPostData['user_status']=0;
            $aryPostData['user_otp']=rand(1000,9999);
            $aryResponse['password_status']=0;
            
            $aryResponse['user_id'] = $rowAdminInfo->user_id;
            $user = $this->SkUser->patchEntity($rowAdminInfo, $aryPostData);
            $this->SkUser->save($user);
            $this->getRequest()->getSession()->write('TEMP_USER',$user);
                            $aryResponse['notification']='OTP Sent To Your Register Mobile Number';

        }else{
            $strRandom = self::getUserUniqueId();
            $aryPostData['user_status'] = 0;
            $aryPostData['user_otp']=rand(1000,9999);
            $aryResponse['password_status']=0;
            
            $aryPostData['user_created_datetime'] = date('Y-m-d h:i:s');
            $aryPostData['user_unique_id'] = $strRandom;
            $user = $this->SkUser->newEntity();
            $user = $this->SkUser->patchEntity($user, $aryPostData);
            $postData=$this->request->getdata();
            if($this->SkUser->save($user)) 
            {
       
                $strMessage = $user->user_otp.' Is the one time password (OTP) to verify your phone number. Kindly do not share with anyone.';
                SmsHelper::sendSms($user->user_mobile,$strMessage);
                $aryResponse['message']='ok';
                $aryResponse['notification']='OTP Sent To Your Register Mobile Number';
                $aryResponse['user_id'] = $user->user_id;
                $this->getRequest()->getSession()->write('TEMP_USER',$user);
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Please Fill All Require Field';
            }    
        }
        echo   json_encode($aryResponse);
        exit();
    }
    /* This function is done by Harsh Lakhera 13/01/2020 */
    function getUserUniqueId()
    { 
        $this->rowUniqueId = $this->SkUniqueIds->find('all')->where(['ui_id'=>3])->first();
        $intCurrentCounter =$this->rowUniqueId['ui_current']+1;
        $strCustomeId =$this->rowUniqueId['ui_prefix'].''. sprintf('%04d',$intCurrentCounter);
        $this->SkUniqueIds->updateAll(['ui_current'=>$intCurrentCounter],['ui_id'=>3]);
        return $strCustomeId;
    }
    
    function userregister()
    {
        //SecurityMaxHelper::encryptIt($aryPostData['user_password'])
        $this->request->allowMethod(['post']);
        $aryPostData =$this->request->getData();
        $rowUserInfo = $this->getRequest()->getSession()->read('TEMP_USER');
       
        $rowUser = $this->SkUser->find('all')->where(' 1 AND  user_id='.$rowUserInfo['user_id'])->first();
        //$rowAdminInfo=$this->SkUser->find('all')->where(['user_otp'=>$rowUserInfo->user_otp])->first();
        if(isset($rowUser->user_id))
    	{
            $aryResponse['message'] ='ok';
            $aryPostData['user_status']=1;
            $user = $this->SkUser->patchEntity($rowUser, $aryPostData);
            $this->SkUser->save($user);
            $this->getRequest()->getSession()->write('USER',$user);
    	}else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Please Fill All Require Field';
        }  
        echo json_encode($aryResponse);
        exit();
    }
    
    function verifyotp()
    {
        $aryResponse =array();
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $postData = $this->request->getData();
            $rowUserInfo = $this->getRequest()->getSession()->read('TEMP_USER');
            
            if($rowUserInfo['user_otp'] == $postData['user_otp'])
            {
                $otp = $postData['user_otp'];
                $exists = $this->SkUser->get($rowUserInfo['user_id']);
                $aryPostData =array();
                $aryPostData['user_status'] = 0;
                $user = $this->SkUser->patchEntity($exists,$aryPostData);
                $this->SkUser->save($user);
                $exists = $this->SkUser->get($rowUserInfo['user_id']);
  
               /// $this->getRequest()->getSession()->write('USER',$exists);
                
                $aryResponse['message']='ok';
                $aryResponse['notification']='OTP Verify Successfully';
                $aryResponse['user_otp'] = $rowUserInfo['user_otp'];
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='OTP does not match';
                //$aryResponse['msg']=json_encode($rowUserInfo);
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
function checkpassword(){
        $aryResponse =array();
        $this->request->allowMethod(['post']);
        $aryPostData =$this->request->getData();
        $rowUserInfo =$this->getRequest()->getSession()->read('TEMP_USER');
       
        $rowPasswordInfo = $this->SkUser
                            ->find('all')
                            ->where(' 1 AND  user_password = \''.$aryPostData['user_pass'].'\' AND user_id=\''.$rowUserInfo['user_id'].'\'')
                            ->first();
       
        if(isset($rowPasswordInfo->user_id))    
        {
            $this->getRequest()->getSession()->write('USER',$rowPasswordInfo);
            if($this->Cookie->read('unique_session')){
                 $unique =  $this->Cookie->read('unique_session');  
            }
            $this->SkCart->updateAll(['cart_user_id'=>$rowPasswordInfo->user_id],['unique_code'=>$unique]);
            $aryResponse['message']='ok';
            $aryResponse['redirect_to']= $this->referer();
            $aryResponse['notification']='Verify Successfully';
        }else{
            $aryResponse['message']='failed';
             $aryResponse['redirect_to']= '';
            $aryResponse['notification']='Password does not match';
        }
        echo json_encode($aryResponse);
        exit;
}
function requestotp()
{
$aryResponse =array();
if ($this->request->is(['patch', 'post', 'put'])) 
{
$rowUserInfo =	 $this->getRequest()->getSession()->read('TEMP_USER');

if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
{

$strRandomOtp =rand(1000,9999);

$aryPostData =array();
$aryPostData['user_otp'] = $strRandomOtp;
$user = $this->SkUser->get($rowUserInfo->user_id);

$user = $this->SkUser->patchEntity($user,$aryPostData);

$this->SkUser->save($user);
$rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$rowUserInfo->user_id.'\'')->first();
$session=$rowUserInfo;
$this->getRequest()->getSession()->write('TEMP_USER',$session);

$strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$strRandomOtp.' DO NOT SHARE WITH ANYBODY';
SmsHelper::sendSms($rowUserInfo->user_mobile,$strMessage);
$aryResponse['message']='new';
$aryResponse['notification']='Invalid Credential';
$aryResponse['mobile_number']=$rowUserInfo->user_mobile;

}

}else{


$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';
$aryResponse['mobile_number']='';

}


echo json_encode($aryResponse);
exit;

}
    /*************Start Newsletter Function****************/
    function newsletter()
    {
        $this->loadModel('SkNewsletter');
        $aryResponse =array();
        $msg =array();
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $postData = $this->request->getData();
            $rowEmailInfo=$this->SkNewsletter->find('all')->where(' 1 AND  newsletter_email = \''.$postData['newsletter_email'].'\'')->first();
            if(!isset($rowEmailInfo->newsletter_email))
            {
                $user = $this->SkNewsletter->newEntity();
                $user = $this->SkNewsletter->patchEntity($user,$postData);
                $postData=$this->request->getdata();
                if($this->SkNewsletter->save($user))
                {
                    $email = new Email('default');
    					$email
    						->setFrom(['info@unnatiplus.com' => 'info@unnatiplus.com'])
    						->setTo($postData['newsletter_email'])
    						->setSubject('Welcome to Unnati+')
    						->setTemplate('formemail', 'formemail')
    						->setEmailFormat('html')
    						->setViewVars(array('msg' => $postData['newsletter_email']))
    						->send();
    				$aryResponse['message']='ok';
    				$aryResponse['notification']='Sent Successfully';
                }else {
                    $aryResponse['message']='failed'; 
                    $aryResponse['notification']='Invalid Credential';
                }
            }else{
                $aryResponse['message']='failed'; 
                $aryResponse['notification']='Email Id Already Subscribed';
            }
        }
        echo json_encode($aryResponse);
        exit;
    }
    /***************END********************/
    function logincheck(){
    $aryResponse =array();
    if ($this->request->is(['patch', 'post', 'put'])) {
    $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_mobile=\''.$this->request->getdata('phonenumber').'\'')->first();
    
    if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0 && $rowUserInfo->user_status==1)
    {
    $aryResponse['message']='ok';
    $session=$rowUserInfo;
    $this->getRequest()->getSession()->write('TEMP_USER',$session);
    $aryResponse['notification']='Login Successfully...';
    
    }else{
    $strRandomOtp =rand(1000,9999);
    
    $aryPostData =array();
    $aryPostData['user_otp'] = $strRandomOtp;
    $aryPostData['user_mobile'] = $this->request->getdata('phonenumber');
    if(isset($rowUserInfo->user_id) && $rowUserInfo->user_status==0)
    {
    $user = $this->SkUser->get($rowUserInfo->user_id);
    
    $user = $this->SkUser->patchEntity($user,$aryPostData);
    
    }else{
    $user =$this->SkUser->newEntity();
    
    $user = $this->SkUser->patchEntity($user,$aryPostData);
    }
    $this->SkUser->save($user);
    $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_mobile=\''.$this->request->getdata('phonenumber').'\'')->first();
    $session=$rowUserInfo;
    $this->getRequest()->getSession()->write('TEMP_USER',$session);
    
    $strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$strRandomOtp.' DO NOT SHARE WITH ANYBODY';
    SmsHelper::sendSms($this->request->getdata('phonenumber'),$strMessage);
    
    
    $aryResponse['message']='new';
    $aryResponse['notification']='Invalid Credential';
    }
    
    }else{
    
    
    $aryResponse['message']='failed';
    $aryResponse['notification']='Method Not Allowed';
    }
    
    
    echo json_encode($aryResponse);
    exit;
    
    }
    function loginUser(){
        $aryResponse =array();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND (user_email_id=\''.$this->request->getdata('username').'\' OR user_mobile=\''.$this->request->getdata('username').'\') AND user_password=\''.$this->request->getdata('password').'\' AND user_status=1')->first();
    
            if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0){
                $aryResponse['message']='ok';
                $session=$rowUserInfo;
                $this->getRequest()->getSession()->write('USER',$session);
                $aryResponse['notification']='Login Successfully...';
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Invalid Credential';
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function logout(){
        $this->getRequest()->getSession()->delete('USER'); 
        return $this->redirect(['action' => 'index']);
    }

    function contactusenquiry(){
        if ($this->request->is('post')) {
            $postdata = $_POST;
            $postdata['enquiry_datetime']=date('Y-m-d h:i:s');
            $user = $this->SkEnquiry->newEntity();
            $user = $this->SkEnquiry->patchEntity($user, $postdata);
            $this->SkEnquiry->save($user);
            $this->Flash->success(__('Thank you for contact us.'));
            return $this->redirect(SITE_URL.'contact-us');
        }
    }
    
    function newsletterenquiry(){
        if ($this->request->is('post')) {
            $postdata = $_POST;
            $postdata['newsletter_datetime']=date('Y-m-d h:i:s');
            $user = $this->SkNewsletter->newEntity();
            $user = $this->SkNewsletter->patchEntity($user, $postdata);
            $this->SkNewsletter->save($user);
            exit;
        }
    }

    function forgotpassword(){
    $aryResponse =array();
    if($this->request->is(['patch', 'post', 'put'])) 
    {
        $aryResponse['ssasa'] = $this->request->getdata('user_mobile');
       // pr($aryResponse['ssasa']);die();
        $strExtra =' 1 AND (user_email_id=\''.$this->request->getdata('user_mobile').'\')  AND user_status=1';
        $rowUserInfo = $this->SkUser->find('all')->where($strExtra)->first();
    
        if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
        {
            $randomHash = md5($rowUserInfo->user_email_id.$rowUserInfo->user_mobile.time());
            $updateuser = $this->SkUser->query();
            $updateuser->update()->set(['user_hash' => $randomHash ])->where(['user_id' =>$rowUserInfo->user_id])->execute();
        
            $strVerifyUrl = SITE_URL.'forgotpasswordlink/'.$randomHash;
            $strEmail=$rowUserInfo->user_email_id;
            $strUserName=$rowUserInfo->user_first_name;
            $headers = "From: info@unnatiplus.com";
            
            $strMsg = 'Reset your password, and we\'ll get you on your way.
            To change your Unnatiplus password, click here or paste the following link into your browser:'.$strVerifyUrl.' This link will expire in 24 hours, so be sure to use it right away.';
            //SmsHelper::sendSms($rowUserInfo->user_mobile, $strMsg);
            $strMessage = 'Reset your password, and we\'ll get you on your way.
            To change your Unnatiplus password, click here or paste the following link into your browser:
            <p>
            <a href="'.$strVerifyUrl.'" style="padding: 10px 30px;height: 50px;margin: 10px 0px;border-radius: 4px;border: 1px solid #2e8e71;
            background: #2e8e71;color: #fff;">Click Here</a>
            </p>
            <p>'.$strVerifyUrl.'</p>
            <p>This link will expire in 24 hours, so be sure to use it right away.</p>
            ';
            $aryResponse['message']='ok';
            $aryResponse['notification']='An email sent to your register email address. Please follow the email instruction.';
            G99emailHelper::sendTestEmail($strEmail,$strUserName,$strMessage,$headers);
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Invalid Email';
        }
    }else{
        $aryResponse['message']='failed';
        $aryResponse['notification']='Method Not Allowed';
    }
        echo json_encode($aryResponse);
        exit;
    } 
    
    function forgotpage($strhashLink){
        $strExtra =' 1 AND user_hash=\''.$strhashLink.'\'   AND user_status=1';
        $rowUserInfo = $this->SkUser->find('all')->where($strExtra)->first();
        if($rowUserInfo->user_id<=0){
            echo 'link expired';
            exit;
        }
        $this->set(compact('rowUserInfo'));
    }
    
    function changepassword(){
        $aryResponse =array();
        if($this->request->is(['patch', 'post', 'put'])) {
            $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$this->request->getdata('user_id').'\'')->first();
            if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0 ){
                $aryResponse['message']='ok';
                $aryResponse['notification']='Password Successfully Change';
                $this->SkUser->updateAll(['user_password'=>$this->request->getdata('confirm_password')],['user_id'=>$this->request->getdata('user_id')]);
                $this->Flash->success(__('Password Change Successfully.'));
                return $this->redirect(SITE_URL.'forgotpasswordlink/'.$rowUserInfo->user_hash);
            }else{
                $aryResponse['message']='failed';
                $aryResponse['notification']='Old Password Does Not Match';
            }
        }else{
            $aryResponse['message']='failed';
            $aryResponse['notification']='Method Not Allowed';
        }
        echo json_encode($aryResponse);
        exit;
    }
    
    function sendOtp(){
        $aryResponse = array();
        $strRandomOtp =rand(1000,9999);
        $user_id = $this->rowAdminInfo['user_id'];
        $updateuser = $this->SkUser->query();
        $updateuser->update()->set(['user_otp' => $strRandomOtp])->where(['user_id' => $user_id])->execute();
        $for_what  = 'to login';
        if(isset($_POST['for_what'])){
            $for_what = $_POST['for_what'];
        }
        $strMsg=$strRandomOtp." is the OTP that you have requested ".$for_what.". Do not share your OTP with anyone.";
        $sms = SmsHelper::sendSms($this->rowAdminInfo['user_mobile'], $strMsg);
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
}