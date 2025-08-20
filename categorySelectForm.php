<form class="form show-form cat-show-form" action="http://localhost/router/categoryProducts/page/1" method="post" name="myForm">
   <fieldset>
      <legend>&nbsp;Category Options&nbsp;</legend>
      <div>
         <select name="type" id="type">
            <option hidden value="">select an option</option>
            <option value="with">show categories with product</option>
            <option value="without">show categories without product</option>
         </select>
      </div>
      <button type="submit" onclick="formValidation(event,this)">show</button>
   </fieldset>
</form>