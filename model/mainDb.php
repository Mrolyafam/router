<?php
class mainDb
{
   protected static $table;
   protected static $connection;
   private static $server = "localhost";
   private static $userName = "root";
   private static $pass = "";
   private static $dbName = "ecommerce";
   protected static function createConn()
   {
      if (!self::$connection) {
         self::$connection = new mysqli(self::$server, self::$userName, self::$pass, self::$dbName);
      }
   }
}
