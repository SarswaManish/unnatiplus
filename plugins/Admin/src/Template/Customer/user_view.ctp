<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Customer's</span> - Feedback</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo  SITE_URL;?>admin"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Customer Feedback</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h5 class="panel-title"><?php echo $rowUserInfo->feedback_name; ?>'s Feedback<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
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
                                                <td style="background:#fff"><?php echo $rowUserInfo->feedback_name; ?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Customer Email </td>
                                                <td style="background:#fff"> <?php echo $rowUserInfo->feedback_email; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Mobile Number</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->feedback_mobile)?> </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #f3f3f3;">Feedback</td>
                                                <td style="background:#fff"> <?=h($rowUserInfo->feedback_feedback)?> </td>
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