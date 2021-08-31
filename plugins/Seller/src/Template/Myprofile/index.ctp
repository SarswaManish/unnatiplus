<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - My Profile</h4>
		</div>

	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>seller/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">My Profile</li>
		</ul>

	</div>
</div>
				<!-- Content area -->
<div class="content">
  <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/seller/myprofile/profileUpdateProcessRequest','enctype'=>'multipart/form-data']); ?>
	<!-- Dashboard content -->
	<input name="seller_id" value="<?php echo $rowSellerInfo['seller_id']; ?>" placeholder="First Name" required="" class="form-control" id="user_name" type="hidden">
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">Seller Details</h5>
			    </div>
				<div class="panel-body" style="padding:20px 15px;">
				    <div class="row">
				        <div class="col-md-6">
				            <div class="form-group" style="margin-bottom: 10px;">
            					<label class="control-label"> First Name: <span style="color:red">*</span></label>
            					<div>
            					    <div class="input text required"><input name="seller_fname" onkeyup="return getproductslug(this.value)" placeholder="Enter First Name"  class="form-control" id="seller_fname" value="<?php echo isset($rowSellerInfo['seller_fname'])?$rowSellerInfo['seller_fname']:''; ?>" type="text"></div>   
            					</div>
        					</div>
				        </div>
				        <div class="col-md-6">
				            <div class="form-group" style="margin-bottom: 10px;">
    					<label class="control-label"> Last Name: <span style="color:red">*</span></label>
    					<div>
    					<div class="input text required"><input name="seller_lname" onkeyup="return getproductslug(this.value)" placeholder="Enter Last Name"  class="form-control" id="seller_lname" value="<?php echo isset($rowSellerInfo['seller_lname'])?$rowSellerInfo['seller_lname']:''; ?>" type="text"></div>   
    					</div>
    					</div>
				        </div>
				    </div>
			        <div class="row">
					        <div class="col-md-6">
					            <div class="form-group" style="margin-bottom: 10px;">
        					<label class="control-label">Email: <span style="color:red">*</span></label>
        					<div>
        					<div class="input text required"><input name="seller_email" onkeyup="return getproductslug(this.value)" placeholder="Enter Email"  class="form-control" id="seller_email" value="<?php echo isset($rowSellerInfo['seller_email'])?$rowSellerInfo['seller_email']:''; ?>" type="text"></div>   
        					</div>
        					</div>
					        </div>
					        <div class="col-md-6">
					            <div class="form-group" style="margin-bottom: 10px;">
        					<label class="control-label">Phone No: <span style="color:red">*</span></label>
        					<div>
        					<div class="input text required"><input name="seller_phone" onkeyup="return getproductslug(this.value)" placeholder="Enter Phone No"  class="form-control" id="seller_phone" value="<?php echo isset($rowSellerInfo['seller_phone'])?$rowSellerInfo['seller_phone']:''; ?>" type="text"></div>   
        					</div>
        					</div>
					        </div>
					    </div>
				    <div class="row">
					        <div class="col-md-6">
					            <div class="form-group" style="margin-bottom: 10px;">
        					<label class="control-label">Password: <span style="color:red">*</span></label>
        					<div>
        					<div class="input text required"><input name="seller_password" onkeyup="return getproductslug(this.value)" placeholder="Enter Pasword"  class="form-control" id="seller_password" value="<?php echo isset($rowSellerInfo['seller_password'])?$rowSellerInfo['seller_password']:''; ?>" type="text"></div>   
        					</div>
        					</div>
					        </div>
					    </div>
					    
    	        </div>
    	         
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">Business Information</h5>
			    </div>
				<div class="panel-body" style="padding:20px 15px;">
				    <div class="row">
				        <div class="col-md-6">
				            <div class="form-group" style="margin-bottom: 10px;">
    					<label class="control-label">Name: <span style="color:red">*</span></label>
    					<div>
    					<div class="input text required"><input name="business_name" onkeyup="return getproductslug(this.value)" placeholder="Enter Full Name"  class="form-control" id="business_name" value="<?php echo isset($rowSellerInfo['business_name'])?$rowSellerInfo['business_name']:''; ?>" type="text"></div>   
    					</div>
    					</div>
				        </div>
				        <div class="col-md-6">
				            <div class="form-group" style="margin-bottom: 10px;">
    					<label class="control-label">Phone no: <span style="color:red">*</span></label>
    					<div>
    					<div class="input text required"><input name="business_phone" onkeyup="return getproductslug(this.value)" placeholder="Enter Phone no"  class="form-control" id="business_phone" value="<?php echo isset($rowSellerInfo['business_phone'])?$rowSellerInfo['business_phone']:''; ?>" type="text"></div>   
    					</div>
    					</div>
				        </div>
				    </div>
			        <div class="row">
					        <div class="col-md-6">
					            <div class="form-group" style="margin-bottom: 10px;">
        					<label class="control-label">Email: <span style="color:red">*</span></label>
        					<div>
        					<div class="input text required"><input name="business_email" onkeyup="return getproductslug(this.value)" placeholder="Enter Email"  class="form-control" id="business_email" value="<?php echo isset($rowSellerInfo['business_email'])?$rowSellerInfo['business_email']:''; ?>" type="text"></div>   
        					</div>
        					</div>
					        </div>
					        <div class="col-md-6">
				            <div class="form-group" style="margin-bottom: 10px;">
            					<label class="control-label">Pincode: <span style="color:red">*</span></label>
            					<div>
            					    <div class="input text required"><input name="business_pincode" placeholder="Enter Pincode"  class="form-control" id="business_pincode" value="<?php echo isset($rowSellerInfo['business_pincode'])?$rowSellerInfo['business_pincode']:''; ?>" type="text"></div>   
            					</div>
        					</div>
				        </div>
				 </div>	        
				    <div class="row">
                        <div class="col-lg-12">
                            <?php $total_locations=0;$c=0;if(isset($rowSellerInfo->business_state)&&$rowSellerInfo->business_state!=""){
                    	    $state_key = "";
                    	    $user_states = explode(',',$rowSellerInfo->business_state);
                    	    $total_locations=count($user_states);
                    	    $user_cities = explode(',',$rowSellerInfo->business_city);
                    	    foreach($user_states as $k_state=>$v_state){?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="control-label">State: <span style="color:red">*</span></label>
                                    
                                    <select onchange="get_cities(this);" name="business_state[]" id="" required="required" class="form-control" placeholder="Select Locations">
                                        <option value="">Select</option>
                                        <option value="Anywhere In India">Anywhere In India</option>
                                        <option value="Anywhere In NCR">Anywhere In NCR</option>
                                        <?php 
                                        foreach($states as $k=>$v){?>
            					        <option <?php if($v->state_id==$v_state){$state_key=$k;echo "selected='selected'";}?> value="<?php echo $v->state_id;?>"><?php echo $v->state_name;?> </option>
            					        <?php }?>
                                        <option value="Outside India">Outside India</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label class="control-label">City: <span style="color:red">*</span></label>
                                    <select name="business_city[]" id="" class="form-control"  placeholder="Select Locations">
                                        <option value="any">Select City</option>
                                        <?php 
            					        if(isset($states[$state_key]))
            					        { 
            					        foreach($states[$state_key]->cities as $k=>$v){?>
            					        <option <?php if (isset($user_cities[$k_state]) && $v->cities_id==$user_cities[$k_state])echo "selected='selected'";?> value="<?php echo $v->cities_id;?>"><?php echo $v->cities_name;?> </option>
            					        <?php }} ?>
                                    </select>
                                </div>
                            </div>
                            <?php $c++;}} else {?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="control-label">State: <span style="color:red">*</span></label>
                                    
                                    <select onchange="get_cities(this);" name="business_state[]" id="" required="required" class="form-control" placeholder="Select Locations">
                                        <option value="">Select</option>
                                        <option value="Anywhere In India">Anywhere In India</option>
                                        <option value="Anywhere In NCR">Anywhere In NCR</option>
                                        <?php 
                                        foreach($states as $k=>$v){?>
            					        <option value="<?php echo $v->state_id;?>"><?php echo $v->state_name;?> </option>
            					        <?php }?>
                                        <option value="Outside India">Outside India</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label class="control-label">City: <span style="color:red">*</span></label>
                                    <select name="business_city[]" id="" class="form-control"  placeholder="Select Locations">
                                        <option value="any">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>

    	        </div>
			</div>
			<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right11" style="margin-bottom:20px !important;">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h6 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion-control-right11" href="#accordion-control-right-group11">About Us</a>
						</h6>
					</div>
					<div id="accordion-control-right-group11" class="panel-collapse collapse in">
						<div class="panel-body" style="padding:0px" >
						    <textarea name="seller_info" class="summernote"><?php echo isset($rowSellerInfo['seller_info'])?$rowSellerInfo['seller_info']:''; ?></textarea>
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
							<a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group22"><?php if(isset($rowSellerInfo['seller_id']) && $rowSellerInfo['seller_id']>0){ echo 'Update'; }else{ echo 'Publish'; } ?></a>
						</h6>
					</div>
						<div id="accordion-control-right-group22" class="panel-collapse collapse in">
										<div class="panel-body" style="background:#f5f5f5; padding:10px 15px;">

										<button type="submit" name="new" class="btn btn-success  btn-xs" style="float:right;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);"> <?php if(isset($rowSellerInfo['seller_id']) && $rowSellerInfo['seller_id']>0){ echo 'Update'; }else{ echo 'Publish'; } ?></button>
										</div>
									</div>
								</div>
					</div>
								<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right1" style="margin-bottom:20px !important;">
					<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control-right1" href="#accordion-control-right-group2">Business Logo</a>
										</h6>
									</div>
								
									<div id="accordion-control-right-group2" class="panel-collapse collapse in">
										<div class="panel-body" style="padding:10px 15px;">
									
										   
								<div class="form-group">
										<div class="media no-margin-top">
											<div class="media-body">
											<div class="media no-margin-top">
											    <div class="media-left" style="padding-right: 5px;">
                                    			<?php if(isset($rowSellerInfo->business_logo) && $rowSellerInfo->business_logo!='')	
                                    			{?>
                                    			
                                    			<a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_SELLER_IMAGE_PATH.$rowSellerInfo->business_logo; ?>" style="width: 58px; height: 58px;" id="blash" alt=""></a>
                                    
                                    			<?php }else{ ?>
                                    			<a href="#"><img src="<?php echo SITE_URL?>/seller/images/placeholder.jpg" style="width: 58px; height: 58px;" id="blash" alt=""></a>
                                    
                                    			<?php } ?>
														
													</div>
							<div class="media-body">
							<div class="uploader bg-warning">
							<input name="business_logo_" class="file-styled" type="file" onchange="readURL(this,'blash')"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" ?="">Choose File</span></div>
							<span class="help-block">Accepted: gif, png, jpg. Max file size 2Mb</span>
													</div>
												</div>
												
												 
											</div>
										</div>
									</div>

					
					    	</div>
					    	
					    
									</div>
							<!--<a href="/admin/tag" target="new" style="font-size:14px;">+ Add New Tag</a>-->
										</div>
									</div>
					<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right1" style="margin-bottom:20px !important;">
					<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control-right1" href="#accordion-control-right-group2">Profile Image</a>
										</h6>
									</div>
								
									<div id="accordion-control-right-group2" class="panel-collapse collapse in">
										<div class="panel-body" style="padding:10px 15px;">
									
										   
								<div class="form-group">
										<div class="media no-margin-top">
											<div class="media-body">
											<div class="media no-margin-top">
											    <div class="media-left" style="padding-right: 5px;">
			<?php if(isset($rowSellerInfo->profile_image) && $rowSellerInfo->profile_image!='')	
			{?>
			
			<a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_SELLER_IMAGE_PATH.$rowSellerInfo->profile_image; ?>" style="width: 58px; height: 58px;" id="blash" alt=""></a>

			<?php }else{ ?>
			<a href="#"><img src="<?php echo SITE_URL?>/seller/images/placeholder.jpg" style="width: 58px; height: 58px;" id="blash" alt=""></a>

			<?php } ?>
														
													</div>
							<div class="media-body">
							<div class="uploader bg-warning">
							<input name="profile_image_" class="file-styled" type="file" onchange="readURL(this,'blash')"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" ?="">Choose File</span></div>
							<span class="help-block">Accepted: gif, png, jpg. Max file size 2Mb</span>
													</div>
												</div>
												
												 
											</div>
										</div>
									</div>

					
					    	</div>
					    	
					    
									</div>
							<!--<a href="/admin/tag" target="new" style="font-size:14px;">+ Add New Tag</a>-->
										</div>
									</div>

					</div>
					
						</div>
					<!-- /dashboard content -->
	<?= $this->Form->end() ?>
	</div>
	<script>var csrf_tocken=<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>
	<!-- /page container -->
	<script>
	    var aryTag =[];
    function producttagspecification(objectElemnt)
    {
        var selectedHtml = $("#product_tag_ option:selected").html();
        var selectval = objectElemnt.val();
        if(jQuery.inArray(selectval, aryTag) == -1 && selectval>0)
{
        aryTag.push(selectval);
        $('#append_tag').append('<span class="label   label-striped" style="margin-right:5px">'+selectedHtml+' <a href="javascript:void(0);" onclick="removetag($(this))"><i class="icon-cross3"></i></a><input type="hidden" name="product_tag_[]" value="'+selectval+'"></span>');
}    
    }
    
    function removetag(objectElement)
    {
        objectElement.parents('span').remove();
    }
	
	function addMoreHighlights(objectelement)
	{
		var strhtml = '<div class="row clsparentrow" style="margin-top:20px"><div class="col-lg-10"><input type="text" name="product_highlights_[]" class="form-control"></div><div class="col-lg-2 clsaddmorebutton"><button type="button" onclick="addMoreHighlights($(this))" class="btn btn-info btn-xs"><i class="icon-plus2"></i> Add More</button></div></div>';
		
		$('.replacehighlights').append(strhtml);
		objectelement.parents('.clsaddmorebutton').html('<button type="button" onclick="removehighlights($(this))" class="btn btn-danger btn-xs"><i class="icon-cross3"></i> Remove</button>');
	}
	
	 function removehighlights(objectElement)
    {
var confirm_ = confirm('Are you want to remove');
if(confirm_)
{
        objectElement.parents().parents('.clsparentrow').remove();
}
    }
    
    
  

  
    function removepicture(strImagetype,object)
{
        $('#image'+strImagetype).addClass('hide');
           $('.imagehover'+strImagetype).addClass('hide');
                $('#image'+strImagetype+'-icon').removeClass('hide');
                           $('input[name=product_image'+strImagetype+']').val("");
     object.remove();
                
}



	    
	    function addmoreprice(objectElement)
	    {
	        objectElement.parents('.clsparentaddmore').html('<a href="javascript:void();" onclick="removeprice($(this))" class="btn btn-danger btn-icon btn-rounded"><i class="icon   icon-minus3"></i></a>');
	        var htmldata ='<div class="row clsparentforremove"><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Attributes: <span style="color:red">*</span></label><div class="input text required"><select name="pu_unit[]" class="form-control"><option value="">Select</option> <?php echo $strHtml; ?> </select></div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Avail Qty: <span style="color:red">*</span></label><div class="input text required"><input class="form-control" placeholder="0.00" type="text"  id="qty_price" name="pu_qty[]" value=""> </div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Selling Price: <span style="color:red">*</span></label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" placeholder="0.00" type="text"  id="sellingprice" name="pu_selling_price[]" value="" onkeyup="getnetbusinessprice($(this))" onblur="getnetbusinessprice($(this))"></div>  <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Discount:</label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" placeholder="0.00" type="text" name="pu_discount[]" id="discount_business" value="" onkeyup="getnetbusinessprice($(this))" onblur="getnetbusinessprice($(this))"></div>  <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Net Price:</label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" placeholder="0.00" type="text" name="pu_net_price[]" id="netprice_business" value="" readonly></div>  <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-1"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">&nbsp;</label><div class="clsparentaddmore"><a href="javascript:void();" onclick="addmoreprice($(this))" class="btn btn-success btn-icon btn-rounded"><i class="icon  icon-plus3"></i></a></div></div></div></div>';
	        $('.appendaddmorecontent').append(htmldata);
	    }
	    function removeprice(objectElement)
	    {
	        
	        var condida = confirm('Are you want to delete');
	        if(condida)
	        {
	            
	         objectElement.parents().parents().parents().parents('.clsparentforremove').remove();
	        }
	    }
function readURL(input,id) {

if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function(e) {
$('#'+id).attr('src', e.target.result);
}

reader.readAsDataURL(input.files[0]);
}
}
	</script>
	<script>function get_cities(box)
    {
        var state_id = box.value;
        $(box).parent().next().find('select').prop('disabled',false);
        if(state_id=="")
        {
            $(box).parent().next().find('select').html('<option value="">Select City</option>');
            return;
        }
        else if(state_id=="any")
        {
            $(box).parent().next().find('select').html('<option value="any">Any City</option>');
        }
        else if(state_id=="any_ncr")
        {
            $(box).parent().next().find('select').html('<option value="any_ncr">Any City</option>');
        }
            else if(state_id=="any_world")
        {
            $(box).parent().next().find('select').html('<option value="any_ncr">Any City</option>');
        }
        else
        {
            $.ajax({
            url: "<?php echo SITE_URL;?>admin/seller/get_cities/"+state_id,
            context: document.body
            }).done(function(data) {
            if(data!="")
            {
            $(box).parent().next().find('select').html(data);
            }
            else
            {
            $(box).parent().next().find('select').html('<option value="">Select City</option>');
            }
            });
        }
    }</script>
