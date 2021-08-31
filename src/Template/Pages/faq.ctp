<?php    use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\RecursHelper;
$conn = ConnectionManager::get('default');
$strPage =  'https://codexosoftware.live/unnatiplus/faq';
$sqlSelectMeta = 'SELECT * FROM sk_pages WHERE 1 AND page_url=\''.$strPage.'\'';  
$rowPageData =$conn->execute($sqlSelectMeta)->fetch('assoc');?>
<div class="sub-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrum">
                    <li><a href="<?php echo SITE_URL; ?>"><i class="fa fa-home"></i></a></li>
                    <li><a href="javascript:;">Faq</a></li>
                </ul>
            <h1>Faq</h1>
            </div>
        </div>
    </div>
</div>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="content">
                    <div class="accordion" id="accordionExample">
                    <?php $count=0;
                        foreach($resFaqInfo as $rowFaqInfo){
                        $count++;?>
                      <div class="card">
                        <div class="card-header" id="heading<?php echo $count;?>">
                          <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $count;?>" aria-expanded="true" aria-controls="collapse<?php echo $count;?>">
                             <?php echo $count;?>. <?php echo $rowFaqInfo->faq_qus;?> ?
                            </button>
                          </h2>
                        </div>
                        <div id="collapse<?php echo $count;?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <div class="card-body">
                            <?php echo $rowFaqInfo->faq_ans; ?>
                          </div>
                        </div>
                      </div>
                      <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>