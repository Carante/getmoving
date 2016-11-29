$(document).ready(function () {
	if (!$("#program_startDateFlexible input[type=checkbox]").attr("checked")) {
		$("#program_startDate select").removeAttr('disabled');
	} else {
		$("#program_startDate select").attr('disabled', "disabled");
	}
})

function toggleDisabled(){
	var element = $("#program_startDate select");
	attr = element.attr('disabled')

	if (attr) {
		element.removeAttr('disabled');
	} else {
		element.attr('disabled', "disabled");
	}
}

$("#program_startDateFlexible input").click(function () {
	toggleDisabled();
});