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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Add Slider</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo SITE_URL; ?>admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Slider</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
  <div class="content">
  <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/slider/SliderProcessRequest','enctype'=>'multipart/form-data']); ?>
	<input type="hidden" name="slider_id" value="<?php echo isset($rowProductInfo['slider_id'])?$rowProductInfo['slider_id']:0; ?>">
					<!-- Dashboard content -->
					
					<div class="panel panel-default">
					    <div class="panel-heading">
<h5 class="panel-title">Add New Slider<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
<div class="heading-elements">
<a href="<?php echo SITE_URL; ?>admin/slider" class="btn btn-default"><i class="icon-chevron-left"></i> Back</a>
<button type="submit" class="btn btn-success"> Save</button>
</div>
</div>
					<div class="panel-body" style="padding:20px 15px;">
					    <div class="row">
<div class="col-lg-6">
<div class="form-group">
<label class="control-label">Slider Type: <span style="color:red">*</span></label>
<select name="slider_type" class="form-control">
    <option>Select</option>
    <option <?php echo (isset($rowProductInfo['slider_type']) && $rowProductInfo['slider_type']==0)?'selected="selected"':''; ?>       value="0">Login App</option>
    <option value="2"   <?php echo (isset($rowProductInfo['slider_type']) && $rowProductInfo['slider_type']==2)?'selected="selected"':''; ?>>Home Slider Aside</option>
    <option value="3"   <?php echo (isset($rowProductInfo['slider_type']) && $rowProductInfo['slider_type']==3)?'selected="selected"':''; ?>>Home Slider Bottom</option>
    <option value="4"   <?php echo (isset($rowProductInfo['slider_type']) && $rowProductInfo['slider_type']==4)?'selected="selected"':''; ?>>App Dashboard Slider 1</option>
    <option value="5"   <?php echo (isset($rowProductInfo['slider_type']) && $rowProductInfo['slider_type']==5)?'selected="selected"':''; ?>>App Dashboard Slider 2</option>
    <option value="6"   <?php echo (isset($rowProductInfo['slider_type']) && $rowProductInfo['slider_type']==6)?'selected="selected"':''; ?>>App Dashboard Slider 3</option>
    <option value="7"   <?php echo (isset($rowProductInfo['slider_type']) && $rowProductInfo['slider_type']==7)?'selected="selected"':''; ?>>Between App Product Slider</option>




</select>

</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label class="control-label">Slider Title: <span style="color:red">*</span></label>
<input placeholder="Enter Slider Title" required="required" name="slider_title" class="form-control" value="<?php echo isset($rowProductInfo['slider_title'])?$rowProductInfo['slider_title']:''; ?>" type="text">

</div>
</div>
</div>
<div class="form-group">
<label class="control-label">Slider Url: <span style="color:red">*</span></label>
<input placeholder="Enter Slider Url"  name="slider_url" class="form-control" value="<?php echo isset($rowProductInfo['slider_url'])?$rowProductInfo['slider_url']:''; ?>" type="text">

</div>
<div class="form-group">
<label class="control-label">Category: <span style="color:red">*</span></label>
 <select class="form-control" name="slider_category">
          <option value="0">Select</option>

     <?php foreach($resCategoryInfo as $rowCategoryInfo)
     {
     $strSelect =(isset($rowProductInfo['slider_category']) && $rowProductInfo['slider_category']==$rowCategoryInfo->category_id)?'selected="selected"':''; 
     ?>
          <option  <?php echo $strSelect; ?> value="<?php echo $rowCategoryInfo->category_id; ?>"><?php echo $rowCategoryInfo->category_name; ?></option>

     <?php } ?>
 </select>
</div>
<div class="form-group">
<label class="control-label">Tag: <span style="color:red">*</span></label>
 <select class="form-control" name="slider_tag">
     <option value="0">Select</option>
     <?php foreach($resTagInfo as $rowCategoryInfo)
     { 
          $strSelect =(isset($rowProductInfo['slider_tag']) && $rowProductInfo['slider_tag']==$rowCategoryInfo->tag_id)?'selected="selected"':''; 

     ?>
          <option <?php echo $strSelect; ?> value="<?php echo $rowCategoryInfo->tag_id; ?>"><?php echo $rowCategoryInfo->tag_name; ?></option>

     <?php } ?>
 </select>
</div>
<div class="form-group">
<label class="control-label">Brand: <span style="color:red">*</span></label>
 <select class="form-control" name="slider_brand">
     <option value="0">Select</option>
     <?php foreach($resTagInfo as $rowCategoryInfo)
     { 
          $strSelect =(isset($rowProductInfo['slider_brand']) && $rowProductInfo['slider_brand']==$rowCategoryInfo->brand_id)?'selected="selected"':''; 

     ?>
          <option <?php echo $strSelect; ?> value="<?php echo $rowCategoryInfo->brand_id; ?>"><?php echo $rowCategoryInfo->brand_name; ?></option>

     <?php } ?>
 </select>
</div>
<div class="row">
<div class="col-lg-12">
<div class="form-group">
<label class="control-label">Slider Description: <span style="color:red">*</span></label>

					 <textarea name="slider_desc" class="form-control" style="height:100px"><?php echo isset($rowProductInfo['slider_desc'])?$rowProductInfo['slider_desc']:''; ?></textarea>

</div>
</div>
</div>		
<div class="row">
<div class="col-lg-6">
<div class="form-group">
										<div class="media no-margin-top">
											<div class="media-body">
											<div class="media no-margin-top">
											<div class="media-left" style="padding-right: 7px">
											<a href="#">
											<img src="<?php echo (isset($rowProductInfo['slider_image']) && $rowProductInfo['slider_image']!='')? SITE_UPLOAD_URL.SITE_SLIDER_IMAGE_PATH.$rowProductInfo->slider_image:'/admin/assets/images/placeholder.jpg'; ?>" style="width: 58px; height: 58px;" id="blah2" class="img-rounded" alt="">
											</a>
											</div>
							<div class="media-body">
							<div class="uploader bg-warning">
							
							<input name="slider_image_" class="file-styled" type="file"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" ?="">Choose File</span>
							
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
					<!-- /dashboard content -->
	<?= $this->Form->end() ?>

	<!-- /page container -->