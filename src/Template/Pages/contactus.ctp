<?php use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default'); 
$rowThemeSetting=$conn->execute('SELECT * FROM theme_setting')->fetch('assoc');
?>
<div class="sub-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ul class="breadcrum">
<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
<li><a href="javascript:;">Contact Us</a></li>
</ul>
<h1>Contact Us</h1>
</div>
</div>
</div>
</div><br>
<div class="main-container container">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d227748.38256739752!2d75.65047175312367!3d26.88544791551139!2
m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c4adf4c57e281%3A0xce1c63a0cf22e09!2sJaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin
!4v1577180102583!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="">
</iframe>
<div class="row" style="margin-top:30px; margin-bottom:30px;">
<div class="col-lg-8">
    <h3 class="title-category ">Get In Touch With Us</h3>
    <p>If you have any questions or enquiries please feel free to contact us alternatively you can complete our online enquiry form located below and we will get back to you as soon as possible.</p>
    <div class="contact-form">
     <?php  echo $this->Flash->render(); ?>
        <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'profileupdate','url'=>'/home/contactusenquiry','class'=>'']); ?>
        <div class="row">
			<div class="col-lg-6">
			    <div class="lr-form-box">
			        <label>First Name:<span style="color: red;">*</span></label>
					<input name="enquiry_first_name" class="form-control" type="text">
			    </div>
			</div>
                
			<div class="col-lg-6">
			    <div class="lr-form-box">
			        <label>Last Name:<span style="color: red;">*</span></label>
				    <input name="enquiry_last_name" class="form-control" type="text">
				</div>
			</div>
		</div><br>
		<div class="row">
			<div class="col-lg-12">
			    <div class="lr-form-box">
			        <label>Email:<span style="color: red;">*</span></label>
				    <input name="enquiry_email" class="form-control" type="email">
				</div>
			</div>
		</div><br>
		<div class="row">
			<div class="col-lg-12">
			    <div class="lr-form-box">
			        <label>Mobile:<span style="color: red;">*</span></label>
				    <input name="enquiry_phone" class="form-control" type="text">
			    </div>
			</div>
		</div><br>
		<div class="row">
			<div class="col-lg-12">
			    <div class="lr-form-box">
			        <label>Message:<span style="color: red;">*</span></label>
				    <textarea name="enquiry_message" class="form-control"></textarea>
		        </div>
			</div>
		</div><br>
		<div class="row">
			<div class="col-lg-12">
			 <button type="submit" class="btn btn-success" onclick="return validationcontact($(this))">SUBMIT</button>
			</div>
		</div>
        <?php echo  $this->Form->end(); ?>
 	</div>
</div>
<div class="col-lg-4">
<h3 class="title-category ">Contact Info</h3>
<div class="address-contact">
<ul>
<li><i class="fa fa-map-marker"></i> Jaipur,Jaipur</li>
<li><i class="fa fa-phone"></i><a href="tel:9999999999" style="color:#333">(+91) 9999999999 </a></li>
<li><i class="fa fa-envelope"></i>info@unnatiplus.com </li>
</ul>
</div>
<h3 class="title-category ">Connect With Us!</h3>
<div class="footer-social-list">
	<ul>
<li><a href="<?php echo $resSocialLink->theme_facebook; ?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/facebook.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_twitter; ?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/twitter.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_ggogle_plus; ?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/google-plus.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_linkdin; ?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/linkdin.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_pinterest; ?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/pinterest.png"></a></li>
<li><a href="<?php echo $resSocialLink->theme_youtube; ?>" target="new"><img src="<?php echo SITE_URL;?>assets/img/youtube.png"></a></li>

	</ul>
	</div>
</div>
</div>
</div>
<script>
    function validationcontact()
    {
        var validation =0;
        $('.required').each(function(){
            var datavalue = $(this).val();
            if(datavalue.trim()=='')
            {
                
                validation=1;
               $(this).attr('style','border:1px solid red'); 
            }else{
                
            $(this).attr('style','');      
            }
        });
        var email = $('input[name=enquiry_email]').val();
        
        if (validateEmail(email)) {
       $('input[name=enquiry_email]').attr('style','');   
  } else {
   
     $('input[name=enquiry_email]').attr('style','border:1px solid red'); 
      validation=1;
  }
  
  
  var phoneno = /^\d{10}$/;
  var phone =$('input[name=enquiry_phone]').val();
  if(phone.match(phoneno))
        {
                 $('input[name=enquiry_phone]').attr('style','');    

        }
      else
        {
        $('input[name=enquiry_phone]').attr('style','border:1px solid red'); 
      validation=1;
        }
        
        
        if(validation==1)
        {
            
            return false;
        }
        
    }
    
    function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
</script>