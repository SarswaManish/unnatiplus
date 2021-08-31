<?php  use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$resCartInfo =  $this->request->getSession()->read('CART'); 
$rowAdminInfo =  $this->request->getSession()->read('USER');
$resAddressList =$conn->execute('SELECT * FROM sk_address_book WHERE 1  AND ab_user_id='.(int)$rowAdminInfo['user_id'].' ')->fetchAll('assoc');
$resStateList =$conn->execute('SELECT * FROM sk_shipping INNER JOIN sk_state ON state_id=shipping_state WHERE 1 AND shipping_status=1   ORDER BY state_name')->fetchAll('assoc');
?>
<section>
<div class="container-fluid">
<div class="prod-list-section">
<?= $this->element('myaccount');?>
<div class="pls-right">
<div class="my-pro-contetnt">
<div class="my-pro-contetnt-body">
<ul class="breadcrum mb-10">
<li><a href="#"><i class="fa fa-home"></i></a></li>
<li><a href="#">My Account</a></li>
<li><a href="javascript:;">Manage Address</a></li>
</ul>
<div class="my-pro-contetnt-title"> Manage Address</div>
<?php  echo $this->Flash->render(); ?>
<div class="row mt-20"> 
<?php if(count($resAddressList)>0) {
foreach($resAddressList as $rowAddressList)
{
$rowAddressList =(object) $rowAddressList;
?>
<div class="col-lg-4 mb-15" >
<div class="address-select" style="width:100%; margin:0;">
<div class="check-box">
<input type="radio" <?php if($rowAddressList->ab_default==1) { ?>checked<?php } ?> name="ab_default">
</div>
<div class="address-select-content">
<p><strong><?php echo $rowAddressList->ab_name; ?> </strong></p>
<p><strong>Phone Number:</strong> <?php echo $rowAddressList->ab_phone; ?></p>
<p class="mb-10"> <?php echo $rowAddressList->ab_address; ?>,<?php echo $rowAddressList->ab_landmark; ?>, <br><?php echo $rowAddressList->ab_locality; ?>, <?php echo $rowAddressList->ab_city; ?>, <?php echo $rowAddressList->ab_state; ?></p>
<a href="javascript:void(0);" onclick="$('#addressform').show();setEditData($(this))" data-json='<?php echo json_encode($rowAddressList); ?>' style="color:#eb268f; font-weight:bold; margin-right:5px;">EDIT</a>
<a href="<?php echo SITE_URL;?>my-account/deleteAddress/<?php echo $rowAddressList->ab_id;?>"  onclick="return confirm('Are you want to sure Delete Address?');"   style="color:#eb268f; font-weight:bold;">DELETE</a>
</div>
</div>
</div>
<?php } } ?>
</div>
<div class="row mt-20"> 
<div class="col-lg-12">
<a href="javascript:;" onclick="$('#addressform').show();setnewaddress()"  class="add-new">Add New Address</a>
</div>
</div>
<div class="lr-box mt-20" id="addressform" style="display:none">
<?php echo  $this->Form->create('', ['type' => 'POST','id'=>'profileupdate','url'=>'','class'=>'']); ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter Name" name="ab_name"> 
            </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Mobile Number</label>
                <input type="text" class="form-control" placeholder="Enter Mobile Number" name="ab_phone">
                <input type="hidden"  name="ab_user_id" value="<?php echo $rowAdminInfo['user_id']; ?>">
                <input type="hidden"  name="ab_id" value="0"> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Pincode</label>
                <input type="text" class="form-control" placeholder="Enter Pincode" name="ab_pincode"> 
            </div>
        </div>
        <div class="col-lg-6">
            <div class="lr-form-box">
                <label>Locality</label>
                <input type="text" class="form-control" placeholder="Enter Locality" name="ab_locality"> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="lr-form-box">
                <label> Address</label>
                <textarea name="ab_address" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label>City/District/Town</label>
                <input type="text" class="form-control" placeholder="Enter City/District/Town" name="ab_city">
               
            </div>
        </div>
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label>State</label>
                 <select name="ab_state" class="form-control">
                    <option>Select State</option>
                    <?php foreach($statesList as $rowStateList)
                    { ?>
                    <option value="<?php echo $rowStateList['state_name']; ?>"><?php echo $rowStateList['state_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label>Landmark (Optional)</label>
                <input type="text" placeholder="Enter Landmark" class="form-control"  name="ab_landmark"> 
            </div>
        </div>
        <div class="col-lg-3">
            <div class="lr-form-box">
                <label>Alternate Phone (Optional)</label>
                <input type="text" placeholder="Enter Alternate Phone (Optional)" class="form-control" name="ab_alternate_phone">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="lr-form-box">
              <button type="submit" onclick="return checkaddressbook($(this))" class="btn btn-success">Save</button>
            </div>
        </div>

    </div> 
<?php echo  $this->Form->end(); ?>
</div>
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
