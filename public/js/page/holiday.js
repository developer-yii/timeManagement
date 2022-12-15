$(document).ready(function() {

        var msgElement = $('#add_error_message');
        var editmsgElement = $('#edit_error_message');

        $('[data-serialtip]').serialtip();

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

        $('#event_date,#edit_event_date').datepicker({
            format: "yyyy-mm-dd",
            multidate: true,            
        });

        $('.add-new').click(function(event) {
            $('.modal-lable-class').html('Add');
            $('#add-form')[0].reset();
        });

        $('body').on('click','input[type="checkbox"]',function(e){
            var currentElement = $(this);
            var i = $(this).val();
            
            if(i == 'all')
            {
                if($("body #student_id_all").prop('checked') == true){
                    console.log('enter');
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

                        if($('#holidayTable').length>0)
                            $('#holidayTable').DataTable().ajax.reload();
                        else
                            location.reload();

                        $("body .student-checkbox").each(function(){
                            $(this).prop('checked',false);     
                            $(this).change();  
                            $(this).prop('disabled', false);
                        });

                        setTimeout(function() {
                            $('#add-modal').modal('hide');
                            show_toast(result.message, 'success');
                        }, 300);

                        $('.error').html("");
                        $('#edit-id').val(0);

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                            if(key == 'student_id')
                                $('.student_id').html(result.message[key]);
                        });
                        $('#add-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    // location.reload();
                }
            });
        });

        $('#edit-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: updateUrl,
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

                        if($('#holidayTable').length>0)
                            $('#holidayTable').DataTable().ajax.reload();
                        else
                            location.reload();

                        setTimeout(function() {
                            $('#edit-modal').modal('hide');
                            show_toast(result.message, 'success');
                        }, 300);

                        $('.error').html("");
                        $('#edit-id').val(0);

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            $('#edit_'+key).closest('.mb-3').find('.error').html(result.message[key]);
                            if(key == 'student_id')
                                $('.student_id').html(result.message[key]);
                        });
                        $('#edit-form').find("#"+first_input).focus();
                    }
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    // location.reload();
                }
            });
        });

        $('body').on('click','.edit-holiday',function(event) {
            var id = $(this).attr('data-id');

            $.ajax({
                url: detailUrl+'?id='+id,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    $('#edit-id').val(id);
                    $('#edit-modal').modal('show');
                    $('.modal-lable-class').html('Edit');
                    // $('#edit-form').find('#edit_start_date').val(result.data.start_date);
                    // $('#edit-form').find('#edit_end_date').val(result.data.end_date);
                    $('#edit_event_date').datepicker('destroy');
                    $('#edit_event_date').datepicker({ format: "yyyy-mm-dd", multidate: false,});
                    $('#edit-form').find('#edit_event_date').val(result.data.event_date);
                    $('#edit-form').find('#edit_note').val(result.data.note);
                    $('#edit-form').find('#edit_event_color').val(result.data.event_color);
                    $('#edit_modal').html('');
                    if(result.data.studentName)
                        $('#edit_modal').html(result.data.studentName);
                    else
                        $('#edit_modal').html('All');
                    document.querySelector('#edit_event_color').dispatchEvent(new Event('input', { bubbles: true }));
                    // $('#add-form').find('#student_id').val(result.data.student_id);
                }
            });    
        });

        

        $('body').on('click','.delete-holiday',function(event) {
            var id = $(this).attr('data-id');
            if(confirm('Are you sure want to delete?')){
                $.ajax({
                    url: deleteUrl+'?id='+id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {
                        element = $('#flash-message');
                        show_toast(result.message, 'success');
                        if($('#holidayTable').length>0)
                            $('#holidayTable').DataTable().ajax.reload();
                        else
                            location.reload();
                    }
                });    
            }
        });
        
        if($('#holidayTable').length>0)
        var departmentTable = $('#holidayTable').DataTable({
            searching: true,
            pageLength: 25,
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
                { data: 'first_name', name:'students.first_name' },
                { data: 'last_name', name:'students.last_name' },
                { data: 'event_date' },
                // { data: 'end_date' },
                { data: 'note' },
                {
                    sortable: false,
                    render: function(_,_, full) {
                        var stuColor = full['event_color'];

                        if(stuColor) {
                            actions = "";
                            actions += ' <span class="me-2 dot" style="background-color:'+ stuColor+';"></span>';
                            return actions;
                        }
                        return '';
                    },
                },
                {
                    sortable: false,
                    render: function(_,_, full) {
                        var contactId = full['id'];

                        if(contactId) {
                            actions = "";
                            actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-warning edit-holiday"><i class="mdi mdi-pencil"></i></a>';
                            actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-danger delete-holiday"><i class="mdi mdi-trash-can"></i></a>';
                            
                            return actions;
                        }

                        return '';
                    },
                },
            ],
            "drawCallback": function( settings ) {
            }
        });


    });