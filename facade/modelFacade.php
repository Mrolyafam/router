<?php
class modelFacade
{
   public static function __callStatic($methodName, $arguments = null)
   {
      $obj = factory::makeObj(static::class);
      return $obj->$methodName($arguments);
   }
   public function __call($methodName, $arguments = null)
   {
      return $this->$methodName($arguments);
   }
}
