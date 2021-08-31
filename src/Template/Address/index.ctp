<?php  use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$rowUserInfo =  $this->request->getSession()->read('USER');
$resCartInfo =  $this->request->getSession()->read('CART'); 

 
  $resAddressList =$conn->execute('SELECT * FROM sk_address_book WHERE 1  AND ab_user_id='.(int)$rowUserInfo['user_id'].' ')->fetchAll('assoc');
  
   $resStateList =$conn->execute('SELECT * FROM sk_shipping INNER JOIN sk_state ON state_id=shipping_state WHERE 1 AND shipping_status=1   ORDER BY state_name')->fetchAll('assoc');

?>

	 <section class="pt-20 pb-20">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ul class="breadcrum mb-20">
<li><a href="<?php echo SITE_URL; ?>">Home</a></li>
<li><a href="javascript:;" style="text-transform: capitalize;">My Address</a></li>
</ul>
</div>
</div>
 		<div class="row">
		<div class="col-lg-3">
		<div class="my-account-header text-center">
<!--	<div class="avtar"><img src="<?php echo SITE_URL; ?>img/avtar.png" alt=""></div>-->
	<div class="avtar-details">
	<div class="name"><?php echo $rowUserInfo['user_first_name'].' '.$rowUserInfo['user_last_name']; ?></div>
	<div class="phone">+91 <?php echo $rowUserInfo['user_mobile']; ?></div>
	<div class="email"><?php echo $rowUserInfo['user_email_id']; ?></div>
	</div>
	</div>
	<div class="list-group">
	<a href="<?php echo SITE_URL; ?>dashboard" class="list-group-item ">My Account</a>
	<a href="<?php echo SITE_URL; ?>order" class="list-group-item ">My Orders</a>
	<a href="<?php echo SITE_URL; ?>address" class="list-group-item active">My Address</a>
    <a href="<?php echo SITE_URL; ?>dashboard/logout" class="list-group-item">Logout</a>
	</div>
		</div>
		<div class="col-lg-9">
				 <?php  echo $this->Flash->render(); ?>

		<div class="pannel-box " style="margin-bottom:20px">

		<div class="pannel-title"><h3>Address Book </h3></div>
			<div class="pannel-body" style="border-bottom: 1px solid #f0f0f0;">
		    <?php if(count($resAddressList)>0) {
		    
		    foreach($resAddressList as $rowAddressList)
		    {
		    $rowAddressList =(object) $rowAddressList;
		    ?>
		<div class="address-select">
		<div class="check-box"><input type="radio" <?php if($rowAddressList->ab_default==1) { ?>checked<?php } ?> name="ab_default"></div>
		<div class="address-select-content">
		<a href="javascript:void(0);" class="pull-right" onclick="$('#addressform').show();setEditData($(this))" data-json='<?php echo json_encode($rowAddressList); ?>' style="color:#eb268f; font-weight:bold;">EDIT</a>
		<p style="margin-bottom:5px;"><strong><?php echo $rowAddressList->ab_name; ?> </strong> <?php echo $rowAddressList->ab_phone; ?></p>
		<p><?php echo $rowAddressList->ab_address; ?>,<?php echo $rowAddressList->ab_landmark; ?>, <br><?php echo $rowAddressList->ab_locality; ?>, <?php echo $rowAddressList->ab_city; ?>, <?php echo $rowAddressList->ab_state; ?></p>
		</div>
		</div>
		<?php } } ?>
		
		
			<a href="javascript:;" onclick="$('#addressform').show();setnewaddress()"  class="button-line place-order-button">Add New Address</a>
		</div>
		
		

		</div>
		<div class="pannel-box" id="addressform" style="display:none">

		<div class="pannel-title"><h3>Add New Address</h3></div>
		<div class="pannel-body" >
                <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'profileupdate','url'=>'/address/addressProcessRequest','class'=>'']); ?>

                <div class="address-form" >
		<div class="row">
		<div class="col-lg-9">
		<div class="row">
		<div class="col-lg-6 address-form-box">
		<label>Name</label>
                <input type="text" placeholder="Enter Name" name="ab_name"></div>
		<div class="col-lg-6">
		<label>10 Digit Mobile Number</label>
		<input type="text" placeholder="Enter Mobile Number" name="ab_phone">
                <input type="hidden"  name="ab_user_id" value="<?php echo $rowUserInfo['user_id']; ?>">
                <input type="hidden"  name="ab_id" value="0">
                </div>
		</div>
		<div class="row">
		<div class="col-lg-6 address-form-box">
		<label>Pincode</label>
		<input type="text" placeholder="Enter Pincode" name="ab_pincode"></div>
		<div class="col-lg-6">
		<label>Locality</label>
		<input type="text" placeholder="Enter Locality" name="ab_locality"></div>
		</div>
		<div class="row">
		<div class="col-lg-12 address-form-box">
		<label>Address</label>
		<textarea name="ab_address"></textarea>
		</div>
		
		</div>
		<div class="row">
		<div class="col-lg-6 address-form-box">
		<label>City/District/Town</label>
		<input type="text" placeholder="Enter City/District/Town" name="ab_city"></div>
		<div class="col-lg-6">
		    <select name="ab_state" class="form-control">
		    <option>Select State</option>
		    <?php foreach($resStateList as $rowStateList)
		    { ?>
		    <option value="<?php echo $rowStateList['state_name']; ?>"><?php echo $rowStateList['state_name']; ?></option>
		    <?php } ?>
		</select>
		
		
	
	    </div>
		</div>
		
		<div class="row">
		<div class="col-lg-6 address-form-box">
		<label>Landmark (Optional)</label>
		<input type="text" placeholder="Enter Landmark" name="ab_landmark"></div>
		<div class="col-lg-6">
		<label>Alternate Phone (Optional)</label>
		<input type="text" placeholder="Enter Alternate Phone (Optional)" name="ab_alternate_phone"></div>
		</div>
		
		</div>
		</div>
		</div>
		<div class="das-form-box">
		<button type="submit" onclick="return checkaddressbook($(this))" class="btn btn-success" style="padding:13px 50px; border-radius:4px;">Save</button>
		</div>
                    <?php echo  $this->Form->end(); ?>
		</div>

		</div>
		</div>
		</div>
	 </div>
	  </section>
	  
<script>


function checkaddressbook(objectElement)
{
    
    var ab_name = $('input[name="ab_name"]').val();
		 if(ab_name.trim()=='')
		 {
			 $('input[name="ab_name"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="ab_name"]').attr('style','');
		 }
                 
        var ab_phone = $('input[name="ab_phone"]').val();
		 if(ab_phone.trim()=='')
		 {
			 $('input[name="ab_phone"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="ab_phone"]').attr('style','');
		 }          
                 
            var ab_pincode = $('input[name="ab_pincode"]').val();
		 if(ab_pincode.trim()=='')
		 {
			 $('input[name="ab_pincode"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="ab_pincode"]').attr('style','');
		 }          
             var ab_locality = $('input[name="ab_locality"]').val();
		 if(ab_locality.trim()=='')
		 {
			 $('input[name="ab_locality"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="ab_locality"]').attr('style','');
		 }                    
                    var ab_address = $('textarea[name="ab_address"]').val();
		 if(ab_address.trim()=='')
		 {
			 $('textarea[name="ab_address"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('textarea[name="ab_address"]').attr('style','');
		 }  
                  var ab_city = $('input[name="ab_city"]').val();
		 if(ab_city.trim()=='')
		 {
			 $('input[name="ab_city"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('input[name="ab_city"]').attr('style','');
		 }  
                  var ab_state = $('select[name="ab_state"]').val();
		 if(ab_state.trim()=='')
		 {
			 $('select[name="ab_state"]').attr('style','border:1px solid red;');
		 return false;	 
		 }else{
			  $('select[name="ab_state"]').attr('style','');
		 }  
     objectElement.html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i> Save');	

    
}

function setEditData(objectElement)
{
    var Jsonparse = JSON.parse(objectElement.attr('data-json'));
    $('input[name="ab_name"]').val(Jsonparse.ab_name);
    $('input[name="ab_phone"]').val(Jsonparse.ab_phone);
    $('input[name="ab_pincode"]').val(Jsonparse.ab_pincode);
    $('select[name="ab_state"]').val(Jsonparse.ab_state);
    $('input[name="ab_city"]').val(Jsonparse.ab_city);
     $('textarea[name="ab_address"]').val(Jsonparse.ab_address);
     $('input[name="ab_locality"]').val(Jsonparse.ab_locality);
     $('input[name="ab_pincode"]').val(Jsonparse.ab_pincode);
     $('input[name="ab_phone"]').val(Jsonparse.ab_phone);
     $('input[name="ab_id"]').val(Jsonparse.ab_id);
     $('input[name="ab_landmark"]').val(Jsonparse.ab_landmark);
     $('input[name="ab_alternate_phone"]').val(Jsonparse.ab_alternate_phone);


}

function setnewaddress()
{
    $('input[name="ab_name"]').val('');
    $('input[name="ab_phone"]').val('');
    $('input[name="ab_pincode"]').val('');
    $('select[name="ab_state"]').val('');
    $('input[name="ab_city"]').val('');
     $('textarea[name="ab_address"]').val('');
     $('input[name="ab_locality"]').val('');
     $('input[name="ab_pincode"]').val('');
     $('input[name="ab_phone"]').val('');
          $('input[name="ab_id"]').val(0);
          $('input[name="ab_landmark"]').val('');
     $('input[name="ab_alternate_phone"]').val('');

}

</script> 