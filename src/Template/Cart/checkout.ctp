<?php        $resCartInfo =  $this->request->getSession()->read('cart_items');
 $intTotalDiscount =0;
$intSubTotal =0;
$intTotalGst =0;
$intTotalAmount =0;
foreach($resCartInfo as $key=>$label)
{ 
    ///echo $key;
    $rowProductInfo =$resProdutObject->find('all',['contain'=>['SkTaxes']])->where(['product_id'=>$key])->first();
 foreach($label as $unit=>$lab)
{
    
    $rowBusinessPriceData =$resBusinessPrice->find('all',['contain'=>['SkUnit','SkSize']])->Where(['pu_id'=>$lab['pu_id']])->first();
  ///  pr($rowBusinessPriceData);
    $intTotal =$rowBusinessPriceData->pu_net_price*$lab['qty']; 
     if(isset($rowProductInfo->sk_tax->tax_title)){
         
         if($rowProductInfo->sk_tax->tax_igst_percent>0)
         {
    $intGst = ($intTotal*$rowProductInfo->sk_tax->tax_igst_percent)/100;
         }else{
             $intGst =0;
         }
     } 
     $intTotalDiscount +=$rowBusinessPriceData->pu_discount*$lab['qty'];
     $intSubTotal +=$intTotal;
     $intTotalGst +=$intGst;
?>
 <?php }} ?>
<section>
<div class="container-fluid">
<div class="cart-section">
<div class="cart-section-left">
<div class="chk-box-section">
<div class="chk-box">
<div class="chk-box-header">
<h4><img src="<?php echo SITE_URL;?>assets/img/icon/tick.png">Shopping Cart</h4>
<p>Total Quantity: <?php echo $cartcount; ?> Item(s)</p>
<a href="<?php echo SITE_URL; ?>cart" class="change">Preview</a>
</div>
<div class="chk-box-body"></div>
</div>
<div class="chk-box">
<div class="chk-box-header">
<h4><img src="<?php echo SITE_URL;?>assets/img/icon/tick-gray.png" id="completeshippingaddressimage">Delivery Address</h4>
<p id="completeshippingaddress"></p>
<a href="<?php echo SITE_URL; ?>cart/checkout" style="display:none" class="changeshippingaddress change">Change</a>

</div>
<div class="chk-box-body p-15" id="shippingaddressbody">
<p>Please select the address where you want products to be delivered.</p>

<?php  foreach($resAddressList as $rowAddressList){ 
 ?>
<div class="address-select">
<div class="edit"  onclick="setEditData($(this))" data-toggle="modal" data-target="#myModal" data-json='<?php echo json_encode($rowAddressList); ?>'>Edit</div>
<input type="radio" value="<?php echo $rowAddressList->ab_id; ?>" onchange="set_shipping_charges()" name="trans_shipping_address" <?php if($rowAddressList->ab_default==1){ ?>checked="checked"<?php } ?>  data-address="<?php echo $rowAddressList->ab_name; ?> - <?php echo $rowAddressList->ab_phone; ?>,<?php echo $rowAddressList->ab_landmark; ?>, <?php echo $rowAddressList->ab_locality; ?>, <?php echo $rowAddressList->ab_address; ?>, <?php echo $rowAddressList->ab_city; ?>, <?php echo $rowAddressList->ab_state; ?> - <?php echo $rowAddressList->ab_pincode; ?>">
<h5><?php echo $rowAddressList->ab_name; ?> - <?php echo $rowAddressList->ab_phone; ?></h5>
<p><strong><?php echo $rowAddressList->ab_landmark; ?></strong></p>
<p><?php echo $rowAddressList->ab_locality; ?>, <?php echo $rowAddressList->ab_address; ?></p>
<p><?php echo $rowAddressList->ab_city; ?>, <?php echo $rowAddressList->ab_state; ?> - <?php echo $rowAddressList->ab_pincode; ?></p>
</div>
<?php } ?>
 
<a href="javascript:void(0)" onclick="opennextstep('shippingaddress')" class="continue">Continue</a>
<a href="javascript:void(0);" class="addnewadd" data-toggle="modal" data-target="#myModal" onclick="setnewaddress()">Add New Address</a>
</div>
</div>
<div class="chk-box">
<div class="chk-box-header">
<h4><img src="<?php echo SITE_URL;?>assets/img/icon/tick-gray.png" id="completebillingaddressimage">Billing Address</h4>
<p id="completebillingaddress"></p>
<a href="<?php echo SITE_URL; ?>cart/checkout" style="display:none" class="changebillingaddress change">Change</a>

</div>
<div class="chk-box-body p-15" id="billingaddressbody" style="display:none">
    <p>Please select the address for billing.</p>

<?php  foreach($resAddressList as $rowAddressList)
{ 
?>
<div class="address-select">
<div class="edit"  onclick="setEditData($(this))" data-toggle="modal" data-target="#myModal" data-json='<?php echo json_encode($rowAddressList); ?>'>Edit</div>
<input type="radio" value="<?php echo $rowAddressList->ab_id; ?>" name="trans_billing_address" <?php if($rowAddressList->ab_default==1){ ?>checked="checked"<?php } ?>  data-address="<?php echo $rowAddressList->ab_name; ?> - <?php echo $rowAddressList->ab_phone; ?>,<?php echo $rowAddressList->ab_landmark; ?>, <?php echo $rowAddressList->ab_locality; ?>, <?php echo $rowAddressList->ab_address; ?>, <?php echo $rowAddressList->ab_city; ?>, <?php echo $rowAddressList->ab_state; ?> - <?php echo $rowAddressList->ab_pincode; ?>">
<h5><?php echo $rowAddressList->ab_name; ?> - <?php echo $rowAddressList->ab_phone; ?></h5>
<p><strong><?php echo $rowAddressList->ab_landmark; ?></strong></p>
<p><?php echo $rowAddressList->ab_locality; ?>, <?php echo $rowAddressList->ab_address; ?></p>
<p><?php echo $rowAddressList->ab_city; ?>, <?php echo $rowAddressList->ab_state; ?> - <?php echo $rowAddressList->ab_pincode; ?></p>
</div>
<?php } ?>
    
    <a href="javascript:void(0)" onclick="opennextstep('billingaddress')" class="continue">Continue</a>
<a href="javascript:void(0);" class="addnewadd" data-toggle="modal" data-target="#myModal" onclick="setnewaddress()">Add New Address</a>
</div>
</div>
<div class="chk-box">
<div class="chk-box-header">
<h4><img src="<?php echo SITE_URL;?>assets/img/icon/tick-gray.png" id="gstdetailimage">GST Detail</h4>
<p id="gstdetail"></p>
<a href="<?php echo SITE_URL; ?>cart/checkout" style="display:none" class="changegstdetail change">Change</a>

</div>
<div class="chk-box-body p-15" id="gstdetailbody" style="display:none">
    <div class="radio-group">
          <input type="radio" name="trans_gst_detail" value="I have registered GST Number." onclick="changegstbox()">  I have registered GST Number.
  
    </div>
    <div class="form-group" id="gstdata" style="display:none">
        <input type="text" placeholder="Enter GST Number" name="trans_gst_number" class="form-control">
    </div>
     <div class="radio-group">
          <input type="radio" name="trans_gst_detail" value="I declare that I am not registered under GST as non applicability of the law." checked="checked"  onclick="changegstbox()">  I declare that I am not registered under GST as non applicability of the law.
    </div>
    
     <a href="javascript:void(0)" onclick="opennextstep('gstdetail')" class="continue">Continue</a>
</div>
</div>
<div class="chk-box">
<div class="chk-box-header">
<h4><img src="<?php echo SITE_URL;?>assets/img/icon/tick-gray.png">Payment</h4>
</div>
<div class="chk-box-body p-15" id="payment_body" style="display:none">
    
     <div class="radio-group">
          <input type="radio" name="trans_payment_method" value="1" >  
  Cash on delivery
    </div>
  
     <div class="radio-group">
          <input type="radio" name="trans_payment_method" value="2" checked="checked" > Debit card/ Credit Card/ UPI/ Net Banking
    </div>
    
     <a href="javascript:void(0)" onclick="comleteorder($(this))" class="continue">Complete Order</a>
</div>
</div>
</div>

</div>
<div class="cart-section-right">
<div class="csr-price-box">
<h3>Order Details</h3>
<ul>
        <?php      $intTotalAmount += $intTotalGst+$intSubTotal; ?>

<li>Sub-Total<span class="pull-right">₹<span id="subtotal"><?php echo number_format($intSubTotal,2,'.',''); ?></span></span></li>
<li>Shipping Charge<span class="pull-right">₹<span id="shipping_charges">6.00</span></span></span></li>
<li>Discount<span class="pull-right">₹<span id="discount"><?php echo number_format($intTotalDiscount,2,'.',''); ?></span></span></li>
<li>GST<span class="pull-right">₹<span id="gst_charges"><?php echo number_format($intTotalGst,2,'.',''); ?></span></span></li>
<hr>
<li><strong>Total Amount</strong><span class="pull-right">
    <strong>₹<span id="total_charges"><?php echo number_format($intTotalAmount,2,'.',''); ?></span></strong></span></li>
</ul>
</div>
</div>
</div>
</div>
</section>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Address</h4>
      </div>
      <div class="modal-body">
<div class="lr-box mt-20" id="addressform" style="">

<form method="post" accept-charset="utf-8" id="profileupdate" class="" action="<?php echo SITE_URL; ?>my-account/manage-address"> 

<div class="row">
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label class="active">Name</label>
                <input type="text" class="form-control" placeholder="Enter Name" name="ab_name"> 
                 <input type="hidden" class="form-control" placeholder="Enter Name" name="from" value="cart"> 
           </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label class="active">Mobile Number</label>
                <input type="text" class="form-control" placeholder="Enter Mobile Number" name="ab_phone">
                <input type="hidden" name="ab_id" value="33"> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label class="active">Pincode</label>
                <input type="text" class="form-control" placeholder="Enter Pincode" name="ab_pincode"> 
            </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label class="active">Locality</label>
                <input type="text" class="form-control" placeholder="Enter Locality" name="ab_locality"> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="lr-form-box">
                <label> Address</label>
                <textarea name="ab_address" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label class="active">City/District/Town</label>
                <input type="text" class="form-control" placeholder="Enter City/District/Town" name="ab_city">
               
            </div>
        </div>
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label>State</label>
                 <select name="ab_state" class="form-control">
                    <option>Select State</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                        <option value="Daman and Diu">Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kenmore">Kenmore</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Narora">Narora</option>
                                        <option value="Natwar">Natwar</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Paschim Medinipur">Paschim Medinipur</option>
                                        <option value="Pondicherry">Pondicherry</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="Vaishali">Vaishali</option>
                                        <option value="West Bengal">West Bengal</option>
                                    </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label class="active">Landmark (Optional)</label>
                <input type="text" placeholder="Enter Landmark" class="form-control" name="ab_landmark"> 
            </div>
        </div>
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label class="active">Alternate Phone (Optional)</label>
                <input type="text" placeholder="Enter Alternate Phone (Optional)" class="form-control" name="ab_alternate_phone">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="lr-form-box">
              <button type="submit" onclick="return checkaddressbook($(this))" class="btn btn-success">Save</button>
            </div>
        </div>

    </div> 
</form>

</div>
      </div>
      
    </div>

  </div>
</div>


<form method="post" accept-charset="utf-8" id="payment_method" class="" action="<?php echo SITE_URL; ?>cart/paymentprocessing"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
<input type="hidden" name="trans_address_id" value="">
<input type="hidden" name="trans_billing_address" value="">
<input type="hidden" name="trans_gst_detail" value="">
<input type="hidden" name="trans_gst_number" value="">
<input type="hidden" name="trans_address_id_data" value="">

<input type="hidden" name="trans_delivery_amount" id="trans_delivery_amount" value="0">
<input type="hidden" name="trans_coupon_id" id="trans_coupon_id" value="">
<input type="hidden" name="trans_discount_amount" id="trans_discount_amount" value="<?php echo $intTotalDiscount; ?>">
<input type="hidden" name="trans_igst" id="trans_gst_amount" value="<?php echo $intTotalGst; ?>">

<input name="trans_payment_method" type="hidden" value="">
</form>


<script>
$(document).ready(function(){
    set_shipping_charges();
});

var base = '<?php echo SITE_URL ; ?>';

function set_shipping_charges(){
    var checkedAddress = $("input[name='trans_shipping_address']:checked").val();
    $.ajax({
        url : base+'get-shipping',
        type:'post',
        data:{'state':checkedAddress},
        success:function(v){
            $('#shipping_charges').text(v);
            $('#trans_delivery_amount').val(v);
            var dis = parseFloat($('#trans_discount_amount').val());
            var gst = parseFloat($('#trans_gst_amount').val());
            var subtotal = $('#subtotal').text();
            var gstv = parseFloat(gst)+parseFloat(v)+parseFloat(subtotal);
             $('#total_charges').text('');
            $('#total_charges').text((gstv-dis));
        },
        error:function(x){
            console.log(x);
        }
    });
}
function checkaddressbook(objectElement){

var ab_name = $('input[name="ab_name"]').val();
if(ab_name.trim()=='')
{
$('input[name="ab_name"]').attr('style','border:1px solid red;');
return false;	 
}else{
$('input[name="ab_name"]').attr('style','');
}

var ab_phone = $('input[name="ab_phone"]').val();
if(ab_phone.trim()=='')
{
$('input[name="ab_phone"]').attr('style','border:1px solid red;');
return false;	 
}else{
$('input[name="ab_phone"]').attr('style','');
}          

var ab_pincode = $('input[name="ab_pincode"]').val();
if(ab_pincode.trim()=='')
{
$('input[name="ab_pincode"]').attr('style','border:1px solid red;');
return false;	 
}else{
$('input[name="ab_pincode"]').attr('style','');
}          
var ab_locality = $('input[name="ab_locality"]').val();
if(ab_locality.trim()=='')
{
$('input[name="ab_locality"]').attr('style','border:1px solid red;');
return false;	 
}else{
$('input[name="ab_locality"]').attr('style','');
}                    
var ab_address = $('textarea[name="ab_address"]').val();
if(ab_address.trim()=='')
{
$('textarea[name="ab_address"]').attr('style','border:1px solid red;');
return false;	 
}else{
$('textarea[name="ab_address"]').attr('style','');
}  
var ab_city = $('input[name="ab_city"]').val();
if(ab_city.trim()=='')
{
$('input[name="ab_city"]').attr('style','border:1px solid red;');
return false;	 
}else{
$('input[name="ab_city"]').attr('style','');
}  
var ab_state = $('select[name="ab_state"]').val();
if(ab_state.trim()=='')
{
$('select[name="ab_state"]').attr('style','border:1px solid red;');
return false;	 
}else{
$('select[name="ab_state"]').attr('style','');
}  
objectElement.html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i> Save');	


}

function setEditData(objectElement)
{
var Jsonparse = JSON.parse(objectElement.attr('data-json'));
$('input[name="ab_name"]').val(Jsonparse.ab_name);
$('input[name="ab_phone"]').val(Jsonparse.ab_phone);
$('input[name="ab_pincode"]').val(Jsonparse.ab_pincode);
$('select[name="ab_state"]').val(Jsonparse.ab_state);
$('input[name="ab_city"]').val(Jsonparse.ab_city);
$('textarea[name="ab_address"]').val(Jsonparse.ab_address);
$('input[name="ab_locality"]').val(Jsonparse.ab_locality);
$('input[name="ab_pincode"]').val(Jsonparse.ab_pincode);
$('input[name="ab_phone"]').val(Jsonparse.ab_phone);
$('input[name="ab_id"]').val(Jsonparse.ab_id);
$('input[name="ab_landmark"]').val(Jsonparse.ab_landmark);
$('input[name="ab_alternate_phone"]').val(Jsonparse.ab_alternate_phone);


}

function setnewaddress()
{
$('input[name="ab_name"]').val('');
$('input[name="ab_phone"]').val('');
$('input[name="ab_pincode"]').val('');
$('select[name="ab_state"]').val('');
$('input[name="ab_city"]').val('');
$('textarea[name="ab_address"]').val('');
$('input[name="ab_locality"]').val(''); 
$('input[name="ab_pincode"]').val('');
$('input[name="ab_phone"]').val('');
$('input[name="ab_id"]').val(0);
$('input[name="ab_landmark"]').val('');
$('input[name="ab_alternate_phone"]').val('');

}

function opennextstep(type)
{
    if(type=='shippingaddress')
    {
        $('#completeshippingaddressimage').attr('src','<?php echo SITE_URL;?>assets/img/icon/tick.png');
        $('.changeshippingaddress').show();
        
        var address = $('input[name=trans_shipping_address]:checked').attr('data-address');
        if($('input[name=trans_shipping_address]:checked').length>0){
            $('#completeshippingaddress').html("");
            $('#completeshippingaddress').html(address);
            $('#shippingaddressbody').hide();
            $('#billingaddressbody').show();
        }else{
             $('#shippingaddressbody').find('p').css('color','red');
        }
    }
     if(type=='billingaddress')
    {
        $('#completebillingaddressimage').attr('src','<?php echo SITE_URL;?>assets/img/icon/tick.png');
        $('.changebillingaddress').show();
        
        var address = $('input[name=trans_billing_address]:checked').attr('data-address');
        if($('input[name=trans_shipping_address]:checked').length>0){
            $('#completebillingaddress').html("");
            $('#completebillingaddress').html(address);
            $('#billingaddressbody').hide();
            $('#gstdetailbody').show();
        }else{
             $('#billingaddressbody').find('p').css('color','red');
        }
        
    }
    if(type=='gstdetail'){
        var gstnumber =$('input[name=trans_gst_number]').val();
        var address = $('input[name=trans_gst_detail]:checked').val();

      if(gstnumber.trim()!='' || address=='I declare that I am not registered under GST as non applicability of the law.')
          {
        $('#gstdetailimage').attr('src','<?php echo SITE_URL;?>assets/img/icon/tick.png');
        $('.changegstdetail').show();
        
        $('#gstdetail').html(address);
        $('#gstdetailbody').hide();
        $('#payment_body').show();
          }else{
              $('input[name=trans_gst_number]').attr('style','border:1px solid red');
              
          }
    }
}

function changegstbox(onj)
{
    var t = $('input[name=trans_gst_detail]:checked').val();
    if(t=='I have registered GST Number.')
    {
        $('#gstdata').show();
    }else{
             $('#gstdata').hide();
   
    }
    
}
function comleteorder(obj)
{
    obj.html('Processing');
    var gstdetail =$('input[name=trans_gst_detail]:checked').val();
    var gstnumber =$('input[name=trans_gst_number]').val();
        var billingaddress =$('input[name=trans_billing_address]:checked').attr('data-address');
        var shippingaddress =$('input[name=trans_shipping_address]:checked').attr('data-address');
                var shippingaddressid =$('input[name=trans_shipping_address]:checked').val();

        var payment =$('input[name=trans_payment_method]:checked').val();
$('input[name=trans_address_id]').val(shippingaddress);
$('input[name=trans_address_id_data]').val(shippingaddressid);

$('input[name=trans_billing_address]').val(billingaddress);
$('input[name=trans_gst_detail]').val(gstdetail);
$('input[name=trans_gst_number]').val(gstnumber);
$('input[name=trans_payment_method]').val(payment);
$('#payment_method').submit();

}
</script>