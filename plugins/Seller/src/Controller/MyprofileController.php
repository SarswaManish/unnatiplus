<?php  namespace Seller\Controller;
use Seller\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;

class MyprofileController extends AppController
 {
       public $STATES;
    public $CITIES;
      
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
	      $this->loadModel('Cities');
            $this->loadModel('SkState');
        $this->SkState->hasMany('Cities')->setForeignKey('state_id');
        $this->Cities->belongsTo('SkState')->setForeignKey('state_id');
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
        $strPageTitle='My Profile';
        $states = $this->SkState->find('all',['contain'=>'Cities','order'=>'SkState.state_name ASC'])->toArray();
        $cities = $this->Cities->find('all',['order'=>'cities_name ASC']);
        $rowSellerInfo =  $this->request->getSession()->read('SELLER');
        $this->set(compact('strPageTitle','rowSellerInfo','states','cities'));
     }
     function profileUpdateProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['seller_id'];
    
    	   $category = $this->SkSeller->get($intEditId, [
            'contain' => []
        ]);
    
    	
       if($this->request->is(['patch', 'post', 'put'])) 
        {
            if(isset($_FILES['profile_image_']['name']) && $_FILES['profile_image_']['name']!='')
            { 
                
             $filename =time().str_replace(' ','',$_FILES['profile_image_']['name']);
            $filename  =str_replace('&','',$filename);
            $acctualfilepath = SITE_UPLOAD_PATH.SITE_SELLER_IMAGE_PATH.$filename;
            move_uploaded_file($_FILES['profile_image_']['tmp_name'], $acctualfilepath);
            
            $aryPostData['profile_image'] = $filename;

            }
         if(!empty($_FILES['business_logo_']['name']))
        {
            $fileName = time().'_'.$_FILES['business_logo_']['name'];
            $uploadPath = SITE_UPLOAD_PATH.SITE_SELLER_IMAGE_PATH;
            $uploadFile = $uploadPath.$fileName;
            if(move_uploaded_file($_FILES['business_logo_']['tmp_name'],$uploadFile))
            {
                $aryPostData['business_logo'] =$fileName;
            }
        }
    	 $aryPostData['seller_password'] = $aryPostData['seller_password'];
    	    $category=$this->SkSeller->patchEntity($category,$aryPostData);
    	    if($this->SkSeller->save($category))
    	    {
    	        $this->Flash->success(__('The Profile Updated Successfully.'));
    	         $rowAdminInfo = $this->SkSeller->find('all')->where(['seller_id'=>$intEditId])->first();
            	 $this->getRequest()->getSession()->write('SELLER',$rowAdminInfo);

    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Profile could not be saved. Please, try again.'));
    	    
    	    
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
    
       public function getCities($id)
    {
        $id = trim($id);
        $cities_array = $this->Cities->find('all',['order'=>'cities_name ASC'])->where(['state_id'=>$id]);
        $output='<option value="">Select City</option>';
        $output.='<option value="any">Any City</option>';
        foreach($cities_array as $k=>$v)
        {
            $output.='<option value="'.$v->cities_id.'">'.$v->cities_name.'</option>';
        }
        echo $output;exit;
    }
       private function setData()
    {
        $cities = $this->Cities->find('all');
        $states = $this->SkState->find('all');
        foreach($cities as $k=>$v)
        {
            $this->CITIES[$v->cities_id] = $v->cities_name;
        }
        foreach($states as $k=>$v)
        {
            $this->STATES[$v->state_id] = $v->state_name;
        }
        return;
    }
    
 }
 

 


