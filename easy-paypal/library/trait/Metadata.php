<?php

namespace EasyPayPal;

/**
 * Metadata is the class which allows binding custom data to any other Object / Entity.
 * For Example, if you want to bind a product_id to a OrderItem, or a UserId to a Order.php
 * Trait Metadata
 * @author Andrei-Robert Rusu
 */
trait Metadata {

  protected $_metadataToSync = array();
  protected $_metadata;

  final public function metadataSet($param, $value) {
    $this->_metadata[$param] = $value;

    $this->_metadataToSync[] = $param;
  }

  final public function metadataGet($param, $defaultValue = null) {
    if(!isset($this->_metadata[$param]))
      $this->_metadata[$param] = ''; // Query Goes Here

    return (isset($this->_metadata[$param]) ? $this->_metadata[$param] : $defaultValue);
  }

  /**
   * When saving an Entity, this method should be called to save metadata also.
   */
  final public function metadataSync() {

  }

  abstract public function metadataGetEntityName();
  abstract public function metadataGetEntityId();

}