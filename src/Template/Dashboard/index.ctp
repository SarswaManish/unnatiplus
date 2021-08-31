<?php $rowUserInfo =  $this->request->getSession()->read('USER');?>

<section class="pt-20 pb-20">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ul class="breadcrum mb-20">
<li><a href="<?php echo SITE_URL; ?>">Home</a></li>
<li><a href="javascript:;" style="text-transform: capitalize;">Myaccount</a></li>
</ul>
</div>
</div>

 	 
		<div class="row">
		<div class="col-lg-3">
		<div class="my-account-header text-center">
<!--	<div class="avtar"><img src="<?php echo SITE_URL; ?>img/avtar.png" alt=""></div>-->
	<div class="avtar-details">
	<div class="name"><?php echo $rowUserInfo['user_first_name'].' '.$rowUserInfo['user_last_name']; ?></div>
	<div class="phone">+91 <?php echo $rowUserInfo['user_mobile']; ?></div>
	<div class="email"><?php echo $rowUserInfo['user_email_id']; ?></div>
	</div>
	</div>
	<div class="list-group">
	<a href="<?php echo SITE_URL; ?>dashboard" class="list-group-item active">My Account</a>
	<a href="<?php echo SITE_URL; ?>order" class="list-group-item ">My Orders</a>
	<a href="<?php echo SITE_URL; ?>address" class="list-group-item ">My Address</a>
    <a href="<?php echo SITE_URL; ?>dashboard/logout" class="list-group-item">Logout</a>
	</div>
		</div>
		<div class="col-lg-9">
				 <?php  echo $this->Flash->render(); ?>

		<div class="pannel-box " style="margin-bottom:20px">
		<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'profileupdate','url'=>'','class'=>'']); ?>

		<div class="pannel-title"><h3>Personal Information | <a href="javascript:;" style="color:#eb268f;" onclick="setEditPerformance()" id="editprofile">Edit</a></h3></div>
		<div class="pannel-body">

		<div class="das-form">
		<div class="das-form-box">
		<div class="row">
		<div class="col-lg-6"><label>First Name</label><input type="hidden" name="user_id" value="<?php echo $rowUserInfo['user_id']; ?>" >
		<input class="profile_input" type="text" name="user_first_name" value="<?php echo $rowUserInfo['user_first_name']; ?>" style="background:#f5f5f5" readonly></div>
		<div class="col-lg-6"><label>Last Name</label><input class="profile_input" type="text" name="user_last_name" value="<?php echo $rowUserInfo['user_last_name']; ?>" style="background:#f5f5f5" readonly></div>
		</div>
		</div>
		<div class="das-form-box">
		<div class="row">
		<div class="col-lg-6"><label>Email Address</label><input class="profile_input" type="text" name="user_email_id" value="<?php echo $rowUserInfo['user_email_id']; ?>" style="background:#f5f5f5" readonly></div>
		<div class="col-lg-6"><label>Mobile Number</label><input class="profile_input" type="text" name="user_mobile" value="<?php echo $rowUserInfo['user_mobile']; ?>" style="background:#f5f5f5" readonly></div>
		</div>
		</div>
		<div class="das-form-box" id="editprofilebutton" style="display:none">
		<button type="submit"  onclick="return profileupdate($(this))" class="btn btn-success">Save</button>
		</div>
		</div>
		</div>
		<?php echo  $this->Form->end(); ?>

		</div>
		<div class="pannel-box">
				<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'changepassword','url'=>'/dashboard/changepassword','class'=>'']); ?>

		<div class="pannel-title"><h3>Change Password</h3></div>
		<div class="pannel-body">

		<div class="das-form">
		<div class="das-form-box">
		<div class="row">
		<div class="col-lg-12"><label>Old Password</label><input type="hidden" name="user_id" value="<?php echo $rowUserInfo['user_id']; ?>" ><input type="password" name="old_password"></div>
		</div>
		</div>
		<div class="das-form-box">
		<div class="row">
		<div class="col-lg-6"><label>New Password</label><input type="password" name="new_password"></div>
		<div class="col-lg-6"><label>Confirm New Password </label><input type="password" name="conf_password"> </div>
		</div>
		</div>
		<div class="das-form-box">
		<button type="submit" onclick="return changepassword($(this))" class="btn btn-success">Save</button>
		</div>
		</div>
		
		</div>
				<?php echo  $this->Form->end(); ?>

		</div>
		</div>
		</div>
		
		</div>
		</section>
	 
	 <script>
	 function setEditPerformance()
	 {
		 $('#editprofile').hide();
		 $('#editprofilebutton').show();
		 $('.profile_input').attr('readonly',false);
		  $('.profile_input').attr('style','');
		 
	 }
	 function profileupdate(objectElement)
	 {
		 
		 var firstname = $('input[name="user_first_name"]').val();
		 if(firstname.trim()=='')
		 {
			 $('input[name="user_first_name"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="user_first_name"]').attr('style','');
		 }
		 
		 var user_last_name = $('input[name="user_last_name"]').val();
		 if(user_last_name.trim()=='')
		 {
			 $('input[name="user_last_name"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="user_last_name"]').attr('style','');
		 }
		  var user_email_id = $('input[name="user_email_id"]').val();
		 if(user_email_id.trim()=='')
		 {
			 $('input[name="user_email_id"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="user_email_id"]').attr('style','');
		 }
		  var user_mobile = $('input[name="user_mobile"]').val();
		 if(user_mobile.trim()=='')
		 {
			 $('input[name="user_mobile"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="user_mobile"]').attr('style','');
		 }
				 objectElement.html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i> Save');	

	 }
	 
	 function changepassword(objectElement)
	 {
		 
		   var old_password = $('input[name="old_password"]').val();
		 if(old_password.trim()=='')
		 {
			 $('input[name="old_password"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="old_password"]').attr('style','');
		 }
		 
		   var new_password = $('input[name="new_password"]').val();
		 if(new_password.trim()=='')
		 {
			 $('input[name="new_password"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="new_password"]').attr('style','');
		 }
		 
		   var conf_password = $('input[name="conf_password"]').val();
		 if(conf_password.trim()=='')
		 {
			 $('input[name="conf_password"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="conf_password"]').attr('style','');
		 }
		 
		 if(conf_password!=new_password)
		 {
			 $('input[name="new_password"]').attr('style','border:1px solid red;');
			 $('input[name="conf_password"]').attr('style','border:1px solid red;');
			 return false;	 
		 }else{
			  $('input[name="conf_password"]').attr('style','');
			  $('input[name="new_password"]').attr('style','');
		 }
		  objectElement.html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i> Save');	
	 }
	 </script>