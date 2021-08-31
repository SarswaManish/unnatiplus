<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=2 ')->fetch('assoc');
 
 

if(!isset($rowSelectPermission['pd_id']))
{
    
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
  
}
?><div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Blog Categories</h4>
						</div>
					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo SITE_URL; ?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Blog Categories</li>
						</ul>
					</div>
				</div>
				<div class="content">
					<div class="row">
					<div class="col-lg-4">
					<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/bcategories/categoryProcessRequest','enctype'=>'multipart/form-data']); ?>
					<div class="panel panel-flat" style="margin-bottom:0px; border-radius:0px; border-bottom: 0px;">
					<input type="hidden" name="category_id" value="<?php echo isset($rowCategoryInfo->category_id)?$rowCategoryInfo->category_id:''; ?>">
					<div class="panel-body" style="padding:20px 15px;">
					<div class="form-group"  id="category-name-error" style="margin-bottom: 10px;">
					<label class="control-label">Category Name: <span style="color:red">*</span></label>
					<div>
					<div class="input text required"><input name="category_name" onkeyup="getCategoryslug(this.value)" placeholder="Enter Category Name" required="required" class="form-control" id="category_name" value="<?php echo isset($rowCategoryInfo->category_name)?$rowCategoryInfo->category_name:''; ?>" type="text"></div>   
					<span style="font-size:11px;color:#999">The name is how it appears on your site.</span>
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Slug:</label>
					<div>
					<div class="input text required"><input name="category_slug"  placeholder="Enter Slug"  class="form-control" id="category_slug" value="<?php echo isset($rowCategoryInfo->category_slug)?$rowCategoryInfo->category_slug:''; ?>" type="text"></div>   
					<span style="font-size:11px;color:#999">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
					</div>
					</div>
				
					
					
					
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Description:</label>
					<div>
					<textarea rows="3" cols="5" class="form-control" placeholder="Description" name="category_descri"><?php echo isset($rowCategoryInfo->category_descri)?$rowCategoryInfo->category_descri:''; ?></textarea>
					<span style="font-size:11px;color:#999">The description is not prominent by default; however, some themes may show it.</span>
					</div>
					</div>
			     
					
					</div>
					</div>
					<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:0px !important;">
					<div class="panel panel-white" style=" border-radius:0px;">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group2">SEO - Meta Tags
											<span style="float: left;font-size: 12px;color: #999;">Define category meta title, meta keywords and meta description to list your page in search engines</span>
											</a>
										</h6>
									</div>
									<div id="accordion-control-right-group2" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Title:</label>
					<div>
					<div class="input text required"><input name="category_meta_title"  placeholder="Enter meta title"  class="form-control"  value="<?php echo isset($rowCategoryInfo->category_meta_title)?$rowCategoryInfo->category_meta_title:''; ?>" type="text"></div>   
					<span style="font-size:11px;color:#999"> Max length 70 characters</span>
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Keywords:</label>
					<div>
					<div class="input text required"><textarea rows="3" cols="5" class="form-control" name="category_meta_keyword" placeholder="Keyword-1, Keyword-2, Keyword-3... "><?php echo isset($rowCategoryInfo->category_meta_keyword)?$rowCategoryInfo->category_meta_keyword:''; ?></textarea></div>   
					<span style="font-size:11px;color:#999">Max length 160 characters</span>
					</div>
					</div>
					<div class="form-group" style="margin-bottom: 10px;">
					<label class="control-label">Meta Description:</label>
					<div>
					<div class="input text required"><textarea name="category_meta_desc"  rows="3" cols="5" class="form-control" placeholder="Meta Description"><?php echo isset($rowCategoryInfo->category_meta_desc)?$rowCategoryInfo->category_meta_desc:''; ?></textarea></div>   
					<span style="font-size:11px;color:#999">Max length 250 characters</span>
					</div>
					</div>
										</div>
									</div>
								</div>
					</div>
					<div class="panel panel-flat" style="margin-bottom:0px; border-radius:0px; border-bottom: 0px;">
					<div class="panel-body" style="padding:20px 15px;">		
					<?php if($rowSelectPermission['pd_entry']==1)
{ ?>				
					<button type="submit" class="btn btn-primary btn-block" style="font-size:17px" onclick="return submitProcessCategory($(this))"><i class="icon-spinner2 spinner position-left spinner-form hide"></i>Save </button>
					<?php } ?>
					</div>
					</div>	
					 <?= $this->Form->end() ?>
					</div>
						<div class="col-lg-8">
						    <?= $this->Flash->render() ?>

							<div class="panel panel-default">
								<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/bcategories/bulkaction','enctype'=>'multipart/form-data']); ?>
			
						<div class="panel-body" style="background:#f5f5f5;">
						<div class="row">
						<div class="col-md-4">
						<div class="input-group">
<select class="form-control" name="bulkaction" id="bulkactionSelect">
<option value="">Bulk Action</option>
<?php if($rowSelectPermission['pd_delete']==1)
{ ?>
<option value="1">Delete</option>
	<?php } ?>
<option value="2">Active</option>
<option value="3">Inactive</option>
</select>
<span class="input-group-btn">
<button class="btn bg-teal" type="submit" id="bulkaction-button" style="margin-left:5px;">Action</button>
</span>
</div>
						</div>
						<div class="col-md-8">
						</div>
						</div>
						
						</div>
						<table class="table table-striped">
										<thead>
											<tr>
												<th style="text-align:center;width:3%;"><input type="checkbox" id="selectAll"></th>
												<th>Name</th>
												<th style="width: 217px;">Description</th>
												<th class="text-center"><i class="icon-arrow-down12"></i></th>
											</tr>
										</thead>
											<tbody >
											    
											    <?php foreach($resCategoryListData as $rowCategoryListData)
											    { ?>
<tr><td style="text-align:center"><input type="checkbox" name="category_id[]" class="checkbox clsSelectSingle" value="<?php echo $rowCategoryListData['category_id'] ?>"></td>
<td> 
    <div class="media-left">
        <div class="">
        <a href="#" class="text-default text-semibold"><?php echo $rowCategoryListData['category_name'] ?></a></div>
        <div class="text-muted text-size-small">
            <?php if( $rowCategoryListData['category_status']==1)
            { ?>
            <a href="<?php echo SITE_URL; ?>admin/bcategories/status/<?php echo $rowCategoryListData['category_id'] ?>"><span class="status-mark border-success"></span> Active</a>
            <?php }else{ ?>
            <a href="<?php echo SITE_URL; ?>admin/bcategories/status/<?php echo $rowCategoryListData['category_id'] ?>"><span class="status-mark border-danger"></span> Inactive</a>
            
            <?php } ?>
            </div>
        </div>
        </td>
        <td><?php echo $rowCategoryListData['category_descri'] ?></td>
 <td class="text-center">
     <ul class="icons-list">
     <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
     <ul class="dropdown-menu dropdown-menu-right">
										<li><a href="<?php echo SITE_URL; ?>admin/bcategories/index/<?php echo $rowCategoryListData['category_id'] ?>" style="padding:3px 15px">Edit</a></li>
										<li><a href="<?php echo SITE_URL; ?>admin/bcategories/deletepermanently/<?php echo $rowCategoryListData['category_id'] ?>" style="padding:3px 15px">Delete</a></li>		</ul>				
										</li>
	</ul>
</td>
											</tr>
									<?php } ?>
										</tbody>
										
									</table>
						 <?= $this->Form->end() ?>			

							</div>
							
							
						</div>

						</div>
			</div>
<script>var csrf_tocken=<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>


    
    <script>
function readURL(input) 
{
if (input.files && input.files[0]) {
var FileUploadPath = input.value;
var Extension = FileUploadPath.substring(
FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
if (Extension == "gif" || Extension == "png" ||  Extension == "jpeg" || Extension == "jpg") {
var reader = new FileReader();
reader.onload = function (e) {
$('#blash').attr('src', e.target.result);
};
reader.readAsDataURL(input.files[0]);
}else{
alert('Photo only allows file types of  PNG, JPG, JPEG');
}
}
}
function readURL1(input) 
{
if (input.files && input.files[0]) {
var FileUploadPath = input.value;
var Extension = FileUploadPath.substring(
FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
if (Extension == "gif" || Extension == "png" ||  Extension == "jpeg" || Extension == "jpg") {
var reader = new FileReader();
reader.onload = function (e) {
$('#blash1').attr('src', e.target.result);
};
reader.readAsDataURL(input.files[0]);
}else{
alert('Photo only allows file types of  PNG, JPG, JPEG');
}
}
}
</script>