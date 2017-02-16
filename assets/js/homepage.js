$("[name='my-checkbox']").bootstrapSwitch();

$(document).ready(function () {
    if ($(".ShownModal").val() == 'true') {
        alert($(".ShownModal").val());
    }
});

//toggle progress bar
$(".hidden-statistics").mouseover(function (ev) {

    $(this).children(".hidden-procent").show();
    $(this).children(".progress").hide();

}).mouseleave(function (ev) {
    $(this).children(".progress").show();
    $(this).children(".hidden-procent").hide();
});

//destroy session
$("#logout").click(function () {
    $.ajax({
        url: HOME_URL,
        type: "POST",
        data: {
            requestType: "ajax",
            action: "destroy_session"
        },
        success: function (result) {
            window.location.href = HOME_URL;
        }
    });
});


//Save Updated user

$(".homepage-dropdown-li").click(function (ev) {
    var selectedYear = $(this).html();
    var existingYear = $(this).data('year_exists');

    if (existingYear == false) {

        showDialog("dialog", "Не съществуват записи за " + selectedYear + ". Желаете ли да създадете нови.<div style='text-align:center'><input type='button' class='confirm_new_birthday_data btn btn-danger' value='Да'/><input type='button' class='unconfirm_new_birthday_data btn btn-success' value='Не'/></div>", "generateNewBirthdayData");
        $(".unconfirm_new_birthday_data").click(function () {
            $(".generateNewBirthdayData").modal('hide');
        });

        $(".confirm_new_birthday_data").click(function () {

            $.ajax({
                url: HOME_URL,
                type: "POST",
                dataType: "JSON",
                data: {
                    requestType: "ajax",
                    action: "add_new_gift_connection",
                    year: selectedYear
                }, success: function (response) {
                    window.location.href = HOME_URL + "Homepage/" + selectedYear + "/";
                },
                error: function (error) {
                  
                }
            });

            $(".generateNewBirthdayData").modal('hide');
            /*$.ajax(*/
        });

    }
    else if (existingYear == true) {
        window.location.href = HOME_URL + "Homepage/" + selectedYear + "/";
    }

});


//delete user
$(".delete").on("click", function () {
    var first_name = $(this).closest("tr").children()[0].innerHTML;
    var middle_name = $(this).closest("tr").children()[1].innerHTML;
    var surname = $(this).closest("tr").children()[2].innerHTML;
    var birthdate = $(this).closest("tr").children()[3].innerHTML;

    var userId = $(this).parent().parent().children().first().children().first().val();

    showDialog("dialog", "Искате ли да изтриете " + first_name + " " + middle_name + " " + surname + "  с рожденна дата : " + birthdate + " ." +
        "<div><button class='btn  btn-danger confirm_delete' value='yes'>Да</button><button data-dismiss='modal' data-backdrop='false' class='btn confirm_no_delete btn-success'" +
        " value='no'>Не</button></div>"
        , "delete_confirm_dialog");

    $(".confirm_delete").click(function () {

        $.ajax({
            url: HOME_URL,
            type: "POST",
            dataType: "JSON",
            data: {
                requestType: "ajax",
                action: "delete_user",
                user_id: userId
            }, success: function (response) {
                if (response == "Невалидно идентификационнен номер.") {
                    showDialog("alert", "Невалидно идентификационнен номер.", "invalid_delete_user_id");
                }
                else {
                    location.reload();
                }
            }
        });

    });
});

$(".export").click(function () {
    var first_name = $(this).parent().parent().siblings("td")[0].innerHTML;

    var middle_name = $(this).parent().parent().siblings("td")[1].innerHTML;
    ;
    var surname = $(this).parent().parent().siblings("td")[2].innerHTML;

    var names = first_name + " " + middle_name + " " + surname;
    window.open(HOME_URL + "?action=download&download_id=" + $(this).data('export_id') + "&names=" + names, '_blank');

});

function handleCyrilicName(data) {
    var cyrilic_patt = /^([а-яА-Я]{0,32})$/g;
    var isCyrilic = cyrilic_patt.test(data);
    //return true and false
    return isCyrilic;
}


function handleDate(data) {
    var birthday_patt = /^([0-9]{4})-([0-9]{2})-([0-9]{2})$/g;
    var isBirthday = birthday_patt.test(data);
    //return true and false
    return isBirthday;
}

