<?php

namespace EasyPayPal;

/**
 * Stored is the abstract Class which will allow objects / entities to be saved easily in the database.
 * Trait Metadata
 * @author Andrei-Robert Rusu
 * @package EasyPayPal
 */
abstract class Stored {

  /**
   * @var DatabaseConnection
   */
  protected $_databaseConnection;

  abstract protected function _getEntityTableName();
  abstract protected function _getEntityToTableMap();
  abstract protected function _getEntityFromTableMap();

  /**
   * @param DatabaseConnection $databaseConnection
   * @return $this;
   */
  public function __construct(DatabaseConnection $databaseConnection) {
    $this->_databaseConnection = $databaseConnection;

    if(method_exists($this, 'init'))
      $this->init();

    return $this;
  }

  /**
   * Get the current database connection
   * @return DatabaseConnection
   */
  public function getDatabaseConnection() {
    return $this->_databaseConnection;
  }

  /**
   * Set a new database connection
   * @param DatabaseConnection $databaseConnection
   * @return $this
   */
  public function setDatabaseConnection(DatabaseConnection $databaseConnection) {
    $this->_databaseConnection = $databaseConnection;

    return $this;
  }

  public function get($entityId) {
    $entityInformation = $this->getDatabaseConnection()->getOne($this->_getEntityTableName(), array('id' => intval($entityId)));

    if(is_object($entityInformation))
      $entityInformation = get_object_vars($entityInformation);

    if(!is_array($entityInformation) || empty($entityInformation))
      throw new \Exception(__CLASS__ . '->' . __METHOD__ . '(' . intval($entityId) . '); invalid entityId provided');

    $this->_setEntityFromTableMap($entityId, $entityInformation);

    return $this;
  }

  public function save() {
    $information = array();

    foreach($this->_getEntityToTableMap() as $tableFieldName => $entityValue)
      if(method_exists($this, $entityValue))
        $information[$tableFieldName] = $this->$entityValue();
      else
        $information[$tableFieldName] = $this->$entityValue;

    if($this->id === null)
      $this->id = $this->getDatabaseConnection()->insert($this->_getEntityTableName(), $information);
    else
      $this->getDatabaseConnection()->update($this->_getEntityTableName(), $information, $this->id);

    return $this;
  }

  protected function _setEntityFromTableMap($entityId, $entityInformation) {
    $this->id = intval($entityId);

    foreach($this->_getEntityFromTableMap() as $tableFieldName => $setEntityValue)
      if(method_exists($this, $setEntityValue))
        $this->$setEntityValue($entityInformation[$tableFieldName]);
      else
        $this->$setEntityValue = $tableFieldName;
  }

}