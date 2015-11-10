window.onload=function()
{
	$("input:first").focus();
	
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
	
	$("#login_form").on('submit', function (e) {
		e.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/login/check/",
			data: $('form#login_form').serialize(),
			dataType: 'json',
			success: function(msg){
				if (msg.hasOwnProperty('message'))
				{
					//TODO: sweetalert
					alert(msg.message);
				}
				if (msg.hasOwnProperty('redirect'))
				{
					
					window.location.replace(msg.redirect);
				}
			},
			error: function() {
				//TODO: sweetalert
				alert(failure);
			}
		});
	});
}