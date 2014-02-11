<?php

namespace EasyPayPal;

/**
 * Class TransactionBound
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
abstract class TransactionBound extends Stored {

  abstract public function getTransactionId();

  abstract public function setTransactionId($transactionId);

  public function getAllByTransactionId($transactionId) {
    $entityList = $this->getDatabaseConnection()->getAll(
      $this->_getEntityTableName(),
      'paypal_transaction_id = ' . intval($transactionId)
    );

    foreach($entityList as $key => $entity) {
      $entityList[$key] = clone $this;
      $entityList[$key]->_setEntityFromTableMap($entity['id'], $entity);

    }

    return $entityList;
  }

}