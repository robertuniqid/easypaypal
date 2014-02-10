<?php

namespace EasyPayPal;

/**
 * Class TransactionListener
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class TransactionListener {

  protected $_requiredInformation = array(
    '_param', '_listener'
  );

  private $_param;
  private $_paramValue;
  private $_listener;

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
}