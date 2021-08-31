<?php namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;

class MyprofileController  extends AppController
{
public function initialize()
{
    parent::initialize();
    $this->loadComponent('Csrf');
    $this->loadModel('Admin');
     $rowAdminInfo =   $this->request->getSession()->read('ADMIN');
        if($rowAdminInfo['admin_id']<=0)
        {
        return $this->redirect(
      ['controller' => 'Login', 'action' => 'index']
       );
        }
    
}

public function index($EditId = null)
    {
        $rowAdminInfo=$this->request->getSession()->read('ADMIN');
        $EditId = $rowAdminInfo['admin_id'];
        $this->viewBuilder()->setLayout('defaultAdmin');
        if($EditId>0)
{
    
        $admin = $this->Admin->get($EditId, ['contain' => []]);
		 if ($this->request->is(['patch', 'post', 'put'])) 
        { 
        $postdata =$this->request->getData();
      
          if(!empty ($_FILES['admin_image']['name']))
           {
               $fileName=$_FILES['admin_image']['name'];
               $uploadPath=SITE_UPLOAD_PATH.SITE_ADMIN_IMAGE_PATH;
               $uploadFile=$uploadPath.$fileName;
               if(move_uploaded_file($_FILES['admin_image']['tmp_name'],$uploadFile))
               {
                   $postdata['admin_image']=$fileName;
               }
           }else{
           
        $postdata['admin_image']= $admin->admin_image;
           }
        
            $admin = $this->Admin->patchEntity($admin, $postdata);
            if ($this->Admin->save($admin)) {
                $this->Flash->success(__('Profile has been successfully saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Profile could not be saved. Please, try again.'));
        }
         	$title ='My Profile | '.SITE_TITLE;
        $this->set(compact('title','admin'));
}
    }
	
}