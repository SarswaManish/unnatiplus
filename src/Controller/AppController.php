<?php
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Controller\Component\CookieComponent;

class AppController extends Controller
{
    public function initialize()
    {
        /* set cookie */
        /**/
        /* set cookie end */
        $this->loadModel('SkProduct');
        $this->loadComponent('Cookie');
        if($this->Cookie->read('unique_session') == ''){
            self::set_cookie();
        }

        if(!isset($_SERVER['HTTPS']))
        {
          $this->redirect('https://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);  
        }
         if(isset($_POST['search_category']))
        {
            
            $_SESSION['FILTER_CATEGORY'] = $_POST['search_category'];
        }
        if(isset($_POST['search_title']))
        {
            
            $_SESSION['FILTER_TITLE'] = $_POST['search_title'];
        }
        if(isset($_POST['search_title']) && isset($_POST['search_category']))
        {
            
            $this->redirect(SITE_URL.'product-list/'.$_POST['search_category']);
        }
        
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadModel('SkCategory');
        $this->loadModel('ThemeSetting');
        $this->loadModel('SkWishlist');
        $this->loadModel('SkProduct');
        $this->loadModel('SkPages');
        $this->loadModel('SkBrand');

        $wishlistInfo =$this->SkWishlist->find('all');
 ///$resBrand =$this->SkBrand->find('all')->where(['brand_status'=>1]);

        $resSocialLink = $this->ThemeSetting->find('all')->first();
        $resCategorySearch = $this->SkCategory->find('all')->where(['category_status'=>1]);
        $resCategoryTreeData = $this->SkCategory->find('all')->where(['category_status'=>1])->order(['category_order'=>'ASC'])->toArray();
        $aryCategoryList =self::buildTree($resCategoryTreeData);
        
        $this->set(compact('aryCategoryList','resCategorySearch','resSocialLink','wishlistInfo')); 
        
        $strPage =  'https://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'];
        $rowPageData =$this->SkPages->find('all')->where(['page_url'=>$strPage])->first();  
        
        $detect = self::systemInfo();

            $data = $this->request->getSession()->read('cart_items');
          $cartcountfromapp =self::getCartCountex($data);

        $this->set(compact('rowPageData','detect','cartcountfromapp'));
    }
      function getCartCountex($resCartInfo)
   {
       $counter =0;
       if(isset($resCartInfo))
       {
      foreach($resCartInfo as $key=>$label)
      {
          foreach($label as $k=>$l)
          {
             $counter++; 
          }
      }
       }
      return $counter;
   }
 public static function systemInfo()
 {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform    = "Unknown OS Platform";
    $os_array       = array('/windows phone 8/i'    =>  'Windows Phone 8',
                            '/windows phone os 7/i' =>  'Windows Phone 7',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile');
    $found = false;
  ///  $addr = new RemoteAddress;
    $device = '';
    foreach ($os_array as $regex => $value) 
    { 
        if($found)
         break;
        else if (preg_match($regex, $user_agent)) 
        {
            $os_platform    =   $value;
            $device = !preg_match('/(windows|mac|linux|ubuntu)/i',$os_platform)
                      ?'MOBILE':(preg_match('/phone/i', $os_platform)?'MOBILE':'SYSTEM');
        }
    }
    $device = !$device? 'SYSTEM':$device;
    return array('os'=>$os_platform,'device'=>$device);
 }

 public static function browser() 
 {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $browser        =   "Unknown Browser";

    $browser_array  = array('/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser');

    foreach ($browser_array as $regex => $value) 
    { 
        if($found)
         break;
        else if (preg_match($regex, $user_agent,$result)) 
        {
            $browser    =   $value;
        }
    }
    return $browser;
 }
    function buildTree(array $elements, $parentId = 0) {
    $branch = array();
    foreach ($elements as $element) {
        if ($element->category_parent == $parentId) {
            $children = $this->buildTree($elements, $element->category_id);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
   }  
   
   function set_cookie(){
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
        $output =  substr(str_shuffle($str_result),  0, '12'); 
        $this->Cookie->write('unique_session', $output);
   }
   
}
