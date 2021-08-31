<?php namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Utility\Security;
use  Cake\Event\Event;

class AttributeListController  extends AppController
{

public function beforeFilter(Event $event)
{
parent::beforeFilter($event);
     $rowAdminInfo =   $this->request->getSession()->read('ADMIN');
        if($rowAdminInfo['admin_id']<=0)
        {
        return $this->redirect(
      ['controller' => 'Login', 'action' => 'index']
       );
        }
}

public function initialize()
{
// * By Default Constructor    
parent::initialize();
$this->loadComponent('Csrf');

}
public function index()
{
//   * Written By Manish Garg
//   * Sunday 23 April 2018
//   * Purpose : Manage Attribute List 
$this->viewBuilder()->setLayout('defaultAdmin');
$this->paginate = ['contain' => ['Attribute']];
$resAttributeInfo = $this->paginate($this->AttributeList);
$title ='Manage Attribute | '.SITE_TITLE;
$this->set(compact('resAttributeInfo','title'));
}

function addattribute($EditId=null)
{
//   * Written By Manish Garg
//   * Sunday 23 April 2018
//   * Purpose : Add/EDIT  Attribute     
//   * Require : PATCH POST PUT OR EDIT ID WHEN EDIT THE RECORD
//   * Return :Reirect To manageattribute Of This Class/Controller
    
$attribute =array();

$postdata = $this->request->getdata();
if ($this->request->is(['patch', 'post', 'put']))
{
   if($EditId>0)
    {
      $attribute = $this->AttributeList->get($EditId, [
            'contain' => []
        ]);

$inttype=$this->request->getdata('att_type');
if($inttype==5)
{
                      $postdata['attr_name']=strtolower(str_replace(' ','_',$postdata['attr_label'])).'[]';
}else{
                      $postdata['attr_name']=strtolower(str_replace(' ','_',$postdata['attr_label']));

}



    }else{
              
        	  $attribute = $this->AttributeList->newEntity();
             $postdata['att_status']=1;
if($inttype==5)
{
                       $postdata['attr_name']=strtolower(str_replace(' ','_',$postdata['attr_label'])).'[]';
}else{
                       $postdata['attr_name']=strtolower(str_replace(' ','_',$postdata['attr_label']));

}
         }
$attribute = $this->AttributeList->patchEntity($attribute, $postdata);
if ($this->AttributeList->save($attribute)) 
{
    $this->Flash->success(__('The Attribute has been saved.'));
    return $this->redirect(['action' => 'index']);
}

$attribute = (object)$this->request->getData();
$this->Flash->error(__('All Field are Required.'));
}else{
       if($EditId>0)
          {
                $attribute = $this->AttributeList->get($EditId, [
            'contain' => ['Attribute']
        ]);
        

          }

    }
$resAttributeGroup = $this->AttributeList->Attribute->find('all');
$title="Manage Attribute | ".SITE_TITLE;
$this->set(compact('title','EditId','attribute','resAttributeGroup'));
$this->viewBuilder()->setLayout('defaultAdmin');
    
    
}
public function attributestatus($id=null)
{
//   * Written By Manish Garg
//   * Sunday 22 April 2018
//   * Purpose : Active Inactive Attribute Group Status  
//   * Require : POST METHOD OR STATUS OR ID
//   * Return :Reirect To Index Of This Class/Controller

$this->request->allowMethod(['post', 'status']);
$attribute= $this->AttributeList->get($id);

if($attribute->get('att_status')==1)
{
     $postdata['att_status'] = 0;
}else{
    
    $postdata['att_status'] = 1;
    }
$attribute=$this->AttributeList->patchEntity($attribute,$postdata);
if($this->AttributeList->save($attribute))
{
$this->Flash->success(__('Attribute  Status Change Successfully'));
return $this->redirect(['action' => 'index']);
}
}

function deleteattribute($id=null)
{
//   * Written By Manish Garg
//   * Sunday 22 April 2018
//   * Purpose : Delete Attribute Group   
//   * Require : POST METHOD OR DELETE OR ID
//   * Return :Reirect To Index Of This Class/Controller

$this->request->allowMethod(['post', 'delete']);
$attribute = $this->AttributeList->get($id);
if ($this->AttributeList->delete($attribute))
{
  $this->Flash->success(__('The Attribute  Has Been Deleted'));
} else {
            $this->Flash->error(__('The Attribute  could not be deleted. Please, try again.'));
        }

return $this->redirect(['action' => 'index']);
}
}