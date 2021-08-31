<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\View\Helper\RecursHelper;

use Cake\Datasource\ConnectionManager;

class ProductListController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('SkUser');
		$this->loadModel('SkProduct');
		$this->loadModel('SkSlider');
		$this->loadModel('SkBrand');
		$this->loadModel('SkCategory');
		$this->loadModel('SkUnit');
		$this->loadModel('SkProductbusinessprice');
		$this->loadModel('SkAttribute');
		$this->loadModel('SkAttributeTerms');
	}
	function index($strCategorySlug = '', $strChildCategory = '')
	{
		/* echo 
        if($strCategorySlug=='gate-texttile-engineering' || )
         {
         return $this->redirect(SITE_URL);       
      
         exit;
         }*/
		if ($strChildCategory != '') {
			$rowParentCategoryInfo = $this->SkCategory->find('all')->where(['category_slug' => $strCategorySlug])->first();
			if (!isset($rowParentCategoryInfo->category_id)) {
				return $this->redirect(SITE_URL);
				exit;
			}
			$rowCategoryInfo = $this->SkCategory->find('all')->where(['category_slug' => $strChildCategory, 'category_parent' => $rowParentCategoryInfo->category_id])->first();
		} else {
			$rowCategoryInfo = $this->SkCategory->find('all')->where(['category_slug' => $strCategorySlug])->first();
			if (!isset($rowCategoryInfo->category_id)) {
				return $this->redirect(SITE_URL);
				exit;
			}
		}

		$strSlug = $strCategorySlug;
		$resProduct = $this->SkProduct;
		$resProduct->hasMany(
			'SkProductbusinessprice',
			[
				'foreignKey' => 'pu_product_id'
			]
		);

		$this->SkProductbusinessprice->belongsTo(
			'SkUnit',
			[
				'foreignKey' => 'pu_unit', //for foreignKey
				'joinType' => 'INNER' //join type
			]
		);

		if ($this->request->is(['patch', 'post', 'put'])) {
			if (isset($rowParentCategoryInfo->category_id)) {
				$strLoadCondition = ' 1 AND FIND_IN_SET(' . $rowCategoryInfo['category_id'] . ',product_category)  AND FIND_IN_SET(' . $rowParentCategoryInfo->category_id . ',product_category) AND product_status=1 ';
				$resCategoryProductList = $this->paginate(
					$this->SkProduct->find('all', ['contain' => ['SkProductbusinessprice', 'SkProductbusinessprice.SkUnit']])->where($strLoadCondition)->order(['product_min_price' => 'ASC'])
				);
			} else {
				$resCategoryProductList = $this->paginate(
					$this->SkProduct->find('all', ['contain' => ['SkProductbusinessprice', 'SkProductbusinessprice.SkUnit']])->where(' 1 AND FIND_IN_SET(' . $rowCategoryInfo['category_id'] . ',product_category) AND product_status=1 ')->order(['product_min_price' => 'ASC'])
				);
			}
		} else {
			if (isset($rowParentCategoryInfo->category_id)) {
				$strLoadCondition = ' 1 AND FIND_IN_SET(' . $rowCategoryInfo['category_id'] . ',product_category)  AND FIND_IN_SET(' . $rowParentCategoryInfo->category_id . ',product_category) AND product_status=1 ';
				$resCategoryProductList = $this->paginate(
					$this->SkProduct->find('all', ['contain' => ['SkProductbusinessprice', 'SkProductbusinessprice.SkUnit']])->where($strLoadCondition)->order(['product_name' => 'ASC'])
				);
			} else {
				$resCategoryProductList = $this->paginate(
					$this->SkProduct->find('all', ['contain' => ['SkProductbusinessprice', 'SkProductbusinessprice.SkUnit']])->where(' 1 AND FIND_IN_SET(' . $rowCategoryInfo['category_id'] . ',product_category) AND product_status=1 ')->order(['product_name' => 'ASC'])
				);
			}
		}
		$resNewProduct = $this->SkProduct->find('all')->where(' 1 AND product_status=1 ')->order(['product_id' => 'DESC'])->limit(3);
		$rowCategoryProductBottom = $this->SkSlider->find('all')->where(['slider_type' => 8])->first();
		$strPageTitle = $rowCategoryInfo->category_name;
		$strParentCatgory = $strCategorySlug;
		$strChildCategory = $strChildCategory;
		$resBrandInfo = $this->SkBrand->find('all')->order(['brand_name' => 'ASC']);
		$resAttributeInfo = $this->SkAttribute->find('all')->order(['att_name' => 'ASC']);
		$resAttributeNameInfo = $this->SkAttributeTerms;
		$this->set(
			compact(
				'strPageTitle',
				'resAttributeInfo',
				'resAttributeNameInfo',
				'rowCategoryInfo',
				'resCategoryProductList',
				'resNewProduct',
				'rowCategoryProductBottom',
				'strParentCatgory',
				'strChildCategory',
				'resBrandInfo',
				'strSlug'
			)
		);
	}
	function filter()
	{
		$resProduct = $this->SkProduct;
		$resProduct->hasMany(
			'SkProductbusinessprice',
			[
				'foreignKey' => 'pu_product_id'
			]
		);
		$this->SkProductbusinessprice->belongsTo(
			'SkUnit',
			[
				'foreignKey' => 'pu_unit', //for foreignKey
				'joinType' => 'INNER' //join type
			]
		);
		$strCategorySlug = $this->request->getData('category_slug');
		$rowCategoryInfo = $this->SkCategory->find('all')->where(['category_slug' => $strCategorySlug])->first();
		if(isset($rowCategoryInfo->category_id)){
		    $strLoadCondition = ' 1    AND FIND_IN_SET(' . $rowCategoryInfo->category_id . ',product_category) AND product_status=1 ';
		}else{
		    $strLoadCondition = ' 1   AND product_status=1 ';
		}
		
		if (isset($_POST['quality']) && $_POST['quality'] != '') {
			$strExplode = explode(',', $_POST['quality']);
			$strLabel = ' AND (';
			$counter = 0;
			$total = count($strExplode);
			foreach ($strExplode as $key => $val) {
				$counter++;
				if ($counter > 1) {
					$strLabel .= ' OR ';
				}
				$strLabel .= '  product_label=\'' . $val . '\'';
			}
			$strLabel .= ' ) ';
			$strLoadCondition = $strLoadCondition . ' ' . $strLabel;
		}
		if (isset($_POST['brand']) && $_POST['brand'] != '') {
			$strExplode = explode(',', $_POST['brand']);
			$strLabel = ' AND (';
			$counter = 0;
			$total = count($strExplode);
			foreach ($strExplode as $key => $val) {
				$counter++;
				if ($counter > 1) {
					$strLabel .= ' OR ';
				}
				$strLabel .= '  product_brand=\'' . $val . '\'';
			}
			$strLabel .= ' ) ';
			$strLoadCondition = $strLoadCondition . ' ' . $strLabel;
		}
		if (isset($_POST['attribute']) && $_POST['attribute'] != '') {
			$strExplode = explode(',', $_POST['attribute']);
			$strLabel = ' AND (';
			$counter = 0;
			$total = count($strExplode);
			foreach ($strExplode as $key => $val) {
				$counter++;
				if ($counter > 1) {
					$strLabel .= ' OR ';
				}
				$strLabel .= '  product_fabric=\'' . $val . '\'';
			}
			$strLabel .= ' ) ';
			$strLoadCondition = $strLoadCondition . ' ' . $strLabel;
		}
		$resCategoryProductList = $this->SkProduct->find('all', ['contain' => ['SkProductbusinessprice', 'SkProductbusinessprice.SkUnit']])->where($strLoadCondition)->order(['product_name' => 'ASC']);
		$resultCount = $resCategoryProductList->count();
		if($resultCount >0){
		    foreach ($resCategoryProductList as $rowCategoryProductList) {
			echo '<div class="col-lg-3 pr-5 pl-5">
                    <div class="product-item mb-10">
                        <div class="top-block">
                            <div class="product-item-img product-ilstimg">
                                <a href="' . SITE_URL . 'product-detail/' . $rowCategoryProductList->product_slug . '">
                                    <img class="zoom-product" src="' . SITE_UPLOAD_URL . SITE_PRODUCT_IMAGE_PATH . $rowCategoryProductList->product_featured_image . '" alt="">
                                </a>
                            </div>
                            <div class="so-quickview text-center">
                                <a class="quickview" href="' . SITE_URL . 'product-detail/' . $rowCategoryProductList->product_slug . '" title="Quick view"><i class="icon-eye"></i></a>
                            </div>
                        </div>
                        <div class="bottom-block">
                            <div class="pi-title">' . $rowCategoryProductList->product_name . ' </div>
                                <div class="pi-price">
                                    <span class="new-price">₹' . $rowCategoryProductList->product_min_price . '/ Piece</span>
                                </div>
                                <div class="pi-label">
                    ';

			if (isset($rowCategoryProductList['product_label']) && $rowCategoryProductList['product_label'] == 'Excellent Quality') {
				echo '<span class="label-pi bg-success-400">' . $rowCategoryProductList->product_label . '</span>';
			} else if (isset($rowCategoryProductList['product_label']) && $rowCategoryProductList['product_label'] == 'Average Quality') {
				echo '<span class="label-pi bg-danger text-white">' . $rowCategoryProductList->product_label . '</span>';
			} else if (isset($rowCategoryProductList['product_label']) && $rowCategoryProductList['product_label'] == 'Good Quality') {
				echo '<span class="label-pi bg-warning text-white">' . $rowCategoryProductList->product_label . '</span>';
			}

			echo ' </div> 
                        <div class="bottom-block-footer">
                           ' . $rowCategoryProductList->product_tagline . '
                        </div>
                        <div class="button-group">
                            <a href="' . SITE_URL . 'product-detail/' . $rowCategoryProductList->product_slug . '" class="addtocart">ADD TO CART</a>
                        </div>
                    </div>
                </div>
            </div>';
		}
		}else{
		    echo '<div class="col-lg-12">
                    <div class="no-img text-center">
                        <img src="https://codexosoftware.live/unnatiplus/assets/img/no-cart.png" class="img-300 mb-20">
                        <h5>No Product?</h5>
                        <p>Looks like you have no item in your shopping cart
                            <br>Click here to continue shopping</p>
                    </div>
                </div>';
		}
		exit;
	}
	function brand($strCategorySlug = '')
	{
		$rowParentCategoryInfo = $this->SkBrand->find('all')->where(['brand_slug' => $strCategorySlug])->first();
		if (!isset($rowParentCategoryInfo->brand_id)) {
			return $this->redirect(SITE_URL);
			exit;
		}
		$resProduct = $this->SkProduct;
		$resProduct->hasMany(
			'SkProductbusinessprice',
			[
				'foreignKey' => 'pu_product_id'
			]
		);
		$this->SkProductbusinessprice->belongsTo(
			'SkUnit',
			[
				'foreignKey' => 'pu_unit', //for foreignKey
				'joinType' => 'INNER' //join type
			]
		);
		$strLoadCondition = ' 1 AND FIND_IN_SET(' . $rowParentCategoryInfo['brand_id'] . ',product_brand)   AND product_status=1 ';
		$resCategoryProductList = $this->paginate(
			$this->SkProduct->find('all', ['contain' => ['SkProductbusinessprice', 'SkProductbusinessprice.SkUnit']])->where($strLoadCondition)->order(['product_name' => 'ASC'])
		);
		$rowCategoryInfo = $rowParentCategoryInfo;
		$strParentCatgory = 'Brands';
		$strChildCategory = $rowParentCategoryInfo->brand_name;
		$strPageTitle = $rowParentCategoryInfo->brand_name;
		$resBrandInfo = $this->SkBrand->find('all')->order(['brand_name' => 'ASC']);
		$resAttributeInfo = $this->SkAttribute->find('all')->order(['att_name' => 'ASC']);
		$resAttributeNameInfo = $this->SkAttributeTerms;
		$this->set(
			compact(
				'strPageTitle',
				'rowCategoryInfo',
				'resCategoryProductList',
				'resNewProduct',
				'rowCategoryProductBottom',
				'strParentCatgory',
				'strChildCategory',
				'resBrandInfo',
				'resAttributeInfo',
				'resAttributeNameInfo'
			)
		);
	}

	function sale($strCategorySlug = '')
	{
		if ($this->request->is(['post'])) {
			$resCategoryProductList = $this->paginate($this->SkProduct->find('all')->Where(['product_onsale=1'])->order(['product_min_price' => 'ASC']));
		} else {
			$resCategoryProductList = $this->paginate($this->SkProduct->find('all')->Where(['product_onsale=1']));
		}
        $resAttributeInfo = $this->SkAttribute->find('all')->order(['att_name' => 'ASC']);
        $resAttributeNameInfo = $this->SkAttributeTerms;
		$resBrandInfo = $this->SkBrand->find('all')->order(['brand_name' => 'ASC']);
		$this->set(
			compact(
				'strPageTitle',
				'rowCategoryInfo',
				'resCategoryProductList',
				'resProductList',
				'rowCategoryProductBottom',
				'strParentCatgory',
				'strChildCategory',
				'resBrandInfo',
				'resAttributeInfo',
				'resAttributeNameInfo'
				
			)
		);
	}

	function plusSizeKurtis() {}
}