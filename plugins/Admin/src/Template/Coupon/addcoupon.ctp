<?php 
$catCheck=0;
/*echo $coupon->coupons_condition;
die;*/
if(isset($coupon->coupon_category) && $coupon->coupon_category>0){
    $catCheck = $coupon->coupon_category;
}
$catList = '<option value="">Select category</option>';$userList = '<option value="">Select user</option>'; 
if(!empty($categories)){
    foreach($categories as $cats){
        if($catCheck == $cats['category_id']){
                $sel = 'selected="selected"';
        }else{
            $sel = "";
        }
        $catList .='<option value="'.$cats['category_id'].'" '.$sel.'>'.$cats['category_name'].'</option>';
    }
}
$userCheck=0;

if(isset($coupon->coupon_user) && $coupon->coupon_user>0){
    $userCheck = $coupon->coupon_user;
}
if(!empty($users)){
    foreach($users as $user){
        if($user['user_first_name'] !=""){
            if($userCheck == $user['user_id']){
                $sel = 'selected="selected"';
            }else{
                $sel = "";
            }
            $userList .='<option value="'.$user['user_id'].'" '.$sel.'>'.$user['user_first_name'].' '.$user['user_last_name'].'</option>';
        }
    }
}
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://testscorner.com/adminassets/assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="https://testscorner.com/adminassets/assets/js/pages/form_layouts.js"></script>
<link href="https://testscorner.com/adminassets/assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<style>
   .mr-3
   {
   width: 60px;
   float: left;
   margin-right: 20px;
   }
</style>
<div class="page-container">
<!-- Page content -->
<div class="page-content">
<!-- Main sidebar -->
<!-- User menu -->
<!-- /user menu -->
<!-- /main sidebar -->
<!-- Main content -->
<div class="content-wrapper">
<!-- Page header -->
<div class="page-header page-header-default">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Coupon</span> - <?php 	echo "Edit Coupon";	?></h4>
      </div>
   </div>
   <div class="breadcrumb-line">
      <ul class="breadcrumb">
         <li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
         <li><a href="#">Coupon</a></li>
         <li class="active"><?php echo "Edit Coupon";?></li>
      </ul>
   </div>
</div>
<!-- /page header -->
<!-- Content area -->	
<div class="content">
   <div class="row">
      <?php echo  $this->Form->create('$Coupon', ['type' => 'POST','id'=>'edit','enctype'=>'multipart/form-data','class'=>'form-horizontal']); ?>
      <!-- Both borders -->
      <div class="panel panel-default">
         <div class="panel-heading">
            <h5 class="panel-title"><?php echo "Edit Coupon";	?></h5>
            <div class="heading-elements">
               <a href="<?php echo SITE_URL;?>admin/coupon" class="btn btn-default"><i class="icon-chevron-left"></i> Back</a>
               <button type="submit" name="submit"class="btn btn-success"> Save</button>
            </div>
            <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
         </div>
         <div class="panel-body" >
            <div class="tabbable">
               <div class="tab-content">
                  <div class="tab-pane fade active in" id="tab1-1">
                     <div class="form-body">
                        <div class="form-group">
                           <label class="col-lg-2 control-label"> Title:</label>
                           <div class="col-lg-10">
                              <?php echo $this->Form->control('', array('type' => 'text','placeholder'=>'Coupon Title','id'=>'coupon_title','required'=>'required','class'=>'form-control','name'=>'coupon_title','value'=>(isset($coupon->coupon_title)?$coupon->coupon_title:''),'label'=>false)); ?>   
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 control-label">Active From:</label>
                           <div class="col-lg-4">
                              <?php echo $this->Form->control('', array('type' => 'text','placeholder'=>'Coupon Active From','required'=>'required','class'=>'form-control form_datetime','name'=>'coupon_active_from','label'=>false,'value'=>(isset($coupon->coupon_active_from) && $coupon->coupon_active_from!='0000-00-00')?date('Y-m-d',strtotime($coupon->coupon_active_from)):'')); ?>      
                           </div>
                           <label class="col-lg-1 control-label">Active To:</label>
                           <div class="col-lg-4">
                              <?php echo $this->Form->control('', array('type' => 'text','label'=>false,'placeholder'=>'Coupon Active To','required'=>'required','class'=>'form-control form_datetime','name'=>'coupon_active_to','value'=>(isset($coupon->coupon_active_from) && $coupon->coupon_active_from!='0000-00-00')?date('Y-m-d',strtotime($coupon->coupon_active_to)):''));  ?>      
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 control-label">Discount:</label>
                           <div class="col-lg-5">
                              <?php echo $this->Form->control('', array('type' => 'text','placeholder'=>'Coupon Discount','required'=>'required','class'=>'form-control','name'=>'coupon_discount','id'=>'coupon_discount','value'=>(isset($coupon->coupon_discount)?$coupon->coupon_discount:''),'label'=>false)); ?>      
                           </div>
                           <div class="col-lg-5">
                              <label class="radio-inline"> 
                              <input type="radio" <?php if(isset($coupon->coupon_discount_mode) && $coupon->coupon_discount_mode==0){ ?> checked="checked" <?php }else{ echo 'checked="checked"'; } ?> onclick="showMaxDiscount($(this))" name="coupon_discount_mode"  value="0"> Percent 
                              </label>
                              <label class="radio-inline"> <input type="radio" onclick="hideMaxDiscount($(this))" <?php if(isset($coupon->coupon_discount_mode) && $coupon->coupon_discount_mode==1){ ?> checked="checked" <?php } ?> name="coupon_discount_mode" value="1"> Rupees </label>											
                           </div>
                        </div>
                        <div class="form-group" style="<?php if(isset($coupon->coupon_max_discount) &&  ''==$coupon->coupon_max_discount) { echo 'display:none'; }?>"  id="couponMax">
                           <label class="col-lg-2 control-label">Maximum Discount:</label>
                           <div class="col-lg-5">
                              <?php echo $this->Form->control('', array('type' => 'text','placeholder'=>'Coupon Maximum Discount','class'=>'form-control','name'=>'coupon_max_discount','id'=>'coupon_max_discount','value'=>(isset($coupon->coupon_max_discount)?$coupon->coupon_max_discount:''),'label'=>false)); ?>      
                           </div>
                        </div>
                        <div class="form-group" style="<?php if(isset($coupon->coupon_max_discount) &&  ''==$coupon->coupon_max_discount) { echo 'display:none'; }?>"  id="couponMax">
                           <label class="col-lg-2 control-label">Minimum Cart Amount:</label>
                           <div class="col-lg-5">
                              <?php echo $this->Form->control('', array('type' => 'text','placeholder'=>'Minimum Cart Amount','class'=>'form-control','name'=>'minimum_cart_amount','id'=>'minimum_cart_amount','value'=>(isset($coupon->minimum_cart_amount)?$coupon->minimum_cart_amount:''),'label'=>false)); ?>      
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 control-label"> Code:</label>
                           <div class="col-lg-5">
                              <?php echo $this->Form->control('', array('type' => 'text','value'=>(isset($coupon->coupon_code)?$coupon->coupon_code:''),'placeholder'=>'Coupon Code','id'=>'coupon_code','required'=>'required','class'=>'form-control','name'=>'coupon_code','label'=>false)); ?>   
                           </div>
                           <div class="col-lg-5">
                              <button type ="button" class="btn bg-teal-400 btn-labeled btn-rounded"  onclick="generateCode($(this))"><b> <i class="icon-plus3"></i></b>Generate Code</button>  
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 control-label"> Minimum quantity:</label>
                           <div class="col-lg-5">
                              <?php echo $this->Form->control('', array('type' => 'text','value'=>(isset($coupon->minimum_order_quantity)?$coupon->minimum_order_quantity:0),'placeholder'=>'Minimum qunatity','id'=>'minimum_order_quantity','class'=>'form-control','name'=>'minimum_order_quantity','label'=>false)); ?>   
                           </div>
                           <div class="col-lg-5">
                               <label class="radio-inline"> 
                               <input type="checkbox" 
                               <?php echo (isset($coupon->Is_applicable_on_first_order) && $coupon->Is_applicable_on_first_order == 1)?'checked':"";?>
                               name="Is_applicable_on_first_order" class="" value="1">Is this applicable on first order only? 
                            </div>
                        </div>
                         <div class="form-group">
                           <label class="col-lg-2 control-label">Condition type:</label>
                           <div class="col-lg-10">
                                <select name="condition_type" id="condition_type" class="form-control" onchange="showCondition(this.value)">
                                    <option value="1"
                                    <?php 
                                        if(isset($coupon->coupons_condition) && $coupon->coupons_condition == 1){
                                            echo "selected='selected'";
                                        }
                                    ?>
                                    >Only on user</option>
                                    <option value="2"
                                        <?php 
                                            if(isset($coupon->coupons_condition) && $coupon->coupons_condition == 2){
                                                echo "selected='selected'";
                                            }
                                        ?>
                                    >Only on category</option>
                                </select>  
                            </div>
                        </div>
                         <div class="form-group">
                           <label class="col-lg-2 control-label">Category:</label>
                           <div class="col-lg-10">
                            <select name="coupon_category" id="coupon_category" class="form-control" >
                                <?php echo $catList; ?>
                            </select>  
                          </div>
                        </div>
                         <div class="form-group">
                           <label class="col-lg-2 control-label">User:</label>
                           <div class="col-lg-10">
                            <select name="coupon_user" id="coupon_user" class="form-control" >
                                <?php echo $userList; ?>
                            </select>  
                          </div>
                        </div>
                       
                        <div class="form-group">
                           <label class="col-lg-2 control-label">Logo :</label>
                           <div class="col-lg-10">
                              <div class="media no-margin-top">
                                 <div class="media-left">
                                    <?php if(isset($coupon->coupon_image) && ''!=$coupon->coupon_image)
                                       { ?>
                                    <a href="#"><img src="<?php echo SITE_UPLOAD.SITE_COUPON_IMAGE_PATH.$coupon->coupon_image; ?>" style="width: 58px; height: 58px; border-radius: 2px;" id="blah1" alt=""></a>
                                    <?php }else{ ?>
                                    <a href="#"><img src="<?php echo SITE_URL ; ?>admin/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" id="blah1" alt=""></a>
                                    <?php } ?>
                                 </div>
                                 <div class="media-body">
                                    <div class="uploader "><input class="file-styled" type="file" onchange="readURL1(this);" name="coupon_image"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" name="theme_setting_logo">Choose File</span></div>
                                    <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?= $this->Form->end() ?>
</div>
<!-- /both borders -->
<script>
   function randome(length=3)
   {
   var text = "";
   var possible = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   for(var i = 0; i < length; i++) {
   text += possible.charAt(Math.floor(Math.random() * possible.length));
   }
   return text;
   }
   function generateCode()
   {
   
   var name= $('#coupon_title').val();
   var discount=$('#coupon_discount').val();
   
   var res = name.substring(0, 4);
   var randomString = res.toUpperCase();
   
   var random = randome();
   $('#coupon_code').val(randomString+random+discount);
   
   
   }
   
   
</script>			 
<script>
   $(function (){
   $('.form_datetime').datepicker({
   format: "yyyy/mm/dd",
   todayHighlight: true,
   }).on('changeDate', function(e){
   $(this).datepicker('hide');
   });
   });
</script>
<script>
   function addMoreFeatures()
   {
   $('.packageDesc').append('<div class="form-group removeBtn"><label class="col-lg-2 control-label"></label><div class="col-lg-6"><input type="text" class="form-control" name="coupon_features[]"></div><div class="col-lg-2"><button type="button" onclick="removePackageHtml($(this))" class="btn btn-danger ">Remove</button></div></div>');
   }
   
   function removePackageHtml(objelement)
   {
   var confirms = confirm('Are you sure you want to remove this element.');
   if(confirms) 
   {
   objelement.parents().parents('.removeBtn').remove();
   }
   }
   
   function readURL(input) 
   {
   if (input.files && input.files[0]) {
   var FileUploadPath = input.value;
   var Extension = FileUploadPath.substring(
   FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
   
   //The file uploaded is an image
   
   if (Extension == "gif" || Extension == "png" || Extension == "bmp"|| Extension == "jpeg" || Extension == "jpg") {
   
   var reader = new FileReader();
   
   reader.onload = function (e) {
   $('#blash').attr('src', e.target.result);
   };
   
   reader.readAsDataURL(input.files[0]);
   }else{
   
   alert('Photo only allows file types of GIF, PNG, JPG, JPEG and BMP.');
   }
   }
   }

   function showConditions(objectElement)
   {
   var selectval=$('#coupon_apply_on').val();
   if(selectval!='0')
   {
   if(selectval=='1')
   {
   //$('#couponDays').show();
   $('#couponProduct').hide();
   $('#couponUser').hide();
   }
   if(selectval=='2')
   {
   $('#couponDays').hide();
   $('#couponProduct').show();
   $('#couponUser').hide();
   }
   if(selectval=='3')
   {
   $('#couponDays').hide();
   $('#couponProduct').hide();
   $('#couponUser').show();
   }
   }
   }

   function showMaxDiscount(objectElement)
   {
   $('#couponMax').show();
   }

   function hideMaxDiscount(objectElement)
   {
    $('#couponMax').hide();
   }
   
   function showCondition(t){
       if(t==1){
           $('#coupon_category').parents('.form-group').hide();
           $('#coupon_user').parents('.form-group').show();
       }else{
           $('#coupon_category').parents('.form-group').show();
           $('#coupon_user').parents('.form-group').hide();
       }
   }
   
   $(document).ready(function(){
      var sg = $('#condition_type').val(); 
      showCondition(sg);
   });
</script>