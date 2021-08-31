<?php use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;

$conn = ConnectionManager::get('default');
$resSelectParetnCategory =$conn->execute('SELECT * FROM sk_category WHERE 1 AND category_status=1 AND category_parent=0')->fetchAll('assoc');
$resSelectCategory =$conn->execute('SELECT * FROM sk_category WHERE 1 AND category_status=1 ')->fetchAll('assoc');

$aryCategoryData =$this->Recurs->buildTreeCategory($resSelectCategory);

//pr($aryCategoryData);exit();
 $resBannerFooterLeft =$conn->execute('SELECT * FROM sk_slider WHERE 1 AND slider_type=5 ')->fetch('assoc');
    $resBannerFooterRight =$conn->execute('SELECT * FROM sk_slider WHERE 1 AND slider_type=7 ')->fetch('assoc');
    $strPage =  'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
   $sqlSelectMeta = 'SELECT * FROM sk_pages WHERE 1 AND page_url=\''.$strPage.'\'';  
   $rowPageData =$conn->execute($sqlSelectMeta)->fetch('assoc');
$rowThemeSetting=$conn->execute('SELECT * FROM theme_setting')->fetch('assoc');

?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="">
<meta name="robots" content="index, follow" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">   
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/bootstrap.css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/style.css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/flexslider.css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/responsive.css">
<!-- Owl Stylesheets -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>owlcarousel/assets/owl.theme.default.min.css">
<link rel='stylesheet' href='<?php echo SITE_URL; ?>fonts/font-awesome/css/font-awesome.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo SITE_URL; ?>fonts/icomoon/styles.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo SITE_URL; ?>css/jquery.growl.css' type='text/css' media='all' />

<link rel="shortcut icon" href="<?php echo SITE_URL; ?>img/favicon.png">
<script src="<?php echo SITE_URL; ?>owlcarousel/vendors/jquery.min.js"></script>
<script src="<?php echo SITE_URL; ?>owlcarousel/owl.carousel.min.js"></script>

<title>Jiyo Home</title>
<?php $rowUserInfo =  $this->request->getSession()->read('USER');?>
<!-- Libs CSS
============================================ -->
 
</head>
<body class="common-home res layout-2">
<div id="wrapper" class="wrapper-fluid banners-effect-7">
<header id="header" class=" typeheader-2" style="box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);">
<!-- //Header Top -->
<!-- Header center -->
<div class="header-middle" style="padding:10px 0px">
<div class="container">
<div class="row">
<!-- Logo -->
<div class="navbar-logo col-lg-2 col-md-2 col-sm-12 col-xs-12">
<div class="logo"><a href="<?php echo SITE_URL; ?>"><img src="https://codexosoftware.live/jiyohome/img/logo.png" title="Your Store" alt="Your Store" /></a></div>
</div>

</div>
</div>
</div>
<!-- //Header center -->

<!-- Header Bottom -->


</header>
<!-- //Header Container  -->

<?= $this->fetch('content') ?>
<!-- Footer Container -->
<div class="footer-top">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="footer-top-title">Our Leading Categories</div>
 <?php foreach($aryCategoryList as $label)
    { 
    if(count($label['children'])>0)
    { ?>
<div class="footer-cat-list">
<ul>
   
<li><a href="<?php $this->Form->getcategoryslug($label); ?>" title="<?php echo $label['category_name']; ?>"><strong><?php echo $label['category_name']; ?> </strong></a></li>
<?php foreach($label['children'] as $label_data)
{ ?>
<li><a href="<?php $this->Form->getcategoryslug($label); ?>"><?php echo $label_data['category_name']; ?></a></li>
<?php } ?>
 
</ul>
</div>
<?php }} ?>
 

</div>
</div>
</div>
</div>
<footer class="bg-darktheme">
<div class="footer">
<div class="container-fluid">
<div class="row">
<div class="col-lg-3">
<div class="footer-title">Contact Info</div>
<p>Jiyo Home Pvt. Ltd.</p>
<p> Buildings Alyssa, Begonia, Jaipur, 560103, Rajasthan, India </p>
<p><strong>Phone:</strong> +91 80 XXX XXXX</p>
<p><strong>Email:</strong> info@jiyohome.com</p>
</div>
<div class="col-lg-2">
<div class="footer-title">My Account</div>
<div class="footer-list">
<ul>
<li><a href="#">My Profile</a></li>
<li><a href="#">Order History</a></li>
<li><a href="#">Wish List</a></li>
<li><a href="#">Track Order</a></li>
<li><a href="#"></a></li>
<li><a href="#"></a></li>
</ul>
</div>
</div>

<div class="col-lg-2">
<div class="footer-title">Quick Links</div>
<div class="footer-list">
<ul>
<li><a href="#">Home</a></li>
<li><a href="#">About Us</a></li>
<li><a href="#"></a></li>
<li><a href="#">Contact Us</a></li>
<li><a href="#"></a></li>
<li><a href="#"></a></li>
</ul>
</div>
</div>
<div class="col-lg-2">
<div class="footer-title">Information</div>
<div class="footer-list">
<ul>
<li><a href="#">Privacy Policy</a></li>
<li><a href="#">Terms & Conditions</a></li>
<li><a href="#">Help & Support</a></li>
<li><a href="#">Cancellation & Returns</a></li>
<li><a href="#">Shipping Policy</a></li>
<li><a href="#"></a></li>
</ul>
</div>
</div>
<div class="col-lg-3">
<div class="footer-title">Signup for Newsletter</div>
<p>Be one of the first to hear about our news, updates and subscriber-only special offers! </p>
<div class="input-group mb-3">
<input type="text" class="form-control" placeholder="Your email address..." id="newsletter_email" name="newsletter_email">
<div class="input-group-append">
<button class="btn btn-outline-secondary" type="button" onclick="return subscribe_newsletter();" style="background: #84c225;color: #fff;border-color: #84c225;">Subscribe</button>
</div>
</div>
<div class="footer-title">Connect With Us!</div>
<div class="footer-social-list">
<ul>
<li><a href="#" target="_blank"><img src="<?php echo SITE_URL; ?>img/facebook.png"></a></li>
<li><a href="#" target="_blank"><img src="<?php echo SITE_URL; ?>img/twitter.png"></a></li>
<li><a href="#" target="_blank"><img src="<?php echo SITE_URL; ?>img/google-plus.png"></a></li>
<li><a href="#" target="_blank"><img src="<?php echo SITE_URL; ?>img/linkedin.png"></a></li>
<li><a href="#" target="_blank"><img src="<?php echo SITE_URL; ?>img/pinterest.png"></a></li>
</ul>
</div>
</div>

</div>
</div>
</div>

<div class="copyright">
<div class="container-fluid">
<div class="row">
<div class="col-lg-4">
Copyright © 2019 Jiyo Home | All Right Reserved
</div>
<div class="col-lg-4"></div>
<div class="col-lg-4"><img src="<?php echo SITE_URL; ?>img/payment.svg" class="img-res"></div>
</div>
</div>
</div>
<!--------------------end-footer----------------------->
</footer>

<!-- The Modal -->
<div class="modal" id="myModal">
<div class="modal-dialog">
<div class="modal-content lr-modal text-center">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<div class="lr-modal-header" style="display:none">Phone Number Verification</div>
<div class="lr-modal-header">Login / Register with Jiyo Home</div>
<div class="lr-modal-content">
  <div class="lr-modal-login clsloginfirst" >
<p>Enter your phone number to<br>Login/Sign up</p>
<div class="login-phone">
    <script>var phoneno = /^\d{10}$/;</script>
<input type="text" maxlength="10" class="login-phone-input clsmobilenumber" value="" onkeyup="if($(this).val().length==10 && $(this).val().match(phoneno)){ $('#loginnext').removeClass('bt-gray');$('#loginnext').addClass('bt-green'); }">
</div>
<button type="button" class="btn bt-gray login-button " id="loginnext" onclick="getloginstatus($(this))"><span id="textnextspinner">Next</span> <i class="fa fa-circle-o-notch fa-spin" style="display:none" id="loginnextspinner"></i>
</button>
</div>
<div class="lr-modal-login login-register-step clslogintwo" style="display:none">
    <div class="alert alert-danger" style="display:none" id="loginuserpassword"></div>
<div class="row">
<div class="col-lg-12">
<input placeholder="Email id / Mobile Number" maxlength="10" required="" id="mobile_number_login" name="user_mobile" type="text" readonly>
</div>
</div>
<div class="row">
<div class="col-lg-12 login-register-step-box">
<input placeholder="Password" required="" id="user_password" name="user_password" type="password">
<a class="forgot">Forgot? </a>
</div>
</div>
<button type="button" class="btn bt-green register-button " onclick="loginuser($(this))"><span id="loginspinnertext">Login</span> <i class="fa fa-circle-o-notch fa-spin" style="display:none" id="loginspinner"></i></button>
<div class="text-gray mb-10 mt-10">OR</div>
<button type="button" class="btn bt-plane register-otp-button " onclick="requestotp()">Request OTP</button>
</div>
<div class="lr-modal-login login-otp-step clsotpone" style="display:none">
<p>Enter 4 digit code sent to your phone  <br>+91-<span id="phonenumberforotp">8094970097</span></p>
<div class="alert alert-danger" id="otperror" style="display:none"></div>
<div class="otp">
<input type="tel" maxlength="1" class="otp-input clsotp1" name="user_otp[]" onkeyup="enableotpbutton('clsotp2')">
<input type="tel" maxlength="1" class="otp-input clsotp2" name="user_otp[]" onkeyup="enableotpbutton('clsotp3')">
<input type="tel" maxlength="1" class="otp-input clsotp3" name="user_otp[]" onkeyup="enableotpbutton('clsotp4')">
<input type="tel" maxlength="1" class="otp-input clsotp4" name="user_otp[]" onkeyup="enableotpbutton('clsotp4')">
</div>
<button type="button" class="btn bt-gray login-button clsotpbutton" onclick="verifyotp($(this))"> <span id="textotpspinner">Verify</span> <i class="fa fa-circle-o-notch fa-spin" style="display:none" id="loginotpspinner"></i></button>
<a class="otp-resend" onclick="resendotp($(this))"><span class="text-gray">Not received your code?</span> Resend Code </a>
<div class="alert alert-success" id="resendotpsuccess" style="display:none"></div>
</div>
<div class="lr-modal-login login-register-step clsregisterone" style="display:none">
<form method="post" action="javascript:void(0);" id="registerdetail">
<div class="row">
<div class="col-lg-6 plessr">
<input placeholder="First Name" id="user_firstname" name="user_first_name" type="text">
</div>
<div class="col-lg-6 plessl">
<input placeholder="Last Name" id="user_lasttname" name="user_last_name" type="text">
</div>
</div>
<div class="row">
<div class="col-lg-12">
<input placeholder="Email id"  id="user_email" name="user_email_id" type="text">
</div>
</div>
<div class="row">
<div class="col-lg-12">
<input placeholder="Enter 10 digit Mobile Number" maxlength="10" id="mobile_number_register" name="user_mobile" type="text" readonly>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<input placeholder="Set Password"  id="user_password_register" name="user_password" type="password">
</div>
</div>
<button type="button" class="btn bt-green register-button " onclick="registerprocess($(this))"><span id="textregisterspinner">Register</span> <i class="fa fa-circle-o-notch fa-spin" style="display:none" id="registerspinner"></i></button>
</form>
</div>



</div>
</div>
</div>

</div>
<script>var _csrf_token_ =<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>
<script src="<?php echo SITE_URL; ?>js/bootstrap.min.js"></script>
<script src="<?php echo SITE_URL; ?>js/flexslider-min.js"></script>
<script src="<?php echo SITE_URL; ?>js/custom.js"></script>
<script src="<?php echo SITE_URL; ?>js/jquery.growl.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/materialize.min.js"></script>
<script src="<?php echo SITE_URL; ?>js/register.js"></script>
 <script src="<?php echo SITE_URL; ?>js/product.js"></script>

<script>

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it

</script>

</body>
</html>