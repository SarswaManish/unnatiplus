<body class="login-container" style="background:url(/unnatiplus/admin/images/backgrounds/seamless.png);">
		<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="content">
<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'login-form','url'=>'javascript:void(0);']); ?>
						<div class=" panel-body login-form">
							<div class="text-center">
								<img src="<?php echo SITE_URL; ?>admin/images/logored.png" style="width:40%">
								<h3 class="content-group"><strong>Login to your online store</strong><small class="display-block">Enter your credentials below</small></h3>
							</div>
							<div class="alert alert-warning no-border hide" id="login-error">
										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Warning!</span> Email id and password are incorrect.
								    </div>
								<div class="alert alert-success no-border hide" id="login-success">
										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Success!</span> Redirecting...
								    </div>
							    
							<div class="form-group has-feedback has-feedback-left">
								<input type="text" id="user_gmail"  name="user_email" class="form-control" placeholder="xyz@account.com" style="height:45px;">
								
								<div class="form-control-feedback" style="line-height:45px;">
									<i class="icon-envelop2 text-muted"></i>
								</div>
								<span class="help-block hide">This field is required.</span>
							</div>
                               <!--has-error-->
							<div class="form-group has-feedback has-feedback-left ">
								<input type="password" id="user_password" name="user_password" class="form-control" placeholder="Enter Your Password" style="height:45px;">
								<div class="form-control-feedback" style="line-height:45px;">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<span class="help-block hide">This field is required.</span>
							</div>

							<div class="form-group">
								<button type="submit" onclick="return LoginAdminProcess($(this))" class="btn btn-primary btn-block" style="font-size:17px"><i class="icon-spinner2 spinner position-left hide"></i>Login </button>
							</div>

							<div class="text-center" style="display:none">
								<a href="<?php echo $this->Url->build('/admin/login/forgot', true); ?>">Forgot password?</a>
							</div>
						</div>
				    <?= $this->Form->end() ?>
					<!-- /simple login form -->


					<!-- Footer -->
					<div class="footer text-muted text-center">
						&copy; 2019. <?php echo SITE_TITLE; ?>
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

</body>