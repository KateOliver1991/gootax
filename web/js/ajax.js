setInterval(function () {

    $.ajax({
        type: "GET",
        url: base + "/city/check-session",
        dataType: "json",
        success: function (data) {
            console.log(data);

        },
        error: function (error) {
            console.log(error.status);
        }
    });
}, 4000);
