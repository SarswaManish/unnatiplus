/******************
 * ENV JS CREATED BY Manish Garg 
 * 2018-09-12
 * purpose - for Project Enviourment
******************/
function LoginAdminProcess (objectElement)
{
  $('.spinner').removeClass('hide');
    var status=0;
    var user_name =$('#user_gmail').val();
	if(user_name.trim()=='')
	{
	$('#user_gmail').parents('.form-group').addClass('has-error');
	$('#user_gmail').parents('.form-group').find('.help-block').removeClass('hide');
    $('.spinner').addClass('hide');
    status=1;
	}
	var password =$('#user_password').val();
	if(password.trim()=='')
	{
	$('#user_password').parents('.form-group').addClass('has-error');
	$('#user_password').parents('.form-group').find('.help-block').removeClass('hide');
    $('.spinner').addClass('hide');
    status=1;
	}
	if(status==1)
	{
		return false;
	}
	var datastring =$('#login-form').serialize();
	$.post(site_url+"login/loginAdminProcess",datastring,function(response){
	    
	  var jsonparsedata = JSON.parse(response);
	  if(jsonparsedata.message=='ok')
	  {
	       $('#login-error').addClass('hide');	
	      $('#login-success').removeClass('hide');
	      window.location=site_url+"dashboard";
	  }else{
	      $('.spinner').addClass('hide');
 	      $('#login-success').addClass('hide');
	      $('#login-error').removeClass('hide');	
	      }
	});
	 
	
}
$('#user_gmail').keyup(function(){
    
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val()))
  {
	$('#user_gmail').parents('.form-group').removeClass('has-error');
   	$('#user_gmail').parents('.form-group').addClass('has-success');
	$('#user_gmail').parents('.form-group').find('.help-block').addClass('hide');
  }else{
      
       
      var phoneno = /^\d{10}$/;
  if($(this).val().match(phoneno))
        { 
   	$('#user_gmail').parents('.form-group').removeClass('has-error');
   	$('#user_gmail').parents('.form-group').addClass('has-success');
	$('#user_gmail').parents('.form-group').find('.help-block').addClass('hide');
        }else{
            
           $('#user_gmail').parents('.form-group').addClass('has-error');
	$('#user_gmail').parents('.form-group').find('.help-block').removeClass('hide');  
        }
  }
});
$('#user_password').keyup(function()
{
    if ($(this).val().trim()!='')
  {
	$('#user_password').parents('.form-group').removeClass('has-error');
   	$('#user_password').parents('.form-group').addClass('has-success');
	$('#user_password').parents('.form-group').find('.help-block').addClass('hide');
  }else{
    $('#user_password').parents('.form-group').addClass('has-error');
	$('#user_password').parents('.form-group').find('.help-block').removeClass('hide');
  }
});

$('#user_email').keyup(function(){
    
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val()))
  {
	$('#user_email').parents('.form-group').removeClass('has-error');
   	$('#user_email').parents('.form-group').addClass('has-success');
	$('#user_email').parents('.form-group').find('.help-block').addClass('hide');
  }else{
      
      var phoneno = /^\d{10}$/;
  if($(this).val().match(phoneno))
        {
            
            	$('#user_email').parents('.form-group').removeClass('has-error');
   	$('#user_email').parents('.form-group').addClass('has-success');
	$('#user_email').parents('.form-group').find('.help-block').addClass('hide');
            
        }else{
    $('#user_email').parents('.form-group').addClass('has-error');
	$('#user_email').parents('.form-group').find('.help-block').removeClass('hide');
        }
  }
});
function ForgotAdminProcess (objectElement)
{
  $('.spinner').removeClass('hide');
    var status=0;
    var user_name =$('#user_email').val();
	if(user_name.trim()=='')
	{
	$('#user_email').parents('.form-group').addClass('has-error');
	$('#user_email').parents('.form-group').find('.help-block').removeClass('hide');
    $('.spinner').addClass('hide');
    status=1;
	}

	if(status==1)
	{
		return false;
	}
	
}