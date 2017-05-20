$(function (){
  hljs.initHighlightingOnLoad();
});

$("#closeContent,#contentCloseButton").on("click", function(event){
    window.location.replace(window.location.protocol + "//" + window.location.host + '/good2great/category');
});

$("#contentNewButton").on("click", function(event){
  window.location.href=window.location.protocol + "//" + window.location.host
  + '/good2great/content/new';
});

$("#contentEditButton").on("click", function(event){
    window.location.href=window.location.protocol + "//" + window.location.host
    + '/good2great/content/edit?id=' + $("#contentID").val();
});


//
$("li[id^='catDropDown_']").on("click", function(event){
    var curCat = $(this).attr("catName");
    var curCatID = $(this).attr("catID");
    var newCatNames = "";
    var newCatIDs = "";

    if($("#categoryNames").val() == ""){
      newCatNames = curCat;
      newCatIDs = curCatID;
    }else{
      var catNames = $("#categoryNames").val().split(",");
      var catIDs = $("#categoryIDs").val().split(",");
      var hasCur = false;
      for(i=0;i<catNames.length;i++){
          if(catNames[i]==curCat) {
            hasCur = true;
            continue;
          }
          //now the first add element
          if(newCatIDs!=""){
            newCatIDs += ",";
            newCatNames += ",";
          }
          newCatIDs += catIDs[i];
          newCatNames += catNames[i];
      }
      if(!hasCur){
        newCatNames += "," + curCat;
        newCatIDs += "," + curCatID;
      }
    }

    $("#categoryNames").val(newCatNames);
    $("#categoryIDs").val(newCatIDs);
});
