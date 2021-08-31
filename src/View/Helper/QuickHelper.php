<?php
/* /app/views/helpers/link.php */

class QuickHelper extends AppHelper {
    function getParentCatgory() {
        // Logic to create specially formatted link goes here...
        	   	      	  $this->loadModel('SkCategory');
         $resCategoryParentData = $this->SkCategory->find('all')->where(['category_status'=>1,'category_paernt'=>0]);
return $resCategoryParentData;
    }
}

?>