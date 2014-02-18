<?php

namespace EasyPayPal;

/**
 * Class IPN
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class IPNHandler {

  /**
   * This is the database Connection
   * @var InterfaceDatabaseConnection
   */
  protected $databaseConnection;

  /**
   * True if the IPN Notification is valid & sent by PayPal.
   * @var bool
   */
  public $isOkay = false;

  public function __construct(InterfaceDatabaseConnection $databaseConnection, $paypalIPNValidation = true, $paypalIPNCheckGross = true) {
    $paypalIPNResponse = $_POST;

    if(!isset($paypalIPNResponse) || empty($paypalIPNResponse))
      exit;

    $this->databaseConnection = $databaseConnection;

    $currentTransaction    = $this->_getTransactionInstance()->get($paypalIPNResponse['custom']);

    $validation = $currentTransaction->getPayPalDestination() . '?cmd=_notify-validate';

    foreach($paypalIPNResponse as $key => $value)
      $validation .= '&' . $key . '=' . $value;

    if($paypalIPNValidation)
      $paypalResponse = file_get_contents($validation);
    else
      $paypalResponse = 'VERIFIED';

    if($paypalResponse == 'VERIFIED') {
      if($paypalIPNResponse['business'] == $currentTransaction->getBusinessPayPalAccount()) {
         if($paypalIPNCheckGross) {
           if($paypalIPNResponse['mc_gross'] == ($currentTransaction->getHandlingPrice() + $currentTransaction->getTotalItemCost())
              && $paypalIPNResponse['mc_currency'] == $currentTransaction->getCurrency()) {
              $transactionProcessing = $currentTransaction->getProcessingObject();
              $transactionProcessing->setIpnResponse($paypalIPNResponse)->process();
              $this->isOkay = true;
           }
         } else {
            $transactionProcessing = $currentTransaction->getProcessingObject();
            $transactionProcessing->setIpnResponse($paypalIPNResponse)->process();
            $this->isOkay = true;
         }
      }
    }

    return $this->isOkay;
  }

  /**
   * Get a Transaction Instance.
   * @return Transaction
   */
  private function _getTransactionInstance() {
    return new Transaction($this->databaseConnection);
  }

}
