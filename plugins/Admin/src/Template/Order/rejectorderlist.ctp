<?php  use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
?>
<div class="page-container">
<div class="page-content">
<div class="content-wrapper">
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Orders</h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo SITE_URL; ?>admin/"><i class="icon-home2 position-left"></i> Home</a></li>
<li class="active">Orders</li>
</ul>
</div>
</div>
<div class="content">
     <?php  echo $this->Flash->render(); ?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Orders List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
<div class="heading-elements">
</div>
</div>
<div class="panel-body" style="background:#f5f5f5;">
<div class="row">
<div class="col-md-6">
<div class="st-list">
</div>
</div>
<div class="col-md-6">
</div>
</div>
</div>
<table class="table table-striped">
<thead>
<tr>
	<th style="text-align:center;width:3%;"><input type="checkbox"></th>
	<th style="width:5%;">ID</th>
	<th style="width:18%;">Customer Detail</th>
	<th style="width:18%;">Order Detail</th>
	<th>Price</th>
	<th>Payment Status</th>
	<th>Status</th>
		<th style="width:10%;">Date</th>

</tr>
</thead>
<tbody>
    <?php 
    if(count($resTransList)>0)
    {
    foreach($resTransList as $rowTransList)
    {
     $rowUserInfo =$resUserInfo->find('all')->where(['user_id'=>$rowTransList->trans_user_id])->first();
     $rowProductInfo = $resProductInfo->find('all')->where(['product_id'=>$rowTransList->trans_item_id])->first();
       $rowSubTotalInfo =$conn->execute('SELECT SUM(trans_amt) as total FROM transactions WHERE 1  AND (trans_main_id='.$rowTransList->trans_id.' OR trans_id='.$rowTransList->trans_id.')')->fetch('assoc');
       
        $rowSubTotalInfo =$conn->execute('SELECT SUM(trans_amt) as total FROM transactions WHERE 1  AND (trans_main_id='.$rowTransList->trans_id.' OR trans_id='.$rowTransList->trans_id.')')->fetch('assoc');
        
                            $resProductName =$conn->execute('SELECT GROUP_CONCAT(CONCAT(product_name,\' X \',trans_quantity) SEPARATOR \',\') as productname FROM transactions INNER JOIN sk_product ON product_id=trans_item_id WHERE 1  AND (trans_main_id='.$rowTransList->trans_id.' OR trans_id='.$rowTransList->trans_id.')')->fetch('assoc');

    ?>
<tr>
<td style="text-align:center"><input type="checkbox"></td>
<td>
<a href="<?php echo $this->Url->build('/admin/order/orderdetail/'.$rowTransList->trans_id, true); ?>" class="text-default text-semibold" style="color:#0073aa !important;"> #<?php echo $rowTransList->trans_id; ?></a><br>
</td>
<td>
	<a href="javascript:;" class="text-default text-semibold" style="color:#0073aa !important;"><?php echo (isset($rowUserInfo->user_first_name) && $rowUserInfo->user_first_name!="")?$rowUserInfo->user_first_name:""; ?> <?php echo (isset($rowUserInfo->user_last_name) && $rowUserInfo->user_last_name!="")?$rowUserInfo->user_last_name:""; ?></strong> </a><br>
	<?php if(isset($rowUserInfo->user_email_id) && $rowUserInfo->user_email_id!=''){ ?> <?php echo $rowUserInfo->user_email_id; ?> <?php } ?><br>
	<?php if(isset($rowUserInfo->user_mobile_number) &&  $rowUserInfo->user_mobile_number!=''){ ?> <?php echo $rowUserInfo->user_mobile_number; ?> <?php } ?>
	</td>
	
	<td><?php echo $resProductName['productname']; ?>	
	</td>

	<td><span class="text-success-600">₹<?php echo ($rowTransList->trans_amt>0)?$rowSubTotalInfo['total']-$rowTransList->trans_discount_amount:'-'; ?></span></td>
	<td>
	<?php if($rowTransList->trans_payment_status==1)
		{ 
		    ?>
	    <span class="label bg-success-400">Confirm</span>
	 <?php }else if($rowTransList->trans_payment_status==0 && $rowTransList->trans_method=='Cash on Delivery')
		{  ?>  
	 	    <span class="label bg-warning">Cash on Delivery</span>

	 <?php }else{ ?>
	 	 	    <span class="label bg-danger">Pending</span>

	 <?php } ?>
	    </td>
	    	<td>
	    	    
	    	    <div class="btn-group btn-group-velocity ">
	                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true" disabled>
	   <?php echo ($rowTransList->trans_status==1)?'Confirm':($rowTransList->trans_status==2)?'Canceled':'Pending'; ?> <span class="caret"></span></button>
									<ul class="dropdown-menu" >
										<li><a href="<?php echo SITE_URL; ?>order/cancelorder/<?php echo $rowTransList->trans_id; ?>"><i class="icon-cross"></i> Cancel Order</a></li>
										<li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal_theme_primary"><i class="icon-screen-full"></i> Order Dispatched</a></li>
										<li><a  href="<?php echo SITE_URL; ?>order/deliverorder/<?php echo $rowTransList->trans_id; ?>"><i class="icon-mail5"></i> Order Delivered</a></li>
									</ul>
	                            </div>
	                            
	                            
	                            
	
	    </td>
	    <td><strong><?php echo date('d/m/Y',strtotime($rowTransList->trans_datetime)); ?></strong><br> <?php echo date('h:i:s',strtotime($rowTransList->trans_datetime)); ?></td>

	<td class="text-center">
		<ul class="icons-list">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="<?php echo $this->Url->build('/admin/order/orderdetail/'.$rowTransList->trans_id, true); ?>" style="padding:3px 15px">View Order</a></li>
				
				</ul>
			</li>
		</ul>
	</td>
</tr>
<?php }
} else{ ?>
<tr><td colspan="10" style="text-align:center">No Result Found</td></tr>
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
</div>
</div>