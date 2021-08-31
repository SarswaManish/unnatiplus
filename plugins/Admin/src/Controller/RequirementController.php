<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\View\Helper\SecurityMaxHelper;

class RequirementController  extends AppController
{
    public $paginate = ['limit' => 100  ];
public function initialize()
{
    parent::initialize();
    $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
            {
            return $this->redirect(SITE_URL.'admin');
            }
        $this->loadModel('SkUser');
        $this->loadModel('SkFeedback');
        $this->loadModel('SkRequirement');
}

    public function index()
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	 $resCouponInfo = $this->paginate($this->SkRequirement->find('all'));
           	$strPageTitle ='Requirement';
    	         $this->set(compact('resCouponInfo','strPageTitle'));
    }
	
 
    public function userView($userId=null)
    {
    	$this->viewBuilder()->setLayout('sideBarLayout');
    	$rowUserInfo = $this->SkRequirement->find('all')->where(['req_id'=>$userId])->first();
        $strPageTitle ='Requirement view';
    	$this->set(compact('strPageTitle','rowUserInfo'));
    }

    
   
public function bulkaction()
{ 
    
    if ($this->request->is(['patch', 'post', 'put'])) 
        {
    $aryPostData =$_POST;
   $intBulkAction = $aryPostData['bulkaction'];
   
   if($intBulkAction==1)
   {
       
      
    $this->SkRequirement->deleteAll( [
        'req_id IN' =>$aryPostData['req_id']]);
     $this->Flash->success(__('The Requirement Deleted Successfully'));
    return $this->redirect(['action' => 'index']);
     
   }
   
    
        }
     
}


    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $coupon= $this->SkRequirement->get($id);
        if ($this->SkRequirement->delete($coupon)) 
        {            
            $this->Flash->success(__('The requirement has been deleted.'));
        } else {
            $this->Flash->error(__('The requirement could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
	public function export()
	{
        $posts = $this->SkRequirement->find('all')->toArray();
        //$this->setData();
        foreach($posts as $key=>$val)
        {
            $row['req_id'] = $val->req_id;   
        	$row['req_category'] = $val->req_category;
        	$row['req_quantity'] = $val->req_quantity;
        	$row['req_days'] = $val->req_days;
        	$row['req_price_min'] = $val->req_price_min;
        	$row['req_price_max'] = $val->req_price_max;
        	$row['req_image'] = $val->req_image;
        	$row['req_link'] = $val->req_link;
        	$row['req_desc'] = $val->req_desc;
        	$row['req_name'] = $val->req_name;
        	$row['req_email'] = $val->req_email;
        	$row['user_created_datetime'] = $val->user_created_datetime;
        	$row['req_mobile'] = $val->req_mobile;
        	$row['req_created_date'] = $val->req_created_date;
            $records[] = $row;
        } 
        $filename='RequirementList.xls'; 
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
}