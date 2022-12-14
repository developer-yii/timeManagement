$(document).ready(function() {

        var msgElement = $('#add_error_message');
        var editmsgElement = $('#edit_error_message');

        
        $('[data-serialtip]').serialtip();        

        Coloris({
          swatches: [
            '#d1652b',
            '#e0b284',
            '#e2b751',
            '#c6990f',
            '#ffe1ba',
            '#e5976e',
            '#84f93b',
            '#079175',
            '#9ef7cf',
            '#80f2ec',
            '#b1c9f9',
            '#1870e2',
          ],
          format: 'hex',
          theme: 'large',
          themeMode: 'light', // light, dark, auto
        });

        $('.add-new').click(function(event) {
            $('.modal-lable-class').html('Add');
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

                        if($('#subjectTable').length>0)
                            $('#subjectTable').DataTable().ajax.reload();
                        else
                            location.reload();

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

        $('body').on('click','.edit-subject',function(event) {
            var id = $(this).attr('data-id');
            $.ajax({
                url: detailUrl+'?id='+id,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    $('#edit-id').val(id);
                    $('#add-modal').modal('show');
                    $('.modal-lable-class').html('Edit');
                    $('#add-form').find('#subject_name').val(result.data.subject_name);
                    $('#add-form').find('#subject_type').val(result.data.subject_type);
                    $('#add-form').find('#subject_color').val(result.data.subject_color);
                    document.querySelector('#subject_color').dispatchEvent(new Event('input', { bubbles: true }));
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
                        if($('#subjectTable').length>0)
                            $('#subjectTable').DataTable().ajax.reload();
                        else
                            location.reload();
                    }
                });    
            }
        });
        
        if($('#subjectTable').length>0)
        var departmentTable = $('#subjectTable').DataTable({
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
                { data: 'subject_name' },
                {
                    sortable: false,
                    render: function(_,_, full) {
                        var contactId = full['id'];

                        if(contactId) {
                            actions = "";
                            actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-warning edit-subject"><i class="mdi mdi-pencil"></i></a>';
                            actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-danger delete-subject"><i class="mdi mdi-trash-can"></i></a>';
                            
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