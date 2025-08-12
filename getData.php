<?php
$route = explode('/', $_SERVER['REQUEST_URI']);
$modelName = $route[3];
if ($modelName != 'footer') {
   $result = $modelName::create($_POST);
   if ($result) {
      echo '<h3 class="home-text">' . $modelName . ' INSERTED :)</h3>';
   }
   if (!$result) {
      echo '<h3 class="error-text">' . $modelName . ' NOT INSERTED ):</h3>';
   }
}
if ($modelName == 'footer') {
   $result = $modelName::all();
   if ($result->num_rows) {
      $updateResult = $modelName::update($_POST);
      if ($updateResult) {
         echo '<h3 class="home-text">Designer Data UPDATED :)</h3>';
      }
      if (!$updateResult) {
         echo '<h3 class="error-text">Designer Data NOT UPDATED ):</h3>';
      }
   }
   if (!$result->num_rows) {
      $insertResult = $modelName::create($_POST);
      if ($insertResult) {
         echo '<h3 class="home-text">Designer Data INSERTED :)</h3>';
      }
      if (!$insertResult) {
         echo '<h3 class="error-text">Designer Data NOT INSERTED ):</h3>';
      }
   }
}
