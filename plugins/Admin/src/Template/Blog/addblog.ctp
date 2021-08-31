<style>
.checker input[type=checkbox], .choice input[type=radio] {
    border: none;
    background: none;
    display: -moz-inline-box;
    display: inline-block;
    margin: 0;
    vertical-align: top;
    cursor: pointer;
    position: absolute;
    top: -2px;
    left: -2px;
    z-index: 2;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>


<style>
    #myProgress {
       width: 100%;
    background-color: #f5f5f5;
    margin-top: 37px;
}

</style>
<script>var editProductId = <?php echo isset($rowProductInfo['product_id'])?$rowProductInfo['product_id']:0; ?>;</script>
	<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Add Blog</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo SITE_URL; ?>admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Blogs</li>
								<li class="active">Add Blog</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
  <div class="content">
  <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/blog/blogprocessrequest','enctype'=>'multipart/form-data']); ?>
	<input type="hidden" name="blog_id" value="<?php echo isset($rowProductInfo['blog_id'])?$rowProductInfo['blog_id']:0; ?>">
					<!-- Dashboard content -->
					<div class="row">
					<div class="col-lg-8">
					<div class="panel panel-default">
					<div class="panel-heading">
							<h5 class="panel-title">Blog Details</h5>
							
						</div>
					<div class="panel-body" style="padding:20px 15px;">
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Blog Title: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="blog_title" onkeyup="return getblogslug(this.value)" placeholder="Enter Blog Title"  class="form-control" id="product_name" value="<?php echo isset($rowProductInfo['blog_title'])?$rowProductInfo['blog_title']:''; ?>" type="text"></div>   
					<span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"><strong>Permalink:</strong> <a href="<?php echo SITE_URL; ?>blog-detail/<?php echo isset($rowProductInfo['blog_slug'])?$rowProductInfo['blog_slug']:''; ?>" id="permalink_product" target="new"><?php echo SITE_URL; ?>blog-detail/<span id="hidewhenedit"><?php echo isset($rowProductInfo['blog_slug'])?$rowProductInfo['blog_slug']:''; ?></span></a> <input type="text" id="permalink_val" class="hide" name="blog_slug" value="<?php echo isset($rowProductInfo['blog_slug'])?$rowProductInfo['blog_slug']:''; ?>"> <a href="javascript:void(0);" onclick="editpermalink()" id="permalink_edit"><span class="label bg-grey-400"><i style="font-size:9px;" class="icon-pencil"></i> Edit</span></a> <a id="permalink_ok"  href="javascript:void(0);" onclick="okpermalink()" class="hide"><span class="label bg-green"> ok</span></a>&nbsp;<a id="permalink_cancel"  href="javascript:void(0);" onclick="cancelpermalink()" class="hide"><span class="label bg-grey-400">Cancel</span></a></span>
					</div>
					</div>
				
					
					</div>
					</div>
					
							<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right11" style="margin-bottom:20px !important;">
					<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control-right11" href="#accordion-control-right-group11">Descritpion</a>
										</h6>
									</div>
									<div id="accordion-control-right-group11" class="panel-collapse collapse in">
										<div class="panel-body" style="padding:0px" >
										    <textarea name="blog_desc" class="summernote"><?php echo isset($rowProductInfo['blog_desc'])?$rowProductInfo['blog_desc']:''; ?></textarea>
										</div>
									</div>
								</div>
					</div>
					


					

					
					
					
					
					<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:20px !important;">
					<div class="panel panel-white" style=" border-radius:0px;">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group2">Search engine listing preview
											
											</a>
										</h6>
									</div>
									<div id="accordion-control-right-group2" class="panel-collapse collapse">
											<div class="panel-body" style="padding:20px 15px;">
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Title:</label>
					<div>
					<div class="input text required"><input name="blog_meta_title"  placeholder="Enter Meta Title"  id="product_meta_title"  onkeyup="changeseop()" class="form-control" value="<?php echo isset($rowProductInfo['blog_meta_title'])?$rowProductInfo['blog_meta_title']:''; ?>" type="text"></div>   
					<span style="font-size:11px;color:#999"> Max length 70 characters</span>
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Keywords:</label>
					<div>
					<div class="input text required">
					    <textarea rows="3" cols="5" id="product_meta_keyword" name="blog_meta_keyword" class="form-control" placeholder="Keyword-1, Keyword-2, Keyword-3... " onkeyup="changeseop()" onblur="changeseop()" ><?php echo isset($rowProductInfo['blog_meta_keyword'])?$rowProductInfo['blog_meta_keyword']:''; ?></textarea>
					    </div>   
					<span style="font-size:11px;color:#999">Max length 160 characters</span>
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Description:</label>
					<div>
					<div class="input text required"><textarea rows="3" cols="5" class="form-control" onkeyup="changeseop()" onblur="changeseop()" id="product_meta_desc" name="blog_meta_description" placeholder="Description"><?php echo isset($rowProductInfo['blog_meta_description'])?$rowProductInfo['blog_meta_description']:''; ?></textarea></div>   
					<span style="font-size:11px;color:#999">Max length 250 characters</span>
					</div>
					</div>
					<div class="panel-body" style="padding:15px;border: 1px solid #ddd; background:#f5f5f5;">
					<span style="font-size:13px;color:#999">Search engine listing preview</span>
					<h4 style="color: #1a0dab;font-size:16px;font-weight: 500;margin-bottom: 5px;" id="seo_title"></h4>
					<p style="color: #3c763d;margin-bottom: 5px;" id="seo_url"></p>
					<span style="font-size:13px;color:#666" id="seo_description"></span>
					</div>
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
											<a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group22"><?php if(isset($rowProductInfo['product_id']) && $rowProductInfo['product_id']>0){ echo 'Update'; }else{ echo 'Publish'; } ?></a>
										</h6>
									</div>
									<div id="accordion-control-right-group22" class="panel-collapse collapse in">
										<div class="panel-body" style="padding:10px 15px;">
										<p>
										<button type="submit" class="btn btn-default  btn-xs" name="saveproductdraft"> Save Draft</button>
										<a href="javascript:;" id="preview-product" target="new" class="btn btn-default  btn-xs" style="float:right" > Preview</a>
										</p>
										<p>
										    <i class="icon-eye"></i> Visibility: <strong>Public</strong> <a href="javascript:;" onclick="$('.clsshowvisible').toggle(100)" style="text-decoration:underline">Edit</a>
										    </p>
										<div style="background:#f5f5f5;padding:0px 10px; border:1px solid #ddd; margin-bottom:10px;display:none"  class=" clsshowvisible">
										<div class="radio">
											<label style="padding-left: 20px;">
												<input name="product_visibility" checked="checked" type="radio">
												Public
											</label>
										</div>
										<div class="radio">
											<label style="padding-left: 20px;">
												<input name="product_visibility" type="radio">
												Password protected
											</label>
										</div>
										<div class="radio">
											<label style="padding-left: 20px;">
												<input name="product_visibility" type="radio">
												Private
											</label>
										</div>
										</div>

										
										
										</div>
										<div class="panel-body" style="background:#f5f5f5; padding:10px 15px;">
										    <?php if(isset($rowProductInfo['blog_id']) && $rowProductInfo['blog_id']>0){ ?>
										    <a href="<?php echo SITE_URL; ?>admin/blog/trash/<?php echo $rowProductInfo['blog_id']; ?>" style="color:#d90000;float:left;margin-top:5px">Move to trash</a>
										    <?php } ?>
										<button type="submit" name="new" class="btn btn-success  btn-xs" style="float:right;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);"> <?php if(isset($rowProductInfo['blog_id']) && $rowProductInfo['blog_id']>0){ echo 'Update'; }else{ echo 'Publish'; } ?></button>
										</div>
									</div>
								</div>
					</div>
					<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:20px !important;">
					<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group1">Categories</a>
										</h6>
									</div>
									<div id="accordion-control-right-group1" class="panel-collapse collapse in">
										<div class="panel-body" style="padding:10px 15px;">
											<span style="float: left;font-size: 12px;color: #999; margin-bottom:10px;">Select category in which you want to display this product. You can also select multiple categories for this product.</span>
												<div class="tabbable">
										<ul class="nav nav-tabs" style="margin-bottom:0px;">
											<li class="active"><a href="#basic-tab1" data-toggle="tab">All Categories</a></li>
											<li><a href="#basic-tab2" data-toggle="tab">Most Used</a></li>
											
										</ul>

										<div class="tab-content" style="border:1px solid #ddd;padding:0px 0px 0px 15px; margin-bottom:15px;">
											<div class="tab-pane active" id="basic-tab1" style="height:200px; overflow-x:hidden;">
											<div class="form-group" style="padding:10px 0px;">
								 <?php
								echo $strCategoryTreeStructure; 
								?></div>
											</div>

											<div class="tab-pane" id="basic-tab2" style="height:200px; overflow-x:hidden;">
												<div class="form-group" style="padding:10px 0px;">
											
										 

										
									</div>
											
											</div>

											
										</div>
									</div>
							<a href="<?php echo $this->Url->build('/admin/bcategories'); ?>" target="new" style="font-size:14px;">+ Add New Category</a>
										</div>
									</div>
								</div>
					</div>
					
					<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right1" style="margin-bottom:20px !important;">
					<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control-right1" href="#accordion-control-right-group2">Featured Image</a>
										</h6>
									</div>
								
									<div id="accordion-control-right-group2" class="panel-collapse collapse in">
										<div class="panel-body" style="padding:10px 15px;">
									
										   
								<div class="form-group">
										<div class="media no-margin-top">
											<div class="media-body">
											<div class="media no-margin-top">
											    <div class="media-left" style="padding-right: 5px;">
			<?php if(isset($rowProductInfo->blog_featured_image) && $rowProductInfo->blog_featured_image!='')	
			{?>
			
			<a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_BLOG_IMAGE_PATH.$rowProductInfo->blog_featured_image; ?>" style="width: 58px; height: 58px;" id="blash" alt=""></a>

			<?php }else{ ?>
			<a href="#"><img src="/admin/images/placeholder.jpg" style="width: 58px; height: 58px;" id="blash" alt=""></a>

			<?php } ?>
														
													</div>
							<div class="media-body">
							<div class="uploader bg-warning">
							<input name="blog_featured_image_" class="file-styled" type="file"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" ?="">Choose File</span></div>
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
 function getblogslug(strProductName)
{
    if(strProductName!='')
    {
        var lower_product_name = strProductName.toLowerCase();
        var strreplace_product_name = lower_product_name.replace(/,/g,'');
      var strreplace_product_name = strreplace_product_name.replace(/&/g,'');
      var split_product_name = strreplace_product_name.split(' ');
      var join_product_name = split_product_name.join('-');
        $('#permalink_product').html(base_url+'blog-detail/<span id="hidewhenedit">'+join_product_name+'</span>');
        $('#permalink_product').attr('href',base_url+'blog-detail/'+join_product_name);
        $('#permalink_val').val(join_product_name);
        $('#preview-product').attr('href',base_url+'blog-detail/'+join_product_name);
        $('#seo_title').html(strProductName);
    }
    
    
}
function editpermalink()
{
    $('#hidewhenedit').addClass('hide');
    $('#permalink_val').removeClass('hide');
    $('#permalink_ok').removeClass('hide');
    $('#permalink_edit').addClass('hide');
    $('#permalink_cancel').removeClass('hide');
}
function okpermalink()
{
    $('#hidewhenedit').removeClass('hide');
    $('#permalink_val').addClass('hide');
    $('#permalink_ok').addClass('hide');
    $('#permalink_cancel').addClass('hide');
    $('#permalink_edit').removeClass('hide');
    $('#permalink_product').html(base_url+'product-detail/<span id="hidewhenedit">'+$('#permalink_val').val()+'</span>');
    $('#permalink_product').attr('href',base_url+'product-detail/'+$('#permalink_val').val());
    $('#permalink_val').val($('#permalink_val').val());
    $('#preview-product').attr('href',base_url+'product-detail/'+$('#permalink_val').val())

}

   
 
 
   
	</script>