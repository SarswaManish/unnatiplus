<!----------------------------->
<div class="slider-box mt-10">
   <div class="container-fluid">
      <div class="sb-box">
         <div class="sb-box-left">
            <div class="sb-cat">
               <div class="sb-cat-header">Shop by Category</div>
               <div class="accordion" id="accordionExample">
                  <div class="menu-card">
                     <?php 
                        $counter =0;
                        foreach($aryCategoryList as $key=>$label)
                        {
                        $counter++;
                        ?>
                     <div class="cat-head" id="heading<?php echo $label['category_id']; ?>">
                        <h2 data-toggle="collapse" data-target="#collapse<?php echo $label['category_id']; ?>">
                           <i class="fa fa-plus"></i> <?php echo $label['category_name']; ?>
                        </h2>
                     </div>
                     <div id="collapse<?php echo $label['category_id']; ?>" class="collapse <?php echo ($counter==1)?'show':''; ?>" aria-labelledby="heading<?php echo $label['category_id']; ?>" data-parent="#accordionExample">
                        <?php if(count($label['children'])>0)
                           { ?>
                        <ul class="menu">
                           <?php foreach($label['children'] as $key2nd=>$label2nd)
                              {
                              ?>
                           <li>
                              <a href="<?php echo SITE_URL ?>product-list/<?php echo $label2nd['category_slug'];?>"><?php echo $label2nd['category_name']; ?></a>
                              <?php if(count($label2nd['children'])>0)
                                 { ?>
                              <div class="megadrop">
                                 <div class="megadrop-col-frist">
                                    <ul>
                                       <?php
                                          $counter =0;
                                          foreach($label2nd['children'] as $key3rd=>$label3rd)
                                          {
                                          $counter++;
                                          ?>  
                                       <li class="">
                                          <a href="<?php echo SITE_URL ?>product-list/<?php echo $label3rd['category_slug'];?>"><?php echo $label3rd['category_name']; ?></a>
                                          <?php if(count($label3rd['children'])>0)
                                             { ?>
                                          <div class="megadrop-sub">
                                             <div class="row">
                                                <div class="col-lg-4">
                                                   <ul>
                                                      <?php foreach($label3rd['children'] as $key4rth=>$label4rth) { ?>  
                                                      <li><a href="#"><?php echo $label4rth['category_name']; ?></a></li>
                                                      <?php } ?>
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                          <?php } ?>
                                       </li>
                                       <?php } ?>
                                    </ul>
                                 </div>
                              </div>
                              <?php } ?>
                           </li>
                           <?php } ?>
                        </ul>
                        <?php } ?>
                     </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="sb-box-right">
            <div class="owl-carousel slider-home owl-theme">
               <?php foreach($resSlider as $rowSlider)
                  { ?>
               <div class="item">
                  <div class="slider-img">
                     <img src="<?php echo SITE_UPLOAD_URL.SITE_SLIDER_IMAGE_PATH.$rowSlider->slider_image; ?>">
                  </div>
               </div>
               <?php } ?>
            </div>
            <div class="add-box mt-10">
               <img class="img-res" src="<?php echo SITE_UPLOAD_URL.SITE_SLIDER_IMAGE_PATH.$resBottomSlider->slider_image; ?>">
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-9"></div>
      </div>
   </div>
</div>
<section>
   <div class="container-fluid">
      <?php foreach($resTagList as $rowTagInfo)
         { 
         $res =    $resProductData->find('all',['contain'=>['SkWishlist']])->where(['product_status'=>1,' FIND_IN_SET('.$rowTagInfo->tag_id.',product_tag)']);
         ?>
      <div class="section-title mb-15">
         <h2><?php echo $rowTagInfo->tag_name; ?></h2>
      </div>
      <div class="row mb-20">
         <div class="col-lg-12">
            <div class="owl-carousel product-slider owl-theme">
               <?php foreach($res as $rowProductData)
                  {?>
               <div class="item">
                  <div class="product-item">
                     <div class="favourit-icon">
                        <?php $rowUserInfo = $this->request->getSession()->read('USER'); 
                           if(isset($rowUserInfo->user_id))
                           { ?>
                        <?php if(isset($rowProductData->sk_wishlist->wish_id))
                           { ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowProductData->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart" aria-hidden="true"></i></a>
                        <?php }else{ ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowProductData->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php } else { ?>
                        <a href="JavaScript:Void(0);" class="login fav-icon" data-toggle="modal" data-target="#login">
                        <i class="heart fa fa-heart-o"  aria-hidden="true"></i></a>
                        <?php  }?>
                     </div>
                     <div class="top-block">
                        <div class="product-item-img">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowProductData->product_slug;?>">
                           <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductData->product_image1; ?>" > 
                           </a>
                        </div>
                        <div class="so-quickview text-center">
                           <a class="quickview" href="<?php echo SITE_URL;?>product-detail/<?php echo $rowProductData->product_slug;?>" title="Quick view"><i class="icon-eye"></i></a>
                        </div>
                     </div>
                     <div class="bottom-block">
                        <div class="pi-title"><?php echo $rowProductData->product_name;?></div>
                        <div class="pi-price">
                           <?php if($rowProductData->product_max_price!=$rowProductData->product_min_price)   
                              { ?>
                           <span class="new-price">₹ <?php echo number_format($rowProductData->product_min_price,2,'.','');?> - <?php echo number_format($rowProductData->product_max_price,2,'.','');?> / Piece</span>
                           <?php }else{ ?>
                           <span class="new-price">₹ <?php echo number_format($rowProductData->product_min_price,2,'.','');?> / Piece</span>
                           <?php } ?>
                        </div>
                        <div class="pi-label">
                           <?php if(isset($rowProductData['product_label']) && $rowProductData['product_label']=='Excellent Quality')
                              {?>
                           <span class="label-pi bg-success-400"><?php echo $rowProductData->product_label;?></span>
                           <?php }else if(isset($rowProductData['product_label']) && $rowProductData['product_label']=='Average Quality')
                              {?>
                           <span class="label-pi bg-danger text-white"><?php echo $rowProductData->product_label;?></span>
                           <?php }else if(isset($rowProductData['product_label']) && $rowProductData['product_label']=='Good Quality')
                              {?>
                           <span class="label-pi bg-warning text-white"><?php echo $rowProductData->product_label;?></span>
                           <?php }?>
                        </div>
                        <div class="bottom-block-footer">
                           <?php echo $rowProductData->product_tagline;?>
                        </div>
                        <div class="button-group">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowProductData->product_slug;?>" class="addtocart">ADD TO CART</a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php }?>
            </div>
         </div>
      </div>
      <?php } ?>
      
      <?php if(count($resRecentlyViewdProduct)>0)
         { ?>
      <div class="section-title mb-15">
         <h2>Recently Viewed Product</h2>
      </div>
      <div class="row mb-20">
         <div class="col-lg-12">
            <div class="owl-carousel product-slider owl-theme">
               <?php foreach($resRecentlyViewdProduct as $rowProductData)
                  {?>
               <div class="item">
                  <div class="product-item">
                     <div class="favourit-icon">
                        <?php $rowUserInfo = $this->request->getSession()->read('USER'); 
                           if(isset($rowUserInfo->user_id))
                           { ?>
                        <?php if(isset($rowProductData->sk_wishlist->wish_id))
                           { ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowProductData->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart" aria-hidden="true"></i></a>
                        <?php }else{ ?>
                        <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowProductData->product_id; ?>,$(this))">
                        <i class="heart fa fa-heart-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php } else { ?>
                        <a href="JavaScript:Void(0);" class="login fav-icon" data-toggle="modal" data-target="#login">
                        <i class="heart fa fa-heart-o"  aria-hidden="true"></i></a>
                        <?php  }?>
                     </div>
                     <div class="top-block">
                        <div class="product-item-img">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowProductData->product_slug;?>">
                           <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductData->product_image1; ?>" > 
                           </a>
                        </div>
                        <div class="so-quickview text-center">
                           <a class="quickview" href="<?php echo SITE_URL;?>product-detail/<?php echo $rowProductData->product_slug;?>" title="Quick view"><i class="icon-eye"></i></a>
                        </div>
                     </div>
                     <div class="bottom-block">
                        <div class="pi-title"><?php echo $rowProductData->product_name;?></div>
                        <div class="pi-price">
                           <?php if($rowProductData->product_max_price!=$rowProductData->product_min_price)   
                              { ?>
                           <span class="new-price">₹ <?php echo number_format($rowProductData->product_min_price,2,'.','');?> - <?php echo number_format($rowProductData->product_max_price,2,'.','');?> / Piece</span>
                           <?php }else{ ?>
                           <span class="new-price">₹ <?php echo number_format($rowProductData->product_min_price,2,'.','');?> / Piece</span>
                           <?php } ?>
                        </div>
                        <div class="pi-label">
                           <?php if(isset($rowProductData['product_label']) && $rowProductData['product_label']=='Excellent Quality')
                              {?>
                           <span class="label-pi bg-success-400"><?php echo $rowProductData->product_label;?></span>
                           <?php }else if(isset($rowProductData['product_label']) && $rowProductData['product_label']=='Average Quality')
                              {?>
                           <span class="label-pi bg-danger text-white"><?php echo $rowProductData->product_label;?></span>
                           <?php }else if(isset($rowProductData['product_label']) && $rowProductData['product_label']=='Good Quality')
                              {?>
                           <span class="label-pi bg-warning text-white"><?php echo $rowProductData->product_label;?></span>
                           <?php }?>
                        </div>
                        <div class="bottom-block-footer">
                           <?php echo $rowProductData->product_tagline;?>
                        </div>
                        <div class="button-group">
                           <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowProductData->product_slug;?>" class="addtocart">ADD TO CART</a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php }?>
            </div>
         </div>
      </div>
      <?php } ?>
      <div class="section-title mb-15">
         <h2>Shop By Brands</h2>
      </div>
      <div class="row mb-20">
         <div class="col-lg-12">
            <div class="owl-carousel brand-slider owl-theme">
               <?php foreach($resBrand as $rowBrand)
                  { ?>
               <div class="item">
                  <div class="brand-box">
                     <?php if(isset($rowBrand->brand_image) && $rowBrand->brand_image!='')
                        { ?>   
                     <a href="<?php echo SITE_URL;?>brand/<?php echo $rowBrand->brand_slug;?>">
                        <div class="brand-box-img"><img src="<?php echo SITE_UPLOAD_URL.SITE_CATEGORY_ICON_PATH.$rowBrand->brand_image; ?>" > </div>
                        <div class="brand-title"><?php echo $rowBrand->brand_name;?></div>
                     </a>
                     <?php } else{?>
                     <a href="<?php echo SITE_URL;?>brand/<?php echo $rowBrand->brand_slug;?>">
                        <div class="brand-box-img"><img src="<?php echo SITE_URL;?>admin/images/placeholder.jpg" > </div>
                        <div class="brand-title"><?php echo $rowBrand->brand_name;?></div>
                     </a>
                     <?php }?>
                  </div>
               </div>
               <?php }?>
            </div>
         </div>
      </div>
      <div class="section-title mb-15">
         <h2>Feedback</h2>
      </div>
        <div class="row mb-20">
            <div class="col-lg-12">
                <div class="owl-carousel feedback-slider owl-theme">
               <?php foreach($resFeedbackInfo as $rowFeedbackInfo)
                  { ?>
               <div class="item">
                  <div class="brand-box" style="height: 217px;">
                      <?php if(isset($rowFeedbackInfo->customer_url) && $rowFeedbackInfo->customer_url!='')
                        { ?>  
                        <iframe style="height:80%;width:100%;" src="<?php echo $rowFeedbackInfo->customer_url;?>"></iframe>
                      <?php }else{?>
                      <?php }?>
                        <div class="brand-title"><?php echo $rowFeedbackInfo->customer_title;?></div>
                        <?php echo $rowFeedbackInfo->customer_review_text;?>
                  </div>
               </div>
               <?php }?>
            </div>
            </div>
        </div>
   </div>
</section>
<!----------------------------->
<!-- The Modal -->

