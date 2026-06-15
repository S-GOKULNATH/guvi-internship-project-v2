$(document).ready(function () {

    $("#registerForm").submit(function (e) {

        e.preventDefault();

        $.ajax({
            url: "php/register.php",
            type: "POST",
            data: {
                username: $("#username").val(),
                email: $("#email").val(),
                password: $("#password").val()
            },
            success: function (response) {

                let result = JSON.parse(response);

                if (result.status === "success") {

                    $("#message").html(
                        "<span class='text-success'>" +
                        result.message +
                        "</span>"
                    );

                    $("#registerForm")[0].reset();

                    setTimeout(function () {
                        window.location.href = "login.html";
                    }, 1500);

                } else {

                    $("#message").html(
                        "<span class='text-danger'>" +
                        result.message +
                        "</span>"
                    );
                }
            }
        });

    });

});