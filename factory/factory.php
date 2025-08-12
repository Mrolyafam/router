<?php
class factory
{
   private static $instances = [];
   public static function makeObj($className, $param = null)
   {
      if (!isset(self::$instances[$className])) {
         self::$instances[$className] = new $className($param);
      }
      return self::$instances[$className];
   }
}
