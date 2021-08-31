<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');
/*
 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=1 ')->fetch('assoc');
if(!isset($rowSelectPermission['pd_id']) && $rowAdminInfo['admin_default']==0)
{
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
}*/
$rowAdminInfo =  $this->request->getSession()->read('SELLER');
?>
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Products</h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>seller/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Products</li>
		</ul>
    </div>
</div>
<!-- /page header -->
<!-- Content area -->
<div class="content">
    <?php  echo $this->Flash->render(); ?>
    <!-- Dashboard content -->
	<div class="row">
		<div class="col-lg-12">
        <!-- Marketing campaigns -->
	    <div class="panel panel-default">
			<div class="panel-heading">
				<h5 class="panel-title">Products List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
				<div class="heading-elements">
					<a href="<?php echo SITE_URL; ?>seller/product/addproduct" class="btn btn-primary"><i class="icon-file-plus position-left"></i> Add New</a>
            	</div>
			</div>
			<div class="panel-body" style="background:#f5f5f5;">
				<div class="row">
					<div class="col-md-6">
						<div class="st-list">
    						<ul>
        						<li class="<?php if($strStatus==''){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>seller/product/index/all">All</a> <span class="count">(<?php echo $resProductListForCount->count(); ?>)</span></li>
        						<li class="<?php if($strStatus=='active'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>seller/product/index/active">Active </a> <span class="count">(<?php echo $resProductListForCount->where(['product_status'=>1])->count(); ?>)</span></li>
        						<li class="<?php if($strStatus=='inactive'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>seller/product/index/inactive">Inactive </a> <span class="count">(<?php echo $resProductListForCount2->where(['product_status'=>0])->count(); ?>)</span></li>
        						<li class="<?php if($strStatus=='trash'){ ?>active<?php } ?>"><a href="<?php echo SITE_URL; ?>seller/product/index/trash">Trash</a> <span class="count">(<?php echo $resProductListForCount3->where(['product_status'=>2])->count(); ?>)</span></li>
    						</ul>
						</div>
					</div>
    				<div class="col-md-6"> </div>
    		    </div>
	        </div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="text-align:center;width:3%;"><input type="checkbox"></th>
						<th style="width:8%;">Unique Id</th>
						<th style="width:1%;">SKU</th>
						<th style="width:31%;">Products</th>
						<th>Categories</th>
						<th>Price</th>
						<th>QTY</th>
						<th style="width:20%;">Publish Date</th>
						<th class="text-center"><i class="icon-arrow-down12"></i></th>
					</tr>
				</thead>
			    <tbody>
        			<?php 
        			if(count($resProductList)>0)
        			{
        			foreach($resProductList as $rowProductListInfo)
        			{ 
        			if($rowProductListInfo->product_category!='')
        			{
        			    $srtLoad ='SELECT GROUP_CONCAT(category_name  SEPARATOR \', \') as totalname FROM sk_category WHERE 1 AND category_id IN('.$rowProductListInfo->product_category.') ';
        			    $rowCategoryNames =$conn->execute($srtLoad)->fetch('assoc');
        			} ?>
        			<tr>
        				<td style="text-align:center"><input type="checkbox"></td>
        				<td><?php echo $rowProductListInfo->product_unique_id;?></td>
        				<td><?php echo $rowProductListInfo->product_sku; ?></td>
        				<td>
        				    <div class="media-left media-middle" style="padding-right:10px;">
        					    <?php if(isset($rowProductListInfo->product_featured_image) && $rowProductListInfo->product_featured_image!='')	
        	                    {?>
        	                        <a target="new" href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowProductListInfo->product_slug; ?>">
        	                            <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductListInfo->product_featured_image; ?>" class="img-circle img-xs" alt="">
                                    </a>
                                <?php }else{ ?>
        	                        <a target="new" href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowProductListInfo->product_slug; ?>">
        	                            <img src="/seller/images/placeholder.jpg" class="img-circle img-xs" alt="">
                                    </a>
        	                    <?php } ?>
        	                </div>
        			        <div class="media-left">
                                <div class=""><a  target="new" href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowProductListInfo->product_slug; ?>" class="text-default text-semibold"><?php echo $rowProductListInfo->product_name; ?></a></div>
                                <div class="text-muted text-size-small">
                                    <?php 	if($rowProductListInfo->product_status==1)
                                    { ?>
                                        <a href="<?php echo SITE_URL; ?>seller/product/status/<?php echo $rowProductListInfo->product_id; ?>"><span class="status-mark border-success"></span> Active </a>
                                    <?php }else if($rowProductListInfo->product_status==0) { ?>
                                        <a href="<?php echo SITE_URL; ?>seller/product/status/<?php echo $rowProductListInfo->product_id; ?>">	<span class="status-mark border-danger"></span> Inactive </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo SITE_URL; ?>seller/product/deletepermanently/<?php echo $rowProductListInfo->product_id; ?>" style="margin-left:4px;">	<span class="status-mark border-danger"></span> Delete Permanantly </a>
                                        <a href="<?php echo SITE_URL; ?>seller/product/status/<?php echo $rowProductListInfo->product_id; ?>" style="margin-left:4px;">	<span class="status-mark border-success"></span> Restore </a>
                                    <?php } ?>
                                </div>
        					</div>
        				</td>
        				<td><?php echo $rowCategoryNames['totalname']; ?></td>
        				<td><span class="text-success-600">₹<?php echo $rowProductListInfo->product_net_price; ?></span></td>
        				<td><input type="text" onkeyup="setProductQty($(this))" product_id="<?php echo $rowProductListInfo->product_id; ?>"  style="width:50px;"  value="<?php echo $rowProductListInfo->product_qty_in_stock; ?>"><i class="icon-spinner2 spinner position-left hide"></i></td>
        				<td><?php echo date('d/m/Y h:i:s',strtotime($rowProductListInfo->product_created_date)); ?></td>
        				<td class="text-center">
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="<?php echo SITE_URL; ?>seller/product/addproduct/<?php echo $rowProductListInfo->product_id; ?>" style="padding:3px 15px">Edit</a></li>
                                        <li><a href="<?php echo SITE_URL; ?>seller/product/addproduct/<?php echo $rowProductListInfo->product_id; ?>/copy" style="padding:3px 15px">Copy Listing</a></li>
                                        <li><a href="<?php echo SITE_URL; ?>seller/product/trash/<?php echo $rowProductListInfo->product_id; ?>" onclick="return confirm('Are you want to sure?');" style="padding:3px 15px">Trash</a></li>
                                        <li><a href="<?php echo SITE_URL; ?>seller/product/deletepermanently/<?php echo $rowProductListInfo->product_id; ?>" onclick="return confirm('Are you want to sure?');" style="padding:3px 15px">Delete Permanently</a></li>	
                                    </ul>
                                </li>
                            </ul>
        			    </td>
        			</tr>
        		    <?php }}else{ ?>
        			    <tr>
                            <td colspan="8" class="text-center">No Result Found</td>
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
	<!-- /page container -->
	<script>var _csrfToken=<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>


