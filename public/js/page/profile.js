function copyID() {
        var displayReferalLink = $('#referral_code_copy').html();
        console.log(displayReferalLink);
        /* Copy the text inside the text field */
        navigator.clipboard.writeText(displayReferalLink);
        show_toast('Copied - '+displayReferalLink,'success');    
    }

$(document).ready(function() {
	var msgElement = $('#add_error_message');
    var editmsgElement = $('#edit_error_message');

    $('body').on('click','.cancel-sub',function(e){
        e.preventDefault();

        if(confirm('Are you sure want to cancel subscription?'))
        {
            $.ajax({
                url: cancelSubUrl,
                type: 'POST',
                dataType: 'json',
                success: function(result) {            
                    show_toast(result.message, 'success');       
                    setTimeout(function() {
                        location.reload();
                    }, 1000);             
                }
            });
        }
    })

    $('#profile-form').submit(function(event) {
        event.preventDefault();
        var $this = $(this);
        console.log(addUrl);
        $.ajax({
            url: addUrl,
            type: 'POST',
            data: $('#profile-form').serialize(),
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

                } else {
                    first_input = "";
                    $('.error').html("");
                    $.each(result.message, function(key) {
                        if(first_input=="") first_input=key;
                        $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                    });
                    $('#profile-form').find("#"+first_input).focus();
                }
            },
            error: function(error) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                alert('Something went wrong!', 'error');
                // location.reload();
            }
        });
    });

    var referralTable = $('#referralTable').DataTable({
            searching: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            ajax: {
                url: apiUrl,
                type: 'GET',
                headers: {
                    'X-XSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
                },
            },
            columns: [
                { data: 'name' },
                { data: 'email' },
            ],
            "drawCallback": function( settings ) {
            }
        });
});