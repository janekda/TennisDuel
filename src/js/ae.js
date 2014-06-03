function loadFromStorage(){
   
   var formElements = ["yourLevel", "maxBasicDegree", "rangeLevel"]
   for (var i=0; i<formElements.length; i++){
    
      var formElementsValue = localStorage.getItem(formElements[i]);
      if(formElementsValue != null){
         
         $("#" + formElements[i]).val(formElementsValue);
      }
   }
}

/**
 *  Kontroluje že hodnoty jsou čísla a ukládá do storage.
 **/ 
function registerFormEvents(){
   
   $(":text[class='numbers']").change(function() {
      
      var isInteger = checkIntegerValue($(this).val());
      if(isInteger){
         localStorage.setItem($(this).attr("id"), $(this).val());
      }
      else{
          $(this).val("");
          $(this).focus();
      }
      
   });
   
  
}

 function checkIntegerValue(value){
   
   var isInteger = false;
   var intRegex = /^\d+$/;
   if(intRegex.test(value)) {
      isInteger = true;
   }
   
   return isInteger;
}
   
$(function(){
   
   
   registerFormEvents();
   loadFromStorage();   
});