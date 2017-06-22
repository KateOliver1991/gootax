


$("#recalls-city").click(function () {
    event.preventDefault();
    $.ajax({
        type: "GET",
        url: "/gootax/web/city/load-cities",
        dataType: "json",
        success: function (data) {
            if(data) {



            }

        },

    });

});