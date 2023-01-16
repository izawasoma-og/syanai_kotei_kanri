"use strict"

let errorFlg = {
    "clientId" : false,
    "name" : false,
}

//=====================================
//●クライアント名
//=====================================

//データリストのオブジェクト配列格納用の変数
let datas = [];

//データリストの項目を読み込む
$.ajax({
  type: 'get',
  url: "/api/client",
  dataType: "json",
})
.done(function(data) {
    datas = data;
    console.log(datas);
})
.fail(function(error){
  console.log(error);
  alert("クライアント情報の取得に失敗しました")
});

let formHelper;

//顧客フォームのエラーメッセージ表示タグ
const formClientIdError = document.getElementById("formClientIdError");

function focusE(input){
    formHelper = new FormHelper(datas,input,["id","name"]);
    formHelper.showInputHelper();
}

function inputE(){
    formHelper.showInputHelper();
}

function blurE(){
    formHelper.closeInputHelper();
}

function selectE(elem){
    formHelper.selectInput(elem);
    //エラーメッセージを削除
    formClientIdError.textContent = "　";
    errorFlg.clientId = true;
}

//=====================================
//●プロジェクト名
//=====================================

const formName = document.getElementById("formName");
const formNameError = document.getElementById("formNameError");

formName.addEventListener("input",function(){
    if(formName.value == ""){
        formNameError.textContent = "プロジェクト名は必須項目です";
        errorFlg.name = false;
    }
    else{
        formNameError.textContent = "　";
        errorFlg.name = true;
    }
    isAllFormValid();
});

//=====================================
//●ボタンの発火許可を切り替える
//=====================================

const formButton = document.getElementById("formButton");

function isAllFormValid(){
    let isValid = true;
    console.log(errorFlg);
    for(let key in errorFlg){
        if(!errorFlg[key]){
            isValid = false;
        }
    }
    if(isValid){
        formButton.disabled = false;
    }
    else{
        formButton.disabled = true;
    }
}

//=====================================
//●初回接続時
//=====================================


if(!(formClientId.value == "" || isNaN(Number(formClientId.value)))){
    errorFlg.clientId = true;
}

if(!(formName.value == "")){
    errorFlg.name = true;
}