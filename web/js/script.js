$(document).ready(function() {
	console.log("ready");
	sliderHeightAdjust();

	programListHeight();


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
});

$(window).resize(function(){
	sliderHeightAdjust();
	programListHeight();
});

$(".step-change").click(function(){
	var step = $(this).attr("data-step");
	step == 6 ? printInfo() : false ;
	changeStep(step);
})

function sliderHeightAdjust(){
	var paH = $("#media-slider").height(),
			paW = $("#media-slider").width();

	$(".slider-mediaOne img").each(function(){
		var elH = $(this).height(),
				elW = $(this).width();

		var offsetY = (paH - elH) / 2,
				offsetX = (paW - elW) / 2;

		$(this).css({'margin-top':offsetY, 'margin-left':offsetX});
	})
}

function changeStep(step){
	console.log(step);
	$(".step-wrap").fadeOut();
	setTimeout(function(){
		$("#register_step_"+step).fadeIn();
	}, 500);
}

function printInfo(){
	console.log("print info");
	var prefix = "#user_registration_form_",
			postfix = "Confirm";

	var firstName = $(prefix+"firstName").val(),
			middleName = $(prefix+"middleName").val(),
			lastName = $(prefix+"lastName").val(),
			sex = $("input[name='user_registration_form[sex]']:checked").val(),
			yearOfBirth = $(prefix+"dateOfBirth_year").val(),
			monthOfBirth = $(prefix+"dateOfBirth_month").val(),
			dayOfBirth = $(prefix+"dateOfBirth_day").val(),
			nationality = $(prefix+"nationality").val(),
			email = $(prefix+"email").val(),
			phone = $(prefix+"phone").val(),
			arrivalYear = $(prefix+"arrivalDate_year").val(),
			arrivalMonth = $(prefix+"arrivalDate_month").val(),
			arrivalDay = $(prefix+"arrivalDate_day").val(),
			programDuration = $(prefix+"duration").val(),
			addressCountry = $(prefix+"addressCountry").val(),
			addressRegion = $(prefix+"addressRegion").val(),
			addressZip = $(prefix+"addressZip").val(),
			addressCity = $(prefix+"addressCity").val(),
			addressPoBox = $(prefix+"addressPoBox").val(),
			addressStreet = $(prefix+"addressStreet").val(),
			addressHouseno = $(prefix+"addressHouseNo").val(),
			addressCo = $(prefix+"addressCo").val(),
			eduExpectedLevel = $(prefix+"eduLevelExpected").val(),
			eduCurrentPlace = $(prefix+"eduCurrentPlace").val(),
			eduCurrentProgram = $(prefix+"eduCurrentProgram").val(),
			eduFuturePlace = $(prefix+"eduFuturePlace").val(),
			eduFutureProgram = $(prefix+"eduFutureProgram").val();


	$("#name"+postfix).html(firstName+" "+middleName+" "+lastName);
	$("#gender"+postfix).html(sex);
	$("#dob"+postfix).html(yearOfBirth+"-"+monthOfBirth+"-"+dayOfBirth);
	$("#nationality"+postfix).html(nationality);
	$("#email"+postfix).html(email);
	$("#phone"+postfix).html(phone);
	$("#arrival"+postfix).html(arrivalYear+"-"+arrivalMonth+"-"+arrivalDay);
	$("#duration"+postfix).html(programDuration+" weeks");
	$("#country"+postfix).html(addressCountry);
	$("#region"+postfix).html(addressRegion);
	$("#city"+postfix).html(addressCity);
	$("#zip"+postfix).html(addressZip);
	$("#street"+postfix).html(addressStreet);
	$("#pobox"+postfix).html(addressPoBox);
	$("#houseno"+postfix).html(addressHouseno);
	$("#co"+postfix).html(addressCo);
	$("#edulevel"+postfix).html(eduExpectedLevel);
	$("#curplace"+postfix).html(eduCurrentPlace);
	$("#curprogram"+postfix).html(eduCurrentProgram);
	$("#futplace"+postfix).html(eduFuturePlace);
	$("#futprogram"+postfix).html(eduFutureProgram);
}


function programListHeight() {
	var listHeight = $(".program-list").height(),
			prevHeight = $(".programs-list-intro").height(),
			newHeight = prevHeight + listHeight;

	$(".programs-container").height(newHeight);
}
