<?php

namespace EasyPayPal;

/**
 * Class TransactionItem
 * @package EasyPayPal
 */
class TransactionItem extends AbstractTransactionStoredEntity {

  protected $_storageTableName    = 'paypal_transaction_item';
  protected $_metadataEntityName  = 'transaction_item';

  protected $_entityToTableDefinition = array(
    'paypal_transaction_id'  => 'getTransactionId',
    'name'                   => 'getName',
    'price'                  => 'getPrice',
    'quantity'               => 'getQuantity',
    'number'                 => 'getNumber'
  );

  protected $_tableToEntityDefinition = array(
    'paypal_transaction_id'  => 'setTransactionId',
    'name'                   => 'setName',
    'price'                  => 'setPrice',
    'quantity'               => 'setQuantity',
    'number'                 => 'setNumber'
  );

  /**
   * An associative array, objectKey => paypalAlias
   * @var array
   */
  protected $_informationArrayDefinition = array(
    'name'        => 'item_name',
    'price'       => 'amount',
    'quantity'    => 'quantity',
    'number'      => 'item_number'
  );

  protected $_informationArrayIgnoreDefinition = array(
    'number'      => array(0, null)
  );

  protected $_requiredInformation = array(
    'name', 'price', 'quantity'
  );

  protected $id;
  protected $transactionId;
  public $name;
  public $price;
  public $quantity = 1;

  /**
   * Optional, internal item_id
   */
  public $number = false;

  /**
   * Get the item name
   * @return string|null
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set the item name
   * @param $name
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the product price
   * @return string|null
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * Set the item price
   * @param $price
   * @return $this
   */
  public function setPrice($price) {
    $this->price = $price;

    return $this;
  }

  /**
   * Get the item quantity
   * @return int
   */
  public function getQuantity() {
    return $this->quantity;
  }

  /**
   * Set the item quantity
   * @param $quantity
   * @return $this
   */
  public function setQuantity($quantity) {
    $this->quantity = $quantity;

    return $this;
  }

  /**
   * @return bool
   */
  public function getNumber() {
    return $this->number;
  }

  /**
   * Optionally, set the item number, can be used to know the product_id
   * @param $number
   * @return $this
   */
  public function setNumber($number) {
    $this->number = $number;

    return $this;
  }

  /**
   * Check if the TransactionItem Object is valid and Transaction Ready
   * @return bool
   */
  public function isValid() {
    $valid = true;

    foreach($this->_requiredInformation as $keyName)
      if($this->$keyName === NULL)
        $valid = false;

    return $valid;
  }

  public function getInformationArray() {
    $information = array();

    foreach($this->_informationArrayDefinition as $objectKey => $paypalAlias)
      if(!(
          isset($this->_informationArrayIgnoreDefinition[$objectKey])
          && (
              (
                is_string($this->_informationArrayIgnoreDefinition[$objectKey])
                && $this->$objectKey = $this->_informationArrayIgnoreDefinition[$objectKey]
              )
              ||
              (
                is_array($this->_informationArrayIgnoreDefinition[$objectKey])
                && in_array($this->$objectKey, $this->_informationArrayIgnoreDefinition[$objectKey])
              )
             )
          )
      )
        $information[$paypalAlias] = $this->$objectKey;


    return $information;
  }

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