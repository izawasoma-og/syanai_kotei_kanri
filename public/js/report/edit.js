"use strict"

//=====================================
//●必要データの読み込み
//=====================================

// 作業内容リストの格納用変数
let oparationList = [];

// 作業内容リストを読み込む
$.ajax({
  type: 'get',
  url: "api/operation",
  dataType: "json",
})
.done(function(data) {
    oparationList = data;
    console.log(data);
})
.fail(function(error){
  console.log(error);
  alert("作業内容一覧の読み込みに失敗しました")
});

//案件一覧の格納用変数
let datas = [];

//案件一覧の項目を読み込む
$.ajax({
  type: 'get',
  url: "api/project",
  dataType: "json",
})
.done(function(data) {
    datas = data;
    console.log(datas)
})
.fail(function(error){
  console.log(error);
  alert("案件内容一覧の読み込みに失敗しました")
});

//=====================================
//●編集ボタンを押した時
//=====================================
let trTag;
let isEditNow = false;
let editId = -1;
let tdDate;
let tdProjectId;
let tdProjectName;
let tdClientName;
let tdWorkingTime;
let tdOperation;
let tdOperationArea;

function goEdit(elem){
    if(!isEditNow){
        isEditNow = true
        trTag = elem.parentNode.parentNode;

        //idの保存
        editId = trTag.getAttribute("editid");
    
        //日時カラム
        tdDate = trTag.querySelectorAll("td")[0];
        let valueDate = new Date(tdDate.textContent);
        valueDate = `${valueDate.getFullYear()}-${(valueDate.getMonth() + 1).toString().padStart(2, "0")}-${valueDate.getDate().toString().padStart(2, "0")}`;
        tdDate.innerHTML = `<input type="date" class="form-control" name="editDate" value="${valueDate}">`;
    
        //案件IDカラム
        tdProjectId = trTag.querySelectorAll("td")[2];
        const valueProjectId = tdProjectId.textContent;
        tdProjectId.innerHTML = `<input formhelpertag="form" type="text" class="form-control formProjectId" name="editProjectId" value="${valueProjectId}" oninput="inputE()" onfocus="focusE(this)" onblur="blurE()" autocomplete="off">`

        //案件名カラム
        tdProjectName = trTag.querySelectorAll("td")[3];
        const valueProjectName = tdProjectName.textContent;
        tdProjectName.innerHTML = `<input formhelpertag="form" type="text" class="form-control formProjectName" value="${valueProjectName}" oninput="inputE()" onfocus="focusE(this)" onblur="blurE() autocomplete="off"">`

        //顧客名カラム
        tdClientName = trTag.querySelectorAll("td")[4];
        const valueClientName = tdClientName.textContent;
        tdClientName.innerHTML = `<input formhelpertag="form" type="text" class="form-control formClientName" value="${valueClientName}" oninput="inputE()" onfocus="focusE(this)" onblur="blurE() autocomplete="off"">`
    
        //稼働時間カラム
        tdWorkingTime = trTag.querySelectorAll("td")[5];
        const valueWorkingTime = tdWorkingTime.textContent;
        tdWorkingTime.innerHTML = `<input type="time" class="form-control" name="editWorkingTime" value="${valueWorkingTime}">`
    
        //作業内容カラム
        tdOperation = trTag.querySelectorAll("td")[6];
        const valueOperation = trTag.querySelectorAll("td")[6].querySelector("span").textContent.trim();
        const selectOperation = document.createElement("select");
        selectOperation.classList.add("form-select");
        selectOperation.setAttribute("name","editOperationId");
        selectOperation.setAttribute("onchange","selectChange(this)");
        oparationList.forEach(operation => {
            const optionOperation = document.createElement("option");
            optionOperation.setAttribute("value",operation.id);
            optionOperation.textContent = operation.name;
            if(operation.name == valueOperation){
                optionOperation.setAttribute("selected","true");   
            }
            selectOperation.appendChild(optionOperation);
        });
    
        //URL
        let urlForm;
        if(valueOperation == "本番アップ"){
            console.log(trTag.querySelectorAll("td")[6].querySelector("a"));
            const url = trTag.querySelectorAll("td")[6].querySelector("a").getAttribute("href");
            urlForm = document.createElement("input");
            urlForm.setAttribute("type","text");
            urlForm.classList.add("form-control");
            urlForm.setAttribute("name","editUrl");
            urlForm.setAttribute("placeholder","本番URLを入力");
            urlForm.value = url;
        }
        const br = document.createElement("br");
        tdOperation.innerHTML = "";
        tdOperation.appendChild(selectOperation);
        if(valueOperation == "本番アップ"){
            tdOperation.appendChild(br);
            tdOperation.appendChild(urlForm);
        }
    
        //操作カラム
        tdOperationArea = trTag.querySelectorAll("td")[7];
        tdOperationArea.innerHTML = `<button type="button" class="btn btn-dark" onClick="submit(this)"><i class="fas fa-check-circle"></i> 確定</button>`
    }
    else{
        alert("編集中の項目が存在します。");
    }

}

function selectHelper(){}

//=====================================
//●フォームヘルパー
//=====================================

let formHelper;

//顧客フォームのエラーメッセージ表示タグ
const formClientIdError = document.getElementById("formClientIdError");

function focusE(input){
    formHelper = new FormHelper(datas,input,["id","project_name","client_name"]);
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
}

//=====================================
//●セレクトボックス選択時
//=====================================
function selectChange(element){
    let tdOperation = element.parentNode;
    //selectedIndex = 3 : 本番アップ
    const selectedIndex = element.selectedIndex
    if(selectedIndex == 3){
        const urlForm = document.createElement("input");
        urlForm.setAttribute("type","text");
        urlForm.classList.add("form-control");
        urlForm.setAttribute("name","editUrl");
        urlForm.setAttribute("placeholder","本番URLを入力");
        const br = document.createElement("br");
        tdOperation.appendChild(br);
        tdOperation.appendChild(urlForm);
    }
    else{
        tdOperation.querySelector("br").remove();
        tdOperation.querySelector("input").remove();
    }
}

//=====================================
//●確定ボタンを押下した時
//=====================================

function submit(element){
    const editDate = document.querySelector("[name='editDate']").value;
    const editProjectId = document.querySelector("[name='editProjectId']").value;
    const editWorkingTime = document.querySelector("[name='editWorkingTime']").value;
    const selectedIndex = document.querySelector("[name='editOperationId']").selectedIndex;
    const editOperationId = document.querySelectorAll("option")[selectedIndex].value;
    let editUrl = null;
    if(editOperationId == 4){
        editUrl = document.querySelector("[name='editUrl']").value;
    }
    const sendData = {
        editId : editId,
        editDate : editDate,
        editOperationId : editOperationId,
        editWorkingTime : editWorkingTime,
        editProjectId : editProjectId,
        editUrl : editUrl,
    }
    $.ajax({
        type: 'PUT',
        url: "api/report",
        data: sendData
      })
      .done(function(data) {
        console.log(data);
        if(data == "complete"){
            updateComp();
            isEditNow = false;
        }
        else{
            alert("情報の更新に失敗しました。");
        }
      })
      .fail(function(error){
        console.log(error);
        alert("URLが未入力です。");
      });
}   

//=====================================
//●情報更新が完了した時
//=====================================

function updateComp(){
    tdDate.innerHTML = tdDate.querySelector("input").value.replace(/-/g,"/");
    tdProjectId.innerHTML = tdProjectId.querySelector("input").value;
    tdProjectName.innerHTML = tdProjectName.querySelector("input").value;
    tdClientName.innerHTML = tdClientName.querySelector("input").value;
    tdWorkingTime.innerHTML = tdWorkingTime.querySelector("input").value;
    
    const selectedIndex = tdOperation.querySelector("select").selectedIndex;
    const value = tdOperation.querySelectorAll("option")[selectedIndex].textContent;
    let url = "";
    if(selectedIndex == 3){
        url = tdOperation.querySelector("input").value;
        tdOperation.innerHTML = `<span>${value} </span><a href="${ url }">リンク</a>`
    } 
    else{
        tdOperation.innerHTML = `<span>${value} </span>`;
    }
    tdOperationArea.innerHTML = `<button type="button" class="btn btn-outline-dark" onClick="goEdit(this)"><i class="fas fa-edit"></i> 編集</button>`;
}