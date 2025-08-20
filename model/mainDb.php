<?php
class mainDb
{
   private $server = "localhost";
   private $userName = "root";
   private $pass = "";
   private $dbName = "ecommerce";
   public static $connection;
   public function __construct()
   {
      if (!self::$connection) {
         self::$connection = new mysqli($this->server, $this->userName, $this->pass, $this->dbName);
      }
      return self::$connection;
   }
}
