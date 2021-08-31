<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\View\Helper\RecursHelper;
use Cake\Datasource\ConnectionManager;
class SellerRegisterController extends AppController
{
    public function initialize()
	{
        parent::initialize();
        $this->loadModel('SkUser');
        $this->loadModel('SkSeller');
         $this->loadModel('SkUniqueIds');
        $rowAdminInfo = $this->rowAdminInfo = $this->request->getSession()->read('USER');
	}

    function index()
    { 
        $feedback =array();
        if($this->request->is(['POST'])) 
        {
            $aryPostData=$this->request->getdata(); 
            $aryPostData['seller_unique_id'] = self::getProductUnitId();;
            $feedback = $this->SkSeller->newEntity();
            $aryPostData['seller_status'] = 0;
            $feedback = $this->SkSeller->patchEntity($feedback,$aryPostData);
            if($this->SkSeller->save($feedback))
            { 
                $this->Flash->success(__('Thanks for registration with Unnati+, We will get back to you shortly.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Failed try again'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $strPageTitle = 'Seller Registration'; 
        $this->set(compact('strPageTitle'));
    }
    function getProductUnitId()
    { 
        $this->rowUniqueId = $this->SkUniqueIds->find('all')->where(['ui_id'=>2])->first();
        $intCurrentCounter =$this->rowUniqueId['ui_current']+1;
        $strCustomeId =$this->rowUniqueId['ui_prefix'].''. sprintf('%04d',$intCurrentCounter);
        $this->SkUniqueIds->updateAll(['ui_current'=>$intCurrentCounter],['ui_id'=>2]);
        return $strCustomeId;
    }
}