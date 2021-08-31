<?php  use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
?> 
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
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Orders Details - #<?php echo $rowTransactionInfo->trans_id; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
<div class="heading-elements">
    	<?php if($rowTransactionInfo->invoice_pdf_file!='')
					{ ?>
					<li><a  class="btn btn-primary" target="new" href="<?php echo SITE_URL; ?>pdf/<?php echo $rowTransactionInfo->invoice_pdf_file; ?>">Print Invoice</a></li>
					<?php }else{ ?>
									<li><a  class="btn btn-primary" target="new" href="<?php echo SITE_URL; ?>invoice/?trans_id=<?php echo $rowTransactionInfo->trans_id; ?>">Print Invoice</a></li>
	
					<?php } ?>
					
					
</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-md-6">
<div class="panel panel-white">
<div class="panel-heading">
<h6 class="panel-title"> Order  Details</h6>
</div>

<div class="panel-body" style="padding:0px;">
<table class="table table-striped">
<tbody>
<tr>
<td style="background: #f3f3f3;">Order ID </td>
<td style="background:#fff">#<?php echo $rowTransactionInfo->trans_id; ?></td>
</tr>
<tr>
<td style="background: #f3f3f3;">Order date</td>
<td style="background:#fff"><?php echo date('D, M d, Y, h:i A',strtotime($rowTransactionInfo->trans_datetime)); ?> India Time</td>
</tr>
<tr>
<td style="background: #f3f3f3;">Order Status </td>
<td style="background:#fff"><?php if($rowTransactionInfo->trans_status==1)
		{ 
		    ?>
	    <span class="label bg-success-400">Delivered</span>
	 <?php }else if($rowTransactionInfo->trans_status==2)
		{   ?>  
	 	    <span class="label bg-primary">Canceled</span>

	 <?php }else if($rowTransactionInfo->trans_status==3)
		{ ?>
		 <span class="label bg-warning">Dispatched</span>
		<?php   }else{ ?>
	 	 	    <span class="label bg-danger">Pending</span>

	 <?php } ?></td>
</tr>
<tr>
<td style="background: #f3f3f3;">Payment Information</td>
<td style="background:#fff"><?php if($rowTransactionInfo->trans_payment_status==1)
		{ 
		    ?>
	    <span class="label bg-success-400">Confirm</span>
	 <?php }else{ ?>  
	 	    <span class="label bg-danger">Pending</span>

	 <?php } ?>  </td>
</tr>

<tr>
<td style="background: #f3f3f3;">Payment Method</td>
<td style="background:#fff"><?php echo $rowTransactionInfo->trans_method; ?>  </td>
</tr>

</tbody>
</table>
</div>
</div>
<div class="panel panel-white">
<div class="panel-heading">
<h6 class="panel-title"> Tracking Details</h6>
</div>

<div class="panel-body" style="padding:0px;">
<table class="table table-striped">
<tbody>
<tr>
<td style="background: #f3f3f3;">Id </td>
<td style="background:#fff"><?php echo ($rowTransactionInfo->trans_tracking_code!='')?$rowTransactionInfo->trans_tracking_code:'N/A';?> </td>
</tr>
<tr>
<td style="background: #f3f3f3;">Url </td>
<td style="background:#fff"><?php echo ($rowTransactionInfo->trans_tacking_url!='')?$rowTransactionInfo->trans_tacking_url:'N/A';?></td>
</tr>


</tbody>
</table>
</div>
</div>

</div>

<div class="col-md-6">
<div class="panel panel-white">
<div class="panel-heading">
<h6 class="panel-title"> Customer Details</h6>
</div>

<div class="panel-body" style="padding:0px;">
<table class="table table-striped">
<tbody>
<tr>
<td style="background: #f3f3f3;">Name </td>
<td style="background:#fff"><?php echo $rowUserInfo->user_first_name.' '.$rowUserInfo->user_last_name;?> </td>
</tr>
<tr>
<td style="background: #f3f3f3;">Phone No </td>
<td style="background:#fff"><?php echo $rowUserInfo->user_mobile; ?></td>
</tr>
<tr>
<td style="background: #f3f3f3;">Contact Email </td>
<td style="background:#fff"><?php echo $rowUserInfo->user_email_id; ?></td>
</tr>

</tbody>
</table>
</div>
</div>
<div class="panel panel-white">
<div class="panel-heading">
<h6 class="panel-title"> Delivery Address</h6>
</div>
<div class="panel-body" style="padding:0px;">
<table class="table table-striped">
<tbody>
    <tr>
<td style="background: #f3f3f3;">Delivery Date </td>
<td style="background:#fff"><?php if($rowTransactionInfo->trans_status==1) { echo date('D, M d, Y, h:i A',strtotime($rowTransactionInfo->trans_delivery_date)); }else{ ?>Not Available<?php } ?></td>
</tr>
<tr>
<td style="background: #f3f3f3;">Deliver to </td>
<td style="background:#fff">
    <p><?php echo $rowAddressInfo['ab_name']; ?></p>
   <p><?php echo $rowAddressInfo['ab_address'].' '.$rowAddressInfo['ab_landmark'].' '.$rowAddressInfo['ab_locality'].' '.$rowAddressInfo['ab_city'].' '.$rowAddressInfo['ab_pincode'].' <br>'.$rowAddressInfo['ab_state']; ?></p>
   <p>Phone: +91-<?php echo $rowAddressInfo['ab_phone']; ?></p>
</td>
</tr>


</tbody>
</table>
</div>
</div>


</div>
</div>
</div>
<div class="panel-body">
<table class="table table-framed">
<thead>
<tr>
<th style="text-align:center;width:3%;"><input type="checkbox"></th>
<th style="width:30%;">Products details</th>
<th>QTY</th>
<th>Unit Price</th>
</tr>
</thead>
<tbody>
<?php 
$rowProductInfo = $resProductObject->find('all')->where(['product_id'=>$rowTransactionInfo->trans_item_id])->first();

     $resTransList =$conn->execute('SELECT * FROM transactions INNER JOIN sk_product ON product_id=trans_item_id WHERE 1  AND (trans_main_id='.$rowTransactionInfo->trans_id.' OR trans_id='.$rowTransactionInfo->trans_id.')')->fetchAll('assoc');
$intTotalAMountIncludingDelivery = 0;
foreach($resTransList as $rowTransList)
{
    $rowTransList =(object)$rowTransList;
    $intTotalAMountIncludingDelivery +=$rowTransList->trans_amt; 
?>
<tr>
<td style="text-align:center"><input type="checkbox"></td>

<td>
<div class="media-left media-middle" style="padding-right:10px;">
<?php if(isset($rowTransList->product_featured_image) && ''!=$rowTransList->product_featured_image)
{ ?>
<a href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowTransList->product_slug; ?>" target="new"><?php echo $this->Html->image(SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowTransList->product_featured_image,array('id'=>"blash",'class'=>'img-circle img-xs'));?></a>
<?php } else { ?>											    
<a href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowTransList->product_slug; ?>" target="new"><?php echo $this->Html->image('Admin./images/placeholder.jpg',array('class'=>'img-circle img-xs')); ?></a>
	<?php } ?>
	
</div>
<div class="media-left">
	<div><a href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowTransList->product_slug; ?>/" target="new" class="text-default text-semibold" ><?php echo $rowTransList->product_name; ?></a></div>
</div>
</td>
<td><?php echo $rowTransList->trans_quantity; ?></td>
<td><span class="text-success-600">₹<?php  echo $rowTransList->trans_unit_price*$rowTransList->trans_quantity; ?></span></td>
</tr>
<?php }  ?>

<tr>
<td style="text-align:center" colspan="2">&nbsp;</td>
<td colspan="2" style="background: #f3f3f3;"><strong>Totals</strong></td>	
</tr>
<tr>
<td style="text-align:center;border: 0px;" colspan="2">&nbsp;</td>
<td style="background: #f3f3f3;">Item subtotal</td>	
<td>₹<?php  echo $intTotalAMountIncludingDelivery-$rowTransactionInfo->trans_delivery_amount; ?></td>	
</tr>
<tr>
<td style="text-align:center;border: 0px;" colspan="2">&nbsp;</td>
<td style="background: #f3f3f3;">Delivery Charge</td>	
<td><?php if($rowTransactionInfo->trans_delivery_amount>0) { echo '₹'.$rowTransactionInfo->trans_delivery_amount; }else{ echo 'Free'; } ?></td>	
</tr>
<tr>
<td style="text-align:center;border: 0px;" colspan="2">&nbsp;</td>
<td style="background: #f3f3f3;">Discount</td>	
<td><?php if($rowTransactionInfo->trans_discount_amount>0) { echo '₹'.$rowTransactionInfo->trans_discount_amount; }else{ echo '₹0.00'; } ?></td>	
</tr>
<tr>
<td style="text-align:center;border: 0px;" colspan="2">&nbsp;</td>
<td style="background: #f3f3f3;"><strong>Grand total</strong></td>	
<td><strong>₹<?php  echo $intTotalAMountIncludingDelivery-$rowTransactionInfo->trans_discount_amount; ?></strong></td>	
</tr>
</tbody>
</table>
</div>

</div>
</div>
</div>
</div>
