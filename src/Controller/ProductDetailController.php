<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\View\Helper\RecursHelper;

use Cake\Datasource\ConnectionManager;

class ProductDetailController extends AppController
{
	public $chachearray = '';
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('SkUser');
		$this->loadModel('SkProduct');
		$this->loadModel('SkSlider');
		$this->loadModel('SkCategory');
		$this->loadModel('SkProductReview');
		$this->loadModel('SkTag');
		$this->loadModel('SkSize');
		$this->loadModel('SkProductbusinessprice');
		$this->loadModel('SkWishlist');
		$this->loadModel('SkAttributeTerms');
		$this->rowAdminInfo = $this->request->getSession()->read('USER');
		if (isset($_COOKIE['PRODUCT_CACHE'])) {
			$this->chachearray = $_COOKIE['PRODUCT_CACHE'];
		}
	}

	function index($strProductSlug = '')
	{
		$intUserId = 0;
		if (isset($this->rowAdminInfo->user_id)) {
			$intUserId = $this->rowAdminInfo->user_id;
		}
		$this->SkProduct->hasOne('SkWishlist')
			->setForeignKey(
				[
					'wish_product_id',
				]
			)
			->setBindingKey(
				[
					'product_id',
				]
			)->setConditions(['wish_user_id' => $intUserId]);

		$this->SkProduct->hasMany('SkProductbusinessprice')
			->setForeignKey(
				[
					'pu_product_id',
				]
			)
			->setBindingKey(
				[
					'product_id',
				]
			);
		$this->SkProductbusinessprice->belongsTo(
			'SkSize',
			[
				'foreignKey' => 'pu_size', //for foreignKey
				'joinType' => 'LEFT' //join type
			]
		);
		$this->SkProduct->belongsTo(
			'SkTaxes',
			[
				'foreignKey' => 'product_tax_class', //for foreignKey
				'joinType' => 'LEFT' //join type
			]
		);
		$rowProductInfo = $this->SkProduct->find('all', ['contain' => ['SkWishlist', 'SkTaxes', 'SkProductbusinessprice' => ['SkSize']]])->where(['product_slug' => $strProductSlug])->first();
		$resFeaturedProduct = $this->SkProduct->find('all')->where(['product_status' => 1]);
		if ($this->chachearray == '') {
			$resRecentlyViewdProduct = $this->SkProduct->find('all')->where(['product_id' => 0]);
			$aryData[] = $rowProductInfo->product_id;
			$this->chachearray = implode(',', $aryData);
			setcookie('PRODUCT_CACHE', $this->chachearray, time() + (86400 * 30 * 30), "/");
		} else {
			$aryData = explode(',', $this->chachearray);
			if (!in_array($rowProductInfo->product_id, $aryData)) {
				$aryData[] = $rowProductInfo->product_id;
				$this->chachearray = implode(',', $aryData);
			}
			$resRecentlyViewdProduct = $this->SkProduct->find('all')->where(['product_status' => 1, 'product_id IN' => $aryData]);
			setcookie('PRODUCT_CACHE', $this->chachearray, time() + (86400 * 30 * 30), "/");
		}
        $strProductTitle=$rowProductInfo->product_name;
        $strOgDetail =strip_tags($rowProductInfo->product_desc);
        $strOgImage=SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_featured_image;
		$strPageTitle = 'Product Detail';
		$this->set(compact('strPageTitle', 'rowProductInfo', 'resFeaturedProduct', 'resRecentlyViewdProduct','strProductTitle','strOgDetail','strOgImage'));
	}
}
