function getTagslug(strCategoryName)
{
    if(strCategoryName!='')
    {
      var lower_product_name = strCategoryName.toLowerCase();
      var strreplace_product_name = lower_product_name.replace(/,/g,'');
      var strreplace_product_name = strreplace_product_name.replace(/&/g,'');
      var strreplace_product_name = strreplace_product_name.replace('  ',' ');
      var split_product_name = strreplace_product_name.split(' ');
      var join_product_name = split_product_name.join('-');
      $('#tag_slug').val(join_product_name);
    }
    
    
}
function submitProcessTag()
{    
    $('.spinner-form').removeClass('hide');
    var categoryname = $('#tag_name').val();
    if(categoryname.trim()=='')
    {
         $('#tag-name-error').addClass('has-error');
         window.scrollTo(0, 100);
         $('.spinner-form').addClass('hide');
         return false;
       
    }else{
        
        $('#tag-name-error').removeClass('has-error');
    }
}