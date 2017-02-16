
$(".edit-admin").each(function (index) {
    $(this).click(function (ev) {
        var addClass = "";

        $(this).siblings(".save-admin").show();
        $(this).hide();

        var userData = $(this).parent().parent().find("td");
        userData.each(function (key, value) {

            switch (key) {

                case 0:
                    addClass = "validate_username";
                    break;
                case 1:
                    addClass = "validate_password";

                    break;
                case 2:
                    addClass = "validate_first_name";
                    break;
            }

            if (key == 3) {
                return true;
            }
            else {
                value.innerHTML = "<td><input size='13' class='" + addClass + "'  type='text' value='" + value.innerHTML + "'/></td>";
            }

            $(".validate_username").on("keyup keyup", function (ev) {
                var isUsername = handleUsernameAndPassword($(this).val());
                if (!isUsername) {

                    $(".save").css("background-color", "#d58512");
                    $(".save").attr("data-is_true", "false");
                    $(this).css("color", "red");
                }
                else {
                    $(".save").css("background-color", "#f0ad4e");
                    $(".save").attr("data-is_true", "true");
                    $(this).css("color", "black");
                }
            });


            $(".validate_password").on('keyup', function () {
                var isPassword = handleUsernameAndPassword($(this).val());
                if (!isPassword) {
                    $(".save").css("background-color", "#d58512");
                    $(".save").attr("data-is_true", "false");
                    $(this).css("color", "red");
                }
                else {
                    $(".save").css("background-color", "#f0ad4e");
                    $(".save").attr("data-is_true", "true");
                    $(this).css("color", "black");
                }
            });

            $(".validate_first_name").on("keyup keypress", function (e) {
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


        });
    });
});



$(".save-admin").each(function (index) {
    $(this).click(function (ev) {
        var save_admin_btn=$(this);
        var usersData=$(this).parent().parent().find("td");

        var username = $(this).parent().parent().find("td > .validate_username").val();
        var password=$(this).parent().parent().find("td > .validate_password").val();
        var first_name=$(this).parent().parent().find("td > .validate_first_name").val();


        /*.validate_password*/
        var isUsername = handleUsernameAndPassword(username);
        var isNameCyrilic = handleCyrilicName(first_name);
        var isPassword = handleUsernameAndPassword(password);
        if((!isPassword && password!="" )|| (!isNameCyrilic || first_name=="" ) || (!isUsername || username==""))
        {

            showDialog("dialog", (isPassword==false && password!=""?'Паролата трябва да бъде между 6 и 13 символа като може да съдържа цифри букви и специални символи.<br/>':'')+""+(isNameCyrilic==false?'Невалидно име.<br/>':'')+(isUsername==false?'Невалидно потребителско име.<br/>':'')+"<div><input type='button'  class=' close_admin_password_dialog btn btn-success' value='Затвори'/></div>", 'admin_password_alert');
            $('.bootbox-close-button').hide();
            $('.validate_password').focus(true);
            $(".close_admin_password_dialog").click(function () {
                $('.admin_password_alert').modal("hide");
            });
            return false;
        }
        if (isUsername && isNameCyrilic && (isPassword  || password=="")) {
            //update
           var admin_id=$(this).data('admin_id');

            $.ajax({
                url: HOME_URL,
                type: "POST",
                dataType: 'JSON',
                data: {
                    requestType: "ajax",
                    action: "update_admin",
                    admin_id: admin_id,
                    username:username,
                    password:password,
                    first_name:first_name
                },
                success: function (response) {
                    if(response==1){
                        showDialog("alert", "Честито променихте администратора.", "update_admin");

                    }
                    else {
                        showDialog("alert", "Грешни данни или невъведени данни.", "update_admin");
                    }
                    usersData.each(function(index){
                        if(index<3)
                        {
                            var newValue = $(this).children().closest("input")[0].value;
                            $(this).html(newValue);
                        }
                        else{
                            save_admin_btn.siblings(".edit-admin").show();
                            save_admin_btn.hide();
                        }
                    });
                }
            });
        }



        /*final round*/
        /*$(this).attr('type','hidden');
         $(this).siblings(".edit-admin").show();*/
    });
});


/*
 ^[\w]*$*/

function handleUsernameAndPassword(data) {
    var username_patt = /^([\w\d!@#$%^&*?]{6,14})$/g;
    var isUsername = username_patt.test(data);

    //return true and false
    //true if its valid
    return isUsername;
}
