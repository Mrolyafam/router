<?php
$addressArr = explode("/", $_SERVER['REQUEST_URI']);
$id = $addressArr[3];
$result = category::find($id);
$foundCat = $result->fetch_assoc();
?>
<form class="form" action="http://localhost/router/updateData/category" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;Edit Category Form&nbsp;</legend>
      <input type="hidden" name="id" value="<?= $foundCat['id']; ?>">
      <div>
         <label for="title">Category Title : </label>
         <input type="text" name="title" placeholder="title" id="title" value="<?= $foundCat['title']; ?>">
      </div>
      <div>
         <label for="description">Category Description : </label>
         <input type="text" name="description" placeholder="description" id="description" value="<?= $foundCat['description']; ?>">
      </div>
      <button type="submit" onclick="formValidation(event,this)">Update Category</button>
   </fieldset>
</form>