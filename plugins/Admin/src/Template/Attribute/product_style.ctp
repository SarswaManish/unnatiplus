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
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Product Style</h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Product Style</li>
		</ul>
	</div>
</div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'tag-form','url'=>'/admin/attribute/productStyleProcessRequest']); ?>
                <input type="hidden" name="attterms_att_id" value="<?php echo  isset($rowFabricInfo->att_id)?$rowFabricInfo->att_id:'0'; ?>">
                <input type="hidden" name="attterms_id" value="<?php echo  isset($rowFabricList->attterms_id)?$rowFabricList->attterms_id:'0'; ?>">
                <div class="panel panel-flat" style="margin-bottom:0px; border-radius:0px; border-bottom: 0px;">
                    <div class="panel-body" style="padding:20px 15px;">
                        <div class="form-group " id="tag-name-error" style="margin-bottom: 10px;">
                            <label class="control-label">Name: <span style="color:red">*</span></label>
                            <div>
                                <div class="input text required"><input name="attterms_name" onkeyup="getTagslug(this.value)" placeholder="Enter Attribute Name"  class="form-control" id="tag_name" value="<?php echo  isset($rowFabricList->attterms_name)    ?$rowFabricList->attterms_name:''; ?>" type="text"></div>   
                                <span style="font-size:11px;color:#999">The name is how it appears on your site.</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;">
                            <label class="control-label">Slug:</label>
                            <div>
                                <div class="input text required"><input name="attterms_slug"  placeholder="Enter Slug" class="form-control" id="tag_slug" value="<?php echo  isset($rowFabricList->attterms_slug)?$rowFabricList->attterms_slug:''; ?>" type="text"></div>   
                                <span style="font-size:11px;color:#999">The ???slug??? is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-flat" style="margin-bottom:0px; border-radius:0px; border-bottom: 0px;">
                    <div class="panel-body" style="padding:20px 15px;">	<?php if($rowSelectPermission['pd_entry']==1)
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
                            <?php echo  $this->Form->create('', ['url'=>'/admin/attribute/productStylebulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select class="form-control" name="bulkaction" id="bulkactionSelect">
                                        <option value="">Bulk Action</option>
                                        <?php if($rowSelectPermission['pd_delete']==1)
                                        { ?>		
                                        <option value="1">Delete</option>
                                        <?php } ?>
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
                                <th class="text-center"><i class="icon-arrow-down12"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(count($resFabricInfo)>0)
                        {
                        foreach($resFabricInfo as $rowFabricListInfo)
                        { ?>	
                            <tr>
                                <td style="text-align:center"><input type="checkbox" name="attterms_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowFabricListInfo->attterms_id);  ?>"></td>
                                <td><?php echo $rowFabricListInfo->attterms_name; ?></td>
                                <td class="text-center">
                                    <ul class="icons-list">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                            <?php if($rowSelectPermission['pd_entry']==1)
                                            { ?>
                                                <li><a href="<?php echo $this->Url->build('/admin/attribute/productStyle/'.$rowFabricListInfo->attterms_id); ?>" style="padding:3px 15px">Edit</a></li>
                                            <?php } ?>
                                            <?php if($rowSelectPermission['pd_delete']==1)
                                            { ?>
                                                <li><a href="<?php echo $this->Url->build('/admin/attribute/deleteproductStyle/'.$rowFabricListInfo->attterms_id); ?>" style="padding:3px 15px">Delete</a></li>
                                            <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr><td colspan="4" style="text-align:center">No Result Found</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?= $this->Form->end() ?>
                    <div class="datatable-footer">
                            <div class="dataTables_info">
                                <?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?>
                            </div>
                            <div class="dataTables_paginate paging_simple_numbers">
                                <?= $this->Paginator->prev('???',['class'=>'paginate_button previous']); ?>
                                    <span>
                                <?= $this->Paginator->numbers(); ?>
                                </span>
                                <?= $this->Paginator->next(' ???'); ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <?= $this->Form->end() ?>
<!-- /content area -->
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip(); 
});
</script>			