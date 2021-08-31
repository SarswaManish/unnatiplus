<?php use Cake\View\Helper\SessionHelper; 
use Cake\View\Helper\SecurityMaxHelper;
use Cake\Datasource\ConnectionManager;
$conn = ConnectionManager::get('default');
$rowAdminInfo =  $this->request->getSession()->read('ADMIN');
$rowSelectPermission =$conn->execute('SELECT * FROM sk_permission_data WHERE 1 AND pd_role='.$rowAdminInfo['admin_role_id'].' AND  pd_permission_id=10 ')->fetch('assoc');
if(!isset($rowSelectPermission['pd_id']))
{
    header ("Location: ".$this->Html->url(array('controller'=>'Dashboard','action'=>'index')));
}
?>
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Taxes</h4>
		</div>

	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="/admin/"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Taxes</li>
		</ul>

	</div>
</div>
<!-- /page header -->
<!-- Content area -->
	<div class="content">
    <?= $this->Flash->render() ?>	
	<!-- Dashboard content -->
					<div class="row">
						<div class="col-lg-12">

							<!-- Marketing campaigns -->
						<div class="panel panel-default">
						<div class="panel-heading">
							<h5 class="panel-title">Taxes List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
							<div class="heading-elements">
						        <?php if($rowSelectPermission['pd_entry']==1)
                                { ?>
								<a href="<?php echo SITE_URL; ?>admin/taxes/addtaxes" class="btn btn-primary"><i class="icon-file-plus position-left"></i> Add New</a>
								<?php } ?>
		                	</div>
						</div>
						<div class="panel-body" style="background:#f5f5f5;">
                            <div class="row">
                                <?php echo  $this->Form->create('', ['url'=>'/admin/taxes/bulkaction','type' => 'POST','id'=>'bulkaction','class'=>'form-horizontal']); ?>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <select class="form-control" onclick="Selectstaus()" name="bulkaction" >
                                            <option>Bulk Action</option>
                                            <option value="1">Delete</option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn bg-teal" id="bulkaction-button" style="height:39px;">Apply</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
						<table class="table table-striped">
										<thead>
											<tr>
												<th style="text-align:center;width:3%;"><input type="checkbox" id="selectAll"></th>
												<th style="width:3%;">S.No.</th>
												<th style="width:30%;">Title</th>
												<th>CGST</th>
												<th>SGST</th>
												<th>IGST</th>
												<th style="width:20%;">Publish Date</th>
												<th class="text-center"><i class="icon-arrow-down12"></i></th>
											</tr>
										</thead>
										<tbody>
								<?php 
								if(count($resTaxesList)>0)
								{
								    $counter=0;
								foreach($resTaxesList as $rowTaxesList)
								{ 
								$counter++; ?>
											<tr>
											<td style="text-align:center"><input type="checkbox" name="tax_id[]" class="checkbox clsSelectSingle" value="<?= $this->Number->format($rowTaxesList->tax_id);  ?>"></td>
											<td><?php echo $counter; ?></td>
												<td>
												
													<div class="media-left">
														<div class=""><a href="javascript:;" class="text-default text-semibold"><?php echo $rowTaxesList->tax_title; ?></a></div>
										<div class="text-muted text-size-small">
												<?php 	if($rowTaxesList->tax_status==1)
												{ ?>
										<a href="<?php echo SITE_URL; ?>admin/taxes/status/<?php echo $rowTaxesList->tax_id; ?>"><span class="status-mark border-success"></span> Active </a>
										<?php }else if($rowTaxesList->tax_status==0) { ?>
										<a href="<?php echo SITE_URL; ?>admin/taxes/status/<?php echo $rowTaxesList->tax_id; ?>">	<span class="status-mark border-danger"></span> Inactive </a>
										<?php }else{ ?>
									<a href="<?php echo SITE_URL; ?>admin/taxes/status/<?php echo $rowTaxesList->tax_id; ?>">	<span class="status-mark border-warning"></span> Trashed </a>
										<?php } ?>
															
														</div>
													</div>
												</td>
											
												<td><span class="text-success-600"><?php echo $rowTaxesList->tax_cgst_percent; ?>%</span></td>
													<td><span class="text-success-600"><?php echo $rowTaxesList->tax_sgst_percent; ?>%</span></td>
														<td><span class="text-success-600"><?php echo $rowTaxesList->tax_igst_percent; ?>%</span></td>
											
												<td><?php echo date('d/m/Y h:i:s',strtotime($rowTaxesList->tax_date_time)); ?></td>
												<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">
															    <?php if($rowSelectPermission['pd_entry']==1)
{ ?>
																<li><a href="<?php echo SITE_URL; ?>admin/taxes/addtaxes/<?php echo $rowTaxesList->tax_id; ?>" style="padding:3px 15px">Edit</a></li>
																	<?php } ?>
										<?php if($rowSelectPermission['pd_delete']==1)
{ ?>					
											<li><a href="<?php echo SITE_URL; ?>admin/taxes/deletepermanently/<?php echo $rowTaxesList->tax_id; ?>" style="padding:3px 15px">Delete</a></li>	
											
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


