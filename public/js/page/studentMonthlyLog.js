$(document).ready(function() {

        var msgElement = $('#add_error_message');
        var editmsgElement = $('#edit_error_message');
        var searched = 0;

        var doc = window.jspdf.jsPDF;

        $('[data-serialtip]').serialtip();

        $("#rowAdder").click(function () {
            newRowAdd = '';
            newRowAdd += '<div class="mb-3"><div class="row linkrow">';
            newRowAdd += linkhtml;
            newRowAdd += '</div></div>';
 
            $('#newinput').append(newRowAdd);
        });
 
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents(".mb-3").remove();
        })

        $("body").on("change", ".links", function () {
            var lid = $(this).val()
            var el = $(this).parents(".mb-3");

            $.ajax({
                url: getLinkUrl,
                type: 'POST',
                data: {id:lid},
                dataType: 'json',
                success: function(result) {                    
                    el.contents().find("input").val(result.link);
                }
            });
            
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

        function printDiv(divId,title,appCssUrl,customCssUrl,name,month,year) 
        {
            let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

            mywindow.document.write(`<html><head><title>${title}</title>`);
            mywindow.document.write('<link rel="stylesheet" type="text/css" href='+appCssUrl+'>');
            mywindow.document.write('<link rel="stylesheet" type="text/css" href='+customCssUrl+'>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<div class="row">');
            mywindow.document.write('<div class="col-md-4">');
            mywindow.document.write('<h6>Name: '+name+'</h6></br>');
            mywindow.document.write('</div>');
            mywindow.document.write('<div class="col-md-4">');
            mywindow.document.write('<h6>Month: '+month+'</h6></br>');
            mywindow.document.write('</div>');
            mywindow.document.write('<div class="col-md-4">');
            mywindow.document.write('<h6>Year: '+year+'</h6></br>');
            mywindow.document.write('</div>');
            mywindow.document.write('</div>');
            mywindow.document.write(document.getElementById(divId).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            // mywindow.close();

            return true;
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

        $('body').on('click','.print-pdf', function(event){
            event.preventDefault();
            if(!searched)
            {
                alert('First search the Data !')
            }
            var student_id = $('#student_id').val();
            var log_year = $('#year').val();
            var log_month = $('#month').val();
            // alert(student_id+' '+log_year+' '+log_month);

            $.ajax({
                url: pdfdataUrl,
                type: 'POST',
                data: {student_id:student_id, log_year:log_year,log_month:log_month},
                dataType: 'json',
                success: function(result) {
                    if (result.status == true) {
                        printDiv('pdfs','Student Monthly Log',appCssUrl,customCssUrl,result.name,result.month,result.year);                                            
                    } else {                        
                        
                    }
                },
                error: function(error) {                    
                }
            });

            // printDiv('pdfs','Student Monthly Log',appCssUrl,customCssUrl,);
        });

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
                        $('#edit-form').find('#hrs').val(result.hrs);
                        $('#edit-form').find('#minutes').val(result.minutes);
                        $('#edit-form').find("textarea#activity_notes").val(result.data.activity_notes); 
                        if(result.data.is_attendance)
                            $('#edit-form').find('#attendance').prop('checked',true);
                        if(result.data.is_completed)
                            $('#add-form').find('#completed').prop('checked',true);

                        $('.linkrow').parents(".mb-3").remove();
                        if(result.html)
                        {
                            $('#newinput').append(result.html);
                        }

                        $('#ufiles').html('');
                        if(result.fileHtml)
                        {
                            $('#ufiles').html(result.fileHtml);                                
                        }
                        
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

            var dataString = new FormData($('#edit-form')[0]);

            var fileLength = $('#edit-form #formFileMultiple')[0].files.length;
            console.log('length: '+fileLength);
            let files = $('#formFileMultiple')[0];
            
            for (let i = 0; i < fileLength; i++) {
                dataString.append('formFileMultiple' + i, files.files[i]);
            }

            $.ajax({
                url: editUrl,
                type: 'POST',
                // data: $('#edit-form').serialize(),
                data: dataString,
                // dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
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

                        $( ".search_log" ).trigger( "click" );

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
                        searched = 1;
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

        $('body').on('click','.delete_log',function(e){
            e.preventDefault();
            var delId = $(this).attr('data-id');

            if(confirm('Are you sure want to delete this log?'))
            {
                $.ajax({
                    url: deleteUrl+'?id='+delId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {            
                        show_toast(result.message, 'success');
                        $( ".search_log" ).trigger( "click" );
                    }
                });
            }
        });    

        $('body').on('change','#end_time1, #start_time1',function(e){
            e.preventDefault();            
            $('#log_time').val(calculateTimeEdit());            
        })            
    });