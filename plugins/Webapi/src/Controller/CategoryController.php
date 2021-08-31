<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;
use App\View\Helper\ManishdbHelper;
class CategoryController  extends AppController
{
public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
$this->getEventManager()->off($this->Csrf);
}
public function initialize()
{
parent::initialize();
$this->loadComponent('Csrf');
$this->loadModel('SkCategory');
$this->loadModel('SkSlider');
$this->loadModel('Coupon');
$this->loadModel('SkBrand');
$this->loadModel('SkTag');
$this->loadModel('SkUnit');

$this->loadModel('SkProductbusinessprice');

 $this->loadModel('SkUserWallet');

  	      $this->loadModel('SkProduct');
 if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {

  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}
   $this->loadModel('SkProductbusinessprice');
  	      $this->loadModel('SkUnit');
}
public function index($intCatId =null)
{
$aryResponse =array();           
$resCatInfo = $this->Category->find('all')->where(' 1 AND category_parent=0 ');
$resCatInfoChild = $this->Category->find('all')->where(' 1 AND category_parent!=0 ');
$aryResponse['message']='ok';
$aryResponse['url']=SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH;
$aryResponse['result']=$resCatInfo;
$aryResponse['resultchild']=$resCatInfoChild;
echo json_encode($aryResponse);
exit;
}
public function brand($intCatId =null)
{
$aryResponse =array();           
$resCatInfo = $this->SkBrand->find('all')->where(['brand_status'=>1]);
 $aryResponse['message']='ok';
$aryResponse['url']=SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH;
$aryResponse['result']=$resCatInfo;
 echo json_encode($aryResponse);
exit;
}
public function categorywithchild()
{
$aryResponse =array();    

$aryResponse['notification_count']=0;       
$resCatInfo = $this->Category->find('all')->where(' 1 AND category_parent=0 ');
$aryResponse['cart_count']=$this->Cart->find('all',['contain'=>['Product']])->where(' 1 AND (cart_device_id=\''.$this->request->getData('cart_device_id').'\' OR cart_user_id='.$this->request->getData('cart_user_id').')')->count();

foreach($resCatInfo  as $roCategoryInfo)
{
$resCatInfoChild = $this->Category->find('all')->where(' 1 AND category_parent='.$roCategoryInfo->category_id);
$roCategoryInfo['child'] = $resCatInfoChild;
$aryResponse['result'][]=$roCategoryInfo;

}
$aryResponse['message']='ok';
$aryResponse['url']=SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH;
echo json_encode($aryResponse);
exit;
}
public function categoryproduct()
{
$aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{     
$intCategoryId = $this->request->getdata('category_id');
$intbrandId = $this->request->getdata('brand_id');
 $intTagId = $this->request->getdata('tag_id');

 
$aryResponse['url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;
$aryResponse['message']='ok';
$aryResponse['notification']='Successfull';
 $intCategoryId = $this->request->getData('category_id');
 if($intCategoryId>0)
 {
  $strSelect =' 1 AND product_status=1 AND FIND_IN_SET('.$intCategoryId.',product_category) ';
 }else if($intbrandId>0)
 {
    $strSelect =' 1 AND product_status=1 AND product_brand
 ='.$intbrandId;
   
 }else if($intTagId>0)
 {
   $strSelect =' 1 AND product_status=1 AND FIND_IN_SET('.$intTagId.',product_tag) ';

  }
  
$this->SkProduct->hasMany('SkProductbusinessprice', [
'foreignKey' => 'pu_product_id',
'sort'=>['SkProductbusinessprice.pu_net_price' => 'ASC']
]);

 $this->SkProductbusinessprice->belongsTo('SkUnit', [
'foreignKey' => 'pu_unit', //for foreignKey
'joinType' => 'INNER' //join type
]);

$resMerchantListData =$this->SkProduct->find('all',['contain'=>['SkProductbusinessprice'=>['SkUnit']]])->where($strSelect);


 

 $aryResponse['result']=$resMerchantListData;
}
else
{
$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';
}
echo json_encode($aryResponse);
exit;
}

public function brandproduct()
{
$aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{     
$intCategoryId = $this->request->getdata('brand_id');
 
 
$aryResponse['url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;
$aryResponse['message']='ok';
$aryResponse['notification']='Successfull';

   $strSelect =' 1 AND product_status=1 AND product_brand='.$intCategoryId;

$this->SkProduct->hasMany('SkProductbusinessprice', [
'foreignKey' => 'pu_product_id',
'sort'=>['SkProductbusinessprice.pu_net_price' => 'ASC']
]);

 $this->SkProductbusinessprice->belongsTo('SkUnit', [
'foreignKey' => 'pu_unit', //for foreignKey
'joinType' => 'INNER' //join type
]);

$resMerchantListData =$this->SkProduct->find('all',['contain'=>['SkProductbusinessprice'=>['SkUnit']]])->where($strSelect);


 


 $aryResponse['result']=$resMerchantListData;
}
else
{
$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';
}
echo json_encode($aryResponse);
exit;
}
public function searchProduct()
{
$aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{   
$strSearchVal = $this->request->getData('search_val');
if($strSearchVal!='')
{
$aryResponse['message']='ok';
$aryResponse['notification']='Result Found';

$strLoadCondition = ' 1 AND product_name LIKE \'%'.$strSearchVal.'%\'';
 $resPorductList =  $this->Product->find('all')->where($strLoadCondition);
if($resPorductList->count()>0)
{
$aryResponse['result'] = $resPorductList;

}else{
$aryResponse['message']='failed';
$aryResponse['notification']='No Result Found';


}
}else{

$aryResponse['message']='failed';
$aryResponse['notification']='No Result Found';
}
}
else
{
$aryResponse['message']='failed';
$aryResponse['notification']='Method Not Allowed';
}
echo json_encode($aryResponse);
exit;
}

public function searchProductFilter()
{
$aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{   
$strSearchVal = $this->request->getData('search_val');
$jsonData =json_decode($strSearchVal);
$intUserId = $this->request->getData('user_id');
if($strSearchVal!='')
{
$aryResponse['message']='ok';
$aryResponse['notification']='Result Found';
$arrayDataId =array();
foreach($jsonData as $key=>$label)
{
$strExplode =explode(',',$label->attr_option);
$strCondition= ' AND ( ';
foreach($strExplode as $k=>$l)
{
if($k!=0)
{
$strCondition .= ' OR  ';

}
$strCondition .= ' FIND_IN_SET(\''.$l.'\',pa_att_val) ';

}
$strCondition .=' ) ';


$strLoadCondition = ' 1 AND pa_att_key=\''.$label->attr_label.'\' '.$strCondition;
 $rowfindProductId = $this->Productattribute->find('all',array('fields'=>['groupid'=>' GROUP_CONCAT(pa_product_id) '],'conditions'=>array($strLoadCondition)))->first();
if($rowfindProductId->groupid!='')
{
$arrayDataId[] = $rowfindProductId->groupid;

}
}


if(count($arrayDataId)>0)
{
$strLoadCondition = ' 1 AND product_id IN('.implode(',',$arrayDataId).')';
 $resPorductList =  $this->Product->find('all')->where($strLoadCondition);




if($resPorductList->count()>0)
{

foreach($resPorductList as $rowCatInfo )
{
$rowImageInfo = $this->ProductImage->find("all")->where(['pimage_base'=>1,'pimage_product_id'=>$rowCatInfo->product_id])->first();

if(isset($rowImageInfo->pimage_file))
{
$rowCatInfo['product_image'] =$rowImageInfo->pimage_file;
}else{
$rowImageInfo = $this->ProductImage->find("all")->where(['pimage_base'=>0,'pimage_product_id'=>$rowCatInfo->product_id])->first();
if(isset($rowImageInfo->pimage_file))
{
$rowCatInfo['product_image'] =$rowImageInfo->pimage_file;
}else{
$rowCatInfo['product_image']='';

}

}





$intWhishlistInfo = $this->Wishlist->find('all')->where(['wishlist_user_id'=>$intUserId,'wishlist_product_id'=>$rowCatInfo->product_id])->count();
if($intWhishlistInfo >0)
{
$rowCatInfo['wishlist_status'] =1;
}else{
$rowCatInfo['wishlist_status'] =0;

}
$intTotalRatingCount = $this->Transactions->find('all')->where(' 1 AND (trans_comment!=\'\' OR trans_rating>0) AND trans_status=1 AND trans_item_id='.$rowCatInfo->product_id)->count(); 
$intTotalRatingSum  =$this->Transactions->find('all',array('fields' => ['total'=> 'sum(Transactions.trans_rating)'], 'conditions'=>array(' 1 AND (trans_comment!=\'\' OR trans_rating>0) AND trans_status=1 AND trans_item_id='.$rowCatInfo->product_id)))->first();

$rowCatInfo['product_rating_count']= $intTotalRatingCount;
if($intTotalRatingCount>0)
{
$rowCatInfo['product_rating'] = $intTotalRatingSum->total/$intTotalRatingCount;
}else{
$rowCatInfo['product_rating']=0;

}
$rowCatInfo['product_order'] = $intTotalRatingCount;
$aryResponse['result'][]=$rowCatInfo ;
}

}else{
$aryResponse['message']='failed';
$aryResponse['notification']='No Result Found';


}}else{
	
	
	
$aryResponse['message']='failed';
$aryResponse['notification']='No Result Found';
}
}else{

$aryResponse['message']='failed';
$aryResponse['notification']='No Result Found';
}
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