<?php define('BASE_PATH', dirname(__FILE__));?>

<h1>This is version alpha 0.2</h1>

<ul>
  <li>Need to implement database save & option to allow metadata to be set to transactions & transaction items.</li>
  <li>Need to Test & Implement the Transaction Listener.</li>
  <li>Need to create the IPN Listener & Dispatch the proper information to the Listeners.</li>
  <li>( Optional ) Create an Abstrat Class for the listeners, and inject the information.</li>
</ul>

<hr/>

<?php
  require_once('your-application/helper/easy-paypal.php');

  $transaction = Helper_EasyPayPal::getInstance()->transaction()->get(26);

  $transactionInformation = $transaction->getInformationObject();

  echo $transactionInformation->getPaymentForm();
