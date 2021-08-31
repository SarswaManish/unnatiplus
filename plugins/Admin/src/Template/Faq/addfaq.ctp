<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">FAQ</span> - Add FAQ</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Add FAQ</li>
</ul>
</div>
</div>
<div class="content">
	<!-- Dashboard content -->
    <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/faq/FaqProcessRequest','enctype'=>'multipart/form-data']); ?>
    <input type="hidden" name="faq_id" value="<?php echo isset($rowFaqInfo['faq_id'])?$rowFaqInfo['faq_id']:0; ?>">
    <div class="panel panel-default">
	    <div class="panel-heading">
            <h5 class="panel-title">Add FAQ<a class="heading-elements-toggle"><i class="icon-more"></i></a><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
            <div class="heading-elements">
                <a href="<?php echo SITE_URL; ?>admin/faq/" class="btn btn-default"><i class="icon-chevron-left"></i> Back</a>
                <button type="submit" class="btn btn-success"> Save</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body" style="padding:20px 15px;">
					<div class="form-group" style="margin-bottom: 10px;">
					    <label class="control-label">Question: <span style="color:red">*</span></label>
    					<div>
    					    <div class="input text required">
    					        <input name="faq_qus"  placeholder="Enter Question" required="" class="form-control" id="faq_qus" value="<?php echo isset($rowFaqInfo['faq_qus'])?$rowFaqInfo['faq_qus']:''; ?>" type="text">
    				        </div>   
    					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					    <label class="control-label">Answer: <span style="color:red">*</span></label>
    					<div>
    					    <div class="input text required">
    					        <textarea name="faq_ans" class="form-control" required="" style="height:100px"><?php echo isset($rowFaqInfo['faq_ans'])?$rowFaqInfo['faq_ans']:''; ?></textarea>
    					 
    				        </div>   
    					</div>
					</div>
				</div>
            </div>
        </div>
	</div>
	<?= $this->Form->end() ?>
</div>
			

					<!-- /dashboard content -->

		
