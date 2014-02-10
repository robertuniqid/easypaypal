<?php

namespace EasyPayPal;

/**
 * Stored is the abstract Class which will allow objects / entities to be saved easily in the database.
 * Trait Metadata
 * @author Andrei-Robert Rusu
 * @package EasyPayPal
 */
abstract class Stored {

  abstract public function getEntityTableName();

  public function get($entityId) {

  }

  public function save() {

  }

}