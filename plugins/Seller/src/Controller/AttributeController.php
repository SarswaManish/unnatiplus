<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class AttributeController extends AppController
 {
     public function beforeFilter(Event $event)
      {
       parent::beforeFilter($event);
      }
      public function initialize()
	{
	     parent::initialize();
	     
	      $this->loadModel('SkAttribute');
	      $this->loadModel('SkAttributeTerms');
	      $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
	     if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
	     {
	          return $this->redirect(SITE_URL.'admin');
	     }

	}
     function index($intTagId=null)
     {
         if($intTagId!=null)
        {
         $rowTagInfo = $this->SkAttribute->get($intTagId, ['contain' => []]);
        }else{
          $rowTagInfo =array();  
        }
         $resTagList = $this->paginate($this->SkAttribute);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Attributes';
         $this->set(compact('strPageTitle','rowTagInfo','resTagList'));
     }
     function tagProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['att_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkAttribute->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkAttribute->newEntity();   
     	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    	    $category=$this->SkAttribute->patchEntity($category,$aryPostData);
    	    if($this->SkAttribute->save($category))
    	    {
    	        $this->Flash->success(__('The Attribute has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Attribute could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
     
 

 
 
 
  function deleteterms($intattid,$intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
             $this->Flash->success(__('The Attribute Terms has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The Attribute Terms could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'configure',$intattid]);
     
 }
 
  function configure($intTagId=null,$intId=null)
     {
         if($intId!=null)
         {
               $rowTermsInfo = $this->SkAttributeTerms->get($intId, ['contain' => []]);
         }
        
         $rowTagInfo = $this->SkAttribute->get($intTagId, ['contain' => []]);
        
          $resTagList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>$rowTagInfo->att_id]);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Attributes';
         $this->set(compact('strPageTitle','rowTagInfo','resTagList','rowTermsInfo'));
     }  
     
     function termsProcessRequest()
     {
       $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkAttributeTerms->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkAttributeTerms->newEntity();   
     	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    	    $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
    	    if($this->SkAttributeTerms->save($category))
    	    {
    	        $this->Flash->success(__('The Attribute has been saved.'));
    	        return $this->redirect(['action' => 'configure',$aryPostData['attterms_att_id']]);
    	    }
    	    $this->Flash->error(__('The Attribute could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'configure',$aryPostData['attterms_att_id']]);

    	}   
         
     }
     
     function getconfigure()
     {
         $intVariantId = $this->request->getData('variant_id');
         
         if($intVariantId>0)
         {
                      $rowTagInfo = $this->SkAttribute->get($intVariantId, ['contain' => []]);

              $resTagList = $this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>$intVariantId]);
              
              $strHtml ='<div class="variant-box variant'.$intVariantId.'" style="margin-top:10px"><div class="heading" style="padding:15px 15px; border:1px solid #ddd; background:#f6f5f5; "><h5 style="margin: 0px;font-weight: 500;font-size: 14px;width: 91%;float: left;" onclick="toggledata($(this))">'.$rowTagInfo->att_name.'</h5><a href="javascript:void(0);"  onclick="removeproductattribute('.$intVariantId.')" style="color:red;">Remove</a></div><div class="childbox" style="padding:15px 15px; border:1px solid #ddd; background:#f6f5f5; display:none"><div class="row"> <div class="col-lg-12"><div class="input text required"><select  class="select select2-hidden-accessible" multiple data-placeholder="Select" name="variantdata['.$intVariantId.'][]" id="datavariants'.$intVariantId.'">';
           foreach($resTagList as $rowTagList)
           {
            $strHtml .=  '<option value="'.$rowTagList->attterms_id.'">'.$rowTagList->attterms_name.'</option>';
           }  
              
             $strHtml .='</select></div></div></div></div></div>';
           echo $strHtml;   
         }
         exit;         

     }
     function generatevarianthtml()
     {
                  $dataforvariant = $this->request->getData('datas');
                
                print_r($dataforvariant);  
                exit;

     }
 }
 