<?php use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');

$resSelectCategory =$conn->execute('SELECT * FROM sk_category WHERE 1 AND category_status=1 ')->fetchAll('assoc');
$aryCategoryData =$this->Recurs->buildTreeCategory($resSelectCategory);

?>
	<div class="main-container container">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
			<li><a href="javascript:;"><?php echo $strPageTitle; ?></a></li>
		</ul>
		
		<div class="row">
			<!--Left Part Start -->
			<aside class="col-sm-4 col-md-3 content-aside" id="column-left">
				<div class="module category-style">
                	<h3 class="modtitle">Categories</h3>
                	<div class="modcontent">
                		<div class="box-category">
                			<ul id="cat_accordion" class="list-group">
                			    <?php foreach($aryCategoryData as $keyCategory=>$labelCategory)
                			    { ?>
                				<li class="<?php if(isset($labelCategory['children']))
                				{ ?>hadchild<?php } ?>"><a href="<?php echo SITE_URL; ?>category-product/<?php echo $labelCategory['category_slug']; ?>" class="cutom-parent"><?php echo $labelCategory['category_name']; ?></a>  
                				<?php if(isset($labelCategory['children']))
                				{ ?><span class="button-view  fa fa-plus-square-o"></span><?php } ?>
                				<?php if(isset($labelCategory['children']))
                				{ ?>
                					<ul style="display: block;">
                					    <?php foreach($labelCategory['children'] as $keyChild=>$labelChild)
                					    { ?>
                						<li><a href="<?php echo SITE_URL; ?>category-product/<?php echo $labelCategory['category_slug']; ?>/<?php echo $labelChild['category_slug']; ?>"><?php echo $labelChild['category_name']; ?></a></li>
                						<?php } ?>
                						
                					</ul>
                						<?php } ?>
                				</li>
                				<?php } ?>
                			
                			
                			</ul>
                		</div>
                		
                		
                	</div>
                </div>
            	<div class="module product-simple">
                    <h3 class="modtitle">
                        <span>Latest products</span>
                    </h3>
                    <div class="modcontent">
                        <div class="so-extraslider" >
                            <!-- Begin extraslider-inner -->
                            <div class=" extraslider-inner">
                                <div class="item">
                                    <div class="product-layout item-inner style1 ">
                                        <div class="item-image">
                                            <div class="item-img-info">
                                                <a href="#" target="_self" title="Mandouille short ">
                                                    <img src="<?php echo SITE_URL; ?>img/catalog/demo/product/80/1.jpg" alt="Mandouille short">
                                                    </a>
                                            </div>
                                            
                                        </div>
                                        <div class="item-info">
                                            <div class="item-title">
                                                <a href="#" target="_self" title="Mandouille short">Mandouille short </a>
                                            </div>
                                            <div class="rating">
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                            </div>
                                            <div class="content_price price">
                                                <span class="price-new product-price">$55.00 </span>&nbsp;&nbsp;

                                                <span class="price-old">$76.00 </span>&nbsp;

                                            </div>
                                        </div>
                                        <!-- End item-info -->
                                        <!-- End item-wrap-inner -->
                                    </div>
                                    <!-- End item-wrap 
                                    <div class="product-layout item-inner style1 ">
                                        <div class="item-image">
                                            <div class="item-img-info">
                                                <a href="#" target="_self" title="Xancetta bresao ">
                                                        <img src="image/catalog/demo/product/80/2.jpg" alt="Xancetta bresao">
                                                        </a>
                                            </div>
                                            
                                        </div>
                                        <div class="item-info">
                                            <div class="item-title">
                                                <a href="#" target="_self" title="Xancetta bresao">
                                                            Xancetta bresao 
                                                        </a>
                                            </div>
                                            <div class="rating">
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                            </div>
                                            <div class="content_price price">
                                                <span class="price-new product-price">$80.00 </span>&nbsp;&nbsp;

                                                <span class="price-old">$89.00 </span>&nbsp;



                                            </div>
                                        </div>
                                       
                                    </div>
                                   
                                    <!-- End item-wrap -->
                                </div>
                            </div>
                            <!--End extraslider-inner -->
                        </div>
                    </div>
                </div>
                <div class="module banner-left hidden-xs ">
                	<div class="banner-sidebar banners">
                      <div>
                          <?php if(isset($rowCategoryProductBottom->slider_image) && $rowCategoryProductBottom->slider_image!='')
{ ?>
        
                  
                <a href="<?php if($rowCategoryProductBottom->slider_url!=''){ echo $rowCategoryProductBottom->slider_url;  }else{ echo '#'; } ?>"><img src="<?php echo SITE_UPLOAD_URL.SITE_SLIDER_IMAGE_PATH.$rowCategoryProductBottom->slider_image; ?>" alt="image"></a>
           
            
            <?php } ?>
                     
                      </div>
                    </div>
                </div>
            </aside>
            <!--Left Part End -->
			
        	<!--Middle Part Start-->
        	<div id="content" class="col-md-9 col-sm-8">
        		<div class="products-category">
                    <h3 class="title-category "><?php echo $strPageTitle; ?></h3>
        			<div class="category-desc">
        				<div class="row">
        					<div class="col-sm-12">
        						<div class="banners">
        							<div>
        							  <?php if(isset($rowCategoryInfo->category_banner) && $rowCategoryInfo->category_banner!='')
        							    { ?>
        								<a  href="javascript:;"><img src="<?php echo SITE_UPLOAD_URL; ?>category_icon/<?php echo $rowCategoryInfo->category_banner; ?>" alt="<?php echo $rowCategoryInfo->category_name; ?>"><br></a>
        								<?php } ?>
        							</div>
        						</div>
        					
        					</div>
        				</div>
        			</div>
        			<!-- Filters -->
                    <div class="product-filter product-filter-top filters-panel">
                        <div class="row" style="display:none">                          
                            <div class="short-by-show form-inline  col-md-7 col-sm-9 col-xs-12">
                                <div class="form-group short-by">
                                    <label class="control-label" for="input-sort">Sort By:</label>
                                    <select id="input-sort" class="form-control"
                                    onchange="location = this.value;">
                                        <option value="" selected="selected">Default</option>
                                        <option value="">Name (A - Z)</option>
                                        <option value="">Name (Z - A)</option>
                                        <option value="">Price (Low &gt; High)</option>
                                        <option value="">Price (High &gt; Low)</option>
                                        <option value="">Rating (Highest)</option>
                                        <option value="">Rating (Lowest)</option>
                                        <option value="">Model (A - Z)</option>
                                        <option value="">Model (Z - A)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="input-limit">Show:</label>
                                    <select id="input-limit" class="form-control" onchange="location = this.value;">
                                        <option value="" selected="selected">15</option>
                                        <option value="">25</option>
                                        <option value="">50</option>
                                        <option value="">75</option>
                                        <option value="">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- //end Filters -->

        			<!--changed listings-->
                    <div class="products-list">
            	<?php 
   	$counter =0;         	
            	
            	foreach($resCategoryProductList as $rowProductInfo)
{ 
 $intPercent =round(($rowProductInfo['product_discount_selling']/$rowProductInfo['product_selling_price'])*100);

$counter++;
  $rowSelectReview =$conn->execute('SELECT count(*) as total,AVG(pr_rating) as avgrating FROM sk_product_review WHERE 1 AND pr_product_id='.$rowProductInfo['product_id'])->fetch('assoc');
  
  
  if($counter%5==0)
{
    
    echo '</div> <div class="products-list">';
}


?>
        				<div class="product-layout product-grid col-md-3 col-sm-6 col-xs-12">
                         <div class="product-item-container">
                                    <div class="left-block left-b">
                                        <?php if($intPercent>0)
                                        { ?>
                                        <div class="box-label">
                                            <span class="label-product label-sale"><?php echo $intPercent; ?>% off</span>
                                        </div>
                                        <?php } ?>
                                        <div class="product-image-container second_img">
                                            <a href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowProductInfo['product_slug']; ?>" target="_self" title="<?php echo $rowProductInfo['product_name']; ?>">
                                               <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_featured_image']; ?>" class="img-1 img-responsive" alt="<?php echo $rowProductInfo['product_name']; ?>">
                                                <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_featured_image']; ?>" class="img-2 img-responsive" alt="<?php echo $rowProductInfo['product_name']; ?>">
                                            </a>											
											 
                                        </div>
										
                                        <!--quickview--> 
                                        <div class="so-quickview">
                                          <a class="btn-button quickview quickview_handler visible-lg" href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowProductInfo['product_slug']; ?>" title="Quick view" ><i class="fa fa-eye"></i><span>Quick view</span></a>
                                        </div>                                                     
                                        <!--end quickview-->

                                        
                                    </div>
                                    <div class="right-block">
                                        <div class="button-group so-quickview cartinfo--left">
                                              <?php if($rowProductInfo['product_qty_in_stock']>0)
                                                { ?> 
                                            <button type="button" class="addToCart" title="Add to cart" onclick="cart.add('<?php echo $rowProductInfo['product_id']; ?>',1,'<?php echo $rowProductInfo['product_name']; ?>');">
                                                <span>Add to cart </span>   
                                            </button>
                                            <?php } ?>
                                            
                                        </div>
                                        <div class="caption hide-cont">
  <div class="ratings">
                                                <?php if($rowSelectReview['total']>0)
                                                { ?>
                                            
                                                <div class="rating-box">   
                                                    <?php $intRemaining =5-(int)$rowSelectReview['avgrating'];
                                                    for($i=0;$i<(int)$rowSelectReview['avgrating'];$i++)
                                                    { ?>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                                    <?php }  for($i=0;$i<$intRemaining;$i++)
                                                    { ?>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x gray" style="color:#ccc"></i></span>
                                                    <?php } ?>
                                                   
                                                </div>
                                                
                                                <span class="rating-num">( <?php echo $rowSelectReview['total']; ?> )</span>
                                                <?php } ?> 
                                            </div>                                             <h4><a href="<?php echo SITE_URL; ?>product-detail/<?php echo $rowProductInfo['product_slug']; ?>" title="<?php echo $rowProductInfo['product_name']; ?>" target="_self"><?php echo $rowProductInfo['product_name']; ?></a></h4>
											<p><strong>ISBN :</strong> <?php echo $rowProductInfo['product_isbn']; ?></p>
                                            
                                        </div>
                                      <p class="price">
                                          <span class="price-new">₹<?php echo $rowProductInfo['product_net_price']; ?></span>
                                          <span class="price-old">₹<?php echo $rowProductInfo['product_selling_price']; ?></span>
                                        </p>
                                    </div>

                                   
                                   
                                </div>
								</div>
				
              <?php } ?>   
                    </div>
        			<!--// End Changed listings-->
        			<!-- Filters -->
        		<div class="product-filter product-filter-bottom filters-panel">
                   <div class="row">
                            <div class="col-sm-6 text-left">
                                  <?= $this->Paginator->prev('←',['class'=>'paginate_button previous']); ?>
							    <span>
<?= $this->Paginator->numbers(); ?>
</span>
<?= $this->Paginator->next(' →'); ?>
                            </div> 
                            <div class="col-sm-6 text-right"><?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?></div>
                    </div>
                    </div>
        			<!-- //end Filters -->
        			
        		</div>
        		
        	</div>
        	

        	<!--Middle Part End-->
        </div>
    </div>
	<!-- //Main Container -->