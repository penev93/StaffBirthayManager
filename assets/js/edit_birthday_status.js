$("#save_birthday_action").click(function (ev) {
    $("#sum_birthday_gift").val("");
    $(".avarage_birthday_sum").text("");
    if ($("#save_birthday_action").val() == "true") {
        $("#save_birthday_action").text("Запази длъжници");
        $("#save_birthday_action").val("false");
        $(".field_set_save_sum").css("display", "none");
        $("input[name='my-checkbox']").bootstrapSwitch('disabled', false);
    }
    else {
        $("input[name='my-checkbox']").bootstrapSwitch('disabled', true);
        $("#save_birthday_action").text("Редактирай длъжници");
        $("#save_birthday_action").val("true");
        $(".field_set_save_sum").css("display", "block");
    }
});

$("#sum_birthday_gift").keyup(function () {
    /*^[0-9]*$*/
    $active_user_counter = 0;
    var isDigit = handleDigit($(this).val());
    if (isDigit) {
        $("input[name='my-checkbox']").each(function () {
            if ($(this).is(":checked")) {
                ++$active_user_counter;
            }

        });
        if ($active_user_counter == 0) {
            var price_per_person = 0;
        }
        else {
            var price_per_person = $(this).val() / $active_user_counter;
        }

        $(".avarage_birthday_sum").css({'color': 'red', 'font-weight': "bold"});
        $(".avarage_birthday_sum").text(price_per_person.toFixed(2) + " лв");

    }
    else {
        showDialog("alert", "Въведете само стойности", "validation_sum_digits");
    }

});

$(".addNote").click(function (ev) {
    var user_id_from = $(this).parent().siblings().find("[data-user_id]").data('user_id');
    var gift_id = $(".field_set_save_sum").data("gift_id");
    $.ajax({
        url: HOME_URL,
        type: "POST",
        data: {
            requestType: 'ajax',
            action: 'get_note',
            user_from: user_id_from,
            gift_id: gift_id
        },
        dataType: "JSON",
        success: function (response) {
            showDialog("dialog", "<div class='form-group'>" +
                "<label for='comment'>Comment:</label>" +
                "<textarea class='form-control' rows='5' id='note_comment'>" + ((response.note == null) ? "" : response.note) + "</textarea>" +
                "</div><input type='button' class='confirm_payment_note btn btn-danger' value='Добави бележка'/><input type='button'" + "class='unconfirm_payment_note btn btn-success' value='Не добавяй'/></div>", "note_payment");

            $(".unconfirm_payment_note").click(function () {
                $(".note_payment").modal("hide");
            });

            //send new payment note
            $(".confirm_payment_note").click(function () {

                var note = $('textarea#note_comment').val();

                $.ajax({
                    url: HOME_URL,
                    type: "POST",
                    data: {
                        requestType: 'ajax',
                        action: 'add_note',
                        note: note,
                        user_from: user_id_from,
                        gift_id: gift_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $(".unconfirm_payment_note").click(function () {
                            $(".note_payment").modal("hide");

                        });
                        $(".note_payment").modal("hide");
                        location.reload();
                    },
                    error: function (error) {

                    }
                });
            });

        },
        error: function (error) {

        }
    });

});


$("#save_sum_birthday_gift").click(function () {
    if ($("#sum_birthday_gift").val() == "") {
        showDialog("alert", "Моля, въведете всички данни", 'sum_birthday_gift_error');
        return false;
    }
    var users_ids_is_active = [];
    var gift_id = $(".field_set_save_sum").data("gift_id");
    showDialog("dialog", "Искате ли да запазите текущите данни<div style='text-align:center'><input type='button' class='confirm_lock_birthday btn btn-danger' value='Да'/><input type='button' class='unconfirm_lock_birthday btn btn-success' value='Не'/></div>", "lockBirthdayModal");

    $(".unconfirm_lock_birthday").click(function () {
        $(".lockBirthdayModal").modal("hide");
    });

    //TODO


    $(".confirm_lock_birthday ").click(function () {
        var user;
        /*add active and not active users*/
        $("input[name='my-checkbox']").each(function (index) {
            var state_is_active = $(this).bootstrapSwitch('state');
            user = $(this).closest("tr").children().last('td');
            var user_from_id = user.find('input').data("user_id");
            //Users id from
            users_ids_is_active.push({"id": user_from_id, "is_active": state_is_active});

        });

        var price = $(".avarage_birthday_sum").html();
        price = price.split(" ")[0];


        /*  if (!handleDigit($("#sum_birthday_gift").val())) {
         showDialog("alert", "Въведете само стойности", "validation_sum_digits");
         return false;
         }
         else {*/
        $.ajax({
            url: HOME_URL,
            type: "POST",
            data: {
                requestType: 'ajax',
                action: 'lock_birthday',
                price: price,
                gift_id: gift_id,
                users_id_is_active: users_ids_is_active,
            },
            dataType: "JSON",
            success: function (response) {

                if (handleDigit(response)) {
                    location.reload();
                }
                else {
                    showDialog("alert", response.error, "error");

                }

            },
            error: function (error) {

            }
        });
        /* }*/
    });

});

$(".update_gift_status").click(function (ev) {
    var btn = $(ev.target);
    var user_from_id = $(this).prev().data('user_id');
    var gift_id = $(".field_set_save_sum").data("gift_id");
    var result = 0;
    var payment = btn.parent().siblings(".payment_checkbox").children("input").prop("checked");
    payment = (payment == true) ? 1 : 0;


    $.ajax({
        url: HOME_URL,
        type: "POST",
        data: {
            requestType: 'ajax',
            action: 'insert_payment',
            is_paid: payment,
            user_from_id: user_from_id,
            gift_id: gift_id
        },
        dataType: "JSON",
        success: function (response) {
            if (response == "1") {
                /*payment is available*/
               
                if (payment == "0") {
                    btn.parent().siblings(".payment_checkbox").children("input").prop("checked", false);
                }
                else {
                    btn.parent().siblings(".payment_checkbox").children("input").prop("checked", true);
                }

                showDialog("alert", "Промяната е направена.", 'birthday_gift_alert');
                // change checkbox status checked and include onclick
            }
        },
        error: function (error) {

        }
    });

});


function handleDigit(data) {
    var digit_patt = /^[0-9]*$/g;
    var isDigit = digit_patt.test(data);
//return true and false
    return isDigit;
}