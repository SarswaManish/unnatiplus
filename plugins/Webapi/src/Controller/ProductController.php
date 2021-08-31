<?php namespace Webapi\Controller;
use Webapi\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use  Cake\Event\Event;
use Cake\ORM\TableRegistry;


class ProductController  extends AppController
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
  	      $this->loadModel('SkProduct');
 if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {

  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}
  	      $this->loadModel('SkWishlist');

  	      $this->loadModel('SkProductbusinessprice');
  	      $this->loadModel('SkUnit');
  	      $this->loadModel('SkSize');

}
public function onsaleproduct()
{
    $aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{
$rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
 $connection = ConnectionManager::get('default');

     
$strSelect =' 1 AND product_status=1 AND product_onsale=1 ';
    
 
 

$resMerchantListData =$this->SkProduct->find('all')->where($strSelect);

$aryResponse['message']='ok';
$aryResponse['product_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;


 $aryResponse['result'] =$resMerchantListData;


 
 

}else{
         $aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;
}
public function categoryproduct()
{
    $aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{
$rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
 $connection = ConnectionManager::get('default');

    if(isset($aryPostData->category_id))
    {
$strSelect =' 1 AND product_status=1 AND FIND_IN_SET('.$aryPostData->category_id.',product_category)';
    }else{
        
        $strSelect =' 1 AND product_status=1 AND FIND_IN_SET('.$aryPostData->brand_id.',product_brand)';

    }
 
 

$resMerchantListData =$this->SkProduct->find('all')->where($strSelect);

$aryResponse['message']='ok';
$aryResponse['product_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;


 $aryResponse['result'] =$resMerchantListData;


 
 

}else{
         $aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;
}

public function getproductsearch()
{
    $aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{
$rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
 $connection = ConnectionManager::get('default');

    if(isset($aryPostData->keyword) && $aryPostData->keyword!='')
    {
$strSelect =' 1 AND product_status=1 AND product_name LIKE \'%'.$aryPostData->keyword.'%\'';
    }else{
        
        $strSelect =' 1 AND product_id=0 ';

    }
 
 

$resMerchantListData =$this->SkProduct->find('all')->where($strSelect);

$aryResponse['message']='ok';
$aryResponse['product_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;


 $aryResponse['result'] =$resMerchantListData;


 
 

}else{
         $aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;
}
public function index()
{
    $aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{
$rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
 $connection = ConnectionManager::get('default');

    
$strSelect =' 1 AND product_status=1 AND product_id='.$aryPostData->product_id;
 
$this->SkProduct->hasMany('SkProductbusinessprice', [
'foreignKey' => 'pu_product_id',
'sort'=>['SkProductbusinessprice.pu_net_price' => 'ASC']
]);

 $this->SkProductbusinessprice->belongsTo('SkUnit', [
'foreignKey' => 'pu_unit', //for foreignKey
'joinType' => 'INNER' //join type
]);
$this->SkProductbusinessprice->belongsTo('SkSize', [
'foreignKey' => 'pu_size', //for foreignKey
'joinType' => 'INNER' //join type
]);
$this->SkProduct->belongsTo('SkTaxes', [
'foreignKey' => 'product_tax_class', //for foreignKey
'joinType' => 'INNER' //join type
]);
$resMerchantListData =$this->SkProduct->find('all',['contain'=>['SkTaxes','SkProductbusinessprice'=>['SkUnit','SkSize']]])->where($strSelect)->first();


$strSelect ='SELECT * FROM sk_product_review   WHERE 1 AND pr_product_id='.$aryPostData->product_id.' ORDER BY pr_datetime DESC LIMIT 3';
$resProductReview = $connection->execute($strSelect)->fetchAll('assoc');
$aryResponse['reiew'] =$resProductReview;


$strSelect ='SELECT * FROM sk_product_review   WHERE 1 AND pr_product_id='.$aryPostData->product_id.' ORDER BY pr_datetime DESC';
$resProductReview = $connection->execute($strSelect)->fetchAll('assoc');
$aryResponse['reiew_count']=$resProductReview;

 $aryResponse['message']='ok';
$aryResponse['product_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;
$strExplode =explode(',',$resMerchantListData['product_category']);
 $aryResponse['maincategory'] = $strExplode[0];


$strSelect ='SELECT * FROM sk_category  WHERE 1 AND category_id='.$aryResponse['maincategory'].'';
$rowCategoryDetail = $connection->execute($strSelect)->fetch('assoc');
 $aryResponse['maincategorydetail'] = $rowCategoryDetail;

$strSelect ='SELECT * FROM sk_productbusinessprice  INNER JOIN sk_unit ON pu_unit=unit_id WHERE 1 AND pu_product_id='.$aryPostData->product_id.' ORDER BY pu_selling_price ASC';
$rowMerchantDetail = $connection->execute($strSelect)->fetchAll('assoc');

$resMerchantListData['child'] =$rowMerchantDetail;
 $aryResponse['result'] =$resMerchantListData;
 
 
 	$strLoadExtraCondition =' ';
		$aryExplodeCategory =explode(',',$resMerchantListData['product_category']);
		if(count($aryExplodeCategory)>0)
		{
		    	$strLoadExtraCondition .=' AND ( ';
		$counter = 0;
		foreach($aryExplodeCategory as $key=>$label)
		{ 
		    $counter++;
		    if($counter!=1)
		    {
		        
		        $strLoadExtraCondition .=' OR ';
		    }
$strLoadExtraCondition .='  FIND_IN_SET('.$label.',product_category)';
		}
		
			$strLoadExtraCondition .=' ) ';
		}
		
	//	echo $strLoadExtraCondition;
 	$strExtra =' 1 AND product_status=1 '.$strLoadExtraCondition.'';
 		
		
  
$this->SkProduct->hasMany('SkProductbusinessprice', [
'foreignKey' => 'pu_product_id',
'sort'=>['SkProductbusinessprice.pu_net_price' => 'ASC']
]);

 $this->SkProductbusinessprice->belongsTo('SkUnit', [
'foreignKey' => 'pu_unit', //for foreignKey
'joinType' => 'INNER' //join type
]);

$resMerchantListData =$this->SkProduct->find('all',['contain'=>['SkProductbusinessprice'=>['SkUnit']]])->where($strExtra);



		 $aryResponse['relatedproduct'] =$resMerchantListData;
		 
		 
		 
		 
		 
		 

}else{
         $aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;
}

public function filterdata()
{
    $aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{
$rwws = file_get_contents('php://input');
$aryPostData =json_decode($rwws);
 $connection = ConnectionManager::get('default');

    
 $strSelect ='SELECT * FROM sk_product  WHERE 1 AND product_status=1 AND product_name LIKE \'%'.$aryPostData->searchdata.'%\'';
$resMerchantListData = $connection->execute($strSelect)->fetchAll('assoc');
 $aryResponse['message']='ok';
$aryResponse['product_url']=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH;


 $aryResponse['result'] =$resMerchantListData;



}else{
         $aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;
}
public function makefav()
{
    $aryResponse =array();      
if ($this->request->is(['patch', 'post', 'put'])) 
{
$rwws = $this->request->getData();
 
$rowFav  = $this->SkWishlist->find('all')->where(['wish_user_id'=>$rwws['user_id'],'wish_product_id'=>$rwws['product_id']])->count();
 if($rowFav>0)
 {
      $this->SkWishlist->deleteAll(['wish_user_id'=>$rwws['user_id'],'wish_product_id'=>$rwws['product_id']]);
 }else{
     $aryPostNewData = array();
     $aryPostNewData['wish_user_id'] = $rwws['user_id'];
        $aryPostNewData['wish_product_id'] = $rwws['product_id'];
 $user =   $this->SkWishlist->newEntity();
 $user =    $this->SkWishlist->patchEntity($user,$aryPostNewData);
    $this->SkWishlist->save($user);
}
$rowCount= $this->SkWishlist->find('all')->where(['wish_user_id'=>$rwws['user_id']])->count();
 $aryResponse['result'] =$rowCount;



}else{
         $aryResponse['message']='failed';
}
echo json_encode($aryResponse);
exit;
}
}