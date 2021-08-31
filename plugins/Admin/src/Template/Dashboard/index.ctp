<div class="content">
    <div class="row">
        <a href="<?php echo SITE_URL;?>admin/user">
        <div class="col-sm-6 col-md-3">
        <div class="panel panel-body bg-blue-400 has-bg-image">
        <div class="media no-margin">
        <div class="media-body">
        <h3 class="no-margin"><?php echo $userCountInfo;?></h3>
        <span class="text-uppercase text-size-mini">Total Users</span>
        </div>
        <div class="media-right media-middle">
        <img src="<?php echo SITE_URL;?>admin/images/users.png" style="width: 52px;">
        </div>
        </div>
        </div>
        </div>
        </a>

  
        <a href="<?php echo SITE_URL;?>admin/seller">
        <div class="col-sm-6 col-md-3">
        <div class="panel panel-body bg-danger-400 has-bg-image">
        <div class="media no-margin">
        <div class="media-body">
        <h3 class="no-margin"><?php echo $sellerCountInfo;?></h3>
        <span class="text-uppercase text-size-mini">Total Seller</span>
        </div>
        <div class="media-right media-middle">
        <img src="<?php echo SITE_URL;?>admin/images/logo_icon_light.png" style="width: 52px;">
        </div>
        </div>
        </div>
        </div>
        </a>

        <a href="<?php echo SITE_URL;?>admin/product">
        <div class="col-sm-6 col-md-3">
        <div class="panel panel-body bg-success-400 has-bg-image">
        <div class="media no-margin">
        <div class="media-left media-middle">
        <i class="icon-pointer icon-3x opacity-75"></i>
        </div>
        <div class="media-body text-right">
        <h3 class="no-margin"><?php echo $productInfo->count();?></h3>
        <span class="text-uppercase text-size-mini">Total Products</span>
        </div>
        </div>
        </div>
        </div>
        </a>

        <a href="<?php echo SITE_URL;?>admin/order">
        <div class="col-sm-6 col-md-3">
        <div class="panel panel-body bg-indigo-400 has-bg-image">
        <div class="media no-margin">
        <div class="media-left media-middle">
        <i class="icon-pointer icon-3x opacity-75"></i>
        </div>
        <div class="media-body text-right">
        <h3 class="no-margin"><?php echo $ordercountInfo;?></h3>
        <span class="text-uppercase text-size-mini">Total Order</span>
        </div>
        </div>
        </div>
        </div>
        </a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Recent Orders<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
                </div>
                <div class="card">
    				<div class="table-responsive">
    					<table class="table text-nowrap">
    						<thead>
    							<tr>
    								<th>Customer Info</th>
    								<th>Amount</th>
    								<th>Date</th>
    								<th>View</th>
    							</tr>
    						</thead>
    						<tbody>
    						    <?php 
    						        if(!empty($orderInfo)) {
    						        foreach($orderInfo as $oinfo){
    						    ?>
    							<tr>
                                    <td>
                                        <div class="media-left media-middle" style="padding-right:10px;">
                                            <a href="#" class="btn bg-primary-400 rounded-round btn-icon btn-sm"> <span class="letter-icon"><?php echo strtoupper(substr($oinfo->sk_user->user_first_name, 0, 1)); ?></span> </a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a  target="new" href="#" class="text-default text-semibold"><?php echo $oinfo->sk_user->user_first_name.' '.$oinfo->sk_user->user_last_name; ?></a><div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> New order</div></div>
                                        </div>
                                    </td>
    								<td>
    									<h6 class="font-weight-semibold mb-0">₹<?php echo $oinfo->trans_amt; ?></h6>
    								</td>
    								<td>
    									<span class="text-muted font-size-sm"><?php echo date('d/m/Y',strtotime($oinfo->trans_datetime)); ?><br><?php echo date('H:i a',strtotime($oinfo->trans_datetime)); ?></span>
    								</td>
    								<td>
    									<a href="<?php echo SITE_URL; ?>admin/order/orderdetail/<?php echo $oinfo->trans_id; ?>" class="font-weight-semibold mb-0">View</a>
    								</td>
    							</tr>
    							
								<?php } } else {?>
								<tr>
									    <td colspan="8" class="text-center">No Recent Order Found</td>
								 </tr>
								<?php }?>
    						</tbody>
    					</table>
    				</div>
    			</div>
			</div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Recent Users<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
                </div>
                <div class="card">
    				<div class="table-responsive">
    					<table class="table text-nowrap">
    						<thead>
    							<tr>
    								<th>Name</th>
    								<th>Mobile/Email</th>
    								<th>View</th>
    							</tr>
    						</thead>
    						<tbody>
    						    <?php 
    						        if(!empty($userInfo)) {
    						        foreach($userInfo as $uinfo){
    						    ?>
    							<tr>
                                    <td>
                                        <div class="media-left media-middle" style="padding-right:10px;">
                                            <a href="#" class="btn bg-primary-400 rounded-round btn-icon btn-sm"> <span class="letter-icon"><?php echo strtoupper(substr($uinfo->user_first_name, 0, 1)); ?></span> </a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a  target="new" href="#" class="text-default text-semibold"><?php echo $uinfo->user_first_name.' '.$uinfo->user_last_name; ?></a><div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> New user</div></div>
                                        </div>
                                    </td>
    								<td>
    									<h6 class="font-weight-semibold mb-0"><?php echo $uinfo->user_mobile; ?><br>
    									<span class="text-muted font-size-sm"><?php echo $uinfo->user_email_id; ?></span></h6>
    								</td>
    							
    								<td>
    									<a href="<?php echo SITE_URL; ?>/admin/user/user-view/<?php echo $uinfo->user_id; ?>" class="font-weight-semibold mb-0">View</a>
    								</td>
    							</tr>
    							
								<?php } } else {?>
								<tr>
									    <td colspan="8" class="text-center">No Recent User Found</td>
								 </tr>
								<?php }?>
    						</tbody>
    					</table>
    				</div>
    			</div>
			</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Recent Sellers<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
                </div>
                <div class="card">
    				<div class="table-responsive">
    					<table class="table text-nowrap">
    						<thead>
    							<tr>
    								<th>Name</th>
    								<th>Mobile/Email</th>
    								<th>View</th>
    							</tr>
    						</thead>
    						<tbody>
    						    <?php 
    						        if(!empty($sellerInfo)) {
    						        foreach($sellerInfo as $sinfo){
    						    ?>
    							<tr>
                                    <td>
                                        <div class="media-left media-middle" style="padding-right:10px;">
                                            <a href="#" class="btn bg-primary-400 rounded-round btn-icon btn-sm"> <span class="letter-icon"><?php echo strtoupper(substr($sinfo->seller_fname, 0, 1)); ?></span> </a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a  target="new" href="#" class="text-default text-semibold"><?php echo $sinfo->seller_fname.' '.$sinfo->seller_lname; ?></a><div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> New seller</div></div>
                                        </div>
                                    </td>
    								<td>
    									<h6 class="font-weight-semibold mb-0"><?php echo $sinfo->seller_phone; ?><br>
    									<span class="text-muted font-size-sm"><?php echo $sinfo->seller_email; ?></span></h6>
    								</td>
    								<td>
    									<a href="<?php echo SITE_URL; ?>admin/seller" class="font-weight-semibold mb-0">View</a>
    								</td>
    							</tr>
    							
								<?php } } else {?>
								<tr>
									    <td colspan="8" class="text-center">No Recent Seller Found</td>
								 </tr>
								<?php }?>
    						</tbody>
    					</table>
    				</div>
    			</div>
			</div>
        </div>
    </div>
</div>