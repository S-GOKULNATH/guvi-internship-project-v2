$(document).ready(function () {

    let username = localStorage.getItem("username");
    let userId = localStorage.getItem("user_id");
    let sessionToken = localStorage.getItem("session_token");

    $.ajax({
        url: "php/get_profile.php",
        type: "GET",
        data: {
            user_id: userId,
            session_token: sessionToken
        },
        dataType: "json",

        success: function (res) {

           if (res.status === "success") {

                $("#dob").val(res.data.dob);
                $("#age").val(res.data.age);
                $("#contact").val(res.data.contact);

            }

        }
    });

    if (!userId || !sessionToken) {
         window.location.href = "login.html";
         return;
    }

    $("#welcomeText").text("Welcome, " + username);

    $("#profileForm").submit(function (e) {

        e.preventDefault();

        $.ajax({
            url: "php/profile.php",
            type: "POST",
            data: {
               user_id: userId,
               session_token: sessionToken,
               dob: $("#dob").val(),
               contact: $("#contact").val()
            },
            success: function (response) {

                let result = JSON.parse(response);

                if (result.status === "success") {

                    $("#message").html(
                        "<span class='text-success'>" +
                        result.message +
                        "</span>"
                    );

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
    $("#dob").change(function () {

        let dob = new Date($(this).val());
        let today = new Date();

        let age = today.getFullYear() - dob.getFullYear();

        let monthDiff = today.getMonth() - dob.getMonth();

        if (
            monthDiff < 0 ||
            (monthDiff === 0 && today.getDate() < dob.getDate())
        ) {
            age--;
        }

        $("#age").val(age);

    });

   $("#logoutBtn").click(function () {

        $.ajax({
            url: "php/logout.php",
            type: "POST",
            data: {
                session_token: localStorage.getItem("session_token")
            },
            success: function () {

                localStorage.removeItem("user_id");
                localStorage.removeItem("username");
                localStorage.removeItem("session_token");

                window.location.href = "login.html";
            }
        });

    });

});