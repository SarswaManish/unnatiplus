function getCategoryslug(strCategoryName)
{
    if(strCategoryName!='')
    {
      var lower_product_name = strCategoryName.toLowerCase();
      var strreplace_product_name = lower_product_name.replace(/,/g,'');
      var strreplace_product_name = strreplace_product_name.replace(/&/g,'');
      var strreplace_product_name = strreplace_product_name.replace('  ',' ');
      var split_product_name = strreplace_product_name.split(' ');
      var join_product_name = split_product_name.join('-');
      $('#category_slug').val(join_product_name);
    }
    
    
}
function submitProcessCategory()
{    
    $('.spinner-form').removeClass('hide');
    var categoryname = $('#category_name').val();
    if(categoryname.trim()=='')
    {
         $('#category-name-error').addClass('has-error');
         window.scrollTo(0, 100);
         $('.spinner-form').addClass('hide');
         return false;
       
    }else{
        
        $('#category-name-error').removeClass('has-error');
    }
}

function showChildCategory(objectElement)
{
    
    var dataloaded = objectElement.attr('data-loaded');
      var dataclass = objectElement.attr('data-class');
   $('.'+dataclass).removeClass('hide');
  
    if(dataloaded==0)
    {
        objectElement.attr('data-loaded',1);
    var dataids = 'child_ids='+objectElement.attr('data-childs')+'&_csrfToken='+csrf_tocken;
    $.post(base_url+'admin/categories/getCatgoryChildHtml',dataids,function(response){
       
        $('.'+dataclass).after(response);
        $('.'+dataclass).remove(); 
       objectElement.attr('data-loaded',1);
    });
    }
    
}

