<div class="sub-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrum">
                    <li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
                    <li><a href="javascript:;">Seller Registration</a></li>
                </ul>
                <h1>Seller Registration</h1>
            </div>
        </div>
    </div>
</div>
<section>
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-8">
                <div class="my-pro-contetnt" style="min-height:auto">
                    <div class="my-pro-contetnt-body">
                        <div class="lr-box">
                            <?= $this->Flash->render() ?>
                            <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'user-form','url'=>'','enctype'=>'multipart/form-data']); ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <label>First Name:<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" required name="seller_fname">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <label>Last Name:<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" required name="seller_lname">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <label>Bussiness Name:<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" required name="business_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <label>Email:<span style="color: red;">*</span></label>
                                            <input type="email" class="form-control" required name="seller_email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <label>Mobile:<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" required name="seller_phone" minlength="10" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <label>Password:<span style="color: red;">*</span></label>
                                            <input type="password" class="form-control" required name="seller_password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <label>Address:<span style="color: red;">*</span></label>
                                            <div>
                                                <textarea class="form-control" name="business_address"></textarea>        				    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="lr-form-box">
                                            <button type="submit" class="btn btn-success" style="margin-right: 19px;">Save</button>
                                            Have an Seller/Agent Account?<a href="<?php echo SITE_URL;?>seller"> Login here</a>
                                        </div>
                                    </div>
                                </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function refreshPage() {
        window.location.reload();
    }
</script>