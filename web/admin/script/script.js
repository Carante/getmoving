$(document).ready(function () {
	toggleDisabled();
	toggleActive();
	$(".dataTable").DataTable();
})

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

$("#program_startDateFlexible input").click(function () {
	toggleDisabled();
});

$("#program_isActive input").click(function () {
	toggleActive();
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
	console.log("SWAL triggered");
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