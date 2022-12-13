$(document).ready(function() {

    $('#photo').change(function(){
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {             
            
            var cHtml = '<iframe d="preview-image" src="" width="100" height="100" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%;" allowfullscreen> </iframe>';
            $('.upload_file').remove();
            $('#img-prv').html(cHtml);
             
            let reader = new FileReader();
            reader.onload = (e) => { 
                console.log(e.target);
              $('#preview-image').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);
            
        }
        else
        {            
            var cHtml = '<img id="preview-image" src="" alt="preview image" style="max-height: 100px;">';
            $('.upload_file').remove();
            $('#img-prv').html(cHtml);
             
            let reader = new FileReader();
            reader.onload = (e) => { 
                console.log(e.target);
              $('#preview-image').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

	$('[data-serialtip]').serialtip();

	var msgElement = $('#add_error_message');
    var editmsgElement = $('#edit_error_message');

    if($('#filesTable').length>0)
        var filesTable = $('#filesTable').DataTable({
        	"rowCallback": function( row, data ) {                
			  if ( data.files != '' ) {			  	
			    $('td:last-child', row).addClass('d-flex');
			  } 
			},
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
                { 
                	data: 'log_date',
                  	name: 'student_time_log.log_date'
              	},
                {
                  	data: 'first_name',
                  	name: 'students.first_name'  
                },
                {
                  	data: 'subject_name',
                  	name: 'subjects.subject_name'  
                },                
                {
                    sortable: false,
                    render: function(_,_, full) {
                        var html = full['files'];

                        if(html) {                            
                            
                            return html;
                        }

                        return '';
                    },
                },
                {
                    sortable: false,
                    render: function(_,_, full) {
                        var contactId = full['file_id'];
                        var src = full['src'];

                        if(contactId) {
                            actions = "";
                            actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" data-src="'+src+'" class="btn-sm btn-info print-file"><i class="mdi mdi-printer"></i></a>';
                            actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-warning edit-file"><i class="mdi mdi-pencil"></i></a>';
                            actions += ' <a href="javascript:void(0)" data-id="'+ contactId +'" class="btn-sm btn-danger delete-file"><i class="mdi mdi-trash-can"></i></a>';
                            
                            return actions;
                        }

                        return '';
                    },
                },
            ],
            "drawCallback": function( settings ) {
            },
            rowCallback: function( row, data, index ) {
                if (data['files'] <= 0) {
                    $(row).hide();
                }
            },
        });

    $('body').on('click','.print-file',function(event) {
        var url = $(this).attr('data-src');
        popup = window.open(url);
        // popup.focus();
        popup.print();
        return false;
    })

    $('body').on('click','.delete-file',function(event) {
        var id = $(this).attr('data-id');
        if(confirm('Are you sure want to delete?')){
            $.ajax({
                url: deleteUrl+'?id='+id,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    element = $('#flash-message');
                    show_toast(result.message, 'success');
                    if($('#filesTable').length>0)
                        $('#filesTable').DataTable().ajax.reload();
                    else
                        location.reload();
                }
            });    
        }
    });

    $('body').on('click','.edit-file',function(event) {
        var id = $(this).attr('data-id');
        $('#edit-id').val(id);

        $('#img-prv').html('');
        $('#edit-form')[0].reset();

        $('#edit-modal').modal('show');               
    });

    $('#edit-form').submit(function(e){
        e.preventDefault();
        $this = $(this);

      $.ajax({
        url: updateUrl,
        type: 'POST',
        typeData: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,

        beforeSend: function() {
            $this.find('button[type="submit"]').prop('disabled', true);
        },
        success: function(res, status) {
          $this.find('button[type="submit"]').prop('disabled', false);
          if (res.status == true) {                                    
            $('#edit-modal').modal('hide');
            $('.error').html("");            
            show_toast(res.message, 'success');
            $('#edit-form')[0].reset();
            if($('#filesTable').length>0)
                $('#filesTable').DataTable().ajax.reload();
            else
                location.reload();            
          }          
          else{            
            first_input = "";
            $('.error').html("");
            if(res.message)
            {
                show_toast(res.message, 'error');
            }
            
            $.each(res.message, function(key) {
                if(first_input==""){first_input=key};
                $('#'+key).closest('.mb-3').find('.error').html(res.message[key]);
            });
            $('#edit-form').find("#"+first_input).focus();
          }

        },
        error: function(xhr) {
          $this.find('button[type="submit"]').prop('disabled', false);
          toastr.error(xhr.message, 'error')
        }
      })

    });

});