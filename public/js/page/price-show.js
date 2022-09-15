$(document).ready(function(){
	$('#change-price-form').submit(function(e){
		e.preventDefault();

		var $this = $(this);

		if(confirm('Are you sure to change price of subscription?'))
		{			
			$.ajax({
	            url: priceChangeUrl,
	            type: 'POST',
	            data: $('#change-price-form').serialize(),
	            dataType: 'json',
	            beforeSend: function() {
	                $($this).find('button[type="submit"]').prop('disabled', true);
	            },
	            success: function(result) {
	                $($this).find('button[type="submit"]').prop('disabled', false);
	                if (result.status == true) {
	                    $this[0].reset();
	                    show_toast(result.message, 'success');
	                    
	                   	$('.error').html("");
	                   	setTimeout(function(){
	                   		location.reload();						  
						}, 1000);

	                } 
	                else if(result.Error == true)
	                {
	                	show_toast(result.message, 'error');	                	
	                }
	                else {
	                    first_input = "";
	                    $('.error').html("");
	                    $.each(result.message, function(key) {
	                        if(first_input=="") first_input=key;
	                        $($this).find('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
	                    });

	                    $('#change-price-form').find("#"+first_input).focus();
	                }
	            },
	            error: function(error) {
	                $($this).find('button[type="submit"]').prop('disabled', false);
	                alert('Something went wrong!', 'error');
	                // location.reload();
	            }
	        });
		}
	})
});