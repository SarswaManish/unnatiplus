<?php $rowAdminInfo =  $this->request->getSession()->read('USER');?>

<div class="pls-left">
<div class="my-box mb-10">
<div class="my-box-body">
<div class="media profile-box">


  <?php if($rowAdminInfo['user_profile']!=''){?>
            <img class="mr-3" src="<?php echo  SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowAdminInfo->user_profile; ?>" alt="Generic placeholder image">

<?php }   else{ ?>
    <img class="mr-3" src="<?php echo SITE_URL;?>assets/img/user.png" alt="Generic placeholder image">
<?php
} ?>
    

<div class="media-body pt-5">
<p>Hello,</p>
<h4><?php echo $rowAdminInfo['user_first_name']; ?></h4>
</div>
</div>
</div>
</div>
<div class="my-box">
<div class="my-ac-list">
<h2><i class="icon-files-empty"></i> Orders <i class="icon-circle-right2 pull-right mt-3"></i></h2>
<ul>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='All Orders') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account/orders">All Orders</a></li>
<!--<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Delivered Orders') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account/delivered-orders">Delivered Orders</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Returned Orders') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account/returned-orders">Returned Orders</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Canceled Orders') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account/canceled-orders">Canceled Orders</a></li>
--></ul>
<hr>
<h2><i class="icon-cube2"></i> Account Setting <i class="icon-circle-right2 pull-right mt-3"></i></h2>
<ul>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='My Account') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account">Profile Inforamation</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Manage Addresses') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account/manage-address">Manage Addresses</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Wish List') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account/wish-list">My Wishlist</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Logout') { ?>active<?php } ?>"><a href="<?php echo SITE_URL;?>my-account/logout" onclick="return confirm('Are you want to sure Logout?');">Logout</a></li>
</ul>
</div>
</div>
</div>