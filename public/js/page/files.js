$(document).ready(function() {

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
            ],
            "drawCallback": function( settings ) {
            }
        });
});