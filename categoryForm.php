<form class="form" action="http://localhost/router/getData/category" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;Category Form&nbsp;</legend>
      <div>
         <label for="title">Category Title : </label>
         <input type="text" name="title" placeholder="title" id="title">
      </div>
      <div>
         <label for="description">Category Description : </label>
         <input type="text" name="description" placeholder="description" id="description">
      </div>
      <button type="submit" onclick="formValidation(event,this)">Save Category</button>
   </fieldset>
</form>