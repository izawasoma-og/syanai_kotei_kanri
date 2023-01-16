"use strict"

$(function(){
    const formName = document.getElementById("formName");
    const formNameError = document.getElementById("formNameError");
    const formButton = document.getElementById("formButton");
    
    formName.addEventListener("input",function(){
        if(formName.value == ""){
            formNameError.textContent = "顧客名は必須項目です";
            formButton.disabled = true;
        }
        else{
            formNameError.textContent = "　";
            formButton.disabled = false;
        }
    });
});