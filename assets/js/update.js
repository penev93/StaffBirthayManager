$("#edit_user").click(function (ev) {
    var first_name_color = $("#edit_first_name").css("color");
    var middle_name_color = $("#edit_middle_name").css("color");
    var surname_color = $("#edit_surname").css("color");
    var birthday_color = $("#edit_birthday").css("color");
    var first_name = $("#edit_first_name").val();
    var middle_name = $("#edit_middle_name").val();
    var surname = $("#edit_surname").val();
    var birthday = $("#edit_birthday").val();


    if (first_name_color == "rgb(255, 0, 0)" || middle_name_color == "rgb(255, 0, 0)" || surname_color == "rgb(255, 0, 0)" ||

        birthday_color == "rgb(255, 0, 0)") {
        showDialog("alert", "Моля въведете валидни данни.", "valid_data");
        return false;
    }

    else if ((first_name_color == "rgb(85, 85, 85)" || first_name_color == "rgb(0, 0, 0)" ) && (middle_name_color == "rgb(85, 85, 85)" || middle_name_color == "rgb(0, 0, 0)" ) && (surname_color == "rgb(85, 85, 85)" || surname_color == "rgb(0, 0, 0)" ) && (birthday_color == "rgb(85, 85, 85)" || birthday_color == "rgb(0, 0, 0)")) {

        var user_id = $(".edit_user_id").val();


        $.ajax({
            url: HOME_URL,
            type: "POST",
            dataType: 'JSON',
            data: {
                requestType: "ajax",
                action: "update_user",
                id: user_id,
                first_name: first_name,
                middle_name: middle_name,
                surname: surname,
                birthday: birthday
            },
            success: function (response) {
                if (response == "Моля,въведете валидни данни.") {
                    showDialog("alert", "Моля,въведете валидни данни.", 'error_update_user');

                }
                else {
                    showDialog("alert", "Успешно въведохте  данни.", 'error_update_user');
                }
            }, error: function (ev) {

            }
        });
    }
});

$(".datepicker").datepicker({
    dateFormat: "yy-mm-dd",
    yearRange: '1900:2013',
    changeMonth: true,
    changeYear: true
});

$("#edit_first_name, #edit_middle_name,#edit_surname").on("keypress keyup", function (e) {
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
    }
);
//birthday validation
$("#edit_birthday").on("keyup", function (e) {
    var isValidDate = handleDate($(this).val());
    if (e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39 ||e.keyCode == 16||e.keyCode == 35) {
        if (isValidDate) {
            $(this).css("color", "black");
            $(".save").css("background-color", "#d58512");
        }
        return true;
    }
    if (isValidDate) {
        $(".save").css("background-color", "#d58512");
        $(this).css("color", "black");
    }
    else if (!isValidDate) {
        $(this).css("color", "red");
        $(".save").css("background-color", "red");
    }
});

$("#edit_birthday").on("change", function () {
    var isValidDate = handleDate($(this).val());
    if (isValidDate) {
        $(".save").css("background-color", "#d58512");
        $(this).css("color", "black");
    }
    else if (!isValidDate) {
        $(this).css("color", "red");
        showDialog("alert", "Въведете валидна дата /година-месец-ден/ 1996-10-10.", "birthday_bootbox");
        $(".save").css("background-color", "red");
    }
});




