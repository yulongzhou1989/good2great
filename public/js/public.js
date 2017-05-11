$("#closeContent,#contentCloseButton").on("click", function(event){
    // event.preventDefault();
    // history.back(1);
    window.location.href='list.html';
});

$("#contentEditButton").on("click", function(event){
    window.location.href='editContent.html';
});
