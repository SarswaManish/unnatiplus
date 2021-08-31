<div class="page-header page-header-default">
   <div class="page-header-content">
      <div class="page-title">
         <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Customer Review</h4>
      </div>
   </div>
   <div class="breadcrumb-line">
      <ul class="breadcrumb">
         <li><a href="<?php echo SITE_URL; ?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
         <li class="active">Customer Review</li>
      </ul>
   </div>
</div>
<div class="content">
   <div class="row">
      <div class="col-lg-4">
         <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/customerView/unitProcessRequest','enctype'=>'multipart/form-data']); ?>
         <div class="panel panel-flat" style="margin-bottom:0px; border-radius:0px; border-bottom: 0px;">
            <input type="hidden" name="customer_id" value="<?php echo isset($rowCategoryInfo->customer_id)?$rowCategoryInfo->customer_id:''; ?>">
            <div class="panel-body" style="padding:20px 15px;">
               <div class="form-group"  id="category-name-error" style="margin-bottom: 10px;">
                  <label class="control-label">Title: <span style="color:red">*</span></label>
                  <div>
                     <div class="input text required"><input name="customer_title"  placeholder="Enter Title" required="required" class="form-control" id="customer_title" value="<?php echo isset($rowCategoryInfo->customer_title)?$rowCategoryInfo->customer_title:''; ?>" type="text"></div>
                     <span style="font-size:11px;color:#999">The name is how it appears on your site.</span>
                  </div>
               </div>
               <div class="form-group"  id="category-name-error" style="margin-bottom: 10px;">
                  <label class="control-label">Youtube URL: <span style="color:red">*</span></label>
                  <div>
                     <div class="input text required"><input name="customer_url"  placeholder="Enter URL" required="required" class="form-control" id="customer_url" value="<?php echo isset($rowCategoryInfo->customer_url)?$rowCategoryInfo->customer_url:''; ?>" type="text"></div>
                  </div>
               </div>
               <div class="form-group"  id="category-name-error" style="margin-bottom: 10px;">
                  <label class="control-label">Review: <span style="color:red">*</span></label>
                  <div>
                     <div class="input text required"><textarea rows="3" cols="5" class="form-control" name="customer_review_text"><?php echo isset($rowCategoryInfo['customer_review_text'])?$rowCategoryInfo['customer_review_text']:''; ?></textarea></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel panel-flat" style="margin-bottom:0px; border-radius:0px; border-bottom: 0px;">
            <div class="panel-body" style="padding:20px 15px;">					
               <button type="submit" class="btn btn-primary btn-block" style="font-size:17px" onclick="return submitProcessCategory($(this))"><i class="icon-spinner2 spinner position-left spinner-form hide"></i>Save </button>
            </div>
         </div>
         <?= $this->Form->end() ?>
      </div>
      <div class="col-lg-8">
         <?= $this->Flash->render() ?>
         <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'category-form','url'=>'/admin/customerView','enctype'=>'multipart/form-data']); ?>
         <div class="panel panel-default">
            <div class="panel-body" style="background:#f5f5f5;">
               <div class="row">
                  <div class="col-md-4">
                     <div class="input-group">
                        <select class="form-control" name="bulkaction" id="bulkactionSelect">
                           <option value="">Bulk Action</option>
                           <option value="1">Delete</option>
                           <option value="2">Active</option>
                           <option value="3">Inactive</option>
                        </select>
                        <span class="input-group-btn">
                        <button class="btn bg-teal" type="submit" id="bulkaction-button" style="margin-left:5px;">Action</button>
                        </span>
                     </div>
                  </div>
                  <div class="col-md-8">
                  </div>
               </div>
            </div>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th style="text-align:center;width:3%;"><input type="checkbox" id="selectAll"></th>
                     <th>Title</th>
                     <th>URL</th>
                     <th class="text-center"><i class="icon-arrow-down12"></i></th>
                  </tr>
               </thead>
               <tbody >
                  <?php if(count($resCategoryList)>0):
                     foreach($resCategoryList as $rowCategoryListInfo):
                     ?>
                  <tr>
                     <td style="text-align:center"><input type="checkbox" class="clsSelectSingle" value="<?php echo $rowCategoryListInfo->customer_id;  ?>" name="customer_id[]"></td>
                     <td>
                        <div class="media-left">
                           <div class=""><a href="#" class="text-default text-semibold"><?php echo $rowCategoryListInfo->customer_title; ?></a></div>
                           <div class="text-muted text-size-small">
                              <?php if($rowCategoryListInfo->customer_status==1)
                                 { ?>
                              <a href="<?php echo $this->Url->build('/admin/customerView/status/'.$rowCategoryListInfo->customer_id); ?>">
                              <span class="status-mark border-success"></span>
                              Active
                              </a>
                              <?php }else{ ?>
                              <a href="<?php echo $this->Url->build('/admin/customerView/status/'.$rowCategoryListInfo->customer_id); ?>">
                              <span class="status-mark border-danger"></span>
                              Inactive
                              </a>
                              <?php } ?>
                           </div>
                        </div>
                     </td>
                     <td><?php echo $rowCategoryListInfo->customer_url;  ?></td>
                     <td class="text-center">
                        <ul class="icons-list">
                           <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                              <ul class="dropdown-menu dropdown-menu-right">
                                 <li><a href="<?php echo $this->Url->build('/admin/customerView/index/'.$rowCategoryListInfo->customer_id); ?>" style="padding:3px 15px">Edit</a></li>
                                 <li><a href="<?php echo $this->Url->build('/admin/customerView/trash/'.$rowCategoryListInfo->customer_id); ?>" style="padding:3px 15px">Delete </a></li>
                              </ul>
                           </li>
                        </ul>
                     </td>
                  </tr>
                  <?php endforeach; 
                     else: ?>
                  <tr>
                     <td style="text-align:center" colspan="4">No Customer View Found</td>
                  </tr>
                  <?php endif; ?>
               </tbody>
            </table>
            <div class="datatable-footer">
               <div class="dataTables_info"><?= $this->Paginator->counter(['format' => __('Showing {{current}} to {{end}} of {{count}} entries')]) ?></div>
               <div class="dataTables_paginate paging_simple_numbers">
                  <?= $this->Paginator->prev('←',['class'=>'paginate_button previous']); ?>
                  <span>
                  <?= $this->Paginator->numbers(); ?>
                  </span>
                  <?= $this->Paginator->next(' →'); ?>
               </div>
            </div>
         </div>
         <?php $this->Form->end(); ?>		
      </div>
   </div>
</div>
<script>var csrf_tocken=<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>