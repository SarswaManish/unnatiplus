<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SmsHelper;
use  Cake\Event\Event;


class RegisterController extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
    $this->getEventManager()->off($this->Csrf);
}
public function initialize()
{
    parent::initialize();
    $this->loadComponent('Csrf');
        $this->loadModel('SkUser');

     $this->loadModel('ThemeSetting');
     $this->loadModel('Transactions');
          $this->loadModel('SkSlider');
                    $this->loadModel('SkDriver');
                    $this->loadModel('SkSeller');


    if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {

  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

}
function slider()
{
   

    $resSliderList=$this->SkSlider->find('all')->where(['slider_type'=>0]);
	    
	    $aryResponse =array();
	    $aryResponse['message']='ok';
	    $aryResponse['results']=$resSliderList;
	  	    $aryResponse['imageurl']=SITE_UPLOAD_URL.SITE_SLIDER_IMAGE_PATH;
  
	    echo json_encode($aryResponse);
	    exit();
    
}
public function index()
       {
      $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{
            
           $aryResponse['message']='ok';

          if($this->request->getdata('user_mobile')!='')
{

    $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_mobile=\''.$this->request->getdata('user_mobile').'\'')->first();


if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
{

if($rowUserInfo->user_status==0)
{

$strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$rowUserInfo->user_otp.' DO NOT SHARE WITH ANYBODY';
SmsHelper::sendSms($this->request->getdata('user_mobile'),$strMessage);
$aryResponse['message']='ok';
         $aryResponse['notification']='OTP Sent  To Your Register Mobile Number';
 $aryResponse['user_id'] = $rowUserInfo->user_id;
}else{
$strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$rowUserInfo->user_otp.' DO NOT SHARE WITH ANYBODY';
SmsHelper::sendSms($this->request->getdata('user_mobile'),$strMessage);
$aryResponse['message']='ok';
         $aryResponse['notification']='OTP Sent  To Your Register Mobile Number';
          $aryResponse['user_id'] = $rowUserInfo->user_id;


}

}else{
$aryPostData = $this->request->getdata();
$strRandomOtp =rand(1000,9999);
$aryPostData['user_otp'] = $strRandomOtp;
$aryPostData['user_created_datetime'] = date('Y-m-d h:i:s');

$user = $this->SkUser->newEntity();

$user = $this->SkUser->patchEntity($user, $aryPostData);
if ($this->SkUser->save($user)) 
{
$strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$strRandomOtp.' DO NOT SHARE WITH ANYBODY';
SmsHelper::sendSms($this->request->getdata('user_mobile'),$strMessage);
$aryResponse['message']='ok';
         $aryResponse['notification']='OTP Sent  To Your Register Mobile Number';
 $aryResponse['user_id'] = $user->user_id;

}else{
$aryResponse['message']='failed';
         $aryResponse['notification']='Please Fill All Require Field';

}
}
}else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Please Fill All Require Field';

}
        }else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

           }
//SmsHelper::sendSms('7610022611','test');

echo json_encode($aryResponse);
exit;       
        }



public function finalregister()
       {
      $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{
            
           $aryResponse['message']='ok';

          if($this->request->getData('user_id')>0)
{


    $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_email_id=\''.$this->request->getdata('user_email_id').'\'')->first();


if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
{
$aryResponse['message']='failed';
         $aryResponse['notification']='Email Already Registered';

}else{
$aryPostData = $this->request->getData();

if(isset($aryPostData['user_reff']) && $aryPostData['user_reff']!='')
{
$rowRefferedBy = $this->SkUser->find('all')->where(['user_share_code'=>$aryPostData['user_reff']])->first();   
if(isset($rowRefferedBy->user_id))
{
   $aryPostData['user_refer_user_id']  =$rowRefferedBy->user_id;
    
}else{
    $rowRefferedBy = $this->SkSeller->find('all')->where(['seller_unique_id'=>$aryPostData['user_reff'],'seller_type'=>1])->first();   
if(isset($rowRefferedBy->seller_id))
{
   $aryPostData['user_refer_seller_id']  =$rowRefferedBy->seller_id;
    
}
    
}
    
}
$rowUserInfo = $this->SkUser->get($this->request->getData('user_id'), [
            'contain' => []  ]);
$aryPostData['user_status']=1;
$user = $this->SkUser->patchEntity($rowUserInfo, $aryPostData);
if ($this->SkUser->save($user)) 
{
$rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$this->request->getData('user_id').'\'')->first();
         $aryResponse['notification']='Thank you for register with us';
 $aryResponse['results'] = $rowUserInfo;

}else{
$aryResponse['message']='failed';
         $aryResponse['notification']='Please Fill All Require Field';

}
}
}else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Please Fill All Require Field';

}
        }else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

           }
//SmsHelper::sendSms('7610022611','test');

echo json_encode($aryResponse);
exit;       
        }

function verifyotp()
{
$aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
{
if($this->request->getdata('user_id')>0 && $this->request->getdata('user_otp')!='')
{

    $rowUserInfo = $this->SkUser->find('all')->where(['user_id'=>$this->request->getdata('user_id')])->first();
if($rowUserInfo->user_id>0 && $rowUserInfo->user_otp==$this->request->getdata('user_otp'))
{

$this->SkUser->updateAll(['user_otp_status'=>1],['user_id'=>$rowUserInfo->user_id]);
$aryResponse['message']='ok';
    $aryResponse['notification']='OTP Verify Successfully';
    $rowUserInfo = $this->SkUser->find('all')->where(['user_id'=>$this->request->getdata('user_id')])->first();

$aryResponse['results'] = $rowUserInfo;

}else{

 $aryResponse['message']='failed';
         $aryResponse['notification']='OTP does not match';

}

}else{

 $aryResponse['message']='failed';
         $aryResponse['notification']='Please Fill All Require Field';

}

}else{

$aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

}
echo json_encode($aryResponse);
exit;     

}

function resendotp()
{

$aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
{
    $rowUserInfo = $this->SkUser->find('all')->where(['user_id'=>$this->request->getdata('user_id')])->first();

$strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$rowUserInfo['user_otp'].' DO NOT SHARE WITH ANYBODY';
SmsHelper::sendSms($rowUserInfo['user_mobile'],$strMessage);
$aryResponse['message']='ok';
         $aryResponse['notification']='OTP Resent To Your Register Mobile Number';
}else{
$aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

}

echo json_encode($aryResponse);
exit;     
}

function loginUser()
{
$aryResponse =array();
if ($this->request->is(['patch', 'post', 'put'])) 
{
    $aryPostData =$this->request->getData();
      $strLoad  =' 1 AND  user_mobile=\''.$this->request->getData('user_mobile').'\'';
$rowUserInfo = $this->SkUser->find('all')->where($strLoad)->first();

if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
{
   
                $strRandomOtp =rand(1000,9999);
   

 $this->SkUser->updateAll(['user_otp'=>$strRandomOtp],['user_id'=>$rowUserInfo->user_id]);
$strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$strRandomOtp.' DO NOT SHARE WITH ANYBODY';
SmsHelper::sendSms($this->request->getdata('user_mobile'),$strMessage);
$rowUserInfo = $this->SkUser->find('all')->where($strLoad)->first();

$aryResponse['message']='ok';
 $aryResponse['notification']='Login Successfully...';
 $aryResponse['results'] = $rowUserInfo;
 

}else{
     $strRandomOtp =rand(1000,9999);
 
    $aryPostData = array();
    $aryPostData['user_mobile'] = $this->request->getdata('user_mobile');
$aryPostData['user_otp'] = $strRandomOtp;
$aryPostData['user_created_datetime'] = date('Y-m-d h:i:s');
$user = $this->SkUser->newEntity();
$user = $this->SkUser->patchEntity($user, $aryPostData);
$user = $this->SkUser->save($user) ;
$intUserId =$user->user_id;
 $rowUserInfo = $this->SkUser->find('all')->where(['user_id'=>$intUserId])->first();

$strMessage = 'Your one Time Password (OTP) for E-Comm registration/transaction is '.$strRandomOtp.' DO NOT SHARE WITH ANYBODY';
SmsHelper::sendSms($this->request->getdata('user_mobile'),$strMessage);


$aryResponse['results'] = $rowUserInfo;
   $aryResponse['message']='ok';
 }
}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';
}


echo json_encode($aryResponse);
exit;

}

function forgotpassword()
{

$aryResponse =array();
     if($this->request->is(['patch', 'post', 'put'])) 
{
$strExtra =' 1 AND (user_email_id=\''.$this->request->getdata('username').'\' OR user_mobile=\''.$this->request->getdata('username').'\')  AND user_status=1';
  	 $rowUserInfo = $this->SkUser->find('all')->where($strExtra)->first();
   
if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
{
	  $randomHash = md5($rowUserInfo->user_email_id.$rowUserInfo->user_mobile.time());
	    $updateuser = $this->SkUser->query();
       $updateuser->update()->set(['user_hash' => $randomHash ])->where(['user_id' =>$rowUserInfo->user_id])->execute();
	   
	   
	   $strVerifyUrl = SITE_URL.'forgotpasswordlink/'.$randomHash;
      $strEmail=$rowUserInfo->user_email_id;
	  $strUserName=$rowUserInfo->user_first_name;
	  
$strMsg = 'Reset your password, and we\'ll get you on your way.
To change your Rara spices password, click here or paste the following link into your browser:'.$strVerifyUrl.' This link will expire in 24 hours, so be sure to use it right away.';
        SmsHelper::sendSms($rowUserInfo->user_mobile, $strMsg);
	     $strMessage = 'Reset your password, and we\'ll get you on your way.
To change your Rara spices password, click here or paste the following link into your browser:
<p>
<a href="'.$strVerifyUrl.'" style="padding: 10px 30px;height: 50px;margin: 10px 0px;border-radius: 4px;border: 1px solid #2e8e71;
    background: #2e8e71;color: #fff;">Click Here</a>
</p>
<p>'.$strVerifyUrl.'</p>
<p>This link will expire in 24 hours, so be sure to use it right away.</p>
';
$aryResponse['message']='ok';
$aryResponse['notification']='An Email sent to your register mobile number.Please follow the email instruction';
//G99emailHelper::passwordresetemail($strEmail,$strUserName,$strMessage);


}else{



$aryResponse['message']='failed';
         $aryResponse['notification']='Invalid Email And Mobile Number';

}


}else{


$aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

}
echo json_encode($aryResponse);
exit;
} 

function changepassword()
{

$aryResponse =array();
     if($this->request->is(['patch', 'post', 'put'])) 
{
      $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$this->request->getdata('user_id').'\'')->first();

if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0 && $rowUserInfo->user_password==$this->request->getdata('user_old_password'))
{
$aryResponse['message']='ok';
$aryResponse['notification']='Password Successfully Change';

$this->SkUser->updateAll(['user_password'=>$this->request->getdata('user_new_password')],['user_id'=>$this->request->getdata('user_id')]);
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

  



function updateuserprofile()
{

$aryResponse =array();
     if($this->request->is(['patch', 'post', 'put'])) 
{
      $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$this->request->getdata('user_id').'\'')->first();

if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
{

$aryResponse['message']='ok';
$aryResponse['notification']='Profile Updated Successfully';
 $strImage = isset($_POST['image_data'])?'':'';
$sqlINsertExtra='';
if($strImage!='')
{
$strFileName = time().rand().'.jpeg';
$path = SITE_UPLOAD_PATH .'user_image/'.$strFileName;
file_put_contents($path,base64_decode($strImage));
$this->SkUser->updateAll(['user_first_name'=>$this->request->getdata('user_first_name'),'user_last_name'=>$this->request->getdata('user_last_name'),'user_email_id'=>$this->request->getdata('user_email_id'),'user_mobile'=>$this->request->getdata('user_mobile'),'user_profile_image'=>$strFileName],['user_id'=>$this->request->getdata('user_id')]);
}else{
    $this->SkUser->updateAll(['user_first_name'=>$this->request->getdata('user_first_name'),'user_last_name'=>$this->request->getdata('user_last_name'),'user_email_id'=>$this->request->getdata('user_email_id'),'user_mobile'=>$this->request->getdata('user_mobile')],['user_id'=>$this->request->getdata('user_id')]);
    
}
	 	


      $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$this->request->getdata('user_id').'\'')->first();
      
      
     if($rowUserInfo['user_profile_image']!='')
{
      $rowUserInfo['user_profile_image'] =SITE_UPLOAD_URL.'user_image/'.$rowUserInfo['user_profile_image'];
} 
      
$aryResponse['results']=$rowUserInfo;


}else{
$aryResponse['message']='failed';
$aryResponse['notification']='Your Login Session Expire'.$this->request->getdata('user_id');
}


}else{


$aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

}
echo json_encode($aryResponse);
exit;
}


function sharetext()
{
$aryResponse =array();
     if($this->request->is(['patch', 'post', 'put'])) 
{
$aryResponse['message'] = 'ok';
      $rowUserInfo = $this->SkUser->find('all')->where(' 1 AND user_id=\''.$this->request->getdata('user_id').'\'')->first();

$aryResponse['text_share_screen'] = 'Share The Code With Friend to get money in your wallet Share. The Code With Friend to get';
if($rowUserInfo->user_share_code=='')
{

$strRandomCode =strtoupper($this->createRandomPassword());
      $rowExtraUserInfo = $this->SkUser->find('all')->where(' 1 AND user_share_code=\''.$strRandomCode .'\'')->first();
if(isset($rowExtraUserInfo->user_id) && $rowExtraUserInfo->user_id>0)
{

$this->SkUser->updateAll(['user_share_code'=>$strRandomCode],['user_id'=>$this->request->getdata('user_id')]);

}else{

$this->SkUser->updateAll(['user_share_code'=>$strRandomCode],['user_id'=>$this->request->getdata('user_id')]);
}
$aryResponse['user_share_code'] = $strRandomCode;

}else{

$aryResponse['user_share_code'] = $rowUserInfo['user_share_code'];

}
}else{

$aryResponse['message']='failed';
$aryResponse['text_share_screen'] = 'Share The Code With Friend to get money   in your wallet Share. The Code With Friend to get';
$aryResponse['user_share_code'] = 'XXXXXXX';

}
$aryResponse['text_share_message'] = ' Try Unnati+, the app that deliver high quality product and delivery services to your door. Here\'s a referral code '.$aryResponse['user_share_code'].'  and use on registration. Get Rs20 credit in your account. Download the app now https://play.google.com/store/apps/details?id=com.unnatiplus&hl=en';

echo json_encode($aryResponse);
exit;

}

function createRandomPassword() { 

    $chars = "ABCDEFGHIJKLMNOPQURSTUVWXYZabcdefghijkmnopqrstuvwxyz"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 5) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 

}

function getuserprofile()
{

$aryResponse =array();
     if($this->request->is(['patch', 'post', 'put'])) 
{ 

$aryResponse['message']='ok';
$rowUserInfo =$this->User->find('all')->where(' 1 AND user_id=\''.$this->request->getdata('user_id').'\'')->first();
if($rowUserInfo['user_profile_image']!='')
{
      $rowUserInfo['user_profile_image'] =SITE_UPLOAD_URL.'user_image/'.$rowUserInfo['user_profile_image'];
}
$aryResponse['result']=$rowUserInfo;


}else{

$aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;


}

public function facebooklogincheck()
{
 $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{
$strLoad =' 1 AND user_facebook_id=\''.$this->request->getdata('user_facebook_id').'\' ';
             $rowUserInfo = $this->User->find('all')->where($strLoad)->first();

if(isset($rowUserInfo->user_id) && $rowUserInfo->user_status==1)
{
$aryResponse['message'] ='ok';
if($rowUserInfo['user_profile_image']!='')
{
      $rowUserInfo['user_profile_image'] =SITE_UPLOAD_URL.'user_image/'.$rowUserInfo['user_profile_image'];
}
$aryResponse['result'] = $rowUserInfo;
}else{
   
   if(isset($rowUserInfo->user_id) && $rowUserInfo->user_status==0)
{
    $aryResponse['message'] ='failed';

   $aryResponse['result'] = $rowUserInfo;
 
}else{
    $strRandomOtp =rand(1000,9999);
    $aryPostData = array();
    $aryPostData['user_facebook_id'] = $this->request->getdata('user_facebook_id');
$aryPostData['user_otp'] = $strRandomOtp;
$aryPostData['user_created_datetime'] = date('Y-m-d h:i:s');
$user = $this->User->newEntity();
$user = $this->User->patchEntity($user, $aryPostData);
$user = $this->User->save($user) ;
$intUserId =$user->user_id;
 $rowUserInfo = $this->User->find('all')->where(['user_id'=>$intUserId])->first();

$aryResponse['result'] = $rowUserInfo;



$aryResponse['message'] ='failed';

}
}
       }else{
$aryResponse['message'] ='failed';

    }
echo json_encode($aryResponse);
exit;  
}


public function googlepluslogincheck()
{
 $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{
$strLoad =' 1 AND user_googleplus_id=\''.$this->request->getdata('user_googleplus_id').'\'';
             $rowUserInfo = $this->User->find('all')->where($strLoad)->first();

if(isset($rowUserInfo->user_id)  && $rowUserInfo->user_status==1)
{
$aryResponse['message'] ='ok';
if($rowUserInfo['user_profile_image']!='')
{
      $rowUserInfo['user_profile_image'] =SITE_UPLOAD_URL.'user_image/'.$rowUserInfo['user_profile_image'];
}

$aryResponse['result'] = $rowUserInfo;
}else{
   if(isset($rowUserInfo->user_id) && $rowUserInfo->user_status==0)
{
    $aryResponse['message'] ='failed';

   $aryResponse['result'] = $rowUserInfo;
 
}else{  
     $strRandomOtp =rand(1000,9999);
    $aryPostData = array();
    $aryPostData['user_googleplus_id'] = $this->request->getdata('user_googleplus_id');
$aryPostData['user_otp'] = $strRandomOtp;
$aryPostData['user_created_datetime'] = date('Y-m-d h:i:s');
$user = $this->User->newEntity();
$user = $this->User->patchEntity($user, $aryPostData);
$user = $this->User->save($user) ;
$intUserId =$user->user_id;
 $rowUserInfo = $this->User->find('all')->where(['user_id'=>$intUserId])->first();

$aryResponse['result'] = $rowUserInfo;

$aryResponse['message'] ='failed';

}
}
       }else{
$aryResponse['message'] ='failed';

    }
echo json_encode($aryResponse);
exit;  
}
public function facebooklogin()
       {
      $aryResponse =array();
     if ($this->request->is(['patch', 'post', 'put'])) 
	{
         
           $aryResponse['message']='ok';

          if($this->request->getdata('user_email')!='' && $this->request->getdata('user_mobile_number')!='' && $this->request->getdata('user_password')!='')
{

    $rowUserInfo = $this->User->find('all')->where(' 1 AND (user_email=\''.$this->request->getdata('user_email').'\' OR user_mobile_number=\''.$this->request->getdata('user_mobile_number').'\')')->first();


if(isset($rowUserInfo->user_id) && $rowUserInfo->user_id>0)
{


 $aryResponse['message']='failed';
         $aryResponse['notification']='Email/Mobile Already Exist';



}else{
$aryPostData = $this->request->getdata();
$strRandomOtp =rand(1000,9999);
$aryPostData['user_status'] =1;
$aryPostData['user_otp'] = $strRandomOtp;
$aryPostData['user_created_datetime'] = date('Y-m-d h:i:s');
$user = $this->User->newEntity();
$user = $this->User->patchEntity($user, $aryPostData);
$user = $this->User->save($user) ;
$intUserId =$user->user_id;
 $rowUserInfo = $this->User->find('all')->where(['user_id'=>$intUserId])->first();

$aryResponse['result'] = $rowUserInfo;
         $aryResponse['notification']='Login Successfully';

}
}else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Please Fill All Require Field';

}
      

  }else{

         $aryResponse['message']='failed';
         $aryResponse['notification']='Method Not Allowed';

           }

echo json_encode($aryResponse);
exit;       
        }



}