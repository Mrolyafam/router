<form class="form user-form" action="http://localhost/router/getData/users" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;User Form&nbsp;</legend>
      <div>
         <label for="userName">User Name : </label>
         <input type="text" name="userName" placeholder="user name" id="userName">
      </div>
      <div>
         <label for="firstName">First Name : </label>
         <input type="text" name="firstName" placeholder="first name" id="firstName">
      </div>
      <div>
         <label for="lastName">Last Name : </label>
         <input type="text" name="lastName" placeholder="last name" id="lastName">
      </div>
      <div>
         <label for="password">Password : </label>
         <input type="password" name="password" placeholder="password" id="password">
      </div>
      <div>
         <label for="email">Email : </label>
         <input type="email" name="email" placeholder="email" id="email">
      </div>
      <div>
         <label for="phoneNumber">Phone Number : </label>
         <input type="tel" name="phoneNumber" placeholder="phone number" id="phoneNumber">
      </div>
      <button type="submit" onclick="formValidation(event,this)">Save User</button>
   </fieldset>
</form>