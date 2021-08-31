<?php 
 $totalSizeCount = count($rowProductInfo['sk_productbusinessprice']);
 $quantityIfSingle = "";
 $sizeSetsStr = ""; 
 $perPiecePrice = "";
 
 $rowCartItem =$this->request->getSession()->read('cart_items');
 if($totalSizeCount == 1){
     
      foreach($rowProductInfo['sk_productbusinessprice'] as $attr){
         $perPiecePrice = $attr->pu_net_price;
     $intQty =0;
     if(isset($rowCartItem[$attr->pu_product_id][$attr->pu_size]))
     {
         
        $intQty = $rowCartItem[$attr->pu_product_id][$attr->pu_size]['qty']; 
     }
     ////pr($rowCartItem[$attr->pu_product_id][$attr->pu_size]);
     $strDisabled ='';
     if($intQty==0)
     {
         $strDisabled = 'disabled="disabled"';
     }
     $quantityIfSingle = '<p><strong>Set Quantity :</strong></p>
                              <div class="pro-button-group">
                                 <div class="input-group pro-input">
                                    <span class="input-group-btn">
                                   <button type="button" class="btn btn-default btn-number minus" '.$strDisabled.' data-type="minus" data-field="quant[1]" onclick="minuscart($(this),'.$attr->pu_id.')"  id="minus'.$attr->pu_id.'">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                    </span>
                                    <input type="text" name="qty[]" class="form-control input-number cssqtyextra cssqty'.$attr->pu_id.'" value="'.$intQty.'" min="'.$attr->pu_moq.'" max="'.$attr->pu_qty.'" id="p_'.$attr->pu_id.'_size_'.$attr->pu_size.'_set_'.$attr->pu_qty.'_pu_'.$attr->pu_id.'"  data-itempack="'.$attr->pu_item_pack.'">
                                    <span class="input-group-btn">
                                     <button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="quant[1]" onclick="pluscart($(this),'.$attr->pu_id.')" id="plus'.$attr->pu_id.'">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    </span>
                                 </div>
                            </div>';
      }
 }else{
 
 foreach($rowProductInfo['sk_productbusinessprice'] as $attr){
     $intQty =0;
     if(isset($rowCartItem[$attr->pu_product_id][$attr->pu_size]))
     {
         
        $intQty = $rowCartItem[$attr->pu_product_id][$attr->pu_size]['qty']; 
     }
     ////pr($rowCartItem[$attr->pu_product_id][$attr->pu_size]);
     $strDisabled ='';
     if($intQty==0)
     {
         $strDisabled = 'disabled="disabled"';
     }
    $perPiecePrice = $attr->pu_net_price/$attr->pu_item_pack;
    $sizeSetsStr .= '<tr id="p_'.$attr->pu_id.'_size_'.$attr->pu_size.'_set_'.$attr->pu_qty.'_pu_'.$attr->pu_id.'">
                       <td id="p_size_'.$attr->pu_size.'">'.$attr->sk_size->size_name.'</td>
                       <td id="pu_set_'.$attr->pu_qty.'">'.$attr->pu_qty.' Set</td>
                       <td class="real_quatity_" data-toggle="tooltip" title="Minimum order qunatity : '.$attr->pu_moq.'">
                          <div class="pro-button-group" style="margin-bottom:0px;">
                             <div class="input-group pro-input" style="float:none;margin:0 auto;">
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number minus" '.$strDisabled.' data-type="minus" data-field="quant[1]" onclick="minuscart($(this),'.$attr->pu_id.')"  id="minus'.$attr->pu_id.'">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                                </span>
                                <input type="text" name="qty[]" class="form-control input-number cssqty'.$attr->pu_id.'" value="'.$intQty.'" min="'.$attr->pu_moq.'" max="'.$attr->pu_qty.'" data-itempack="'.$attr->pu_item_pack.'">
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="quant[1]" onclick="pluscart($(this),'.$attr->pu_id.')" id="plus'.$attr->pu_id.'">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                                </span>
                             </div>
                          </div>
                       </td>
                    </tr> ';  
 }
 }
 
 $intProductId = $rowProductInfo->product_id;
?>
<style>
     .favourit-icon {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 99999;
    background: rgba(255,255,255,0.6);
    width: 35px;
    height: 35px;
    text-align: center;
    font-size: 16px;
    border-radius: 50%;
    padding: 6px;
}
 .favourit-icon a{
  color:#000;   
 }
</style>
<section>
   <div class="container-fluid">
      <input type="hidden" name="p_id" id="p_id" value="<?php echo $rowProductInfo['product_id'].'@'.$rowProductInfo['product_sku'];  ?>"> 
      <div class="row">
         <div class="col-lg-4">
            <div class="tt-product-vertical-layout">
               <div class="tt-product-single-img">
                  <div>
                     <img class="zoom-product" src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_featured_image; ?>" alt="" >
                  <div class="favourit-icon">
                 <?php $rowUserInfo = $this->request->getSession()->read('USER'); 
                           if(isset($rowUserInfo->user_id))
                           { ?>
                        <?php if(isset($rowProductInfo->sk_wishlist->wish_id))
                           { ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowProductInfo->product_id; ?>,$(this))">
                        <i class="add-cart mb-10 heart fa fa-heart" aria-hidden="true"></i></a>
                        <?php }else{ ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowProductInfo->product_id; ?>,$(this))">
                        <i class="add-cart mb-10 heart fa fa-heart-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php } else { ?>
                        <a href="JavaScript:Void(0);" class="login fav-icon" data-toggle="modal" data-target="#login">
                        <i class="add-cart mb-10 heart fa fa-heart-o"  aria-hidden="true"></i></a>
                        <?php  }?>
                   </div>
                  </div>
                  
               </div>
               <div class="tt-product-single-carousel-vertical">
                  <ul id="smallGallery" class="tt-slick-button-vertical  slick-animated-show-js">
                     <?php if($rowProductInfo['product_image1']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image1; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image1; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image2']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image2; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image2; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image3']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image3; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image3; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image4']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image4; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image4; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image5']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image5; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image5; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image6']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image6; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image6; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image7']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image7; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image7; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image8']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image8; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image8; ?>" alt=""></a></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_image9']!='')
                        { ?>
                     <li><a class="zoomGalleryActive" href="#" data-image="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image9; ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_image9; ?>" alt=""></a></li>
                     <?php }?>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-lg-5">
            <div class="pro-details">
               <?php if($rowProductInfo['product_name']!='')
                  { ?>
               <h1><?php echo $rowProductInfo->product_name;?></h1>
               <?php }?>
               <div class="pi-label mb-10" style="<?php if($rowProductInfo->product_label==''){ ?>display:none<?php } ?>">
                  <span class="label-pi bg-success-400"><?php echo $rowProductInfo->product_label;?></span>
               </div>
               <div class="pro-meta">
                  <ul>
                     <?php if($rowProductInfo['product_model']!='')
                        { ?>
                     <li><span>Model:</span><?php echo $rowProductInfo->product_model;?></li>
                     <?php }?>
                     <?php if($rowProductInfo['product_sku']!='')
                        { ?>
                     <li><span>HSN:</span><?php echo $rowProductInfo->product_sku;?></li>
                     <?php }?>
                  </ul>
               </div>
               <?php if($rowProductInfo['product_fabric']!='')
                  { ?>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Fabric</td>
                            <td><?php echo $rowProductInfo['product_fabric'];?></td>
                        </tr>
                        <tr>
                            <td>Occasion</td>
                            <td><?php echo $rowProductInfo['product_occasion'];?></td>
                        </tr>
                        <tr>
                            <td>Design</td>
                            <td><?php echo $rowProductInfo['product_design'];?></td>
                        </tr>
                        <tr>
                            <td>Product Style</td>
                            <td><?php echo $rowProductInfo['product_style'];?></td>
                        </tr>
                        <tr>
                            <td>Product Fit</td>
                            <td><?php echo $rowProductInfo['product_fit'];?></td>
                        </tr>
                        <tr>
                            <td>Neck Type</td>
                            <td><?php echo $rowProductInfo['product_neck_type'];?></td>
                        </tr>
                        <tr>
                            <td>Sleeve</td>
                            <td><?php echo $rowProductInfo['product_sleeve'];?></td>
                        </tr>
                    </tbody>
                </table>
               <?php }?>
               <?php if($rowProductInfo['product_desc']!='')
                  { ?>
               <div class="pro-des">
                  <h4>Description</h4>
                  <p><?php   echo $rowProductInfo->product_desc;?></p>
               </div>
               <?php }?>
            </div>
         </div>
         <div class="col-lg-3">
            <div class="pro-highlight">
               <div class="pro-highlight-body">
                  <div class="pro-price">
                     <span class="new-price">₹<?php echo round($perPiecePrice,2); ?> / Piece</span>
                     <p>Per Piece + <?php echo $rowProductInfo['sk_tax']->tax_title;  ?></p>
                  </div>
                  <?php echo $quantityIfSingle; ?>
                  <?php if($sizeSetsStr!='')
                  { ?>
                  <div class="pro-table">
                     <table>
                        <thead>
                           <tr>
                              <th>Size</th>
                              <th>Available</th>
                              <th>Quantity</th>
                           </tr>
                        </thead>
                        <tbody id="product_attrs" >
                        <?php echo $sizeSetsStr ; ?>
                        </tbody>
                     </table>
                  </div>
                        <a href="javascript:void(0)" id="add_to_cart"  class="add-cart mb-10"  style="width:100%;"><i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                            ADD TO CART </a>
                       
                  <?php }else{ ?>
                        <a href="javascript:void(0)"   onclick="addtocart($(this))" class="add-cart mb-10"  style="width:100%;"><i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>
                            ADD TO CART </a>
                  <?php } ?>
              
                  <p class="text-gray f11">Shipping Charge and Return Policy <a href="<?php echo SITE_URL;?>cancellation-and-returns">click here</a></p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section>
   <div class="container-fluid">
      <div class="section-title mb-15">
         <h2>Related Product</h2>
      </div>
      <div class="row mb-20">
         <div class="col-lg-12">
            <div class="owl-carousel product-slider owl-theme">
               <?php foreach($resFeaturedProduct as $rowFeaturedProduct)
                  {?>
               <div class="item">
                  <div class="product-item">
                     <div class="favourit-icon">
                        <?php $rowUserInfo = $this->request->getSession()->read('USER'); 
                           if(isset($rowUserInfo->user_id))
                           { ?>
                        <?php if(isset($rowFeaturedProduct->sk_wishlist->wish_id))
                           { ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowFeaturedProduct->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart" aria-hidden="true"></i></a>
                        <?php }else{ ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowFeaturedProduct->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php } else { ?>
                        <a href="JavaScript:Void(0);" class="login fav-icon" data-toggle="modal" data-target="#login">
                        <i class="heart fa fa-heart-o"  aria-hidden="true"></i></a>
                        <?php  }?>
                     </div>
                     <div class="top-block">
                        <div class="product-item-img">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>">
                           <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowFeaturedProduct->product_image1; ?>"  > 
                           </a>
                        </div>
                        <div class="so-quickview text-center">
                           <a class="quickview" href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>" title="Quick view"><i class="icon-eye"></i>
                           </a>
                        </div>
                     </div>
                     <div class="bottom-block">
                        <div class="pi-title"><?php echo $rowFeaturedProduct->product_name;?></div>
                        <div class="pi-price">
                           <span class="new-price">₹ <?php echo number_format($rowFeaturedProduct->product_min_price,2,'.','');?>/ Piece</span>
                        </div>
                        <div class="pi-label">
                           <?php if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Excellent Quality')
                              {?>
                           <span class="label-pi bg-success-400"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }else if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Average Quality')
                              {?>
                           <span class="label-pi bg-danger text-white"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }else if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Good Quality')
                              {?>
                           <span class="label-pi bg-warning text-white"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }?>
                        </div>
                        <div class="bottom-block-footer">
                           <?php echo $rowProductInfo->product_tagline;?>
                        </div>
                        <div class="button-group">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>" class="addtocart">ADD TO CART</a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php }?>
            </div>
         </div>
      </div>
      <div class="section-title mb-15">
         <h2>More From This Seller </h2>
      </div>
      <div class="row mb-20">
         <div class="col-lg-12">
            <div class="owl-carousel product-slider owl-theme">
               <?php foreach($resFeaturedProduct as $rowFeaturedProduct)
                  {?>
               <div class="item">
                  <div class="product-item">
                     <div class="favourit-icon">
                        <?php 
                    $rowUserInfo = $this->request->getSession()->read('USER'); 
                           if(isset($rowUserInfo->user_id))
                           { ?>
                        <?php if(isset($rowFeaturedProduct->sk_wishlist->wish_id))
                           { ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowFeaturedProduct->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart" aria-hidden="true"></i></a>
                        <?php }else{ ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowFeaturedProduct->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php } else { ?>
                        <a href="JavaScript:Void(0);" class="login fav-icon" data-toggle="modal" data-target="#login">
                        <i class="heart fa fa-heart-o"  aria-hidden="true"></i></a>
                        <?php  }  ?>
                     </div>
                     <div class="top-block">
                        <div class="product-item-img">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>">
                           <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowFeaturedProduct->product_image1; ?>"  > 
                           </a>
                        </div>
                        <div class="so-quickview text-center">
                           <a class="quickview" href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>" title="Quick view"><i class="icon-eye"></i>
                           </a>
                        </div>
                     </div>
                     <div class="bottom-block">
                        <div class="pi-title"><?php echo $rowFeaturedProduct->product_name;?></div>
                        <div class="pi-price">
                           <span class="new-price">₹ <?php echo number_format($rowFeaturedProduct->product_min_price,2,'.','');?>/ Piece</span>
                        </div>
                        <div class="pi-label">
                           <?php if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Excellent Quality')
                              {?>
                           <span class="label-pi bg-success-400"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }else if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Average Quality')
                              {?>
                           <span class="label-pi bg-danger text-white"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }else if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Good Quality')
                              {?>
                           <span class="label-pi bg-warning text-white"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }?>
                        </div>
                        <div class="bottom-block-footer">
                           <?php echo $rowProductInfo->product_tagline;?>
                        </div>
                        <div class="button-group">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>" class="addtocart">ADD TO CART</a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php }?>
            </div>
         </div>
      </div>
      <?php if($resRecentlyViewdProduct->count()>0)
         {?>
      <div class="section-title mb-15">
         <h2>Recently Viewed</h2>
      </div>
      <div class="row mb-20">
         <div class="col-lg-12">
            <div class="owl-carousel product-slider owl-theme">
               <?php 
                  foreach($resRecentlyViewdProduct as $rowFeaturedProduct)
                  {?>
               <div class="item">
                  <div class="product-item">
                     <div class="favourit-icon">
                        <?php $rowUserInfo = $this->request->getSession()->read('USER'); 
                           if(isset($rowUserInfo->user_id))
                           { ?>
                        <?php if(isset($rowFeaturedProduct->sk_wishlist->wish_id))
                           { ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowFeaturedProduct->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart" aria-hidden="true"></i></a>
                        <?php }else{ ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowFeaturedProduct->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php } else { ?>
                        <a href="JavaScript:Void(0);" class="login fav-icon" data-toggle="modal" data-target="#login">
                        <i class="heart fa fa-heart-o"  aria-hidden="true"></i></a>
                        <?php  }?>
                     </div>
                     <div class="top-block">
                        <div class="product-item-img">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>">
                           <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowFeaturedProduct->product_image1; ?>"  > 
                           </a>
                        </div>
                        <div class="so-quickview text-center">
                           <a class="quickview" href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>" title="Quick view"><i class="icon-eye"></i>
                           </a>
                        </div>
                     </div>
                     <div class="bottom-block">
                        <div class="pi-title"><?php echo $rowFeaturedProduct->product_name;?></div>
                        <div class="pi-price">
                           <span class="new-price">₹ <?php echo number_format($rowFeaturedProduct->product_min_price,2,'.','');?>/ Piece</span>
                        </div>
                        <div class="pi-label">
                           <?php if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Excellent Quality')
                              {?>
                           <span class="label-pi bg-success-400"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }else if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Average Quality')
                              {?>
                           <span class="label-pi bg-danger text-white"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }else if(isset($rowFeaturedProduct['product_label']) && $rowFeaturedProduct['product_label']=='Good Quality')
                              {?>
                           <span class="label-pi bg-warning text-white"><?php echo $rowFeaturedProduct->product_label;?></span>
                           <?php }?>
                        </div>
                        <div class="bottom-block-footer">
                           <?php echo $rowProductInfo->product_tagline;?>
                        </div>
                        <div class="button-group">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowFeaturedProduct->product_slug;?>" class="addtocart">ADD TO CART</a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php }?>
            </div>
         </div>
      </div>
      <?php } ?>
   </div>
</section>
<script src="<?php echo SITE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo SITE_URL;?>js/jquery.elevatezoom.js"></script>
<script src="<?php echo SITE_URL;?>js/slick.min.js"></script>
<script src="<?php echo SITE_URL;?>js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo SITE_URL;?>js/lazyload.min.js"></script>
<script src="<?php echo SITE_URL;?>js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
<script>
$('#add_to_cart').on('click',function(){
   var productId =  $("#p_id").val().split('@')['0'];
   var attrs = [];
   $('#product_attrs tr').each(function(){
       var qty = $(this).find('input').val();
       var ItemInPack = $(this).find('input').attr('data-itempack');
       // currently taken static make it dynamic 
       if(qty>0){
        var moq = $(this).find('input').attr('min');
        if(moq > qty){
            $.growl.error({ title: "Failed", message: "Minimum order qunatity is "+moq });
            return false;
        }
        var trId = $(this).attr('id').split('_');
        var size = trId['3'];
        var setValue = trId['5'];
        var puid = trId['7'];
        var obj = {'size': size,  'set': setValue,'qty':qty,'pu_id':puid,'ItemInPack':ItemInPack};
        attrs.push(obj);
       }
   });
    
   if(attrs.length > 0){
       // run ajax to set session and enter data into database
       var siteUrl = '<?php echo SITE_URL; ?>';
       var daat = {'product_id':productId,'attrs':attrs,'action':1};
       
       $.ajax({
           url : siteUrl+'add-to-cart-product',
           type : 'post',
           data : daat,
           success:function(y){
               console.log(y);
                var tcc =JSON.parse(y);
                $.growl.notice({ title: "Added to Cart", message: "Product Added to cart Successfully" });
                $('.cartcountforupdate').html(tcc.cartcount+' item(s)');
           },
           error:function(x){
               console.log(x);
           }
       });
   }else{
       console.log('somethins went wrong');
       $.growl.error({ title: "Failed", message: "Minimum order quantity required" });
   }
});

function minuscart(object,pbprice)
{
    var strclass ='cssqty'+pbprice;
    var valofunit = $('.'+strclass).val();
    if(valofunit>0)
    {
        
         $('.'+strclass).val(parseInt(parseInt(valofunit)-parseInt(1)));
                $('#plus'+pbprice).attr('disabled',false);

    }
    if(valofunit==1)
    {
              object.attr('disabled',true);
    }
    
}
function pluscart(object,pbprice)
{
       var strclass ='cssqty'+pbprice;
    var valofunit = $('.'+strclass).val();
    var mxorder =  $('.'+strclass).attr('max');
   if(valofunit==0)
   {
             $('#minus'+pbprice).attr('disabled',false);
   }
   if(parseInt(mxorder)>parseInt(valofunit))
    {
         console.log(mxorder,"mxorder");
     console.log(valofunit,"valofunit");
    $('.'+strclass).val(parseInt(parseInt(valofunit)+parseInt(1)));
    }
    if(parseInt(mxorder)==parseInt(valofunit))
    {
        object.attr('disabled',true);
        
    }
} 

function addtocart()
{
   
    var attrs =[];
    var qty =$('.cssqtyextra').val();
    if(qty>0)
    {
     var trId = $('.cssqtyextra').attr('id').split('_');
      var ItemInPack = $('.cssqtyextra').attr('data-itempack');
      var size = trId['3'];
       var setValue = trId['5'];
       
       var puid = trId['7'];
    ///   alert(puid);
var obj = {'size': size,  'set': setValue,'qty':qty,'pu_id':puid,'ItemInPack':ItemInPack};
        attrs.push(obj);
       
       if(attrs.length > 0){
       // run ajax to set session and enter data into database
       var siteUrl = '<?php echo SITE_URL; ?>';
       $.ajax({
           url : siteUrl+'add-to-cart-product',
           type : 'post',
           data : {'product_id':<?php echo $intProductId; ?>,'attrs':attrs,'action':1},
           success:function(y){
               console.log(y);
                 $.growl.notice({ title: "Added to Cart", message: "Product Added to cart Successfully" });
                var tcc =JSON.parse(y);
$('.cartcountforupdate').html(tcc.cartcount+' item(s)');
           },
           error:function(x){
               console.log(x);
           }
       });
   }else{
                 $.growl.error({ title: "Failed", message: "Minimum order qty required" });
   }
    }else{
                 $.growl.error({ title: "Failed", message: "Minimum order qty required" });
   }
    
    
}

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>