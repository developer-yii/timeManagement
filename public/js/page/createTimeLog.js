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

        $('#add-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            // var hrs = $('#hrs').val();
            // var minute = $('#minutes').val();
            // if(hrs == '' && minute == '')
            // {
            //     alert('Please enter Hrs or minute!');
            //     return;
            // }
            // if(hrs == '')
            // {
            //     hrs = 0;
            // }
            // if(minute == '')
            // {
            //     minute = 0;
            // }            

            var dataString = new FormData($('#add-form')[0]);

            var fileLength = $('#add-form #formFileMultiple')[0].files.length;
            let files = $('#formFileMultiple')[0];
            
            for (let i = 0; i < fileLength; i++) {
                dataString.append('formFileMultiple' + i, files.files[i]);
            }

            $.ajax({
                url: addUrl,
                type: 'POST',
                // data: $('#add-form').serialize(),
                data: dataString,
                cache: false,
                contentType: false,
                processData: false,
                // dataType: 'json',
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

                        $('.error').html("");
                        $('#edit-id').val(0);

                    } else {
                        first_input = "";
                        $('.error').html("");
                        $.each(result.message, function(key) {
                            if(first_input=="") first_input=key;
                            // $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                            if(key.match(/formFileMultiple.*/))
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
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    alert('Something went wrong!', 'error');
                    //location.reload();
                }
            });
        });                            

       $('body').on('change','#end_time',function(e){
            e.preventDefault();
            $('#log_time').val(calculateTime());            
        })
        
    });