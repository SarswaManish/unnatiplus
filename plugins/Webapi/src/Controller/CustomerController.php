<?php namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
class CustomerController  extends AppController
{
public function initialize()
{
    parent::initialize();
    $this->loadComponent('Csrf');
    
}
public function index()
       {
    	     $this->viewBuilder()->setLayout('defaultAdmin');
    	     $title ='Customers | Leaf Disposal';
           
             $this->set(compact('title'));
        }
}