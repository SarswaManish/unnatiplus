<?php  use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
use Cake\View\Helper\NumberToWordHelper;

$conn = ConnectionManager::get('default');
?> 

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Order Detail - EA-Publications</title>
<!-- Global stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/admin/css/icons/icomoon/styles.css"/><link rel="stylesheet" href="/admin/css/bootstrap.css"/><link rel="stylesheet" href="/admin/css/core.css"/><link rel="stylesheet" href="/admin/css/components.css"/><link rel="stylesheet" href="/admin/css/colors.css"/><script src="/admin/js/plugins/loaders/pace.min.js"></script><script src="/admin/js/core/libraries/jquery.min.js"></script><script src="/admin/js/core/libraries/bootstrap.min.js"></script><script src="/admin/js/plugins/loaders/blockui.min.js"></script><script src="/admin/js/plugins/visualization/d3/d3.min.js"></script><script src="/admin/js/plugins/visualization/d3/d3_tooltip.js"></script><script src="/admin/js/plugins/forms/styling/switchery.min.js"></script><script src="/admin/js/plugins/forms/styling/switch.min.js"></script>
<script src="/admin/js/plugins/forms/styling/uniform.min.js"></script><script src="/admin/js/plugins/forms/selects/bootstrap_multiselect.js"></script><script src="/admin/js/plugins/ui/moment/moment.min.js"></script><script src="/admin/js/plugins/pickers/daterangepicker.js"></script><script src="/admin/js/plugins/editors/summernote/summernote.min.js"></script><script src="/admin/js/pages/editor_summernote.js"></script><script src="/admin/js/plugins/loaders/progressbar.min.js"></script>

<script src="/admin/js/core/app.js"></script><style>

.dash {
    background: #333 none repeat scroll 0 0;
    float: left;
    height: 2px;
    margin-right: 5px;
    margin-top: 10px;
    width: 15px;
}
</style>
<script>var base_url='https://www.eapublications.org/';</script>
</head>
<body style="background:#fff">

<style>
table{
width:100%;
 border-collapse: collapse;
}
table td{
border:1px solid #ccc;
padding:10px;
}
p{
margin-bottom:5px;
margin-top:0px;
}
</style>

<table width="100%">
<tr>
<td style="text-align:center;">
<img src="https://www.eapublications.org/webroot/img/uploads/theme_image/1540813096logo.jpg" style="width:200px;">
<p>Website : www.eapublications.org</p>
</td>
<td colspan="6">
<p><strong>Office Address :</strong></p>
<p>S-52, 53, Mahaveer Nagar , Behind Jaipur Hospital, Gopalpura, Tonk<br>
Road, Jaipur , Rajasthan – 302018</p>
<p>Support : 7665505666</p>
<p>E-mail : engineersacademypublications@gmail.com</p>
<p>GSTIN : 08AAHFE1272F1ZM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAN : AAHFE1272F</p>
</td>
</tr>
<tr>
<td>
<p><strong>Buyer Details:</strong></p>
<p>Name : <?php echo $rowUserInfo->user_first_name.' '.$rowUserInfo->user_last_name;?></p>
<p>Address : <?php echo $rowAddressInfo['ab_address'].' '.$rowAddressInfo['ab_landmark'].' '.$rowAddressInfo['ab_locality'].' '.$rowAddressInfo['ab_city'].' '.$rowAddressInfo['ab_pincode']; ?></p>
<br>
<p>Email : <?php echo $rowUserInfo->user_email_id; ?></p>
<p>Phone No. : <?php echo $rowUserInfo->user_mobile; ?></p>
<p>City : <?php echo $rowAddressInfo['ab_city']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;State : <?php echo $rowAddressInfo['ab_state']; ?></p>
</td>
<td colspan="4">
<p><strong>Delivery Address:</strong></p>
<p>Name : <?php echo $rowAddressInfo['ab_name']; ?></p>
<p>Address : <?php echo $rowAddressInfo['ab_address'].' '.$rowAddressInfo['ab_landmark'].' '.$rowAddressInfo['ab_locality'].' '.$rowAddressInfo['ab_city'].' '.$rowAddressInfo['ab_pincode']; ?></p>
<br>
<p>Email : <?php echo $rowUserInfo->user_email_id; ?></p>
<p>Phone No. : <?php echo $rowAddressInfo['ab_phone']; ?></p>
<p>City : <?php echo $rowAddressInfo['ab_city']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;State : <?php echo $rowAddressInfo['ab_state']; ?></p>
</td>
<td>
<p><strong>Order ID</strong><br><?php echo $rowTransactionInfo->trans_id; ?></p>
<p><strong>Order Date</strong><br><?php echo date('d M Y',strtotime($rowTransactionInfo->trans_datetime)); ?></p>
<p><strong>Invoice No</strong><br><?php echo $rowTransactionInfo->trans_id; ?></p>
<p><strong>Invoice Date</strong><br><?php echo date('d M Y',strtotime($rowTransactionInfo->trans_datetime)); ?></p>
</td>
</tr>
<tr>
<td style="text-align:center;">Product Detail</td>
<td style="text-align:center;">Description</td>
<td style="text-align:center;">H.S.N.</td>
<td style="text-align:center;">Quantity</td>
<td style="text-align:center;">Rate</td>
<td style="text-align:center;">Gross Amount<br>(INR)</td>
</tr>
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
<td style="text-align:center;height: 200px;vertical-align: top;"><?php echo $rowTransList->product_name; ?></td>
<td style="text-align:center;height: 200px;vertical-align: top;">Product Detail</td>
<td style="text-align:center;height: 200px;vertical-align: top;">-</td>
<td style="text-align:center;height: 200px;vertical-align: top;"><?php echo $rowTransList->trans_quantity; ?></td>
<td style="text-align:center;height: 200px;vertical-align: top;">₹<?php  echo $rowTransList->trans_unit_price; ?></td>
<td style="text-align:center;height: 200px;vertical-align: top;">₹<?php  echo $rowTransList->trans_unit_price*$rowTransList->trans_quantity; ?></td>
</tr>
<?php }  ?>
<tr>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;" colspan="2">&nbsp;</td>
<td style="text-align:center;" colspan="2">TOTAL</td>
<td style="text-align:center;">₹<?php  echo $intTotalAMountIncludingDelivery-$rowTransactionInfo->trans_delivery_amount; ?></td>
</tr>
<tr>
<td style="text-align:center;"><strong>Mode of Payment</strong></td>
<td style="text-align:center;" colspan="2"><?php echo $rowTransactionInfo->trans_method; ?> </td>
<td style="text-align:center;">Discount</td>
<td style="text-align:center;"><?php if($rowTransactionInfo->trans_discount_amount>0) { echo ($rowTransactionInfo->trans_discount_amount/($intTotalAMountIncludingDelivery-$rowTransactionInfo->trans_delivery_amount))*100; }else{ echo '0%'; } ?></td>
<td style="text-align:center;"><?php if($rowTransactionInfo->trans_discount_amount>0) { echo '₹'.$rowTransactionInfo->trans_discount_amount; }else{ echo '₹0.00'; } ?></td>
</tr>
<tr>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;" colspan="4">Total Taxable Value After Discount</td>
<td style="text-align:center;">₹<?php echo $intTotalAMountIncludingDelivery-$rowTransactionInfo->trans_delivery_amount-$rowTransactionInfo->trans_discount_amount; ?></td>
</tr>
<tr>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">Add</td>
<td style="text-align:center;">SGST</td>
<td style="text-align:center;" colspan="2">0%</td>
<td style="text-align:center;">0</td>
</tr>
<tr>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">CGST</td>
<td style="text-align:center;" colspan="2">0%</td>
<td style="text-align:center;">0</td>
</tr>
<tr>
<td style="text-align:center;"><strong>Payment Reference Number</strong></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">IGST</td>
<td style="text-align:center;" colspan="2">0%</td>
<td style="text-align:center;">0</td>
</tr>
<tr>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">Add</td>
<td style="text-align:center;">Shipping</td>
<td style="text-align:center;" colspan="2"></td>
<td style="text-align:center;"><?php if($rowTransactionInfo->trans_delivery_amount>0) { echo '₹'.$rowTransactionInfo->trans_delivery_amount; }else{ echo '₹0'; } ?></td>
</tr>
<tr>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;" colspan="3">Total</td>
<td style="text-align:center;">₹<?php  echo $intTotalAmount = $intTotalAMountIncludingDelivery-$rowTransactionInfo->trans_discount_amount; ?></td>
</tr>
<tr>
<td style="text-align:center;">Amount Chargeable in Words / INR :</td>
<td style="text-align:center;" colspan="5"><?php echo $this->NumberToWord->convert_number_to_words($intTotalAmount); ?></td>
 
</tr>
</table>
<table>
    <tr style="    border: none;"><td  style="    border: none;">Declaration:</td></tr>
     <tr  style="    border: none;"><td  style="    border: none;">The goods sold are intended for end user consumption and not for resale.
:</td></tr>
 <tr  style="    border: none;"><td  style="    border: none;">The goods sold are Nil Rate Under GST // HSN Code 4901 (Printed Books)
</td></tr>
 <tr  style="    border: none;"><td  style="    border: none;">E. & O.E.</td></tr>
  <tr  style="    border: none;"><td  style="    border: none;text-align:right;font-weight:bold">Authorised Signature</td></tr>
  <tr  style="    border: none;"><td  style="    border: none;text-align:right;font-weight:bold">Engineers Academy Publications</td></tr>
  <tr  style="    border: none;border-top:1px solid #ccc"><td  style="    border: none;font-weight:bold">Office - 1: S-52, 53, Mahaveer Nagar, Behind Jaipur Hospital, Gopalpura, Tonk Road, Jaipur, Raj.- 302018</td></tr>
  <tr  style="    border: none;"><td  style="    border: none;font-weight:bold">Office – 2: 100-102, Ram Nagar-B, Bambala Pulia, Near Toll Tax, Pratapnagar, Jaipur-302033</td></tr>

</table>

