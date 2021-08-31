<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=11 ')->fetch('assoc');
if(!isset($rowSelectPermission['pd_id']) && $rowAdminInfo['admin_default']==0)
{
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
}
?>
<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Frequent Ask Questions</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Frequent Ask Questions</li>
        </ul>
    </div>
</div>
<div class="content">
    <?= $this->Flash->render();  ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">FAQ Listing</h5>
            <div class="heading-elements">
                <?php if($rowSelectPermission['pd_entry']==1)
                { ?>
                    <a href="<?php echo SITE_URL; ?>admin/faq/addfaq" class="btn btn-primary"><i class="icon-file-plus position-left"></i> Add New</a>
                <?php } ?>
            </div>
        </div>
        <div class="panel-body" style="background:#f5f5f5;">
            <div class="row">
                <?php echo  $this->Form->create('', ['url'=>'/admin/faq/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
                <div class="col-md-4">
                    <div class="input-group">
                        <select class="form-control" onclick="Selectstaus()" name="bulkaction" >
                            <option>Bulk Action</option>
                            <option value="1">Delete</option>
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
                <th style="text-align:left; width:10px; "> <input type="checkbox" id="selectAll"></th>
                <th>S.no</th>
                <th>Questions</th>
                <th>Answers</th>
                <th style="text-align:center;">Publish Date</th>
                <th style="text-align:center; width:180px;">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
                $counter =0;
                if(isset($resRolesList) && count($resRolesList)>0)
                {
                    foreach($resRolesList as $rowRolesInfo):
                    $counter++;
                ?>
                <tr>
                    <td style="text-align:left"> <input type="checkbox" name="faq_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowRolesInfo->faq_id);  ?>"> </td>
                    <td><?= h($counter) ?></td>
                    <td><?= h($rowRolesInfo->faq_qus) ?></td>
                    <td><?= h($rowRolesInfo->faq_ans) ?></td>
                    <td style="text-align:center"><?= date("d/m/Y", strtotime($rowRolesInfo->faq_publish_Date)) ?></td>
                    <td style="text-align:center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                <?php if($rowSelectPermission['pd_entry']==1)
                                { ?>
                                    <li><a href="<?php echo SITE_URL; ?>admin/faq/addfaq/<?php echo $rowRolesInfo->faq_id; ?>" style="padding:3px 15px">Edit</a></li>
                                    <li><a href="<?php echo SITE_URL; ?>admin/faq/faqdelete/<?php echo $rowRolesInfo->faq_id; ?>" style="padding:3px 15px">Delete</a></li>
                                <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php  endforeach;
                }else{ ?>
                <tr><td colspan="6" class="text-center">No Result Found</td></tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="datatable-footer" >
            <div class="dataTables_info"><?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?></div>
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
<?= $this->Form->end() ?>
