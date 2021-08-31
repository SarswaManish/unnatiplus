<?php $rowAdminInfo =  $this->request->getSession()->read('USER');?>

<section>
<div class="container-fluid">
<div class="prod-list-section">
<?= $this->element('myaccount');?>
<div class="pls-right">
<div class="my-pro-contetnt">
<div class="my-pro-contetnt-body">
<ul class="breadcrum mb-10">
<li><a href="#"><i class="fa fa-home"></i></a></li>
<li><a href="#">My Account</a></li>
<li><a href="javascript:;">Profile Inforamation</a></li>
</ul>
<div class="my-pro-contetnt-title">Profile Inforamation</div>
    <div class="lr-box">
    <?= $this->Flash->render() ?>
    <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'user-form','url'=>'','enctype'=>'multipart/form-data']); ?>
        <input type="hidden" class="form-control" name="user_id" value="<?php echo $rowAdminInfo['user_id']; ?>">
    <div class="row">
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>First Name</label>
                <input type="text" class="form-control" required name="user_first_name" value="<?php echo $rowAdminInfo['user_first_name']; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Last Name:</label>
                <input type="text" class="form-control" required name="user_last_name" value="<?php echo $rowAdminInfo['user_last_name']; ?>">

            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="lr-form-box">
                <label> Mobile:</label>
                <input type="text" class="form-control" required name="user_mobile" minlength="10" maxlength="10" value="<?php echo $rowAdminInfo['user_mobile']; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label> Email:</label>
                <input type="email" class="form-control" required name="user_email_id" value="<?php echo $rowAdminInfo['user_email_id']; ?>">
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="lr-form-box">
                <label> Profile Image:</label>
                <input type="file" class="form-control" name="user_profile_"id="file" onchange="return fileValidation()" value="<?php echo $rowAdminInfo['user_profile']; ?>">
   
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="lr-form-box">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>

 
<?= $this->Form->end() ?>
<br/>
 
</div>

<div class="my-pro-contetnt-title"> Change Password</div>
 <div class="lr-box">
<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'changepassword','url'=>'/my-account/changepassword','class'=>'']); ?>

    <div class="row">
         <div class="col-lg-12">
            <div class="lr-form-box">
                <label> Old Password:</label>  
                <input type="hidden" name="user_id" value="<?php echo $rowAdminInfo['user_id']; ?>" >
                <input type="password"  class="form-control"  name="old_password">
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="lr-form-box">
                <label>New Password</label>
                <input type="password" class="form-control"   name="new_password"> 
            </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Confirm New Password </label>
                <input type="password" class="form-control"   name="conf_password">  

            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="lr-form-box">
                <button type="submit" onclick="return changepassword($(this))" class="btn btn-success">Change</button>
            </div>
        </div>
    </div>
<?php echo  $this->Form->end(); ?>

</div>
</div>
 

</div>
</div>
</div>
</div>
</div>
</section>
<script>
function refreshPage(){
window.location.reload();
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

$("#user_first_name").on("blur", function() {
if ( $(this).val().match('^[a-zA-Z]{3,16}$') ) {
alert( "Valid name" );
} else {
alert("That's not a name");
}
});
</script>

<script>
   function fileValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload .JPEG .JPG File only ');
        fileInput.value = '';
        return false;
    } 
}

</script>