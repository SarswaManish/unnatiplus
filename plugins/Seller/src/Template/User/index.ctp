<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');
$rowAdminInfo =  $this->request->getSession()->read('ADMIN');
$rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=6 ')->fetch('assoc');
if(!isset($rowSelectPermission['pd_id']))
{
    header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
}
?>
<!-- Bordered panel body table -->		
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">User</span> - Manage User</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Manage User</li>
        </ul>
    </div>
</div>
<div class="content">
    <?= $this->Flash->render();  ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">User Listing</h5>
            
        </div>
      
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Unique Id</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th style="text-align:center;">Publish Date</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center; width:180px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
                $count=0;
                if(count($resCouponInfo)>0)
                {
                foreach($resCouponInfo as $rowCouponInfo):
                ?>
                <tr>
                    <td> <?php echo ++$count; ?></td>
                    <td> <?php echo $rowCouponInfo->user_unique_id; ?></td>
                    <td><div class=""><a  target="new" href="<?php echo SITE_URL; ?>seller/user/user-view/<?php echo $rowCouponInfo->user_id; ?>" class="text-default text-semibold"><?= h($rowCouponInfo->user_first_name.' '.$rowCouponInfo->user_last_name) ?></a></div></td>
                    <td><?= h((($rowCouponInfo->user_email_id!='')?$rowCouponInfo->user_email_id:'-')); ?></td>
                    <td><?= h((($rowCouponInfo->user_mobile!='')?$rowCouponInfo->user_mobile:'-')); ?></td>
                    <td style="text-align:center"><?= date("d M, Y", strtotime($rowCouponInfo->user_created_datetime)) ?></td>
                    <td style="text-align:center"> 
                        <a href="#"><?php echo $arrayStatus[$rowCouponInfo->user_status]; ?></a>
                    </td>
                    <td style="text-align:center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="<?php echo SITE_URL; ?>seller/user/user-view/<?php echo $rowCouponInfo->user_id; ?>" style="padding:3px 15px">View</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php endforeach;
                }else{ ?>
                <tr><td colspan="8" class="text-center">No Result Found</td></tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="datatable-footer">
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  } );
</script>