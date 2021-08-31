<?php use Cake\View\Helper\SessionHelper; 
   use Cake\View\Helper\SecurityMaxHelper;
   use Cake\Datasource\ConnectionManager;
   $conn = ConnectionManager::get('default');
   $rowAdminInfo =  $this->request->getSession()->read('ADMIN');
   $resStateList =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].'  ')->fetchAll('assoc');
   $aryPermissionId =array();
   foreach($resStateList as $rowStateList)
   {
   $aryPermissionId[$rowStateList['pd_permission_id']] =$rowStateList;
   }
  
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
      <link rel="icon" href="<?php echo SITE_UPLOAD_URL.SITE_THEME_IMAGE_PATH.$rowThemeInfo->theme_favicon; ?>" type="image/gif" sizes="16x16">
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
            <a class="navbar-brand" href="<?php echo SITE_URL;?>admin" style="margin-left: 18px;">
               <p>Unnati+</p>
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
                  <span><?php echo $rowAdminInfo->admin_first_name.' '.$rowAdminInfo->admin_last_name; ?></span>
                  <i class="caret"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right">
                     <li><a href="<?php echo SITE_URL; ?>admin/myprofile/"><i class="icon-user-plus"></i> My profile</a></li>
                     <li><a href="<?php echo SITE_URL; ?>admin/dashboard/logout"><i class="icon-switch2"></i> Logout</a></li>
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
                              <a href="<?php echo $this->Url->build('/admin/dashboard', true); ?>"><i class="icon-home4"></i> <span>Dashboard</span></a>
                           </li>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]) || isset($aryPermissionId[2]) || isset($aryPermissionId[3]))
                              { ?>
                           <li style="display:none">
                              <a href="#"><i class="icon-newspaper"></i> <span>Blog</span></a>
                              <ul>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]))
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Blog') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/blog', true); ?>">Manage Blog</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]) && $aryPermissionId[1]['pd_entry'])
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Add Blog') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/blog/addblog', true); ?>">Add New</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[2]))
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Blog Categories') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/bcategories', true); ?>">Categories</a></li>
                                 <?php } ?>		
                              </ul>
                           </li>
                           <?php } ?>	
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]) || isset($aryPermissionId[2]) || isset($aryPermissionId[3]))
                              { ?>
                           <li>
                              <a href="#"><i class="icon-newspaper"></i> <span>Seller</span></a>
                              <ul>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]))
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Seller') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/seller', true); ?>">Manage Seller</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]) && $aryPermissionId[1]['pd_entry'])
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Add Seller') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/seller/addseller', true); ?>">Add New</a></li>
                                 <?php } ?>	
                              </ul>
                           </li>
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]) || isset($aryPermissionId[2]) || isset($aryPermissionId[3]))
                              { ?>
                           <li>
                              <a href="#"><i class="icon-cart2"></i> <span>Products</span></a>
                              <ul>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]))
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Product') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/product', true); ?>">Manage Products</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[1]) && $aryPermissionId[1]['pd_entry'])
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='AddProduct') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/product/addproduct', true); ?>">Add New</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[2]))
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Categories') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/categories', true); ?>">Categories</a></li>
                                 <?php } ?>		
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Tag') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/tag', true); ?>">Tags</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Attributes') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/unit', true); ?>">Unit</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Size') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/size', true); ?>">Size</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <!--<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Attributes') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute', true); ?>">Attributes</a></li>-->
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Fabric') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute/fabric', true); ?>">Fabric</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Occasion') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute/occasion', true); ?>">Occasion</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Design') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute/design', true); ?>">Design</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Product Style') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute/product-style', true); ?>">Product Style</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Product Fit') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute/product-fit', true); ?>">Product Fit</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Neck Type') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute/neck-type', true); ?>">Neck Type</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[3]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Sleeve') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/attribute/sleeve', true); ?>">Sleeve</a></li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <?php } ?>		
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[10]) || isset($aryPermissionId[9]) || isset($aryPermissionId[11]))
                              { ?>	
                           <li>
                              <a href="javascript:;"><i class="icon-stack3"></i> <span>Appearance</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Brand') { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/brand">Brands</a></li>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[10]) )
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Taxes' || isset($strPageTitle) && $strPageTitle=='Add Tax') { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/taxes">Taxes</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[9]) )
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Slider' || isset($strPageTitle) && $strPageTitle=='Add Slider') { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/slider">Slider & Banner</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[11]) )
                                    { ?>
                                 <!--			<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Roles' || isset($strPageTitle) && $strPageTitle=='Add Roles') { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/roles">Roles</a></li>-->
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[11]) )
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage FAQ' || isset($strPageTitle) && $strPageTitle=='Add FAQ') { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/faq">FAQ</a></li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <?php } ?>	
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[4]) || isset($aryPermissionId[5]) || isset($aryPermissionId[14]))
                              { ?>		
                           <li>
                              <a href="#"><i class="icon-clipboard3"></i> <span>Orders</span></a>
                              <ul>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[4]))
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Order' || isset($strPageTitle) && $strPageTitle=='Order Detail') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/order', true); ?>">Manage Orders</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[5]))
                                    { ?>				
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Cancel Order') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/order/cancelorderlist', true); ?>">Cancellations</a></li>
                                 <?php } ?>		
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[14]))
                                    { ?>					
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Rejected Order') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/order/rejectorderlist', true); ?>">Rejected Order</a></li>
                                 <?php } ?>				
                              </ul>
                           </li>
                           <?php } ?>	
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[4]) || isset($aryPermissionId[5]) || isset($aryPermissionId[14]))
                              { ?>		
                           <li>
                              <a href="#"><i class="icon-history"></i> <span>Recent Activity</span></a>
                              <ul>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[4]))
                                    { ?>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Cart History') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/recentHistory/cart-history', true); ?>">Cart History</a></li>
                                 <?php } ?>	
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[5]))
                                    { ?>				
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Wishlist History') { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/recentHistory/wishlist-history', true); ?>">Wishlist History</a></li>
                                 <?php } ?>		
                              </ul>
                           </li>
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[6]))
                              { ?>
                           <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage User' ) { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/user', true); ?>"><i class="icon-people"></i> <span>Users</span></a></li>
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[6]))
                              { ?>
                           <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Customer Review' ) { ?> active <?php } ?>"><a href="<?php echo $this->Url->build('/admin/customer-review', true); ?>"><i class="icon-eye8"></i> <span>Customer Review</span></a></li>
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[7]))
                              {   ?>	
                           <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Customer Feedback' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/customer"><i class="icon-thumbs-up3"></i><span>Feedback</span></a></li>
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[7]))
                              {   ?>	
                           <li>
                              <a href="#"><i class="icon-users"></i> <span>Requirement</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Requirement' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/requirement">Requirement</a></li>
                              </ul>
                           </li>
                           <?php } ?>	
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[7]))
                              { ?>	
                           <li>
                              <a href="#"><i class="icon-truck"></i> <span>Shipping</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Shipping' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/shipping"> Shipping Rate</a></li>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[7]) && $aryPermissionId[7]['pd_entry'])
                                    {   ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Add Shipping Rates' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/shipping"> Add New</a></li>
                                 <?php } ?>		
                              </ul>
                           </li>
                           <?php } ?>	
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[28]))
                              {   ?>	
                           <!--<li>
                              <a href="#"><i class="icon-truck"></i> <span>Staff </span></a>
                              <ul>
                              <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Staff' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/staff" > Manage Staff</a></li>
                              <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[28]) && $aryPermissionId[28]['pd_entry']==1)
                                 {   ?>	
                              <li  class="<?php if(isset($strPageTitle) && $strPageTitle=='Add Staff' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/staff/addstaff"> Add New</a></li>
                              <?php } ?>
                              </ul>
                              </li>-->
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[8]))
                              {   ?>	
                           <li>
                              <a href="#"><i class="icon-ticket"></i> <span>Coupon</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Coupon' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/coupon">Manage Coupon </a></li>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[8]) && $aryPermissionId[8]['pd_entry']==1)
                                    {   ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Add coupon') { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/coupon/addcoupon"> Add Coupon</a></li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[12]) || isset($aryPermissionId[13]) )
                              { ?>		
                           <li>
                              <a href="#"><i class="icon-cog52"></i> <span>Setting</span></a>
                              <ul>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[12]))
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Theme Setting' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/theme-setting">Theme Setting</a></li>
                                 <?php } ?>
                                 <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[13]) )
                                    { ?>	
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Social Setting' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/theme-setting/socialsetting">Social Setting</a></li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <?php } ?>	
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[16]) )
                              { ?>		
                           <li>
                              <a href="#"><i class="icon-files-empty"></i> <span>Pages</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Pages' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/pages">Manage Pages</a></li>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Add Pages' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/pages/addpages">Add New</a></li>
                              </ul>
                           </li>
                           <?php } ?>
                           <?php if($rowAdminInfo->admin_default==1 || isset($aryPermissionId[17]) )
                              { ?>		
                           <li>
                              <a href="#"><i class="icon-envelop5"></i> <span>Enquiry</span></a>
                              <ul>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Enquiry' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/enquiry">Contact Us</a></li>
                                 <li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Help & Support' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/help-and-support">Help & Support</a></li>
                                 <!--<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Newsletter' ) { ?> active <?php } ?>"><a href="<?php echo SITE_URL; ?>admin/newsletter">Newsletter</a></li>
                                    -->
                              </ul>
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