<?php
$result = footer::all();
$footer = $result->fetch_assoc();
?>
<form class="form" action="http://localhost/router/getData/footer" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;Footer Information&nbsp;</legend>
      <?php if ($result->num_rows) { ?> <input type="hidden" name="id" value="<?= $footer['id']; ?>"> <?php } ?>
      <div>
         <label for="designerName">Designer Name : </label>
         <input type="text" name="designerName" placeholder="designer name" id="designerName" value="<?php if ($result->num_rows) {
                                                                                                         echo $footer['designerName'];
                                                                                                      } ?>">
      </div>
      <div>
         <label for="phoneNumber">Phone Number : </label>
         <input type="number" name="phoneNumber" placeholder="phone number" id="phoneNumber" value="<?php if ($result->num_rows) {
                                                                                                      echo $footer['phoneNumber'];
                                                                                                   } ?>">
      </div>
      <button type="submit" onclick="formValidation(event,this)">Save</button>
   </fieldset>
</form>