<?php
$addressArr = explode("/", $_SERVER['REQUEST_URI']);
$id = $addressArr[3];
$result = users::find($id);
$foundUser = $result->fetch_assoc();
?>
<h2>Single User</h2>
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
      </tr>
   </thead>
   <tbody>
      <tr>
         <td><?= $foundUser['id']; ?></td>
         <td><?= $foundUser['userName']; ?></td>
         <td><?= $foundUser['firstName']; ?></td>
         <td><?= $foundUser['lastName']; ?></td>
         <td><?= $foundUser['password']; ?></td>
         <td><?= $foundUser['email']; ?></td>
         <td><?= $foundUser['phoneNumber']; ?></td>
         <td><a href="http://localhost/router/editUser/<?= $foundUser['id']; ?>">Edit</a></td>
         <td><a href="http://localhost/router/delete/user/<?= $foundUser['id']; ?>">Delete</a></td>
      </tr>
   </tbody>
</table>