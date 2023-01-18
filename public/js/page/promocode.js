function copyID() {
    var copyPromo = $('#promocode').val();
    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyPromo);        
    show_toast('Copied - '+copyPromo, 'success'); 
}
$(document).ready(function() {

    var msgElement = $('#add_error_message');
    var editmsgElement = $('#edit_error_message');

    $('#add-modal').on('hidden.bs.modal', function(e) {
        $('#add-form')[0].reset();
        $('#edit-id').val('');
        $('.error').html('');
    })

    $(document).on('click', '.generate', function(e){
        e.preventDefault();

        $.ajax({
            url: generateUrl,
            type: 'GET',
            success: function(result) {     
                $('#promocode').val(result);
            },
            error: function(error) {               
            }
        });
    })

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

                    if($('#promoTable').length>0)
                        $('#promoTable').DataTable().ajax.reload();
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
                        $('.error').html(result.message[key]);
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

    $('body').on('click','.edit-promocode',function(event) {
        var id = $(this).attr('data-id');
        $.ajax({
            url: detailUrl+'?id='+id,
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                $('#edit-id').val(id);
                $('#add-modal').modal('show');
                $('.modal-lable-class').html('Edit');
                $('#add-form').find('#promocode').val(result.data.promocode);                
            }
        });    
    });    

    $('body').on('click','.delete-promocode',function(event) {
        var id = $(this).attr('data-id');
        if(confirm('Are you sure want to delete?')){
            $.ajax({
                url: deleteUrl+'?id='+id,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    element = $('#flash-message');
                    show_toast(result.message, 'success');
                    if($('#promoTable').length>0)
                        $('#promoTable').DataTable().ajax.reload();
                    else
                        location.reload();
                }
            });    
        }
    });
    
    if($('#promoTable').length>0)
    var departmentTable = $('#promoTable').DataTable({
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
            { data: 'promocode' },
            {
                sortable: false,
                render: function(_,_, full) {
                    var contactId = full['id'];

                    if(contactId) {
                        actions = "";
                        actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-warning edit-promocode"><i class="mdi mdi-pencil"></i></a>';
                        actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-danger delete-promocode"><i class="mdi mdi-trash-can"></i></a>';
                        
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