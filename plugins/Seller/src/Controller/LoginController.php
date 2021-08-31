<?php  namespace Seller\Controller;
use Seller\Controller\AppController;
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
	      $this->loadModel('SkSeller');
	     $rowAdminInfo =$this->getRequest()->getSession()->read('SELLER');
	     if(SecurityMaxHelper::checkAdminLogin($rowAdminInfo['seller_id']))
	     {
	          return $this->redirect(SITE_URL.'seller/dashboard');
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
 
      $rowAdminInfo=$this->SkSeller->find('all')->where(' 1 AND seller_email=\''.$aryPostData['user_email'].'\' AND  seller_password = \''.$aryPostData['user_password'].'\'')->first();
      if(isset($rowAdminInfo->seller_id)>0)
    	{
    	 $aryResponse['message']='ok';
    	 $session=$rowAdminInfo;
    	 $this->getRequest()->getSession()->write('SELLER',$session);
    	}else{
        $aryResponse['message'] ='failed';
        }
        echo   json_encode($aryResponse);
        exit();
    }
 }