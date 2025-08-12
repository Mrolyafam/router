<?php
class loadFile
{
   public static function load($fileName)
   {
      $fileName .= ".php";
      if (file_exists($fileName)) {
         include "$fileName";
      }
      if (!file_exists($fileName)) {
         include "404.php";
      }
   }
}
