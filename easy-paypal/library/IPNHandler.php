<?php

namespace EasyPayPal;

/**
 * Class IPN
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class IPNHandler {

  protected $databaseConnection;
  public $isOkay;

  public function __construct(DatabaseConnection $databaseConnection) {
    $paypalIPNResponse = $_POST;

    if(!isset($paypalIPNResponse) || empty($paypalIPNResponse))
      exit;

    $this->databaseConnection = $databaseConnection;

    $currentTransaction    = $this->_getTransactionInstance()->get(26);//$_POST['custom']);

    $validation = $currentTransaction->getPayPalDestination() . '?cmd=_notify-validate';

    foreach($paypalIPNResponse as $key => $value)
      $validation .= '&' . $key . '=' . $value;

    $paypalResponse = file_get_contents($validation);

    if($paypalResponse == 'VERIFIED') {
      $transactionProcessing = $currentTransaction->getProcessingObject();
      $transactionProcessing->setIpnResponse($_POST)->process();

      $this->isOkay = true;
    } else {
      $this->isOkay = false;
    }

    return $this->isOkay;
  }

  /**
   * @return Transaction
   */
  private function _getTransactionInstance() {
    return new Transaction($this->databaseConnection);
  }

}