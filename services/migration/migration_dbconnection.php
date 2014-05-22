<?php
require_once('../../config.class.php');
Class migration_dbconnection
{
    //SAME AS dbconnection.php, but with migration db config
  private static $con;
  private static function connect()    { migration_dbconnection::$con = mysqli_connect(Config::migration_host, Config::migration_db_user, Config::migration_db_pass, Config::migration_db); }
  private static function disconnect() { mysqli_close(migration_dbconnection::$con); }

  function __construct()
  {
    migration_dbconnection::connect();
  }

  protected static function query($query, $debug = false)
  {
    if($debug) echo $query;
    if(!(mysqli_query(migration_dbconnection::$con, $query)))
    {
        return false;
    }
    return migration_dbconnection::$con->insert_id;
  }

  protected static function queryInsert($query, $debug = false)
  {
    if($debug) echo $query;
    if(!(mysqli_query(migration_dbconnection::$con, $query)))
    {
        return false;
    }
    return mysqli_insert_id(migration_dbconnection::$con);
  }

  protected static function queryObject($query, $debug = false)
  {
    if($debug) echo $query;
    if(!($sql_data = mysqli_query(migration_dbconnection::$con, $query)))
    {
        return false;
    }
    return mysqli_fetch_object($sql_data);
  }

  protected static function queryArray($query, $debug = false)
  {
    if($debug) echo $query;
    if(!($sql_data = mysqli_query(migration_dbconnection::$con, $query)))
    {
        return false;
    }
    $ret = array();
    while($o = mysqli_fetch_object($sql_data))
        $ret[] = $o;
    return $ret;
  }

  function __destruct()
  {
    migration_dbconnection::disconnect();
  }
}
?>