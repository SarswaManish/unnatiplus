<?php use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default'); 
$rowThemeSetting=$conn->execute('SELECT * FROM theme_setting')->fetch('assoc');
?>
<div class="sub-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrum">
                    <li><a href="https://codexosoftware.live/unnatiplus/"><i class="fa fa-home"></i></a></li>
                    <li><a href="javascript:;">Forgot Password</a></li>
                </ul>
            <h1>Forgot Password</h1>
            </div>
        </div>
    </div>
</div>
<section>
   <div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-lg-6">
<div class="my-pro-contetnt" style="min-height:auto">
<div class="my-pro-contetnt-body">
<div class="lr-box">
    <?php  echo $this->Flash->render(); ?>
    <?php echo  $this->Form->create('', ['type' => 'POST','id'=>'profileupdate','url'=>'/home/changepassword','class'=>'']); ?>
    <div class="row">
         <div class="col-lg-12">
            <div class="lr-form-box">
                <label>New Password:</label>
                <input name="user_id"  type="hidden" value="<?php echo $rowUserInfo->user_id; ?>">
                <input name="new_password" type="password">
            </div>
        </div>
    </div><div class="row">
                <div class="col-lg-12">
            <div class="lr-form-box">
                <label>Confirm Password:</label>
                <input name="confirm_password"type="password">
            </div>
        </div>

    </div>
     <div class="row">
         <div class="col-lg-12">
            <div class="lr-form-box">
                <button type="submit" class="btn btn-success" onclick="return validationcontact($(this))">SUBMIT</button>
            </div>
        </div>
    </div><br>
    <?php echo  $this->Form->end(); ?>
</div>
    
</div>
</div>
</div>
</div>
</div>
</section>
<script>
    function validationcontact()
    {
      
        var new_password = $('input[name=new_password]').val();
        if(new_password.trim()=='')
        {
              $('input[name=new_password]').attr('style','border:1px solid red'); 
   return false;
            
        }else{
  $('input[name=new_password]').attr('style',''); 

        }
        var confirm_password = $('input[name=confirm_password]').val();
        if(confirm_password.trim()=='')
        {
              $('input[name=confirm_password]').attr('style','border:1px solid red'); 
   return false;
            
        }else{
  $('input[name=confirm_password]').attr('style',''); 

        }
        
        if(confirm_password!=new_password)
        {
                     $('input[name=new_password]').attr('style','border:1px solid red'); 
     
              $('input[name=confirm_password]').attr('style','border:1px solid red'); 
   return false; 
        }

    }
    
    
</script>