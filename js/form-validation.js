window.onload = init;
function init() {
  document.getElementById("paymentSubmit").onsubmit = validateForm;
   document.getElementById("choosePayment").focus();
}

function validateForm(theForm) {
   with(theForm) {
	if(document.getElementById("choosePayment").value == 'authorize')
	{
		return ( isNotEmpty(your_name, "Please enter name!", elmNameError)
         && isValidEmail(email, "Please enter valid email address!", elmEmailError)
         && isNumeric(auth_amount,"Please enter proper amount",elmAuthamountError)
         && isNotEmpty(cardNo2,"Please enter card number",elmCardNo2Error)
		);

	}

	if(document.getElementById("choosePayment").value == 'paypal')
	{
		return ( isNotEmpty(your_name, "Please enter name!", elmNameError)
         && isValidEmail(email, "Please enter valid email address!", elmEmailError)
         && isNumeric(paypal_amount,"Please enter proper amount",elmPaypalAmountError)
         && isNotEmpty(cardNo1,"Please enter card number",elmCardNo1Error)
		);
	}
	
	
   }
}
 

function postValidate(isValid, errMsg, errElm, inputElm) {
   if (!isValid) {
      if (errElm !== undefined && errElm !== null
            && errMsg !== undefined && errMsg !== null) {
         errElm.innerHTML = errMsg;
      }
      if (inputElm !== undefined && inputElm !== null) {
         inputElm.classList.add("errorBox");
         inputElm.focus();
      }
   } else {
      if (errElm !== undefined && errElm !== null) {
         errElm.innerHTML = "";
      }
      if (inputElm !== undefined && inputElm !== null) {
         inputElm.classList.remove("errorBox");
      }
   }
}
 
function isNotEmpty(inputElm, errMsg, errElm) {
   var isValid = (inputElm.value.trim() !== "");
   postValidate(isValid, errMsg, errElm, inputElm);
   return isValid;
}


 
function isNumeric(inputElm, errMsg, errElm) {
   var isValid = (inputElm.value.trim().match(/^\d+$/) !== null);
   postValidate(isValid, errMsg, errElm, inputElm);
   return isValid;
}

function isValidEmail(inputElm, errMsg, errElm) {
   var isValid = (inputElm.value.trim().match(
         /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/) !== null);
   postValidate(isValid, errMsg, errElm, inputElm);
   return isValid;
}
