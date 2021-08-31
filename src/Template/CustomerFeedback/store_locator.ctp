<?php    use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$strPage =  'https://codexosoftware.live/unnatiplus/store-locator';
   $sqlSelectMeta = 'SELECT * FROM sk_pages WHERE 1 AND page_url=\''.$strPage.'\'';  
   $rowPageData =$conn->execute($sqlSelectMeta)->fetch('assoc');?>
 <?php if(!isset($strApp) || isset($strApp) && $strApp=='')
{ ?>
<div class="sub-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ul class="breadcrum">
<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
<li><a href="javascript:;">Store Locator </a></li>
</ul>
<h1>Store Locator </h1>
</div>
</div>
</div>
</div>
<?php } ?>

<section>
<div class="container-fluid">
<!--<div class="row justify-content-md-center" style="display:none">
<div class="col-lg-5">
<div class="address-box">
<div class="address-box-map mb-10">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28455.130366749338!2d75.78019014876885!3d26.938660419430022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db3e6511b0c55%3A0x73e227a3a563df97!2sJaipur%2C%20Rajasthan%20302016!5e0!3m2!1sen!2sin!4v1577941228589!5m2!1sen!2sin" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
</div>
<div class="address-box-content">
<h3>Head Office Jaipur</h3>
<p>B-1, Crystal Mall, Banipark,<br>Jaipur-302016, Rajasthan, India </p>
<p>Phone : (+91) 0141-4049163, (+91) 9116121383</p>
</div>
</div>
</div>
<div class="col-lg-5">
<div class="address-box">
<div class="address-box-map mb-10">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28455.130366749338!2d75.78019014876885!3d26.938660419430022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db3e6511b0c55%3A0x73e227a3a563df97!2sJaipur%2C%20Rajasthan%20302016!5e0!3m2!1sen!2sin!4v1577941228589!5m2!1sen!2sin" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
</div>
<div class="address-box-content">
<h3>Head Office Jaipur</h3>
<p>B-1, Crystal Mall, Banipark,<br>Jaipur-302016, Rajasthan, India </p>
<p>Phone : (+91) 0141-4049163, (+91) 9116121383</p>
</div>
</div>
</div>

</div>-->




<div class="row">
<div class="col-lg-12">
<div class="content">
<?php echo $rowPageData['page_desc'];?>
</div>
</div>
</div>
</div>
</section>

           
