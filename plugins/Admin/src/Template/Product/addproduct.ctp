<style>
   .checker input[type=checkbox], .choice input[type=radio] {
   border: none;
   background: none;
   display: -moz-inline-box;
   display: inline-block;
   margin: 0;
   vertical-align: top;
   cursor: pointer;
   position: absolute;
   top: -2px;
   left: -2px;
   z-index: 2;
   opacity: 0;
   filter: alpha(opacity=0);
   }
</style>
<style>
   #myProgress {
   width: 100%;
   background-color: #f5f5f5;
   margin-top: 37px;
   }
   .dashboard-panel .d-panelheading {
   width: 100%;
   color: #333;
   background-color: #fcfcfc;
   padding: 13px 15px 12px;
   border-bottom: 1px solid #e1e8ed;
   border-top-right-radius: 3px;
   border-top-left-radius: 3px;
   font-size: 16px;
   }
   .dashboard-panel .d-panelbody {
   padding: 15px;
   }
</style>
<script>var editProductId = <?php echo isset($rowProductInfo['product_id'])?$rowProductInfo['product_id']:0; ?>;</script>
<div class="page-header page-header-default">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Product Listing</h4>
      </div>
   </div>
   <div class="breadcrumb-line">
      <ul class="breadcrumb">
         <li><a href="<?php echo SITE_URL; ?>admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Products</li>
      </ul>
   </div>
</div>
<!-- /page header -->
<!-- Content area -->
<div class="content">
   <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/product/ProductProcessRequest','enctype'=>'multipart/form-data']); ?>
   <input type="hidden" name="product_id" value="<?php echo isset($rowProductInfo['product_id'])?$rowProductInfo['product_id']:0; ?>">
   <input type="hidden" name="product_copy" value="<?php echo $strCopyStatus; ?>">
   <!-- Dashboard content -->
   <div class="row">
      <div class="col-lg-8">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h5 class="panel-title">Product Details</h5>
            </div>
            <div class="panel-body" style="padding:20px 15px;">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Product Name / Title: <span style="color:red">*</span></label>
                        <div>
                           <div class="input text required"><input name="product_name" required onkeyup="return getproductslug(this.value)" placeholder=""  class="form-control" id="product_name" value="<?php echo isset($rowProductInfo['product_name'])?$rowProductInfo['product_name']:''; ?>" type="text"></div>
                           <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"><strong>Permalink:</strong> <a href="<?php echo SITE_URL; ?>product-detail/<?php echo isset($rowProductInfo['product_slug'])?$rowProductInfo['product_slug']:''; ?>" id="permalink_product" target="new"><?php echo SITE_URL; ?>product-detail/<span id="hidewhenedit"><?php echo isset($rowProductInfo['product_slug'])?$rowProductInfo['product_slug']:''; ?></span></a> <input type="text" id="permalink_val" class="hide" name="product_slug" value="<?php echo isset($rowProductInfo['product_slug'])?$rowProductInfo['product_slug']:''; ?>"> <a href="javascript:void(0);" onclick="editpermalink()" id="permalink_edit"><span class="label bg-grey-400"><i style="font-size:9px;" class="icon-pencil"></i> Edit</span></a> <a id="permalink_ok"  href="javascript:void(0);" onclick="okpermalink()" class="hide"><span class="label bg-green"> ok</span></a>&nbsp;<a id="permalink_cancel"  href="javascript:void(0);" onclick="cancelpermalink()" class="hide"><span class="label bg-grey-400">Cancel</span></a></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Product Tagline: <span style="color:red">*</span></label>
                        <div>
                           <div class="input text required"><input name="product_tagline" required placeholder=" "  class="form-control" id="product_sku" value="<?php echo isset($rowProductInfo['product_tagline'])?$rowProductInfo['product_tagline']:''; ?>" type="text"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">HSN/SAC Code: <span style="color:red">*</span></label>
                        <div>
                           <div class="input text required"><input name="product_hsn" placeholder=" " required  class="form-control" id="product_hsn" value="<?php echo isset($rowProductInfo['product_hsn'])?$rowProductInfo['product_hsn']:''; ?>" type="text"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Product Code / SKU: <span style="color:red">*</span></label>
                        <div>
                           <div class="input text required"><input name="product_sku" placeholder=" " required  class="form-control" id="product_sku" value="<?php echo isset($rowProductInfo['product_sku'])?$rowProductInfo['product_sku']:''; ?>" type="text"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Model No: <span style="color:red">*</span></label>
                        <div>
                           <div class="input text required"><input name="product_model" placeholder=" " required  class="form-control" id="product_hsn" value="<?php echo isset($rowProductInfo['product_hsn'])?$rowProductInfo['product_hsn']:''; ?>" type="text"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group" style="">
                        <label class="control-label"> <span style="color:red"></span></label>
                     </div>
                     <div class="input text" >
                        <input class="styled" id="is_return" <?php echo (isset($rowProductInfo['product_is_return']) && $rowProductInfo['product_is_return'] == 1)?"checked":""; ?> name="is_return" value="1" type="checkbox">
                        Is return policy applicable?:
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group" style="">
                        <label class="control-label">No. of days in which product can be returned: <span style="color:red"></span></label>
                        <div>
                           <div class="input text ">
                              <?php $disabled = (isset($rowProductInfo['product_is_return']) && $rowProductInfo['product_is_return'] == 0)?"disabled":""; ?>
                              <?php $disabledn = (empty($rowProductInfo))?"disabled":""; ?>
                              <input name="return_days" <?php echo $disabled ;echo $disabledn; ?>  min="0" placeholder=" "  class="form-control" id="return_days" value="<?php echo isset($rowProductInfo['product_return_days'])?$rowProductInfo['product_return_days']:0; ?>" type="number">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right11" style="margin-bottom:20px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right11" href="#accordion-control-right-group11">Descritpion</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group11" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:0px" >
                     <textarea name="product_desc" class="summernote"><?php echo isset($rowProductInfo['product_desc'])?$rowProductInfo['product_desc']:''; ?></textarea>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right11" style="margin-bottom:20px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right11" href="#accordion-control-right-group11">Highlights</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group11" class="panel-collapse collapse in">
                  <div class="panel-body"  >
                     <?php $aryExplodeHighlight = isset($rowProductInfo['product_highlights'])?explode('######',$rowProductInfo['product_highlights']):array(); ?>
                     <?php foreach($aryExplodeHighlight as $key=>$label)
                        {   
                           if($label!='')
                        { ?>
                     <div class="row clsparentrow" style="margin-bottom:20px">
                        <div class="col-lg-10">
                           <input type="text" name="product_highlights_[]" class="form-control" value="<?php echo $label; ?>">
                        </div>
                        <div class="col-lg-2 clsaddmorebutton">
                           <button type="button" onclick="removehighlights($(this))" class="btn btn-danger btn-xs"><i class="icon-cross3"></i> Remove</button>
                        </div>
                     </div>
                     <?php }} ?>
                     <div class="row clsparentrow">
                        <div class="col-lg-10">
                           <input type="text" name="product_highlights_[]" class="form-control">
                        </div>
                        <div class="col-lg-2 clsaddmorebutton">
                           <button type="button" style="height: 40px;" onclick="addMoreHighlights($(this))" class="btn btn-info btn-xs"><i class="icon-plus2"></i> Add More</button>
                        </div>
                     </div>
                     <div class="replacehighlights"> </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h5 class="panel-title">Others</h5>
            </div>
            <div class="panel-body" style="padding:20px 15px;">
               <div class="row">
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Fabric: <span style="color:red"></span></label>
                        <div class="input text required">
                           <select name="product_fabric[]" class="select" >
                              <option value="">Select</option>
                              <?php 
                                 foreach($resFabricList as $rowFabricList)
                                 {
                                 ?>
                              <option <?php echo (isset($rowProductInfo->product_fabric) && $rowProductInfo->product_fabric==$rowFabricList->attterms_name)?'selected="selected"':''; ?> value="<?php echo $rowFabricList->attterms_name; ?>"><?php echo $rowFabricList->attterms_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Occasion: <span style="color:red"></span></label>
                        <div class="input text required">
                           <select name="product_occasion[]" class="select" >
                              <option value="">Select</option>
                              <?php 
                                 foreach($resOccasionList as $rowOccasionList)
                                 {
                                 ?>
                              <option <?php echo (isset($rowProductInfo->product_occasion) && $rowProductInfo->product_occasion==$rowOccasionList->attterms_name)?'selected="selected"':''; ?> value="<?php echo $rowOccasionList->attterms_name; ?>"><?php echo $rowOccasionList->attterms_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Design: <span style="color:red"></span></label>
                        <div class="input text required">
                           <select name="product_design[]" class="select" >
                              <option value="">Select</option>
                              <?php 
                                 foreach($resDesignList as $rowDesignList)
                                 {
                                 ?>
                              <option <?php echo (isset($rowProductInfo->product_design) && $rowProductInfo->product_design==$rowDesignList->attterms_name)?'selected="selected"':''; ?> value="<?php echo $rowDesignList->attterms_name; ?>"><?php echo $rowDesignList->attterms_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Product Style: <span style="color:red"></span></label>
                        <div class="input text required">
                           <select name="product_style[]" class="select" >
                              <option value="">Select</option>
                              <?php 
                                 foreach($resProductStyleList as $rowProductStyleList)
                                 {
                                 ?>
                              <option <?php echo (isset($rowProductInfo->product_style) && $rowProductInfo->product_style==$rowProductStyleList->attterms_name)?'selected="selected"':''; ?> value="<?php echo $rowProductStyleList->attterms_name; ?>"><?php echo $rowProductStyleList->attterms_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Product Fit: <span style="color:red"></span></label>
                        <div class="input text required">
                           <select name="product_fit[]" class="select required" >
                              <option value="">Select</option>
                              <?php 
                                 foreach($resProductFitList as $rowProductFitList)
                                 {
                                 ?>
                              <option <?php echo (isset($rowProductInfo->product_fit) && $rowProductInfo->product_fit==$rowProductFitList->attterms_name)?'selected="selected"':''; ?> value="<?php echo $rowProductFitList->attterms_name; ?>"><?php echo $rowProductFitList->attterms_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Neck Type: <span style="color:red"></span></label>
                        <div class="input text required">
                           <select name="product_neck_type[]" class="select required" >
                              <option value="">Select</option>
                              <?php 
                                 foreach($resNeckTypeList as $rowNeckTypeList)
                                 {
                                 ?>
                              <option <?php echo (isset($rowProductInfo->product_neck_type) && $rowProductInfo->product_neck_type==$rowNeckTypeList->attterms_name)?'selected="selected"':''; ?> value="<?php echo $rowNeckTypeList->attterms_name; ?>"><?php echo $rowNeckTypeList->attterms_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Sleeve: <span style="color:red"></span></label>
                        <div class="input text required">
                           <select name="product_sleeve[]" class="select required" >
                              <option value="">Select</option>
                              <?php 
                                 foreach($resSleeveList as $rowSleeveList)
                                 {
                                 ?>
                              <option <?php echo (isset($rowProductInfo->product_sleeve) && $rowProductInfo->product_sleeve==$rowSleeveList->attterms_name)?'selected="selected"':''; ?> value="<?php echo $rowSleeveList->attterms_name; ?>"><?php echo $rowSleeveList->attterms_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h5 class="panel-title">Pricing & Quantity</h5>
            </div>
            <div class="panel-body" style="padding:20px 15px;">
               <legend class="text-bold">Pricing</legend>
               <?php foreach($resProductBusinessArray as $rowProductBusinessArray)
                  { ?>
               <div class="row clsparentforremove">
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Unit: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <select name="pu_unit[]" class="select required" required>
                              <option value="">Select</option>
                              <?php 
                                 $strHtml ='';
                                 foreach($resUnitList as $rowUnitList)
                                 {
                                 $strHtml .='<option value="'.$rowUnitList->unit_id.'">'.$rowUnitList->unit_name.'</option>';
                                 ?>
                              <option <?php echo (isset($rowProductBusinessArray->pu_unit) && $rowProductBusinessArray->pu_unit==$rowUnitList->unit_id)?'selected="selected"':''; ?> value="<?php echo $rowUnitList->unit_id; ?>"><?php echo $rowUnitList->unit_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Size: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <select name="pu_size[]" class="select required" required>
                              <option value="">Select</option>
                              <?php 
                                 $strSizeHtml ='';
                                 foreach($resSizeList as $rowSizeList)
                                 {
                                 $strSizeHtml .='<option value="'.$rowSizeList->size_id.'">'.$rowSizeList->size_name.'</option>';
                                 ?>
                              <option <?php echo (isset($rowProductBusinessArray->pu_size) && $rowProductBusinessArray->pu_size==$rowSizeList->size_id)?'selected="selected"':''; ?> value="<?php echo $rowSizeList->size_id; ?>"><?php echo $rowSizeList->size_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Avail Qty: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <input class="form-control" required placeholder="0.00" type="text"  id="qty_price" name="pu_qty[]" value="<?php echo isset($rowProductBusinessArray->pu_qty)?$rowProductBusinessArray->pu_qty:''; ?>"> 
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px; margin-right: -31px;">
                        <label class="control-label">Selling Price/ Piece: <span style="color:red">*</span></label>
                        <div>
                           <div class="input-group">
                              <span class="input-group-addon">₹</span>
                              <input class="form-control" required  id="sellingprice" placeholder="0.00" type="text" name="pu_selling_price[]" value="<?php echo isset($rowProductBusinessArray->pu_selling_price)?$rowProductBusinessArray->pu_selling_price:''; ?>" onkeyup="getnetbusinessprice($(this))" onblur="getnetbusinessprice($(this))">
                           </div>
                           <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2" style="margin-left: 1px;">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Discount/ Piece:</label>
                        <div>
                           <div class="input-group">
                              <span class="input-group-addon">₹</span>
                              <input class="form-control"  placeholder="0.00" type="text" name="pu_discount[]" value="<?php echo isset($rowProductBusinessArray->pu_discount)?$rowProductBusinessArray->pu_discount:''; ?>" onkeyup="getnetbusinessprice($(this))" id="discount_business"  onblur="getnetbusinessprice($(this))">
                           </div>
                           <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Net Price/ Piece:</label>
                        <div>
                           <div class="input-group">
                              <span class="input-group-addon">₹</span>
                              <input class="form-control" placeholder="0.00" type="text" name="pu_net_price[]" value="<?php echo isset($rowProductBusinessArray->pu_net_price)?$rowProductBusinessArray->pu_net_price:''; ?>"  id="netprice_business" readonly>
                           </div>
                           <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">MOQ: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <input class="form-control" required placeholder="0.00" type="text"  id="qty_moq" name="pu_moq[]" value="<?php echo isset($rowProductBusinessArray->pu_moq)?$rowProductBusinessArray->pu_moq:''; ?>"> 
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Item in Pack: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <input class="form-control" required placeholder="0.00" type="text"  id="qty_item_pack" name="pu_item_pack[]" value="<?php echo isset($rowProductBusinessArray->pu_item_pack)?$rowProductBusinessArray->pu_item_pack:''; ?>"> 
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-1">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">&nbsp;</label>
                        <div class="clsparentaddmore">
                           <a href="javascript:void();" onclick="removeprice($(this))" class="btn btn-danger btn-icon btn-rounded"><i class="icon   icon-minus3"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php   } ?>
               <?php $req = empty($resProductBusinessArray)?"required":""; ?>
               <div class="row clsparentforremove">
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Unit: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <select name="pu_unit[]" class="select" <?php echo $req; ?>>
                              <option value="">Select</option>
                              <?php 
                                 $strHtml ='';
                                 foreach($resUnitList as $rowUnitList)
                                 {
                                 $strHtml .='<option value="'.$rowUnitList->unit_id.'">'.$rowUnitList->unit_name.'</option>';
                                 ?>
                              <option value="<?php echo $rowUnitList->unit_id; ?>"><?php echo $rowUnitList->unit_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Size: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <select name="pu_size[]" class="select" <?php echo $req; ?>>
                              <option value="">Select</option>
                              <?php 
                                 $strSizeHtml ='';
                                 foreach($resSizeList as $rowSizeList)
                                 {
                                 $strSizeHtml .='<option value="'.$rowSizeList->size_id.'">'.$rowSizeList->size_name.'</option>';
                                 ?>
                              <option value="<?php echo $rowSizeList->size_id; ?>"><?php echo $rowSizeList->size_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Avail Qty: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <input class="form-control" placeholder="0.00" type="text"  id="qty_price" name="pu_qty[]" value="" <?php echo $req; ?>> 
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px; margin-right: -31px;">
                        <label class="control-label">Selling Price/ Piece: <span style="color:red">*</span></label>
                        <div>
                           <div class="input-group">
                              <span class="input-group-addon">₹</span>
                              <input class="form-control" <?php echo $req; ?>  id="sellingprice" placeholder="0.00" type="text" name="pu_selling_price[]" value="" onkeyup="getnetbusinessprice($(this))" onblur="getnetbusinessprice($(this))">
                           </div>
                           <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2" style="margin-left: 1px;">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Discount/ Piece:</label>
                        <div>
                           <div class="input-group">
                              <span class="input-group-addon">₹</span>
                              <input class="form-control" placeholder="0.00" type="text" name="pu_discount[]" value="" onkeyup="getnetbusinessprice($(this))" id="discount_business"  onblur="getnetbusinessprice($(this))">
                           </div>
                           <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Net Price/ Piece:</label>
                        <div>
                           <div class="input-group">
                              <span class="input-group-addon">₹</span>
                              <input class="form-control" placeholder="0.00" type="text" name="pu_net_price[]" value=""  id="netprice_business" readonly>
                           </div>
                           <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">MOQ: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <input class="form-control" <?php echo $req; ?> placeholder="0.00" type="text"  id="qty_price" name="pu_moq[]" value=""> 
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Item in Pack: <span style="color:red">*</span></label>
                        <div class="input text required">
                           <input class="form-control" <?php echo $req; ?> placeholder="0.00" type="text"  id="qty_price" name="pu_item_pack[]" value=""> 
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-1">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">&nbsp;</label>
                        <div class="clsparentaddmore">
                           <a href="javascript:void();" onclick="addmoreprice($(this))" class="btn btn-success btn-icon btn-rounded"><i class="icon  icon-plus3"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="appendaddmorecontent"></div>
               <legend class="text-bold">Taxable Product</legend>
               <div class="form-group" style="margin-bottom: 10px;">
                  <label class="control-label"> Tax Class:</label>
                  <div>
                     <div class="input text required">
                        <select class="select" name="product_tax_class" >
                           <option>Select</option>
                           <option value="0" <?php echo  (isset($rowProductInfo['product_tax_class']) && $rowProductInfo['product_tax_class']==0)?'selected="selected"':'';?>>None</option>
                           <?php foreach($resTaxList as $rowTaxList) 
                              { 
                               $strSelect = (isset($rowProductInfo['product_tax_class']) && $rowProductInfo['product_tax_class']==$rowTaxList->tax_id)?'selected="selected"':''; ?>
                           <option <?php echo $strSelect; ?> value="<?php echo  $rowTaxList->tax_id; ?>"><?php echo  $rowTaxList->tax_title; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;">Choose tax class in which this product belongs. You can add them from Tax Section (<a href="<?php echo "/admin/taxes"; ?>" target="new">Click Here</a>). </span>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h5 class="panel-title">Images</h5>
               <div class="heading-elements">
                  <div class="row hide" style="    margin-bottom: 10px;" id="progressbarshow">
                     <div class="col-lg-12">
                        <div class="progress ">
                           <div class="progress-bar progress-bar-success" id="myBar"  style="width: 5%">
                              <span id="title-percent">0% Complete</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <input type="file" id="product_image" style="display:none">
            </div>
            <div class="panel-body" style="padding:20px 15px;">
               <div class="row hide" style="    margin-bottom: 10px;" id="image-error">
                  <div class="col-lg-12">
                     <div class="alert alert-danger">
                        jpeg,jpg or png extension are allowed.
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-6">
                     <?php if(isset($rowProductInfo['product_image1']) && $rowProductInfo['product_image1']!='')
                        { ?>
                     <div class="img-upload img-upload-big " style="height:auto">
                        <a href="javascript:;" onclick="removepicture('1',$(this))" class="remove-img"><span style="font-size:12px;"><i class="icon-trash"></i> </span></a> 
                        <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image1'];?>" onclick="changePicture('image1')" id="image1" class="" style="width:100%">   
                        <input type="hidden" name="product_image1" value="<?php echo $rowProductInfo['product_image1']; ?>">
                        <div class="icon-click hide" id="image1-icon">
                           <a href="javascript:;" onclick="changePicture('image1')"><i class="icon-image2"></i><br>
                           <span style="font-size:14px;">Click Here to Upload Image</span></a>
                        </div>
                     </div>
                     <?php }else{ ?>
                     <div class="img-upload img-upload-big " >
                        <img src="/admin/images/placeholder.jpg" onclick="changePicture('image1')" id="image1" class="hide" style="width:100%">   
                        <div class="icon-click" id="image1-icon">
                           <a href="javascript:;" onclick="changePicture('image1')"><i class="icon-image2"></i><br>
                           <span style="font-size:14px;">Click Here to Upload Image</span></a>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
                  <div class="col-lg-6">
                     <div class="row">
                        <div class="col-lg-6">
                           <?php if(isset($rowProductInfo['product_image2']) && $rowProductInfo['product_image2']!='')
                              { ?>
                           <div class="img-upload img-upload-small" style="height:auto">
                              <a href="javascript:;" onclick="removepicture('2',$(this))" class="remove-img"><span style="font-size:12px;"><i class="icon-trash"></i></span></a> 
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image2'];?>" onclick="changePicture('image2')" id="image2" class="" style="width:100%">   
                              <input type="hidden" name="product_image2" value="<?php echo $rowProductInfo['product_image2']; ?>">
                              <div class="icon-click hide" style="margin-top:5px;" id="image2-icon">
                                 <a href="javascript:;" onclick="changePicture('image2')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                           </div>
                           <?php }else{ ?>
                           <div class="img-upload img-upload-small" >
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image2')" id="image2" class="hide" style="width:100%">   
                              <div class="icon-click" style="margin-top:5px;" id="image2-icon">
                                 <a href="javascript:;" onclick="changePicture('image2')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                        <div class="col-lg-6">
                           <div class="img-upload img-upload-small" >
                              <?php if(isset($rowProductInfo['product_image3']) && $rowProductInfo['product_image3']!='')
                                 { ?>
                              <a href="javascript:;" onclick="removepicture('3',$(this))" style="color: red;float: right;"><span style="font-size:14px;">Remove</span></a> 
                              <input type="hidden" name="product_image3" value="<?php echo $rowProductInfo['product_image3']; ?>">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image3'];?>" onclick="changePicture('image3')" id="image3" class="" style="width:100%"> 
                              <div class="icon-click hide" style="margin-top:5px;" id="image3-icon">
                                 <a href="javascript:;" onclick="changePicture('image3')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php }else{ ?>
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image3')" id="image3" class="hide" style="width:100%"> 
                              <div class="icon-click" style="margin-top:5px;" id="image3-icon">
                                 <a href="javascript:;" onclick="changePicture('image3')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                     <div class="row" style="margin-top:10px;">
                        <div class="col-lg-6">
                           <div class="img-upload img-upload-small" >
                              <?php if(isset($rowProductInfo['product_image4']) && $rowProductInfo['product_image4']!='')
                                 { ?>
                              <a href="javascript:;" onclick="removepicture('4',$(this))" style="color: red;float: right;"><span style="font-size:14px;">Remove</span></a> 
                              <input type="hidden" name="product_image4" value="<?php echo $rowProductInfo['product_image4']; ?>">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image4'];?>" onclick="changePicture('image4')" id="image4" class="" style="width:100%">   
                              <div class="icon-click hide" style="margin-top:5px;" id="image4-icon">
                                 <a href="javascript:;" onclick="changePicture('image4')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php }else{ ?>
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image4')" id="image4" class="hide" style="width:100%">   
                              <div class="icon-click" style="margin-top:5px;" id="image4-icon">
                                 <a href="javascript:;" onclick="changePicture('image4')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="img-upload img-upload-small" >
                              <?php if(isset($rowProductInfo['product_image5']) && $rowProductInfo['product_image5']!='')
                                 { ?>
                              <a href="javascript:;" onclick="removepicture('5',$(this))" style="color: red;float: right;"><span style="font-size:14px;">Remove</span></a> 
                              <input type="hidden" name="product_image5" value="<?php echo $rowProductInfo['product_image5']; ?>">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image5'];?>" onclick="changePicture('image5')" id="image5" style="width:100%">
                              <div class="icon-click hide" style="margin-top:5px;" id="image5-icon">
                                 <a href="javascript:;" onclick="changePicture('image5')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php }else{ ?>
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image5')" id="image5" class="hide" style="width:100%">
                              <div class="icon-click" style="margin-top:5px;" id="image5-icon">
                                 <a href="javascript:;" onclick="changePicture('image5')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php  } ?>
                           </div>
                        </div>
                     </div>
                     <div class="row" style="margin-top:10px;">
                        <div class="col-lg-6">
                           <div class="img-upload img-upload-small" >
                              <?php if(isset($rowProductInfo['product_image6']) && $rowProductInfo['product_image6']!='')
                                 { ?>
                              <a href="javascript:;" onclick="removepicture('6',$(this))" style="color: red;float: right;"><span style="font-size:14px;">Remove</span></a> 
                              <input type="hidden" name="product_image6" value="<?php echo $rowProductInfo['product_image6']; ?>">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image6'];?>" onclick="changePicture('image6')" id="image6" class="" style="width:100%">   
                              <div class="icon-click hide" style="margin-top:5px;" id="image6-icon">
                                 <a href="javascript:;" onclick="changePicture('image6')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php }else{ ?>
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image6')" id="image6" class="hide" style="width:100%">   
                              <div class="icon-click" style="margin-top:5px;" id="image6-icon">
                                 <a href="javascript:;" onclick="changePicture('image6')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="img-upload img-upload-small" >
                              <?php if(isset($rowProductInfo['product_image7']) && $rowProductInfo['product_image7']!='')
                                 { ?>
                              <a href="javascript:;" onclick="removepicture('7',$(this))" style="color: red;float: right;"><span style="font-size:14px;">Remove</span></a> 
                              <input type="hidden" name="product_image7" value="<?php echo $rowProductInfo['product_image7']; ?>">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image5'];?>" onclick="changePicture('image7')" id="image7" style="width:100%">
                              <div class="icon-click hide" style="margin-top:5px;" id="image7-icon">
                                 <a href="javascript:;" onclick="changePicture('image7')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php }else{ ?>
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image5')" id="image7" class="hide" style="width:100%">
                              <div class="icon-click" style="margin-top:5px;" id="image7-icon">
                                 <a href="javascript:;" onclick="changePicture('image7')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php  } ?>
                           </div>
                        </div>
                     </div>
                     <div class="row" style="margin-top:10px;">
                        <div class="col-lg-6">
                           <div class="img-upload img-upload-small" >
                              <?php if(isset($rowProductInfo['product_image8']) && $rowProductInfo['product_image8']!='')
                                 { ?>
                              <a href="javascript:;" onclick="removepicture('8',$(this))" style="color: red;float: right;"><span style="font-size:14px;">Remove</span></a> 
                              <input type="hidden" name="product_image8" value="<?php echo $rowProductInfo['product_image8']; ?>">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image8'];?>" onclick="changePicture('image8')" id="image8" class="" style="width:100%">   
                              <div class="icon-click hide" style="margin-top:5px;" id="image8-icon">
                                 <a href="javascript:;" onclick="changePicture('image8')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php }else{ ?>
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image8')" id="image8" class="hide" style="width:100%">   
                              <div class="icon-click" style="margin-top:5px;" id="image8-icon">
                                 <a href="javascript:;" onclick="changePicture('image8')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="img-upload img-upload-small" >
                              <?php if(isset($rowProductInfo['product_image9']) && $rowProductInfo['product_image9']!='')
                                 { ?>
                              <a href="javascript:;" onclick="removepicture('9',$(this))" style="color: red;float: right;"><span style="font-size:14px;">Remove</span></a> 
                              <input type="hidden" name="product_image9" value="<?php echo $rowProductInfo['product_image9']; ?>">
                              <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo['product_image9'];?>" onclick="changePicture('image9')" id="image9" style="width:100%">
                              <div class="icon-click hide" style="margin-top:5px;" id="image9-icon">
                                 <a href="javascript:;" onclick="changePicture('image9')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php }else{ ?>
                              <img src="/admin/images/placeholder.jpg" onclick="changePicture('image9')" id="image9" class="hide" style="width:100%">
                              <div class="icon-click" style="margin-top:5px;" id="image9-icon">
                                 <a href="javascript:;" onclick="changePicture('image9')"><i class="icon-image2" style="font-size: 32px;"></i><br>
                                 <span style="font-size:12px;">Click Here to Upload Image</span></a>
                              </div>
                              <?php  } ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:20px !important;">
            <div class="panel panel-white" style=" border-radius:0px;">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group2">Search engine listing preview
                     </a>
                  </h6>
               </div>
               <div id="accordion-control-right-group2" class="panel-collapse collapse">
                  <div class="panel-body" style="padding:20px 15px;">
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Meta Title:</label>
                        <div>
                           <div class="input text required"><input name="product_meta_title"  placeholder="Enter Meta Title"  id="product_meta_title"  onkeyup="changeseop()" class="form-control" value="<?php echo isset($rowProductInfo['product_meta_title'])?$rowProductInfo['product_meta_title']:''; ?>" type="text"></div>
                           <span style="font-size:11px;color:#999"> Max length 70 characters</span>
                        </div>
                     </div>
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Meta Keywords:</label>
                        <div>
                           <div class="input text required">
                              <textarea rows="3" cols="5" id="product_meta_keyword" name="product_meta_keyword" class="form-control" placeholder="Keyword-1, Keyword-2, Keyword-3... " onkeyup="changeseop()" onblur="changeseop()" ><?php echo isset($rowProductInfo['product_meta_keyword'])?$rowProductInfo['product_meta_keyword']:''; ?></textarea>
                           </div>
                           <span style="font-size:11px;color:#999">Max length 160 characters</span>
                        </div>
                     </div>
                     <div class="form-group" style="margin-bottom: 10px;">
                        <label class="control-label">Meta Description:</label>
                        <div>
                           <div class="input text required"><textarea rows="3" cols="5" class="form-control" onkeyup="changeseop()" onblur="changeseop()" id="product_meta_desc" name="product_meta_description" placeholder="Description"><?php echo isset($rowProductInfo['product_meta_description'])?$rowProductInfo['product_meta_description']:''; ?></textarea></div>
                           <span style="font-size:11px;color:#999">Max length 250 characters</span>
                        </div>
                     </div>
                     <div class="panel-body" style="padding:15px;border: 1px solid #ddd; background:#f5f5f5;">
                        <span style="font-size:13px;color:#999">Search engine listing preview</span>
                        <h4 style="color: #1a0dab;font-size:16px;font-weight: 500;margin-bottom: 5px;" id="seo_title"></h4>
                        <p style="color: #3c763d;margin-bottom: 5px;" id="seo_url"></p>
                        <span style="font-size:13px;color:#666" id="seo_description"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:20px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group22"><?php if(isset($rowProductInfo['product_id']) && $rowProductInfo['product_id']>0){ echo 'Update'; }else{ echo 'Publish'; } ?></a>
                  </h6>
               </div>
               <div id="accordion-control-right-group22" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:10px 15px;">
                     <p>
                        <button type="submit" class="btn btn-default  btn-xs" name="saveproductdraft"> Save Draft</button>
                        <a href="javascript:;" id="preview-product" target="new" class="btn btn-default  btn-xs" style="float:right" > Preview</a>
                     </p>
                     <p>
                        <i class="icon-eye"></i> Visibility: <strong>Public</strong> <a href="javascript:;" onclick="$('.clsshowvisible').toggle(100)" style="text-decoration:underline">Edit</a>
                     </p>
                     <div style="background:#f5f5f5;padding:0px 10px; border:1px solid #ddd; margin-bottom:10px;display:none"  class=" clsshowvisible">
                        <div class="radio">
                           <label style="padding-left: 20px;">
                           <input name="product_visibility" checked="checked" type="radio">
                           Public
                           </label>
                        </div>
                        <div class="radio">
                           <label style="padding-left: 20px;">
                           <input name="product_visibility" type="radio">
                           Password protected
                           </label>
                        </div>
                        <div class="radio">
                           <label style="padding-left: 20px;">
                           <input name="product_visibility" type="radio">
                           Private
                           </label>
                        </div>
                     </div>
                     <p><i class="icon-calendar3"></i> Publish immediately <a href="javascript:;" onclick="$('.clspublish').toggle(100)" style="text-decoration:underline">Edit</a></p>
                     <div style="background:#f5f5f5;padding:10px; border:1px solid #ddd;display:none"  class="clspublish">
                        <div class="row">
                           <div class="col-lg-3">
                              <select style="width:100%" name="publish_month">
                                 <option value="01" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='01' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='01')?'selected="selected"':'';?> data-text="Jan">01-Jan</option>
                                 <option value="02" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='02' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='02')?'selected="selected"':'';?> data-text="Feb">02-Feb</option>
                                 <option value="03" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='03' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='03')?'selected="selected"':'';?> data-text="Mar">03-Mar</option>
                                 <option value="04" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='04' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='04')?'selected="selected"':'';?> data-text="Apr">04-Apr</option>
                                 <option value="05" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='05' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='05')?'selected="selected"':'';?> data-text="May">05-May</option>
                                 <option value="06" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='06' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='06')?'selected="selected"':'';?> data-text="Jun">06-Jun</option>
                                 <option value="07" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='07' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='07')?'selected="selected"':'';?> data-text="Jul">07-Jul</option>
                                 <option value="08" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='08' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='08')?'selected="selected"':'';?> data-text="Aug">08-Aug</option>
                                 <option value="09" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='09' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='09')?'selected="selected"':'';?> data-text="Sep" >09-Sep</option>
                                 <option value="10" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='10' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='10')?'selected="selected"':'';?> data-text="Oct">10-Oct</option>
                                 <option value="11" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='11' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='11')?'selected="selected"':'';?> data-text="Nov">11-Nov</option>
                                 <option value="12" <?php echo (!isset($rowProductInfo['product_publish_date']) && date('m')=='12' || isset($rowProductInfo['product_publish_date']) && date('m',strtotime($rowProductInfo['product_publish_date']))=='12')?'selected="selected"':'';?> data-text="Dec">12-Dec</option>
                              </select>
                           </div>
                           <div class="col-lg-2" style="padding-left:0px;">
                              <input type="text" style="width:100%;height:21px;" placeholder="<?php echo !isset($rowProductInfo['product_publish_date'])?date('d'):date('d',strtotime($rowProductInfo['product_publish_date'])); ?>" name="publish_date" value="<?php echo !isset($rowProductInfo['product_publish_date'])?date('d'):date('d',strtotime($rowProductInfo['product_publish_date'])); ?>">
                           </div>
                           <div class="col-lg-2" style="padding-left:0px; padding-right:0px;">
                              <input type="text" style="width:100%;height:21px;" placeholder="<?php echo date('Y'); ?>" name="publish_year" value="<?php echo !isset($rowProductInfo['product_publish_date'])?date('Y'):date('Y',strtotime($rowProductInfo['product_publish_date'])); ?>">
                           </div>
                           <div class="col-lg-1" style="padding-left:0px; padding-right:0px; text-align:center;">@</div>
                           <div class="col-lg-1" style="padding-left:0px;padding-right:0px;">
                              <input type="text" style="width:100%;height:21px;" placeholder="<?php echo date('h'); ?>" name="publish_hour" value="<?php echo !isset($rowProductInfo['product_publish_date'])?date('h'):date('h',strtotime($rowProductInfo['product_publish_date'])); ?>">
                           </div>
                           <div class="col-lg-1" style="padding-left:0px; padding-right:0px; text-align:center;width:2%">:</div>
                           <div class="col-lg-1" style="padding-left:0px;padding-right:0px;">
                              <input type="text" style="width:100%;height:21px;" placeholder="<?php echo date('i'); ?>" name="publish_minute" value="<?php echo !isset($rowProductInfo['product_publish_date'])?date('i'):date('i',strtotime($rowProductInfo['product_publish_date'])); ?>">
                           </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                           <div class="col-lg-2"><a href="javascript:;"  onclick="$('.clspublish').toggle(100)"><span class="label bg-blue" style="padding:3px 10px;">Save</span></a></div>
                           <div class="col-lg-2"><a href="javascript:;" style="text-decoration:underline" onclick="$('.clspublish').toggle(100)">Cancel</a></div>
                        </div>
                     </div>
                  </div>
                  <div class="panel-body" style="background:#f5f5f5; padding:10px 15px;">
                     <?php if(isset($rowProductInfo['product_id']) && $rowProductInfo['product_id']>0){ ?>
                     <a href="<?php echo SITE_URL; ?>admin/product/trash/<?php echo $rowProductInfo['product_id']; ?>" style="color:#d90000;float:left;margin-top:5px">Move to trash</a>
                     <?php } ?>
                     <button type="submit" name="new" class="btn btn-success  btn-xs" style="float:right;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);"> <?php if(isset($rowProductInfo['product_id']) && $rowProductInfo['product_id']>0){ echo 'Update'; }else{ echo 'Publish'; } ?></button>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:20px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group1">Categories</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group1" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:10px 15px;">
                     <span style="float: left;font-size: 12px;color: #999; margin-bottom:10px;">Select category in which you want to display this product. You can also select multiple categories for this product.</span>
                     <div class="tabbable">
                        <ul class="nav nav-tabs" style="margin-bottom:0px;">
                           <li class="active"><a href="#basic-tab1" data-toggle="tab">All Categories</a></li>
                           <!--	<li><a href="#basic-tab2" data-toggle="tab">Most Used</a></li>-->
                        </ul>
                        <div class="tab-content" style="border:1px solid #ddd;padding:0px 0px 0px 15px; margin-bottom:15px;">
                           <div class="tab-pane active" id="basic-tab1" style="height:200px; overflow-x:hidden;">
                              <div class="form-group" style="padding:10px 0px;">
                                 <?php
                                    echo $strCategoryTreeStructure; 
                                    ?>
                              </div>
                           </div>
                           <!--<div class="tab-pane" id="basic-tab2" style="height:200px; overflow-x:hidden;">
                              <div class="form-group" style="padding:10px 0px;">
                              
                              
                              
                              
                              </div>
                              
                              </div>-->
                        </div>
                     </div>
                     <a href="<?php echo $this->Url->build('/admin/categories'); ?>" target="new" style="font-size:14px;">+ Add New Category</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:10px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group1">On Sale</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group1" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:10px 15px;">
                     <div class="tabbable" >
                        <div class="tab-content"  style=" margin-left: 7px;">
                           <div class="custom-control custom-radio">
                              <input  type="hidden" name="product_onsale" value="0">
                              <input  style="float:left; " type="checkbox" class="custom-control-input" name="product_onsale" value="1"  <?php echo (isset($rowProductInfo['product_onsale']) && $rowProductInfo['product_onsale']==1)?'checked="checked"':''; ?>>
                              <label  style=" margin-left: 7px;" class="custom-control-label" for="good-quality">Sale</label>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:10px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group1">Rating Label</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group1" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:10px 15px;">
                     <div class="tabbable" >
                        <div class="tab-content"  style=" margin-left: 7px;">
                           <div class="custom-control custom-radio"  >
                              <input  style="float:left;" type="radio" class="custom-control-input" name="product_label" value="Excellent Quality" id="excellent-quality" <?php echo (isset($rowProductInfo['product_label']) && $rowProductInfo['product_label']=='Excellent Quality')?'checked="checked"':''; ?> >
                              <label  style=" margin-left: 7px;" class="custom-control-label" for="excellent-quality">Excellent Quality</label>
                           </div>
                           <div class="custom-control custom-radio" > 
                              <input  style="float:left;" type="radio" class="custom-control-input" name="product_label" value="Average Quality" id="average-quality" <?php echo (isset($rowProductInfo['product_label']) && $rowProductInfo['product_label']=='Average Quality')?'checked="checked"':''; ?> >
                              <label  style="margin-left: 7px;" class="custom-control-label" for="average-quality">Average Quality</label>
                           </div>
                           <div class="custom-control custom-radio">
                              <input  style="float:left; " type="radio" class="custom-control-input" name="product_label" value="Good Quality" id="good-quality" <?php echo (isset($rowProductInfo['product_label']) && $rowProductInfo['product_label']=='Good Quality')?'checked="checked"':''; ?>>
                              <label  style=" margin-left: 7px;" class="custom-control-label" for="good-quality">Good Quality </label>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:10px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group1">Tag</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group1" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:10px 15px;">
                     <span style="float: left;font-size: 12px;color: #999; margin-bottom:10px;">Select category in which you want to display this product. You can also select multiple categories for this product.</span>
                     <div class="tabbable" >
                        <div class="tab-content" style="margin-bottom:15px;">
                           <select class="select"  id="product_tag_" onchange="producttagspecification($(this))">
                              <option value="0">Select</option>
                              <?php foreach($resTagList as $rowTagList) 
                                 { 
                                 
                                  ?>
                              <option  value="<?php echo  $rowTagList->tag_id; ?>"><?php echo  $rowTagList->tag_name; ?></option>
                              <?php } ?>
                           </select>
                           <p style="margin-top:10px;line-height:37px" id="append_tag">
                              <?php foreach($resSelectedTagList as $rowSelectedTagList)				        
                                 { ?>
                              <span class="label   label-striped" style="margin-right:5px"><?php echo $rowSelectedTagList->tag_name; ?> <a href="javascript:void(0);" onclick="removetag($(this))"><i class="icon-cross3"></i></a><input type="hidden" name="product_tag_[]" value="<?php echo $rowSelectedTagList->tag_id; ?>"></span>
                              <?php } ?>
                           </p>
                        </div>
                     </div>
                     <a href="<?php echo $this->Url->build('/admin/tag'); ?>" target="new" style="font-size:14px;">+ Add New Tag</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right" style="margin-bottom:10px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group1">Brand</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group1" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:10px 15px;">
                     <div class="tabbable" >
                        <div class="tab-content" style="margin-bottom:15px;">
                           <select class="form-control select-search select2-hidden-accessible"  id="product_brand" name="product_brand" >
                              <option value="0">Select</option>
                              <?php foreach($resBrandList as $rowTagList) 
                                 { 
                                 
                                  ?>
                              <option <?php echo (isset($rowProductInfo->product_brand) && $rowProductInfo->product_brand==$rowTagList->brand_id)?'selected="selected"':'';?>  value="<?php echo  $rowTagList->brand_id; ?>"><?php echo  $rowTagList->brand_name; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <a href="<?php echo $this->Url->build('/admin/brand'); ?>" target="new" style="font-size:14px;">+ Add New Brand</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right1" style="margin-bottom:20px !important;">
            <div class="panel panel-white">
               <div class="panel-heading">
                  <h6 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion-control-right1" href="#accordion-control-right-group2">Featured Image</a>
                  </h6>
               </div>
               <div id="accordion-control-right-group2" class="panel-collapse collapse in">
                  <div class="panel-body" style="padding:10px 15px;">
                     <div class="form-group">
                        <div class="media no-margin-top">
                           <div class="media-body">
                              <div class="media no-margin-top">
                                 <div class="media-left" style="padding-right: 5px;">
                                    <?php if(isset($rowProductInfo->product_featured_image) && $rowProductInfo->product_featured_image!='')	
                                       {?>
                                    <a href="#"><img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowProductInfo->product_featured_image; ?>" style="width: 58px; height: 58px;" id="blash" alt=""></a>
                                    <?php }else{ ?>
                                    <a href="javascript:void(0);"><img src="<?php echo SITE_URL;?>/admin/images/placeholder.jpg" style="width: 58px; height: 58px;" id="blash" alt=""></a>
                                    <?php } ?>
                                 </div>
                                 <div class="media-body">
                                    <div class="uploader bg-warning">
                                       <input name="product_featured_image_" class="file-styled" type="file" onchange="readURL(this,'blash')"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action btn bg-pink-400 legitRipple" style="-moz-user-select: none;" ?="">Choose File</span>
                                    </div>
                                    <span class="help-block">Accepted: gif, png, jpg. Max file size 2Mb</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!--<a href="/admin/tag" target="new" style="font-size:14px;">+ Add New Tag</a>-->
            </div>
         </div>
      </div>
   </div>
   <!-- /dashboard content -->
   <?= $this->Form->end() ?>
</div>
<script>var csrf_tocken=<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>
<!-- /page container -->
<script>
   var aryTag =[];
   function producttagspecification(objectElemnt)
   {
      var selectedHtml = $("#product_tag_ option:selected").html();
      var selectval = objectElemnt.val();
      if(jQuery.inArray(selectval, aryTag) == -1 && selectval>0)
   {
      aryTag.push(selectval);
      $('#append_tag').append('<span class="label   label-striped" style="margin-right:5px">'+selectedHtml+' <a href="javascript:void(0);" onclick="removetag($(this))"><i class="icon-cross3"></i></a><input type="hidden" name="product_tag_[]" value="'+selectval+'"></span>');
   }    
   }
   
   function removetag(objectElement)
   {
      objectElement.parents('span').remove();
   }
   
   function addMoreHighlights(objectelement)
   {
   var strhtml = '<div class="row clsparentrow" style="margin-top:20px"><div class="col-lg-10"><input type="text" name="product_highlights_[]" class="form-control"></div><div class="col-lg-2 clsaddmorebutton"><button type="button"  style="height: 40px;" onclick="addMoreHighlights($(this))" class="btn btn-info btn-xs"><i class="icon-plus2"></i> Add More</button></div></div>';
   
   $('.replacehighlights').append(strhtml);
   objectelement.parents('.clsaddmorebutton').html('<button type="button"  style="height: 40px;" onclick="removehighlights($(this))" class="btn btn-danger btn-xs"><i class="icon-cross3"></i> Remove</button>');
   }
   
   function removehighlights(objectElement)
   {
   var confirm_ = confirm('Are you want to remove');
   if(confirm_)
   {
      objectElement.parents().parents('.clsparentrow').remove();
   }
   }
   function removepicture(strImagetype,object)
   {
      $('#image'+strImagetype).addClass('hide');
         $('.imagehover'+strImagetype).addClass('hide');
              $('#image'+strImagetype+'-icon').removeClass('hide');
                         $('input[name=product_image'+strImagetype+']').val("");
   object.remove();
              
   }
   
   
   
   function addmoreprice(objectElement)
   {
       objectElement.parents('.clsparentaddmore').html('<a href="javascript:void();" onclick="removeprice($(this))" class="btn btn-danger btn-icon btn-rounded"><i class="icon   icon-minus3"></i></a>');
       var htmldata ='<div class="row clsparentforremove"><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Unit: <span style="color:red">*</span></label><div class="input text required"><select name="pu_unit[]" class="form-control"><option value="">Select</option> <?php echo $strHtml; ?> </select></div></div></div><div class="col-lg-3"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Size: <span style="color:red">*</span></label><div class="input text required"><select name="pu_size[]" class="form-control"><option value="">Select</option> <?php echo $strSizeHtml; ?> </select></div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Avail Qty: <span style="color:red">*</span></label><div class="input text required"><input class="form-control" placeholder="0.00" type="text"  id="qty_price" name="pu_qty[]" value=""> </div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px; margin-right: -31px;"><label class="control-label">Selling Price/ Piece:</label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" placeholder="0.00" type="text"  id="sellingprice" name="pu_selling_price[]" value="" onkeyup="getnetbusinessprice($(this))" onblur="getnetbusinessprice($(this))"></div>  <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-2" style="margin-left: 1px;"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Discount/ Piece:</label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" placeholder="0.00" type="text" name="pu_discount[]" id="discount_business" value="" onkeyup="getnetbusinessprice($(this))" onblur="getnetbusinessprice($(this))"></div>  <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Net Price/ Piece:</label><div><div class="input-group"><span class="input-group-addon">₹</span><input class="form-control" placeholder="0.00" type="text" name="pu_net_price[]" id="netprice_business" value="" readonly></div>  <span style="font-size:12px;color:#999; margin-top:10px;display: inline-block;"></span></div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">MOQ: <span style="color:red">*</span></label><div class="input text required"><input class="form-control" placeholder="0.00" type="text"  id="qty_price" name="pu_moq[]" value=""> </div></div></div><div class="col-lg-2"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">Item in Pack: <span style="color:red">*</span></label><div class="input text required"><input class="form-control" placeholder="0.00" type="text"  id="qty_price" name="pu_item_pack[]" value=""> </div></div></div><div class="col-lg-1"><div class="form-group" style="margin-bottom: 10px;"><label class="control-label">&nbsp;</label><div class="clsparentaddmore"><a href="javascript:void();" onclick="addmoreprice($(this))" class="btn btn-success btn-icon btn-rounded"><i class="icon  icon-plus3"></i></a></div></div></div></div>';
       $('.appendaddmorecontent').append(htmldata);
   }
   function removeprice(objectElement)
   {
       
       var condida = confirm('Are you want to delete');
       if(condida)
       {
           
        objectElement.parents().parents().parents().parents('.clsparentforremove').remove();
       }
   }
   function readURL(input,id) {
   
   if (input.files && input.files[0]) {
   var reader = new FileReader();
   
   reader.onload = function(e) {
   $('#'+id).attr('src', e.target.result);
   }
   
   reader.readAsDataURL(input.files[0]);
   }
   }
   
   $('#is_return').on('click',function(){
   
   if($(this).prop("checked") == true){
      $('#return_days').removeAttr('disabled');
      $('#return_days').addClass('required');
   }else{
      $('#return_days').attr('disabled',true);
      $('#return_days').removeClass('required');
   }
   });
</script>