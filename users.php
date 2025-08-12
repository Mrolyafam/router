<?php
$limit = 5;
$result = users::pageInit($limit);
?>
<h2>Users List</h2>
<table style="width: 90%;">
   <thead>
      <tr>
         <th>Id</th>
         <th>User Name</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Password</th>
         <th>Email</th>
         <th>Phone Number</th>
         <th>Edit</th>
         <th>Delete</th>
         <th>Show</th>
      </tr>
   </thead>
   <tbody>
      <?php
      while ($userRow = $result->fetch_assoc()) {
      ?>
         <tr>
            <td><?= $userRow['id']; ?></td>
            <td><?= $userRow['userName']; ?></td>
            <td><?= $userRow['firstName']; ?></td>
            <td><?= $userRow['lastName']; ?></td>
            <td><?= $userRow['password']; ?></td>
            <td><?= $userRow['email']; ?></td>
            <td><?= $userRow['phoneNumber']; ?></td>
            <td><a href="http://localhost/router/editUsers/<?= $userRow['id']; ?>">Edit</a></td>
            <td><a href="http://localhost/router/delete/users/<?= $userRow['id']; ?>">Delete</a></td>
            <td><a href="http://localhost/router/showUsers/<?= $userRow['id']; ?>">Show</a></td>
         </tr>
      <?php
      }
      ?>
   </tbody>
</table>
<?php
$count = users::count()->get()->fetch_assoc()['count(*)'];
?>
<p style="margin-top: 14px; font-weight: bold;">Number of Rows : <?= $count ?></p>
<?php
if ($count > $result->num_rows) {
?>
   <div class="page_num_container">
      <?php
      for ($i = 1; $i - 1 < $count / $limit; $i++) {
      ?>
         <a href="http://localhost/router/users/page/<?= $i; ?>" class="page_num"><?= $i; ?></a>
      <?php
      }
      ?>
   </div>
<?php
}
$route = explode('/', $_SERVER['REQUEST_URI']);
$modelName = $route[2];
$result = $modelName::fields();
include 'customShowForm.php';
include 'searchForm.php';