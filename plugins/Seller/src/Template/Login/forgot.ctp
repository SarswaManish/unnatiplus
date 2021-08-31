<body class="login-container" style="background:url(/admin/images/backgrounds/seamless.png);">
		<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="content">
					<form action="javascript:void(0);" method="post" id="forgotpassword">
						<div class=" panel-body login-form">
							<div class="text-center">
								<img src="/admin/images/shopaccino-cart-logo.png" style="width:180px">
								<h3 class="content-group"><strong>Forgot  your online store</strong><small class="display-block">Enter your credentials below</small></h3>
							</div>
							<div class="alert alert-warning no-border hide" id="forgot-error">
										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Warning!</span> Email id and password are incorrect.
								    </div>
								<div class="alert alert-success no-border hide" id="forgot-success">
										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Success!</span> Redirecting...
								    </div>	    
							<div class="form-group has-feedback has-feedback-left">
								<input type="text" id="user_email"  name="user_gmail" class="form-control" placeholder="xyz@account.com" style="height:45px;">
								
								<div class="form-control-feedback" style="line-height:45px;">
									<i class="icon-envelop2 text-muted"></i>
								</div>
								<span class="help-block hide">This field is required.</span>
							</div>
                               <!--has-error-->
							

							<div class="form-group">
								<button type="submit" onclick="return ForgotAdminProcess($(this))" class="btn btn-primary btn-block" style="font-size:17px"><i class="icon-spinner2 spinner position-left hide"></i>Reset </button>
							</div>

							<div class="text-center">
								Do You Have remember? <a href="<?php echo $this->Url->build('/admin/', true); ?>">Login</a>
							</div>
						</div>
					</form>
					<!-- /simple login form -->


					<!-- Footer -->
					<div class="footer text-muted text-center">
						&copy; 2018. Thunder e-Commerce Solution Pvt. Ltd.
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