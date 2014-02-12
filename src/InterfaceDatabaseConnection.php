<?php

namespace EasyPayPal;

/**
 * Class DatabaseConnection
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
interface InterfaceDatabaseConnection {

  public function query($query);
  public function getAll($tableName, $where);
  public function getOne($tableName, $where);
  public function insert($tableName, $information);
  public function update($tableName, $information, $id);

}