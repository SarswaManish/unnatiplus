<?php    use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
   $sqlSelectMeta = 'SELECT * FROM sk_blog WHERE 1 AND blog_status=1 ORDER BY blog_created_date';  
   $resBlogList =$conn->execute($sqlSelectMeta)->fetchAll('assoc');
   
   
   ?>
<style>
    .blog-box-details{width:100%;background:#fff;border-radius:3px;border:1px solid #e6ebed;margin-bottom:20px;}
.blog-box-content{width:100%;padding:20px 10px 20px 0px;position:relative;}
.blog-box-content a{text-decoration:none;color:#333;}
.blog-box-content h2{font-size:18px;font-weight:700;margin-top:0px;}
.blog-box-content p{font-size:13px;line-height:22px;}
.blog-img-box{width:100%;height:230px;overflow:hidden;}
.blog-img-box img{width:100%;height:230px;overflow:hidden;border-radius:3px 0px 0px 3px;}
a.red{color:#EE1C25;}
.meta-info{width:100%;margin-bottom:10px;}
.meta-info ul{margin:0;padding:0;margin-left:-10px;list-style:none;}
.meta-info ul li{display:inline-block;border-right:1px solid #ccc;line-height:0px;padding:0px 10px;}
.blog-cat{margin-bottom:0px;font-size:12px;font-style:italic;}
</style>
	<div class="main-container container">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
			<li><a href="javascript:;">Blogs</a></li>
			
		</ul>
              
          <div class="row">
			<div id="content" class="col-md-12 col-sm-8">
		<?php foreach($resBlogList as $rowBlogList)	
		{ 
		$strCategoryName ='';
		if($rowBlogList['blog_category']!='')
		{
		 $sqlSelectMeta = 'SELECT GROUP_CONCAT(category_name) as total FROM sk_bcategory WHERE 1 AND category_id IN ('.$rowBlogList['blog_category'].') ';  
   $rowCateName =$conn->execute($sqlSelectMeta)->fetch('assoc');
   
  $strCategoryName = '	<a href="javascript:void(0);">'.$rowCateName['total'].'</a>	';
		}
   
   
		?>
			
<div class="blog-box-details">
	<div class="row">
		<div class="col-lg-4 pless-right">
			<div class="blog-img-box">
				<a href="<?php echo SITE_URL; ?>blog-details/<?php echo $rowBlogList['blog_slug']; ?>">
				    <img src="<?php echo SITE_UPLOAD_URL; ?>blog_image/<?php echo $rowBlogList['blog_featured_image']; ?>" alt="<?php echo $rowBlogList['blog_title']; ?>" title="<?php echo $rowBlogList['blog_title']; ?>">
				    </a>
			</div>
		</div>
		
		
<div class="col-lg-8">
	<div class="blog-box-content">
		<div class="blog-cat">
			<i class="fa fa-tags" aria-hidden="true"></i> 

		
	<?php echo $strCategoryName; ?>
	
</div>
<div class="blog-cat"></div>
<a href="<?php echo SITE_URL; ?>blog-details/<?php echo $rowBlogList['blog_slug']; ?>"><h2><?php echo $rowBlogList['blog_title']; ?></h2></a>
<div class="meta-info">
<ul>
<li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d M Y',strtotime($rowBlogList['blog_created_date'])); ?> </li>
</ul>
</div>
<p>
	
<?php echo substr(strip_tags($rowBlogList['blog_desc']),0,150); ?>...</p>

<a class="red" href="<?php echo SITE_URL; ?>blog-details/<?php echo $rowBlogList['blog_slug']; ?>">Read More <i class="fa fa-angle-double-right" aria-hidden="true"></i>
</a>
</div>
</div>
</div>
</div>
<?php } ?>
           </div>
           </div>
              
               </div>	
             
