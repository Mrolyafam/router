<?php
$addressArr = explode("/", $_SERVER['REQUEST_URI']);
$className = $addressArr[3];
$id = $addressArr[4];
$result = $className::delete($id);
if ($result) {
   echo '<h3 class="home-text"> ' . $className . ' DELETED :)</h3>';
}
if (!$result) {
   echo '<h3 class="error-text"> ' . $className . ' NOT DELETED ):</h3>';
}
