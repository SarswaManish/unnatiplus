

    <div class="navbar-collapse collapse" id="navbar-mobile">
      
<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?php echo SITE_URL; ?>">
						<i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Go to website</span>
					</a>
				</li>

				
			</ul>
        
     
    </div>
  </div>
  <!-- /main navbar -->


  <!-- Page container -->
  <div class="page-container">

    <!-- Page content -->
    <div class="page-content">

      <!-- Main content -->
      <div class="content-wrapper">

        <!-- Content area -->
        <div class="content">

          <!-- Simple login form -->
		
          <?php echo  $this->Form->create('login', ['type' => 'POST','id'=>'login']); ?>
            <div class="panel panel-body login-form">
              <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
              </div>
  <div id="warning" style="display:none" class="alert alert-warning">
  <strong>Warning!</strong> Invalid Login Credentials.
</div>
<div class="alert alert-success" id="success" style="display:none">
  <strong>Success!</strong> login Successfully.
</div>
              <div class="form-group has-feedback has-feedback-left">
 <?php echo $this->Form->control('', array('type' => 'text','placeholder'=>'Username','required'=>'required','class'=>'form-control','name'=>'username','label'=>false)); ?>                <div class="form-control-feedback">
                  <i class="icon-user text-muted"></i>
                </div>
              </div>

              <div class="form-group has-feedback has-feedback-left">
			  			 <?php echo $this->Form->control('', array('type' => 'password','placeholder'=>'Password','required'=>'required','class'=>'form-control','name'=>'password','label'=>false)); ?>
                <div class="form-control-feedback">
                  <i class="icon-lock2 text-muted"></i>
                </div>
              </div>

              <div class="form-group">
               
				 <?php echo $this->Form->control('Login', array('type' => 'submit','class'=>'btn btn-primary btn-block','label'=>false,'div'=>false,'onclick'=>'userlogin($(this))')); ?>
              </div>

              <div class="text-center">
                <!--<a href="login_password_recover.html">Forgot password?</a>-->
              </div>
            </div>
         <?php echo  $this->Form->end(); ?>
          <!-- /simple login form -->


          <!-- Footer -->
          <div class="footer text-muted text-center">
            &copy; 2018. <a href="#"><?php echo SITE_TITLE; ?></a> by <a href="http://codexosoftware.com" target="_blank"><?php echo 'codexosoftware.com'; ?></a>
          </div>
          <!-- /footer -->

        </div>
        <!-- /content area -->

      </div>
      <!-- /main content -->

    </div>
    <!-- /page content -->

  </div>
  <!-- /page container -->
<?php echo $this->Html->scriptStart(array('inline' => false)); ?>
	$(document).ready(function(){
	
	$('#login').attr('action','javascript:void(0)');
	});
function userlogin(objectElement)
{
var dataString= $('#login').serialize();
$.post('<?php echo SITE_URL; ?>admin/login/loginAdminProcess',dataString,function(response)
	{
	var object= jQuery.parseJSON(response);
		if(object.message=='failed')
		{
		$('#success').attr('style','display:none');
		$('#warning').show();
		}
		else
		{
		$('#warning').attr('style','display:none');
		$('#success').show();
		window.location = "<?php echo SITE_URL;?>admin/dashboard";
		
		}
	});

}

<?php echo $this->Html->scriptEnd(); ?>
</body>