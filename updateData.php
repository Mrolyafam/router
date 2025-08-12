<?php
$route = explode('/', $_SERVER['REQUEST_URI']);
$modelName = $route[3];
$result = $modelName::update($_POST);
if ($result) {
   echo '<h3 class="home-text"> ' . $modelName . ' UPDATED :)</h3>';
}
if (!$result) {
   echo '<h3 class="error-text"> ' . $modelName . ' NOT UPDATED ):</h3>';
}
