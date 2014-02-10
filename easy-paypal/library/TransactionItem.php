<?php

namespace EasyPayPal;

/**
 * Class TransactionItem
 * @package EasyPayPal
 */
class TransactionItem extends Stored {

  use Metadata;

  protected $_storageTableName    = 'paypal_transaction_item';
  protected $_metadataEntityName  = 'transaction_item';

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

  protected $_requiredInformation = array(
    'name', 'price', 'quantity'
  );

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
      if($this->$objectKey !== null)
        $information[$paypalAlias] = $this->$objectKey;


    return $information;
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