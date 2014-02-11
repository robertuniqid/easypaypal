<?php define('BASE_PATH', dirname(__FILE__));?>

<h1>This is version alpha 0.2</h1>

<ul>
  <li>Need to allow metadata to be set to transactions & transaction items.</li>
  <li>Need to create the IPN Listener & Dispatch the proper information to the Listeners.</li>
</ul>

<hr/>

<?php
  require_once('your-application/helper/easy-paypal.php');

  $transaction = Helper_EasyPayPal::getInstance()->transaction()->get(26);

  $transactionInformation = $transaction->getInformationObject();

  echo $transactionInformation->getPaymentForm();
