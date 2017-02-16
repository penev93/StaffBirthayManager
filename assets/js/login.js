$("#login_btn").click(function () {
    var username = $("#login_username").val();
    var password = $("#login_password").val();
    var isValid = loginValidator(username, password);
    //display error

    if ((typeof isValid) == "string") {
        showDialog("alert", isValid, "login_alert");
    }
    //run ajax
    else if ((typeof isValid) == "boolean") {
        $.ajax({
            url: HOME_URL,
            type: "POST",
            dataType: "JSON",
            data: {
                requestType: "ajax",
                username: username,
                password: password, action: "login"
            },
            success: function (response) {


                if (response.invalid_user) {
                    //return error
                    showDialog("alert", response.invalid_user, "login_alert");
                }

                else if (response.user_not_found) {
                    //user not found
                    showDialog("alert", "User not found", "login_alert");
                }

                else {

                    window.location.href = HOME_URL;
                    //return correct user and login
                }
            }, error: function (error) {
               
            }
        });
    }


});

function loginValidator(username, password) {
    var errors = [];
    if (username == "" || password == "") {
        return errors['error_no_data'] = "Въведете потребителски данни.";
    }

    //validation for length
    var isLenghtLongUsername = (username.length < 6 || username.length > 13) ? false : true;
    var isLenghtLongPassword = (password.length < 6 || password.length > 13) ? false : true;
    //validation for space
    var pattern = /\s/g;
    var hasSpaceUser = pattern.test(username);
    var hasSpacePass = pattern.test(password);

    if (isLenghtLongPassword && isLenghtLongUsername && !hasSpaceUser && !hasSpacePass) {
        return true;
    }
    else {
        var error_text = "";
        if (isLenghtLongPassword == false || hasSpacePass == true) {
            errors['error_long_pass'] = "Невалидна парола.";
        }
        if (isLenghtLongUsername == false || hasSpaceUser == true) {
            errors['error_long_user'] = "Невалиден потребител.";
        }
        for (var index in errors) {
            error_text += errors[index] + "<br/>";
        }
        return error_text;
    }

}
