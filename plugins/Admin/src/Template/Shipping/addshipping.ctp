
<style>
.mr-3
{
width: 60px;
float: left;
margin-right: 20px;
}
</style>
<div class="page-container">
<div class="page-content">
<div class="content-wrapper">
<!-- Page header -->
<div class="page-header page-header-default">
<div class="page-header-content">
<div class="page-title">
<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Shipping Rates</span> - <?php 	echo " Add Shipping Rates";	?></h4>
</div>
</div>
<div class="breadcrumb-line">
<ul class="breadcrumb">
<li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
<li><a href="#">Shipping Rates</a></li>
<li class="active"><?php echo "Add Shipping Rates";?></li>
</ul>
</div>
</div>
<!-- /page header -->
<!-- Content area -->	
<div class="content">
<div class="row">
<?php echo  $this->Form->create('shipping', ['type' => 'POST','id'=>'edit','enctype'=>'multipart/form-data','class'=>'form-horizontal','url'=>'/admin/shipping/shippingProcessRequest']); ?>
<!-- Both borders -->		
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title"><?php echo "Add Shipping Rates";	?></h5>
<div class="heading-elements">
<a href="<?php echo SITE_URL;?>admin/shipping" class="btn btn-default"><i class="icon-chevron-left"></i> Back</a>
<button type="submit" name="submit"class="btn btn-success"> Save</button>
</div>
<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
<div class="panel-body" >
<div class="tabbable">
<div class="tab-content">
<div class="tab-pane fade active in" id="tab1-1">
<div class="form-body">	
<div class="form-group">
<label class="col-lg-2 control-label"> State Name:</label>
<div class="col-lg-10">
<select class="form-control" name="shipping_state">
<option>Select State</option>
<?php foreach($resStateList as $rowStateList)  
{ 
$strSelect = (isset($rowShippingInfo['shipping_state']) && $rowShippingInfo['shipping_state']==$rowStateList->state_id)?'selected="selected"':'';
?>
<option  <?php echo $strSelect; ?> value="<?php echo $rowStateList->state_id; ?>"><?php echo $rowStateList->state_name; ?></option>
<?php } ?>
</select>
</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label"> Delivery Charge:</label>
<div class="col-lg-10">
<input type="text" class="form-control" name="shipping_rate"  value="<?php echo isset($rowShippingInfo['shipping_rate'])?$rowShippingInfo['shipping_rate']:'0'; ?>">
<input type="hidden" class="form-control" name="shipping_id" value="<?php echo isset($rowShippingInfo['shipping_id'])?$rowShippingInfo['shipping_id']:'0'; ?>">

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?= $this->Form->end() ?>
</div>