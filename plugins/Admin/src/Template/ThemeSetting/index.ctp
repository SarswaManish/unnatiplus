<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=12 ')->fetch('assoc');
 
 

if(!isset($rowSelectPermission['pd_id']))
{
    
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
  
}
?>
<style>
input[type=text] {
    width: 100%;
    
    position: absolute;
    top: 0;
     
    bottom: 0;
    height: 36px;
    margin-left: 20px;
    
    cursor: pointer;
    z-index: 10;
    }
</style>
<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Theme Setting</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/admin/"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Theme Setting</li>
						</ul>

					</div>
				</div>

			<div class="content">
			       <?= $this->Flash->render() ?>
<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'edit','enctype'=>'multipart/form-data','class'=>'form-horizontal','url'=>'/admin/theme-setting/themeUpdateProcessRequest']); ?>
<!-- Both borders -->
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Theme Settings<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
<div class="heading-elements">
          <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
<button type="submit" name="submit" class="btn btn-success"> Save</button>
<?php } ?>
</div>

<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
<div class="panel-body" >

<div class="form-group">
<label class="col-lg-2 control-label">Logo :</label>
<div class="col-lg-10">
<div class="media no-margin-top">
<div class="media-left">
    <?php if($rowThemeInfo->theme_logo!='')
    { ?>
<a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_THEME_IMAGE_PATH.$rowThemeInfo->theme_logo; ?>" style="width: 58px; height: 58px; border-radius: 2px;" id="blah1" alt=""></a>
<?php }else{ ?>
<a href="#"><img src="/admin/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" id="blah1" alt=""></a>

<?php } ?>
</div>
<div class="media-body">
<div class="uploader "><input class="file-styled" type="file" onchange="readURL1(this);" name="theme_logo_"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" name="theme_setting_logo">Choose File</span></div>
<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Favicon :</label>
<div class="col-lg-10">
<div class="media no-margin-top">
<div class="media-left">
    <?php if($rowThemeInfo->theme_favicon!='')
    { ?>
<a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_THEME_IMAGE_PATH.$rowThemeInfo->theme_favicon; ?>" style="width: 58px; height: 58px; border-radius: 2px;" id="blah1" alt=""></a>
<?php }else{ ?>
<a href="#"><img src="/admin/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" id="blah1" alt=""></a>

<?php } ?>
</div>
<div class="media-body">
<div class="uploader "><input class="file-styled" type="file" onchange="readURL(this);" name="theme_favicon_"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" name="theme_setting_favicon">Choose File</span></div>
<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
</div>
</div>
</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Contact :</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_contact"  class="form-control" value="<?php echo $rowThemeInfo->theme_contact;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>

<div class="form-group">
<label class="col-lg-2 control-label">Email :</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_email"  class="form-control" value="<?php echo $rowThemeInfo->theme_email;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Address :</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_address"  class="form-control" value="<?php echo $rowThemeInfo->theme_address;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>
</div>

<legend>Helpline Number</legend>
<div class="form-group">
<label class="col-lg-2 control-label">Return Helpline:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_return_number"  class="form-control" value="<?php echo $rowThemeInfo->theme_return_number;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>
<div class="form-group">
<label class="col-lg-2 control-label">Credit Helpline:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_credit_number"  class="form-control" value="<?php echo $rowThemeInfo->theme_credit_number;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>
<div class="form-group">
<label class="col-lg-2 control-label">Delivery Helpline:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_delivery_number"  class="form-control" value="<?php echo $rowThemeInfo->theme_delivery_number;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>
<div class="form-group">
<label class="col-lg-2 control-label">General Support:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_general_number"  class="form-control" value="<?php echo $rowThemeInfo->theme_general_number;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>

<legend>Whatsapp Helpline Number</legend>
<div class="form-group">
<label class="col-lg-2 control-label">Return Helpline:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_return_wnumber"  class="form-control" value="<?php echo $rowThemeInfo->theme_return_wnumber;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>
<div class="form-group">
<label class="col-lg-2 control-label">Credit Helpline:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_credit_wnumber"  class="form-control" value="<?php echo $rowThemeInfo->theme_credit_wnumber;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>
<div class="form-group">
<label class="col-lg-2 control-label">Delivery Helpline:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_delivery_wnumber"  class="form-control" value="<?php echo $rowThemeInfo->theme_delivery_wnumber;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>
<div class="form-group">
<label class="col-lg-2 control-label">General Support:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_general_wnumber"  class="form-control" value="<?php echo $rowThemeInfo->theme_general_wnumber;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>

<legend>Refferal Setting</legend>
<div class="form-group">
<label class="col-lg-2 control-label">Refferal Amount:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_referral_amount"  class="form-control" value="<?php echo $rowThemeInfo->theme_referral_amount;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>
<div class="form-group">
<label class="col-lg-2 control-label">Redeem Percent:</label>
<div class="col-lg-9">
<div class="media no-margin-top">
 
<div class="media-body">
     <input type="text" name="theme_redeem_percentage"  class="form-control" value="<?php echo $rowThemeInfo->theme_redeem_percentage;?>"> 

 </div>
</div>
</div>
<div class="col-lg-1"></div>

</div>

</div>
</div>
<!-- /both borders -->
<?= $this->Form->end() ?>
