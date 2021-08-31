<?php    use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$strPage =  'https://codexosoftware.live/unnatiplus/terms-and-condition';
   $sqlSelectMeta = 'SELECT * FROM sk_pages WHERE 1 AND page_url=\''.$strPage.'\'';  
   $rowPageData =$conn->execute($sqlSelectMeta)->fetch('assoc');?>

<div class="sub-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
     <?php if(!isset($strApp) || isset($strApp) && $strApp=='')
{ ?>
<ul class="breadcrum">
<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
<li><a href="javascript:;">Terms & Conditions</a></li>
</ul>
<?php } ?>
<h1>Terms & Conditions</h1>
</div>
</div>
</div>
</div>
<section>
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="content">
<?php echo $rowPageData['page_desc'];?>
</div>
</div>
</div>
</div>
</section>
           