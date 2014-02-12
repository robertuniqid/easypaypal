<?php

namespace EasyPayPal;

/**
 * Class TransactionProcessing
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class TransactionProcessing {

  private $_transactionId;
  private $_listeners   = array();
  private $_ipnResponse = array();

  /**
   * @return array
   */
  public function getListeners() {
    return $this->_listeners;
  }

  /**
   * @param $listeners
   * @return $this
   */
  public function setListeners($listeners) {
    $this->_listeners = $listeners;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getTransactionId() {
    return $this->_transactionId;
  }

  /**
   * @param $transactionId
   * @return $this
   */
  public function setTransactionId($transactionId) {
    $this->_transactionId = $transactionId;

    return $this;
  }

  /**
   * @return array
   */
  public function getIpnResponse() {
    return $this->_ipnResponse;
  }

  /**
   * @param $ipnResponse
   * @return $this
   */
  public function setIpnResponse($ipnResponse) {
    $this->_ipnResponse = $ipnResponse;

    return $this;
  }

  public function process() {
    foreach($this->getListeners() as $listener) {
      if(isset($this->getIpnResponse()[$listener->getParam()])
          && (
                ($listener->getParamValue() === null || $listener->getParamValue() === '')
                  || $this->getIpnResponse()[$listener->getParam()] == $listener->getParamValue()
             )
      ) {
        call_user_func($listener->getListener(), $this->getTransactionId(), $this->getIpnResponse());
      }
    }
  }


}