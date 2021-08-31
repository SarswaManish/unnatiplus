<?php  use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$rowUserInfo =  $this->request->getSession()->read('USER');
?>
<section>
    <div class="container-fluid">
        <div class="prod-list-section">
            <?= $this->element('myaccount');?>
            <div class="pls-right">
                <div class="my-pro-contetnt">
                    <div class="my-pro-contetnt-body">
                        <ul class="breadcrum mb-10">
                            <li><a href="#"><i class="fa fa-home"></i></a></li>
                            <li><a href="#">My Account</a></li>
                            <li><a href="javascript:;">Orders</a></li>
                        </ul>
                        <div class="my-pro-contetnt-title">All Orders</div>
                            <?php foreach($resTransactionList as $rowTransactionList)
                            { 
 
                                $rowSubTotalInfo =$conn->execute('SELECT SUM(trans_amt) as total FROM transactions WHERE 1  AND (trans_main_id='.$rowTransactionList->trans_id.' OR trans_id='.$rowTransactionList->trans_id.')')->fetch('assoc');
                                $resProductName =$conn->execute('SELECT GROUP_CONCAT(CONCAT(product_name,\' X \',trans_quantity) SEPARATOR \',\') as productname,product_is_return,product_return_days FROM transactions INNER JOIN sk_product ON product_id=trans_item_id WHERE 1  AND (trans_main_id='.$rowTransactionList->trans_id.' OR trans_id='.$rowTransactionList->trans_id.')')->fetch('assoc');            
                                //print_r($resProductName);
                                //die;
                            ?>
                            <div class="order-box">
                                <div class="ob-order-details">
                                    <div class="btd-id text-center">
                                        <span>ORDER ID</span>
                                        <div class="bid">
                                            <?php echo $rowTransactionList->trans_id; ?>
                                        </div>
                                    </div>
                                    <div class="btd-id text-center">
                                        <span>ORDER DATE &amp; TIME</span>
                                        <div class="bid" style="font-size: 13px;">
                                            <?php echo date('D d M Y ',strtotime($rowTransactionList->trans_datetime)); ?> @
                                            <?php echo date('h:i a',strtotime($rowTransactionList->trans_datetime)); ?>
                                        </div>
                                    </div>
                                    <?php if($rowTransactionList->trans_status==5){ ?>
                                        <div class="btd-id text-center">
                                            <span>DELIVERED ON</span>
                                            <div class="bid" style="font-size: 13px;">
                                                <?php echo date('D d M Y ',strtotime($rowTransactionList->trans_delivery_date)); ?> @
                                                <?php echo date('h:i a',strtotime($rowTransactionList->trans_delivery_date)); ?>
                                            </div>
                                        </div> 
                                                                                <span class="label-pi bg-warning text-white">Return Initiate</span>

                                    <?php }?>
                                    <?php if($rowTransactionList->trans_status==6){ ?>
                                        <div class="btd-id text-center">
                                            <span>DELIVERED ON</span>
                                            <div class="bid" style="font-size: 13px;">
                                                <?php echo date('D d M Y ',strtotime($rowTransactionList->trans_delivery_date)); ?> @
                                                <?php echo date('h:i a',strtotime($rowTransactionList->trans_delivery_date)); ?>
                                            </div>
                                        </div> 
                                        <span class="label-pi bg-warning text-white">Returned</span>
                                    <?php }?>
                                    <?php if($rowTransactionList->trans_status==4){ ?>
                                        <div class="btd-id text-center">
                                            <span>DELIVERED ON</span>
                                            <div class="bid" style="font-size: 13px;">
                                                <?php echo date('D d M Y ',strtotime($rowTransactionList->trans_delivery_date)); ?> @
                                                <?php echo date('h:i a',strtotime($rowTransactionList->trans_delivery_date)); ?>
                                            </div>
                                        </div>
                                        <?php 
                                        $date = date('Y-m-d', strtotime('+'.$resProductName['product_return_days'].' days'));
                                        if($resProductName['product_is_return']  == 1){
                                            if(strtotime($rowTransactionList->trans_delivery_date) < strtotime($date)){ ?>
                                            <div class="btd-id text-center">
                                                <a href="javascript:void(0)" style="color:#fff;padding:12px;background-color:#d60008" class="bg-danger" onclick="sendOtpAndVerify('<?php echo $rowTransactionList->trans_id ?>','<?php echo $rowUserInfo->user_id; ?>','return')">RETURN ORDER</a>
                                            </div>
                                        <?php } }?>
                                    <?php } ?>
                                    <?php if($rowTransactionList->trans_status==1){ ?>
                                        <div class="btd-id text-center">
                                            <a href="javascript:void(0)" style="color:#fff;padding:12px;background-color:#d60008" class="bg-danger" onclick="sendOtpAndVerify('<?php echo $rowTransactionList->trans_id ?>','<?php echo $rowUserInfo->user_id; ?>')">CANCEL ORDER</a>
                                        </div>
                                    <?php } ?>
                                    <?php if($rowTransactionList->trans_status==3){ ?>
                                    <div class="btd-id text-center">
                                        <span>TRACKING CODE</span>
                                        <div class="bid"><?php echo $rowTransactionList->trans_tracking_code; ?></div>
                                    </div>
                                    <?php } ?>
                                    <div class="text-center">
                                        <?php if($rowTransactionList->trans_status==3)
                                        { ?>
                                            <a target="_blank" href="<?php echo $rowTransactionList->trans_tacking_url; ?>" class="btn btn-primary">Track Order</a>
                                        <?php }else if($rowTransactionList->trans_status==2) { ?>
                                            <a href="#" class="btn btn-danger" >Canceled</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="ob-order-info">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="bti-img"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowTransactionList->sk_product->product_featured_image; ?>"></div>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="bti-content">
                                                <div class="order-title mb-10">
                                                    <?php echo $resProductName['productname']; ?>
                                                </div>
                                                <div class="order-details-list">
                                                    <ul>
                                                        <li><span>Delivery Address:</span> <span class="tst"><?php echo $rowTransactionList->trans_delivery_address; ?></span></li>
                                                        <li><span>Quantity: </span><span class="tst"><?php echo $rowTransactionList->trans_quantity; ?></span></li>
                                                    </ul>
                                                </div>
                                                <hr>
                                                <div class="title mb-10">Price Details</div>
                                                <div class="order-price-list">
                                                    <ul>
                                                        <li>Sub Total<span>₹<?php echo number_format($rowSubTotalInfo['total']-$rowTransactionList->trans_delivery_amount,2,'.',''); ?></span></li>
                                                        <li>Delivery Charge<span>₹<?php echo number_format($rowTransactionList->trans_delivery_amount,2,'.',''); ?></span>
                                                        </li>
                                                        <?php if($rowTransactionList->trans_discount_amount>0)
                                                        { ?>
                                                            <li>Discount<span>₹<?php echo number_format($rowTransactionList->trans_discount_amount,2,'.',''); ?></span></li>
                                                        <?php } ?>
                                                        <div class="dash-divider"></div>
                                                        <li>AMOUNT
                                                            <?php if($rowTransactionList->trans_payment_status==1){ ?>PAID
                                                            <?php }else{ ?>PENDING
                                                            <?php } ?> ( <?php echo $rowTransactionList->trans_method; ?>)
                                                            <span class="f16"><strong>₹<?php echo number_format(($rowSubTotalInfo['total']-$rowTransactionList->trans_discount_amount),2,'.',''); ?></strong></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<button id="trigger_model" data-toggle="modal" data-target="#verifyOtpplz" style="display:none;"></button>
<div class="modal" id="verifyOtpplz">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close-pop" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                 <form id="cancelotpform" method="post" action="javascript:void(0)">
                    <div id="" >
                        <div class="md-input alert alert-success" id="verifyotp-success" style="display:none"></div>
                        <div class="md-input alert alert-danger" id="verifyotp-error" style="display:none"></div>
                        <!--<div class="md-input alert alert-success" id="otp-success" style="display:none"></div>-->
                        <div class="lr-box text-center">
                            <h2>Please enter your OTP</h2>
                            <div class="alert alert-success"> One OTP is send to your registered mobile number ending with XXXXXX<?php echo substr($rowUserInfo->user_mobile,6,10); ?> </div>
                            <div class="lr-form-box">
                                <input type="text" required="" name="user_otp" id="cancel_user_otp" placeholder="Enter OTP" value="" required>
                            
                            </div>
                            <button type="button" >Verify<i id="verifyotp_spinner" class="icon-spinner2 spinner position-left " ></i></button>
                        </div>
                      <!--  <div id="hidetimer" style="text-align: center; display: none;">
                            <p style="text-align:center">RESEND OTP AFTER</p>
                            <p id="timerotp" class="otp-circle">-1</p>
                        </div>
                        <div id="showresendbutton" style="display: block; padding-top: 14px;">
                            <p style="text-align:center"><a href="javascript:void(0);" onclick="resendotp();">Resend OTP</a></p>
                        </div>-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function sendOtpAndVerify(orderId,userid,param='cancel'){
        if(param == ''){
            var for_what = "for cancel the order"; 
        }else{
            var for_what = "for return the order";  
        }
        var datastring = {'for_what':for_what};
        $.post(base_url+'home/sendOtp',datastring,function(response){
            var jsondata = JSON.parse(response);
            console.log(jsondata);
            if(jsondata.status=='1'){
                if(param == 'cancel'){
                    $('#cancelotpform').find('button').attr('onclick','verifyCancelOtp("'+orderId+'","'+userid+'")');
                }else{
                    $('#cancelotpform').find('button').attr('onclick','verifyOtpAndReturn("'+orderId+'","'+userid+'")'); 
                }
                $('#trigger_model').trigger('click');
                $('#verifyotp_spinner').hide();
            }else{
               console.log('something went wrong');
            }
        });
    }
    
    function verifyOtpAndReturn(orderId,userid){
        var datastring = {'user_otp':$('#cancel_user_otp').val(),'trans_id':orderId,'user_id':userid};
        $('#verifyotp_spinner').show();
        $.post(base_url+'order/initiatereturn',datastring,function(response){
            var jsondata = JSON.parse(response);
            if(jsondata.message=='ok'){
               location.reload();
            }else{
               console.log('something went wrong');
            }
        });
    }
    
    function verifyCancelOtp(orderId,userid){
        var datastring = {'user_otp':$('#cancel_user_otp').val(),'trans_id':orderId,'user_id':userid};
        $('#verifyotp_spinner').show();
        $.post(base_url+'order/cancelorder',datastring,function(response){
            var jsondata = JSON.parse(response);
            if(jsondata.message=='ok'){
               location.reload();
            }else{
               console.log('something went wrong');
            }
        });
    }
</script>