function verticalAlignModal(element) {
    var top = ($(window).height() - element.outerHeight(true)) / 2;
    if(top < 20){
        top = 20;
    }
    element.css({"top": top, "left": 0});
}

function fixBodyModal() {
    if ($(".modal-dialog").length > 0 && !$("body").hasClass('modal-open')) {
        $("body").addClass('modal-open');
    }
}
//THIS WORKS FOR ALL BOOTBOXES
function fixZIndexBackdrop(element) {
    var bootbox_z_index = 1052;
    var bootbox_backdrop_z_index = 1051;
    $('.bootbox').each(function (index) {
        bootbox_z_index += 2;
        bootbox_backdrop_z_index += 2;
        $(this).css({'z-index': bootbox_z_index}).next('.modal-backdrop').css({'z-index': bootbox_backdrop_z_index});

    })
    //element.last().css({'z-index': 1052}).next('.modal-backdrop').css({'z-index':1051});
}
$(window).resize(function () {
    verticalAlignModal($(".modal-dialog"));
})


function showDialog(dialog_type, message, className) {
    if (className == undefined) {
        className = "";
    }
    var dialog = eval("bootbox." + dialog_type)({
        "message": message,
        "animate": false,
        "show": false,
        className: className
    });
    dialog.on('hidden.bs.modal', function () {
        fixBodyModal();
    });
    dialog.on('shown.bs.modal', function () {
        verticalAlignModal($(this).find(".modal-dialog"));
        fixZIndexBackdrop($(this));
    });
    dialog.modal('show'); //KOPR

}