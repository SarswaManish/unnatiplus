var baseurl = 'https://www.jiyohome.com/';
function getloginstatus(objectElement)
{
    var phoneds = $('.clsmobilenumber').val();
    if(!phoneds.match(phoneno))
    {
          return false;
    }
    
    
    $('#textnextspinner').hide();
     $('#loginnextspinner').show();
   
    var datastring = 'phonenumber='+phoneds;
    $.post(baseurl+'home/logincheck',datastring,function(response){
        var jd = JSON.parse(response);
        if(jd.message=='ok')
        {
              $('.clsloginfirst').hide();
                  $('.clslogintwo').show();
$('#mobile_number_login').val(phoneds);
        
        }else  if(jd.message=='new')
        {
          $('.clsloginfirst').hide();
          $('.clsotpone').show();
          $('#phonenumberforotp').html(phoneds);
       }
    });
}
function loginuser(objectElement)
{
    
     var password = $('#user_password').val();
     if(password.trim()=='')
     {
         $('#loginuserpassword').html('Please Enter Password');
         $('#loginuserpassword').show();
         return false;
     }
      if(password.trim().length<6)
     {
                  $('#loginuserpassword').html('Please Enter Password greater than and equals to 6');
                    $('#loginuserpassword').show();

         return false;
     }
    

     $('#loginuserpassword').hide();
     $('#loginspinnertext').hide();
     $('#loginspinner').show();
     var datastring = 'username='+ $('#mobile_number_login').val()+'&password='+$('#user_password').val();
    $.post(baseurl+'home/loginUser',datastring,function(response){
        var jd =JSON.parse(response);
         if(jd.message=='ok')
         {
             window.location.href="";
         }else{
           $('#loginuserpassword').html(jd.notification);
                    $('#loginuserpassword').show();  
                     $('#loginspinnertext').show();
     $('#loginspinner').hide();
         }
     });
}
function resendotp(object)
{
    var datastring = '';
    $.post(baseurl+'home/resentotp',datastring,function(response){
        var jd =JSON.parse(response);
         $('#resendotpsuccess').html(jd.notification);
         $('#resendotpsuccess').show();
     });
}
function enableotpbutton(clsname)
{
    $('.'+clsname).focus();
    var cnt=0;
    $('.otp-input').each(function(){
        if($(this).val()=='')
        {
           cnt++; 
        }
    });
    
     if(cnt==0)
    {
        $('.clsotpbutton').removeClass('bt-gray');
        $('.clsotpbutton').addClass('bt-green');
    }else{
       $('.clsotpbutton').removeClass('bt-green');
        $('.clsotpbutton').addClass('bt-gray');   
    }
    
}

function verifyotp()
{
    ///alert();
    var cnt=0;
    var arotp = [];
    $('.otp-input').each(function(){
        arotp.push($(this).val());
        if($(this).val()=='')
        {
           cnt++; 
        }
    });
     if(cnt!=0)
    {
       return false;
    }
      $('#textotpspinner').hide();
         $('#loginotpspinner').show();  
    var datastring = 'arotp='+arotp.join('');
    $.post(baseurl+'home/verifyotp',datastring,function(response){
        var jd = JSON.parse(response);
        if(jd.message=='ok')
        {
            if(jd.result.user_status==1)
            {
                
            window.location.href="";
            }else{
         $('.clsotpone').hide();
         $('.clsregisterone').show();
         $('#mobile_number_register').val(jd.result.user_mobile);
            }
        }else{
            
            $('#otperror').html(jd.notification);
               $('#otperror').show();
          $('#textotpspinner').show();
         $('#loginotpspinner').hide();  
        }
       
    });
 
           
          
}

function registerprocess()
{
    
    var first_name =$('#user_firstname').val();
    if(first_name.trim()=='')
    {
       $('#user_firstname').attr('style','border:1px solid red'); 
        return false;
    }else{
         $('#user_firstname').attr('style',''); 
    }
    var first_name =$('#user_lasttname').val();
    if(first_name.trim()=='')
    {
       $('#user_lasttname').attr('style','border:1px solid red'); 
        return false;
    }else{
         $('#user_lasttname').attr('style',''); 
    }
    var first_name =$('#user_email').val();
    if(first_name.trim()=='')
    {
       $('#user_email').attr('style','border:1px solid red'); 
        return false;
    }else{
         $('#user_email').attr('style',''); 
    }
      var mobile_number_register =$('#mobile_number_register').val();
    if(mobile_number_register.trim()=='')
    {
       $('#mobile_number_register').attr('style','border:1px solid red'); 
        return false;
    }else{
         $('#mobile_number_register').attr('style',''); 
    }
     var user_password_register =$('#user_password_register').val();
    if(user_password_register.trim()=='')
    {
       $('#user_password_register').attr('style','border:1px solid red'); 
        return false;
    }else{
         $('#user_password_register').attr('style',''); 
    }
    if(user_password_register.length<6)
    {
          $('#password_error_message').remove();
       $('#user_password_register').after('<span style="padding-bottom: 10px; color: red;float: left;" id="password_error_message">Password Must be greater than 6 or equal to 6</span>'); 
        return false;
    }else{
          $('#password_error_message').remove();
    }

 
     $('#textregisterspinner').hide();
         $('#registerspinner').show();  
         var datastring = $('#registerdetail').serialize();
         $.post(baseurl+'home/registeruser',datastring,function(response){
             
             window.location.href="";
         });
    
}

function requestotp()
{
      var datastring = '';
         $.post(baseurl+'home/requestotp',datastring,function(response){
             var jd = JSON.parse(response);
             if(jd.mobile_number!='')
             {
               $('.clslogintwo').hide();
          $('.clsotpone').show();
          $('#phonenumberforotp').html(jd.mobile_number);
             }
         
            
         });
}