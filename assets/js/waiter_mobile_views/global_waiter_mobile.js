$(function(){

	$('.open-settings').on('touchend', function(){
		open_settings_modal($('#myModal'));		
	});

	$('.close-settings').on('touchend', function(){
		close_modal($('#myModal'));
	});

})

function open_settings_modal(modal)
{
	$.ajax({
		type: 'POST',
		url: '/waiter/ajax_settings_modal/',
		async: false,
		success: function(response) {
			$(modal).find('.content').append(response);
			$(modal).addClass('active').css('z-index','1040');
		},
		error: function() {
			alert(failure);
		}
	});
}
function close_modal(modal)
{
	$(modal).removeClass('active');
	$(modal).removeClass('active').css('z-index','0');
	$(modal).find('.content').children().remove();
}