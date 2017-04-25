


    $("#no_city").click(function () {
        event.preventDefault();
        $.ajax({
            type: "GET",
            url: "/gootax/web/city/load-cities",
            data: {},

            dataType: "json",
            success: function (data) {
                if(data) {

                    $("select option").empty();
                    for(var i=0;i<3;i++) {
                        var i2 = i+1;
                        $("select option:nth-child("+i2+")").html(data.cities[i]);
                    }

                }

            },

        });

    });

