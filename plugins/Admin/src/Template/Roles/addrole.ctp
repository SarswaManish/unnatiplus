<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Roles</span> - Add Roles</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Add Roles</li>
</ul>
</div>
</div>
<div class="content">
					<!-- Dashboard content -->
			  <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/roles/RolesProcessRequest','enctype'=>'multipart/form-data']); ?>
		
					<div class="panel panel-default">
					    <div class="panel-heading">
<h5 class="panel-title">Add Roles<a class="heading-elements-toggle"><i class="icon-more"></i></a><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
<div class="heading-elements">
<a href="<?php echo SITE_URL; ?>admin/roles/" class="btn btn-default"><i class="icon-chevron-left"></i> Back</a>
<button type="submit" class="btn btn-success"> Save</button>
</div>
</div>
					<div class="panel-body" style="padding:20px 15px;">


<div class="form-group">
<label class="control-label col-lg-2">Role: <span style="color:red">*</span></label>
<div class="col-lg-10">
<input type="text" name="role_name" value="" class="form-control">
	</div>	
</div>
		

					
						</div>
							</div>
								<?= $this->Form->end() ?>

					<!-- /dashboard content -->

		
