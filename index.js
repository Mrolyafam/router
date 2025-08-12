// let formElements = document.forms['myForm'].elements;
// let formElementsLength = document.forms['myForm'].elements.length;
let errorBox = document.querySelector(".empty");
function formValidation(ev, el) {
   let forms = el.parentElement.parentElement;
   let formElements = el.parentElement.parentElement.elements;
   let formElementsLength = el.parentElement.parentElement.elements.length;
   console.log(formElements);
   ev.preventDefault();
   let customHtml = "";
   let hasError = false;
   for (let i = 1; i < formElementsLength - 1; i++) {
      if (formElements[i].value == "") {
         formElements[i].style.border = "1px solid red";
         customHtml += formElements[i].id + " " + "is empty" + "&nbsp&nbsp&nbsp&nbsp";
         errorBox.innerHTML = customHtml;
         hasError = true;
      } else {
         formElements[i].style.border = "none";
      }
   }
   if (!hasError) {
      forms.submit();
   }
}