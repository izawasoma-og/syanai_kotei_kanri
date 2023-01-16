class FormHelper {
    /**
    * コンストラクタ
    * @param {number} duration スクロール時間のミリ秒です。
    */
    constructor(datas,input,column){

        /**
         * [datas]検索対象のデータ配列
         */
        this.datas = datas;

        /**
         * [datas]検索対象のデータ配列
         */
        this.column = column;

        /**
         * [nowTypingForm]入力中のinput要素
         */
        this.nowTypingForm = input;
    
        /**
         * [formHelperTagName]複数inputをグループ化する際に用いるタグの値
         */
        if(this.nowTypingForm.getAttribute("formhelpertag") === null){
            console.error("formhelper:入力されたinputタグにformhelpertag属性が付与されていません。");
        }
        else{
            this.formHelperTagName = this.nowTypingForm.getAttribute("formhelpertag");
        }

        /**
         * [siblingForm]タグによってグループ化されたinput要素のnodeList
         */
        this.siblingForms = document.querySelectorAll(`[formhelpertag=${this.formHelperTagName}]`);

        /**
         * [formHelperWidth]フォームヘルパーのwidth
         */
        this.formHelperWidth = this.getFormHelperWidth();

        /**
         * [keyword]inputに入力されたキーワード
         */
        this.keyword = "";

        /**
         * [formhelper]フォームヘルパー要素それ自身(ulタグ)。
         */
        this.formHelper = undefined;

        /**
         * [hitData]ヒットしたデータ列。
         */
        this.hitDatas = [];

        /**
         * [selectData]最後に選択した選択データ
         */
        this.selectData = [];

        /**
         * [selectFlg]liタグを選択した後に走るblurかを判別するためのフラグ
         */
        this.selectFlg = false;


        /**
         * [iniValues]コンストラクタされた時点の各inputのvalue値
         */
        this.iniValue = this.getInputValues();
    }

    /**
    * フォームヘルパーの幅を取得する。
    * @return 一番左のinputの左端〜一番右のinputの右端までの距離(px)
    */
    getFormHelperWidth(){
        const leftCoordinates = [];
        const rightCoordinates = [];
        this.siblingForms.forEach((siblingForm,index) => {
            leftCoordinates[index] = siblingForm.getBoundingClientRect().left;
            rightCoordinates[index] = siblingForm.getBoundingClientRect().right;
        });
        const formsLeftEdge = Math.min(...leftCoordinates);
        const formsRightEdge = Math.max(...rightCoordinates);
        return formsRightEdge - formsLeftEdge;
    }

    
    /**
     * focus,inputで動くinputタグのイベント
     * 主に候補の表示処理
    */
    showInputHelper(){
        //古いフォームヘルパーが合ったら消す
        if(this.formHelper !== undefined){
           this.formHelper.remove();
        }
        //入力されている検索キーワードを取得
        this.getInputValue();
        //データ検索
        this.hitDatas = this.searchData(this.keyword);
        //フォームヘルパー本体を生成して、表示する
        this.formHelper = document.createElement("ul");
        this.formHelper.classList.add("formhelper");
        this.formHelper.style.cssText = `width: ${this.formHelperWidth}px;`;
        this.hitDatas.forEach((hitData,index) => {
            let li = document.createElement("li");
            li.classList.add("formhelperItem")
            li.setAttribute("hitDataIndex",index);
            li.setAttribute("onmousedown","selectE(this)");
            let innerText = "";
            for(const property in hitData){
                innerText += hitData[property];
                innerText += " ";
            }
            li.textContent = innerText;
            this.formHelper.appendChild(li);
        });
        this.siblingForms[0].after(this.formHelper);
    }
    
    /**
     * blurで動くinputタグのイベント
     * フォームヘルパーの非表示処理
     * ※selectInputHelperの方が先に動作する
    */
    closeInputHelper(){
        if(this.formHelper !== undefined){
           this.formHelper.remove();
        }
        //blurイベントの前にonmousedownが動いていないのであれば、実行
        if(!this.selectFlg){
            //inputへデータを格納する（データ不整合対策）
            this.resetInputValues();
        }
    }
    
    /**
     * onmousedownで動くliタグのイベント
     * 選択した要素から、該当データをinputタグに格納する
     * ※closeInputHelperの方が先に動作する
    */
    selectInput(elem){
        //ヒットデータと対応するindex番号を取得
        const hitDataIndex = elem.getAttribute("hitdataindex");
        //該当データ取得
        this.selectData = this.hitDatas[hitDataIndex];
        //inputへデータを格納する
        this.setSelectedInputValue();
        //この後動くblurイベントのためのフラグを設定
        this.selectFlg = true;
    }
    
    /**
    * 入力されたキーワードを取得し、フィールドへ格納
    */
    getInputValue(){
        this.keyword = this.nowTypingForm.value;
    }

    /**
    * 選択されたデータを用いて、inputへデータを格納する
    */
    setSelectedInputValue(){
        //データに対して、どのデータをinputに格納するかの指定がない場合
        if(this.column === undefined){
           let index = 0;
           for(const property in this.selectData){
               if(this.siblingForms[index]){
                   this.siblingForms[index].value = this.selectData[property];
                }
                index++;
            }
        }
        //データに対して、どのデータをinputに格納するかの指定がある場合
        else{
            let index = 0;
            this.column.forEach((columnName) => {
                if(this.siblingForms[index]){
                    this.siblingForms[index].value = this.selectData[columnName];
                }
                index++;
            })
        }
    }

    /**
    * inputに入力されているデータを取得する
    */
    getInputValues(){
        const iniValues = [];
        this.siblingForms.forEach((form) => {
            iniValues.push(form.value);
        });
        return iniValues;
    }

    /**
    * inputの値を元の状態に戻す
    */
    resetInputValues(){
        this.siblingForms.forEach((form,index) => {
            form.value = this.iniValue[index];
        });
    }

    /**
    * フォームヘルパーのtopの位置を調整
    */

    settingStyleFormhelperPositionTop(top){
        console.log(this.formHelper);
        this.formHelper.style.top = `${top}`;
    }

    //以下、汎用メソッド
    
    /**
     * 入力されたデータから、検索条件にヒットするデータを取得
    * @return ヒットしたdata配列
    */
    searchData(keyword){
        //検索結果格納用の配列とindex
        const result = [];
        let index = 0;
        //検索テキストをフォーマットする
        keyword = this.formattingToSearchString(keyword);
        //検索処理
        this.datas.forEach((data) => {
            let targetStr = "";
            for(const property in data){
                targetStr = this.formattingToSearchString(data[property]);
                if(targetStr.indexOf(keyword) !== -1){
                    result[index] = data;
                    index++;
                    break;
                }
            }
        })
        return result;
    }

    /**
    * 入力された文字列に含まれる全角文字を全て半角文字に変換して返す
    * @param string 文字列
    * @return 半角変換した文字列
    */
    fullTohalf(string){
        return string.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
            return String.fromCharCode(s.charCodeAt(0) - 65248);
        })
    }

    /**
    * 入力された文字列に含まれるカタカナを全てひらがなに変換して返す
    * @param string 文字列
    * @return カタカナをひらがなに変換した文字列
    */
    kanaToHira(str) {
        return str.replace(/[\u30a1-\u30f6]/g, function(match) {
            var chr = match.charCodeAt(0) - 0x60;
            return String.fromCharCode(chr);
        });
    }

    /**
    * 検索用文字列に整形（全角→半角、大文字→小文字、カタカナ→ひらがな）
    * @param string 文字列
    * @return 整形した文字列
    */
    formattingToSearchString(str){
        str = str.toString();
        str = this.fullTohalf(str);
        str = str.toLowerCase();
        return this.kanaToHira(str);
    }
}