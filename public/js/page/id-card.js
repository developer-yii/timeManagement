$(document).ready(function() {
	if (isCard) {
		$('#dob').datepicker({
	        format: "mm-dd-yy",
	        autoclose: true,
	    });
	}

	// var element = $('#print-v-card');
	if (isPrint) {
		window.print();
	}

	// html2canvas(element, {
    //     onrendered: function(canvas) {
    //         var imgData = canvas.toDataURL('image/jpeg');
    //         $('#print-v-card').hide();
    //         $('.append_canvas').attr('src', imgData);
    //         $('.append_canvas').show();
    //         window.print();
    //     }
    // });

	function card_type_change() {
		var card_type = $('input[name="card_type"]:checked').val();

		if (card_type == 1) {
			$('.disable_for_student').attr('disabled', true);
			$('.disable_for_teacher').attr('disabled', false);

			$('.hide_for_student').hide();
			$('.hide_for_teacher').show();
		} else {
			$('.disable_for_student').attr('disabled', false);
			$('.disable_for_teacher').attr('disabled', true);

			$('.hide_for_student').show();
			$('.hide_for_teacher').hide();
		}
	}

	card_type_change();

	$('input[type=radio][name=card_type]').change(function() {
		card_type_change();
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
	                	$('.error').html("");
	                	$('.school_card').text(result.data.school_name);
	                	$('.year_card').text(result.data.school_year);
	                	$('.middle').find('.left').hide();
	                	$('.append_card_img').show();

	                	if (result.data.card_type == '1') {
	                		// $('.student_img_card').attr('src', '');
	                		$('.student_name_card').text(result.data.student_name);
	                		$('.dob_card').text(result.data.dob);
	                		$('.educator_card').text(result.data.teacher_name);
	                		$('.grade_card').text(result.data.student_grade);
	                	} else {
	                		$('.teacher_name_card').text(result.data.teacher_name);
	                		$('.address_card').text(result.data.address1+' '+result.data.address2+', '+result.data.city);
	                		$('.phone_card').text(result.data.phone_number);
	                	}
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