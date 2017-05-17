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

$("li[id^='catDropDown_']").on("click", function(event)){
    var curCat = $(this).attr("catName");
    var curCatID =  $(this).attr("catID");
    if($("#categoryNames").val() == "") {
        $("#categoryNames").val(curCat);
        $("#categoryIDs").val(curCatID);
    }
    var catNames = $("#categoryNames").val().split(",");
    var currCat = $(this).attr("catName");
    $.each(catNames, function(i, val){
      if(val == currCat) return;
    });
    $("#categoryNames").val($("#categoryNames").val() + "," + curCat);
    $("#categoryIDs").val($("#categoryNames").val() + "," + curCatID);
}
