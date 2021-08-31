<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.9.1
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\View\Helper;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;

/**
 * Html Helper class for easy use of HTML widgets.
 *
 * HtmlHelper encloses all methods needed while working with HTML pages.
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 * @link https://book.cakephp.org/3.0/en/views/helpers/html.html
 */
class PayumoneyHelper extends Helper
{
  
public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);
    }
 // Merchant key here as provided by Payu
    private $merchantKey = PAYU_MERCHANT_KEY;
    // Merchant Salt as provided by Payu
    private $salt = PAYU_MERCHANT_SALT;
    // End point - change to https://secure.payu.in for LIVE mode
    private $payuBaseURL = PAYU_BASE_URL;
    private $payuSandBaseURL = "https://test.payu.in";

    //Hash code
    private $hash = "";
    //Constructor
  
    public function getAction() {
        return PAYU_BASE_URL . '/_payment';
    }
    public static function randomTxnId() {
        // Generate random transaction id
        return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    }
    private static function generateHash($posted = []) {
        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }
        $hash_string .= PAYU_MERCHANT_SALT;
       return  strtolower(hash('sha512', $hash_string));
    }
    public static function send($posted = []) {
        // Post Request
        $posted['key'] = PAYU_MERCHANT_KEY;
        $hash = self::generateHash($posted);
        $posturl = PAYU_BASE_URL . '/_payment';
        $payu_in_args = array(
            // Merchant details
            'key'                   => PAYU_MERCHANT_KEY,
            'surl'                  => $posted['surl'],
            'furl'                  => $posted['furl'],
            'curl'                  => $posted['curl'],
            'service_provider'      => 'payu_paisa',
            // Customer details
            'firstname'             => $posted['firstname'],
            'lastname'              => '',
            'email'                 => $posted['email'],
            'address1'              => '',
            'address2'              => '',
            'city'                  => '',
            'state'                 => '',
            'zipcode'               => '',
            'country'               => '',
            'phone'                 => $posted['phone'],
            // Item details
            'productinfo'           => $posted['productinfo'],
            'amount'                => $posted['amount'],
            // Pre-selection of the payment method tab
            'pg'                    => ''
        );
        $payuform = '';
        foreach( $payu_in_args as $key => $value ) {
            if( $value ) {
                $payuform .= "<input type='hidden' name='" . $key . "' value='" . $value . "' />\n";
            }
        }
        $payuform .= '<input type="hidden" name="txnid" value="' . $posted['txnid'] . '" />' . "\n";
        $payuform .= '<input type="hidden" name="hash" value="' . $hash . '" />' . "\n";
        // The form
        echo '
          <style>
            body {
                text-lign:      center;
                background-color:#fff;
                cursor: wait;
                margin: 0 auto;
                width: 200px;
            }
            .box {
              margin: 50 0px;
              width: 200px;
              background-color:#e6e6e6;
              padding: 50px;
              border: 3px solid #aaa;
            }
          </style>
          <div class="box">
            <img src="" alt="Redirecting..." />Thank you for your order. We are now redirecting you to PayUMoney to make payment.
          </div>
          <form action="' . $posturl . '" method="POST" name="payuForm" id="payform">
                ' . $payuform . '
                <input type="submit" class="button" id="submit_payu_in_payment_form" value="Pay via PayUMoney" />
                <a class="button cancel" href="' . $posted['curl'] . '">Cancel order &amp; restore cart</a>
                <script type="text/javascript">
                    var payuForm = document.forms.payuForm;
                    payuForm.submit();
                </script>
            </form>';
        exit;
    }
}
