<?php
 

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
 
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
 

$routes->connect('/', ['controller' => 'Home', 'action' => 'index', 'home']);
$routes->connect('/product-list/filter', ['controller' => 'ProductList', 'action' => 'filter']);

$routes->connect('/product-list/*', ['controller' => 'ProductList', 'action' => 'index']);

$routes->connect('/brand/*', ['controller' => 'ProductList', 'action' => 'brand']);
$routes->connect('/sale/*', ['controller' => 'ProductList', 'action' => 'sale']);

$routes->connect('/product-detail/productreview', ['controller' => 'ProductDetail', 'action' => 'productreview']);
$routes->connect('/book/*', ['controller' => 'ProductDetail', 'action' => 'index']);

$routes->connect('/product-detail/*', ['controller' => 'ProductDetail', 'action' => 'index']);

$routes->connect('/add-to-cart-product/', ['controller' => 'Cart', 'action' => 'addtocart']);

$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
$routes->connect('my-cart/', ['controller' => 'Cart', 'action' => 'index']);
$routes->connect('get-shipping/', ['controller' => 'Cart', 'action' => 'getshipping']);
$routes->connect('my-account/wish-list/', ['controller' => 'MyAccount', 'action' => 'wishList']);
$routes->connect('my-account/orders/', ['controller' => 'MyAccount', 'action' => 'orders']);
$routes->connect('my-account/manage-address/', ['controller' => 'MyAccount', 'action' => 'address']);
$routes->connect('my-account/returned-orders/', ['controller' => 'MyAccount', 'action' => 'returned-orders']);
$routes->connect('my-account/delivered-orders/', ['controller' => 'MyAccount', 'action' => 'delivered-orders']);
$routes->connect('checkout/', ['controller' => 'Cart', 'action' => 'checkout']);
$routes->connect('customer-feedback/', ['controller' => 'CustomerFeedback', 'action' => 'index']);
$routes->connect('post-your-requirement/', ['controller' => 'CustomerFeedback', 'action' => 'postYourRequirement']);
$routes->connect('post-your-requirement/*', ['controller' => 'CustomerFeedback', 'action' => 'postYourRequirement']);
$routes->connect('store-locator/', ['controller' => 'CustomerFeedback', 'action' => 'storeLocator']);
$routes->connect('store-locator/*', ['controller' => 'CustomerFeedback', 'action' => 'storeLocator']);


$routes->connect('about-us', ['controller' => 'Pages', 'action' => 'aboutus']);
$routes->connect('special-offer', ['controller' => 'Pages', 'action' => 'specialoffer']);
$routes->connect('how-to-purchase', ['controller' => 'Pages', 'action' => 'howtopurchase']);
$routes->connect('faq', ['controller' => 'Pages', 'action' => 'faq']);
$routes->connect('help-and-support', ['controller' => 'Pages', 'action' => 'helpandsupport']);
$routes->connect('help-and-support/*', ['controller' => 'Pages', 'action' => 'helpandsupport']);

$routes->connect('cancellation-and-returns', ['controller' => 'Pages', 'action' => 'cancellationandreturns']);
$routes->connect('terms-and-condition', ['controller' => 'Pages', 'action' => 'termsandcondition']);
$routes->connect('terms-and-condition/*', ['controller' => 'Pages', 'action' => 'termsandcondition']);

$routes->connect('shipping-policy', ['controller' => 'Pages', 'action' => 'shippingpolicy']);
$routes->connect('contact-us', ['controller' => 'Pages', 'action' => 'contactus']);
$routes->connect('return-policy', ['controller' => 'Pages', 'action' => 'returnpolicy']);
$routes->connect('privacy-policy', ['controller' => 'Pages', 'action' => 'privacypolicy']);
$routes->connect('privacy-policy/*', ['controller' => 'Pages', 'action' => 'privacypolicy']);

$routes->connect('/forgotpasswordlink/*', ['controller' => 'Home', 'action' => 'forgotpage']);
$routes->connect('/ajaxcreatecallbackgreques', ['controller' => 'Pages', 'action' => 'ajaxcreatecallbackgreques']);
$routes->connect('/blog-details/*', ['controller' => 'BlogDetails', 'action' => 'index']);


   /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
   
     Router::scope('/admin', ['plugin' => 'Admin'], function ($routes) {
    $routes->connect('/', ['controller' => 'Login']);
    $routes->connect('/customer-review/*', ['controller' => 'CustomerView', 'action' => 'index']);
    });
 Router::scope('/seller', ['plugin' => 'Seller'], function ($routes) {
    $routes->connect('/', ['controller' => 'Login']);
    });
 Router::scope('/webapi', ['plugin' => 'Webapi'], function ($routes) {
    $routes->connect('/', ['controller' => 'Login']);
    });

    
    $routes->fallbacks(DashedRoute::class);
});


Router::extensions(['pdf']);
