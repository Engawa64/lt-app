//詳細を見るボタンのクリックイベント
//========================================================
function openExplainPage() {
  //dvdのjanの値を渡すための変数
  var dvd_jan = document.getElementById('dvd_jan').innerText;
  console.log('DVD:' + dvd_jan);
  //ページ遷移
  window.open("../dvd_explain.php?dvd=" + dvd_jan);
}

//Vue.jsの処理
//========================================================
var vueJson = new Vue({
    el: '#vueJson',
    data: {
      searchWord: '',
      allData: [],
    },
    methods: {
      fetchAllData: function() {
        axios.post('../select.php',{

        }).then(function(responce) {
          //SELECTの結果(select.php参照)を配列で格納
          vueJson.allData = responce.data;
          console.log(responce.data);
        });
      },
    },
    //ロードされた時に読み込まれる
    created: function() {
      this.fetchAllData();
    },
    computed: {
      searchedData: function() {
        var allData = [];
        for (let i in this.allData) {
          var searched = this.allData[i];
          if ((searched.title.indexOf(this.searchWord) !== -1) || (searched.title_ja.indexOf(this.searchWord) !== -1) || (searched.title_eng.indexOf(this.searchWord) !== -1)) {
            allData.push(searched);
          }
        }
        return allData;
      }
    }
});