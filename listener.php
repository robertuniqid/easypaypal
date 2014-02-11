<?php

define('BASE_PATH', dirname(__FILE__));

require_once('helper/easy-paypal.php');

Helper_EasyPayPal::getInstance()->handleIPN();