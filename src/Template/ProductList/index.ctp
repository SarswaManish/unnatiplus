<style>
    #datalist li:nth-child(n+10) {
        display: none;
    }
</style>
<section>
    <div class="container-fluid">
        <div class="prod-list-section">
            <div class="pls-left">
                <div class="pls-side-box">
                    <div class="pls-side-box-title">Rating</div>
                    <div class="pls-side-box-body">
                        <div class="psb-list">
                            <ul id="datalist">
                                <li onclick="onchangefilter($(this),'Excellent Quality')">
                                    <label class="co-check"><a href="javascript:void(0);"> Excellent Quality </a>
                                    <input type="checkbox" class="checkedrating" value="Excellent Quality"><span class="checkmark"></span></label>
                                </li>
                                <li onclick="onchangefilter($(this),'Good Quality')">
                                    <label class="co-check"><a href="javascript:void(0);">  Good Quality </a>
                                    <input type="checkbox" class="checkedrating" value="Good Quality"><span class="checkmark"></span></label>
                                </li>
                                <li onclick="onchangefilter($(this),'Average Quality')">
                                    <label class="co-check"><a href="javascript:void(0);"> Average Quality </a>
                                    <input type="checkbox" class="checkedrating" value="Average Quality"><span class="checkmark"></span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php foreach($resAttributeInfo as $rowAttributeInfo)
                { 
                    $rowAttInfo = $resAttributeNameInfo->find('list',['keyField'=>'attterms_att_id','valueField'=>'attterms_name'])->where(['attterms_att_id '=>$rowAttributeInfo->att_id])->toArray();        
                    //pr($rowAttInfo);
                ?>
                <div class="pls-side-box mt-10">
                    <div class="pls-side-box-title"><?php echo $rowAttributeInfo->att_name;?></div>
                    <div class="pls-side-box-body">
                        <div class="psb-list">
                            <ul id="datalist">
                                <?php foreach($rowAttInfo as $key=>$val)
                                { ?>
                                    <li onclick="onchangefilter($(this),'<?php echo $key?>')">
                                        <label class="co-check">
                                            <?php echo $val;?>
                                            <input type="checkbox" class="attributefilterdata" value="<?php echo $key?>">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                <?php } ?>  
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="pls-side-box mt-10">
                    <div class="pls-side-box-title">Brands</div>
                    <div class="pls-side-box-body">
                        <div class="psb-list">
                            <ul id="datalist">
                                <?php foreach($resBrandInfo as $rowBrandInfo)
                                { ?>
                                    <li onclick="onchangefilter($(this),'<?php echo $rowBrandInfo['brand_id']; ?>')">
                                        <label class="co-check">
                                            <?php echo $rowBrandInfo->brand_name;?>
                                            <input type="checkbox" class="brandfilterdata" value="<?php echo $rowBrandInfo['brand_id']; ?>">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                <?php } ?>
                            </ul>
                            <a href="javascript:void(0);" style="color:red" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> More</a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="pls-right">
                <ul class="breadcrum">
                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                    <li><a href="javascript:;"><?php echo ucfirst(implode(' ',explode('-',$strParentCatgory))); ?></a></li>
                    <li><a href="javascript:;"><?php echo ucfirst(implode(' ',explode('-',$strChildCategory))); ?></a></li>
                    <!--<li><a href="#"><?php echo $rowCategoryInfo->category_name;?></a></li>
                    <li><a href="javascript:;">Winter Wear</a></li>-->
                </ul>
                <div class="page-title mb-10 mt-10"></div>
                <div class="short-by-section">
                    <form id="form1" action="" method="post">
                        <ul>
                           <!-- <li><strong>Short By:</strong></li>
                            <li><a href="JavaScript:Void(0);" onclick="document.getElementById('form1').submit();">Price - Low to High</a></li>-->
                            <li class="pull-right text-gray">
                                <?php echo ucfirst(implode(' ',explode('-',$strParentCatgory))); ?> 
                                (<?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?>)
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="row" style="margin-left:-5px;margin-right:-5px" id="replacedataproduct">
                    <?php 
                    if(count($resCategoryProductList)>0)
                    {
                    foreach($resCategoryProductList as $rowCategoryProductList)
                    {
                    ?>
                        <div class="col-lg-3 pr-5 pl-5">
                            <div class="product-item mb-10">
                                <div class="top-block">
                                    <div class="product-item-img product-ilstimg">
                                        <div class="favourit-icon">
                                            <?php $rowUserInfo = $this->request->getSession()->read('USER'); 
                                            if(isset($rowUserInfo->user_id))
                                            { ?>
                                                <?php if(isset($rowCategoryProductList->sk_wishlist->wish_id))
                                                { ?>
                                                    <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowCategoryProductList->product_id; ?>,$(this))">
                                                    <i class="heart fa fa-heart" aria-hidden="true"></i></a>
                                                <?php }else{ ?>
                                                    <a href="JavaScript:Void(0);" onclick="setwish(<?php echo $rowCategoryProductList->product_id; ?>,$(this))">
                                                    <i class="heart fa fa-heart-o" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <a href="JavaScript:Void(0);" class="login fav-icon" data-toggle="modal" data-target="#login">
                                                <i class="heart fa fa-heart-o" aria-hidden="true"></i></a>
                                            <?php  }?>
                                        </div>
                                        <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowCategoryProductList->product_slug;?>">
                                            <img class="zoom-product" src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowCategoryProductList->product_featured_image; ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="so-quickview text-center">
                                        <a class="quickview" href="<?php echo SITE_URL;?>product-detail/<?php echo $rowCategoryProductList->product_slug;?>" title="Quick view"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="bottom-block">
                                    <div class="pi-title">
                                        <?php echo $rowCategoryProductList->product_name;?>
                                    </div>
                                    <div class="pi-price">
                                        <span class="new-price">₹ <?php echo number_format($rowCategoryProductList->product_min_price,2,'.','');?>/ Piece</span>
                                    </div>
                                    <div class="pi-label">
                                        <?php if(isset($rowCategoryProductList['product_label']) && $rowCategoryProductList['product_label']=='Excellent Quality'){?>
                                            <span class="label-pi bg-success-400"><?php echo $rowCategoryProductList->product_label;?></span>
                                        <?php }else if(isset($rowCategoryProductList['product_label']) && $rowCategoryProductList['product_label']=='Average Quality'){?>
                                            <span class="label-pi bg-danger text-white"><?php echo $rowCategoryProductList->product_label;?></span>
                                        <?php }else if(isset($rowCategoryProductList['product_label']) && $rowCategoryProductList['product_label']=='Good Quality'){?>
                                            <span class="label-pi bg-warning text-white"><?php echo $rowCategoryProductList->product_label;?></span>
                                        <?php }?>
                                    </div>
                                    <div class="bottom-block-footer">
                                        <?php echo $rowCategoryProductList->product_tagline;?>
                                    </div>
                                    <div class="button-group">
                                        <a href="<?php echo SITE_URL;?>product-detail/<?php echo $rowCategoryProductList->product_slug;?>" class="addtocart">ADD TO CART</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }}else{ ?>
                        <div class="col-lg-12">
                            <div class="no-img text-center">
                                <img src="<?php echo SITE_URL;?>assets/img/no-cart.png" class="img-300 mb-20">
                                <h5>No Product?</h5>
                                <p>Looks like you have no item in your shopping cart
                                    <br>Click here to continue shopping</p>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- The Modal -->
<div class="modal" id="myModal" style="z-index: 99999;">
    <div class="modal-dialog psb-model">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Choose Brand</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="pls-side-box-body">
                    <div class="psb-list-2">
                        <ul>
                            <?php foreach($resBrandInfo as $rowBrandInfo){ ?>
                                <li onclick="onchangefilter($(this),'<?php echo $rowBrandInfo['brand_id']; ?>')">
                                    <label class="co-check">
                                        <?php echo $rowBrandInfo->brand_name;?>
                                        <input type="checkbox" class="brandfilterdata" value="<?php echo $rowBrandInfo['brand_id']; ?>">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">APPLY</button>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
    function onchangefilter(obj, strva) {
        if (obj.find('input').prop('checked')) {
            obj.find('input').prop('checked', false);
        } else {
            obj.find('input').prop('checked', true);
        }
        var stdataquality = [];
        $('.checkedrating').each(function() {
            if ($(this).prop('checked')) {
                stdataquality.push($(this).val());
            }
        });
        var brandsdata = [];
        $('.brandfilterdata').each(function() {
            if ($(this).prop('checked')) {
                brandsdata.push($(this).val());
            }
        });
        var attrdata = [];
        $('.attributefilterdata').each(function() {
            if ($(this).prop('checked')) {
                attrdata.push($(this).val());
            }
        });
        var datastring = 'category_slug='+"<?php echo $strSlug; ?>"+'&attribute=' + attrdata + '&brand=' + brandsdata + '&quality=' + stdataquality + '&filter=true';
        $.post('<?php echo SITE_URL; ?>product-list/filter', datastring, function(response) {
            $('#replacedataproduct').html(response);
        });
    }
</script>