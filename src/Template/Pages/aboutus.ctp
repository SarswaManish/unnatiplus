<?php    use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$strPage =  'https://codexosoftware.live/unnatiplus/about-us';
   $sqlSelectMeta = 'SELECT * FROM sk_pages WHERE 1 AND page_url=\''.$strPage.'\'';  
   $rowPageData =$conn->execute($sqlSelectMeta)->fetch('assoc');?>

<div class="sub-header">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ul class="breadcrum">
<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
<li><a href="javascript:;">About Us</a></li>
</ul>
<h1>About Us</h1>
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

           