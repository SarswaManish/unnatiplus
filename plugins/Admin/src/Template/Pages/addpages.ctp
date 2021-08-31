
	<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - <?php echo isset($rowTaxInfo['tax_id'])?'Edit':'Add'; ?> Page</h4>
						</div>

						
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo SITE_URL; ?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Pages</li>
                           <li class="active">Add Pages</li>

						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
  <div class="content">
  <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/pages/pagesProcessRequest']); ?>
	<input type="hidden" name="page_id" value="<?php echo isset($rowTaxInfo['page_id'])?$rowTaxInfo['page_id']:0; ?>">
					<!-- Dashboard content -->
					<div class="row">
					<div class="col-lg-8">
					<div class="panel panel-default">
					<div class="panel-heading">
							<h5 class="panel-title">Page Details</h5>
							
						</div>
					<div class="panel-body" style="padding:20px 15px;">
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Name / Title: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="page_title"  placeholder="Enter Page Name / Title"  class="form-control" id="page_title" value="<?php echo isset($rowTaxInfo['page_title'])?$rowTaxInfo['page_title']:''; ?>" type="text"></div>   
					
					</div>
					</div>
	<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Page Url: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="page_url"  placeholder="Enter Page Url"  class="form-control" id="page_url" value="<?php echo isset($rowTaxInfo['page_url'])?$rowTaxInfo['page_url']:''; ?>" type="text"></div>   
					
					</div>
					</div>
					</div>
					</div>
					
						<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right11" style="margin-bottom:20px !important;">
					<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control-right11" href="#accordion-control-right-group11">Content</a>
										</h6>
									</div>
									<div id="accordion-control-right-group11" class="panel-collapse collapse in">
										<div class="panel-body" style="padding:0px" >
										    <textarea name="page_desc" class="summernote"><?php echo isset($rowTaxInfo['page_desc'])?$rowTaxInfo['page_desc']:''; ?></textarea>
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
					<div class="input text required"><input name="page_meta_title"  placeholder="Enter Meta Title"  id="page_meta_title"  onkeyup="changeseop()" class="form-control" value="<?php echo isset($rowTaxInfo['page_meta_title'])?$rowTaxInfo['page_meta_title']:''; ?>" type="text"></div>   
					<span style="font-size:11px;color:#999"> Max length 70 characters</span>
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Keywords:</label>
					<div>
					<div class="input text required">
					    <textarea rows="3" cols="5" id="page_meta_keyword" name="page_meta_keyword" class="form-control" placeholder="Keyword-1, Keyword-2, Keyword-3... " onkeyup="changeseop()" onblur="changeseop()" ><?php echo isset($rowTaxInfo['page_meta_keyword'])?$rowTaxInfo['page_meta_keyword']:''; ?></textarea>
					    </div>   
					<span style="font-size:11px;color:#999">Max length 160 characters</span>
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Description:</label>
					<div>
					<div class="input text required"><textarea rows="3" cols="5" class="form-control" onkeyup="changeseop()" onblur="changeseop()" id="page_meta_desc" name="page_meta_desc" placeholder="Description"><?php echo isset($rowTaxInfo['page_meta_desc'])?$rowTaxInfo['page_meta_desc']:''; ?></textarea></div>   
					<span style="font-size:11px;color:#999">Max length 250 characters</span>
					</div>
					</div>
					<div class="panel-body" style="padding:15px;border: 1px solid #ddd; background:#f5f5f5;display:none">
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