<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class ThemeSettingController extends AppController
 {
     public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
      }
      public function initialize()
	{
	     parent::initialize();
	      $this->loadModel('SkAdmin');
	      	      $this->loadModel('ThemeSetting');

	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index($intTagId=null)
     {
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Theme Setting';
          $rowThemeInfo =  $this->ThemeSetting->find('all')->first();
         $this->set(compact('strPageTitle','rowThemeInfo'));
     }
     function themeUpdateProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =1;
    
    	   $category = $this->ThemeSetting->get($intEditId, [
            'contain' => []
        ]);
    
    	
       if($this->request->is(['patch', 'post', 'put'])) 
        {
            
            	 if(isset($_FILES['theme_favicon_']['name']) && $_FILES['theme_favicon_']['name']!='')
            { 
                
 $filename =time().str_replace(' ','',$_FILES['theme_favicon_']['name']);
$filename  =str_replace('&','',$filename);
$acctualfilepath = SITE_UPLOAD_PATH.SITE_THEME_IMAGE_PATH.$filename;
move_uploaded_file($_FILES['theme_favicon_']['tmp_name'], $acctualfilepath);

$aryPostData['theme_favicon'] = $filename;

            }
            	 if(isset($_FILES['theme_logo_']['name']) && $_FILES['theme_logo_']['name']!='')
            { 
                
 $filename =time().str_replace(' ','',$_FILES['theme_logo_']['name']);
$filename  =str_replace('&','',$filename);
$acctualfilepath = SITE_UPLOAD_PATH.SITE_THEME_IMAGE_PATH.$filename;
move_uploaded_file($_FILES['theme_logo_']['tmp_name'], $acctualfilepath);

$aryPostData['theme_logo'] = $filename;

            }
            
            
    	    $category=$this->ThemeSetting->patchEntity($category,$aryPostData);
    	    if($this->ThemeSetting->save($category))
    	    {
    	        $this->Flash->success(__('The Theme Setting Updated Successfully.'));
    	        
                    if(isset($aryPostData['theme_reffer']))
                    {
                        
                     return $this->redirect(['action' => 'socialsetting']);
                    }else{
                         return $this->redirect(['action' => 'index']);
                    }
                    
    	       
    	    }
    	    $this->Flash->error(__('The Theme Setting could not be saved. Please, try again.'));
    	    
    	          if(isset($aryPostData['theme_reffer']))
                    {
                        
                     return $this->redirect(['action' => 'socialsetting']);
                    }else{
                         return $this->redirect(['action' => 'index']);
                    }

    	}
         
     }
     
 
 function socialsetting()
 {
              $this->viewBuilder()->setLayout('sideBarLayout');

      $strPageTitle='Social Setting';
          $rowThemeInfo =  $this->ThemeSetting->find('all')->first();
         $this->set(compact('strPageTitle','rowThemeInfo')); 
 }
    
 }
 