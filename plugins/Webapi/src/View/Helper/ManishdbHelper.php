<?php namespace Admin\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\View\Helper\FormHelper;
use Cake\View\Helper\Html;
class ManishdbHelper extends Helper
{

static function getcategorydropdowntreestructure($resCatObject,$strHtml='',$intCatParent=0,$intCntParentLevel=0)
{

$resCategoryList =$resCatObject->find('all')->where(['category_parent'=>$intCatParent]);

foreach($resCategoryList as $rowCategoryList)
{
if($intCatParent==0)
{
$intCntParentLevel = 0;

}
$strExtraHtml = '';
for($i=0;$i<$intCntParentLevel;$i++)
{

$strExtraHtml .=' - '; 
}
echo '<option value="'.$rowCategoryList->category_id.'">'.$strExtraHtml.$rowCategoryList->category_name.'</option>';

if($rowCategoryList->category_parent<=0)
{
$intCntParentLevel++;

self::getcategorydropdowntreestructure($resCatObject,$strHtml,$rowCategoryList->category_id,$intCntParentLevel);
}
}


}

function getCategoryHtml($resCatObject,$strHtml='',$intCatParent=0,$intCntParentLevel=0,$arrayStatus,$formhelper,$htmlhelper)
{

$resCategoryList =$resCatObject->find('all')->where(['category_parent'=>$intCatParent]);


foreach($resCategoryList as $rowCategoryList)
{
$strBackground='';
if($intCatParent==0)
{
$intCntParentLevel = 0;

}else{

$strBackground ='background:#f5f5f5';
}
$strExtraHtml = '';
for($i=0;$i<$intCntParentLevel;$i++)
{

$strExtraHtml .='<span class="dash"></span>'; 
}
echo '<tr style="'.$strBackground .'" ><td><input type="checkbox" name="category_id[]" class="checkbox clsSelectSingle" value="'.$rowCategoryList->category_id.'"></td>
<td class="category_title">'.$strExtraHtml.$rowCategoryList->category_name.'</td><td style="text-align:center"> 
'.$formhelper->postLink(__($arrayStatus[$rowCategoryList->category_status]), ['action' => 'status', $rowCategoryList->category_id],['class'=>'','escape'=>false,'confirm' => __('Are you sure you want to change the status?', $rowCategoryList->category_name)]).'</td>
<td style="text-align:center" >'.$htmlhelper->link(__('<i class="icon-pencil7 "></i>'), ['action' => 'index', $rowCategoryList->category_id],['class'=>'btn btn-info btn-icon','escape'=>false]).' '.$formhelper->postLink(__('<i class="icon-trash "></i>'), ['action' => 'delete', $rowCategoryList->category_id],['class'=>'btn btn-danger btn-icon','escape'=>false,'confirm' => __('Are you sure you want to delete # {0}?', $rowCategoryList->category_name)]).'</td></tr>';
$intCntParentLevel++;

self::getCategoryHtml($resCatObject,$strHtml,$rowCategoryList->category_id,$intCntParentLevel,$arrayStatus,$formhelper,$htmlhelper);
$intCntParentLevel--;
}


}

}


?>