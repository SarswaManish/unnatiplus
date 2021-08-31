<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=7 ')->fetch('assoc');
 
 

if(!isset($rowSelectPermission['pd_id']))
{
    
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
  
}
?>
<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Shipping Rates</span> - Shipping Rates</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Shipping Rates</li>
</ul>
</div>
</div>
<div class="content">
<?= $this->Flash->render();  ?>
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Shipping Rate Listing</h5>
<div class="heading-elements">
     <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
<?= $this->Html->link(__('<i class="icon-file-plus position-left"></i> Add New'), ['action' => 'addshipping'],['class'=>'btn btn-primary','escape'=>false]) ?> 
<?php } ?>
</div>
</div>
<div class="panel-body" style="background:#f5f5f5;">
<div class="row">
 <?php echo  $this->Form->create('', ['url'=>'/admin/shipping/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
<div class="col-md-4">
<div class="input-group">
<select class="form-control" onclick="Selectstaus()" name="bulkaction" >
<option>Bulk Action</option>
<option value="1">Delete</option>
<option value="2">Active</option>
<option value="3">Inactive</option>
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
<th> S.no</th>
<th> State Name</th>
<th style="text-align:center;">Country </th>
<th style="text-align:center; ">Delivery Charge</th>
<th style="text-align:center;">Status</th>
<th style="text-align:center; width:180px;">Action</th>
</tr>
</thead>
<tbody>
<?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
$count=0;
foreach($resShippingList as $rowShippingInfo):

$rowStateInfo =$resState->find('all')->where(['state_id'=>$rowShippingInfo->shipping_state])->first();
?>
<tr>
<td style="text-align:left">
<input type="checkbox" name="shipping_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowShippingInfo->shipping_id) ?>">
<input type="hidden" name="shipping_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowShippingInfo->shipping_id) ?>">
</td>
<td> <?php echo ++$count; ?></td>
<td><?= h($rowStateInfo->state_name) ?></td>
<td style="text-align:center"><?= h($rowShippingInfo->shipping_country) ?></td>
<td style="text-align:center"><?= h($rowShippingInfo->shipping_rate) ?></td>
<td style="text-align:center"> 


<?= $this->Form->postLink(__($arrayStatus[$rowShippingInfo->shipping_status]), ['action' => 'status', $rowShippingInfo->shipping_id],['class'=>'','escape'=>false,'confirm' => __('Are you sure you want to change the status # {0}?', $rowShippingInfo->state_name)]); ?>
 

  </td>
<td style="text-align:center">

<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">
															    					    <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
																<li><a href="<?php echo SITE_URL; ?>admin/shipping/addshipping/<?php echo $rowShippingInfo->shipping_id; ?>" style="padding:3px 15px">Edit</a></li>
								<?php } ?>										
							    <?php if($rowSelectPermission['pd_delete']==1)
{ ?>														
											<li><a href="<?php echo SITE_URL; ?>admin/shipping/deletepermanently/<?php echo $rowShippingInfo->shipping_id; ?>" style="padding:3px 15px">Delete</a></li>	<?php } ?>					
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