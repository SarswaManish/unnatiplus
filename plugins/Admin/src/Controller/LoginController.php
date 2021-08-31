<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Utility\Security;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;

/**********This Class Used To login Admin
 * And Developed By Manish Garg,
 * Created On 13-09-2018
 * model-Admin
***********/
class LoginController extends AppController
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
	      $this->loadModel('SkAdmin');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin/dashboard');
	     }

	}
     function index()
     {
        ///echo  SecurityMaxHelper::encryptIt('unnatiplus@2444');
        $strPageTitle='Login';
        $this->set(compact('strPageTitle'));
     }
     
     function forgot()
     {
         
         $strPageTitle='Forgot';
         $this->set(compact('strPageTitle'));
     }
    function loginAdminProcess()
    {
        
      $this->request->allowMethod(['post']);
      $aryPostData =$this->request->getData();
 
      $rowAdminInfo=$this->SkAdmin->find('all')->where(' 1 AND admin_status=1 AND (admin_login_email=\''.$aryPostData['user_email'].'\' OR admin_mobile_number=\''.$aryPostData['user_email'].'\') AND  admin_password = \''.SecurityMaxHelper::encryptIt($aryPostData['user_password']).'\'')->first();
      if(isset($rowAdminInfo->admin_id)>0)
    	{
    	 $aryResponse['message']='ok';
    	 $session=$rowAdminInfo;
    	 $this->getRequest()->getSession()->write('ADMIN',$session);
    	}else{
        $aryResponse['message'] ='failed';
        }
        echo   json_encode($aryResponse);
        exit();
    }
 }