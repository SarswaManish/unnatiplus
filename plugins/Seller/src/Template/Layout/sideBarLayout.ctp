<?php use Cake\View\Helper\SessionHelper; 
   use Cake\View\Helper\SecurityMaxHelper;
   use Cake\Datasource\ConnectionManager;
   $rowAdminInfo =  $this->request->getSession()->read('SELLER');
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo isset($strPageTitle)?$strPageTitle.' - ':''; ?><?php echo SITE_TITLE; ?></title>
      <!-- Global stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
      <?php  echo $this->Html->css('Admin.icons/icomoon/styles'); ?>
      <?php  echo $this->Html->css('Admin.bootstrap'); ?>
      <?php  echo $this->Html->css('Admin.core'); ?>
      <?php  echo $this->Html->css('Admin.components'); ?>
      <?php  echo $this->Html->css('Admin.colors'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/loaders/pace.min'); ?>
      <?php echo $this->Html->script('Admin./js/core/libraries/jquery.min'); ?>
      <?php echo $this->Html->script('Admin./js/core/libraries/bootstrap.min'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/loaders/blockui.min'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/visualization/d3/d3.min'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/visualization/d3/d3_tooltip'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/forms/styling/switchery.min');?>
      <?php echo $this->Html->script('Admin./js/plugins/forms/styling/switch.min');?>
      <?php echo $this->Html->script('Admin./js/plugins/forms/styling/uniform.min');?>
      <?php echo $this->Html->script('Admin./js/plugins/forms/selects/bootstrap_multiselect'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/ui/moment/moment.min'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/pickers/daterangepicker'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/editors/summernote/summernote.min'); ?>
      <?php echo $this->Html->script('Admin./js/pages/editor_summernote'); ?>
      <?php echo $this->Html->script('Admin./js/plugins/loaders/progressbar.min'); ?>
      <?php echo $this->Html->script('Admin./js/core/app'); ?>
      <style>
         .dash {
         background: #333 none repeat scroll 0 0;
         float: left;
         height: 2px;
         margin-right: 5px;
         margin-top: 10px;
         width: 15px;
         }
      </style>
      <script>var base_url='<?php echo SITE_URL; ?>';</script>
      <?php   ?>
   </head>
   <body>
      <!-- Main navbar -->
      <div class="navbar navbar-inverse">
         <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo SITE_URL;?>admin">
               Unnati+<!--<img src="<?php echo SITE_URL; ?>img/logo.png" alt="">-->
            </a>
            <ul class="nav navbar-nav visible-xs-block">
               <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
               <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
         </div>
         <div class="navbar-collapse collapse" id="navbar-mobile">
            <p class="navbar-text"><span class="label bg-success">Online</span></p>
            <ul class="nav navbar-nav navbar-right">
               <li class="dropdown dropdown-user">
                  <a class="dropdown-toggle" data-toggle="dropdown">
                  <img src="/admin/images/placeholder.jpg" alt="">
                  <span><?php echo $rowAdminInfo->seller_fname.' '.$rowAdminInfo->seller_lname; ?></span>
                  <i class="caret"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right">
                     <li><a href="<?php echo SITE_URL; ?>seller/myprofile"><i class="icon-user-plus"></i> My profile</a></li>
                     <li><a href="<?php echo SITE_URL; ?>seller/dashboard/logout"><i class="icon-switch2"></i> Logout</a></li>
                  </ul>
               </li>
            </ul>
         </div>
      </div>
      <!-- /main navbar -->
      <!-- Page container -->
      <div class="page-container">
         <!-- Page content -->
         <div class="page-content">
            <!-- Main sidebar -->
            <div class="sidebar sidebar-main">
               <div class="sidebar-content">
                  <div class="sidebar-category sidebar-category-visible">
                     <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">
                           <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
                           <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Dashboard | Ecommerce') { ?> active <?php } ?>">
                              <a href="<?php echo $this->Url->build('/seller/dashboard', true); ?>"><i class="icon-home4"></i> <span>Dashboard</span></a>
                           </li>
                           <?php if($rowAdminInfo->seller_type == 0){ ?>
                           <li>
                              <a href="#"><i class="icon-cart2"></i> <span>Products</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Product') { ?> active <?php } ?>"><a href="<?php echo SITE_URL;?>seller/product">Manage Products</a></li>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='AddProduct') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/seller/product/addproduct', true); ?>">Add New</a></li>
                              </ul>
                           </li>
                           <li>
                              <a href="#"><i class="icon-clipboard3"></i> <span>Orders</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Order' || isset($strPageTitle) && $strPageTitle=='Order Detail') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/seller/order', true); ?>">Manage Orders</a></li>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Cancel Order') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/seller/order/cancelorderlist', true); ?>">Cancellations</a></li>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Rejected Order') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/seller/order/rejectorderlist', true); ?>">Rejected Order</a></li>
                              </ul>
                           </li>
                           <?php }else{ ?>
                            <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Users | Ecommerce') { ?> active <?php } ?>">
                              <a href="<?php echo $this->Url->build('/seller/user', true); ?>"><i class="icon-people"></i> <span>Users</span></a>
                            </li>
                           <?php } ?>
                        </ul>
                     </div>
                  </div>
                  <!-- /main navigation -->
               </div>
            </div>
            <!-- /main sidebar -->
            <!-- Main content -->
            <div class="content-wrapper">
               <?= $this->fetch('content') ?>
               <div class="content">
                  <!-- Footer -->
                  <div class="footer text-muted">
                     &copy; 2019. <a href="#">Unnati+</a> by <a href="http://codexosoftware.com/" target="_blank">Unnati+@.com Pvt. Ltd.</a>
                  </div>
                  <!-- /footer -->
               </div>
               <!-- /content area -->
            </div>
         </div>
         <!-- /page content -->
      </div>
      <!-- /page container -->
      <?php echo $this->Html->script('Admin./js/plugins/forms/selects/select2.min.js'); ?>
      <?php echo $this->Html->script('Admin./js/pages/form_select2'); ?>	
      <?php echo $this->Html->script('Admin./js/product_env'); ?>
      <?php echo $this->Html->script('Admin./js/category_env'); ?>
      <?php echo $this->Html->script('Admin./js/tag_env'); ?>
      <?php echo $this->Html->script('Admin./js/pages/form_checkboxes_radios'); ?>
      <script>
         $('#selectAll').click(function(){
         if($(this).is(':checked'))
         {
         $('.clsSelectSingle').prop('checked',true);
         }else{
         $('.clsSelectSingle').prop('checked',false);
         }
         
         });
         
         $('#bulkaction-button').click(function(){
         
         if($('.clsSelectSingle:checked').length == 0)
         {
         alert('Please select atleast one service.');
         return false;
         }else if($('#bulkactionSelect').val() == 0)
         {
         alert('Please select action.');
         return false;
         }else{
         var statusConfirm =confirm('Are you want to perform bulk action?');
         if(statusConfirm)
         {
         $('#bulkaction-button').parents('form').submit();
         return true;
         }
         
         
         }
         
         });
      </script>
   </body>
</html>