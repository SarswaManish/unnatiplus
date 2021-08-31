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
<li><a href="javascript:;">My Wishlist</a></li>
</ul>
<div class="my-pro-contetnt-title">My Wishlist</div>
<div class="row" style="margin-left:-5px;margin-right:-5px">
<?php
if(count($resWishList)>0)
{
foreach($resWishList as $rowWishList)
{
?>
<div class="col-lg-3 pr-5 pl-5">
<div class="product-item mb-10">
    
    <div class="fav-delete">
        
        <a href="<?php echo SITE_URL;?>my-account/removeWishlistItem/<?php echo $rowWishList->wish_id;?>"  onclick="return confirm('Are you want to sure delete?');" ><i class="icon-trash"></i></a>

     
    
    </div>  

<div class="top-block">
<div class="product-item-img product-ilstimg">
<a href="https://codexosoftware.live/unnatiplus/product-detail/nike-footwear-2017-18-shoes-mix-lot-(shoes-slippers-and-sandals)">
<img class="zoom-product" src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowWishList->sk_product->product_featured_image; ?>" alt="">
</a>
</div>
<div class="so-quickview text-center">
<a class="quickview" href="https://codexosoftware.live/unnatiplus/product-detail/nike-footwear-2017-18-shoes-mix-lot-(shoes-slippers-and-sandals)" title="Quick view"><i class="icon-eye"></i>
</a>
</div>
</div>
<div class="bottom-block">
<div class="pi-title"><?php echo $rowWishList->sk_product->product_name;?> </div>
<div class="pi-price">
<span class="new-price">₹ <?php echo $rowWishList->sk_product->product_min_price;?>/ Piece</span>
</div>
<div class="pi-label">
<?php if(isset($rowWishList->sk_product['product_label']) && $rowWishList->sk_product['product_label']=='Excellent Quality')
{?>
<span class="label-pi bg-success-400"><?php echo $rowWishList->sk_product->product_label;?></span>
<?php }else if(isset($rowWishList->sk_product['product_label']) && $rowWishList->sk_product['product_label']=='Average Quality')
{?>
<span class="label-pi bg-danger text-white"><?php echo $rowWishList->sk_product->product_label;?></span>
<?php }else if(isset($rowWishList->sk_product['product_label']) && $rowWishList->sk_product['product_label']=='Good Quality')
{?>
<span class="label-pi bg-warning text-white"><?php echo $rowWishList->sk_product->product_label;?></span>
<?php }?>
</div>
<div class="bottom-block-footer">
<?php echo $rowWishList->sk_product->product_tagline;?>
</div>
<div class="button-group">
<a href="#"class="addtocart">ADD TO CART</a>
</div>
</div>
</div>
</div>
<?php }}?>
</div>
</div>
</div>
</div>
</div>
</section>

<script>
function refreshPage(){

location.reload(true);
} 
</script>
<script>
function ConfirmDelete()
{
var x = confirm("Are you want to sure?");
if (x == true)
window.location.reload();
else
return false;
}

</script>
