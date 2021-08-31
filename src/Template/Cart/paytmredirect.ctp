<section class="bg-gray">
<div class="container">
<div class="row">
<div class="col-lg-2"></div>
<div class="col-lg-8">
<div class="extra-t-box text-center">


<img src="<?= SITE_URL; ?>img/Paytm_logo.png" style="width:150px"/>
<h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
		document.f1.submit();
		</script>
	</form>


</div>
</div>
<div class="col-lg-2"></div>
</div>
</div>
</section>
	