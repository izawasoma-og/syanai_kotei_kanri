"use strict"

//データリストのオブジェクト配列格納用の変数
let datas = [];

//データリストの項目を読み込む
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

iniSetting();

function isFullInput(element) {
    const fieldId = getAttributeByGoingBackParents(element, "fieldId");
    const hitElement = document.querySelector(`[fieldId="${fieldId}"]`);
    if (inputGroupJudge(hitElement)) {
        //各要素に割り振られたfieldIdの中で最大値を取得する
        const allInputGroup = document.querySelectorAll("[fieldId]");
        let work = -1;
        allInputGroup.forEach((inputGroup) => {
            if (Number(work) < Number(inputGroup.getAttribute("fieldId"))) {
                work = Number(inputGroup.getAttribute("fieldId"));
            }
        });
        const maxFieldId = work;
        console.log(fieldId);
        console.log(maxFieldId);
        if (fieldId == maxFieldId) {
            addInputGroup(maxFieldId);
            iniSetting();
        }
    }
}

function getAttributeByGoingBackParents(element, attributeName) {
    
    let work = element;
    let value = work.getAttribute(attributeName);
    let flg = true;
    
    while (flg) {
        //attribute発見？
        if (value) {
            return value;
        }
        
        //親要素はある？
        if (work.tagName == "BODY") {
            //ない
            flg = false;
        }
        else {
            //ある
            value = work.getAttribute(attributeName);
            work = work.parentNode;
        }
    }
    return null;
}

function inputGroupJudge(element) {
    
    let errorFlg = true;
    
    const inputItems = element.querySelectorAll(".inputItem");
    const selectItems = element.querySelectorAll(".selectItem");
    
    //以下各要素に対して必須チェックを行う
    inputItems.forEach((inputItem) => {
        if (inputItem.value == "") {
            errorFlg = false;
        }
    });
    selectItems.forEach((selectItem) => {
        if (selectItem.selectedIndex == 0) {
            errorFlg = false;
        }
    });
    
    return errorFlg;
}

function addInputGroup(maxFieldId) {
    $("#formTable").append(`
    <tr fieldid="${Number(maxFieldId) + 1}">
        <td class="col-1 align-middle text-center">
            <input class="form-control inputItem formProjectId" type="text" name="report[${Number(maxFieldId) + 1}][project_id]" 
            value="" oninput="inputE()" onfocus="focusE(this)" onblur="blurE()" formhelpertag="form${Number(maxFieldId) + 1}">
        </td>
        <td class="col-2 align-middle text-center">
            <input class="form-control inputItem formProjectName" type="text" name="report[${Number(maxFieldId) + 1}][project_name]" 
            value="" oninput="inputE()" onfocus="focusE(this)" onblur="blurE()" formhelpertag="form${Number(maxFieldId) + 1}">
        </td>
        <td class="col-2 align-middle text-center">
            <input class="form-control inputItem formClientName" type="text" name="report[${Number(maxFieldId) + 1}][client_name]" 
            value="" oninput="inputE()" onfocus="focusE(this)" onblur="blurE()" formhelpertag="form${Number(maxFieldId) + 1}">
        </td>
        <td class="col-2 align-middle text-center">
            <input type="time" class="form-control inputItem" id="formClientId" value="" name="report[${Number(maxFieldId) + 1}][working_time]">
        </td>
        <td class="col-3 align-middle text-center">
            <select tag="${maxFieldId + 1}" class="form-select selectItem" aria-label="Default select example" name="report[${Number(maxFieldId) + 1}][operation_id]" onchange="selectBoxChange(this)">
                <option value="0" selected>選択してください</option>
                <option value="1">コーディング</option>
                <option value="2">修正</option>
                <option value="3">プログラミング</option>
                <option value="4">本番アップロード</option>
            </select>
            <span class="d-none">
                <br>
                <input type="text" class="form-control" name="report[${maxFieldId + 1}][url]" value="http://dammy" placeholder="本番URLを入力">
            </span>
        </td>
        <td class="col-1 align-middle text-center">
            <button type="button" class="btn btn-danger" deleteId="${maxFieldId + 1}"><i class="fas fa-minus-circle"></i></button>
        </td>
    </tr>
    `);
}

function iniSetting(){
    let inputItems = document.querySelectorAll('.inputItem');
    let selectItems = document.querySelectorAll('.selectItem');
    let deleteBtns = document.querySelectorAll("[deleteId]");
    
    inputItems.forEach((element) => {
        element.addEventListener("input", function () {
            isFullInput(this);
        });
    });
    
    selectItems.forEach((element) => {
        element.addEventListener("change", function () {
            isFullInput(this);
        });
    });

    deleteBtns.forEach((element) => {
        element.addEventListener("click",function(){
           deleteFormGroup(this); 
        });
    })
}

function deleteFormGroup(deleteBtn){
    let deleteId = deleteBtn.getAttribute("deleteId");
    let targetElement = document.querySelector(`[fieldId="${deleteId}"]`);
    targetElement.remove();
}


let formHelper;

function focusE(input){
    formHelper = new FormHelper(datas,input,["id","project_name","client_name"]);
    formHelper.showInputHelper();
    formHelper.settingStyleFormhelperPositionTop("auto");
}

function inputE(){
    formHelper.showInputHelper();
    formHelper.settingStyleFormhelperPositionTop("auto");
}

function blurE(){
    formHelper.closeInputHelper();
}

function selectE(elem){
    formHelper.selectInput(elem);
}

function returnParentNode(element,num){
    for(let i = 0; i < num; i++){
        element = element.parentNode;
    }
    return element;
}

function selectBoxChange(element){
    console.log(element);
    //selectedIndex = 4 : 本番アップ
    const selectedIndex = element.selectedIndex
    //セレクトタグの親要素
    const parent = element.parentNode;
    //URL入力フォームのラッパー
    const wrapperSpan = parent.querySelector(["span"]);
    //URL入力フォーム
    const urlForm = wrapperSpan.querySelector(["input"]);
    //識別番号
    const tag = element.getAttribute("tag");

    if(selectedIndex == 4){
        wrapperSpan.classList.remove("d-none");
        urlForm.value = "";
    }
    else{
        wrapperSpan.classList.add("d-none");
        urlForm.value = "http://dammy";
    }
}