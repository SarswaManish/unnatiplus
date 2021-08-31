<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');
$rowAdminInfo =  $this->request->getSession()->read('ADMIN');
$rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=9 ')->fetch('assoc');
if(!isset($rowSelectPermission['pd_id']))
{
    header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
}
?>
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Slider</h4>
		</div>

	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="/admin/"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Slider</li>
		</ul>

	</div>
</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
 <?php  echo $this->Flash->render(); ?>
					
					<!-- Dashboard content -->
					<div class="row">
						<div class="col-lg-12">
 <?php echo  $this->Form->create('', ['url'=>'/admin/slider/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>

							<!-- Marketing campaigns -->
							<div class="panel panel-default">
						<div class="panel-heading">
							<h5 class="panel-title">Slider List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
							<div class="heading-elements">
							    			     <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
								<a href="<?php echo $this->Url->build('/admin/slider/addslider', true); ?>" class="btn btn-primary"><i class="icon-file-plus position-left"></i> Add New</a>
								
								<?php } ?>
		                	</div>
						</div>
						<div class="panel-body" style="background:#f5f5f5;">
    						<div class="row">
        						<div class="col-md-4">
                                    <div class="input-group">
                                        <select class="form-control" name="bulkaction" id="bulkactionSelect">
                                            <option value="">Bulk Action</option>
                                            <?php if($rowSelectPermission['pd_delete']==1)
                                            { ?>
                                            <option value="1">Delete</option>
                                            <?php } ?>
                                            <option value="2">Active</option>
                                            <option value="3">Inactive</option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn bg-teal" type="submit" id="bulkaction-button" style="margin-left:5px;">Action</button>
                                        </span>
                                    </div>						
                                </div>
    						</div>
						</div>
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="text-align:center;width:3%;"><input type="checkbox" id="selectAll"></th>
							        <th style="width:3%;">Sr.No.</th>
									<th>Title</th>
									<th>Description</th>
									<th>Type</th>
									<th class="text-center"><i class="icon-arrow-down12"></i></th>
								</tr>
							</thead>
						<tbody>
								<?php 
								$aryType = array('Login App',2=>'Home Slider Aside','Home Slider Bottom','App Dashboard Slider 1','App Dashboard Slider 2','App Dashboard Slider 3','Between App Product Slider');
								$counter=0;
								if(count($resSliderList)>0)
								{
								foreach($resSliderList as $rowProductListInfo)
								{ 
								$counter++;
								?>
										<tr>
											<td style="text-align:center"><input type="checkbox" name="slider_id[]" class="clsSelectSingle"  value="<?php echo $rowProductListInfo->slider_id; ?>"></td>
											<td><?php echo $counter; ?></td>
												<td>
													<div class="media-left media-middle" style="padding-right:10px;">
														<img src="<?php echo SITE_UPLOAD_URL.SITE_SLIDER_IMAGE_PATH.$rowProductListInfo->slider_image; ?>" class="img-circle img-xs" alt="">
													</div>
													<div class="media-left">
														<div class=""><a href="javascript:;" class="text-default text-semibold"><?php echo $rowProductListInfo->slider_title; ?></a></div>
										<div class="text-muted text-size-small">
												<?php 	if($rowProductListInfo->slider_status==1)
												{ ?>
										<a href="<?php echo $this->Url->build('/admin/slider/status/'.$rowProductListInfo->slider_id, true); ?>"><span class="status-mark border-success"></span> Active </a>
										<?php }else if($rowProductListInfo->slider_status==0) { ?>
										<a href="<?php echo $this->Url->build('/admin/slider/status/'.$rowProductListInfo->slider_id, true); ?>">	<span class="status-mark border-danger"></span> Inactive </a>
										<?php } ?>
															
														</div>
													</div>
												</td>
											
												<td><span ><?php echo $rowProductListInfo->slider_desc; ?></span></td>
												<td><?php echo $aryType[$rowProductListInfo->slider_type]; ?></td>
												<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">
															    	     <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
																<li><a href="<?php echo $this->Url->build('/admin/slider/addslider/'.$rowProductListInfo->slider_id, true); ?>" style="padding:3px 15px">Edit</a></li>
																	<?php } ?>
																	     <?php if($rowSelectPermission['pd_delete']==1)
{ ?>
											<li><a href="<?php echo $this->Url->build('/admin/slider/deletepermanently/'.$rowProductListInfo->slider_id, true); ?>" style="padding:3px 15px">Delete </a></li>
											<?php } ?>
															</ul>
														</li>
													</ul>
												</td>
											</tr>
								<?php }}else{ ?>
									<tr>
									    <td colspan="8" class="text-center">No Result Found</td>
								 </tr>
								<?php } ?>
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
<?= $this->Form->end() ?>
				
							
						</div>

						</div>
					<!-- /dashboard content -->


					<!-- Footer -->
				
					<!-- /footer -->

				
	</div>
	<!-- /page container -->
	<script>var _csrfToken=<?= json_encode($this->request->getParam('_csrfToken')); ?>;</script>


