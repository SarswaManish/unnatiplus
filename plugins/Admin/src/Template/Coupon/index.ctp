<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=8 ')->fetch('assoc');
 
 

if(!isset($rowSelectPermission['pd_id']))
{
    
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
  
}
?><!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Coupon</span> - Manage Coupon</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Manage Coupon</li>
</ul>
</div>
</div>
<div class="content">
<?= $this->Flash->render();  ?>
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Coupon Listing</h5>
<div class="heading-elements">
     <?php if($rowSelectPermission['pd_entry']==1)
{ ?>   
<?= $this->Html->link(__('<i class="icon-file-plus position-left"></i> Add New'), ['action' => 'addcoupon'],['class'=>'btn btn-primary','escape'=>false]) ?> 
<?php } ?>
</div>
</div>
<div class="panel-body" style="background:#f5f5f5;">
<div class="row">
 <?php echo  $this->Form->create('', ['url'=>'/admin/coupon/bulkaction','type' => 'POST','id'=>'bulkaction','enctype'=>'multipart/form-data','class'=>'form-horizontal']); ?>
<div class="col-md-4">
<div class="input-group">
<select class="form-control" onclick="Selectstaus()" name="bulkaction">
<option>Bulk Action</option>
 <option value="1">Delete</option>
  <option value="2">Active</option>
  <option value="3">Inactive</option>
</select>
<span class="input-group-btn">
<button type="submit" class="btn bg-teal" id="bulkaction-button" style="height: 39px;">Apply</button>
</span>
</div>
</div>
</div>
</div>
<table class="table table-striped">
<thead>
<tr>
<th style="text-align:left; width:10px; "><input type="checkbox" id="selectAll"></th>
<th> S.no</th>
<th> Name</th>
<th style="text-align:center;">Active From </th>
<th style="text-align:center; ">Active To</th>
<th style="text-align:center; ">Coupon Code</th>
<th style="text-align:center;">Status</th>
<th style="text-align:center; width:180px;">Action</th>
</tr>
</thead>
<tbody>
<?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
$count=0;
foreach($resCouponInfo as $rowCouponInfo):?>
<tr>
<td style="text-align:left">
<input type="checkbox" name="coupon_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowCouponInfo->coupon_id) ?>">
</td>
<td> <?php echo ++$count; ?></td>
<td><?= h($rowCouponInfo->coupon_title) ?></td>
<td style="text-align:center"><?= date("d M, Y", strtotime($rowCouponInfo->coupon_active_from)) ?></td>
<td style="text-align:center"><?= date("d M, Y", strtotime($rowCouponInfo->coupon_active_to)) ?></td>
<td style="text-align:center"><?= h($rowCouponInfo->coupon_code) ?></td>
<td style="text-align:center"> 

<?php
$currentDate=date("Y-m-d");
$couponEndDate=date("Y-m-d",strtotime($rowCouponInfo->coupon_active_to));

 if($couponEndDate>$currentDate)
 {
	 ?>
<?= $this->Form->postLink(__($arrayStatus[$rowCouponInfo->coupon_status]), ['action' => 'status', $rowCouponInfo->coupon_id],['class'=>'','escape'=>false,'confirm' => __('Are you sure you want to change the status # {0}?', $rowCouponInfo->coupon_title)]) ?>
 <?php } else 
 { ?>
	 <span class="label label-default">Expire</span>
	 
<?php }?>

  </td>
<td style="text-align:center">

<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">
															        <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
																<li><a href="<?php echo SITE_URL; ?>admin/coupon/addcoupon/<?php echo $rowCouponInfo->coupon_id; ?>" style="padding:3px 15px">Edit</a></li>
									<?php } ?>
									    <?php if($rowSelectPermission['pd_delete']==1)
{ ?>
																
											<li><a href="<?php echo SITE_URL; ?>admin/coupon/delete/<?php echo $rowCouponInfo->coupon_id; ?>" style="padding:3px 15px">Delete</a></li>		<?php } ?>				
															</ul>
														</li>
													</ul>
													
													
</td>
</tr>
<?php endforeach; ?>
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