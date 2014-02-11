<?php

define('BASE_PATH', dirname(dirname(__FILE__)));

require_once('helper/easy-paypal.php');

function someDummyFunction($transactionId, $paypalIPN) {

  file_put_contents(BASE_PATH . DIRECTORY_SEPARATOR . 'ipn-log.txt',
                    'Transaction id : ' . $transactionId . "\n" . implode($paypalIPN, "\n"));

}

Helper_EasyPayPal::getInstance()->handleIPN();