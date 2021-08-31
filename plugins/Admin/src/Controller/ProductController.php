<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;

class ProductController extends AppController
{
    public $paginate = ['limit' => 100  ];
    public $rowUniqueId =array();
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->getEventManager()->off($this->Csrf);
    }
    
    public function initialize()
	{
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadModel('SkAdmin');
        $this->loadModel('SkCategory');
        $this->loadModel('SkProduct');
        $this->loadModel('SkTaxes');
        $this->loadModel('SkSeller');
        $this->loadModel('SkTag');
        $this->loadModel('SkUnit');
        $this->loadModel('SkBrand');
        $this->loadModel('SkSize');
        $this->loadModel('SkUnitGroup');
        $this->loadModel('SkProductbusinessprice');
        $this->loadModel('SkUniqueIds');
        $this->loadModel('SkAttributeTerms');
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }
        
	}
	
    function index($strStatus=null)
    {
        if($this->request->is('post'))
        {
            $arySessionData =array();
            if($this->request->getData('filter_keyword')!='')
            {
                $arySessionData['KEYWORD'] = $this->request->getData('filter_keyword');  
            }
            $this->getRequest()->getSession()->write('FILTER',$arySessionData); 
        }
        
        $this->SkProduct->belongsTo('SkSeller', [
            'foreignKey' => 'product_seller_id', //for foreignKey
            'joinType' => 'LEFT' //join type
        ]);
        
        $rowFilterData =  $this->getRequest()->getSession()->read('FILTER');
        $strLoadConditrion =  ' 1  ';
        if(isset($rowFilterData['KEYWORD']) && $rowFilterData['KEYWORD']!='')
        {
            $catCondition = "";
            $cats = $this->SkCategory->find('all')->where('category_name LIKE \'%'.$rowFilterData['KEYWORD'].'%\'')->toArray();
            if(!empty($cats)){
                foreach($cats as $cat){
                   $catCondition .= ' OR product_category LIKE \'%'.$cat->category_id.'%\'';
                }
            }
            $strLoadConditrion .= ' AND product_name LIKE \'%'.$rowFilterData['KEYWORD'].'%\' OR product_sku LIKE \'%'.$rowFilterData['KEYWORD'].'%\''.$catCondition;
           
        } 
        $resProductList = $this->paginate($this->SkProduct->find('all',['contain'=>['SkSeller']])->where(['AND' => ['product_status IN '=>array(0,1),$strLoadConditrion]]));
        if($strStatus=='active')
        {
            $resProductList = $this->paginate($this->SkProduct->find('all',['contain'=>['SkSeller']],array('order'=>array('product_id ASC')))->where(['AND' => ['product_status'=>1,$strLoadConditrion]]));
        }
        if($strStatus=='inactive')
        {
            $resProductList = $this->paginate($this->SkProduct->find('all',['contain'=>['SkSeller']],array('order'=>array('product_id ASC')))->where(['AND' => ['product_status'=>0,$strLoadConditrion]]));
            
        }
        if($strStatus=='trash')
        {
            $resProductList = $this->paginate($this->SkProduct->find('all',array('order'=>array('product_id ASC')))->where(['AND' => ['product_status'=>2,$strLoadConditrion]]));
        }
        $resProductListForCount = $this->SkProduct->find('all');
        $resProductListForCount2 = $this->SkProduct->find('all');
        $resProductListForCount3 = $this->SkProduct->find('all');
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Manage Product';
        $this->set(compact('strPageTitle','resProductList','resProductListForCount','resProductListForCount2','resProductListForCount3','strStatus','rowFilterData'));
    }
     
    function reset()
    {
        $this->getRequest()->getSession()->delete('FILTER'); 
        return $this->redirect(SITE_URL.'admin/product/');
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
        $resFabricList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>10]);
        $resOccasionList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>11]);
        $resDesignList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>12]);
        $resProductStyleList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>13]);
        $resProductFitList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>14]);
        $resNeckTypeList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>15]);
        $resSleeveList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>16]);
        $resUnitGroupList = $this->SkUnitGroup->find('all')->where(['unit_group_status'=>1]);
        $resBrandList =$this->SkBrand->find('all')->order(['brand_name'=>'ASC']);
        $this->set(compact('strPageTitle','resSleeveList','resNeckTypeList','resOccasionList','resDesignList','resProductStyleList','resProductFitList','resFabricList','resUnitGroupList','resSizeList','connectionManager','strCategoryTreeStructure','rowProductInfo','strCopyStatus','resTaxList','resProductBusinessArray','resProductFixedArray','resTagList','resSelectedTagList','resUnitList','resBrandList'));
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
            
            if(isset($aryPostData['product_fabric']) && count($aryPostData['product_fabric'])>0)
            {
                $aryPostData['product_fabric']=implode(',',$aryPostData['product_fabric']);
            }
            if(isset($aryPostData['product_occasion']) && count($aryPostData['product_occasion'])>0)
            {
                $aryPostData['product_occasion']=implode(',',$aryPostData['product_occasion']);
            }
            if(isset($aryPostData['product_design']) && count($aryPostData['product_design'])>0)
            {
                $aryPostData['product_design']=implode(',',$aryPostData['product_design']);
            }
            if(isset($aryPostData['product_style']) && count($aryPostData['product_style'])>0)
            {
                $aryPostData['product_style']=implode(',',$aryPostData['product_style']);
            }
            if(isset($aryPostData['product_neck_type']) && count($aryPostData['product_neck_type'])>0)
            {
                $aryPostData['product_neck_type']=implode(',',$aryPostData['product_neck_type']);
            }
            if(isset($aryPostData['product_sleeve']) && count($aryPostData['product_sleeve'])>0)
            {
                $aryPostData['product_sleeve']=implode(',',$aryPostData['product_sleeve']);
            }
            if(isset($aryPostData['product_fit']) && count($aryPostData['product_fit'])>0)
            {
                $aryPostData['product_fit']=implode(',',$aryPostData['product_fit']);
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
    	    $aryPostData['product_is_return'] = (isset($aryPostData['is_return']))?$aryPostData['is_return']:0;
    	    $aryPostData['product_return_days'] = (isset($aryPostData['return_days']) && $aryPostData['return_days']>0)?$aryPostData['return_days']:0;
    	    $category=$this->SkProduct->patchEntity($category,$aryPostData);
    	    if($this->SkProduct->save($category))
    	    {
                $intInsertId = $category->product_id;
                $this->SkProductbusinessprice->deleteAll(['pu_product_id' => $intInsertId]);     
                $aryMinMax =array();
                $aryDiscount = array();
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
                        $aryMinMax[]= (int)$aryPostDataNew['pu_net_price']/$aryPostDataNew['pu_item_pack'];
                        $aryDiscount[] =  ($aryPostDataNew['pu_discount']/$aryPostDataNew['pu_net_price'])*100;
                        $aryPostDataNew['pu_unit'] =$aryPostData['pu_unit'][$key];
                        $aryPostDataNew['pu_size'] =$aryPostData['pu_size'][$key];
                        $aryPostDataNew['pu_product_id'] =$intInsertId;
                        $aryPostDataNew['pu_selling_price'] =$aryPostData['pu_selling_price'][$key];
                        $productBusiness=$this->SkProductbusinessprice->newEntity();  
                        $productBusiness=$this->SkProductbusinessprice->patchEntity($productBusiness,$aryPostDataNew);
                        $this->SkProductbusinessprice->save($productBusiness);
        	        }
                }
                $min = min($aryMinMax);
                $max = max($aryMinMax);
               // pr($aryDiscount);
            //    echo max($aryDiscount);
    	        $query = $this->SkProduct->query(); 
                $query->update()->set(['product_max_price'=>$max,'product_min_price'=>$min,'product_discount_percent'=>max($aryDiscount)]) ->where(['product_id ' => $intInsertId])->execute();
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
        } else
        {
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
        } else {
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
        } else if($category->get('product_status')==2){
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

	public function export() 
	{
        $conn = ConnectionManager::get('default');
        $delimiter = ",";
        $filename = "ProductList_" . date('Y-m-d') . ".csv";
        $f = fopen('php://memory', 'w');
        $fields = array('product_id','product_name', 'product_sub_title', 'product_slug', 'product_sku', 'product_model', 'product_tagline', 'product_hsn','product_desc','product_selling_price','product_discount_selling','product_net_price','product_qty_in_stock','product_min','product_max','product_meta_title','product_meta_keyword','product_meta_description','product_category','product_visibility','product_publish_date','product_created_date','product_status','product_draft_status','product_tax_class','product_isbn','product_tag','product_onsale','product_label','product_highlights','product_delivery_text','product_no_of_page','product_user_for','product_spec','product_min_price','product_discount_percent','product_max_price','product_rating','product_brand','product_seller_id');
        fputcsv($f, $fields, $delimiter);   
        $data = $this->SkProduct->find('all')->toArray();

        foreach($data as $row)
        {
            $lineData = array($row['product_id'],$row['product_name'], $row['product_sub_title'], $row['product_slug'],$row['product_sku'],$row['product_model'],$row['product_tagline'],$row['product_hsn'],$row['product_desc'],$row['product_selling_price'],$row['product_discount_selling'],$row['product_net_price'],$row['product_qty_in_stock'],$row['product_min'],$row['product_max'],$row['product_meta_title'],$row['product_meta_keyword'],$row['product_meta_description'],$row['product_category'],$row['product_visibility'],$row['product_publish_date'],$row['product_created_date'],$row['product_status'],$row['product_draft_status'],$row['product_tax_class'],$row['product_isbn'],$row['product_tag'],$row['product_onsale'],$row['product_label'],$row['product_highlights'],$row['product_delivery_text'],$row['product_no_of_page'],$row['product_user_for'],$row['product_spec'],$row['product_min_price'],$row['product_discount_percent'],$row['product_max_price'],$row['product_rating'],$row['product_brand'],$row['product_seller_id']);
            fputcsv($f, $lineData, $delimiter);
        }
    
        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
        exit;
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
                    $this->SkProduct->deleteAll( ['product_id IN' =>$aryPostData['product_id']]);
                    $this->Flash->success(__('Deleted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==2)
                {
                    $this->SkProduct->updateAll(['product_status'=>'1'],['product_id IN' =>$aryPostData['product_id']]);
                    $this->Flash->success(__('Selected Entry Active Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                if($intBulkAction==3)
                {
                    $this->SkProduct->updateAll(['product_status'=>'0'],['product_id  IN' =>$aryPostData['product_id'] ]);
                    $this->Flash->success(__('Selected Entry Inactive Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }else{
            self::sendfcm();
        }
    }
    /* This function is done by Harsh Lakhera 13/01/2020 */
    function getProductUnitId()
    { 
        $this->rowUniqueId = $this->SkUniqueIds->find('all')->where(['ui_id'=>1])->first();
        $intCurrentCounter =$this->rowUniqueId['ui_current']+1;
        $strCustomeId =$this->rowUniqueId['ui_prefix'].''. sprintf('%04d',$intCurrentCounter);
        $this->SkUniqueIds->updateAll(['ui_current'=>$intCurrentCounter],['ui_id'=>1]);
        return $strCustomeId;
    }
}
 