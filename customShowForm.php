<div class="forms-container">
   <form class="form show-form" action="http://localhost/router/customshow/page/1" method="post" name="myForm">
      <fieldset>
         <legend>&nbsp;multiple show form&nbsp;</legend>
         <div class="show-form-inputs">
            <input type="hidden" name="table" value="<?= $modelName; ?>">
            <div>
               <label for="start">start : </label>
               <input type="number" name="start" placeholder="start" id="start" min="0">
            </div>
            <div>
               <label for="end">end : </label>
               <input type="number" name="end" placeholder="end" id="end" min="0">
            </div>
         </div>
         <button type="submit" name="customShowForm" onclick="formValidation(event,this)">show</button>
      </fieldset>
   </form>