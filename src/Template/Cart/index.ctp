<?php 
$rowAdminInfo = $this->rowAdminInfo = $this->request->getSession()->read('USER');
if(count($resCartInfo)>0){ 
?>
<section>
   <div class="container-fluid">
      <div class="cart-section">
         <div class="cart-section-left">
            <div class="csl-box">
               <div class="csl-box-header">
                  <div class="row">
                     <div class="col-lg-5">Product</div>
                     <div class="col-lg-2"></div>
                     <div class="col-lg-1"></div>
                     <div class="col-lg-2"></div>
                     <div class="col-lg-1 text-center">Amount</div>
                     <div class="col-lg-1 text-center">GST</div>
                  </div>
               </div>
               <?php 
                  $intTotalDiscount =0;
                  $intSubTotal =0;
                  $intTotalGst =0;
                  $intTotalAmount =0;
                  $intGst = 0;
                  
                  foreach($resCartInfo as $key=>$label)
                  { 
                     
                     $rowProductInfo =$resProdutObject->find('all',['contain'=>['SkTaxes']])->where(['product_id'=>$key])->first();
                     if(!empty($rowProductInfo)){
                         
                     
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
                   ////   $intTotalDiscount +=$rowBusinessPriceData->pu_discount*$lab['qty'];
                      $intSubTotal +=$intTotal;
                      $intTotalGst +=$intGst;
                  ?>
               <div class="csl-box-list">
                  <div class="row">
                     <div class="col-lg-5">
                        <div class="cslbl-con-box">
                           <div class="cslbl-con-img">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image1; ?>"  > 
                           </div>
                           <div class="cslbl-con-dec">
                              <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowProductInfo->product_slug;?>"><?php echo $rowProductInfo->product_name; ?></a>
                              <p>SKU: <?php echo $rowProductInfo->product_sku;?></p>
                              <p><?php echo $rowProductInfo->product_tagline;?></p>
                              <div class="pi-label mt-10 mb-10">
                                 <?php if(isset($rowProductInfo['product_label']) && $rowProductInfo['product_label']=='Excellent Quality')
                                    {?>
                                 <span class="label-pi bg-success-400"><?php echo $rowProductInfo->product_label;?></span>
                                 <?php }else if(isset($rowProductInfo['product_label']) && $rowProductInfo['product_label']=='Average Quality')
                                    {?>
                                 <span class="label-pi bg-danger text-white"><?php echo $rowProductInfo->product_label;?></span>
                                 <?php }else if(isset($rowProductInfo['product_label']) && $rowProductInfo['product_label']=='Good Quality')
                                    {?>
                                 <span class="label-pi bg-warning text-white"><?php echo $rowProductInfo->product_label;?></span>
                                 <?php }?>
                              </div>
                              <div class="cslbl-meta">
                                 <ul>
                                    <li><a href="javascript:void(0);" onclick="removefromcart('<?php echo $rowBusinessPriceData->pu_id; ?>',$(this),'<?php echo $rowProductInfo->product_id;?>')"><i class="icon-trash"></i>Remove</a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-2">
                        <div class="csl-qty"></div>
                     </div>
                     <div class="col-lg-1">
                        <div class="csl-text"><?php echo $lab['qty']; ?> <?php if(isset($rowBusinessPriceData->sk_unit->unit_name)){ echo $rowBusinessPriceData->sk_unit->unit_name;  }else{ echo 'piece'; } ?></div>
                     </div>
                     <div class="col-lg-2">
                        <div class="csl-text text-center">₹ <?php echo number_format($rowBusinessPriceData->pu_net_price,2,'.',''); ?>/<?php if(isset($rowBusinessPriceData->sk_unit->unit_name)){ echo $rowBusinessPriceData->sk_unit->unit_name;  }else{ echo 'piece'; } ?>
                           <br> <?php if(isset($rowProductInfo->sk_tax->tax_title)){ echo $rowProductInfo->sk_tax->tax_title;  } ?>
                        </div>
                     </div>
                     <div class="col-lg-1">
                        <div class="csl-text text-center">₹<?php echo number_format($intTotal,2,'.',''); ?></div>
                     </div>
                     <div class="col-lg-1">
                        <div class="csl-text text-center">₹<?php echo number_format($intGst,2,'.',''); ?></div>
                     </div>
                  </div>
               </div>
               <?php }}} ?>
            </div>
         </div>
         <div class="cart-section-right">
            <div class="csr-price-box">
               <h3>Order Details</h3>
               <ul>
                <?php      $intTotalAmount += $intTotalGst+$intSubTotal; ?>
                <li>Sub-Total<span class="pull-right">₹<span id="subtotal"><?php echo number_format($intSubTotal,2,'.',''); ?></span></span></li>
                <li style="display:none">Shipping Charge<span class="pull-right">₹<span id="shipping_charges">6.00</span></span></span></li>
                <li>Discount<span class="pull-right">₹<span id="discount"><?php echo number_format($intTotalDiscount,2,'.',''); ?></span></span></li>
                <li>GST<span class="pull-right">₹<span id="gst_charges"><?php echo number_format($intTotalGst,2,'.',''); ?></span></span></li>
                <hr>
                <li><strong>Total Amount</strong><span class="pull-right">
                    <strong>₹<span id="total_charges"><?php echo number_format($intTotalAmount,2,'.',''); ?></span></strong></span></li>
                </ul>
            </div>
            <?php if(isset($rowAdminInfo['user_id']) && $rowAdminInfo['user_id']>0)
               { ?>
            <a href="<?php echo SITE_URL?>checkout" class="place-order">Place Order</a>
            <?php }else{ ?>
            <a href="javascript:void(0);"   data-toggle="modal" data-target="#login" class="place-order">Place Order</a>
            <?php } ?>
         </div>
      </div>
   </div>
</section>
<?php }else{ ?>
<section>
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="no-img text-center">
               <img src="<?php echo SITE_URL;?>assets/img/no-cart.png" class="img-300 mb-20">
               <h5>Cart is empty?</h5>
               <p>Looks like you have no item in your shopping cart<br>Click here to continue shopping</p>
            </div>
         </div>
      </div>
   </div>
</section>
<?php } ?>
<script>
   function removefromcart(puid,object,product_id){
       var datastring ='puid='+puid+'&product_id='+product_id;
       object.parents('.csl-box-list').remove();
       $.post('<?php echo SITE_URL; ?>cart/removefromcart',datastring,function(resonse){
          var jt = JSON.parse(resonse); 
         
          if(jt.message=='ok')
          {
             location.reload();
             /* $('.cartcountforupdate').html(jt.cartcount+' Item(s)');
              if(jt.cartcount == 0){
                  $('.cart-section').before('<div class="row"><div class="col-lg-12"><div class="no-img text-center"><img src="https://codexosoftware.live/unnatiplus/assets/img/no-cart.png" class="img-300 mb-20"><h5>Cart is empty?</h5><p>Looks like you have no item in your shopping cart<br>Click here to continue shopping</p></div></div></div>');
                  $('.cart-section').remove();
              }*/
              
          }else{
              alert('some error occured');
          }
       });
   }
</script>