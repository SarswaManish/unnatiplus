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
use Cake\Datasource\ConnectionManager;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AddToCartController  extends AppController{
    
    public function initialize(){
       parent::initialize();
       $this->loadModel('SkCart');
	}
	
    function index(){
       /* $cartSession = $this->request->getSession()->read('cart_items');
        
        if(!isset($cartSession)){
            $this->request->getSession()->write('cart_items',array());
        }*/
        
        $postData = $this->request->getData();
        
        $rowAdminInfo = $this->rowAdminInfo = $this->request->getSession()->read('USER');
          if(!isset($rowAdminInfo->user_id)){
              $user_id = 0;  
          }else{
              $user_id = $rowAdminInfo->user_id;
          }
        
        if($postData['action'] == 1){
            
            $tableData = array(
                'cart_user_id'=>$user_id,
                'cart_product_id'=>$postData['product_id'],
                'cart_product_attributes'=>serialize($postData['attrs']),
                'cart_status'=>1
            );
            $new = $this->SkCart->newEntity();
            $newEntry = $this->SkCart->patchEntity($new,$tableData);
            //$this->SkCart->save($newEntry);
            
            $data = $this->request->getSession()->read('cart_items');
            $add[$postData['product_id']] = $postData['attrs'];
            if(!isset($data[$postData['product_id']])){
                $data[$postData['product_id']] = $postData['attrs'];
                $this->request->getSession()->write('cart_items', $data);
            }else{
                foreach($data[$postData['product_id']] as $key=>$label){
                    
                }
            }
            echo json_encode($data[$postData['product_id']]);
        }
        exit;
    }
    
}