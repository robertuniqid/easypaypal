<?php

namespace EasyPayPal;

/**
 * AbstractStoredEntity is the abstract Class which will allow objects / entities to be saved easily in the database.
 * This works like a "mini" ORM.
 * @author Andrei-Robert Rusu
 * @package EasyPayPal
 */
abstract class AbstractStoredEntity {

  /**
   * This is the database Connection
   * @var InterfaceDatabaseConnection
   */
  protected $_databaseConnection;

  /**
   * Table Name of the entity
   * @return string
   */
  abstract protected function _getEntityTableName();
  /**
   * Entity To Table map
   * @return array
   */
  abstract protected function _getEntityToTableMap();
  /**
   * Table To Entity map
   * @return array
   */
  abstract protected function _getEntityFromTableMap();

  /**
   * @param InterfaceDatabaseConnection $databaseConnection
   */
  public function __construct(InterfaceDatabaseConnection $databaseConnection) {
    $this->_databaseConnection = $databaseConnection;

    if(method_exists($this, 'init'))
      $this->init();
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
   * @param InterfaceDatabaseConnection $databaseConnection
   * @return $this
   */
  public function setDatabaseConnection(InterfaceDatabaseConnection $databaseConnection) {
    $this->_databaseConnection = $databaseConnection;

    return $this;
  }

  /**
   * @param $entityId
   * @return $this
   * @throws \Exception
   */
  public function get($entityId) {
    $entityInformation = $this->getDatabaseConnection()->getOne($this->_getEntityTableName(), array('id' => intval($entityId)));

    if(is_object($entityInformation))
      $entityInformation = get_object_vars($entityInformation);

    if(!is_array($entityInformation) || empty($entityInformation))
      throw new \Exception(__CLASS__ . '->' . __METHOD__ . '(' . intval($entityId) . '); invalid entityId provided');

    $this->_setEntityFromTableMap($entityId, $entityInformation);

    return $this;
  }

  /**
   * @return $this
   */
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

  /**
   * @param $entityId
   * @param $entityInformation
   */
  protected function _setEntityFromTableMap($entityId, $entityInformation) {
    $this->id = intval($entityId);

    foreach($this->_getEntityFromTableMap() as $tableFieldName => $setEntityValue)
      if(method_exists($this, $setEntityValue))
        $this->$setEntityValue($entityInformation[$tableFieldName]);
      else
        $this->$setEntityValue = $tableFieldName;
  }

  public function populateFromArray($informationArray) {
    $entityTableTOMAP = $this->_getEntityToTableMap();

    foreach($informationArray as $structureName => $structureValue)
      if(isset($entityTableTOMAP[$structureName]))
        $this->$entityTableTOMAP[$structureName]($structureValue);
  }

}