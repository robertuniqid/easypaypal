<?php

namespace EasyPayPal;

/**
 * Class TransactionListener
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class TransactionListener extends AbstractTransactionStoredEntity {

  protected $_storageTableName    = 'paypal_transaction_listener';
  protected $_metadataEntityName  = 'transaction_listener';

  protected $_entityToTableDefinition = array(
    'paypal_transaction_id'  => 'getTransactionId',
    'param_name'             => 'getParam',
    'param_value'            => 'getParamValue',
    'listener'               => 'getSerializedListener',
  );

  protected $_tableToEntityDefinition = array(
    'paypal_transaction_id'  => 'setTransactionId',
    'param_name'             => 'setParam',
    'param_value'            => 'setParamValue',
    'listener'               => 'setUnSerializedListener',
  );

  protected $_requiredInformation = array(
    '_param', '_listener'
  );

  protected $id;
  protected $transactionId;
  private   $_param;
  private   $_paramValue;
  private   $_listener;

  /**
   * Get The param you want to listen to
   * @return string|null
   */
  public function getParam() {
    return $this->_param;
  }

  /**
   * Set the param you want to listen to
   * @param string $param
   * @return $this
   */
  public function setParam($param) {
    $this->_param = $param;

    return $this;
  }

  /**
   * Get the param value you want to listen to
   * @return string|null
   */
  public function getParamValue() {
    return $this->_paramValue;
  }

  /**
   * Set the param value you want to listen to
   * @param string $paramValue
   * @return $this
   */
  public function setParamValue($paramValue) {
    $this->_paramValue = $paramValue;

    return $this;
  }

  /**
   * Get the Listener
   * @return string|array
   */
  public function getListener() {
    return $this->_listener;
  }

  /**
   * Set the listener, called by call_user_func_array();
   * @param string|array $listener
   * @return $this
   */
  public function setListener($listener) {
    $this->_listener = $listener;

    return $this;
  }

  /**
   * Get the Listener serialized
   * @return string|array
   */
  public function getSerializedListener() {
    return serialize($this->_listener);
  }

  /**
   * Set the un serialized listener, called by call_user_func_array();
   * @param string|array $listener
   * @return $this
   */
  public function setUnSerializedListener($listener) {
    $this->_listener = unserialize($listener);

    return $this;
  }

  /**
   * Check if the OrderItem Object is valid and Order Ready
   * @return bool
   */
  public function isValid() {
    $valid = true;

    foreach($this->_requiredInformation as $keyName)
      if($this->$keyName === NULL)
        $valid = false;

    return $valid;
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