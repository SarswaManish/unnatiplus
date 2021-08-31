<?php  namespace Seller\Controller;
use Seller\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;

class DashboardController extends AppController
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
	      $rowAdminInfo =$this->getRequest()->getSession()->read('SELLER');
	    //pr($rowAdminInfo);exit;
	     if(!isset($rowAdminInfo['seller_id']))
	     {
	          return $this->redirect(SITE_URL.'seller');
	     }

	}
	
     function index()
     {
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Dashboard | Ecommerce';
         $this->set(compact('strPageTitle'));
     }
     
     function logout()
     {
         $this->getRequest()->getSession()->delete('SELLER');
         return $this->redirect(SITE_URL.'seller');

     }
     
   
    
 }
 

 


