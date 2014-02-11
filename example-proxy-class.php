<?php

/**
 * Change this class to suit your needs.
 * This Class works like a Proxy Class for the things offered by EasyPayPal
 * I strongly suggest you think of using a proxy class to have full control on default settings or anything.
 * Class EasyPayPal
 * @author Andrei-Robert Rusu
 */
class Helper_EasyPayPal {

  protected static $_instance;

  public static function getInstance() {
    if(self::$_instance === null)
      self::$_instance = new self();

    return self::$_instance;
  }

  /**
   * Inject default values for the EasyPayPal\Transaction
   * @var array
   */
  protected $_defaultTransaction = array(
    'setBusinessPayPalAccount'  => 'robert@easy-development.com',
    'setIpnUrl'                 => '',
    'setCustomerSuccessUrl'     => '',
    'setCustomerCancelUrl'      => ''
  );

  public function __construct() {

  }

  private function _getDatabaseStorageConnection() {
    return new EasyPayPal\DatabaseStorageConnection('localhost', 'username', 'password', 'db_name');
  }

  public function handleIPN() {
    $IPNHandler = new EasyPayPal\IPNHandler($this->_getDatabaseStorageConnection());
  }

  public function transaction() {
    $transaction = new EasyPayPal\Transaction($this->_getDatabaseStorageConnection());

    $this->_setIntoObject($transaction, $this->_defaultTransaction);

    return $transaction;
  }

  public function transactionItem() {
    return new EasyPayPal\TransactionItem($this->_getDatabaseStorageConnection());
  }

  public function transactionListener() {
    return new EasyPayPal\TransactionListener($this->_getDatabaseStorageConnection());
  }

  private function _setIntoObject($object, $key, $value = null) {
    if(is_array($key)) {
      foreach($key as $keyKey => $keyValue)
        $this->_setIntoObject($object, $keyKey, $keyValue);
    } else if(is_string($key)) {
      $object->$key($value);
    }
  }

}