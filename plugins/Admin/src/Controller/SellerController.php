<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class SellerController extends AppController
 {
    public $paginate = ['limit' => 100  ];
    public $STATES;
    public $CITIES;
    public $rowUniqueId =array();
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    
    public function initialize()
	{
        parent::initialize();
        $this->loadModel('SkTaxes');
        $this->loadModel('SkSeller');
        $this->loadModel('Cities');
        $this->loadModel('SkState');
        $this->loadModel('SkUniqueIds');
        $this->SkState->hasMany('Cities')->setForeignKey('state_id');
        $this->Cities->belongsTo('SkState')->setForeignKey('state_id');
        
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }
	}
	
    function index()
    {
        $this->SkSeller->belongsTo('Cities', [
            'foreignKey' => 'business_city', //for foreignKey
             'joinType' => 'LEFT' //join type
                ]);
        if($this->request->is('post'))
        {
           
           $arySessionData =array();
            if($this->request->getData('filter_keyword')!='')
            {
                $arySessionData['KEYWORD'] = $this->request->getData('filter_keyword');  
            }
            $this->getRequest()->getSession()->write('FILTER',$arySessionData); 
        }
        $rowFilterData =  $this->getRequest()->getSession()->read('FILTER');
        $strLoadConditrion =  ' 1 AND seller_status=1 ';
        if(isset($rowFilterData['KEYWORD']) && $rowFilterData['KEYWORD']!='')
        {
            $strLoadConditrion .= ' AND seller_fname LIKE \'%'.$rowFilterData['KEYWORD'].'%\' OR seller_lname LIKE \'%'.$rowFilterData['KEYWORD'].'%\' OR seller_phone LIKE \'%'.$rowFilterData['KEYWORD'].'%\' OR seller_email LIKE \'%'.$rowFilterData['KEYWORD'].'%\'';
           
        }
       
        $resSeller = $this->paginate($this->SkSeller->find('all',['contain'=>['Cities']])->where($strLoadConditrion));
      
       // $resSeller = $this->SkSeller->find('all');
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Manage Seller';
        $this->set(compact('strPageTitle','resSeller','rowFilterData'));
    }
     
    function reset()
    {
        $this->getRequest()->getSession()->delete('FILTER'); 
        return $this->redirect(SITE_URL.'admin/seller/');
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
    
    function addseller($intEditId=null,$strCopyStatus=null)
    {
         $aryPostData=array();
         $rowSellerInfo=array();
         if($intEditId>0)
         {
              $rowSellerInfo = $this->SkSeller->get($intEditId, [
            'contain' => []  ]);
         }
      
        $resSellerList = $this->SkSeller->find('all');
        $states = $this->SkState->find('all',['contain'=>'Cities','order'=>'SkState.state_name ASC'])->toArray();
        $cities = $this->Cities->find('all',['order'=>'cities_name ASC']);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Add Seller';
         $this->set(compact('strPageTitle','rowSellerInfo','resSellerList','states','cities'));
     
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
    
    function sellerProcessRequest()
    {
         
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
        //pr($aryPostData);
    	$intEditId =$aryPostData['seller_id'];
    	if($intEditId>0)
    	{
	        $category = $this->SkSeller->get($intEditId, ['contain' => [] ]);
	    }else{
            $strRandom = self::getProductUnitId();
            $category=$this->SkSeller->newEntity();   
            $aryPostData['seller_status']=1;
            $aryPostData['seller_unique_id']=$strRandom;
	    }
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
            if(isset($aryPostData['business_state'])&&count($aryPostData['business_state'])>0)
            {
                $user_states = [];
                foreach($aryPostData['business_state'] as $k=>$v)
                {
                    if($v!=""&&$v!='0')
                    {
                        $user_states[] = $v;
                    } else {
                        unset($aryPostData['user_city'][$k]);
                    }
                }
                $aryPostData['business_state'] = implode(', ',$user_states);
            }
            if(isset($aryPostData['business_city'])&&count($aryPostData['business_city'])>0)
            {
                $aryPostData['business_city'] = implode(', ',$aryPostData['business_city']);
            }
            $category=$this->SkSeller->patchEntity($category,$aryPostData);
    	    if($this->SkSeller->save($category))
    	    {
    	        $this->getRequest()->getSession()->write('SELLER',$category);
    	        $this->Flash->success(__('The Seller has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
	        $this->Flash->error(__('The Seller could not be saved. Please, try again.'));
	        return $this->redirect(['action' => 'index']);
	    }
    }
     
    function trash($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkTaxes->get($intTrashId);
        $aryPostData['tax_status'] = 2;
        $category =$this->SkTaxes->patchEntity($category,$aryPostData);
        if($this->SkTaxes->save($category))
        {
            $this->Flash->success(__('Tax Trash Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    function deletepermanently($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkSeller->get($intTrashId);
        if ($this->SkSeller->delete($category))
        {
            $this->Flash->success(__('The Manage Seller has been deleted'));
        } else{
            $this->Flash->error(__('The Manage Seller could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
 
    public function status($id=null)
    {
        $this->request->allowMethod(['get','post']);
        $category = $this->SkSeller->get($id);
        $aryPostData =array();
        if($category->get('seller_status')==1)
        {
            $aryPostData['seller_status'] = 0;
        } else{
            $aryPostData['seller_status'] = 1;
        }
        $category =$this->SkSeller->patchEntity($category,$aryPostData);
        if($this->SkSeller->save($category))
        {
            $this->Flash->success(__('Status Update Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }

	public function export()
	{
        $posts = $this->SkSeller->find('all')->toArray();
        //$this->setData();
        foreach($posts as $key=>$val)
        {
            $row['seller_id']           = ($val->seller_id!='')?$val->seller_id:0;   
        	$row['seller_fname']        = ($val->seller_fname!='')?$val->seller_fname:0;
        	$row['seller_lname']        = ($val->seller_lname!='')?$val->seller_lname:0;
        	$row['total_order']         = ($val->total_order!='')?$val->total_order:0;
        	$row['seller_status']       = ($val->seller_status!='')?$val->seller_status:0;
        	$row['seller_logo']         = ($val->seller_logo!='')?$val->seller_logo:0;
        	$row['seller_info']         = ($val->seller_info!='')?$val->seller_info:0;
        	$row['seller_email']        = ($val->seller_email!='')?$val->seller_email:0;
        	$row['seller_phone']        = ($val->seller_phone!='')?$val->seller_phone:0;
        	$row['seller_password']     = ($val->seller_password!='')?$val->seller_password:0;
        	$row['profile_image']       = ($val->profile_image!='')?$val->profile_image:0;
        	$row['business_name']       = ($val->business_name!='')?$val->business_name:0;
        	$row['business_phone']      = ($val->business_phone!='')?$val->business_phone:0;
        	$row['business_email']      = ($val->business_email!='')?$val->business_email:0;
        	$row['business_logo']       = ($val->business_logo!='')?$val->business_logo:0;
        	$row['business_address']    = ($val->business_address!='')?$val->business_address:0;
        	$row['business_state']      = ($val->business_state!='')?$val->business_state:0;
        	$row['business_city']       = ($val->business_city!='')?$val->business_city:0;
    	    $row['business_pincode']    = ($val->business_pincode!='')?$val->business_pincode:0;
            $records[] = $row;
        }
        $filename='SellerList.xls'; 
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

	    $heading = false;
		if(!empty($records))
	    foreach($records as $row) 
	    {
		    if(!$heading) 
		    {
	            echo implode("\t", array_keys($row)) . "\n";
	            $heading = true;
		    }
		    echo implode("\t", array_values($row)) . "\n";
	    } 
        exit;
	}

    /* This function is done by Harsh Lakhera 11/01/2020*/
    public function bulkaction()
    {
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $intBulkAction = $_POST['bulkaction'];
            if($intBulkAction>0)
            {
                $aryPostData =$_POST;
                $intBulkAction = $aryPostData['bulkaction'];
                if($intBulkAction==1)
                {
                    $this->SkSeller->deleteAll( ['seller_id IN' =>$aryPostData['seller_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->SkSeller->updateAll(['seller_status'=>'1'],['seller_id IN' =>$aryPostData['seller_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->SkSeller->updateAll(['seller_status'=>'0'],['seller_id  IN' =>$aryPostData['seller_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }
    
    /* This function is done by Harsh Lakhera 13/01/2020*/
    function getProductUnitId()
    { 
        $this->rowUniqueId = $this->SkUniqueIds->find('all')->where(['ui_id'=>2])->first();
        $intCurrentCounter =$this->rowUniqueId['ui_current']+1;
        $strCustomeId =$this->rowUniqueId['ui_prefix'].''. sprintf('%04d',$intCurrentCounter);
        $this->SkUniqueIds->updateAll(['ui_current'=>$intCurrentCounter],['ui_id'=>2]);
        return $strCustomeId;
    }

 }
 