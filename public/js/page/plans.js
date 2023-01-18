$(document).ready(function() {

	var buttonLoading = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Processing...';
    var buttonSave = 'Apply';

	$('#freeCodeForm').submit(function (e){
		e.preventDefault();
		var $this = $(this);
            $.ajax({
                url: freeCodeUrl,
                type: 'POST',
                data: $('#freeCodeForm').serialize(),
                dataType: 'json',
                beforeSend: function() {
                	$($this).find('button[type="submit"]').html(buttonLoading);
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                	$($this).find('button[type="submit"]').html(buttonSave);
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $this[0].reset();                        
                        $('.error').html("");                        
                        window.location.href = homeUrl;

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('.error').html(result.message[key]);                            
                        });
                        $('#freeCodeForm').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                	$($this).find('button[type="submit"]').html(buttonSave);
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    // location.reload();
                }
            });
	});
});