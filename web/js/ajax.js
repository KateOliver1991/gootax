			$.ajax({
                type: "GET",
                url: "/gootax/web/city/",
                data: {},
                dataType: "json",
                success: function (data) {


                    if (data) {

                        location.reload();

                    } else {

                    }


                },
                error: function (error) {
                    console.log(error.status);
                }
            });
