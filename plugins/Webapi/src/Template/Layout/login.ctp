<?php use Cake\Datasource\ConnectionManager;

$connection = ConnectionManager::get('default');
$rowThemeSetting = $connection->execute('SELECT * FROM  theme_setting ')->fetch('assoc');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE; ?></title>
     <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
      
 <?php  echo $this->Html->css('/admin/css/bootstrap.css'); ?>
 <?php  echo $this->Html->css('/admin/css/core.css'); ?>
 <?php  echo $this->Html->css('/admin/css/components.css'); ?>
 <?php  echo $this->Html->css('/admin/css/colors.css'); ?>
 <?php  echo $this->Html->css('/admin/css/icons/icomoon/styles.css'); ?>

<?php echo $this->Html->script('/admin/js/plugins/loaders/pace.min.js', array('inline' => false)); ?>
<?php echo $this->Html->script('/admin/js/core/libraries/jquery.min.js', array('inline' => false)); ?>
<?php echo $this->Html->script('/admin/js/core/libraries/bootstrap.min.js'); ?>
<?php echo $this->Html->script('/admin/js/plugins/loaders/blockui.min.js'); ?>
<?php echo $this->Html->script('/admin/js/core/app.js'); ?>

       <link href="<?php echo SITE_UPLOAD_URL.SITE_THEME_IMAGE_PATH.$rowThemeSetting['theme_favicon']; ?>" type="image/x-icon" rel="icon"/>


</head>



<body class="login-container">
  <!-- Main navbar -->
  <div class="navbar navbar-inverse">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo SITE_URL; ?>admin">
	<img src="<?php echo SITE_UPLOAD_URL.SITE_THEME_IMAGE_PATH.$rowThemeSetting['theme_logo']; ?>" alt="">
      </a>


      <ul class="nav navbar-nav pull-right visible-xs-block">
        <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
      </ul>
    </div>


        <?= $this->fetch('content') ?>

</html>
