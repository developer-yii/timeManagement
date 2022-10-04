Coloris({
      swatches: [
        '#fa5c7c',
        '#264653',
        '#2a9d8f',
        '#e9c46a',
        '#f4a261',
        '#e76f51',
        '#d62828',
        '#023e8a',
        '#0077b6',
        '#0096c7',
        '#00b4d8',
        '#48cae4',
      ],
      format: 'hex',
      theme: 'large',
      themeMode: 'light', // light, dark, auto
    });

$(document).ready(function() {

        var msgElement = $('#add_error_message');
        var editmsgElement = $('#edit_error_message');

        function calculateTime()
        {
            var day = '1/1/1970 ', // 1st January 1970
            start = $('#start_time').val(), //eg "09:20 PM"
            end = $('#end_time').val(), //eg "10:00 PM"
            diff_in_min = ( Date.parse(day + end) - Date.parse(day + start) ) / 1000 / 60;

            var hr = Math.floor(diff_in_min / 60);
            var min = diff_in_min % 60;

            if(hr < 10)
                hr = '0'+hr;
            if(min < 10)
                min = '0'+min;

            return hr+':'+min;
        }

        function calculateTimeEdit()
        {
            var day = '1/1/1970 ', // 1st January 1970
            start = $('#start_time1').val(), //eg "09:20 PM"
            end = $('#end_time1').val(), //eg "10:00 PM"
            diff_in_min = ( Date.parse(day + end) - Date.parse(day + start) ) / 1000 / 60;

            var hr = Math.floor(diff_in_min / 60);
            var min = diff_in_min % 60;

            if(hr < 10)
                hr = '0'+hr;
            if(min < 10)
                min = '0'+min;

            return hr+':'+min;
        }

        $('.add-new').click(function(event) {
            $('#add-form-lable').html('');
            $('#add-form-lable').html('Add Student Time Log');
            $('#add-form').find('button[type="submit"]').show();
            $('#add-form').find('#edit-id').val(0);
            $('#add-form')[0].reset()
        });

        $('#add-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: addUrl,
                type: 'POST',
                data: $('#add-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $this[0].reset();


                        setTimeout(function() {
                            $('#add-modal').modal('hide');                            
                            show_toast(result.message, 'success');
                        }, 300);
                        location.reload();

                        $('.error').html("");
                        $('#edit-id').val(0);

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                        });
                        $('#add-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    //location.reload();
                }
            });
        });        

        $('#edit-form').submit(function(e){
            e.preventDefault();

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
                            show_toast(result.message, 'success');
                        }, 300);
                        location.reload();

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

        $('body').on('click','.delete-subject',function(event) {
            var id = $(this).attr('data-id');
            if(confirm('Are you sure want to delete?')){
                $.ajax({
                    url: deleteUrl+'?id='+id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {
                        element = $('#flash-message');
                        show_toast(result.message, 'success');
                        location.reload();
                    }
                });    
            }
        });                

        $('body').on('click','#log-del',function(event) {
            var log_id = $('#add-modal').find('#edit-id').val()
            if(confirm('Are you sure want to delete this log?'))
            {
                $.ajax({
                    url: deleteUrl+'?id='+log_id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {            
                        show_toast(result.message, 'success');

                        setTimeout(function() {                        
                            location.reload();
                        }, 1500);
                    }
                });
            }
        });

        $('body').on('click','#event-del',function(event) {
            var eventId = $('#edit-modal').find('#edit-id').val()
            if(confirm('Are you sure want to delete this log?'))
            {
                $.ajax({
                    url: deleteEventUrl+'?id='+eventId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {            
                        $('#edit-modal').hide();
                        show_toast(result.message, 'success');

                        setTimeout(function() {                        
                            location.reload();
                        }, 1500);
                    }
                });
            }
        });

        $('body').on('click','.reset-form',function(){

            window.location.href = window.location.pathname;            
        })

        $('body').on('change','#end_time',function(e){
            e.preventDefault();
            $('#log_time').val(calculateTime());            
        })

        $('body').on('change','#end_time1',function(e){
            e.preventDefault();
            $('#edit_log_time').val(calculateTimeEdit());            
        })
    });