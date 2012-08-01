<?php
  /*
  *  Standard Database Plugin
  *  Copyright (c) 2012 - Verexa
  */
  
  class Database_Plugin extends Plugin{
    private $info = array(
      "type"       =>   "mysql",
      "host"       =>   "localhost",
      "port"       =>   "3306",
      "username"   =>   "user",
      "password"   =>   "pass",
      "database"   =>   "db"
    );
    
    /* Database Connection Resource */
    private $connection; 
    
    /* Plugin Loading */
    public function load(){
      $this->connect();
    }
    
    /* Connect to Database */
    public function connect(){
      switch($this->info["type"]){
        case "mysql": 
          $this->connection = mysql_connect($this->info["host"].":".$this->info["port"], $this->info["username"], $this->info["password"]);
          $this->select_db($this->info["database"]);
          break;
        case "pg":
          $this->connection = pg_connect("host=". $this->info["host"] ." port=". $this->info["port"] ." dbname=". $this->info["database"] ." user=". $this->info["username"] ." password=". $this->info["password"]);
          break;
      }
    }
    
    /* Close Connection */
    public function disconnect(){
      switch($this->info["type"]){
        case "mysql": 
          mysql_close($this->connection);
          break;
        case "pg":
          pg_close($this->connection);
          break;
      }
    } 
    
    /* Change Host */
    public function change_host($host){
      $this->info["host"] = $host;
    }
    
    /* Select Database */
    public function select_db($database){
      switch($this->info["type"]){
        case "mysql": 
          mysql_select_db($database, $this->connection);
          break;
      }
    }
    
    /* Return Number of Rows*/
    public function num_rows($result){
      switch($this->info["type"]){
        case "mysql":
          return mysql_num_rows($result);
        case "pg":
          return pg_num_rows($result);
      }
    }
    
    /* Return an Escaped String */
    public function escape_string($str){
      return addslashes((string)$str);
    }
    
    /* Run Query on Database */
    public function query($query){
      switch($this->info["type"]){
        case "mysql":
          return mysql_query($query, $this->connection);
        case "pg":
          return pg_query($this->connection, $query);
      }
    }
    
    /* Fetch Array of Result */
    public function fetch_array($result){
      switch($this->info["type"]){
        case "mysql": 
          return mysql_fetch_array($result);
        case "pg":
          return pg_fetch_all($result);
      }
    }
    
    /* Free Result */
    public function free_result(&$result){
      switch($this->info["type"]){
        case "mysql": 
          mysql_free_result($result);
          break;
        case "pg":
          pg_free_result($result);
          break;
      }
    }
    
    /* Return Connection Status */
    public function is_connected(){
      switch($this->info["type"]){
        case "mysql": 
          return mysql_ping($this->connection);
        case "pg":
          return pg_ping($this->connection);
      }
    }
  }

?>