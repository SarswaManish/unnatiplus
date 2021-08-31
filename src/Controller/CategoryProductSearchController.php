<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper\SmsHelper;
use Cake\View\Helper\RecursHelper;

use Cake\Datasource\ConnectionManager;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CategoryProductSearchController extends AppController
{

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
        public function initialize()
	{
	     parent::initialize();
	   	      $this->loadModel('SkUser');
	   	      $this->loadModel('SkProduct');
	   	      	  $this->loadModel('SkSlider');
	   	      	  $this->loadModel('SkCategory');

	   	       $this->loadModel('SkProductbusinessprice');

	}
   function index($strCategorySlug='')
   {
       $arySession =array();
       if(isset($_SESSION['FILTER_TITLE']))
       {
           
         $arySession['name'] =   $_SESSION['FILTER_TITLE'];
       }
       
       $rowCategoryInfo =$this->SkCategory->find('all')->where(['category_slug'=>$strCategorySlug])->first();
      if(isset( $arySession['name']))
      {
       $strCategoryName = $rowCategoryInfo->category_name;
       $intCatId = $rowCategoryInfo->category_id;
       
     echo  $strLoadCondition ='  AND product_name LIKE \'%'. $arySession['name'] .'%\' AND FIND_IN_SET('.$intCatId.',product_category)  AND product_status=1 ';
      }else{
                 $intCatId = $rowCategoryInfo->category_id;
       $strCategoryName = $rowCategoryInfo->category_name;

              $strLoadCondition ='   AND FIND_IN_SET('.$intCatId.',product_category)  AND product_status=1 ';

      }
      // echo $strLoadCondition;
        $resCategoryProductList =$this->paginate($this->SkProduct->find('all')->where(' 1 '.$strLoadCondition)->order(['product_name'=>'ASC']));
        
                       $rowCategoryProductBottom = $this->SkSlider->find('all')->where(['slider_type'=>8])->first();
        $strPageTitle=$strCategoryName;
         $this->set(compact('strPageTitle','intCatId','strCategoryName','resCategoryProductList','rowCategoryProductBottom','rowCategoryInfo'));
       
   }
   
   
  
}