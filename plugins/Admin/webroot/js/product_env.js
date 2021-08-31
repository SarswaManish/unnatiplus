function getproductslug(strProductName)
{
    if(strProductName!='')
    {
        var lower_product_name = strProductName.toLowerCase();
        var strreplace_product_name = lower_product_name.replace(/,/g,'');
      var strreplace_product_name = strreplace_product_name.replace(/&/g,'');
      var split_product_name = strreplace_product_name.split(' ');
      var join_product_name = split_product_name.join('-');
        $('#permalink_product').html(base_url+'product-detail/<span id="hidewhenedit">'+join_product_name+'</span>');
        $('#permalink_product').attr('href',base_url+'product-detail/'+join_product_name);
        $('#permalink_val').val(join_product_name);
        $('#preview-product').attr('href',base_url+'product-detail/'+join_product_name);
        $('#seo_title').html(strProductName);
    }
    
    
}
function editpermalink()
{
    $('#hidewhenedit').addClass('hide');
    $('#permalink_val').removeClass('hide');
    $('#permalink_ok').removeClass('hide');
    $('#permalink_edit').addClass('hide');
    $('#permalink_cancel').removeClass('hide');
}
function okpermalink()
{
    $('#hidewhenedit').removeClass('hide');
    $('#permalink_val').addClass('hide');
    $('#permalink_ok').addClass('hide');
    $('#permalink_cancel').addClass('hide');
    $('#permalink_edit').removeClass('hide');
    $('#permalink_product').html(base_url+'product-detail/<span id="hidewhenedit">'+$('#permalink_val').val()+'</span>');
    $('#permalink_product').attr('href',base_url+'product-detail/'+$('#permalink_val').val());
    $('#permalink_val').val($('#permalink_val').val());
    $('#preview-product').attr('href',base_url+'product-detail/'+$('#permalink_val').val())

}
function getNetPrice(discountValue)
{
    var sellingprice = $('input[name=product_selling_price]').val();
    if(sellingprice<=0)
    {
       $('input[name=product_selling_price]').parents().parents().parents('.form-group').addClass('has-error'); 
       
    }else{
         $('input[name=product_selling_price]').parents().parents().parents('.form-group').removeClass('has-error'); 
        var netprice = parseFloat(parseFloat(sellingprice)-parseFloat(discountValue));
        $('input[name=product_net_price]').val(netprice);
                 $('#net_business_price').html("₹"+netprice);

    }
}
function getNetPriceDuplicate(sellingprice)
{
    var discountprice = $('input[name=product_discount_selling]').val();
    if(discountprice<=0)
    {
       $('input[name=product_net_price]').val(sellingprice);
         $('#net_business_price').html("₹"+sellingprice);
       
    }else{
      
        var netprice = parseFloat(parseFloat(sellingprice)-parseFloat(discountValue));
        $('input[name=product_net_price]').val(netprice);
        $('#net_business_price').html("₹"+netprice);
        
    }
}
function changeseop()
{
    var seotitle = $('#product_meta_title').val();
    if(seotitle.length>70)
    {
   $('#product_meta_title').parents().parents().parents('form-group').addClass('has-error');     
        
    }
    var seodesc = $('#product_meta_desc').val();
    if(seotitle.length>250)
    {
   $('#product_meta_title').parents().parents().parents('form-group').addClass('has-error');     
        
    }
    if(seotitle!='')
    {
        $('#seo_title').html(seotitle);
        
    }
     if(seodesc!='')
    {
        $('#seo_description').html(seodesc);
        
    }
    $('#seo_url').html($('#permalink_product').html());
}
 function changePicture(strImageId) {
        document.getElementById('product_image').click();
        var link = document.getElementById('product_image').url;
       $('#product_image').attr('data-id',strImageId);
    }
document.getElementById('product_image').onchange = function (evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            var fileName = evt. target. files[0]. name;
var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

if(ext == "jpg" || ext == "png" || ext == "jpeg")
{
 $('#image-error').addClass('hide');

} else{
    $('#image-error').removeClass('hide');
$('#product_image').val('');
return false;
}
$('.img-upload').attr('style','height:auto');

            document.getElementById($('#product_image').attr('data-id')).src = fr.result;
            $('#'+$('#product_image').attr('data-id')+'-icon').addClass('hide');
            $('#'+$('#product_image').attr('data-id')).removeClass('hide');
            
            $('#progressbarshow').removeClass('hide');
move();

var file_data = $('#product_image').prop('files')[0]; 
var form_data = new FormData();    
form_data.append('product_image', file_data);	
form_data.append('_csrfToken', csrf_tocken);	


$.ajax({
url: base_url+'admin/product/uploadImage/', // point to server-side PHP script 
dataType: 'text',  
cache: false,
contentType: false,
processData: false,
data: form_data,                         
type: 'post',
success: function(php_script_response){
var jsondata = JSON.parse(php_script_response);
if(jsondata.message=='ok')
{
    var dataid = $('#product_image').attr('data-id');
    $('#product_'+dataid+'_upload').remove();
    $('#'+dataid).after('<input type="hidden" id="product_'+dataid+'_upload" name="product_'+dataid+'" value="'+jsondata.name+'">');
    $('#image-error').addClass('hide')
}else{
    
    $('#image-error').removeClass('hide');
    
}
        $('#product_image').val('');

}
});  
}
        fr.readAsDataURL(files[0]);
    }

    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
}
function move() {
    var elem = document.getElementById("myBar"); 
    var width = 1;
    var id = setInterval(frame, 40);
    function frame() {
        if (width >= 100) {
            clearInterval(id);
      //   $('#myProgress').hide(1000);

        } else {
            width++; 
            elem.style.width = width + '%'; 
            $('#title-percent').html(width+'% Complete');
        }
    }
}   
function addMoreBusinessPrice(objElement)
{
    var strHtmlContent ='<div class="row clsparentrow"><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Quantity: <span style="color:red">*</span></label><div><div class="input text required"><input name="pbp_qty[]" onkeyup="getnetbusinessprice($(this))" id="qty_business" placeholder="eg:1,2,3"  class="form-control" value="" type="text"></div><span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Quantity discounts: </label><div><div class="input-group"><input class="form-control" placeholder="Discounts" onkeyup="getnetbusinessprice($(this))" id="discount_business" name="pbp_discount[]" type="text"><span class="input-group-addon">%</span></div></div></div></div><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">&nbsp;</label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" id="netprice_business" placeholder="0.00" name="pbp_net_price[]" type="text"></div><span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">&nbsp;</label><div class="div-addmore-business"><button type="button" onclick="addMoreBusinessPrice($(this))" class="btn btn-info btn-xs"><i class="icon-plus2" ></i> Add More</button></div></div></div></div>';
       $('#replacebusinessprice').append(strHtmlContent);
       objElement.parents('.div-addmore-business').html('<button type="button" onclick="removeBusinessPrice($(this))" class="btn btn-danger btn-xs"><i class="icon-cross3" ></i> Remove</button>');
    
}
function removeBusinessPrice(objectelement)
{
    var confirmdata = confirm('Are you want to sure to remove');
    if(confirmdata)
    {
    objectelement.parents().parents().parents().parents('.clsparentrow').remove();
    }
}
function addMoreFixedPrice(objElement)
{
    var strHtmlContent ='<div class="row clsparentrow"><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Quantity: <span style="color:red">*</span></label><div><div class="input text required"><input name="pbp_qty_[]" onkeyup="return getslug($(this))" placeholder="eg:1,2,3" required="required" class="form-control" id="category_name" value="" type="text"></div><span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Price</label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" placeholder="0.00" name="pbp_net_price_[]" type="text"></div><span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">&nbsp;</label><div class="div-addmore-fixed"><button type="button" onclick="addMoreFixedPrice($(this))" class="btn btn-info btn-xs"><i class="icon-plus2" ></i> Add More</button></div></div></div></div>';
       $('#replaceFixedprice').append(strHtmlContent);
       objElement.parents('.div-addmore-fixed').html('<button type="button" onclick="removeBusinessPrice($(this))" class="btn btn-danger btn-xs"><i class="icon-cross3" ></i> Remove</button>');
    
}
function getnetbusinessprice(objectElement)
{
    var sellingprice = objectElement.parents().parents().parents().parents().parents('.clsparentforremove').find('#sellingprice').val();
    var discount = objectElement.parents().parents().parents().parents().parents('.clsparentforremove').find('#discount_business').val();
    if(sellingprice<=0)
    {
     objectElement.parents().parents().parents('.form-group').addClass('has_error');
     return  false;
     }else{
     objectElement.parents().parents().parents('.form-group').removeClass('has_error');    
     }
     //var netprice =$('input[name=product_net_price]').val();

      if(discount<=0)
    {
      objectElement.parents().parents().parents().parents().parents('.clsparentforremove').find('#netprice_business').val(sellingprice);
     }else{
       
     objectElement.parents().parents().parents().parents().parents('.clsparentforremove').find('#netprice_business').val(parseFloat(parseFloat(sellingprice)-parseFloat(discount)));   
         
     }
}
    if(editProductId>0)
    {
      changeseop();  
    }
function setcheckedstatus(objectElemen)
{
    if(objectElemen.prop('checked'))
    {
        objectElemen.parents('span').addClass('checked');
    }else{
        
          objectElemen.parents('span').removeClass('checked');
      
    }
}
function setProductQty(objectElement)
{
    objectElement.parents('td').find('.spinner').removeClass('hide');
    var datastring = 'qty='+objectElement.val()+'&product_id='+objectElement.attr('product_id')+'&_csrfToken='+_csrfToken;
    $.post(base_url+'admin/product/updateqtyrequest',datastring,function(response){
      objectElement.parents('td').find('.spinner').addClass('hide');
    });
    
}