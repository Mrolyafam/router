   <form class="form show-form" action="http://localhost/router/searchResult/page/1" method="post" name="myForm">
      <fieldset>
         <legend>&nbsp;search form&nbsp;</legend>
         <div class="show-form-inputs">
            <input type="hidden" name="table" value="<?= $modelName; ?>">
            <div>
               <label for="field">fields : </label>
               <select name="field" id="field">
                  <option value="" hidden>Choose a field</option>
                  <?php
                  while ($field = $result->fetch_assoc()) {
                  ?>
                     <option value="<?= $field['Field']; ?>"><?= $field['Field']; ?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>
            <div>
               <label for="value">value : </label>
               <input type="text" name="value" placeholder="value" id="value">
            </div>
         </div>
         <button type="submit" name="searchForm" onclick="formValidation(event,this)">show</button>
      </fieldset>
   </form>
   </div>