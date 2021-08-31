<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class TaxesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('SkTaxes');
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }
    }

    function index()
    {
        $resTaxesList = $this->paginate($this->SkTaxes);
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Manage Taxes';
        $this->set(compact('strPageTitle','resTaxesList'));
    }

    function addtaxes($intEditId=null,$strCopyStatus=null)
    {
        $rowTaxInfo=array();
        if($intEditId>0)
        {
            $rowTaxInfo = $this->SkTaxes->get($intEditId, ['contain' => []  ]);
        }
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Add Tax';
        $this->set(compact('strPageTitle','rowTaxInfo'));
    }

    function taxProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
        $intEditId =$aryPostData['tax_id'];
        if($intEditId>0)
        {
            $category = $this->SkTaxes->get($intEditId, ['contain' => [] ]);
        }else{
            $category=$this->SkTaxes->newEntity();   
            $aryPostData['tax_status']=1;
            $aryPostData['tax_date_time']=date('Y-m-d h:i:s');
        }
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkTaxes->patchEntity($category,$aryPostData);
            if($this->SkTaxes->save($category))
            {
                $this->Flash->success(__('The tax has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tax could not be saved. Please, try again.'));
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
        $category = $this->SkTaxes->get($intTrashId);
        if ($this->SkTaxes->delete($category))
        {
            $this->Flash->success(__('The Tax has been deleted'));
        } else{
            $this->Flash->error(__('The Tax could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function status($id=null)
    {
        $this->request->allowMethod(['post','get', 'status']);
        $coupon= $this->SkTaxes->get($id);
        $aryPostData =$_POST;
        if($coupon->get('tax_status')==1)
        {
            $aryPostData['tax_status'] = 0;
        }else if($coupon->get('tax_status')==2)
        {
            $aryPostData['tax_status'] = 0;
        }else{
            $aryPostData['tax_status'] = 1;
        }
        $coupon=$this->SkTaxes->patchEntity($coupon,$aryPostData);
        if($this->SkTaxes->save($coupon))
        {
            $this->Flash->success(__('Status Update Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    /* This function is done by Harsh Lakhera 11/01/2020 */
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
                    $this->SkTaxes->deleteAll( ['tax_id IN' =>$aryPostData['tax_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->SkTaxes->updateAll(['tax_status'=>'1'],['tax_id IN' =>$aryPostData['tax_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->SkTaxes->updateAll(['tax_status'=>'0'],['tax_id  IN' =>$aryPostData['tax_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }    
}
