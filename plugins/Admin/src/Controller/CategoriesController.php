<?php  namespace Admin\Controller;
use Admin\Controller\AppController;
use  Cake\Event\Event;
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\HtmlHelper;
class CategoriesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    
    public function initialize()
	{
        parent::initialize();
        $this->loadModel('SkAdmin');
        $this->loadModel('SkCategory');
        $this->loadModel('SkProduct');
        $this->loadModel('SkCategoryView');
        $rowAdminInfo =$this->getRequest()->getSession()->read('ADMIN');
        if(!SecurityMaxHelper::checkAdminLogin($rowAdminInfo['admin_id']))
        {
            return $this->redirect(SITE_URL.'admin');
        }
	}
	
    function index($intCatId =null)
    {
        $arypostdata=array(); 
        if($intCatId!=null)
        {
            $rowCategoryInfo = $this->SkCategory->get($intCatId, ['contain' => []]);
        }else{
            $rowCategoryInfo =array();  
        }
        if($this->request->is(['patch', 'post', 'put']))
        {
            $arypostdata=$_POST;
            $arypostdata=$this->request->getdata();
            if(isset($arypostdata['bulkaction']))
            {
                $action = $arypostdata['bulkaction'];
                $ids = $arypostdata['category_id'];
                if($action=='1')
                {
                    $this->SkCategory->deleteAll(['category_id IN'=>$ids]);
        	        $this->Flash->success(__('Delete Successfully.'));
        	        return $this->redirect(['action' => 'index']);
                }
                elseif($action=='2')
                {
                    $this->SkCategory->updateAll(['category_status'=>1],['category_id IN'=>$ids]);
        	        $this->Flash->success(__('Active Successfully.'));
        	        return $this->redirect(['action' => 'index']);
                }
                elseif($action=='3')
                {
                    $this->SkCategory->updateAll(['category_status'=>0],['category_id IN'=>$ids]);
        	        $this->Flash->success(__('Inactive Successfully.'));
        	        return $this->redirect(['action' => 'index']);
                }
            }
            else
            {
                if(isset($arypostdata['category_id'])&&$arypostdata['category_id']>0)
                {
                    $category = $this->SkCategory->get($arypostdata['category_id']);
                }
                else
                {
                    $category = $this->SkCategory->newEntity();
                }
                $category = $this->SkCategory->patchEntity($category,$arypostdata);
                $category = $this->SkCategory->save($category);
    	        $this->Flash->success(__('category has been saved.'));
    	        return $this->redirect(['action' => 'index']);
            }
            
    }
         $resParentCategoryList = $this->SkCategory->find('all',array('order'=>array('category_name ASC')))->where(['category_parent'=>0]);
         $this->viewBuilder()->setLayout('sideBarLayout');
         $strPageTitle='Categories';
         $resCategoryListData =$this->SkCategory->find('all')->toArray();
         $tree = $this->buildTree($resCategoryListData);
         $strCategoryHtml = $this->getCatgoryChildHtml($tree);
         $resChildCategory =$this->SkCategory;
  
         $this->set(compact('strPageTitle','rowCategoryInfo','resCategoryList','resParentCategoryList','strCategoryHtml','resChildCategory','category'));
     }
     
     function categoryProcessRequest()
     {
        $this->viewBuilder()->setLayout('sideBarLayout');
        $aryPostData = $this->request->getData();
        //pr($aryPostData);
    	$intEditId =$aryPostData['category_id'];
    	if($intEditId>0)
    	{
    	   $category = $this->SkCategory->get($intEditId, [
            'contain' => []
        ]);
    
    	}else{
    	  $category=$this->SkCategory->newEntity();   
    	  $aryPostData['category_status']=1;
    	  $aryPostData['category_created_datetime']=date('Y-m-d h:i:s');
    	}
       if($this->request->is(['patch', 'post', 'put'])) 
        {
    	 
    	    if(isset($_FILES['category_icon_']['name']) && $_FILES['category_icon_']['name']!='')
            { 
                
             $filename =time().str_replace(' ','',$_FILES['category_icon_']['name']);
            $filename  =str_replace('&','',$filename);
            $acctualfilepath = SITE_UPLOAD_PATH.SITE_CATEGORY_ICON_PATH.$filename;
            move_uploaded_file($_FILES['category_icon_']['tmp_name'], $acctualfilepath);
            
            $aryPostData['category_icon'] = $filename;

            }
            
            
             if(isset($_FILES['category_banner_']['name']) && $_FILES['category_banner_']['name']!='')
            { 
                
             $filename =time().str_replace(' ','',$_FILES['category_banner_']['name']);
            $filename  =str_replace('&','',$filename);
            $acctualfilepath = SITE_UPLOAD_PATH.SITE_CATEGORY_ICON_PATH.$filename;
            move_uploaded_file($_FILES['category_banner_']['tmp_name'], $acctualfilepath);
            
            $aryPostData['category_banner'] = $filename;

          }
            if(isset($_FILES['category_app_icon_']['name']) && $_FILES['category_app_icon_']['name']!='')
            { 
                
             $filename =time().str_replace(' ','',$_FILES['category_app_icon_']['name']);
            $filename  =str_replace('&','',$filename);
            $acctualfilepath = SITE_UPLOAD_PATH.SITE_CATEGORY_ICON_PATH.$filename;
            move_uploaded_file($_FILES['category_app_icon_']['tmp_name'], $acctualfilepath);
            
            $aryPostData['category_app_icon'] = $filename;

            }
            if(!isset($aryPostData['category_show_menu']))
            {
                $aryPostData['category_show_menu']=0;
            }
            
             if(!isset($aryPostData['category_megamenu']))
            {
                $aryPostData['category_megamenu']=0;
            }
    	    $category=$this->SkCategory->patchEntity($category,$aryPostData);
    	    if($this->SkCategory->save($category))
    	    {
    	        $this->Flash->success(__('The Category has been saved.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
    	    $this->Flash->error(__('The Category could not be saved. Please, try again.'));
    	             return $this->redirect(['action' => 'index']);

    	}
         
     }
     function getcategorylevel($intleveld,$rowCategoryInfo)
     {
                      
                      if(isset($rowCategoryInfo['category_id']) && $rowCategoryInfo['category_parent']==0)
                      {
                          
                      }else{
                             $rowProductCount = $this->SkCategory->find('all')->where(['category_id'=>$rowCategoryInfo['category_parent']])->first()->toArray();
                                      $intleveld =$intleveld+1;  

$intleveld = self::getcategorylevel($intleveld,$rowProductCount);

 
  
                      }
 
         return $intleveld;
     }
   function getCatgoryChildHtml($tree,$strExtraHtml='',$intLevel=0)
   {
      $strHtml=$strExtraHtml;
  
           foreach($tree as $key=>$label)
           {
              $rowProductCount = $this->SkProduct->find('all')->where(' FIND_IN_SET('.$label['category_id'].',product_category) ')->count();
               $strStyle='';
               if($label['category_parent']!=0)
               {
               $strStyle=' style="background:#eaeaea"';
              
               }
                 $intLevel=self::getcategorylevel(0,$label);
                
               $strExtraData = '';
               for($i=0;$i<$intLevel;$i++)
               {
                    $strExtraData .='<span class="dash"></span>';
                   
                   
               }
               $strImage = SITE_URL.'admin/images/placeholder.jpg';
               if(isset($label['category_icon']) && ''!=$label['category_icon'])
{ 
    $strImage = SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH.$label['category_icon'];
}
             $strHtml .='<tr '.$strStyle.'><td style="text-align:center"><input type="checkbox" name="category_id[]" class="checkbox clsSelectSingle" value="'.$label['category_id'].'"></td>'
                     . '<td><div class="media-left media-middle" style="padding-right:10px;">'
                     . '<a href="#"><img src="'.$strImage.'" class="img-circle img-xs"></a></div>'
                     . '<div class="media-left"><div class="">'
                     . '<a href="#" class="text-default text-semibold">'.$strExtraData.$label['category_name'].'</a></div><div class="text-muted text-size-small">';
														  if($label['category_status']==1)
														 { 
											 $strHtml .='<a href="'.SITE_URL.'admin/categories/status/'.$label['category_id'].'"><span class="status-mark border-success"></span> Active</a>';
														 }else{ 
													 $strHtml .='<a href="'.SITE_URL.'admin/categories/status/'.$label['category_id'].'">
															<span class="status-mark border-danger"></span>
															Inactive
															</a>';
  														} 
										 $strHtml .='</div></div></td><td>'.substr($label['category_descri'],0,50).'</td>';
                                         if($label['category_popular']==1)
                                         {
                                             $strHtml .='<td class="text-center"><a href="'.SITE_URL.'admin/categories/makepopular/'.$label['category_id'].'"><img src="'.SITE_URL.'admin/images/star.png" style="width:16px"></a></td>';
                                        }else{
                                          $strHtml .='<td class="text-center"><a href="'.SITE_URL.'admin/categories/makepopular/'.$label['category_id'].'"><img src="'.SITE_URL.'admin/images/star_blank.png" style="width:16px"></a></td>';  
                                            
                                        }                                    $strHtml .='<td class="text-center"><ul class="icons-list"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a><ul class="dropdown-menu dropdown-menu-right">
										<li><a href="'.SITE_URL.'admin/categories/index/'.$label['category_id'].'" style="padding:3px 15px">Edit</a></li>
										<li><a href="'.SITE_URL.'admin/categories/deletepermanently/'.$label['category_id'].'" style="padding:3px 15px">Delete</a></li>		</ul>								</li>
													</ul>
												</td>
											</tr>
										'; 
										
									
	if(isset($label->children))
	{
	    	//pr($label->children);
	    	//pr($label['children']);
 ///$intLevel++;
      $strHtml =$this->getCatgoryChildHtml($label->children,$strHtml,$intLevel);
	}
    }
    
    return $strHtml;
        exit();
   }
     
 function trash($intTrashId)
 {
   $this->request->allowMethod(['get']);
   $category = $this->SkCategory->get($intTrashId);
   $aryPostData['category_status'] = 2;
   $category =$this->SkCategory->patchEntity($category,$aryPostData);
  if($this->SkCategory->save($category))
    	    {
    	        $this->Flash->success(__('Category Trash Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
     
 }
 function deletepermanently($intTrashId)
 {
     
      $this->request->allowMethod(['get']);
        $category = $this->SkCategory->get($intTrashId);
        if ($this->SkCategory->delete($category))
        {
            
             $this->SkCategory->updateAll(['category_parent'=>'0'],[
        'category_parent' =>$intTrashId]);
        
             $this->Flash->success(__('The category has been deleted'));
              
        } else
        {
             $this->Flash->error(__('The category could not be deleted. Please, try again.'));
              
        }
            return $this->redirect(['action' => 'index']);
     
 }
 
 public function makepopular($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkCategory->get($id);
   $aryPostData =array();
   if($category->get('category_popular')==1)
      {
         $aryPostData['category_popular'] = 0;
      }
   else
      {
         $aryPostData['category_popular'] = 1;
    
      }
  $category =$this->SkCategory->patchEntity($category,$aryPostData);
  if($this->SkCategory->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
 public function status($id=null)
{

   $this->request->allowMethod(['get']);
   $category = $this->SkCategory->get($id);
   $aryPostData =array();
   if($category->get('category_status')==1)
      {
         $aryPostData['category_status'] = 0;
      }
   else
      {
         $aryPostData['category_status'] = 1;
    
      }
  $category =$this->SkCategory->patchEntity($category,$aryPostData);
  if($this->SkCategory->save($category))
    	    {
    	        $this->Flash->success(__('Status Update Successfully.'));
    	        return $this->redirect(['action' => 'index']);
    	    }
}
  function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
         
        if ($element['category_parent'] == $parentId) {
            $children = $this->buildTree($elements, $element['category_id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}   
}
 