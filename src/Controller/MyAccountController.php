<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\View\Helper\RecursHelper;

use Cake\Datasource\ConnectionManager;
class MyAccountController extends AppController
{

    public $STATES;
    public $CITIES;
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('SkUser');
        $this->loadModel('SkProduct');
        $this->loadModel('Transactions');
        $this->loadModel('SkSlider');
        $this->loadModel('SkAddressBook');
        $this->loadModel('Cities');
        $this->loadModel('SkState');
        $this->loadModel('SkCategory');
        $this->loadModel('SkProductReview');
        $this->loadModel('SkTag');
        $this->loadModel('SkProductbusinessprice');
        $this->loadModel('SkWishlist');
        $this
            ->SkState
            ->hasMany('Cities')
            ->setForeignKey('state_id');
        $this
            ->Cities
            ->belongsTo('SkState')
            ->setForeignKey('state_id');
        $rowAdminInfo = $this->rowAdminInfo = $this
            ->request
            ->getSession()
            ->read('USER');

        if (!isset($rowAdminInfo->user_id))
        {
            return $this->redirect(SITE_URL);
        }
    }

    function index()
    {

        if (isset($_POST['user_first_name']))
        {
            $aryPostData = $this
                ->request
                ->getData();
            $intEditId = $aryPostData['user_id'];

            $category = $this
                ->SkUser
                ->get($intEditId, ['contain' => []]);

            if (isset($_FILES['user_profile_']['name']) && $_FILES['user_profile_']['name'] != '')
            {

                $filename = time() . str_replace(' ', '', $_FILES['user_profile_']['name']);
                $filename = str_replace('&', '', $filename);
                $acctualfilepath = SITE_UPLOAD_PATH . SITE_PRODUCT_IMAGE_PATH . $filename;
                move_uploaded_file($_FILES['user_profile_']['tmp_name'], $acctualfilepath);

                $aryPostData['user_profile'] = $filename;

            }
            $category = $this
                ->SkUser
                ->patchEntity($category, $aryPostData);
            if ($this
                ->SkUser
                ->save($category))
            {
                $rowAdminInfo = $this
                    ->SkUser
                    ->find('all')
                    ->where(' 1 AND user_id=\'' . $this
                    ->request
                    ->getdata('user_id') . '\'')
                    ->first();
                $this->getRequest()
                    ->getSession()
                    ->write('USER', $category);
                $this
                    ->Flash
                    ->success(__('The Profile Updated Successfully.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $strPageTitle = "My Account";
        $this->set(compact('strPageTitle'));
    }

    function orders()
    {
        $this
            ->Transactions
            ->belongsTo('SkProduct', ['foreignKey' => 'trans_item_id', //for foreignKey
        'joinType' => 'INNER'
        //join type
        ]);
        $resUserInfo = $this
            ->request
            ->getSession()
          ->read('USER');
               $str = ' 1 AND trans_main_id=0 AND trans_user_id='.$resUserInfo->user_id.'  AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\')';

        $resTransactionList = $this
            ->Transactions
            ->find('all', ['contain' => 'SkProduct'])
            ->where($str)
            ->order(['trans_id' => 'DESC']);
        $resProductInfo = $this->SkProduct;
        $strPageTitle = 'All Orders';
        $this->set(compact('strPageTitle', 'resTransactionList', 'resProductInfo'));
    }
    function deliveredOrders()
    {

        $rowUserInfo = $this
            ->SkUser
            ->find('all')
            ->where(['user_id' => $this
            ->rowAdminInfo
            ->user_id])
            ->first();

        $strPageTitle = 'Delivered Orders';
        $this->set(compact('strPageTitle', 'resUserInfo'));
    }
    function canceledOrders()
    {

        $rowUserInfo = $this
            ->SkUser
            ->find('all')
            ->where(['user_id' => $this
            ->rowAdminInfo
            ->user_id])
            ->first();

        $strPageTitle = 'Canceled Orders';
        $this->set(compact('strPageTitle', 'resUserInfo'));
    }
    function returnedOrders()
    {

        $rowUserInfo = $this
            ->SkUser
            ->find('all')
            ->where(['user_id' => $this
            ->rowAdminInfo
            ->user_id])
            ->first();

        $strPageTitle = 'Returned Orders';
        $this->set(compact('strPageTitle', 'resUserInfo'));
    }

    function address()
    {
  $rowAdminInfo = $this->rowAdminInfo = $this
            ->request
            ->getSession()
            ->read('USER');
        if ($this->request->is(['patch', 'post', 'put'])){

            $postData = $this->request->getData();
          
            if ($postData['ab_id'] > 0){
                $coupon = $this->SkAddressBook->get($postData['ab_id'], ['contain' => []]);
            }else{
                $coupon = $this->SkAddressBook->newEntity();
            }
            $postData['ab_user_id'] =  $rowAdminInfo['user_id'];
            $rowCountData = $this->SkAddressBook->find('all')->where(['ab_user_id' => (int)$postData['ab_user_id']])->count();
            if ($rowCountData <= 0){
                $postData['ab_default'] = 1;
            }
            if ($postData['ab_city'] > 0){
                $rowCityInfo = $this->Cities->find('all')->where(['cities_id' => $postData['ab_city']])->first();
                $postData['ab_city'] = $rowCityInfo->cities_name;
            }
            if ($postData['ab_state'] > 0){
                $rowCityInfo = $this->SkState->find('all')->where(['state_id' => $postData['ab_state']])->first();
                $postData['ab_state'] = $rowCityInfo->state_name;
            }
           
            $coupon = $this->SkAddressBook->patchEntity($coupon, $postData);
            if ($this->SkAddressBook->save($coupon)){
                $this->Flash->success(__('The Address has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The Address could not be saved. Please, try again.'));

        }
        $rowUserInfo = $this->SkUser->find('all')->where(['user_id' => $this->rowAdminInfo->user_id])->first();
        $statesList = $this->SkState->find('all', ['contain' => 'Cities', 'order' => 'SkState.state_name ASC']);
        $strPageTitle = 'Manage Addresses';
        $this->set(compact('strPageTitle', 'resUserInfo', 'statesList'));
    }

    private function setData()
    {
        $cities = $this
            ->Cities
            ->find('all');
        $states = $this
            ->SkState
            ->find('all');
        foreach ($cities as $k => $v)
        {
            $this->CITIES[$v
                ->cities_id] = $v->cities_name;
        }
        foreach ($states as $k => $v)
        {
            $this->STATES[$v
                ->state_id] = $v->state_name;
        }
        return;
    }

    public function getCities($id)
    {
        $id = trim($id);
        $cities_array = $this
            ->Cities
            ->find('all', ['order' => 'cities_name ASC'])
            ->where(['state_id' => $id]);
        $output = '<option value="">Select City</option>';
        $output .= '<option value="any">Any City</option>';
        foreach ($cities_array as $k => $v)
        {
            $output .= '<option value="' . $v->cities_id . '">' . $v->cities_name . '</option>';
        }
        echo $output;
        exit;
    }

    function changepassword()
    {

        if (isset($_POST['old_password']))
        {
            $aryPostData = $this
                ->request
                ->getData();
            $intEditId = $aryPostData['user_id'];

            $category = $this
                ->SkUser
                ->get($intEditId, ['contain' => []]);
            if ($category->user_password != $aryPostData['old_password'])
            {

                $this
                    ->Flash
                    ->error(__('The old password does not match. Please, try again.'));
                return $this->redirect(['action' => 'index']);

            }
            else
            {
                $aryPostData['user_password'] = $aryPostData['new_password'];
                $category = $this
                    ->SkUser
                    ->patchEntity($category, $aryPostData);
                if ($this
                    ->SkUser
                    ->save($category))
                {
                    $this
                        ->Flash
                        ->success(__('Password Changed Successfully.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }

    public function removeWishlistItem($intTrashId)
    {
        $aryPostData = array();
        $this
            ->request
            ->allowMethod(['get']);
        $category = $this
            ->SkWishlist
            ->get($intTrashId);
        if ($this
            ->SkWishlist
            ->delete($category))
        {
            return $this->redirect(['action' => 'wish-list']);
        }
        else
        {
            return $this->redirect(['action' => 'wish-list']);
        }

    }

    function logout()
    {
        $this->getRequest()
            ->getSession()
            ->destroy('USER');
        return $this->redirect(SITE_URL);
        exit();
    }
    function wishList()
    {
        $this
            ->SkWishlist
            ->belongsTo('SkProduct', ['foreignKey' => 'wish_product_id', //for foreignKey
        'joinType' => 'INNER'
        //join type
        ]);

        $resWishList = $this
            ->SkWishlist
            ->find('all', ['contain' => ['SkProduct']], ['order' => ['wish_product_id ASC']])
            ->where(['wish_user_id' => $this
            ->rowAdminInfo->user_id]);
        //$this->SkWishlist->delete(['wish_user_id'=>$this->rowAdminInfo->user_id,'wish_product_id'=>$intProductId]);
        //pr($resWishList);
        $strPageTitle = 'Wish List';
        $this->set(compact('strPageTitle', 'resWishList'));
    }
    public function deleteAddress($intTrashId)
    {
        $aryPostData = array();
        $this
            ->request
            ->allowMethod(['get']);
        $category = $this
            ->SkAddressBook
            ->get($intTrashId);
        if ($this
            ->SkAddressBook
            ->delete($category))
        {
            $this
                ->Flash
                ->success(__('The address has been deleted'));
            return $this->redirect(['action' => 'manage-address']);
        }
        else
        {
            $this
                ->Flash
                ->error(__('The  could not be deleted. Please, try again.'));
            return $this->redirect(['action' => 'manage-address']);
        }

    }
}