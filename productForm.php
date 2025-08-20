<?php
$result = category::select('id', 'title')->get();
?>
<form class="form pro-form" action="http://localhost/router/getData/product" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;Product Form&nbsp;</legend>
      <div>
         <label for="title">Product Title : </label>
         <input type="text" name="title" placeholder="title" id="title">
      </div>
      <div>
         <label for="price">Product Price : </label>
         <input type="number" name="price" placeholder="price" id="price" min="0">
      </div>
      <div class="pro-form-bottom-row">
         <div class="check-container">
            <label for="exist">Exist :&nbsp;</label>
            <input type="checkbox" name="exist" value="EXIST" id="exist">
         </div>
         <div class="select-container">
            <label for="category">Category :&nbsp;</label>
            <select name="categoryId" id="category">
               <option value="" hidden>Choose a Category</option>
               <?php
               while ($catRow = $result->fetch_assoc()) {
               ?>
                  <option value="<?= $catRow['id']; ?>">
                     <?= $catRow['title']; ?>
                  </option>
               <?php
               }
               ?>
            </select>
         </div>
      </div>
      <button type="submit" onclick="formValidation(event,this)">Save Product</button>
   </fieldset>
</form>