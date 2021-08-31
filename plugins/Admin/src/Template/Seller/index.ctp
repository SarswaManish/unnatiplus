<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');
$rowAdminInfo =  $this->request->getSession()->read('ADMIN');
$rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=7 ')->fetch('assoc');
if(!isset($rowSelectPermission['pd_id']))
{
header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'admin/index')));
}
?>
    <!-- Bordered panel body table -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Manage Seller</span> - Manage Seller</h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Manage Seller</li>
            </ul>
        </div>
    </div>
    <div class="content">
        <?= $this->Flash->render();  ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Seller Listing</h5>
                    <div class="heading-elements">
                        <?php if($rowSelectPermission['pd_entry']==1)
                        { ?>
                            <a href="javascript:void(0);" onclick="show_filter(this);" class="btn btn-primary" style="margin-right:10px;">Filter</a>
                            <a href="<?php echo SITE_URL;?>admin/seller/export" class="btn btn-primary" style="margin-right:10px;"><i class="icon-database-export position-left"></i> Export</a>
                        <?= $this->Html->link(__('<i class="icon-file-plus position-left"></i> Add New'), ['action' => 'addseller'],['class'=>'btn btn-primary','escape'=>false]) ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel-body" id="search_box" style="display:none;background:#f5f5f5;">
                    <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'']); ?>
                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="filter_keyword" placeholder="Enter Name, Email, Phone Number" value="<?php echo isset($rowFilterData['KEYWORD'])?$rowFilterData['KEYWORD']:''; ?>">
                        </div>
                        <div class="col-md-1">
                            <span class="input-group-btn">
                            <button type="submit" class="btn bg-teal" style="height: 39px;border-radius:3px!important;">Search</button>
                            </span>
                        </div>
                        <div class="col-md-1">
                            <span class="input-group-btn">
                                <a href="<?php echo SITE_URL;?>admin/seller/reset" ><button type="button" class="btn bg-teal" style="height:39px;border-radius:3px!important;">Reset</button></a>
                            </span>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>                
                <div class="panel-body" style="background:#f5f5f5;">
                    <div class="row">
                        <?php echo  $this->Form->create('', ['url'=>'/admin/seller/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
                        <div class="col-md-4">
                            <div class="input-group">
                                <select class="form-control" onclick="Selectstaus()" name="bulkaction" >
                                    <option>Bulk Action</option>
                                    <option value="1">Delete</option>
                                    <option value="2">Active</option>
                                    <option value="3">Inactive</option>
                                </select>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn bg-teal" id="bulkaction-button" style="height:39px;">Apply</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="text-align:left; width:10px; "><input type="checkbox" id="selectAll"></th>
                            <th style="text-align:left; ">S.no</th>
                            <th style="text-align:left; ">Unique Id</th>
                                                             <th style="text-align:center; ">Type</th>

                            <th style="text-align:left; ">Seller Info </th>
                            <th style="text-align:left; ">Business Info</th>
                            <th style="text-align:center; ">Total Order</th>
                            <th style="text-align:center; ">Total Product</th>
                    <!--   <th style="text-align:center; ">City</th>-->
                            
                            <th style="text-align:center;">Status</th>
                            <th style="text-align:center; width:180px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
                      
                        $count=0;
                        foreach($resSeller as $rowSeller):
                          
                        ?>
                            <tr>
                                <td style="text-align:left">
                                    <input type="checkbox" name="seller_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowSeller->seller_id) ?>">
                                </td>
                                <td><?php echo ++$count; ?></td>
                                <td><?php echo $rowSeller->seller_unique_id; ?></td>
                                <td><?php echo ($rowSeller->seller_type==0)?"Seller":"Agent"; ?></td>
                                <td>
                                    <div class="media-left media-middle">
                                        <?php if(isset($rowSeller->business_logo) && $rowSeller->business_logo!='')	
                                        {?>
                                            <img src="<?php echo SITE_UPLOAD_URL.SITE_SELLER_IMAGE_PATH.$rowSeller->business_logo; ?>" class="img-circle img-xs" alt="" style="border: 1px solid #ccc;">
                                        <?php }else{ ?>
                                                <img src="<?php echo SITE_URL?>/admin/images/placeholder.jpg" class="img-circle img-xs" alt="" style="border: 1px solid #ccc;">
                                        <?php } ?>
                                    </div>
                                    <div class="media-left">
                                        <strong><?= h($rowSeller->seller_fname) ?></strong>
                                        <br>
                                        <?= h($rowSeller->seller_email) ?>
                                            <br>
                                            <?= h($rowSeller->seller_phone) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="media-left">
                                        <strong><?= h($rowSeller->business_name) ?></strong>
                                        <br>
                                        <?= h($rowSeller->business_email) ?>
                                            <br>
                                        <?= h($rowSeller->business_phone) ?>
                                    </div>
                                </td>
                                <td style="text-align:center"> <a href="javascript:void(0);">0</a> </td>
                                <td style="text-align:center"> <a href="javascript:void(0);">0</a> </td>
                                <td style="text-align:center">
                                    <?php	if($rowSeller->seller_status==1)
                                    { ?>
                                        <a href="<?php echo SITE_URL; ?>admin/seller/status/<?php echo $rowSeller->seller_id; ?>"><span class="label label-success">Active </span> </a>
                                    <?php }else   { ?>
                                            <a href="<?php echo SITE_URL; ?>admin/seller/status/<?php echo $rowSeller->seller_id; ?>"> <span class="label label-danger ">Inactive</span> </a>
                                    <?php } ?>
                                </td>
                                <td style="text-align:center">
                                    <ul class="icons-list">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <?php if($rowSelectPermission['pd_entry']==1)
                                                { ?>
                                                    <li><a href="<?php echo SITE_URL; ?>admin/seller/addseller/<?php echo $rowSeller->seller_id; ?>" style="padding:3px 15px">Edit</a></li>
                                                <?php } ?>
                                                <?php if($rowSelectPermission['pd_delete']==1)
                                                { ?>
                                                    <li><a href="<?php echo SITE_URL; ?>admin/seller/deletepermanently/<?php echo $rowSeller->seller_id; ?>" style="padding:3px 15px">Delete</a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
    </div>
    <?php $this->Form->end() ?>
<script>
    function show_filter(box)
    {
        if($('#search_box').css('display')=='none')
        {
            $('#search_box').slideDown();
            $(box).css({'background':'#fff','color':'#2196F3'});
        }
        else
        {
            $('#search_box').slideUp();
            $(box).css({'background':'#2196F3','color':'#fff'});
        }
    }
</script>