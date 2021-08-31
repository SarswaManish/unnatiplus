<?php  namespace Admin\Controller;
use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public function initialize()
	{
	     parent::initialize();
          $this->loadComponent('Csrf');
	      $this->loadModel('SkAdmin');
	      $this->loadModel('ThemeSetting');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	    //pr($rowAdminInfo);exit;
	    
      $rowThemeInfo =  $this->ThemeSetting->find('all')->first();
	    $this->set(compact('rowThemeInfo'));
  
	}
	
	 
}
 
      
     