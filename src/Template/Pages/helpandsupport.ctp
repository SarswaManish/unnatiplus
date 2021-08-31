<?php use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$strPage =  'https://codexosoftware.live/unnatiplus/help-and-support';
$sqlSelectMeta = 'SELECT * FROM sk_pages WHERE 1 AND page_url=\''.$strPage.'\'';  
$rowPageData =$conn->execute($sqlSelectMeta)->fetch('assoc');?>
 <?php if(!isset($strApp) || isset($strApp) && $strApp=='')
{ ?>
<div class="sub-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
    
<ul class="breadcrum">
<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
<li><a href="javascript:;">Help & Support</a></li>
</ul>

<h1>Help & Support</h1>
</div>
</div>
</div>
</div>
<?php } ?>

<section>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-lg-8">
<div class="my-pro-contetnt" style="min-height:auto">
<div class="my-pro-contetnt-body">
<div class="lr-box">
<?= $this->Flash->render() ?>
<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'user-form','url'=>'','enctype'=>'multipart/form-data']); ?>
<input type="hidden" class="form-control" name="user_id" value="">
<div class="row">
<div class="col-lg-6">
<div class="lr-form-box">
<label>First Name:<span style="color: red;">*</span></label>
<input type="text" class="form-control" required name="hs_fname" value="">
</div>
</div>
<div class="col-lg-6">
<div class="lr-form-box">
<label>Last Name:<span style="color: red;">*</span></label>
<input type="text" class="form-control" required name="hs_lname" value="">
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<div class="lr-form-box">
<label>Mobile No:<span style="color: red;">*</span></label>
<input type="text" class="form-control" required name="hs_mobile" minlength="10" maxlength="10" value="">
</div>
</div>
<div class="col-lg-6">
<div class="lr-form-box">
<label>Email:<span style="color: red;">*</span></label>
<input type="email" class="form-control" required name="hs_email" value="">
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<div class="lr-form-box">
<label>Message:</label>
<textarea name="hs_message" class="form-control"></textarea>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<div class="lr-form-box">
<button type="submit" class="btn btn-success">Submit</button>
</div>
</div>
</div>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>
</div>
</div>
</section>









