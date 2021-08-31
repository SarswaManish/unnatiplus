<?php ///$rowAdminInfo =  $this->request->getSession()->read('USER');?>
 <?php if(!isset($strApp) || isset($strApp) && $strApp=='')
{ ?>
<div class="sub-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ul class="breadcrum">
<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
<li><a href="javascript:;">Customer Feedback</a></li>
</ul>
<h1>Customer Feedback</h1>
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
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Full Name:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" required name="feedback_name" >
            </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Email:<span style="color: red;">*</span></label>
                <input type="email" class="form-control" required name="feedback_email"  >

            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="lr-form-box">
                <label> Mobile:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" required name="feedback_mobile" minlength="10" maxlength="10"  >
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col-lg-12">
            <div class="lr-form-box">
                <label> feedback:<span style="color: red;">*</span></label>
                 <textarea  class="form-control" required name="feedback_feedback" ></textarea>
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
    <?= $this->Form->end() ?><br/>
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