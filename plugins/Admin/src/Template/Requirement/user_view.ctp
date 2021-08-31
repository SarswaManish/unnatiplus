<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Requirement</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Requirement </li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h5 class="panel-title"><?php echo $rowUserInfo->req_name; ?>'s Requirement<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-body" style="padding:0px;">
                                    <table class="table table-striped">
                                        <tbody>
                                             <tr>
                                                <td style="background: #f3f3f3;">Customer Name</td>
                                                <td style="background:#fff"><?php echo $rowUserInfo->req_name; ?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Customer Email </td>
                                                <td style="background:#fff"> <?php echo $rowUserInfo->req_email; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Mobile Number</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_mobile)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Category</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_category)?> </td>
                                            </tr> 
                                            <tr>
                                                <td style="background: #f3f3f3;">Quantity</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_quantity)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Required Days</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_days)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Min Price</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_price_min)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Max Price</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_price_max)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Image</td>
                                                <td style="background:#fff"> <img src="<?php echo SITE_UPLOAD_URL.SITE_PRODUCT_IMAGE_PATH.$rowUserInfo->req_image;?>" style="width:100%">   
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Link</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_link)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Description</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->req_desc)?> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>