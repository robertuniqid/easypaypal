<?php

require_once('library/abstract/Stored.php');
require_once('library/trait/Metadata.php');
require_once('library/Lang.php');
require_once('library/TransactionInformation.php');
require_once('library/Transaction.php');
require_once('library/TransactionItem.php');
require_once('library/TransactionListener.php');

/**
 * Change this class to suit your needs.
 * This Class works like a Proxy Class for the things offered by EasyPayPal
 * Class EasyPayPal
 * @author Andrei-Robert Rusu
 */
class EasyPayPal {

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
    'setBusinessPayPalAccount'  => 'robert@easy-development.com'
  );

  public function __construct() {

  }

  public function getTransaction() {
    $transaction = new EasyPayPal\Transaction();

    $this->_setIntoObject($transaction, $this->_defaultTransaction);

    return $transaction;
  }

  public function getTransactionInformation() {
    $transaction = new EasyPayPal\TransactionInformation();

    return $transaction;
  }

  public function getTransactionItem() {
    return new EasyPayPal\TransactionItem();
  }

  public function getTransactionListener() {
    return new EasyPayPal\TransactionListener();
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