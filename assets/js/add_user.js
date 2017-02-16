$("#add_first_name, #add_middle_name,#add_surname").on("keyup", function (e) {
    var isCyrilic = handleCyrilicName($(this).val());
    if (e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39 ||e.keyCode == 16||e.keyCode == 35) {
        if (isCyrilic) {
            $(this).css("color", "black");
        }
        return true;
    }
    if (isCyrilic) {
        $(this).css("color", "black");
        $(".save").css("background-color", "#d58512");
    }
    else if (!isCyrilic) {
        $(this).val($(this).val().substring(0, $(this).val().length - 1));

        if (handleCyrilicName($(this).val())) {
            $(this).css("color", "black");
        }
        else{
            $(this).css("color", "red");
        }
        showDialog("alert", "Въведете имената на кирилица с дължина до 32 букви.", "cyrilic_bootbox");
    }
});
$("#add_first_name, #add_middle_name,#add_surname").on("keydown", function (e) {
    var isCyrilic = handleCyrilicName($(this).val());
    if (e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39 ||e.keyCode == 16 ||e.keyCode == 35) {
        return true;
    }
    if (isCyrilic) {
        $(this).css("color", "black");
        $(".save").css("background-color", "#d58512");
    }
    else {
        $(this).val($(this).val().substring(0, $(this).val().length - 1));
    }
});
//birthday validation
$("#add_birthday").on("keyup", function () {

    var isValidDate = handleDate($(this).val());
    if (isValidDate) {
        $(".save").css("background-color", "#d58512");
        $(this).css("color", "black");
    }
    else if (!isValidDate) {
        $(this).css("color", "red");
        $(".save").css("background-color", "red");
    }
});

$("#add_birthday").on("change", function () {
    var isValidDate = handleDate($(this).val());
    if (isValidDate) {
        $(".save").css("background-color", "#d58512");
        $(this).css("color", "black");
    }
    else if (!isValidDate) {
        $(this).css("color", "red");
        showDialog("alert", "Въведете валидна дата /ден-месец-година/ 10-10-1996.", "birthday_bootbox");
        $(".save").css("background-color", "red");
    }
});
$("#add_birthday").datepicker({
    dateFormat: "yy-mm-dd",
    yearRange: '1900:2013',
    changeMonth: true,
    changeYear: true
});

$("#new_user").click(function (ev) {
    var first_nameColor = $("#add_first_name").css("color");
    var middle_nameColor = $("#add_middle_name").css("color");
    var surnameColor = $("#add_surname").css("color");
    var dateColor = $("#add_birthday").css('color');
    /*add user*/
    if (first_nameColor == 'rgb(0, 0, 0)' && middle_nameColor == 'rgb(0, 0, 0)' && surnameColor == 'rgb(0, 0, 0)' && dateColor == 'rgb(0, 0, 0)') {
        var first_name = $("#add_first_name").val();
        var middle_name = $("#add_middle_name").val();
        var surname = $("#add_surname").val();
        var birthday = $("#add_birthday").val();
        $.ajax({
            url: HOME_URL,
            type: "POST",
            dataType: "JSON",
            data: {
                requestType: "ajax",
                action: "add_user",
                first_name: first_name,
                middle_name: middle_name,
                surname: surname,
                birthday: birthday
            }, success: function (response) {

                if (response != 1) {
                    showDialog("alert", "Моля, въведете правилни данни.", 'invalid_data');
                }
                if (response == 1) {
                    $("#add_first_name").val("");
                    $("#add_middle_name").val("");
                    $("#add_surname").val("");
                    $("#add_birthday").val("");
                    showDialog("alert", "Честито създадохте нов рожденик.", 'confirm_new_user');
                }
            }
        })

    }
    //wrong data
    else if (first_nameColor == 'rgb(255, 0, 0)' ||
        middle_nameColor == 'rgb(255, 0, 0)' ||
        surnameColor == 'rgb(255, 0, 0)' ||
        dateColor == 'rgb(255, 0, 0)') {
        showDialog("alert", "Моля, въведете правилни данни.", 'invalid_data');
    }
    //missing data
    else if (first_nameColor == 'rgb(85, 85, 85)' || middle_nameColor == 'rgb(85, 85, 85)' || surnameColor == 'rgb(85, 85, 85)' || dateColor == 'rgb(85, 85, 85)') {
        showDialog("alert", "Моля, въведете всички данни.", 'invalid_data');
    }
});

