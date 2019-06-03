function selectAvatar(id) {
    var selectedImg = $("#add-img .img-style-selected");
    selectedImg.addClass("img-style");
    selectedImg.removeClass("img-style-selected");
    $("#add-img #" + id).addClass("img-style-selected");
}