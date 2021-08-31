
			    
			    
<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Manage Permission </h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/admin/"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Manage Permission</li>
						</ul>

					</div>
				</div>

			<div class="content">
			    <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'permission-form','url'=>'']); ?>

			    <div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Manage Permission For <?php echo $rowRoleInfo->role_name; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
<div class="heading-elements">
<button type="submit" name="submit" class="btn btn-success"> Save</button>
</div>

<a class="heading-elements-toggle"><i class="icon-menu"></i></a>
</div>
<div class="panel-body" style="padding:0px">
    <input type="hidden" value="<?php echo $rowRoleInfo->role_id; ?>" name="role_id" >
<table class="table table-striped">
     <tr>
     <th>
       Permission Name
     </th>
      <th>
      Entry
     </th>
      <th>
      Delete
     </th>
      <th>
      View
     </th>
     </tr>
   <?php foreach($resPermission as $rowPermission) 
   { 
   
   $rowPermissionChecked = $resPermissionData->find('all')->where(['pd_role'=>$rowRoleInfo->role_id,'pd_permission_id'=>$rowPermission->permission_id])->first(); 
   
   ?>
   
    <tr>
     <td>
       <?php echo $rowPermission->permission_key; ?> 
     </td>
     <td>
      <input type="checkbox"  <?php if(isset($rowPermissionChecked->pd_entry) && $rowPermissionChecked->pd_entry==1) { echo 'checked'; } ?> name="permission[<?php echo $rowPermission->permission_id; ?>][]" value="1">  
    </td>
      <td>
      <input type="checkbox" <?php if(isset($rowPermissionChecked->pd_delete) && $rowPermissionChecked->pd_delete==1) { echo 'checked'; } ?> name="permission[<?php echo $rowPermission->permission_id; ?>][]" value="2">  
    </td>
      <td>
      <input type="checkbox" <?php if(isset($rowPermissionChecked->pd_view) && $rowPermissionChecked->pd_view==1) { echo 'checked'; } ?> name="permission[<?php echo $rowPermission->permission_id; ?>][]" value="3">  
    </td>
    </tr>
    <?php } ?>
</table>

</div>
</div>

				    <?= $this->Form->end() ?>
