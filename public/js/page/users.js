$(document).ready(function() {

    $('body').on('click','.user-login',function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var homeUrl = window.location.origin;

        $.ajax({
            url: loginUrl,
            type: 'POST',
            data: {id:id},
            dataType: 'json',
            success: function(result) {
                if (result.status == true) {
                    show_toast(result.message, 'success');
                    setTimeout(function () {
                        location.reload();
                     }, 1000);
                                        
                } else {
                    show_toast(result.message, 'error');
                }
            },
            error: function(error) {                    
                alert('Something went wrong!', 'error');
                // location.reload();
            }
        });       
    });    

    $('body').on('click','.user-delete',function(event) {
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

    var userTable = $('#userTable').DataTable({
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
            { data: 'name' },
            { data: 'email' },
            { data: 'type' },            
            {
                sortable: false,
                render: function(_,_, full) {
                    var contactId = full['id'];

                    if(contactId) {
                        actions = "";
                        actions += ' <a href="javascript:void(0)" data-toggle="tooltip" title="click to login" data-id="'+ contactId +'" class="btn-sm btn-warning user-login"><i class="mdi mdi-login-variant"></i></a>';
                        actions += ' <a href="javascript:void(0)" data-toggle="tooltip" title="click to delete" data-id="'+ contactId +'" class="btn-sm btn-danger user-delete"><i class="mdi mdi-delete"></i></a>';
                        
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