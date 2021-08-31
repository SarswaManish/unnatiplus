<?php  use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
?>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Profile</span> - User Profile</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
            <li>Profile</li>
            <li class="active">User Profile</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h5 class="panel-title"><?php echo $rowUserInfo->user_first_name; ?> <?php echo $rowUserInfo->user_last_name; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body" style="padding:0px;">
                                    <table class="table table-striped">
                                        <tbody>
                                             <tr>
                                                <td style="background: #f3f3f3;">Full Name</td>
                                                <td style="background:#fff"><?php echo $rowUserInfo->user_first_name; ?> <?php echo $rowUserInfo->user_last_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Email Address</td>
                                                <td style="background:#fff"> <?php echo $rowUserInfo->user_email_id; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Mobile Number</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->user_mobile)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Password</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->user_password)?> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading"> 
                                    <h5 class="panel-title">Order History</h5>
                                </div>
                                <div class="panel-body" style="padding:0px;">
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
                                            	<th class="text-center"><i class="icon-arrow-down12"></i></th>
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
                                            $resProductName =$conn->execute('SELECT GROUP_CONCAT(CONCAT(product_name,\' X \',trans_quantity) SEPARATOR \',\') as productname FROM transactions INNER JOIN sk_product ON product_id=trans_item_id WHERE 1  AND (trans_main_id='.$rowTransList->trans_id.' OR trans_id='.$rowTransList->trans_id.')')->fetch('assoc');
                                            
                                            ?>
<tr>
<td style="text-align:center"><input type="checkbox"></td>
<td>
<a href="<?php echo $this->Url->build('/admin/order/orderdetail/'.$rowTransList->trans_id, true); ?>" class="text-default text-semibold" style="color:#0073aa !important;"> #<?php echo $rowTransList->trans_id; ?></a><br>
</td>
<td>
	<a href="javascript:;" class="text-default text-semibold" style="color:#0073aa !important;"><?php echo $rowUserInfo->user_first_name; ?> <?php echo $rowUserInfo->user_last_name; ?></strong> </a><br>
	<?php if($rowUserInfo->user_email_id!=''){ ?> <?php echo $rowUserInfo->user_email_id; ?> <?php } ?><br>
	<?php if($rowUserInfo->user_mobile_number!=''){ ?> <?php echo $rowUserInfo->user_mobile_number; ?> <?php } ?>
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

	 <?php } ?><br>
	 <?php echo $rowTransList->trans_method; ?>
	    </td>
	    	<td>
	    	    
	    	    <div class="btn-group btn-group-velocity ">
	                                <button type="button" <?php if($rowTransList->trans_status==1){ echo 'disabled';} ?> class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
	                                    <?php if($rowTransList->trans_status==1){ echo 'Delivered';}else{ ?>
	   <?php echo ($rowTransList->trans_status==1)?'Delivered':($rowTransList->trans_status==3)?'Dispatched':'Pending'; ?>   <?php } ?> <span class="caret"></span></button>
	 
									<ul class="dropdown-menu" >
										<li><a <?php if($rowTransList->trans_status!=3 && $rowTransList->trans_status!=1){ ?>  href="<?php echo SITE_URL; ?>admin/order/cancelorder/<?php echo $rowTransList->trans_id; ?>" <?php } ?>><i class="icon-cross"></i> Cancel Order</a></li>
										<li><a href="javascript:void(0);" <?php if($rowTransList->trans_status!=3  &&  $rowTransList->trans_status!=1){ ?>   data-toggle="modal" data-target="#modal_theme_primary" onclick="setTransid('<?php echo $rowTransList->trans_id;; ?>')" <?php } ?>><i class="icon-screen-full"></i> Order Dispatched</a></li>
										<li><a href="<?php echo SITE_URL; ?>admin/order/deliverorder/<?php echo $rowTransList->trans_id; ?>"><i class="icon-mail5"></i> Order Delivered</a></li>
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
					<?php if($rowTransList->invoice_pdf_file!='')
					{ ?>
					<li><a target="new" href="<?php echo SITE_URL; ?>pdf/<?php echo $rowTransList->invoice_pdf_file; ?>" style="padding:3px 15px">Print Invoice</a></li>
					<?php }else{ ?>
									<li><a target="new" href="<?php echo SITE_URL; ?>invoice/?trans_id=<?php echo $rowTransList->trans_id; ?>" style="padding:3px 15px">Print Invoice</a></li>
	
					<?php } ?>
					<li><a href="<?php echo $this->Url->build('/admin/order/cancelorder/'.$rowTransList->trans_id, true); ?>" style="padding:3px 15px">Cancel Order</a></li>
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
<div class="datatable-footer" style="padding-left: 17px; padding-right: 17px;">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading"> 
                                    <h5 class="panel-title">Cart History</h5>
                                </div>
                                <div class="panel-body" style="padding:0px;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align:left; width:10px; "><input type="checkbox" id="selectAll"></th>
                                                <th>S.no</th>
                                                <th>User Name</th>
                                                <th>Product Name</th>
                                                <th>Email</th>
                                                <th>Publish Date</th>
                                                <th style="text-align:center; width:180px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
                                            $count=0;
                                            if(count($cartlistInfo)>0)
                                            {
                                            foreach($cartlistInfo as $rowCartlistInfo):
                                            ?>
                                            <tr>
                                                <td style="text-align:left">
                                                    <input type="checkbox" name="user_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowCartlistInfo->cart_id);  ?>">
                                                </td>
                                                <td> <?php echo ++$count; ?></td>
                                                <td><?php echo $rowCartlistInfo->sk_user->user_first_name?> <?php echo $rowCartlistInfo->sk_user->user_last_name?></td>
                                                <td><div class=""><a  target="new" href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowCartlistInfo->sk_product->product_slug; ?>" class="text-default text-semibold"><?php echo $rowCartlistInfo->sk_product->product_name?></a></div></td>
                                                <td><?php echo $rowCartlistInfo->sk_user->user_email_id?></td>
                                                <td><span><?= date('d/m/Y h:i A',strtotime($rowCartlistInfo->cart_created)); ?></span></td>
                                                <td style="text-align:center">
                                                    <ul class="icons-list">
                                                        <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="#" style="padding:3px 15px">Send Notification</a></li>
                                                            <li><a href="#" style="padding:3px 15px">Send Message</a></li>
                                                            <li><a href="#" style="padding:3px 15px" onclick="return confirm('Are you sure you want to delete?');">Delete</a></li>		
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
                                    <div class="datatable-footer" style="padding-left: 17px; padding-right: 17px;" >
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading"> 
                                    <h5 class="panel-title">Wishlist History</h5>
                                </div>
                                <div class="panel-body" style="padding:0px;">
                                    <table class="table table-striped">
            <thead>
                <tr>
                    <th style="text-align:left; width:10px; "><input type="checkbox" id="selectAll"></th>
                    <th>S.no</th>
                    <th>User Name</th>
                    <th>Product Name</th>
                    <th>Email</th>
                    <th>Publish Date</th>
                    <th style="text-align:center; width:180px;">Action</th>
                </tr>
            </thead>
<tbody>
<?php $arrayStatus =array('<span class="label label-danger">Inctive</span>','<span class="label label-success">Active</span>');
$count=0;
if(count($wishlistInfo)>0)
{
foreach($wishlistInfo as $rowWishlistInfo):
?>
<tr>
<td style="text-align:left">
<input type="checkbox" name="user_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowWishlistInfo->wish_id);  ?>">
</td>
<td> <?php echo ++$count; ?></td>
<td><?php echo $rowWishlistInfo->sk_user->user_first_name?> <?php echo $rowWishlistInfo->sk_user->user_last_name?></td>
<td><div class=""><a  target="new" href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowWishlistInfo->sk_product->product_slug; ?>" class="text-default text-semibold"><?php echo $rowWishlistInfo->sk_product->product_name?></a></div></td>
<td><?php echo $rowWishlistInfo->sk_user->user_email_id?></td>
<td><span><?= date('d/m/Y h:i A',strtotime($rowWishlistInfo->wish_created)); ?></span></td>
<td style="text-align:center">
<ul class="icons-list">
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
<ul class="dropdown-menu dropdown-menu-right">
<li><a href="#" style="padding:3px 15px">Send Notification</a></li>
<li><a href="#" style="padding:3px 15px">Send Message</a></li>
<li><a href="#" style="padding:3px 15px" onclick="return confirm('Are you sure you want to delete?');">Delete</a></li>		
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
<div class="datatable-footer" style="padding-left: 17px; padding-right: 17px;">
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
                </div>
            </div>
        </div>
    </div>
</div>