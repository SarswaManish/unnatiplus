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
                  <a href="<?php echo SITE_URL; ?>admin/order/export" class="btn btn-primary" style="margin-right:10px;"><i class="icon-database-export position-left"></i> Export</a>
                  <!--<a href="#" class="btn btn-primary"><i class="icon-file-plus position-left"></i> Export As CSV</a>-->
               </div>
            </div>
            <div class="panel-body" style="background:#f5f5f5;">
               <div class="row">
                  <div class="col-md-6">
                     <div class="st-list">
                        <ul>
                           <?php
                                $rowTotalCount =$resCountOrder->find('all',['fields'=>['total'=>'count(*)']])->where(' 1 AND trans_main_id=0 AND trans_status!=2 AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\') ')->first();
                                $rowConfirmTotalCount =$resCountOrder->find('all',['fields'=>['total'=>'count(*)'],'conditions'=>[' 1 AND trans_main_id=0 AND trans_status=1 ']])->first();
                                $rowDeliveredTotalCount =$resCountOrder->find('all',['fields'=>['total'=>'count(*)'],'conditions'=>[' 1 AND trans_main_id=0 AND trans_status=4 ']])->first();
                                $rowDispatchedTotalCount =$resCountOrder->find('all',['fields'=>['total'=>'count(*)']])->where(' 1 AND trans_main_id=0 AND trans_status=3 ')->first();
                                $rowPendingTotalCount =$resCountOrder->find('all',['fields'=>['total'=>'count(*)'],'conditions'=>[' 1 AND trans_main_id=0 AND trans_status!=2 AND trans_status=0 AND ( trans_payment_status=1 OR trans_method=\'Cash on Delivery\') ']])->first();
                              ?>
                            <li class="<?php if($strType=='all'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>admin/order">All</a> <span class="count">(<?php echo  $rowTotalCount->total; ?>)</span></li>
                            <li class="<?php if($strType=='confirm'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>admin/order/index/confirm">Confirm </a> <span class="count">(<?php echo  $rowConfirmTotalCount->total; ?>)</span></li>
                            <li class="<?php if($strType=='dispatched'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>admin/order/index/dispatched">Dispatched </a> <span class="count">(<?php echo  $rowDispatchedTotalCount->total; ?>)</span></li>
                            <li class="<?php if($strType=='pending'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>admin/order/index/pending">Pending </a> <span class="count">(<?php echo  $rowPendingTotalCount->total; ?>)</span></li>
                            <li class="<?php if($strType=='delivered'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>admin/order/index/delivered">Delivered </a> <span class="count">(<?php echo  $rowDeliveredTotalCount->total; ?>)</span></li>
                        </ul>
                     </div>
                  </div>
                  <?php echo  $this->Form->create('', ['url'=>'/admin/order/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
                  <div class="col-md-2"></div>
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
                     <th style="text-align:center;width:3%;"><input type="checkbox" id="selectAll"></th>
                     <th style="width:5%;">ID</th>
                     <th style="width:10%;">Order ID</th>
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
                     if(count($resTransList)>0){
                     foreach($resTransList as $rowTransList){
                        $rowUserInfo =$resUserInfo->find('all')->where(['user_id'=>$rowTransList->trans_user_id])->first();
                        $rowProductInfo = $resProductInfo->find('all')->where(['product_id'=>$rowTransList->trans_item_id])->first();
                        $rowSubTotalInfo =$conn->execute('SELECT SUM(trans_amt) as total FROM transactions WHERE 1  AND (trans_main_id='.$rowTransList->trans_id.' OR trans_id='.$rowTransList->trans_id.')')->fetch('assoc');
                        $resProductName =$conn->execute('SELECT GROUP_CONCAT(CONCAT(CONCAT(product_name,\' X \',trans_quantity),\' size \',size_name) SEPARATOR \', \')  as productname FROM transactions INNER JOIN sk_product ON product_id=trans_item_id LEFT JOIN sk_size ON sk_size.size_id = transactions.trans_size WHERE 1  AND (trans_main_id='.$rowTransList->trans_id.' OR trans_id='.$rowTransList->trans_id.')')->fetch('assoc');
                     ?>
                  <tr>
                     <td style="text-align:center"><input type="checkbox" name="trans_user_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowTransList->trans_user_id);  ?>"></td>
                     <td>
                        <a href="<?php echo $this->Url->build('/admin/order/orderdetail/'.$rowTransList->trans_id, true); ?>" class="text-default text-semibold" style="color:#0073aa !important;"> #<?php echo $rowTransList->trans_id; ?></a><br>
                     </td>
                     <td><?php echo $rowTransList->trans_order_number?></td>
                     <td>
                        <a href="javascript:;" class="text-default text-semibold" style="color:#0073aa !important;">
                            <?php 
                            if(isset($rowUserInfo->user_first_name) &&  $rowUserInfo->user_first_name!=""){
                                echo $rowUserInfo->user_first_name." ";
                            }
                            if(isset($rowUserInfo->user_last_name) && $rowUserInfo->user_last_name!=""){
                                echo $rowUserInfo->user_last_name;
                            }?>
                        </a>
                        <br>
                        <?php if(isset($rowUserInfo->user_email_id) && $rowUserInfo->user_email_id!=''){ ?> <?php echo $rowUserInfo->user_email_id; ?> <?php } ?><br>
                        <?php if(isset($rowUserInfo->user_mobile_number) && $rowUserInfo->user_mobile_number!=''){ ?> <?php echo $rowUserInfo->user_mobile_number; ?> <?php } ?>
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
                        <?php if($rowTransList->trans_status!=4 && $rowTransList->trans_status!=2){ ?>
                        <?php if($rowTransList->trans_status!=5 && $rowTransList->trans_status!=6){  ?>
                        <div class="btn-group btn-group-velocity ">
                           <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true" >
                           <?php 
                                if($rowTransList->trans_status==1){ 
                                    echo 'Confirmed';
                                }elseif($rowTransList->trans_status==2){ 
                                     echo 'Cancel';
                                }elseif($rowTransList->trans_status==3){ 
                                     echo 'Dispatched';
                                }elseif($rowTransList->trans_status==4){ 
                                     echo 'Delivered';
                                }elseif($rowTransList->trans_status==5){ 
                                     echo 'Return';
                                }elseif($rowTransList->trans_status==7){ 
                                     echo 'Intransit';
                                }
                            ?>
                            <span class="caret"></span></button>
                           <ul class="dropdown-menu" >
                            <li>
                                <a <?php if($rowTransList->trans_status!=3 && $rowTransList->trans_status!=4){ ?>  href="<?php echo SITE_URL; ?>admin/order/cancelorder/<?php echo $rowTransList->trans_id; ?>" <?php } ?>>
                                <i class="icon-cross"></i>Cancel Order 
                                </a>
                            </li>
                              <li><a href="javascript:void(0);" <?php if($rowTransList->trans_status!=3  &&  $rowTransList->trans_status!=4){ ?>   data-toggle="modal" data-target="#modal_theme_primary" onclick="setTransid('<?php echo $rowTransList->trans_id;; ?>')" <?php } ?>><i class="icon-screen-full"></i> Order Dispatched</a></li>
                              <li><a href="<?php echo SITE_URL; ?>admin/order/deliverorder/<?php echo $rowTransList->trans_id; ?>"><i class="icon-mail5"></i> Order Delivered</a></li>
                              <li><a href="<?php echo SITE_URL; ?>admin/order/intransitorder/<?php echo $rowTransList->trans_id; ?>"><i class="icon-mail5"></i> Intransit Order</a></li>
                           </ul>
                        </div>
                        <?php }else{
                            if($rowTransList->trans_status==5){
                                echo '<a href="'.SITE_URL.'admin/order/returnorder/'.$rowTransList->trans_id.'" class="btn btn-danger" >Return request</a>';
                            }else{
                                echo '<span class="label bg-danger">Returned</span>';
                            }
                        }?>
                        <?php }else{
                            ?>
                            <span class="label bg-success">Delivered</span><br>
                        <?php echo $rowTransList->trans_delivery_date; ?>
                        <?php } ?>
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
<!--                                 <li><a target="new" href="<?php echo SITE_URL; ?>pdf/<?php echo $rowTransList->invoice_pdf_file; ?>" style="padding:3px 15px">Print Invoice</a></li>
-->                                 <?php }else{ ?>
<!--                                 <li><a target="new" href="<?php echo SITE_URL; ?>invoice/?trans_id=<?php echo $rowTransList->trans_id; ?>" style="padding:3px 15px">Print Invoice</a></li>
-->                                 <?php } ?>
                               </ul>
                           </li>
                        </ul>
                     </td>
                  </tr>
                  <?php }
                     } else{ ?>
                  <tr>
                     <td colspan="10" style="text-align:center">No Result Found</td>
                  </tr>
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
<?= $this->Form->end() ?>
<div id="modal_theme_primary" class="modal fade in" tabindex="-1" style="">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h6 class="modal-title">Tracking Detail</h6>
         </div>
         <?php echo  $this->Form->create('transaction', ['type' => 'POST','id'=>'trans_ship','class'=>'form-horizontal']); ?>
         <div class="modal-body">
            <h6 class="text-semibold">Tracking Url From Shipping Agency</h6>
            <p><input type="text" class="form-control" name="trans_tacking_url"></p>
            <input type="hidden" class="form-control" name="trans_id_data" id="trans_id_data">
            <h6 class="text-semibold">Tracking Code</h6>
            <p><input type="text" class="form-control" name="trans_tracking_code"></p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
         </div>
         </form>
      </div>
   </div>
</div>
<script>
   function  setTransid(intTransid)
   {
       $('#trans_id_data').val(intTransid);
       
   }
</script>

