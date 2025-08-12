<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="http://localhost/router/style.css">
   <title>
      <?php
      $address = $_SERVER['REQUEST_URI'];
      $addressArr = explode("/", $address);
      $title = $addressArr[2];
      if ($addressArr[2] == "") {
         $title = "home";
      }
      echo $title;
      ?>
   </title>
</head>

<body>
   <?php include "menu.php"; ?>
   <div class="container">