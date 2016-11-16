$(document).ready(function() {
	console.log("ready");
	$("#GM-loginTrigger").click(function () {
		$("#GM-loginBox").slideToggle();
	});

	$("#GM-userLogin").click(function () {
		var email = $("#GM-user").val(),
				password = $("#GM-password").val();

		$.ajax("../ajax/ajax.php", {
			data: {
				"function":"login",
				"email":email,
				"password":password
			},
			method: "get",
			dataType: 'json'
		}).done(function(response){
				swal({
					title: response.title,
					text: response.message,
					type: response.type
				});
		}).fail(function(response){
			swal({
				title: "Ooops...!",
				text: "There was a technical error. Please try again later.",
				type: "error"
			});
		});
	});

})