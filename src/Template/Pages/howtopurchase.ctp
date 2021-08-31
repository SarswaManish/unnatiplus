<?php    use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$strPage =  'https://www.eapublications.org/how-to-purchase';
   $sqlSelectMeta = 'SELECT * FROM sk_pages WHERE 1 AND page_url=\''.$strPage.'\'';  
   $rowPageData =$conn->execute($sqlSelectMeta)->fetch('assoc');?>

	<div class="main-container container">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
			<li><a href="javascript:;">How To Purchase</a></li>
		</ul>
              
          <div class="row">
			<div id="content" class="col-md-12 col-sm-12">			     
               <?php echo $rowPageData['page_desc'];?>
               
           </div>
           </div>
              
               </div>	
             