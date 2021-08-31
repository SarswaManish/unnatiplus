var base_url = 'https://codexosoftware.live/unnatiplus/';
var _csrf_token ='';
    function setregistrationotp(objectElement)
    {
 
        var usermobile = $('#user_mobile_number').val(); 
        if(usermobile.trim()=='')
        {
            $('#user_mobile_number').attr('style',' border-bottom: 1px solid red;');
            return false;
        }else{
            var phoneno = /^\d{10}$/;
            if(usermobile.match(phoneno))
            {
                $('#user_mobile_number').attr('style',' border-bottom: 1px solid #ccc;');
            }else{
                $('#user_mobile_number').attr('style',' border-bottom: 1px solid red;');
            return false;     
            }
        }
        $('#register_spinner').show();
        var datastring= $('#registerform').serialize();
        $.post(base_url+'home/registeruser',datastring,function(response){
        var jsondata = JSON.parse(response);  
        if(jsondata.message=='ok')
        {
            $('#registerform').hide();
            $('#otp-success').html(jsondata.notification);
            $('#otp-success').show();
            $('#user_id_otp').val(jsondata.user_id);
            $('#otp').show();
            $('#register_spinner').hide();
        }else{
            $('#register-error').html(jsondata.notification);   
            $('#register-error').show();
            $('#register_spinner').hide();
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
        var datastring =$('#otpform').serialize();
        $.post(base_url+'home/verifyotp',datastring,function(response){
        var jsondata = JSON.parse(response);
        if(jsondata.message=='ok')
        {
            $('#otp-success').html(jsondata.notification);
            $('#otp-success').show();
            window.location.href=base_url;
        }else{
            $('#otp-error').html(jsondata.notification);
            $('#otp-error').show();
            $('#otp_spinner').hide();
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
          if (distance < 0) {
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
            $('#otp-success').html(jsonparsedata.notification);
            $('#otp-success').show();
        }
        settimerdata();
        });
    }
/**************************Google Plus For SignIN***************************/

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log(profile);
    var googleid =profile.getId();
    var googlename = profile.getName();
    var googleimage = profile.getImageUrl();
    var googleemail = profile.getEmail();
    
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
    $('#signin').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
    var datestring='user_googleplus_id='+googleid+'&user_name='+googlename+'&user_profile_image='+googleimage+'&user_email='+googleemail+'&_csrfToken='+_csrf_token;
    $.post(base_url+'home/googlepluslogin',datestring,function(response){
    var jsonparser =JSON.parse(response);
    if(jsonparser.message=='ok')
    {
    window.location.href=base_url;
    }else{
    alert("Some turble here please try after some time");
    }
});
signOut();
}
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
}

$("#signin").on('click', function() {
	// API call for Google login
	gapi.auth2.getAuthInstance().signIn().then(
		function(success) {
			// Login API call is successful	
                  console.log(success);
                       onSignIn(success);
		},
		function(error) {
			// Error occurred
			  console.log(error);
			  
			  ////to find the reason
		}
	);
});
/**************************Google Plus  LOGIN **********************/

/**************************Google Plus For SignUp***************************/

function onSignUp(googleUser) {
    var profile = googleUser.getBasicProfile();
    var googleid =profile.getId();
    var googlename = profile.getName();
    var googleimage = profile.getImageUrl();
    var googleemail = profile.getEmail();
    
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
    $('#signup').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
    var datestring='user_google_id='+googleid+'&user_first_name='+googlename+'&user_image='+googleimage+'&user_email_id='+googleemail+'&_csrfToken='+_csrf_token;
    $.post(base_url+'home/googlepluslogin',datestring,function(response){
    var jsonparser =JSON.parse(response);
    if(jsonparser.message=='ok')
    {
    window.location.href=base_url;
    }else{
    alert("Some turble here please try after some time");
    }
});
signOut();
}
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
}

$("#signup").on('click', function() {
	// API call for Google login
	gapi.auth2.getAuthInstance().signIn().then(
		function(success) {
			// Login API call is successful	
                  console.log(success);
                       onSignIn(success);
		},
		function(error) {
			// Error occurred
			// console.log(error) to find the reason
		}
	);
});
/**************************Google Plus  LOGIN **********************/
function loginuser(objectElement)
{
    
    var user_name = $('#username').val(); 
    if(user_name.trim()=='')
    {
        $('#username').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
        $('#username').attr('style','');
    }
    var user_password = $('#password').val(); 
    if(user_password.trim()=='')
    {
        $('#password').attr('style',' border-bottom: 1px solid red;');
        return false;
    }else{
 
      $('#password').attr('style','');
    }
    $('#login_spinner').show();
    var datastring= $('#loginform').serialize();
    $.post(base_url+'home/loginuser',datastring,function(response){
    var jsondata = JSON.parse(response);  
    if(jsondata.message=='ok')
    {
        window.location.href='';
    }else{
        $('#login-error').html(jsondata.notification);   
        $('#login-error').show();
        $('#login_spinner').hide();
    }
});

}
function sendforgotpasswordlink(objectelement)
    {
        var email=$('input[name=user_email_forgot]').val();
        if(email.trim()=='')
        {
            $('input[name=user_email_forgot]').attr('style','border:1px solid red');
            return false;
        }
                objectelement.html('Processing...');

        $('input[name=user_email_forgot]').attr('style','');
        var datastring='user_email='+email;
        $.post(base_url+'home/forgotpassword',datastring,function(response)
        {
                            objectelement.html('Send Email');

            var jsondata=JSON.parse(response);
            if(jsondata.message=='ok')
            {
                $('#forgot-success').html(jsondata.notification);
                $('#forgot-success').show();
                $('input[name=user_email_forgot]').val('');
            }else
            {
                $('#forgot-error').html(jsondata.notification);
                $('#forgot-error').show();
                  $('input[name=user_email_forgot]').val('');
          }
        });
    }
/****************************Forget Password************************/

