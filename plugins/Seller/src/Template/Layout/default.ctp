<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($strPageTitle)?$strPageTitle.' - ':''; ?><?php echo SITE_TITLE; ?> </title>
   
   	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
<?php  echo $this->Html->css('Admin.bootstrap'); ?>
<?php  echo $this->Html->css('Admin.core'); ?>
<?php  echo $this->Html->css('Admin.components'); ?>
<?php  echo $this->Html->css('Admin.colors'); ?>
<?php  echo $this->Html->css('Admin.icons/icomoon/styles'); ?>
<?php echo $this->Html->script('Admin./js/plugins/loaders/pace.min'); ?>
<?php echo $this->Html->script('Admin./js/core/libraries/jquery.min'); ?>
<?php echo $this->Html->script('Admin./js/core/libraries/bootstrap.min'); ?>
<?php echo $this->Html->script('Admin./js/plugins/loaders/blockui.min'); ?>
<script>var site_url='<?php echo $this->Url->build('/seller/'); ?>';</script>
</head>
<?= $this->fetch('content') ?>
<?php echo $this->Html->script('Admin./js/env'); ?>
</html>