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

        $(function(){
            $('[data-serialtip]').serialtip();
        });   

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

        $('.add-new-holiday').click(function(event) {
            $('#add-holiday-form')[0].reset();
        });

        $("#rowAdder").click(function () {
            newRowAdd = '';
            newRowAdd += '<div class="mb-1"><div class="row linkrow">';
            newRowAdd += linkhtml;
            newRowAdd += '</div></div>';
 
            $('#newinput').append(newRowAdd);
        });
 
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents(".mb-1").remove();
        })

        // $("body").on("change", ".links", function () {
        //     var lid = $(this).val()
        //     var el = $(this).parents(".mb-3");

        //     $.ajax({
        //         url: getLinkUrl,
        //         type: 'POST',
        //         data: {id:lid},
        //         dataType: 'json',
        //         success: function(result) {                    
        //             el.contents().find("input").val(result.link);
        //         }
        //     });
            
        // });

        $('body').on('click','input[type="checkbox"]',function(e){
            var currentElement = $(this);
            var i = $(this).val();
            
            if(i == 'all')
            {
                if($("body #student_id_all").prop('checked') == true){
                    $("body .student-checkbox").each(function(){
                        $(this).prop('checked',false);     
                        $(this).change();  
                        $(this).prop('disabled', true);
                    });

                }
                else
                {
                    $("body .student-checkbox").each(function(){
                        $(this).prop('checked',false);     
                        $(this).change();  
                        $(this).prop('disabled', false);
                    });                           
                }
            }
        })

        $('#log_date').datepicker({
            format: "yyyy-mm-dd",
            multidate: true,            
        });

        $('.add-new').click(function(event) {
            $('#add-form-lable').html('');
            $('#add-form-lable').html('Add Student Time Log');
            $('.linkrow').html('');
            $('#ufiles').html('');
            $('#add-form').find('button[type="submit"]').show();
            $('#add-form').find('#edit-id').val(0);
            $('#log_date').datepicker('setDate',null);
            $('#log_date').datepicker('destroy');
            $('#log_date').datepicker({ format: "yyyy-mm-dd", multidate: true,});
            $('#add-form')[0].reset();
        });

        $('body').on('click','.delete-u-file',function(e){
            e.preventDefault();
            var fileId = $(this).attr('data-id');
            var $this = $(this);
            
            if(confirm('Are you sure want to delete this file?')){
                $.ajax({
                    url: deleteFileUrl+'?id='+fileId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {
                        if(result.status == true)
                        {                            
                            show_toast(result.message, 'success');
                            $this.closest(".file").remove();
                        }
                    }
                });    
            }
        });

        $('#add-holiday-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: addHolidayUrl,
                type: 'POST',
                data: $('#add-holiday-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $this[0].reset();

                        setTimeout(function() {
                            $('#add-holiday-modal').modal('hide');                            
                            show_toast(result.message, 'success');
                        }, 300);
                        location.reload();

                        $('.error').html("");
                        
                        $("body .student-checkbox").each(function(){
                            $(this).prop('checked',false);     
                            $(this).change();  
                            $(this).prop('disabled', false);
                        });                        

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                            if(key == 'student_id')
                                $('.student_id').html(result.message[key]);
                        });
                        $('#add-holiday-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    // location.reload();
                }
            });
        });

        $('#add-student-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: addStudentUr,
                type: 'POST',
                data: $('#add-student-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $this[0].reset();                        

                        $('#add-student-modal').modal('hide');
                        show_toast(result.message, 'success');
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1000);

                        $('.error').html("");                        

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                        });
                        $('#add-student-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    // location.reload();
                }
            });
        });

        $('#add-subject-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: addSubjectUrl,
                type: 'POST',
                data: $('#add-subject-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $this[0].reset();                       

                        setTimeout(function() {
                            $('#add-subject-modal').modal('hide');
                            show_toast(result.message, 'success');
                        }, 300);

                        $('.error').html("");                        

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                        });
                        $('#add-subject-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    // location.reload();
                }
            });
        });

        $('#add-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            var dataString = new FormData($('#add-form')[0]);

            var fileLength = $('#add-form #formFileMultiple')[0].files.length;
            let files = $('#formFileMultiple')[0];

            var buttonLoading = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Loading...';
            var buttonSave = 'Save changes';
            
            for (let i = 0; i < fileLength; i++) {
                dataString.append('formFileMultiple' + i, files.files[i]);
            }  
                        
            $.ajax({
                url: addUrl,
                type: 'POST',
                data: dataString,
                // dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $($this).find('button[type="submit"]').html(buttonLoading);
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').html(buttonSave);
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if (result.status == true) {
                        $this[0].reset();

                        show_toast(result.message, 'success');

                        $('#add-modal').modal('hide');                            
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                        $('.error').html("");
                        $('#edit-id').val(0);

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            if(key == 'hrs')
                            {
                                $('#'+key).closest('.col-4').find('.error').html(result.message[key]);                            
                            }
                            else if(key == 'minutes')
                            {
                                $('#'+key).closest('.col-4').find('.error').html(result.message[key]);
                            }
                            else if(key.match(/formFileMultiple.*/))
                            {
                                $('.formFileMultiple').html(result.message[key]);    
                            }
                            else
                            {
                                $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                            }
                        });
                        $('#add-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').html(buttonSave);
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

        $('body').on('click','.deleteRow',function(event) {
            var link_id = $(this).attr('data-id');
            $this = $(this);
            
            if(confirm('Are you sure want to delete this link?'))
            {
                $.ajax({
                    url: deleteLinkUrl+'?id='+link_id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {            
                        if(result.status == true)
                        {                            
                            show_toast(result.message, 'success');
                            $this.parents(".mb-1").remove();
                        }
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