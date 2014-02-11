<?php

namespace EasyPayPal;

/**
 * Ready to use DB for EasyPayPal, you don't have to use this, you can simply just make a class which implements DatabaseConnection, and use that
 * Class DatabaseStorageConnection
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class DatabaseStorageConnection implements DatabaseConnection {

  protected $_lastInsertId = 0;

  protected $_host = '';
  protected $_user = '';
  protected $_pass = '';
  protected $_db   = '';

  public function __construct($host, $user, $pass, $tableName) {
    $this->_host = $host;
    $this->_user = $user;
    $this->_pass = $pass;
    $this->_db   = $tableName;
  }

  public function query($sql) {
    $conn = mysql_connect($this->_host, $this->_user, $this->_pass);

    if(! $conn )
    {
      die('Could not connect: ' . mysql_error());
    }

    mysql_select_db($this->_db);

    $retval = mysql_query( $sql, $conn );

    if(! $retval )
    {
      die('Could not enter data: ' . mysql_error());
    }

    if(strpos($sql, 'INSERT') === 0)
      $this->_lastInsertId = mysql_insert_id($conn);


    mysql_close($conn);

    return $retval;
  }

  public function getAll($tableName, $where = null) {
    $response = array();

    $sql = 'SELECT * FROM ' . $tableName;

    if($where !== null){
      $sql .= ' WHERE ';
      if(is_array($where)){
        $where = $this->_wrapMyArray($where);
        $sql .= $this->_arrayImplode("=" , "AND" , $where);
      }else{
        $sql .= $where;
      }
    }

    $result = $this->query($sql);

    while( $row = mysql_fetch_assoc( $result ) ) {
      $response[] = $row;
    }

    return $response;
  }

  public function getOne($tableName, $where) {
    $sql = 'SELECT * FROM ' . $tableName;

    if($where !== null){
      $sql .= ' WHERE ';
      if(is_array($where)){
        $where = $this->_wrapMyArray($where);
        $sql .= $this->_arrayImplode("=" , "AND" , $where);
      }else{
        $sql .= $where;
      }
    }

    $sql .= ' LIMIT 1';

    $result = $this->query($sql);

    while( $row = mysql_fetch_assoc( $result ) ) {
      return $row;
    }

    return array();
  }


  public function insert($db_name , $data){
    if(is_array($data) && !empty($data)){

      $data = array_map('mysql_real_escape_string', $data);

      $keys = array_keys($data);

      $sql = 'INSERT INTO '.$db_name.' ('
        .implode("," , $this->_wrapMyArray($keys , '`'))
        .') VALUES ('
        .implode("," , $this->_wrapMyArray($data))
        .')';

      $this->query($sql);

      return $this->_lastInsertId;
    }

    return false;
  }

  public function update($db_name , $data = array() , $where = array()) {
    if(is_array($data) && !empty($data)){
      $data = array_map('mysql_real_escape_string', $data);
      $data = $this->_wrapMyArray($data);

      $sql = 'UPDATE '.$db_name.' SET ';
      $sql .= $this->_arrayImplode("=" , "," , $data);

      if(!empty($where)){
        $sql .= ' WHERE ';
        if(is_array($where)){
          $where = $this->_wrapMyArray($where);
          $sql .= $this->_arrayImplode("=" , "AND" , $where);
        }else{
          $sql .= $where;
        }
      }

      $this->query($sql);
      return true;
    }
    return false;
  }

  public function delete($db_name , $where = array()){
    $sql = 'DELETE FROM '.$db_name.' ';

    if(!empty($where)){
      $sql .= ' WHERE ';
      if(is_array($where)){
        $where = $this->_wrapMyArray($where);
        $sql .= $this->_arrayImplode("=" , "AND" , $where);
      }else{
        $sql .= $where;
      }
    }

    $this->query($sql);
  }

  /**
   * @param $array
   * @param string $wrapper
   * @return array
   */
  private function _wrapMyArray($array , $wrapper = '"') {
    $new_array = array();
    foreach($array as $k=>$element){
      if(!is_array($element)){
        $new_array[$k] = $wrapper . $element . $wrapper;
      }
    }
    return $new_array;
  }

  private function _arrayImplode( $glue, $separator, $array ) {
    if ( ! is_array( $array ) ) return $array;
    $string = array();
    foreach ( $array as $key => $val ) {
      if ( is_array( $val ) )
        $val = implode( ',', $val );
      $string[] = "{$key}{$glue}{$val}";

    }
    return implode( $separator, $string );
  }

}

