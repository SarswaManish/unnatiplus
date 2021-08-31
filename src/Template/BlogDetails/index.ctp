<?php    use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
   $sqlSelectMeta = 'SELECT * FROM sk_blog WHERE 1   AND blog_slug=\''.$strBlogSlug.'\' ORDER BY blog_created_date';  
   $rowBlogList =$conn->execute($sqlSelectMeta)->fetch('assoc');
   
   
   ?>
   	<?php  
		$strCategoryName ='';
		if($rowBlogList['blog_category']!='')
		{
		 $sqlSelectMeta = 'SELECT GROUP_CONCAT(category_name) as total FROM sk_bcategory WHERE 1 AND category_id IN ('.$rowBlogList['blog_category'].') ';  
   $rowCateName =$conn->execute($sqlSelectMeta)->fetch('assoc');
   
  $strCategoryName = '	<a href="javascript:void(0);">'.$rowCateName['total'].'</a>	';
		}
   
   
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

<script id="dsq-count-scr" src="//eapublication.disqus.com/count.js" async></script>

	<div class="main-container container">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
			<li><a href="javascript:;">Blogs</a></li>
	<li><a href="javascript:;"><?php echo $rowBlogList['blog_title']; ?></a></li>			
		</ul>
              
          <div class="row">
              
              
			<div id="content" class="col-md-8 col-sm-8">
			    <div class="blog-details">
<div class="blog-details-img-box mb-20">
				    <img src="<?php echo SITE_UPLOAD_URL; ?>blog_image/<?php echo $rowBlogList['blog_featured_image']; ?>" alt="<?php echo $rowBlogList['blog_title']; ?>" title="<?php echo $rowBlogList['blog_title']; ?>">
</div>
<h1><?php echo $rowBlogList['blog_title']; ?></h1>
<div class="meta-info mb-10">
<ul>
<li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d M Y',strtotime($rowBlogList['blog_created_date'])); ?></li>
</ul>
</div>
<div class="blog-cat mb-10">
	<i class="fa fa-tags" aria-hidden="true"></i> 
		<?php echo $strCategoryName; ?>	<!--	<a href="#">English</a>, <a href="#">Paper Back</a>-->
	</div>
<div class="blog-details-content">
    <?php echo $rowBlogList['blog_desc']; ?>
<div class="share-blog mt-20">
<div class="section-title">
<h2> Share this <span class="theme-color"> Blog</span></h2>
<div class="double-line-bottom-theme-colored-2"></div>

<div id="disqus_thread"></div>
</div>

</div>


</div>
	
			

           </div>
           </div>
              
               </div>	
                            </div>	
                            
                            
                            

<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://eapublication.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>


