<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">User</span> - Manage Staff</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Manage Staff</li>
</ul>
</div>
</div>
<div class="content">
<?= $this->Flash->render();  ?>
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Staff Listing</h5>
<div class="heading-elements">
								<a href="<?php echo SITE_URL; ?>admin/staff/addstaff" class="btn btn-primary"><i class="icon-file-plus position-left"></i> Add New</a>
		                	</div>
</div>
<div class="panel-body" style="background:#f5f5f5;">
<div class="row">
 <?php echo  $this->Form->create('', ['url'=>'/admin/staff/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
<div class="col-md-4">
<div class="input-group">
<select class="form-control" onclick="Selectstaus()" name="bulkaction">
<option>Bulk Action</option>
<option value="1">Delete</option>
<option value="2">Active</option>
<option value="3">Inactive</option>
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
<th style="text-align:left; width:1%; "><input type="checkbox" id="selectAll"></th>
<th style="text-align:left; width:30%; ">Staff Information</th>
<th>Role</th>

<th style="text-align:center;">Publish Date</th>
<th style="text-align:center;">Status</th>
<th style="text-align:center; width:180px;">Action</th>
</tr>
</thead>
<tbody>
<?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
if(count($resCouponInfo)>0)
{
foreach($resCouponInfo as $rowCouponInfo):

$rowRoleInfo = $resRoleInfo->find('all')->where(['role_id'=>$rowCouponInfo->admin_role_id])->first();?>
<tr>
<td style="text-align:left">
<input type="checkbox" name="admin_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowCouponInfo->admin_id);  ?>">
</td>
<td><?= h($rowCouponInfo->admin_first_name.' '.$rowCouponInfo->admin_first_name) ?><br>
<?= (($rowCouponInfo->admin_login_email!='')?'<strong>Email: </strong>'. $rowCouponInfo->admin_login_email:'-'); ?><br><?= (($rowCouponInfo->admin_mobile_number!='')?'<strong>Mobile: </strong>'. $rowCouponInfo->admin_mobile_number:'-'); ?></td>
<td ><?= $rowRoleInfo->role_name; ?></td>
<td style="text-align:center"><?= date("d M, Y", strtotime($rowCouponInfo->admin_publish_date)) ?></td>
<td style="text-align:center"> 

<a href="<?php echo SITE_URL; ?>admin/staff/status/<?php echo $rowCouponInfo->admin_id; ?>" onclick="return confirm('Are you sure you want to change the status')"><?php echo $arrayStatus[$rowCouponInfo->admin_status]; ?></a>



  </td>
<td style="text-align:center">

<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">

											<li><a href="<?php echo SITE_URL; ?>admin/staff/addstaff/<?php echo $rowCouponInfo->admin_id; ?>" style="padding:3px 15px">Edit</a></li>						
											<li><a href="<?php echo SITE_URL; ?>admin/staff/delete/<?php echo $rowCouponInfo->admin_id; ?>" style="padding:3px 15px">Delete</a></li>						
															</ul>
														</li>
													</ul>
													
													
</td>
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
