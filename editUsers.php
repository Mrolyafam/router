<?php
$addressArr = explode("/", $_SERVER['REQUEST_URI']);
$id = $addressArr[3];
$result = users::find($id);
$foundUser = $result->fetch_assoc();
?>
<form class="form user-form" action="http://localhost/router/updateData/users" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;Edit User Form&nbsp;</legend>
      <input type="hidden" name="id" value="<?= $foundUser['id']; ?>">
      <div>
         <label for="userName">User Name : </label>
         <input type="text" name="userName" placeholder="user name" id="userName" value="<?= $foundUser['userName']; ?>">
      </div>
      <div>
         <label for="firstName">First Name : </label>
         <input type="text" name="firstName" placeholder="first name" id="firstName" value="<?= $foundUser['firstName']; ?>">
      </div>
      <div>
         <label for="lastName">Last Name : </label>
         <input type="text" name="lastName" placeholder="last name" id="lastName" value="<?= $foundUser['lastName']; ?>">
      </div>
      <div>
         <label for="password">Password : </label>
         <input type="password" name="password" placeholder="password" id="password" value="<?= $foundUser['password']; ?>">
      </div>
      <div>
         <label for="email">Email : </label>
         <input type="email" name="email" placeholder="email" id="email" value="<?= $foundUser['email']; ?>">
      </div>
      <div>
         <label for="phoneNumber">Phone Number : </label>
         <input type="tel" name="phoneNumber" placeholder="phone number" id="phoneNumber" value="<?= $foundUser['phoneNumber']; ?>">
      </div>
      <button type="submit" onclick="formValidation(event,this)">Update User</button>
   </fieldset>
</form>