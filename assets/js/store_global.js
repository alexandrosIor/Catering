/* Empty modal content on close */
$('#myModal').on('hidden.bs.modal', function () {
	$(this).data('bs.modal', null);
});

/* Check for empty inputs */
function form_empty(form)
{
	var error = false;
	
	$(form).find('input').each(function(){
		if ($(this).val().length < 1)
		{
			$(this).parent().addClass('has-error');
			$(this).on('click', function(){
				$(this).parent().removeClass('has-error');
			});
			error = true;
		}
		else if ($(this).attr('type') == 'email')
		{
			if (!is_valid_email($(this).val()))
			{
				$(this).parent().addClass('has-error');
				$(this).on('click', function(){
					$(this).parent().removeClass('has-error');
				});
				error = true;
			}
		}
	});

	return error;
}

/* Check for correct email format */
function is_valid_email(email) {
	var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
	return pattern.test(email);
};

/* Notification sound for new orders */
function notification_sound(sound)
{
	var notification = new Audio('assets/sounds/'+sound+'.mp3');
	notification.play();
}

/* Toastr notification messages */
function toastr_notification(type, title, message)
{
	Command: toastr[type](message, title);

	toastr.options = {
  		"closeButton": true,
  		"debug": false,
  		"newestOnTop": true,
  		"progressBar": false,
  		"positionClass": "toast-top-right",
  		"preventDuplicates": true,
  		"showDuration": "300",
  		"hideDuration": "0",
  		"timeOut": "0",
  		"extendedTimeOut": "0",
  		"showEasing": "swing",
  		"hideEasing": "linear",
  		"showMethod": "fadeIn",
  		"hideMethod": "fadeOut"
	}
}

/* Close shift alert popup */
$('.store_close-shift').on('click', function(){
	swal({   
		title: '<span class="close-shift-alert">Κλείσιμο βάρδιας</span>',   
		text: 'Εισάγετε το συνολικό ποσό του ταμείου σας:',   
		type: 'input',
		html: true,  
		showCancelButton: true,   
		closeOnConfirm: false,   
		animation: 'slide-from-top',   
		inputPlaceholder: 'Σύνολο',
		confirmButtonText: 'Καταχώρηση',   
		cancelButtonText: 'Ακύρωση',
		}, 
		function(inputValue){ 

			if (inputValue === false) return false;      
			if (inputValue === "") {     
				swal.showInputError("Παρακαλώ εισάγετε το ποσό του ταμείου σας!");     
				return false  
			}

			$.ajax({
				type: 'POST',
				url: '/logout/close_shift',
				async: false,
				data: {'turnover_delivered' : inputValue},
				dataType: 'json',
				success: function(data) {		
					swal({   
						title: "Η βάρδια έκλεισε!",   
						text: 'Το ταμείο σας: ' + data.turnover_delivered + '<br/>Σύνολο ταμείου: ' + data.turnover_calculated + '<br/>Διαφορα ταμείου: ' + data.turnover_diff,   
						type: "success",
						html: true, 
						showCancelButton: false,     
						confirmButtonText: "Κλείσιμο",   
						closeOnConfirm: false 
						}, 
						function(){
							window.location = '/logout'; 
						}
					);
				},
				error: function() {
					alert('failure');
				}
			});

		}
	);
});

/* Input mask to prevent from inserting invalid characters */
$('.sweet-alert input').mask('0ZZZ.ZZ',{
	translation: {
		'Z': {
			pattern: /[0-9]/, optional: true
		}
	}
});