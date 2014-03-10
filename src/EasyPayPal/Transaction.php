<?php

namespace EasyPayPal;

/**
 * Class Transaction
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class Transaction extends AbstractStoredEntity {

  protected $_storageTableName    = 'paypal_transaction';
  protected $_metadataEntityName  = 'transaction';

  protected $_entityToTableDefinition = array(
    'paypal_account'        => 'getBusinessPayPalAccount',
    'paypal_destination'    => 'getPayPalDestination',
    'currency'              => 'getCurrency',
    'transaction_type'      => 'getTransactionType',
    'has_individual_items'  => 'getHasIndividualItems',
    'has_shipping'          => 'getHasShipping',
    'handling_price'        => 'getHandlingPrice',
    'ipn_url'               => 'getIpnUrl',
    'customer_success_url'  => 'getCustomerSuccessUrl',
    'customer_cancel_url'   => 'getCustomerCancelUrl'
  );

  protected $_tableToEntityDefinition = array(
    'paypal_account'        => 'setBusinessPayPalAccount',
    'paypal_destination'    => 'setPayPalDestination',
    'currency'              => 'setCurrency',
    'transaction_type'      => 'setTransactionType',
    'has_individual_items'  => 'setHasIndividualItems',
    'has_shipping'          => 'setHasShipping',
    'handling_price'        => 'setHandlingPrice',
    'ipn_url'               => 'setIpnUrl',
    'customer_success_url'  => 'setCustomerSuccessUrl',
    'customer_cancel_url'   => 'setCustomerCancelUrl'
  );

  protected $id;
  private $_defaultCurrency = 'USD';
  private $_currency;
  private $_businessPayPalAccount;
  private $_payPalDestination   = 'https://www.paypal.com/cgi-bin/webscr';
  private $_transactionType     = '_cart';
  private $_hasIndividualItems  = 1;
  private $_hasShipping         = 0;
  private $_handlingPrice       = 0;
  private $_ipnUrl              = null;
  private $_customerSuccessUrl  = '';
  private $_customerCancelUrl   = '';

  protected $_items         = array();
  protected $_listeners     = array();
  protected $_notifications = array();

  public function init() {
    $this->_currency  = $this->_defaultCurrency;
  }

  /**
   * @return int|null
   */
  public function getId() {
    return $this->id;
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
   * Get the Paypal IPN notification Link
   * @return null|string
   */
  public function getIpnUrl() {
    return $this->_ipnUrl;
  }

  /**
   * Set the Paypal IPN notification Link
   * @param $ipnUrl
   * @return $this
   */
  public function setIpnUrl($ipnUrl) {
    $this->_ipnUrl = $ipnUrl;

    return $this;
  }

  /**
   * Get the customer return URL on successful payment
   * @return string
   */
  public function getCustomerSuccessUrl() {
    return $this->_customerSuccessUrl;
  }

  /**
   * Set the customer return URL on successful payment
   * @param string $customerSuccessUrl
   * @return $this
   */
  public function setCustomerSuccessUrl($customerSuccessUrl)
  {
    $this->_customerSuccessUrl = $customerSuccessUrl;

    return $this;
  }

  /**
   * Get the customer return URL on canceled payment
   * @return string
   */
  public function getCustomerCancelUrl() {
    return $this->_customerCancelUrl;
  }

  /**
   * Set the customer return URL on canceled payment
   * @param string $customerCancelUrl
   * @return $this
   */
  public function setCustomerCancelUrl($customerCancelUrl) {
    $this->_customerCancelUrl = $customerCancelUrl;

    return $this;
  }
  
  /**
   * Get the Total Cost, the item total cost & handling price
   * @return float|int
   */
  public function getTotalCost() {
    return $this->getTotalItemCost() + $this->getHandlingPrice();
  }

  /**
   * Get the Total Cost, the item total cost & handling price
   * @return float|int
   */
  public function getTotalCost() {
    return $this->getTotalItemCost() + $this->getHandlingPrice();
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

  public function isSandBoxTransaction() {
    return strpos($this->_payPalDestination, 'sandbox.paypal') !== false;
  }

  /**
   * @return array()
   */
  public function getItems() {
    return $this->_items;
  }
  
  /**
   * Get the total cost of all items
   * @return float|int
   */
  public function getTotalItemCost() {
    if(empty($this->_items))
      return 0;
      
    $totalItemCost = 0;
    
    foreach($this->_items as $item)
      $totalItemCost += ($item->getPrice() * $item->getQuantity());
    
    return $totalItemCost;
  }

  /**
   * Get the total cost of all items
   * @return float|int
   */
  public function getTotalItemCost() {
    if(empty($this->_items))
      return 0;

    $totalItemCost = 0;

    foreach($this->_items as $item)
      $totalItemCost += ($item->getPrice() * $item->getQuantity());

    return $totalItemCost;
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
   * Add a transaction log notification
   * @param TransactionNotification $notification
   * @return $this
   */
  public function logTransactionNotification(TransactionNotification $notification) {
    $this->_notifications[] = $notification;

    return $this;
  }

  /**
   * Get a transaction by id
   * @param $transactionId
   * @return $this
   */
  public function get($transactionId) {
    parent::get($transactionId);

    $transactionItems = new TransactionItem($this->getDatabaseConnection());
    $this->_items     = $transactionItems->getAllByTransactionId($this->id);

    $transactionListeners = new TransactionListener($this->getDatabaseConnection());
    $this->_listeners     = $transactionListeners->getAllByTransactionId($this->id);

    $transactionNotifications = new TransactionNotification($this->getDatabaseConnection());
    $this->_notifications     = $transactionNotifications->getAllByTransactionId($this->id);

    return $this;
  }

  /**
   * Save the current transaction
   * @return $this
   */
  public function save() {
    parent::save();

    foreach($this->_items as $key => $item) {
      $item->setTransactionId($this->id)->save();
    }

    foreach($this->_listeners as $key => $listener) {
      $listener->setTransactionId($this->id)->save();
    }

    foreach($this->_notifications as $key => $notification) {
      $notification->setTransactionId($this->id)->save();
    }

    return $this;
  }

  /**
   * @return TransactionInformation
   */
  public function getInformationObject() {
    $transactionInformation = new TransactionInformation();

    $transactionInformation->id                    = $this->id;
    $transactionInformation->currency              = $this->getCurrency();
    $transactionInformation->businessPayPalAccount = $this->getBusinessPayPalAccount();
    $transactionInformation->handlingPrice         = $this->getHandlingPrice();
    $transactionInformation->payPalDestination     = $this->getPayPalDestination();
    $transactionInformation->transactionType       = $this->getTransactionType();
    $transactionInformation->hasIndividualItems    = $this->getHasIndividualItems();
    $transactionInformation->hasShipping           = $this->getHasShipping();
    $transactionInformation->handlingPrice         = $this->getHandlingPrice();
    $transactionInformation->items                 = $this->getItems();
    $transactionInformation->listeners             = $this->getListeners();
    $transactionInformation->customerCancelUrl     = $this->getCustomerCancelUrl();
    $transactionInformation->customerSuccessUrl    = $this->getCustomerSuccessUrl();
    $transactionInformation->ipnUrl                = $this->getIpnUrl();

    return $transactionInformation;
  }

  /**
   * @return TransactionProcessing
   */
  public function getProcessingObject() {
    $transactionProcessing = new TransactionProcessing();

    $transactionProcessing->setTransactionId($this->id)
        ->setListeners($this->getListeners());

    return $transactionProcessing;
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

  protected function _metadataGetEntityName() {
    return $this->_metadataEntityName;
  }

  protected function _metadataGetEntityId() {
    return $this->id;
  }

}
