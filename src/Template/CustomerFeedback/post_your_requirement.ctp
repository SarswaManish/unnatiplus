<?php ///$rowAdminInfo =  $this->request->getSession()->read('USER');?>
 <?php if(!isset($strApp) || isset($strApp) && $strApp=='')
{ ?>
<div class="sub-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ul class="breadcrum">
<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
<li><a href="javascript:;">Post Your Requirement</a></li>
</ul>
<h1>Post Your Requirement</h1>
</div>
</div>
</div>
</div>
<?php } ?>

<section>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-lg-8">
<div class="my-pro-contetnt" style="min-height:auto">
<div class="my-pro-contetnt-body">
<div class="lr-box">
<?= $this->Flash->render() ?>
<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'user-form','url'=>'','enctype'=>'multipart/form-data']); ?>
<div class="row">
<div class="col-lg-12">
<div class="lr-form-box">
<label>Please Select Category</label>
<select class="form-control" name="req_category">
<?php 
foreach($aryCategoryList as $key=>$label)
{  ?>
<option value="<?php echo $label['category_name']; ?> "><?php echo $label['category_name']; ?></option>
<?php }?>
</select>
</div>
</div>
<!--<label>Please Select Category</label>

<label>
<input type="radio" value="Women's Fashion"  name="req_category">Women's Fashion 
</label>
<label>
<input type="radio" value="Footwear"  name="req_category">Footwear
</label>
<label>
<input type="radio" value="Fabrics"  name="req_category">Fabrics
</label>
<label>
<input type="radio" value="Men's Fashion"  name="req_category">Men's Fashion
</label>
<label>
<input type="radio" value="Kids Fashion"  name="req_category">Kids Fashion  
</label>
<label>
<input type="radio" value="Home Furnishing"  name="req_category">Home Furnishing
</label>
-->
</div>
<div class="row">
<div class="col-lg-3">
<div class="lr-form-box">
<label>Quantity</label>
<input type="text" class="form-control" required name="req_quantity" >
</div>
</div>
<div class="col-lg-3">
<div class="lr-form-box">
<label>Required Days!</label>
<input type="text" class="form-control" required name="req_days"  >
</div>
</div>
<div class="col-lg-3">
<div class="lr-form-box">
<label> Price Range:</label>
<span>from Rs.</span><input type="text" class="form-control" required name="req_price_min">
</div>
</div>    
<div class="col-lg-3">
<div class="lr-form-box">
<span>to Rs.</span><input type="text" class="form-control" required name="req_price_max"  >
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<div class="lr-form-box">
<label> Upload Refernce Image:</label>
<input type="file" class="form-control" required name="req_image_"  >
<span>Don't have refernce image? DO you have any refernce link from any website?</span>
</div>
</div>
<div class="col-lg-6">
<div class="lr-form-box">
<label> Please Provide link in box:</label>
<textarea name="req_link" rows="1"class="form-control" ></textarea>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<div class="lr-form-box">
<label> Please describe your buying requirement. i.e Fabric,material and many other preferences:</label>
<textarea name="req_desc" rows="3"class="form-control" ></textarea>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<div class="lr-form-box">
<label>Name</label>
<input type="text" class="form-control" required name="req_name" >
</div>
</div>
<div class="col-lg-6">
<div class="lr-form-box">
<label>Email:</label>
<input type="email" class="form-control" required name="req_email"  >
</div>
</div>
<div class="col-lg-6">
<div class="lr-form-box">
<label> Mobile:</label>
<input type="text" class="form-control" required name="req_mobile" minlength="10" maxlength="10"  >
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<button type="submit" class="btn btn-success">Save</button>
</div>
</div>
<?= $this->Form->end() ?>
<br/>
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