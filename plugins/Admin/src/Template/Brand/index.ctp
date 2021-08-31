<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');
$rowAdminInfo =  $this->request->getSession()->read('ADMIN');
$rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=3 ')->fetch('assoc');
if(!isset($rowSelectPermission['pd_id']))
{
    header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
}
?>
    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Brands</h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="<?php echo SITE_URL; ?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Brand</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'tag-form','url'=>'/admin/brand/tagProcessRequest','enctype'=>'multipart/form-data']); ?>
                    <input type="hidden" name="brand_id" value="<?php echo  isset($rowTagInfo->brand_id)?$rowTagInfo->brand_id:'0'; ?>">
                    <div class="panel panel-flat" style="margin-bottom:0px; border-radius:0px; border-bottom: 0px;">
                        <div class="panel-body" style="padding:20px 15px;">
                            <div class="form-group " id="tag-name-error" style="margin-bottom: 10px;">
                                <label class="control-label">Brand Name: <span style="color:red">*</span></label>
                                <div>
                                    <div class="input text required">
                                        <input name="brand_name" onkeyup="getTagslug(this.value)" placeholder="Enter Brand Name" class="form-control" id="tag_name" value="<?php echo  isset($rowTagInfo->brand_name)?$rowTagInfo->brand_name:''; ?>" type="text">
                                    </div>
                                    <span style="font-size:11px;color:#999">The name is how it appears on your site.</span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label class="control-label">Slug:</label>
                                <div>
                                    <div class="input text required">
                                        <input name="brand_slug" placeholder="Enter Brand Slug" class="form-control" id="tag_slug" value="<?php echo  isset($rowTagInfo->brand_slug)?$rowTagInfo->brand_slug:''; ?>" type="text">
                                    </div>
                                    <span style="font-size:11px;color:#999">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label class="control-label">Description:</label>
                                <div>
                                    <textarea rows="3" cols="5" class="form-control" placeholder="Description" name="brand_desc">
                                        <?php echo  isset($rowTagInfo->brand_desc)?$rowTagInfo->brand_desc:''; ?>
                                    </textarea>
                                    <span style="font-size:11px;color:#999">The description is not prominent by default; however, some themes may show it.</span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label class="control-label">Thumbnail:</label>
                                <div>
                                    <div class="media no-margin-top">
                                        <div class="media-left" style="padding-right: 5px;">
                                            <?php if(isset($rowTagInfo->brand_image) && $rowTagInfo->brand_image!='')
										    { ?>
                                                <a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH.$rowTagInfo->brand_image; ?>" style="width: 58px; height: 58px;" id="blash1" alt="" ></a>
                                            <?php }else{ ?>
                                                <a href="#"><img src="<?php echo SITE_URL;?>admin/images/placeholder.jpg" style="width: 58px; height: 58px;" id="blash1" alt="" ></a>
                                            <?php } ?>
                                        </div>
                                        <div class="media-body">
                                            <div class="uploader">
                                                <input class="file-styled" onchange="readURL1(this)" type="file" name="brand_image_"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400" style="-moz-user-select: none;">Choose File</span></div>
                                            <span class="help-block">Accepted: gif, png, jpg. Max file size 2Mb</span>
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
                                <button type="submit" onclick="return submitProcessTag($(this))" class="btn btn-primary btn-block" style="font-size:17px"><i class="icon-spinner2 spinner position-left spinner-form hide"></i>Save </button>
                            <?php } ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
            </div>
            <div class="col-lg-8">
                <?= $this->Flash->render() ?>
                    <div class="panel panel-default">
                        <div class="panel-body" style="background:#f5f5f5;">
                            <div class="row">
                                <?php echo  $this->Form->create('', ['url'=>'/admin/brand/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
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
                                <div class="col-md-8"></div>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center;width:3%;"><input type="checkbox" id="selectAll"></th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-center"><i class="icon-arrow-down12"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								if(count($resTagList)>0)
								{
								foreach($resTagList as $rowTagListInfo)
								{ ?>
                                    <tr>
                                        <td style="text-align:center"><input type="checkbox" name="brand_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowTagListInfo->brand_id);  ?>"></td>
                                        <td>
                                            <div class="media-left media-middle" style="padding-right:10px;">
                                                <?php if($rowTagListInfo->brand_image!='')
										        { ?>
                                                    <a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH.$rowTagListInfo->brand_image; ?>" class="img-circle img-xs"></a>
                                                <?php }else{ ?>
                                                    <a href="#"><img src="<?php echo SITE_URL;?>admin/images/placeholder.jpg" class="img-circle img-xs"></a>
                                                <?php } ?>
                                            </div>
                                            <div class="media-left">
                                                <div class="">
                                                    <a href="#" class="text-default text-semibold">
                                                        <?php echo $rowTagListInfo->brand_name; ?>
                                                    </a>
                                                </div>
                                                <div class="text-muted text-size-small">
                                                    <?php if($rowTagListInfo->brand_status==1)
										            { ?>
                                                        <a href="<?php echo SITE_URL; ?>admin/brand/status/<?php echo $rowTagListInfo->brand_id; ?>"><span class="status-mark border-success"></span> Active</a>
                                                    <?php }else{ ?>
                                                        <a href="<?php echo SITE_URL; ?>admin/brand/status/<?php echo $rowTagListInfo->brand_id; ?>"><span class="status-mark border-danger"></span> Inactive</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-toggle="tooltip" title="<?php echo $rowTagListInfo->brand_desc; ?>">
                                            <?php echo ($rowTagListInfo->brand_desc!='')?substr($rowTagListInfo->brand_desc,0,50).'...':'-'; ?>
                                        </td>
                                        <td class="text-center">
                                            <ul class="icons-list">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <?php if($rowSelectPermission['pd_entry']==1)
                                                        { ?>
                                                            <li><a href="<?php echo $this->Url->build('/admin/brand/index/'.$rowTagListInfo->brand_id); ?>" style="padding:3px 15px">Edit</a></li>
                                                        <?php } ?>
                                                        <?php if($rowSelectPermission['pd_delete']==1)
                                                        { ?>
                                                            <li><a href="<?php echo $this->Url->build('/admin/brand/deletepermanently/'.$rowTagListInfo->brand_id); ?>" style="padding:3px 15px">Delete</a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php }}else{ ?>
                                    <tr>
                                        <td colspan="4">No Brand Found</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="datatable-footer">
                            <div class="dataTables_info">
                                <?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?>
                            </div>
                            <div class="dataTables_paginate paging_simple_numbers">

                                <?= $this->Paginator->prev('←',['class'=>'paginate_button previous']); ?>
                                    <span>
                                    <?= $this->Paginator->numbers(); ?>
                                    </span>
                                    <?= $this->Paginator->next(' →'); ?>

                            </div>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
            </div>

        </div>
        <!-- /dashboard content -->

    </div>
    <!-- /content area -->

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var FileUploadPath = input.value;
                var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
                if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg") {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#blash').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('Photo only allows file types of  PNG, JPG, JPEG');
                }
            }
        }

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var FileUploadPath = input.value;
                var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
                if (Extension == "gif" || Extension == "png" || Extension == "jpeg" || Extension == "jpg") {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#blash1').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('Photo only allows file types of  PNG, JPG, JPEG');
                }
            }
        }
    </script>