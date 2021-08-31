<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Utility\Security;
use  Cake\Event\Event;
class WishlistController  extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
$this->getEventManager()->off($this->Csrf);
}
public function initialize()
{
// * By Default Constructor    
parent::initialize();
$this->loadComponent('Csrf');
$this->loadModel('Admin.Product');
$this->loadModel('Admin.Wishlist');
$this->loadModel('Admin.ProductImage');
$this->loadModel('Admin.Transactions');

}
public function index()
{
$aryResponse=array();
if ($this->request->is(['patch', 'post', 'put'])) 
{
$resWishList=$this->Wishlist->find('all',['contain'=>['Product']])->where(['wishlist_user_id'=>$this->request->getData('wishlist_user_id')]);
$resWishListCount=$this->Wishlist->find('all',['contain'=>['Product']])->where(['wishlist_user_id'=>$this->request->getData('wishlist_user_id')])->count();
if($resWishListCount>0)
{
$aryResponse['message']='ok';

foreach($resWishList as $rowWishList)
{
$rowImageInfo = $this->ProductImage->find("all")->where(['pimage_base'=>1,'pimage_product_id'=>$rowWishList->product->product_id])->first();
$rowWishList['product_image']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowImageInfo['pimage_file'];


$intTotalRatingCount = $this->Transactions->find('all')->where(' 1 AND (trans_comment!=\'\' OR trans_rating>0) AND trans_status=1 AND trans_item_id='.$rowWishList->product->product_id)->count(); 
$intTotalRatingSum  =$this->Transactions->find('all',array('fields' => ['total'=> 'sum(Transactions.trans_rating)'], 'conditions'=>array(' 1 AND (trans_comment!=\'\' OR trans_rating>0) AND trans_status=1 AND trans_item_id='.$rowWishList->product->product_id)))->first();

$rowWishList['product_rating_count']= $intTotalRatingCount;
if($intTotalRatingCount>0)
{
$rowWishList['product_rating'] = number_format(($intTotalRatingSum->total/$intTotalRatingCount),1,'.','');
}else{
$rowWishList['product_rating']=0;

}
$rowWishList['product_order'] = $intTotalRatingCount;




$rowWishList['product_review_count'] = $intTotalRatingCount;

$intOffAmount  = $rowWishList->product->product_msp-$rowWishList->product->product_mrp;
$intOffPercent = ($intOffAmount/$rowWishList->product->product_msp)*100;
if($intOffPercent>0)
{
$rowWishList['percent_off_string'] = (int)$intOffPercent.' % Off';
}else{
$rowWishList['percent_off_string']="";

}


$aryResponse['wishlist_array'][]=$rowWishList;
$aryResponse['notification']='Result found';
}
}
else
{
$aryResponse['message']='Failed';
$aryResponse['notification']='Not Found';
}
}
else
{
$aryResponse['message']='Failed';
$aryResponse['notification']='Some error occur';
}
echo json_encode($aryResponse);
exit;
}
function addtowishlist()
{
$aryResponse=array();
if ($this->request->is(['patch', 'post', 'put'])) 
{
$wishlist = $this->Wishlist->newEntity();
$wishlist = $this->Wishlist->patchEntity($wishlist, $postData);
if ($this->Wishlist->save($wishlist)) 
{
$aryResponse['cart_count']=$this->Cart->find('all',['contain'=>['Product']])->where(['cart_device_id'=>$this->request->getData('cart_device_id'),'cart_user_id'=>$this->request->getData('cart_user_id')])->count();
$aryResponse['message']='Ok';
$aryResponse['notification']='Successfully added to Wishlist';
}
else
{
$aryResponse['message']='Failed';
$aryResponse['notification']='Some error occur';  
}
}else
{
$aryResponse['message']='Failed';
$aryResponse['notification']='Method Not Allowed';
}
echo json_encode($aryResponse);
exit;
}
function delete()
{
$aryResponse=array();
if ($this->request->is(['patch', 'post', 'put'])) 
{
$attribute = $this->Wishlist->get($this->request->getData('wishlist_id'));
if ($this->Wishlist->delete($attribute))
{
$aryResponse['message']='ok';
$aryResponse['notification']='Product remove from Wishlist successfully ';
} 
else 
{
$aryResponse['message']='failed';
$aryResponse['notification']='Some error occur'; }
}
else
{
$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';	
}
echo json_encode($aryResponse);
exit;
}
}