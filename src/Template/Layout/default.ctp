<?php $rowUserInfo =  $this->request->getSession()->read('USER');
       $userMobile =  $this->request->getSession()->read('TEMP_USER');
?>
<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/css/product-slider.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/css/responsive.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/css/materialize.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/css/custom-bootstrap.css">
<link rel="icon" href="<?php echo SITE_URL;?>assets/img/favicon.png" type="image/x-icon" />
<link rel='stylesheet' href='<?php echo SITE_URL;?>assets/fonts/icomoon/styles.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo SITE_URL;?>assets/fonts/font-awesome/css/font-awesome.css' type='text/css' media='all' />
<link rel="stylesheet" href="<?php echo SITE_URL;?>owlcarousel/assets/owl.carousel.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>owlcarousel/assets/owl.theme.default.min.css">
<link rel='stylesheet' href='<?php echo SITE_URL;?>assets/css/jquery.growl.css' type='text/css' media='all' />
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<style>.otp-circle{border:1px solid #ccc;display:inline-block;width:50px;height:50px;border-radius:50%;line-height:50px}</style>
<title>Unnati+</title>

<meta property="og:title" content="<?php echo (isset($strProductTitle)?$strProductTitle:'');?>" />
<meta property="og:image" content="<?php echo isset($strOgImage)?$strOgImage:''; ?>" />
<meta property="og:description" content="<?php echo isset($strOgDetail)?$strOgDetail:''; ?>" />

</head>
<body>
<?php if(!isset($strApp) || isset($strApp) && $strApp=='')
{ ?>
<a href="<?php echo SITE_URL;?>customer-feedback" class="feedback-flo">Feedback</a>
<div class="top-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
<div class="top-header-list">
<ul>
<li><a href="<?php echo SITE_URL; ?>seller-register">Are you a Seller/Agent ? Register here</a></li>
</ul>
</div>
</div>
<div class="col-lg-6">
<div class="top-header-list pull-right">
<ul>
<li><a href="<?php echo SITE_URL; ?>sale"><i class="fa fa-gift"></i> SALE</a></li>
<li><a href="<?php echo SITE_URL; ?>post-your-requirement">Post your Requirement</a></li>
<li><i class="icon-map"></i><a href="<?php echo SITE_URL; ?>store-locator">Store Locator</a></li>
<li><i class="icon-phone-wave"></i><?php echo $resSocialLink->theme_contact;?></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Help & Support') { ?>active<?php } ?>"><i class="icon-help"></i>
<a href="<?php echo SITE_URL;?>help-and-support">Help & Support</a></li>
<!--<li><i class="icon-help"></i>Help & Support</li>
--></ul>
</div>
</div>
</div>
</div>
</div>

<header>
<div class="container-fluid">
<div class="row">
<div class="col-lg-3 col-5">
    <?php if($detect['device']=='MOBILE')
{ 
    ?>
<a href="#" data-target="slide-out" class="sidenav-trigger">
<div class="side-menu-icon">
<img src="<?php echo SITE_URL;?>assets/img/icon/menu.png">
</div>
<div class="logo"><img src="<?php echo SITE_UPLOAD_URL.SITE_THEME_IMAGE_PATH.$resSocialLink->theme_logo;?>"></div>
</a>

<?php }else{ ?>
<a href="<?php echo SITE_URL; ?>" >
<div class="side-menu-icon">
<img src="<?php echo SITE_URL;?>assets/img/icon/menu.png">
</div>
<div class="logo"><img src="<?php echo SITE_UPLOAD_URL.SITE_THEME_IMAGE_PATH.$resSocialLink->theme_logo;?>"></div>
</a>
<?php } ?>
</div>
<div class="col-lg-6 res-search">
<form method="post" action="">
<div class="search-box">
<div class="selectParent">
<select name="search_category">
<?php foreach($aryCategoryList as $selectCategoryList)
{?><option value="<?php echo $selectCategoryList->category_slug;?>"><?php echo $selectCategoryList->category_name;?></option><?php }?>
</select>
</div>
<input type="text" name="search_title" placeholder="eg. type in name or brand of product....">
<button type="submit"><i class="icon-search4"></i></button>
</div>

</form>
</div>
<div class="col-lg-3 col-7">
<div class="header-left">
<ul>
<?php if($rowUserInfo['user_id']>0)
{ 
$wishlistCount = $wishlistInfo->find('all')->where(['wish_user_id'=>$rowUserInfo['user_id']])->count();
?>
<li>
<a href="<?php echo SITE_URL;?>my-account/wish-list">
<img src="<?php echo SITE_URL;?>assets/img/icon/heart.png" style="width:25px; height:25px;">
<?php if($wishlistCount>0){ ?>

<div class="count wishlistcount"><?php echo $wishlistCount; ?></div>
<?php }else{ ?>
<div class="count wishlistcount" style="display:none"><?php echo $wishlistCount; ?></div>

<?php } ?>
</a>
</li>
<?php }else{?>
<li>
<a href="#" data-toggle="modal" data-target="#login" >
<img src="<?php echo SITE_URL;?>assets/img/icon/heart.png" style="width:25px; height:25px;">
<!--<div class="count">2</div>-->
</a>
</li>
<?php }?>
<li>
<a href="<?php echo SITE_URL;?>my-cart">
<img src="<?php echo SITE_URL;?>assets/img/icon/cart.png" style="width:25px; height:25px;">
<div class="hl-cont">
<span class="title">My Cart</span>
 <span class="text cartcountforupdate"><?php echo $cartcountfromapp; ?> item(s) </span>
</div>
</a>
</li>
<?php if($rowUserInfo['user_id']>0)
{ ?>
<li>
<a href="<?php echo SITE_URL;?>my-account">
<img src="<?php echo SITE_URL;?>assets/img/icon/user.png" style="width:25px; height:25px;">
<div class="hl-cont">
<span class="title">My Account</span>
<span class="text">Hi ! <?php echo $rowUserInfo->user_first_name; ?></span>
</div>
</a>
</li>
<?php } else{?>
<li>
<a href="#" id="refreshLoginPopup" onclick="refreshLoginPopup()" data-toggle="modal" data-target="#login">
<img src="<?php echo SITE_URL;?>assets/img/icon/user.png" style="width:25px; height:25px;">
<div class="hl-cont">
<span class="title">My Account</span>
<span class="text">Sign in / Sign up</span>
</div>
</a>
</li>
<?php }?>
</ul>
</div>
</div>
</div>
</div>
</header>
<?php } ?>
<!----mobile-menu------------------------------>
<div id="slide-out" class="sidenav">
<div class="bside-menu">
  <?php 
                                $counter =0;
                                foreach($aryCategoryList as $key=>$label)
                                {
                                $counter++;
                                ?>    
<div class="bside-menu-list">
<ul>
<li><a href="<?php echo SITE_URL ?>product-list/<?php echo $label['category_slug'];?>"> <?php echo $label['category_name']; ?></a></li>
 <?php if(count($label['children'])>0)
 { ?>
 <?php foreach($label['children'] as $key2nd=>$label2nd)
 { ?>
 
<li><a href="<?php echo SITE_URL ?>product-list/<?php echo $label2nd['category_slug'];?>" class="sub"><?php echo $label2nd['category_name']; ?></a></li>

<?php } }?>
</ul>
</div>
<hr>
<?php }?>

<!--
<div class="bside-menu-list">
<ul>
<li><a href="https://codexosoftware.com/web">Website Design & Development</a></li>
<li><a href="https://codexosoftware.com/e-commerce-development" class="sub">- E-Commerce Development</a></li>
<li><a href="https://codexosoftware.com/custom-website-design" class="sub">- Custom Website Design</a></li>
<li><a href="https://codexosoftware.com/responsive-design" class="sub">- Responsive Design</a></li>
<li><a href="https://codexosoftware.com/web-application-development" class="sub">- Web Application Development</a></li>
<li><a href="https://codexosoftware.com/cms-development" class="sub">- CMS Development</a></li>
<li><a href="https://codexosoftware.com/open-source-customization" class="sub">- Open Source Customization</a></li>
</ul>
</div>
<hr>
<div class="bside-menu-list">
<ul>
<li><a href="https://codexosoftware.com/mobile">Mobile Application Development</a></li>
<li><a href="https://codexosoftware.com/ionic-app-development" class="sub">- Ionic App Development</a></li>
<li><a href="https://codexosoftware.com/iphone-app-development" class="sub">- iPhone App Development</a></li>
<li><a href="https://codexosoftware.com/android-app-development" class="sub">- Android App Development</a></li>
<li><a href="https://codexosoftware.com/windows-application" class="sub">- Windows Application</a></li>
<li><a href="https://codexosoftware.com/game-development" class="sub">- Game Development</a></li>
<li><a href="https://codexosoftware.com/phone-gap-application" class="sub">- PhoneGap Application</a></li>
</ul>
</div>
<hr>
<div class="bside-menu-list">
<ul>
<li><a href="https://codexosoftware.com/digital-marketing">Digital Marketing</a></li>
<li><a href="https://codexosoftware.com/search-engine-optimization" class="sub">- Search Engine Optimization</a></li>
<li><a href="https://codexosoftware.com/social-media-optimization" class="sub">- Social Media Optimization</a></li>
<li><a href="https://codexosoftware.com/ppc-management" class="sub">- PPC Management</a></li>
<li><a href="https://codexosoftware.com/email-marketing" class="sub">- Email Marketing</a></li>
</ul>
</div>
<hr>
<div class="bside-menu-list">
<ul>
<li><a href="https://codexosoftware.com/solutions">Solutions</a></li>
<li><a href="https://codexosoftware.com/case-studies">Case Studies</a></li>
<li><a href="#">Products</a></li>
<li><a href="#">Contact Us</a></li>
<li><a href="#">Request a Free Quote</a></li>
</ul>
</div>-->
</div>
</div>
<!----mobile-menu--end---------------------------->
<?php echo $this->fetch('content');?>
   <?php if(!isset($strApp) || isset($strApp) && $strApp=='')
{ ?>
<footer>
<div class="container-fluid">
<div class="row">
<div class="col-lg-3">
<div class="footer-logo">
<img src="https://codexosoftware.live/unnatiplus/webroot/assets/img/uploads/theme_image/1577183312logo.png">
</div>
<p style="margin-bottom:3px;">Unnati+ has factories producing excellent selection of products as sellers who list their ready inventory stock for sale to shopkeepers across the country...</p>
<p><a href="<?php echo SITE_URL;?>about-us">Read More</a></p>
<div class="address">
<p>B-1, Crystal Mall, Pratap Nagar,<br>
Jaipur-302016, Rajasthan, India</p>
<p><i class="icon-mail5"></i> info@unnati.com</p>
<p><i class="icon-phone-wave"></i> +91- 000 000 0000</p>
</div>
</div>
<div class="col-lg-3 col-6">
<div class="footer-list">
<h2>Information</h2>
<div class="row">
<div class="col-lg-6">
<ul>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='About Us') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>about-us">About Us</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Faq') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>faq">FAQ</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Terms & Conditions') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>terms-and-condition">Terms & Conditions</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Contact Us') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>contact-us">Contact Us</a></li>

</ul>
</div>
<div class="col-lg-6">
<?php if($rowUserInfo['user_id']>0)
{ ?>
<ul>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='My Account') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>my-account">My Account</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Orders') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>my-account/orders">Orders</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='My Cart') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>my-cart">My Cart</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Wishlist') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>my-account/wish-list">Wishlist</a></li>
</ul>
<?php }else{?>
<ul>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='My Account') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="#" data-toggle="modal" data-target="#login">My Account</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Orders') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="#" data-toggle="modal" data-target="#login">Orders</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='My Cart') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>my-cart" >My Cart</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Wishlist') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="#" data-toggle="modal" data-target="#login">Wishlist</a></li>
</ul>
<?php }?>
</div>
</div>


</div>
</div>
<div class="col-lg-2 col-6">
<div class="footer-list">
<h2>Quick Links</h2>
<ul>

<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Help & Support') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>help-and-support">Help & Support</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Cancellation & Returns') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>cancellation-and-returns">Cancellation & Returns</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Privacy Policy') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>privacy-policy">Privacy Policy</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Terms & Conditions') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>terms-and-condition">Terms & Conditions</a></li>
<li class="<?php if(isset($strPageTitle) && $strPageTitle=='Shipping Policy') { ?>active<?php } ?>"><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>shipping-policy">Shipping Policy</a></li>
<li ><i class="fa fa-angle-double-right mr-1" aria-hidden="true"></i><a href="<?php echo SITE_URL;?>customer-feedback">Feedback</a></li>

</ul>
</div>
</div>
<div class="col-lg-4">
<div class="footer-title mb-10">Signup for Newsletter</div>
<p class="text-gray">Be one of the first to hear about our news, updates and subscriber-only special offers! </p>
<form id="newsletterform" method="post" action="javascript:void(0)">
<div class="newsletter mb-20">
<div class="md-input alert alert-success" id="newsletter-success" style="display:none"></div>
<div class="md-input alert alert-danger"  id="newsletter-error" style="display:none"></div>
<div class="input-group">

<input type="text" class="form-control" name="newsletter_email" id="newsletter_email"  placeholder="Your email address...">
<div class="input-group-append">
<button type="submit" onclick="return newsletterprocess($(this));">Submit</button>
</div>
</div>
</div>
</form>
<?= $this->Form->end() ?>
<div class="footer-title mb-10">Connect with us!</div>
<div class="footer-social-list">
<ul>
<li><a href="<?php echo $resSocialLink->theme_facebook;?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/facebook.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_twitter;?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/twitter.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_ggogle_plus;?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/google-plus.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_linkdin;?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/linkdin.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_pinterest;?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/pinterest.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_youtube;?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/youtube.png"></a></li>
</ul>
</div>
</div>

</div>
</div>
</footer>
<div class="copyright">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
@2019 Unnati. All Rights Reserved
</div>
<div class="col-lg-6">
<img src="<?php echo SITE_URL;?>assets/img/payment.svg" class="pull-right">
</div>
</div>
</div>
</div>
<?php } ?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>-->

<script src="<?php echo SITE_URL;?>assets/js/bootstrap.min.js" ></script>
<script src="<?php echo SITE_URL;?>owlcarousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>owlcarousel/owl.carousel.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/materialize.min.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/jquery.growl.js" type="text/javascript"></script>
<script>var options; document.addEventListener('DOMContentLoaded',function(){var elems=document.querySelectorAll('.sidenav');var instances=M.Sidenav.init(elems,options);});$(document).ready(function(){$('.sidenav').sidenav();});</script>
<script>
$('.slider-home').owlCarousel({
loop:true,
margin:10,
nav:true,
dots:false,
responsive:{
0:{
items:1
},
600:{
items:1
},
1000:{
items:1
}
}
})
$('.product-slider').owlCarousel({
loop:true,
margin:10,
nav:true,
dots:false,
responsive:{
0:{
items:2
},
600:{
items:2
},
1000:{
items:5
}
}
})
$('.brand-slider').owlCarousel({
loop:true,
margin:15,
nav:false,
dots:false,
responsive:{
0:{
items:1
},
600:{
items:3
},
1000:{
items:8
}
}
})
$('.feedback-slider').owlCarousel({
loop:true,
margin:15,
nav:false,
dots:false,
responsive:{
0:{
items:1
},
600:{
items:3
},
1000:{
items:3
}
}
})
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5dfdf06727773e0d832a2c08/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<!--Start of wishlist Script-->
<script>
function setwish(e,obj)
{

var datastring = 'ev='+e;
$.post('<?php echo SITE_URL; ?>home/wishlist',datastring,function(response){
var sd = JSON.parse(response);
if(sd.message=='ok' && sd.status==1)
{
obj.find('i').removeClass('fa-heart-o');
obj.find('i').addClass('fa-heart');
}else if(sd.message=='ok' && sd.status==0)
{
obj.find('i').addClass('fa-heart-o');
obj.find('i').removeClass('fa-heart');   
}
if(sd.total>0)
{
$('.wishlistcount').html(sd.total);
$('.wishlistcount').show();
}else{
$('.wishlistcount').hide();

}
});

}
</script>
<!--End of wishlist Script-->
<!--Start of Newsletter Script-->
<script>
function newsletterprocess(objectElement)
{

var useremail = $('#newsletter_email').val(); 
if(useremail.trim()=='')
{
$('#newsletter_email').attr('style',' border-bottom: 1px solid red;');
return false;
}else{
if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(useremail))
{
$('#newsletter_email').attr('style',' border-bottom: 1px solid #ccc;');
}else{
$('#newsletter_email').attr('style',' border-bottom: 1px solid red;');
return false;
}
}
var datastring= $('#newsletterform').serialize();
$.post(base_url+'home/newsletter',datastring,function(response){
var jsondata = JSON.parse(response);
if(jsondata.message=='ok')
{
$('#newsletter-success').html(jsondata.notification);
$('#newsletter-success').show();
setTimeout(function(){
$('#newsletter-success').fadeOut();
},3000);
//window.location.href=base_url+'my-account';
}else{
$('#newsletter-error').html(jsondata.notification);
$('#newsletter-error').show();
setTimeout(function(){
$('#newsletter-error').fadeOut();
},3000);
}
});
}
</script>
<!--End of Newsletter Script-->
<div class="modal" id="login">
    <div class="modal-dialog login-pop">
        <div class="modal-content">
            <button type="button" class="close-pop" onclick="$('#registerform').show();" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <form id="registerform" method="post" action="javascript:void(0)">
                    <div id="register">
                        <div class="md-input alert alert-danger" id="register-error" style="display:none"></div>
                        <div class="lr-box text-center">
                            <h2>Please enter your mobile number</h2>
                            <div class="lr-form-box">
                                <div class="country-code">+91</div>
                                <input type="text" required="" name="user_mobile" id="user_mobile" placeholder="Mobile Number" value="" class="pl-50">
                            </div>
                            <button type="submit" onclick="return registrationotp($(this));">Continue<i id="register_spinner" class="icon-spinner2 spinner position-left " style="display:none"></i></button>
                        </div>
                    </div>
                </form>
                <form id="otpform" method="post" action="javascript:void(0)">
                    <div id="otp" style="display:none">
                        <div class="md-input alert alert-success" id="verifyotp-success" style="display:none"></div>
                        <div class="md-input alert alert-danger" id="verifyotp-error" style="display:none"></div>
                        <div class="lr-box text-center">
                            <h2>Please enter your OTP</h2>
                            <div class="lr-form-box">
                                <input type="text" required="" name="user_otp" id="user_otp" placeholder="Enter OTP" value="">
                                <input class="md-form-control" type="hidden" name="user_id_otp" id="user_id_otp">
                            </div>
                            <button type="submit" onclick="return checkotpverification($(this));">Verify<i id="verifyotp_spinner" class="icon-spinner2 spinner position-left " style="display:none"></i></button>
                        </div>
                        <div id="hidetimer" style="text-align: center; display: none;">
                            <p style="text-align:center">RESEND OTP AFTER</p>
                            <p id="timerotp" class="otp-circle">-1</p>
                        </div>
                        <div id="showresendbutton" style="display: block; padding-top: 14px;">
                            <p style="text-align:center"><a href="javascript:void(0);" onclick="resendotp();">Resend OTP</a></p>
                        </div>
                    </div>
                </form>
                <form id="passwordform" method="post" action="javascript:void(0)">
                    <div id="password" style="display:none">
                        <div class="md-input alert alert-danger" id="password-error" style="display:none"></div>
                        <div class="lr-box text-center">
                            <h2>Please enter your Password</h2>
                            <div class="lr-form-box">
                                <input type="password" required="" name="user_pass" id="user_pass" placeholder="Enter Password" value="">
                            </div>
                            <button type="submit" onclick="return checkpassword($(this));">Login<i id="password_spinner" class="icon-spinner2 spinner position-left " style="display:none"></i></button><br><br>
                            <a href="#" onclick="$('#forgot').show();$('#password').hide();"> Forgot Password?</a>
                        </div>
                    </div>
                </form>
                <form id="forgotform" method="post" action="javascript:void(0)">
                    <div id="forgot" style="display:none">
                        <div class="md-input alert alert-success" id="forgotpasword-success" style="display:none"></div>
                        <div class="md-input alert alert-danger" id="forgotpasword-error" style="display:none"></div>
                        <div class="lr-box text-center">
                            <h2>Forgot Password</h2>
                            <div class="lr-form-box">
                                <input type="text" required="" name="user_mobile" id="user_forget_mobile" placeholder="Enter Email Id" value="">
                            </div>
                            <button type="submit" onclick="return forgotpassword($(this));">Submit<i id="password_spinner" class="icon-spinner2 spinner position-left " style="display:none"></i></button><br><br>
                        </div>
                    </div>
                </form>
<form id="userform" method="post" action="javascript:void(0)">
<div id="user" style="display:none">
<div class="md-input alert alert-danger" id="user-error" style="display:none"></div>
<div class="lr-box">
<h2 class="mb-20">Please provide following details</h2>
<div class="row">
<div class="col-lg-6">
<div class="lr-form-box">
<label>First Name</label>
<input type="text" required="" name="user_first_name" id="user_first_name" placeholder="Enter First Name" value="">
</div>
</div>
<div class="col-lg-6">
<div class="lr-form-box">
<label>Last Name</label>
<input type="text" required="" name="user_last_name" id="user_last_name" placeholder="Enter Last Name" value="">
</div>
</div>
</div>
<div class="lr-form-box">
<label>Email</label>
<input type="email" required="" name="user_email_id" id="user_email_id" placeholder="Enter Email" value="">
</div>
<div class="lr-form-box">
<label>Password</label>
<input type="password" required="" name="user_password" id="user_password" placeholder="Enter Password" value="">
<input class="md-form-control" type="hidden" name="user_otp" id="user_otp">
</div>
<button type="submit" onclick="return userregister($(this));">Continue<i id="user_spinner" class="icon-spinner2 spinner position-left " style="display:none"></i></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<script>

    function refreshLoginPopup()
    {
        $('#register').show();
        $('#register_spinner').hide();
        $('#user').hide();
        $('#forgot').hide();
        $('#password').hide();
        $('#otp').hide();
    }
</script>
<script>
var base_url = 'https://codexosoftware.live/unnatiplus/';
function registrationotp(objectElement)
{
    var usermobile = $('#user_mobile').val(); 
    if(usermobile.trim()=='')
    {
        $('#user_mobile').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        var phoneno = /^\d{10}$/;
        if(usermobile.match(phoneno))
        {
            $('#user_mobile').attr('style',' border-bottom: 1px solid #ccc;');
        }else{
            $('#user_mobile').attr('style',' border-bottom: 1px solid red;');
            return false;     
        }
    }
    $('#register_spinner').show();
    var datastring= $('#registerform').serialize();
    $.post(base_url+'home/registeruser',datastring,function(response){
        var jsondata = JSON.parse(response); 
        console.log(jsondata);
        if(jsondata.message=='ok')
        {
            if(jsondata.password_status==1)
            {
                $('#registerform').hide();
                /*$('#password-error').html(jsondata.notification);
                $('#password-error').show();*/
                $('#user_mobile').val(jsondata.user_mobile);
                $('#password').show();
            } else{
                $('#registerform').hide();
                $('#verifyotp-success').html(jsondata.notification);
                $('#verifyotp-success').show();
                $('#user_id_otp').val(jsondata.user_id);
                $('#otp').show();
            }
        }else{
            //console.log(jsondata.msg);
            $('#register-error').html(jsondata.notification);   
            $('#register-error').show();
            $('#register_spinner').hide();
        }
    });
}

function checkpassword(objectElement)
{
    var userpass= $('#user_pass').val();
    if(userpass.trim()=='')
    {
        $('#user_pass').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        $('#user_pass').attr('style',' border-bottom: 1px solid #ccc;');
    }
    $('#password_spinner').show();
    var datastring =$('#passwordform').serialize();
    $.post(base_url+'home/checkpassword',datastring,function(response){
        var jsondata = JSON.parse(response);
        if(jsondata.message=='ok')
        {
            window.location.href=jsondata.redirect_to;
        }else{
            $('#password_spinner').hide();
            $('#password-error').html(jsondata.notification);
            $('#password-error').show();
        }
    });
}

function checkotpverification(objectElement)
{
    var userpass= $('#user_otp').val();
    if(userpass.trim()=='')
    {
        $('#user_otp').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        $('#user_otp').attr('style',' border-bottom: 1px solid #ccc;');
    }
    $('#login_spinner').show();
    var datastring =$('#otpform').serialize();
    $.post(base_url+'home/verifyotp',datastring,function(response){
        var jsondata = JSON.parse(response);
        if(jsondata.message=='ok')
        {
            //console.log(jsondata.msg);
            $('#registerform').hide();
            $('#otpform').hide();
            $('#user_otp').val(jsondata.user_otp);
            $('#user').show();
        }else{
            $('#verifyotp-error').html(jsondata.notification);
            $('#verifyotp-error').show();
            $('#login_spinner').hide();
        }
    });
}

function settimerdata()
{
    // Set the date we're counting down to
    var distance =60;
    // Update the count down every 1 second
    var x = setInterval(function() {
        $("#showresendbutton").hide();
        $("#hidetimer").show();
        distance =distance-1;
        document.getElementById("timerotp").innerHTML = distance;
        if (distance < 0) 
        {
            clearInterval(x);
            $("#showresendbutton").show();
            $("#hidetimer").hide();
        }
    }, 1000);
}

function resendotp()
{
    var user_id =$('#user_id_otp').val();
    $.get(base_url+'home/resentotp/'+user_id,function(response){
        var jsonparsedata = JSON.parse(response);
        if(jsonparsedata.message=='ok')
        {
            
            $('#verifyotp-success').html(jsonparsedata.notification);   
            $('#verifyotp-success').show();
        }
        settimerdata();
    });
}

function userregister(objectElement)
{
    var user_firstname = $('#user_first_name').val(); 
    if(user_firstname.trim()=='')
    {
        $('#user_first_name').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        $('#user_first_name').attr('style',' border-bottom: 1px solid #ccc;');
    }
    var user_lastname = $('#user_last_name').val(); 
    if(user_lastname.trim()=='')
    {
        $('#user_last_name').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        $('#user_last_name').attr('style',' border-bottom: 1px solid #ccc;');
    }
    var useremail = $('#user_email_id').val(); 
    if(useremail.trim()=='')
    {
        $('#user_email_id').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(useremail))
        {
            $('#user_email_id').attr('style',' border-bottom: 1px solid #ccc;');
        }else{
            $('#user_email_id').attr('style',' border-bottom: 1px solid red;');
            return false;
        }
    }
    var userpass= $('#user_password').val(); 
    if(userpass.trim()=='')
    {
        $('#user_password').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        $('#user_password').attr('style',' border-bottom: 1px solid #ccc;'); 
    }
    $('#user_spinner').show();
    var datastring= $('#userform').serialize();
    $.post(base_url+'home/userregister',datastring,function(response)
    {
        var jsondata = JSON.parse(response);
        if(jsondata.message=='ok')
        {
            window.location.href=base_url+'my-account';
        }else{
            $('#user-error').html(jsondata.notification);
            $('#user-error').show();
            $('#user_spinner').hide();
        }
    });
}

    function forgotpassword()
    {
        var user_mobile = $('#user_forget_mobile').val(); 
        if(user_mobile.trim()=='')
        {
            $('#user_forget_mobile').attr('style',' border-bottom: 1px solid red;');
            return false;
        }else{
            $('#user_forget_mobile').attr('style',' border-bottom: 1px solid #ccc;');
        }
        //var datastring= $('#forgotform').serialize();
        var datastring='user_mobile='+user_mobile;
        $.post(base_url+'home/forgotpassword',datastring,function(response)
        {
            var jsondata = JSON.parse(response);
            if(jsondata.message=='ok')
            {
                $('#forgotpasword-success').html(jsondata.notification);
                $('#forgotpasword-success').show();
                $('#user_forget_mobile').val('');
            }else{
                $('#forgotpasword-error').html(jsondata.notification);
                $('#forgotpasword-error').show();
                $('#user_spinner').hide();
            }
        });
        
    }
</script>
</body>
</html>