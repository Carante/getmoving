$(document).ready(function() {
	console.log("ready");


	$('.datepicker.birthday').datepicker({
		minDate: "-70Y",
		maxDate: "-16Y",
		changeMonth: true,
		changeYear: true,
		yearRange: "-70:-16",
		format: 'yyyy-mm-dd'
	});
	$('.datepicker').datepicker({
		minDate: "+2M",
		maxDate: "+1Y +6M",
		changeMonth: true,
		changeYear: true,
		format: 'yyyy-mm-dd'
	});

})