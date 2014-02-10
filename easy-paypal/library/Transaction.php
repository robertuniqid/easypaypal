<?php

namespace EasyPayPal;

/**
 * Class Transaction
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class Transaction extends Stored {

  use Metadata;

  protected $_storageTableName    = 'paypal_transaction';
  protected $_metadataEntityName  = 'transaction';

  protected $id;
  private $_defaultCurrency = 'USD';
  private $_currency;
  private $_businessPayPalAccount;
  private $_payPalDestination   = 'https://www.paypal.com/cgi-bin/webscr';
  private $_transactionType     = '_cart';
  private $_hasIndividualItems  = 1;
  private $_hasShipping         = 0;
  private $_handlingPrice       = 0;

  protected $_items     = array();
  protected $_listeners = array();

  public function __construct() {
    $this->_currency  = $this->_defaultCurrency;
  }

  /**
   * Get the Paypal Account Email, of the seller
   * @return string|null
   */
  public function getBusinessPayPalAccount() {
    return $this->_businessPayPalAccount;
  }

  /**
   * Set the Paypal Account Email, of the seller
   * @param $businessPayPalAccount
   * @return $this
   */
  public function setBusinessPayPalAccount($businessPayPalAccount) {
    $this->_businessPayPalAccount = $businessPayPalAccount;

    return $this;
  }

  /**
   * Get the transaction currency
   * @return string
   */
  public function getCurrency() {
    return $this->_currency;
  }

  /**
   * Set the transaction currency
   * @param $currency
   * @return $this
   */
  public function setCurrency($currency) {
    $this->_currency = $currency;

    return $this;
  }

  /**
   * Get the Transaction Type, by default _cart
   * @return string
   */
  public  function getTransactionType() {
    return $this->_transactionType;
  }

  /**
   * Set the Transaction Type, by default _cart
   * @param $transactionType
   * @return $this
   */
  public  function setTransactionType($transactionType) {
    $this->_transactionType = $transactionType;

    return $this;
  }

  /**
   * Flag, this should be true if individual items are passed to the Paypal. By default 1
   * @return int - 1 or 0
   */
  public  function getHasIndividualItems() {
    return $this->_hasIndividualItems;
  }

  /**
   * Flag, this should be true if individual items are passed to the Paypal. By default 1
   * @param $hasIndividualItems
   * @return $this
   */
  public  function setHasIndividualItems($hasIndividualItems) {
    $this->_hasIndividualItems = $hasIndividualItems;

    return $this;
  }

  /**
   * Set to true if you want to require shipping details from Paypal
   * @return int
   */
  public function getHasShipping() {
    return $this->_hasShipping;
  }

  /**
   * Boolean true if you want to require shipping details from Paypal
   * @param int|bool $hasShipping
   * @return $this
   */
  public function setHasShipping($hasShipping) {
    $this->_hasShipping = $hasShipping;

    return $this;
  }

  /**
   * Set the payment processing cost
   * @return int|float
   */
  public function getHandlingPrice() {
    return $this->_handlingPrice;
  }

  /**
   * Set the payment processing cost
   * @param int|float $handlingPrice
   * @return $this
   */
  public function setHandlingPrice($handlingPrice) {
    $this->_handlingPrice = $handlingPrice;

    return $this;
  }

  /**
   * Get the form destination
   * @return string
   */
  public function getPayPalDestination() {
    return $this->_payPalDestination;
  }

  /**
   * Set the form destination
   * @param $payPalDestination
   * @return $this
   */
  public function setPayPalDestination($payPalDestination) {
    $this->_payPalDestination = $payPalDestination;

    return $this;
  }

  /**
   * @param TransactionItem $item
   * @return $this
   * @throws \Exception
   */
  public function addItem(TransactionItem $item) {
    if($item->isValid() === false)
      throw new \Exception('Invalid product item supplied');

    $this->_items[] = $item;

    return $this;
  }

  /**
   * @return array
   */
  public function getItems() {
    return $this->_items;
  }

  /**
   * @param TransactionListener $listener
   * @return $this
   * @throws \Exception
   */
  public function addListener(TransactionListener $listener) {
    if($listener->isValid() === false)
      throw new \Exception('Invalid product item supplied');

    $this->_listeners[] = $listener;

    return $this;
  }

  /**
   * @return array
   */
  public function getListeners() {
    return $this->_listeners;
  }

  /**
   * Save the current transaction
   * @return $this
   */
  public function save() {
    parent::save();

    return $this;
  }

  /**
   * @return TransactionInformation
   */
  public function getInformationObject() {
    $orderInformation = new TransactionInformation();

    $orderInformation->currency              = $this->getCurrency();
    $orderInformation->businessPayPalAccount = $this->getBusinessPayPalAccount();
    $orderInformation->handlingPrice         = $this->getHandlingPrice();
    $orderInformation->payPalDestination     = $this->getPayPalDestination();
    $orderInformation->transactionType       = $this->getTransactionType();
    $orderInformation->hasIndividualItems    = $this->getHasIndividualItems();
    $orderInformation->hasShipping           = $this->getHasShipping();
    $orderInformation->handlingPrice         = $this->getHandlingPrice();
    $orderInformation->items                 = $this->getItems();
    $orderInformation->listeners             = $this->getListeners();

    return $orderInformation;
  }

  public function getEntityTableName() {
    return $this->_storageTableName;
  }

  public function metadataGetEntityName() {
    return $this->_metadataEntityName;
  }

  public function metadataGetEntityId() {

  }

}