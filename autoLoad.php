<?php
class autoLoad
{
   public static function load($class)
   {
      if ($class === "product" || $class === "category" || $class === "users" || $class === "mainDb" || $class === "footer" || $class === "model") {
         $class = "model/" . $class;
      }
      if ($class === "factory") {
         $class = "factory/" . $class;
      }
      if ($class === "modelFacade") {
         $class = "facade/" . $class;
      }
      $class .= ".php";
      if (file_exists($class)) {
         include "$class";
      } else {
         die("this ($class) is not found.");
      }
   }
}
spl_autoload_register(['autoLoad', 'load']);
