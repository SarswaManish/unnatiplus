<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;

?>
<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Enquiry</span> - Manage Help & Support</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Manage Help & Support</li>
</ul>
</div>
</div>
<div class="content">
<?= $this->Flash->render();  ?>
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Help & Support</h5>
<div class="heading-elements">
    

</div>
</div>
<div class="panel-body" style="background:#f5f5f5;">
<div class="row">
<?php echo  $this->Form->create('', ['url'=>'/admin/helpAndSupport/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
<div class="col-md-4">
<div class="input-group">
<select class="form-control" onclick="Selectstaus()" name="bulkaction" >
<option>Bulk Action</option>
<option value="1">Delete</option>
</select>
<span class="input-group-btn">
<button type="submit" class="btn bg-teal" id="bulkaction-button" style="height:39px;">Apply</button>
</span>
</div>
</div>
</div>
</div>
<table class="table table-striped">
<thead>
<tr>
<th style="text-align:left; width:10px; "><input type="checkbox" id="selectAll"></th>
<th>S.no</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Message</th>
<th style="text-align:center;">Publish Date</th>
<th class="text-center"><i class="icon-arrow-down12"></i></th>
</tr>
</thead>
<tbody>
<?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
$count=0;
if(count($resCouponInfo)>0)
{
foreach($resCouponInfo as $rowCouponInfo):
?>
<tr>
<td style="text-align:left">
<input type="checkbox" name="hs_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowCouponInfo->hs_id);  ?>">
</td>
<td> <?php echo ++$count; ?></td>
<td><?= h($rowCouponInfo->hs_fname.' '.$rowCouponInfo->hs_lname) ?></td>
<td><?= h((($rowCouponInfo->hs_email!='')?$rowCouponInfo->hs_email:'-')); ?></td>
<td><?= h((($rowCouponInfo->hs_mobile!='')?$rowCouponInfo->hs_mobile:'-')); ?></td>
<td><?= h((($rowCouponInfo->hs_message!='')?$rowCouponInfo->hs_message:'-')); ?></td>

<td style="text-align:center"><?= date("d M, Y", strtotime($rowCouponInfo->hs_created_date)) ?></td>
<td class="text-center">
	<ul class="icons-list">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li><a href="<?php echo $this->Url->build('/admin/helpAndSupport/deletepermanently/'.$rowCouponInfo->hs_id); ?>" style="padding:3px 15px">Delete</a></li>
			</ul>
		</li>
	</ul>
</td>
</tr>
<?php endforeach;
}else{ ?>
<tr><td colspan="8" class="text-center">No Result Found</td></tr>
<?php } ?>
</tbody>
</table>
<div class="datatable-footer" >

<div class="dataTables_info"><?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?></div>
<div class="dataTables_paginate paging_simple_numbers">

<?= $this->Paginator->prev('???',['class'=>'paginate_button previous']); ?>
<span>
<?= $this->Paginator->numbers(); ?>
</span>
<?= $this->Paginator->next(' ???'); ?>

</div>

</div>

</div>
						
	</div>				
					 <?= $this->Form->end() ?>
