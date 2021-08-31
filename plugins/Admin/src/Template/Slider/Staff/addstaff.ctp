<?php use Cake\View\Helper\SecurityMaxHelper;
?>
	<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - <?php echo isset($rowTaxInfo['tax_id'])?'Edit':'Add'; ?> Staff</h4>
						</div>

						
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo SITE_URL; ?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Staff</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
  <div class="content">
  <?php 
  echo  $this->Form->create('', ['type' => 'POST','id'=>'staff-form','url'=>'/admin/staff/staffProcessRequest']); ?>
	<input type="hidden" name="staff_id" value="<?php echo isset($resAdminInfo['admin_id'])?$resAdminInfo['admin_id']:0; ?>">
					<!-- Dashboard content -->
					<div class="row">
					<div class="col-lg-8">
					<div class="panel panel-default">
					<div class="panel-heading">
							<h5 class="panel-title">Staff Details</h5>
							
						</div>
					<div class="panel-body" style="padding:20px 15px;">
					    
					    <div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Role: <span style="color:red">*</span></label>
					<div>
					<div class="input text required">
					  <select name="admin_role_id" class="form-control" required> 
					      <option>Select Role</option>
					     <?php foreach($resRoleInfo as $rowRoleInfo)
					     {
					     
					     $strSelect = (isset($resAdminInfo['admin_role_id']) && $resAdminInfo['admin_role_id']==$rowRoleInfo->role_id)?'selected="selected"':''; ?>
					      <option  <?php echo $strSelect; ?> value="<?php echo $rowRoleInfo->role_id; ?>"><?php echo $rowRoleInfo->role_name; ?></option>
					      <?php } ?>
					  </select>
					    </div>   
					
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">First Name: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="admin_first_name"  placeholder="Enter First Name"  class="form-control" id="staff_name" value="<?php echo isset($resAdminInfo['admin_first_name'])?$resAdminInfo['admin_first_name']:''; ?>" type="text"></div>   
					
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Last Name: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="admin_last_name"  placeholder="Enter Last Name"  class="form-control" id="staff_name" value="<?php echo isset($resAdminInfo['admin_last_name'])?$resAdminInfo['admin_last_name']:''; ?>" type="text"></div>   
					
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Email: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="admin_login_email"  placeholder="Enter Email"  class="form-control" id="admin_login_email" value="<?php echo isset($resAdminInfo['admin_login_email'])?$resAdminInfo['admin_login_email']:''; ?>" type="text"></div>   
					
					</div>
					</div>
                    <div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Phone Number: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="admin_mobile_number"  placeholder="Enter Phone Number"  class="form-control" id="admin_mobile_number" value="<?php echo isset($resAdminInfo['admin_mobile_number'])?$resAdminInfo['admin_mobile_number']:''; ?>" type="text"></div>   
					
					</div>
					</div>
                   <div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Password: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="admin_password"  placeholder="Enter Password"  class="form-control" id="staff_password" value="<?php echo isset($resAdminInfo['admin_password'])?SecurityMaxHelper::decryptIt($resAdminInfo['admin_password']):''; ?>" type="text"></div>   
					
					</div>
					</div>

					</div>
					</div>
					
							
					
					</div>
					<div class="col-lg-4">
					<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:20px !important;">
					<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group22">Publish</a>
										</h6>
									</div>
									<div id="accordion-control-right-group22" class="panel-collapse collapse in">
									
										<div class="panel-body" style="background:#f5f5f5; padding:10px 15px;">
										<button type="submit" name="new" class="btn btn-success  btn-xs" style="float:right;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);"> Publish</button>
										</div>
									</div>
								</div>
					</div>
							
					</div>
					
						</div>
					<!-- /dashboard content -->
	<?= $this->Form->end() ?>
	</div>
	<script>var csrf_tocken=<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>
	<!-- /page container -->