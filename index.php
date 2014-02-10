<h1>This is version alpha 0.1</h1>

<ul>
  <li>Need to implement database save & option to allow metadata to be set to transactions & transaction items.</li>
  <li>Need to Test & Implement the Transaction Listener.</li>
  <li>Need to create the IPN Listener & Dispatch the proper information to the Listeners.</li>
  <li>( Optional ) Create an Abstrat Class for the listeners, and inject the information.</li>
</ul>

<hr/>

<?php
  require_once('easy-paypal/easy-paypal.php');

  $orderItem = EasyPayPal::getInstance()->getTransactionItem();

  $orderItem->setName('My Awesome Product')
            ->setPrice(11)
            ->setQuantity(11);

  $order = EasyPayPal::getInstance()->getTransaction();

  $order->setHandlingPrice(12.5)
        ->addItem($orderItem)
        ->addItem($orderItem)
        ->addItem($orderItem)
        ->addItem($orderItem)
        ->addItem($orderItem);

  $orderInformation = $order->save()->getInformationObject();

  echo $orderInformation->getPaymentForm();
