<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Wishlist History</h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Wishlist History</li>
		</ul>
	</div>
</div>
<div class="content">
    <?= $this->Flash->render();  ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">Wishlist History</h5>
            <div class="heading-elements"> </div>
        </div>
        <div class="panel-body" style="background:#f5f5f5;">
            <div class="row">
                <?php echo  $this->Form->create('', ['url'=>'/admin/recentHistory/wishListbulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
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
<input type="checkbox" name="wish_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowWishlistInfo->wish_id);  ?>">
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
  <li><a href="<?php echo SITE_URL; ?>admin/recentHistory/deletewishlist/<?php echo $rowWishlistInfo->wish_id; ?>" style="padding:3px 15px" onclick="return confirm('Are you sure you want to delete?');">Delete</a></li>		
</ul>
</li>
</ul>
</td>
</tr>
<?php endforeach;
}else{ ?>
<tr><td colspan="5" class="text-center">No Result Found</td></tr>
<?php } ?>
</tbody>
</table>
<div class="datatable-footer" >
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
<?= $this->Form->end() ?>