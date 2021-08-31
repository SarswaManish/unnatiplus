<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class AttributeController extends AppController
 {
    public $rowAttributeId =array();
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
    	    $category = $this->SkAttribute->get($intEditId, ['contain' => [] ]);
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
        } else {
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
     
    /* Beloww all Functions is Cerated by Harsh Lakhera 13/01/2020 */
    function fabric($intId=null)
    {
        if($intId!=null)
        {
            $rowFabricList = $this->SkAttributeTerms->get($intId, ['contain' => []]);
        }
        $rowFabricInfo = $this->SkAttribute->find('all')->where(['att_id'=>10])->first();
        $resFabricInfo = $this->paginate($this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>10]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Fabric';
        $this->set(compact('strPageTitle','rowFabricInfo','rowFabricList','resFabricInfo'));
    } 
    
    function fabricProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	    $category = $this->SkAttributeTerms->get($intEditId, ['contain' => [] ]);
    	}else{
    	    $category=$this->SkAttributeTerms->newEntity();   
     	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
            if($this->SkAttributeTerms->save($category))
            {
                $this->Flash->success(__('The Fabric has been saved.'));
                return $this->redirect(['action' => 'fabric']);
            }
            $this->Flash->error(__('The Fabric could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'fabric']);
    	}   
         
    }
    
    function fabricbulkaction()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData =$_POST;
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction==1)
            {
                $this->SkAttributeTerms->deleteAll( ['attterms_id IN' =>$aryPostData['attterms_id']]);
                $this->Flash->success(__('The Fabric Deleted Successfully'));
                    return $this->redirect(['action' => 'fabric']);
            }
        }
    }
    
    function deletefabric($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
            $this->Flash->success(__('The Fabric has been deleted'));
        } else {
            $this->Flash->error(__('The Fabric could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'fabric']);
    }
    
    function occasion($intId=null)
    {
        if($intId!=null)
        {
            $rowFabricList = $this->SkAttributeTerms->get($intId, ['contain' => []]);
        }
        $rowFabricInfo = $this->SkAttribute->find('all')->where(['att_id'=>11])->first();
        $resFabricInfo = $this->paginate($this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>11]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Occasion';
        $this->set(compact('strPageTitle','rowFabricInfo','rowFabricList','resFabricInfo'));
    }
    
    function occasionProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	    $category = $this->SkAttributeTerms->get($intEditId, ['contain' => [] ]);
    	}else{
    	    $category=$this->SkAttributeTerms->newEntity();   
     	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
            if($this->SkAttributeTerms->save($category))
            {
                $this->Flash->success(__('The Occasion has been saved.'));
                return $this->redirect(['action' => 'occasion']);
            }
            $this->Flash->error(__('The Occasion could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'occasion']);
    	}   
         
    }
    
    function occasionbulkaction()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData =$_POST;
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction==1)
            {
                $this->SkAttributeTerms->deleteAll( ['attterms_id IN' =>$aryPostData['attterms_id']]);
                $this->Flash->success(__('The Occasion Deleted Successfully'));
                    return $this->redirect(['action' => 'occasion']);
            }
        }
    }
    
    function deleteoccasion($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
            $this->Flash->success(__('The Occasion has been deleted'));
        } else {
            $this->Flash->error(__('The Occasion could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'occasion']);
    }
    
    function design($intId=null)
    {
        if($intId!=null)
        {
            $rowFabricList = $this->SkAttributeTerms->get($intId, ['contain' => []]);
        }
        $rowFabricInfo = $this->SkAttribute->find('all')->where(['att_id'=>12])->first();
        $resFabricInfo = $this->paginate($this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>12]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Design';
        $this->set(compact('strPageTitle','rowFabricInfo','rowFabricList','resFabricInfo'));
    }
    
    function designProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	    $category = $this->SkAttributeTerms->get($intEditId, ['contain' => [] ]);
    	}else{
    	    $category=$this->SkAttributeTerms->newEntity();   
     	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
            if($this->SkAttributeTerms->save($category))
            {
                $this->Flash->success(__('The Design has been saved.'));
                return $this->redirect(['action' => 'design']);
            }
            $this->Flash->error(__('The Design could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'design']);
    	}   
         
    }
    
    function designbulkaction()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData =$_POST;
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction==1)
            {
                $this->SkAttributeTerms->deleteAll( ['attterms_id IN' =>$aryPostData['attterms_id']]);
                $this->Flash->success(__('The Design Deleted Successfully'));
                    return $this->redirect(['action' => 'design']);
            }
        }
    }
    
    function deletedesign($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
            $this->Flash->success(__('The Design has been deleted'));
        } else {
            $this->Flash->error(__('The Design could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'design']);
    }
    
    function productStyle($intId=null)
    {
        if($intId!=null)
        {
            $rowFabricList = $this->SkAttributeTerms->get($intId, ['contain' => []]);
        }
        $rowFabricInfo = $this->SkAttribute->find('all')->where(['att_id'=>13])->first();
        $resFabricInfo = $this->paginate($this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>13]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Product Style';
        $this->set(compact('strPageTitle','rowFabricInfo','rowFabricList','resFabricInfo'));
    }
    
    function productStyleProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	    $category = $this->SkAttributeTerms->get($intEditId, ['contain' => [] ]);
    	}else{
    	    $category=$this->SkAttributeTerms->newEntity();   
     	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
            if($this->SkAttributeTerms->save($category))
            {
                $this->Flash->success(__('The Product Style has been saved.'));
                return $this->redirect(['action' => 'productStyle']);
            }
            $this->Flash->error(__('The product Style could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'productStyle']);
    	}   
         
    }
    
    function productStylebulkaction()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData =$_POST;
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction==1)
            {
                $this->SkAttributeTerms->deleteAll( ['attterms_id IN' =>$aryPostData['attterms_id']]);
                $this->Flash->success(__('The Product Style Deleted Successfully'));
                    return $this->redirect(['action' => 'productStyle']);
            }
        }
    }
    
    function deleteproductStyle($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
            $this->Flash->success(__('The Product Style has been deleted'));
        } else {
            $this->Flash->error(__('The Product Style could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'productStyle']);
    }
    
    function productFit($intId=null)
    {
        if($intId!=null)
        {
            $rowFabricList = $this->SkAttributeTerms->get($intId, ['contain' => []]);
        }
        $rowFabricInfo = $this->SkAttribute->find('all')->where(['att_id'=>14])->first();
        $resFabricInfo = $this->paginate($this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>14]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Product Fit';
        $this->set(compact('strPageTitle','rowFabricInfo','rowFabricList','resFabricInfo'));
    }
    
    function productFitProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	    $category = $this->SkAttributeTerms->get($intEditId, ['contain' => [] ]);
    	}else{
    	    $category=$this->SkAttributeTerms->newEntity();   
     	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
            if($this->SkAttributeTerms->save($category))
            {
                $this->Flash->success(__('The Product Fit Style has been saved.'));
                return $this->redirect(['action' => 'productFit']);
            }
            $this->Flash->error(__('The Product Fit Style could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'productFit']);
    	}   
         
    }
    
    function productFitbulkaction()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData =$_POST;
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction==1)
            {
                $this->SkAttributeTerms->deleteAll( ['attterms_id IN' =>$aryPostData['attterms_id']]);
                $this->Flash->success(__('The Product Fit Deleted Successfully'));
                    return $this->redirect(['action' => 'productFit']);
            }
        }
    }
    
    function deleteproductFit($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
            $this->Flash->success(__('The Product Fit has been deleted'));
        } else {
            $this->Flash->error(__('The Product Fit could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'productFit']);
    }
    
    function neckType($intId=null)
    {
        if($intId!=null)
        {
            $rowFabricList = $this->SkAttributeTerms->get($intId, ['contain' => []]);
        }
        $rowFabricInfo = $this->SkAttribute->find('all')->where(['att_id'=>15])->first();
        $resFabricInfo = $this->paginate($this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>15]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Neck Type';
        $this->set(compact('strPageTitle','rowFabricInfo','rowFabricList','resFabricInfo'));
    }

    function neckTypeProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	    $category = $this->SkAttributeTerms->get($intEditId, ['contain' => [] ]);
    	}else{
    	    $category=$this->SkAttributeTerms->newEntity();   
     	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
            if($this->SkAttributeTerms->save($category))
            {
                $this->Flash->success(__('The Neck Type has been saved.'));
                return $this->redirect(['action' => 'neckType']);
            }
            $this->Flash->error(__('The Neck Type could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'neckType']);
    	}   
         
    }
    
    function neckTypebulkaction()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData =$_POST;
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction==1)
            {
                $this->SkAttributeTerms->deleteAll( ['attterms_id IN' =>$aryPostData['attterms_id']]);
                $this->Flash->success(__('The Neck Type Deleted Successfully'));
                    return $this->redirect(['action' => 'neckType']);
            }
        }
    }
    
    function deleteneckType($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
            $this->Flash->success(__('The Neck Type has been deleted'));
        } else {
            $this->Flash->error(__('The Neck Type could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'neckType']);
    }    
    
    function sleeve($intId=null)
    {
        if($intId!=null)
        {
            $rowFabricList = $this->SkAttributeTerms->get($intId, ['contain' => []]);
        }
        $rowFabricInfo = $this->SkAttribute->find('all')->where(['att_id'=>16])->first();
        $resFabricInfo = $this->paginate($this->SkAttributeTerms->find('all')->where(['attterms_att_id'=>16]));
        $this->viewBuilder()->setLayout('sideBarLayout');
        $strPageTitle='Sleeve';
        $this->set(compact('strPageTitle','rowFabricInfo','rowFabricList','resFabricInfo'));
    }
    function sleeveProcessRequest()
    {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
    	$intEditId =$aryPostData['attterms_id'];
    	if($intEditId>0)
    	{
    	    $category = $this->SkAttributeTerms->get($intEditId, ['contain' => [] ]);
    	}else{
    	    $category=$this->SkAttributeTerms->newEntity();   
     	}
        if($this->request->is(['patch', 'post', 'put'])) 
        {
            $category=$this->SkAttributeTerms->patchEntity($category,$aryPostData);
            if($this->SkAttributeTerms->save($category))
            {
                $this->Flash->success(__('The Sleeve has been saved.'));
                return $this->redirect(['action' => 'sleeve']);
            }
            $this->Flash->error(__('The Sleeve could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'sleeve']);
    	}   
         
    }
    
    function sleevebulkaction()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $aryPostData =$_POST;
            $intBulkAction = $aryPostData['bulkaction'];
            if($intBulkAction==1)
            {
                $this->SkAttributeTerms->deleteAll( ['attterms_id IN' =>$aryPostData['attterms_id']]);
                $this->Flash->success(__('The Sleeve Deleted Successfully'));
                    return $this->redirect(['action' => 'sleeve']);
            }
        }
    }
    
    function deletesleeve($intTrashId)
    {
        $this->request->allowMethod(['get']);
        $category = $this->SkAttributeTerms->get($intTrashId);
        if ($this->SkAttributeTerms->delete($category))
        {
            $this->Flash->success(__('The Sleeve has been deleted'));
        } else {
            $this->Flash->error(__('The Sleeve could not be deleted. Please, try again.'));
        }
            return $this->redirect(['action' => 'sleeve']);
    }
}
 