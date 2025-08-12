<?php
$addressArr = explode("/", $_SERVER['REQUEST_URI']);
$id = $addressArr[3];
$result = product::find($id);
$foundPro = $result->fetch_assoc();
$catResult = category::select(['id', 'title'])->get();
?>
<form class="form pro-form" action="http://localhost/router/updateData/product" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;Edit Product Form&nbsp;</legend>
      <input type="hidden" name="id" value="<?= $foundPro['id']; ?>">
      <div>
         <label for="title">Product Title : </label>
         <input type="text" name="title" placeholder="title" id="title" value="<?= $foundPro['title']; ?>">
      </div>
      <div>
         <label for="price">Product Price : </label>
         <input type="number" name="price" placeholder="price" id="price" value="<?= $foundPro['price']; ?>" min="0">
      </div>
      <div class="pro-form-bottom-row">
         <div class="check-container">
            <label for="exist">Exist :&nbsp;</label>
            <input type="checkbox" name="exist" value="EXIST" id="exist" <?php if ($foundPro['exist'] == "EXIST") {
                                                                              echo "checked";
                                                                           } ?>>
         </div>
         <div class="select-container">
            <label for="category">Category :&nbsp;</label>
            <select name="categoryId" id="category">
               <option value="" hidden>Choose a Category</option>
               <?php
               while ($catRow = $catResult->fetch_assoc()) {
               ?>
                  <option value="<?= $catRow['id']; ?>" <?php if ($foundPro['categoryId'] == $catRow['id']) {
                                                            echo "selected";
                                                         } ?>>
                     <?= $catRow['title']; ?>
                  </option>
               <?php
               }
               ?>
            </select>
         </div>
      </div>
      <button type="submit" onclick="formValidation(event,this)">Update Product</button>
   </fieldset>
</form>