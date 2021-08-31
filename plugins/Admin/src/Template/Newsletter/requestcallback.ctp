<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=18 ')->fetch('assoc');
 
 

if(!isset($rowSelectPermission['pd_id']))
{
    
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
  
}
?>
<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Request a Call Back</span> </h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Manage Request a Call Back</li>
</ul>
</div>
</div>
<div class="content">
<?= $this->Flash->render();  ?>
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Request a Call Back Listing</h5>
<div class="heading-elements">
    

</div>
</div>
<div class="panel-body" style="background:#f5f5f5;">
<div class="row">
 <?php echo  $this->Form->create('', ['url'=>'/admin/newsletter/bulkactionrequest','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
<div class="col-md-4">
<div class="input-group">
<select class="form-control" onclick="Selectstaus()" name="bulkaction">
<option>Bulk Action</option>
						    <?php if($rowSelectPermission['pd_delete']==1)
{ ?>
<option value="1">Delete</option>
<?php } ?>

</select>
<span class="input-group-btn">
<button type="submit" class="btn bg-teal" id="bulkaction-button" style="    height: 39px;">Apply</button>
</span>
</div>
</div>
</div>
</div>
<table class="table table-striped">
<thead>
<tr>
<th style="text-align:left; width:10px; "><input type="checkbox" id="selectAll"></th>
<th>Name</th>
<th>Mobile</th>

<th style="text-align:center;">Publish Date</th>
</tr>
</thead>
<tbody>
<?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
if(count($resCouponInfo)>0)
{
foreach($resCouponInfo as $rowCouponInfo):
?>
<tr>
<td style="text-align:left">
<input type="checkbox" name="rcb_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowCouponInfo->rcb_id);  ?>">
</td>
<td><?= h((($rowCouponInfo->rcb_fullname!='')?$rowCouponInfo->rcb_fullname:'-')); ?></td>
<td><?= h((($rowCouponInfo->rcb_mobile!='')?$rowCouponInfo->rcb_mobile:'-')); ?></td>

<td style="text-align:center"><?= date("d M, Y", strtotime($rowCouponInfo->rcb_date)) ?></td>

</tr>
<?php endforeach;
}else{ ?>
<tr><td colspan="5" class="text-center">No Result Found</td></tr>
<?php } ?>
</tbody>
</table>
<div class="datatable-footer" >

<div class="dataTables_info"><?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?></div>
							<div class="dataTables_paginate paging_simple_numbers">
							    
							    <?= $this->Paginator->prev('←',['class'=>'paginate_button previous']); ?>
							    <span>
<?= $this->Paginator->numbers(); ?>
</span>
<?= $this->Paginator->next(' →'); ?>

							</div>
							
</div>

</div>
						
	</div>				
					 <?= $this->Form->end() ?>
