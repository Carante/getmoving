$(document).ready(function () {
	toggleDisabled();
	toggleActive();
	squareImgAdjustment();
	$(".dataTable").DataTable();

	$(".btn-user-delete").mouseover(function() {
		$(this).addClass("color--purple");
	});
	$(".btn-user-delete").mouseleave(function() {
		$(this).removeClass("color--purple");
	})

	$(".coreValueRow").each(function (){
		$(this).attr("data-visible") == "true" ? false : $(this).hide();
	});

});

$(window).resize(function() {
	squareImgAdjustment();
});




function toggleDisabled() {
	var checker = $("input#program_flexStart"),
		element = $("#program_startDate select");

	var attr = checker.is(':checked');

	if (!attr) {
		element.removeAttr('disabled');
	} else {
		element.attr('disabled', "disabled");
	}
}

function toggleActive() {
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
		if (flexible.is(':checked')) {
			dateSelector.attr('disabled', 'disabled')
		}
	}
}


function squareImgAdjustment(){
	var parent = $('.squareImg-placeholder'),
			child = $(".squareImg-placeholder img");

	var paW = parent.width();

	parent.height(paW);

	var chH = child.height(),
			chW = child.width();

	chW >= chH ? child.height(paW) : child.width(paW) ;
}

function coreValueFieldAdjustment(target) {
	var coreValCount = 0;
	$(".coreValueRow").each(function () {
		if ($(this).attr("data-visible") == "true") {
			++coreValCount;
		}
	});

	console.log(coreValCount);

	if (target.hasClass("remove")) {
		if (coreValCount != 1) {
			var targetRow = $(".coreValueRow[data-num="+coreValCount+"]");
			var kids = $(".coreValueRow[data-num="+coreValCount+"] :input");

			targetRow.hide().attr("data-visible", "false");
			kids.val("");
			$(".iconPreview[data-target="+coreValCount+"] i").attr("class", "");
			if (coreValCount == 2) {
				target.addClass("color--gray");
			}
			if (coreValCount == 5) {
				$(".core-value-fields-adjust.add").removeClass("color--gray");
			}
		}
	}

	if (target.hasClass("add")) {
		if (coreValCount != 5) {
			++coreValCount;

			var targetRow = $(".coreValueRow[data-num="+coreValCount+"]");

			targetRow.show().attr("data-visible", "true");
			if (coreValCount == 5) {
				target.addClass("color--gray");
			}
			if (coreValCount == 2) {
				$(".core-value-fields-adjust.remove").removeClass("color--gray");
			}
		}
	}
}



$(".core-value-fields-adjust").click(function (){
	var target = $(this);
	coreValueFieldAdjustment(target);
});

$(".iconSelector").change(function () {
	var target = $(this).attr("data-target"),
			value = $(this).val(),
			preview = $(".iconPreview[data-target="+target+"] i");

	console.log("changed");
	console.log(target);
	console.log(value);

	preview.removeAttr("class");
	preview.attr("class", "fa "+value);
});


$("#program_startDateFlexible input").click(function () {
	toggleDisabled();
});

$("#program_isActive input").click(function () {
	toggleActive();
});

$(".documents-save").click(function () {
	var targetId = $(this).attr('data-target'),
			userId = $(this).attr('data-user'),
			programId = $(this).attr('data-program');

	// var passportURI = $("#document_passport_"+targetId).val(),
	// 	  criminalRecordURI = $("#document_criminalRecord_"+targetId).val(),
	//   	ticketURI = $("#document_ticket_"+targetId).val();
	//
	// var passportArray = passportURI.split("\\"),
	// 		passport = passportArray[passportArray.length-1];
	// var criminalRecordArray = criminalRecordURI.split("\\"),
	//   	criminalRecord = criminalRecordArray[passportArray.length-1];
	// var ticketArray = ticketURI.split("\\"),
	// 	  ticket = ticketArray[passportArray.length-1];

	var passport = $("#document_passport_"+targetId);
	// 	  criminalRecord = $("#document_criminalRecord_"+targetId),
	// 	  ticket = $("#document_ticket_"+targetId);

	var formData = new FormData($("#upload_"+targetId));

	// xhr
	var http = new XMLHttpRequest();
	var url = '/admin/participation/documents/'+targetId+'/'+userId+'/'+targetId;
	var file_data = formData;
	http.open("POST", url, true);

// headers
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", file_data.length);
	http.setRequestHeader("Connection", "close");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			alert(http.responseText);
		}
	}

	http.send(file_data);


	// $.ajax
	// ({
	// 	url: '/admin/participation/documents/'+targetId+'/'+userId+'/'+targetId,
	// 	type: "POST",
	// 	data:   formData,
	// 	mimeType: "multipart/form-data",
	// 	contentType: false,
	// 	cache: false,
	// 	processData: false
	// }).done(function (response) {
	// });



	// console.log("ParticionID: "+targetId);
	// console.log("UserID: "+userId);
	// console.log("ProgramID: "+programId);
	// console.log("Passport: "+passport.files);
	// console.log("Criminal Record: "+criminalRecord.files);
	// console.log("Return ticket: "+ticket.files);

	// swal({
	// 	title: "Update particion",
	// 	text: "Are you sure you want to update this volunteers participation?",
	// 	type: "info",
	// 	showCancelButton: true,
	// 	confirmButtonColor: "#1B9061",
	// 	confirmButtonText: "Yes, update!",
	// 	showLoaderOnConfirm: true,
	// 	onClose: function () {
	// 		var location = "/admin/participation/"+targetId+"/"+userId+"/"+programId+"?function=docs&passport="+passport+"&criminalRecord="+criminalRecord+"&ticket="+ticket;
	// 		console.log(location);
	// 		window.location.href = location;
	// 	}
	// });
});


$(".particion-save").click(function () {
	var targetId = $(this).attr('data-target'),
		userId = $(this).attr('data-user'),
		programId = $(this).attr('data-program');

	var newArrival = $("input[name=arrivalDate][data-target="+targetId+"]").val(),
		newDuration = $("select[name=duration][data-target="+targetId+"]").val();

	console.log(targetId);
	console.log(userId);
	console.log(programId);
	console.log(newArrival);
	console.log(newDuration);

	swal({
		title: "Update particion",
		text: "Are you sure you want to update this volunteers participation?",
		type: "info",
		showCancelButton: true,
		confirmButtonColor: "#1B9061",
		confirmButtonText: "Yes, update!",
		showLoaderOnConfirm: true,
		onClose: function () {
			var location = "/admin/participation/"+targetId+"/"+userId+"/"+programId+"?arrival="+newArrival+"&duration="+newDuration;
			console.log(location);
			window.location.href = location;
		}
	});
});


// Modal link with ALL media library
$(".mediaLibraryModalTrigger").click(function () {
	var curMediaOneId = $("input[name=mediaOne-choosable]:checked").val(),
		mediaGalleryId = [];

	$('input[name="program_media[]"]').each(function (i) {
		if ($(this).is(":checked")) {
			mediaGalleryId.push($(this).val());
		}
	});

	localStorage.curMediaOneId = curMediaOneId;
	localStorage.mediaGalleryId = mediaGalleryId;

	var target = $(this).attr('data-entity');
	$(".modal-body").hide();
	$(".modal-body." + target).show();

});
$(".mediaOneModal-close").click(function () {
	var curMediaOneId = localStorage.curMediaOneId,
		mediaGalleryId = localStorage.mediaGalleryId.split(",");

	$("input[data-target=mediaOne" + curMediaOneId + "]").prop("checked", true);

	$('input[name="program_media[]"]').prop("checked", false);
	$.each(mediaGalleryId, function(i) {
		$("input[data-target=mediaGallery" + mediaGalleryId[i] + "]").prop("checked", true);
	});
});
$(".mediaOneModal-save").click(function () {
	var newMediaOneId = $("input[name=mediaOne-choosable]:checked").val(),
		newMediaOnePath = $("label[for=mediaOne" + newMediaOneId + "]").attr("data-img");
	$(".file-preview-thumbnails.gallery").html("");
	$('input[name="program_media[]"]').each(function (i) {
		if ($(this).is(":checked")) {
			$(".file-preview-thumbnails.gallery").append("<div class='file-default-preview col-md-15 text-center' tabindex='-1' style='height: 150px'><img alt='preview' style='max-width: 160px;max-height:100%' src='" + $(this).attr("data-img") + "'></div>");
		}
	});

	localStorage.curMediaOneId = newMediaOneId;
	$(".file-default-preview.feature img").attr("src", newMediaOnePath);
	$(".file-default-preview.logo img").attr("src", newMediaOnePath);
});


// Delete single media from library
$(".mediaModal-delete").click(function () {
	var target = $(this).attr('data-mediaTarget');
	swal({
		title: "Delete media",
		text: "Are you sure you want to delete this media? If yes, then all saved data will be lost.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes, delete media!",
		showLoaderOnConfirm: true,
		onClose: function () {
			var location = "/admin/media/delete/"+target;
			console.log(location);
			window.location.href = location;
		}
	});
});


$(".btn-user-delete").click(function () {
	var targetId = $(this).attr('data-target'),
			d = new Date(),
			M = d.getMonth()+1,
			Y = d.getFullYear(),
			D = d.getDate();

	// console.log(targetId);
	// console.log(d);
	// console.log(Y);
	// console.log(M);
	// console.log(D);

	swal({
		title: "Delete user?",
		text: "Are you sure you want to delete this user? If yes the changes can not be undone.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#1B9061",
		confirmButtonText: "Yes, delete user!",
		showLoaderOnConfirm: true,
		onClose: function () {
			var location = "/admin/user/delete/"+targetId+"/"+Y+"/"+M+"/"+D;
			console.log(location);
			window.location.href = location;
		}
	});
});
