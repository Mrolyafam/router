<?php
class router
{
   private $uri;
   private $uriArr;
   function __construct($uri)
   {
      $this->uri = $uri;
   }
   public function parseUri()
   {
      $this->uriArr = explode("/", $this->uri);
      return $this->uriArr;
   }
}
