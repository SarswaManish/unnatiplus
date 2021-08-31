<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=11 ')->fetch('assoc');
 
 

if(!isset($rowSelectPermission['pd_id']) && $rowAdminInfo['admin_default']==0)
{
    
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
  
}
?>
<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Roles</span> - Manage Roles</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Manage Roles</li>
</ul>
</div>
</div>
<div class="content">
<?= $this->Flash->render();  ?>
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Roles Listing</h5>
<div class="heading-elements">
        <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
    <a href="<?php echo SITE_URL; ?>admin/roles/addrole" class="btn btn-primary"><i class="icon-file-plus position-left"></i> Add New</a>
	<?php } ?>
</div>
</div>

<table class="table table-striped">
<thead>
<tr>
<th style="text-align:left; width:10px; ">
    <input type="checkbox" id="selectAll"></th>
    <th>S.no</th>

<th>Role</th>

<th style="text-align:center;">Publish Date</th>
<th style="text-align:center; width:180px;">Action</th>
</tr>
</thead>
<tbody>
<?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
$counter =0;
if(isset($resRolesList) && count($resRolesList)>0)
{
foreach($resRolesList as $rowRolesInfo):
$counter++;
if($rowRolesInfo->role_id!=3)
{
?>
<tr>
<td style="text-align:left">
<input type="checkbox" name="role_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowRolesInfo->role_id);  ?>">
</td>
<td><?= h($counter) ?></td>

<td><?= h($rowRolesInfo->role_name) ?></td>


<td style="text-align:center"><?= date("d M, Y", strtotime($rowRolesInfo->role_publish_Date)) ?></td>

<td style="text-align:center">

<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">

		<?php if($rowSelectPermission['pd_entry']==1)
{ ?>
<li><a href="<?php echo SITE_URL; ?>admin/roles/managepermission/<?php echo $rowRolesInfo->role_id; ?>" style="padding:3px 15px">Manage Permission</a></li>	
<?php } ?>
															</ul>
														</li>
													</ul>
													
													
</td>
</tr>
<?php } endforeach;
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
