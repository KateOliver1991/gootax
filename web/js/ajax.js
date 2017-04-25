

setInterval(function() {

    $.ajax({
        type: "GET",
        url: "/gootax/web/city/check-session",
        data: {},
        async: true,
        dataType: "json",
        success: function (data) {


            if (data) {

                location.reload();

            }


        },
        error: function (error) {
            console.log(error.status);
        }
    });
}, 4000);

