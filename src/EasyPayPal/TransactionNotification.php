<?php

namespace EasyPayPal;

/**
 * Class TransactionNotification
 * @package EasyPayPal
 */
class TransactionNotification extends AbstractTransactionStoredEntity {

  protected $_storageTableName    = 'paypal_transaction_notification';

  protected $_entityToTableDefinition = array(
    'paypal_transaction_id'  => 'getTransactionId',
    'receiver_email'         => 'getReceiverEmail',
    'receiver_id'            => 'getReceiverId',
    'residence_country'      => 'getResidenceCountry',
    'test_ipn'               => 'getTestIPN',
    'transaction_subject'    => 'getTransactionSubject',
    'txn_id'                 => 'getTxnId',
    'txn_type'               => 'getTxnType',
    'payer_email'            => 'getPayerEmail',
    'payer_id'               => 'getPayerId',
    'payer_status'           => 'getPayerStatus',
    'first_name'             => 'getFirstName',
    'last_name'              => 'getLastName',
    'address_city'           => 'getAddressCity',
    'address_country'        => 'getAddressCountry',
    'address_country_code'   => 'getAddressCountryCode',
    'address_name'           => 'getAddressName',
    'address_state'          => 'getAddressState',
    'address_status'         => 'getAddressStatus',
    'address_street'         => 'getAddressStreet',
    'address_zip'            => 'getAddressZip',
    'custom'                 => 'getCustom',
    'handling_amount'        => 'getHandlingAmount',
    'mc_currency'            => 'getMcCurrency',
    'mc_fee'                 => 'getMcFee',
    'mc_gross'               => 'getMcGross',
    'payment_date'           => 'getPaymentDate',
    'payment_fee'            => 'getPaymentFee',
    'payment_gross'          => 'getPaymentGross',
    'payment_status'         => 'getPaymentStatus',
    'payment_type'           => 'getPaymentType',
    'protection_eligibility' => 'getProtectionEligibility',
    'shipping'               => 'getShipping',
    'tax'                    => 'getTax'
  );

  protected $_tableToEntityDefinition = array(
    'paypal_transaction_id'  => 'setTransactionId',
    'receiver_email'         => 'setReceiverEmail',
    'receiver_id'            => 'setReceiverId',
    'residence_country'      => 'setResidenceCountry',
    'test_ipn'               => 'setTestIPN',
    'transaction_subject'    => 'setTransactionSubject',
    'txn_id'                 => 'setTxnId',
    'txn_type'               => 'setTxnType',
    'payer_email'            => 'setPayerEmail',
    'payer_id'               => 'setPayerId',
    'payer_status'           => 'setPayerStatus',
    'first_name'             => 'setFirstName',
    'last_name'              => 'setLastName',
    'address_city'           => 'setAddressCity',
    'address_country'        => 'setAddressCountry',
    'address_country_code'   => 'setAddressCountryCode',
    'address_name'           => 'setAddressName',
    'address_state'          => 'setAddressState',
    'address_status'         => 'setAddressStatus',
    'address_street'         => 'setAddressStreet',
    'address_zip'            => 'setAddressZip',
    'custom'                 => 'setCustom',
    'handling_amount'        => 'setHandlingAmount',
    'mc_currency'            => 'setMcCurrency',
    'mc_fee'                 => 'setMcFee',
    'mc_gross'               => 'setMcGross',
    'payment_date'           => 'setPaymentDate',
    'payment_fee'            => 'setPaymentFee',
    'payment_gross'          => 'setPaymentGross',
    'payment_status'         => 'setPaymentStatus',
    'payment_type'           => 'setPaymentType',
    'protection_eligibility' => 'setProtectionEligibility',
    'shipping'               => 'setShipping',
    'tax'                    => 'setTax'
  );

  protected $id;
  protected $transactionId;
  public $receiverEmail;
  public $receiverId;
  public $residenceCountry;
  public $testIPN = 0;
  public $transactionSubject;
  public $txnId;
  public $txnType;
  public $payerEmail;
  public $payerId;
  public $payerStatus;
  public $firstName;
  public $lastName;
  public $addressCity;
  public $addressCountry;
  public $addressCountryCode;
  public $addressName;
  public $addressState;
  public $addressStatus;
  public $addressStreet;
  public $addressZip;
  public $custom;
  public $handlingAmount;
  public $mcCurrency;
  public $mcFee;
  public $mcGross;
  public $paymentDate;
  public $paymentFee;
  public $paymentGross;
  public $paymentStatus;
  public $paymentType;
  public $protectionEligibility;
  public $shipping = 0;
  public $tax = 0;

  /**
   * Get the transaction id
   * @return int|null
   */
  public function getTransactionId() {
    return $this->transactionId;
  }

  /**
   * Set the transaction id
   * @param $transactionId
   * @return $this
   */
  public function setTransactionId($transactionId) {
    $this->transactionId = $transactionId;

    return $this;
  }

  public function getReceiverEmail()
  {
    return $this->receiverEmail;
  }

  public function setReceiverEmail($receiverEmail)
  {
    $this->receiverEmail = $receiverEmail;
  }

  public function getReceiverId()
  {
    return $this->receiverId;
  }

  public function setReceiverId($receiverId)
  {
    $this->receiverId = $receiverId;
  }

  public function getResidenceCountry()
  {
    return $this->residenceCountry;
  }

  public function setResidenceCountry($residenceCountry)
  {
    $this->residenceCountry = $residenceCountry;
  }

  public function getTestIPN()
  {
    return $this->testIPN;
  }

  public function setTestIPN($testIPN)
  {
    $this->testIPN = $testIPN;
  }

  public function getTransactionSubject()
  {
    return $this->transactionSubject;
  }

  public function setTransactionSubject($transactionSubject)
  {
    $this->transactionSubject = $transactionSubject;
  }

  public function getTxnId()
  {
    return $this->txnId;
  }

  public function setTxnId($txnId)
  {
    $this->txnId = $txnId;
  }

  public function getTxnType()
  {
    return $this->txnType;
  }

  public function setTxnType($txnType)
  {
    $this->txnType = $txnType;
  }

  public function getPayerEmail()
  {
    return $this->payerEmail;
  }

  public function setPayerEmail($payerEmail)
  {
    $this->payerEmail = $payerEmail;
  }

  public function getPayerId()
  {
    return $this->payerId;
  }

  public function setPayerId($payerId)
  {
    $this->payerId = $payerId;
  }

  public function getPayerStatus()
  {
    return $this->payerStatus;
  }

  public function setPayerStatus($payerStatus)
  {
    $this->payerStatus = $payerStatus;
  }

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }

  public function getAddressCity()
  {
    return $this->addressCity;
  }

  public function setAddressCity($addressCity)
  {
    $this->addressCity = $addressCity;
  }

  public function getAddressCountry()
  {
    return $this->addressCountry;
  }

  public function setAddressCountry($addressCountry)
  {
    $this->addressCountry = $addressCountry;
  }

  public function getAddressCountryCode()
  {
    return $this->addressCountryCode;
  }

  public function setAddressCountryCode($addressCountryCode)
  {
    $this->addressCountryCode = $addressCountryCode;
  }

  public function getAddressName()
  {
    return $this->addressName;
  }

  public function setAddressName($addressName)
  {
    $this->addressName = $addressName;
  }

  public function getAddressState()
  {
    return $this->addressState;
  }

  public function setAddressState($addressState)
  {
    $this->addressState = $addressState;
  }

  public function getAddressStatus()
  {
    return $this->addressStatus;
  }

  public function setAddressStatus($addressStatus)
  {
    $this->addressStatus = $addressStatus;
  }

  public function getAddressStreet()
  {
    return $this->addressStreet;
  }

  public function setAddressStreet($addressStreet)
  {
    $this->addressStreet = $addressStreet;
  }

  public function getAddressZip()
  {
    return $this->addressZip;
  }

  public function setAddressZip($addressZip)
  {
    $this->addressZip = $addressZip;
  }

  public function getCustom()
  {
    return $this->custom;
  }

  public function setCustom($custom)
  {
    $this->custom = $custom;
  }

  public function getHandlingAmount()
  {
    return $this->handlingAmount;
  }

  public function setHandlingAmount($handlingAmount)
  {
    $this->handlingAmount = $handlingAmount;
  }

  public function getMcCurrency()
  {
    return $this->mcCurrency;
  }

  public function setMcCurrency($mcCurrency)
  {
    $this->mcCurrency = $mcCurrency;
  }

  public function getMcFee()
  {
    return $this->mcFee;
  }

  public function setMcFee($mcFee)
  {
    $this->mcFee = $mcFee;
  }

  public function getMcGross()
  {
    return $this->mcGross;
  }

  public function setMcGross($mcGross)
  {
    $this->mcGross = $mcGross;
  }

  public function getPaymentDate()
  {
    return $this->paymentDate;
  }

  public function setPaymentDate($paymentDate)
  {
    $this->paymentDate = $paymentDate;
  }

  public function getPaymentFee()
  {
    return $this->paymentFee;
  }

  public function setPaymentFee($paymentFee)
  {
    $this->paymentFee = $paymentFee;
  }

  public function getPaymentGross()
  {
    return $this->paymentGross;
  }

  public function setPaymentGross($paymentGross)
  {
    $this->paymentGross = $paymentGross;
  }

  public function getPaymentStatus()
  {
    return $this->paymentStatus;
  }

  public function setPaymentStatus($paymentStatus)
  {
    $this->paymentStatus = $paymentStatus;
  }

  public function getPaymentType()
  {
    return $this->paymentType;
  }

  public function setPaymentType($paymentType)
  {
    $this->paymentType = $paymentType;
  }

  public function getProtectionEligibility()
  {
    return $this->protectionEligibility;
  }

  public function setProtectionEligibility($protectionEligibility)
  {
    $this->protectionEligibility = $protectionEligibility;
  }

  public function getShipping()
  {
    return $this->shipping;
  }

  public function setShipping($shipping)
  {
    $this->shipping = $shipping;
  }

  public function getTax()
  {
    return $this->tax;
  }

  public function setTax($tax)
  {
    $this->tax = $tax;
  }

  protected function _getEntityTableName() {
    return $this->_storageTableName;
  }

  protected function _getEntityToTableMap() {
    return $this->_entityToTableDefinition;
  }

  protected function _getEntityFromTableMap() {
    return $this->_tableToEntityDefinition;
  }

}