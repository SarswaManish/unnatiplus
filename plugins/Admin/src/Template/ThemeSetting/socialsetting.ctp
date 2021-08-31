<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');

 $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
 $rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=13 ')->fetch('assoc');
 
 

if(!isset($rowSelectPermission['pd_id']))
{
    
  header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
  
}
?>
<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Social Setting</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/admin/"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Social Setting</li>
						</ul>

					</div>
				</div>

			<div class="content">
			       <?= $this->Flash->render() ?>
<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'edit','enctype'=>'multipart/form-data','class'=>'form-horizontal','url'=>'/admin/theme-setting/themeUpdateProcessRequest']); ?>
<!-- Both borders -->
<div class="panel panel-default">
<div class="panel-heading">
<h5 class="panel-title">Social Settings<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
<div class="heading-elements">
       <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
<button type="submit" name="submit" class="btn btn-success"> Save</button>
<?php } ?>
</div>

<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
<div class="panel-body" >

<div class="form-group">
<label class="col-lg-2 control-label">Facebook Link :</label>
<div class="col-lg-10">
<input type="text" name="theme_facebook" class="form-control" value="<?php echo $rowThemeInfo['theme_facebook']; ?>">

<input type="hidden" name="theme_reffer" class="form-control" value="<?php echo $rowThemeInfo['theme_facebook']; ?>">

</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Twitter Link :</label>
<div class="col-lg-10">
<input type="text" name="theme_twitter" class="form-control" value="<?php echo $rowThemeInfo['theme_twitter']; ?>">
</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Google Plus Link :</label>
<div class="col-lg-10">
<input type="text" name="theme_ggogle_plus" class="form-control" value="<?php echo $rowThemeInfo['theme_ggogle_plus']; ?>">
</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Pinterest Link :</label>
<div class="col-lg-10">
<input type="text" name="theme_pinterest"  class="form-control" value="<?php echo $rowThemeInfo['theme_pinterest']; ?>">
</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Youtube Link :</label>
<div class="col-lg-10">
<input type="text" name="theme_youtube"   class="form-control" value="<?php echo $rowThemeInfo['theme_youtube']; ?>">
</div>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">Linkedin Link :</label>
<div class="col-lg-10">
<input type="text" name="theme_linkdin" class="form-control" value="<?php echo $rowThemeInfo['theme_linkdin']; ?>">
</div>
</div>
</div>
</div>
<!-- /both borders -->
<?= $this->Form->end() ?>
