
<section>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-lg-4">
<div class="my-pro-contetnt" style="min-height:auto">
<div class="my-pro-contetnt-body">
<div class="lr-box text-center">
 <img src="<?= SITE_URL?>assets/img/checked.png" style="width:100px;">
 <h3>ORDER SUCCESSFULL</h3>
			<p>Order id: <?php echo $this->request->getSession()->read('tarns_booking_id'); 
			$this->request->getSession()->delete('tarns_booking_id'); 

			?>
</p>

			  		<a href="<?= SITE_URL?>" style="margin-top:20px;" class="btn btn-success">keep shopping</a>

 
</div>
</div>
</div>
</div>
</div>
</div>

</section>
 