<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - My Profile</h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">My Profile</li>
		</ul>
	</div>
</div>
<div class="content">
  <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/myprofile/profileUpdateProcessRequest','enctype'=>'multipart/form-data']); ?>
	<!-- Dashboard content -->
	<input name="admin_id" value="<?php echo $rowAdminInfo['admin_id']; ?>" placeholder="First Name" required="" class="form-control" id="user_name" type="hidden">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">My Profile</h5>
					<div class="heading-elements">
                    <button type="Submit" class="btn btn-success">Update</button>
                </div>
			    </div>
			    
				<div class="panel-body" style="padding:20px 15px;">
				    <div class="row">
				        <div class="col-md-6">
				            <div class="form-group" style="margin-bottom: 10px;">
            					<label class="control-label">First Name: <span style="color:red">*</span></label>
            					<div>
            					    <div class="input text required"><input name="admin_first_name" onkeyup="return getproductslug(this.value)" placeholder="Enter First Name"  class="form-control" id="admin_first_name" value="<?php echo isset($rowAdminInfo['admin_first_name'])?$rowAdminInfo['admin_first_name']:''; ?>" type="text"></div>   
            					</div>
        					</div>
				        </div>
				        <div class="col-md-6">
				            <div class="form-group" style="margin-bottom: 10px;">
    					<label class="control-label">Last Name: <span style="color:red">*</span></label>
    					<div>
    					<div class="input text required"><input name="admin_last_name" onkeyup="return getproductslug(this.value)" placeholder="Enter Last Name"  class="form-control" id="admin_last_name" value="<?php echo isset($rowAdminInfo['admin_last_name'])?$rowAdminInfo['admin_last_name']:''; ?>" type="text"></div>   
    					</div>
    					</div>
				        </div>
				    </div>
			        <div class="row">
					        <div class="col-md-6">
					            <div class="form-group" style="margin-bottom: 10px;">
        					<label class="control-label">Email: <span style="color:red">*</span></label>
        					<div>
        					<div class="input text required"><input name="admin_login_email" onkeyup="return getproductslug(this.value)" placeholder="Enter Email"  class="form-control" id="admin_login_email" value="<?php echo isset($rowAdminInfo['admin_login_email'])?$rowAdminInfo['admin_login_email']:''; ?>" type="text"></div>   
        					</div>
        					</div>
					        </div>
					        <div class="col-md-6">
					            <div class="form-group" style="margin-bottom: 10px;">
        					<label class="control-label">Phone No: <span style="color:red">*</span></label>
        					<div>
        					<div class="input text required"><input name="admin_mobile_number" onkeyup="return getproductslug(this.value)" placeholder="Enter Phone No"  class="form-control" id="admin_mobile_number" value="<?php echo isset($rowAdminInfo['admin_mobile_number'])?$rowAdminInfo['admin_mobile_number']:''; ?>" type="text"></div>   
        					</div>
        					</div>
					        </div>
					    </div>
				    <div class="row">
					        <div class="col-md-6">
					            <div class="form-group" style="margin-bottom: 10px;">
        					<label class="control-label">Password: <span style="color:red">*</span></label>
        					<div>
        					<div class="input text required"><input name="admin_password" onkeyup="return getproductslug(this.value)" placeholder="Enter Pasword"  class="form-control" id="admin_password" value="" type="text"></div>   
        					</div>
        					</div>
					        </div>
					    </div>
    	        </div>
			</div>
</div>
</div>
					<!-- /dashboard content -->
	<?= $this->Form->end() ?>
	</div>