$(document).ready(function () {
	toggleDisabled();
	toggleActive();
})

function toggleDisabled(){
	var checker = $("input#program_flexStart"),
			element = $("#program_startDate select");

	var attr = checker.is(':checked');

	if (!attr) {
		element.removeAttr('disabled');
	} else {
		element.attr('disabled', "disabled");
	}
}

function toggleActive(){
	var checker = $("#program_isActive input"),
			inputs = $("select, input[type=text], input[type=number], textarea, input#program_flexStart"),
			flexible = $("input#program_flexStart"),
			dateSelector = $("#program_startDate select");

	var attr = checker.is(':checked');

	if (checker.val() != null && !attr) {
		inputs.attr('readonly', "readonly");
		console.log('disable');

	} else {
		inputs.removeAttr('readonly');
		inputs.removeAttr('readonly');
		if (flexible.is(':checked')){
			dateSelector.attr('disabled', 'disabled')
		}
	}

}

$("#program_startDateFlexible input").click(function () {
	toggleDisabled();
});

$("#program_isActive input").click(function() {
	toggleActive();
});