$(document).ready(function() {
	var msgElement = $('#add_error_message');
    var editmsgElement = $('#edit_error_message');

    $('#password-form').submit(function(event) {
        event.preventDefault();
        var $this = $(this);
        
        $.ajax({
            url: addUrl,
            type: 'POST',
            data: $('#password-form').serialize(),
            dataType: 'json',
            beforeSend: function() {
                $($this).find('button[type="submit"]').prop('disabled', true);
            },
            success: function(result) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                if (result.status == true) {
                    $('.error').html("");                    

                    setTimeout(function() {
                        show_toast(result.message, 'success');
                    }, 300);

                    setTimeout(function() {
                        location.reload();
                    }, 2000);                    

                } else {
                    first_input = "";
                    $('.error').html("");
                    $.each(result.message, function(key) {
                        console.log(key);
                        if(first_input=="") first_input=key;
                        $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                    });
                    $('#password-form').find("#"+first_input).focus();
                }
            },
            error: function(error) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                alert('Something went wrong!', 'error');
                // location.reload();
            }
        });
    });
});