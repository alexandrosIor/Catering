$('#myModal').on('hidden.bs.modal', function () {
	$(this).data('bs.modal', null);
});

/* check for empty inputs */
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

/* check for correct email format */
function is_valid_email(email) {
	var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
	return pattern.test(email);
};