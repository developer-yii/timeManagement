$(document).ready(function() {

        var msgElement = $('#add_error_message');
        var editmsgElement = $('#edit_error_message');

        $('body').on('click','.editModal',function(event) {
            $('.modal-lable-class').html('Edit');
            var logId = $(this).attr('data-id');
            $('#edit-id').val(logId);

            $.ajax({
                url: detailUrl+'?id='+logId,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.status == true) {
                        $('#edit-form').find('#student_id').val(result.data.student_id);
                        $('#edit-form').find('#subject_id').val(result.data.subject_id);
                        $('#edit-form').find('#log_date').val(result.data.log_date);
                        $('#edit-form').find('#log_time').val(result.data.log_time);
                        $('#edit-form').find("textarea#activity_notes").val(result.data.activity_notes); 
                        if(result.data.is_attendance)
                            $('#edit-form').find('#attendance').prop('checked',true);
                        
                        $('.error').html("");                        
                    } else {                        
                        
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    //location.reload();
                }
            });
            
        });

        $('#edit-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: editUrl,
                type: 'POST',
                data: $('#edit-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $this[0].reset();

                        setTimeout(function() {
                            $('#edit-modal').modal('hide');
                            console.log('helo');
                            show_toast(result.message, 'success');
                        }, 300);

                        $( ".search_log" ).trigger( "click" );

                        $('.error').html("");
                        $('#edit-id').val(0);

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                        });
                        $('#edit-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    //location.reload();
                }
            });
        });

        $('#search-form').submit(function(event) {
            event.preventDefault();           

            var $this = $(this);
            $.ajax({
                url: searchUrl,
                type: 'GET',
                data: $('#search-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $('#logData').html('');
                        $('#logData').html(result.data);
                        $('.error').html("");                        
                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#'+key).closest('.col-3').find('.error').html(result.message[key]);
                        });
                        $('#search-form').find("#"+first_input).focus();
                        
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    //location.reload();
                }
            });
        });                
    });