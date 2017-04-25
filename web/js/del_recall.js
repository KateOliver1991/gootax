

 $(".del_recall").click(function () {
	 
	 event.preventDefault();
	 
	var id = $(this).data("id");
	 
	$.ajax({
		
		url: "del-recall",
		
		data: {"id":id},
		
		success: function(data){
			if(data){
				location.reload();
			}
		}
		
	});
	
});
