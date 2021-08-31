<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;

class RecentHistoryController extends AppController
{
    public $paginate = ['limit' => 100  ];
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->getEventManager()->off($this->Csrf);
    }
    public function initialize()
	{
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadModel('SkWishlist');
        $this->loadModel('SkUser');
        $this->loadModel('SkProduct');
        $this->loadModel('SkCart');
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }
	}
	
    function cartHistory()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $this->SkCart->belongsTo('SkUser', [
            'foreignKey' => 'cart_user_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        $this->SkCart->belongsTo('SkProduct', [
            'foreignKey' => 'cart_product_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        $cartlistInfo = $this->paginate($this->SkCart->find('all',['contain'=>['SkUser','SkProduct']])->order(['cart_id'=>'DESC']))->toArray();
        $strPageTitle='Cart History';
        $this->set(compact('strPageTitle','cartlistInfo'));
    }
    function wishlistHistory()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $this->SkWishlist->belongsTo('SkUser', [
            'foreignKey' => 'wish_user_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        $this->SkWishlist->belongsTo('SkProduct', [
            'foreignKey' => 'wish_product_id', //for foreignKey
             'joinType' => 'INNER' //join type
                      ]);
        $wishlistInfo = $this->paginate($this->SkWishlist->find('all',['contain'=>['SkUser','SkProduct']])->order(['wish_id'=>'DESC']))->toArray();
        //pr($wishlistInfo);
        $strPageTitle='Wishlist History';
        $this->set(compact('strPageTitle','wishlistInfo'));
    }
    
    public function cartbulkaction()
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
                    $this->SkCart->deleteAll( ['cart_id IN' =>$aryPostData['cart_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'cartHistory']);
                }
                if($intBulkAction==2)
                {
                    $this->SkCart->updateAll(['cart_status'=>'1'],['cart_id IN' =>$aryPostData['cart_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'cartHistory']);
                }
                if($intBulkAction==3)
                {
                    $this->SkCart->updateAll(['cart_status'=>'0'],['cart_id  IN' =>$aryPostData['cart_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'cartHistory']);
                }
            }
        }else{
            self::sendfcm();
        }
    }
    
    public function wishlistbulkaction()
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
                    $this->SkWishlist->deleteAll( ['wish_id IN' =>$aryPostData['wish_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'wishlistHistory']);
                }
                if($intBulkAction==2)
                {
                    $this->SkWishlist->updateAll(['wish_status'=>'1'],['wish_id IN' =>$aryPostData['wish_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'wishlistHistory']);
                }
                if($intBulkAction==3)
                {
                    $this->SkWishlist->updateAll(['wish_status'=>'0'],['wish_id  IN' =>$aryPostData['wish_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'wishlistHistory']);
                }
            }
        }else{
            self::sendfcm();
        }
    }
    
    function deletecart($id=0){
        $category = $this->SkCart->get($id);
        $this->SkCart->delete($category);
        return $this->redirect(['action' => 'cartHistory']);
    }
    
    function deletewishlist($id=0){
        $category = $this->SkWishlist->get($id);
        $this->SkWishlist->delete($category);
        return $this->redirect(['action' => 'wishlistHistory']);
    }
    
}
 

 


