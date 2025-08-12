<?php
include "header.php";
include "autoLoad.php";
$uri = $_SERVER['REQUEST_URI'];
$router = factory::makeObj('router', $uri);
$uriArray = $router->parseUri();
if ($uriArray[2] == "" && count($uriArray) == 3) {
   loadFile::load("home");
}
if ($uriArray[2] != "" && count($uriArray) >= 3) {
   loadFile::load($uriArray[2]);
}
include "footer.php";
