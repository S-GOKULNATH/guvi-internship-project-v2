$(document).ready(function () {

    $("#loginForm").submit(function (e) {

        e.preventDefault();

        $.ajax({
            url: "php/login.php",
            type: "POST",
            data: {
                email: $("#email").val(),
                password: $("#password").val()
            },
            success: function (response) {

                let result = JSON.parse(response);

                if (result.status === "success") {

                   localStorage.setItem("user_id", result.user_id);
                   localStorage.setItem("username", result.username);
                   localStorage.setItem("session_token", result.session_token);

                    $("#message").html(
                        "<span class='text-success'>" +
                        result.message +
                        "</span>"
                    );

                    setTimeout(function () {
                        window.location.href = "profile.html";
                    }, 1000);

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