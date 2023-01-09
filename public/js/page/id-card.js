$(document).ready(function() {
	// if (isCard) {
	// 	$('#dob').datepicker({
	//         format: "mm/dd/yyyy",
	//         autoclose: true,
	//         todayHighlight: true,
	//     });
	// }

	// var element = $('.body-main-div');
	if (isPrint) {
		// window.print();
	}

	// html2canvas(element, {
    //     onrendered: function(canvas) {
    //         var imgData = canvas.toDataURL('image/jpeg');
    //         // $('#print-v-card').hide();
    //         // $('.append_canvas').attr('src', imgData);
    //         // $('.append_canvas').show();
    //         // window.print();
    //         $('.body-main-div').html('<img src="'+imgData+'">');
    //     }
    // });

	var container = document.getElementById("body-main-div");
    html2canvas(container, { allowTaint: true,backgroundColor:null }).then(function (canvas) {
        var dataURL = canvas.toDataURL();
        $('#body-main-div').html('<img src="'+dataURL+'">');
        setTimeout(function () {
        	window.print();
        }, 1000);
    });

	function card_type_change() {
		var card_type = $('input[name="card_type"]:checked').val();

		if (card_type == 1) {
			$('.disable_for_student').attr('disabled', true);
			$('.disable_for_teacher').attr('disabled', false);

			$('.hide_for_student').hide();
			$('.hide_for_teacher').show();

			$('.dp_teacher').hide();
			$('.dp_student').show();
		} else {
			$('.disable_for_student').attr('disabled', false);
			$('.disable_for_teacher').attr('disabled', true);

			$('.hide_for_student').show();
			$('.hide_for_teacher').hide();

			$('.dp_teacher').show();
			$('.dp_student').hide();
		}
	}

	// function color_type_change() {
	// 	var card_color = $('input[name="card_color"]:checked').val();

	// 	if (card_color == 1) {
	// 		$('.v-card').css('background', '#1e541c');
	// 	} else {
	// 		$('.v-card').css('background', '#40a3a3');
	// 	}
	// }

	card_type_change();
	// color_type_change();

	$('input[type=radio][name=card_type]').change(function() {
		card_type_change();
	});

	// $('input[type=radio][name=card_color]').change(function() {
	// 	color_type_change();
	// });

	$('#phone_number').keydown(function (e) {
       	var key = e.charCode || e.keyCode || 0;
       	$text = $(this);

       	if (key !== 8 && key !== 9) {
           	if ($text.val().length === 3) {
               	$text.val($text.val() + '-');
           	}

           	if ($text.val().length === 7) {
               	$text.val($text.val() + '-');
           	}
       	}
       	return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
   	});

	$('body').on('click', '.update_preview', function() {
		$('.form_type').val('preview');
	});

	$('body').on('click', '.display_printable_page', function() {
		$('.form_type').val('submit');
	});

	$('.id_card_form').submit(function(event) {
		event.preventDefault();
        var $this = $(this);
        var form_type = $('.id_card_form').val();
        var dataString = new FormData($('.id_card_form')[0]);
        
        $.ajax({
            url: addUrl,
            type: 'POST',
            data: dataString,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $($this).find('button[type="submit"]').prop('disabled', true);
            },
            success: function(result) {
                $($this).find('button[type="submit"]').prop('disabled', false);

                if (result.status == true) {
                	if (result.type == 'submit') {
	                    $this[0].reset();

	                    $('.error').html("");

	                    window.location.href = previewCardUrl+'/'+result.data.id;
	                } else {
	                	// $('.left_loader').show();
	                	$('.error').html("");
	                	$('.school_card').text(result.data.school_name);
	                	$('.year_card').text(result.data.school_year);
	                	$('.middle').find('.left').hide();
	                	$('.student_img_card').remove();
	                	$('.teacher_img_card').remove();
	                	$('.append_card_img').show();

	                	if (result.data.card_type == '1') {
	                		$('.student_name_card').text(result.data.student_name);
	                		$('.dob_card').text(result.data.dob);
	                		$('.educator_card').text(result.data.teacher_name);
	                		$('.grade_card').text(result.data.student_grade);
	                	} else {
	                		var address1 = "";
	                		if (result.data.address1) {
	                			address1 = result.data.address1;
	                		}

	                		var address2 = "";
	                		if (result.data.address2) {
	                			address2 = result.data.address2;
	                		}

	                		var city = "";
	                		if (result.data.city) {
	                			city = result.data.city;
	                		}

	                		$('.teacher_name_card').text(result.data.teacher_name);
	                		$('.address_card').text(address1+' '+address2+' '+city);
	                		$('.phone_card').text(result.data.phone_number);
	                	}

	                	// $('#html2canvas').show();
	                	// var container = document.getElementById("html2canvas");
		                // html2canvas(container, { allowTaint: true,backgroundColor:null }).then(function (canvas) {
		                //     var dataURL = canvas.toDataURL();
		                //     $('#html2canvas').hide();
		                //     $('.static_img').html('<img src="'+dataURL+'">');
		                //     $('.left_loader').hide();
		                // });
	                }
                } else {
                    first_input = "";
                    $('.error').html("");
                    $.each(result.message, function(key) {
                        if(first_input=="") first_input=key;
                        $('#'+key).closest('.column').find('.error').html(result.message[key]);
                    });
                    $('.id_card_form').find("#"+first_input).focus();
                }
            },
            error: function(error) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                alert('Something went wrong!', 'error');
            }
        });
	});
});