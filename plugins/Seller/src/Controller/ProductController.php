<?php  namespace Seller\Controller;
use Seller\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class ProductController extends AppController
{
    public $rowUniqueId =array();
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->getEventManager()->off($this->Csrf);
    }
    public $rowAdminInfo;
    public function initialize()
	{
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadModel('SkAdmin');
        $this->loadModel('SkCategory');
        $this->loadModel('SkProduct');
        $this->loadModel('SkTaxes');
        $this->loadModel('SkTag');
        $this->loadModel('SkUnit');
        $this->loadModel('SkBrand');
        $this->loadModel('SkSize');
        $this->loadModel('SkUnitGroup');
        $this->loadModel('SkProductbusinessprice');
        $this->loadModel('SkUniqueIds');
        
        $rowAdminInfo =$this->getRequest()->getSession()->read('SELLER');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['seller_id']))
        {
            return $this->redirect(SITE_URL.'seller');
        }
	}
    function index($strStatus=null)
    {
        $rowAdminInfo =$this->getRequest()->getSession()->read('SELLER');
        $resProductList = $this->paginate($this->SkProduct->find('all')->where(['AND' =>['product_status IN '=>array(0,1),'product_seller_id'=>$rowAdminInfo->seller_id]]));
        if($strStatus=='active')
        {
            $resProductList = $this->paginate($this->SkProduct->find('all',array('order'=>array('product_id ASC')))->where(['product_status'=>1]));
        }
        if($strStatus=='inactive')
        {
            $resProductList = $this->paginate($this->SkProduct->find('all',array('order'=>array('product_id ASC')))->where(['product_status'=>0]));
        }
        if($strStatus=='trash')
        {
            $resProductList = $this->paginate($this->SkProduct->find('all',array('order'=>array('product_id ASC')))->where(['product_status'=>2]));
        }
        $resProductListForCount = $this->SkProduct->find('all')->where(['AND' =>['product_seller_id'=>$rowAdminInfo->seller_id]]);
        $resProductListForCount2 = $this->SkProduct->find('all')->where(['AND' =>['product_seller_id'=>$rowAdminInfo->seller_id]]);
        $resProductListForCount3 = $this->SkProduct->find('all')->where(['AND' =>['product_seller_id'=>$rowAdminInfo->seller_id]]);
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Manage Product';
        $this->set(compact('strPageTitle','resProductList','resProductListForCount','resProductListForCount2','resProductListForCount3','strStatus'));
    }
     
    function addproduct($intEditId=null,$strCopyStatus=null)
    {
        $rowProductInfo=array();
        $resProductBusinessArray =array();
        $resProductFixedArray =array();
        if($intEditId>0)
        {
            $rowProductInfo = $this->SkProduct->get($intEditId, [ 'contain' => []  ]);
            $resProductBusinessArray=$this->SkProductbusinessprice->find('all')->where(['pu_type'=>0,'pu_product_id'=>$intEditId]);  
        }
        $strCategory =array();
        if(isset($rowProductInfo->product_category))
        {
            $strCategory = explode(',',$rowProductInfo->product_category);
        }
        $this->viewBuilder()->setLayout('sideBarLayout');
        $resParentCategoryList = $this->SkCategory->find('all',array('order'=>array('category_name ASC')))->toArray();
        $aryCategoryList = $this->treedata($resParentCategoryList,0);
        $strCategoryTreeStructure =$this->genrateHtml($aryCategoryList,0,$strCategory);
        $strPageTitle='AddProduct';
        $resTaxList =$this->SkTaxes->find('all');
        $resTagList =$this->SkTag->find('all');
        $resSelectedTagList =array();
        if($intEditId>0 && isset($rowProductInfo->product_tag) && $rowProductInfo->product_tag!='')
        {
            $resSelectedTagList =$this->SkTag->find('all')->where(['tag_id IN '=>explode(',',$rowProductInfo->product_tag)]);
        }
        $resUnitList = $this->SkUnit->find('all')->where(['unit_status'=>1]);
        $resSizeList = $this->SkSize->find('all')->where(['size_status'=>1]);
        $resUnitGroupList = $this->SkUnitGroup->find('all')->where(['unit_group_status'=>1]);
        $resBrandList =$this->SkBrand->find('all')->order(['brand_name'=>'ASC']);
        $this->set(compact('strPageTitle','resUnitGroupList','resSizeList','connectionManager','strCategoryTreeStructure','rowProductInfo','strCopyStatus','resTaxList','resProductBusinessArray','resProductFixedArray','resTagList','resSelectedTagList','resUnitList','resBrandList'));
    }
     
    function ProductProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['product_id'];
    	if($intEditId>0 && $aryPostData['product_copy']=='')
    	{
    	   $category = $this->SkProduct->get($intEditId, [ 'contain' => [] ]);
    	}else{
    	    $strRandom = self::getProductUnitId();
	        unset($aryPostData['product_id']);
    	    $category=$this->SkProduct->newEntity();   
    	    $aryPostData['product_status']=1;
    	    $aryPostData['product_created_date']=date('Y-m-d h:i:s');
    	    $aryPostData['product_unique_id']=$strRandom;
    	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            if(isset($aryPostData['product_highlights_']) && count($aryPostData['product_highlights_'])>0)
            {
                $aryPostData['product_highlights']=implode('######',$aryPostData['product_highlights_']);
            } 
            if(isset($aryPostData['product_category_']) && count($aryPostData['product_category_'])>0)
            {
                $aryPostData['product_category']=implode(',',$aryPostData['product_category_']);
            }
            if(isset($aryPostData['product_tag_']) && count($aryPostData['product_tag_'])>0)
            {
                $aryPostData['product_tag']=implode(',',$aryPostData['product_tag_']);
            }else{
                $aryPostData['product_tag']='';
            }
            if(isset($_FILES['product_featured_image_']['name']) && $_FILES['product_featured_image_']['name']!='')
            { 
                $filename =time().str_replace(' ','',$_FILES['product_featured_image_']['name']);
                $filename  =str_replace('&','',$filename);
                $acctualfilepath = SITE_UPLOAD_PATH.SITE_PRODUCT_IMAGE_PATH.$filename;
                move_uploaded_file($_FILES['product_featured_image_']['tmp_name'], $acctualfilepath);
                $aryPostData['product_featured_image'] = $filename;
            }
            $aryPostData['product_publish_date']=$aryPostData['publish_year'].'-'.$aryPostData['publish_month'].'-'.$aryPostData['publish_date'].' '.$aryPostData['publish_hour'].':'.$aryPostData['publish_minute'].':00';
    	    $category=$this->SkProduct->patchEntity($category,$aryPostData);
    	    if($this->SkProduct->save($category))
    	    {
                $intInsertId = $category->product_id;
                $this->SkProductbusinessprice->deleteAll(['pu_product_id' => $intInsertId]);     
                $aryMinMax =array();
                foreach($aryPostData['pu_qty'] as $key=>$label)
                {
                    if($label!='')
                    {
        	            $aryPostDataNew =array();
        	            $aryPostDataNew['pu_qty'] =$aryPostData['pu_qty'][$key];
        	            $aryPostDataNew['pu_moq'] =$aryPostData['pu_moq'][$key];
        	            $aryPostDataNew['pu_item_pack'] =$aryPostData['pu_item_pack'][$key];
            	        $aryPostDataNew['pu_discount'] =$aryPostData['pu_discount'][$key];
            	        $aryPostDataNew['pu_net_price'] =$aryPostData['pu_net_price'][$key];
            	        $aryMinMax[]= $aryPostDataNew['pu_net_price'];
        	            $aryPostDataNew['pu_unit'] =$aryPostData['pu_unit'][$key];
        	            $aryPostDataNew['pu_size'] =$aryPostData['pu_size'][$key];
        	            $aryPostDataNew['pu_unit_group'] =$aryPostData['pu_unit_group'][$key];
        	            $aryPostDataNew['pu_product_id'] =$intInsertId;
                        $aryPostDataNew['pu_selling_price'] =$aryPostData['pu_selling_price'][$key];
                        $productBusiness=$this->SkProductbusinessprice->newEntity();   
        	      	    $productBusiness=$this->SkProductbusinessprice->patchEntity($productBusiness,$aryPostDataNew);
                        $this->SkProductbusinessprice->save($productBusiness);
         	        }
                }
                $min = min($aryMinMax);
                $max = max($aryMinMax);
                $query = $this->SkProduct->query(); 
                $query->update()->set(['product_max_price'=>$max,'product_min_price'=>$min]) ->where(['product_id ' => $intInsertId])->execute();
                $this->Flash->success(__('The product has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The product could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
    }
      
    function trash($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkProduct->get($intTrashId);
        $aryPostData['product_status'] = 2;
        $category =$this->SkProduct->patchEntity($category,$aryPostData);
        if($this->SkProduct->save($category))
        {
            $this->Flash->success(__('Product Trash Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    function deletepermanently($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkProduct->get($intTrashId);
        if ($this->SkProduct->delete($category))
        {
            $this->Flash->success(__('The Product has been deleted'));
        } else {
            $this->Flash->error(__('The Product could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'index']);
    }
    
    public function treedata($ar, $pid = null) 
    {
        $this->loadModel('SkCategory');
        $op = array();
        foreach($ar as $item) 
        {
            if ($item->category_parent == $pid) 
            {
                $op[$item->category_id] = $item;
                // using recursion
                $children = $this->treedata($ar, $item->category_id);
                if ($children) 
                {
                    $op[$item->category_id]['children'] = $children;
                }
            }
        }
        return $op;
    }
    
    function genrateHtml($aryCategoryTree,$intLevel=0,$strSelectCategory=array())
    {
        $strHtml='';
        foreach($aryCategoryTree as $key=>$label)
        {
            if($label->category_parent==0)
            {
                $intLevel=0;
            }
            $strChecked='';
            $strExtraChecked ='';
            if(in_array($label->category_id,$strSelectCategory))
            {
                $strChecked = 'checked="checked"';
                $strExtraChecked ='checked';
            }
            $margin =$intLevel*20;
            $strLevelByMargin = 'margin-left:'.$margin.'px;';
            $strHtml .='<div class="checkbox"   style="'.$strLevelByMargin.'"><label><div class="checker"><span class="'.$strExtraChecked.'"><input onclick="setcheckedstatus($(this))" class="styled" name="product_category_[]" '.$strChecked.' value="'.$label->category_id.'" type="checkbox"></span></div>'.$label->category_name.'</label></div>'; 
            if(isset($label->children))
            {
                $intLevel++;
                $strHtml .=$this->genrateHtml($label->children,$intLevel,$strSelectCategory);
            }
        }
        return $strHtml;
    }
  
    public function uploadImage($counter=null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $intCounter =0;
        $aryImageData = array();
        $path=SITE_UPLOAD_PATH.SITE_PRODUCT_IMAGE_PATH;
        $aryResponse =array();
        if ( 0 < $_FILES['product_image']['error'] ) 
        {
            $aryResponse['message']='failed';
            $aryResponse['notification']=$_FILES['product_image']['error'];
        } else{
            $filename =time().str_replace(' ','',$_FILES['product_image']['name']);
            $filename  =str_replace('&','',$filename);
            $acctualfilepath = SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$filename;
            move_uploaded_file($_FILES['product_image']['tmp_name'], $path.$filename);
            $strData =SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$filename;
            $aryResponse['message']='ok';
            $aryResponse['notification']='Image Upload Successfully';
            $aryResponse['url']	 = $strData;
            $aryResponse['name'] = $filename;
        }
        echo json_encode($aryResponse);
        exit();
    }

    public function status($id=null)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkProduct->get($id);
        $aryPostData =array();
        if($category->get('product_status')==1)
        {
            $aryPostData['product_status'] = 0;
        } else if($category->get('product_status')==2)
            {
                $aryPostData['product_status'] = 0;
            }else{
                $aryPostData['product_status'] = 1;
            }
            $category =$this->SkProduct->patchEntity($category,$aryPostData);
            if($this->SkProduct->save($category))
    	    {
                $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    }

    function updateqtyrequest()
    {
        $this->request->allowMethod(['post']);
        $category = $this->SkProduct->get($_POST['product_id']);
        $aryPostData =array();
        $aryPostData['product_qty_in_stock'] = $_POST['qty'];
        $category =$this->SkProduct->patchEntity($category,$aryPostData);
        $this->SkProduct->save($category);
        exit();
    }
    
    function getProductUnitId()
    { 
        $this->rowUniqueId = $this->SkUniqueIds->find('all')->where(['ui_id'=>1])->first();
        $intCurrentCounter =$this->rowUniqueId['ui_current']+1;
        $strCustomeId =$this->rowUniqueId['ui_prefix'].''. sprintf('%04d',$intCurrentCounter);
        $this->SkUniqueIds->updateAll(['ui_current'=>$intCurrentCounter],['ui_id'=>1]);
        return $strCustomeId;
    }
}
 