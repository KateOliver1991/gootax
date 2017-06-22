$("#add_recall").click(function () {
    event.preventDefault();

    $("form input").val("");

    $("#form_hide").show();


});


$(".edit_recall").click(function () {
    event.preventDefault();

    $("#form_hide").show();

    $("#recalls-city").val($(this).data("city"));

    $("#recalls-title").val($(this).data("title"));

    $("#recalls-text").val($(this).data("text"));

    $("#recalls-rating").val($(this).data("rating"));

    $("#recalls-img").val($(this).data("img"));


});
	
	
	