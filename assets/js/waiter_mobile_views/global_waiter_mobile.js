$(function(){

	$('.open-settings').on('touchend', function(){
		open_settings_modal($('#myModal'));		
	});

	$('.close-settings').on('touchend', function(){
		close_modal($('#myModal'));
	});

	open_popover($('.select-table'));
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

function open_popover(element)
{	
	$(element).unbind();
	$(element).on('touchend', function(){
		$.ajax({
			type: 'GET',
			url: '/orders/ajax_popover_table_select/',
			async: false,
			success: function(response) {
				$('.fa-angle-down').removeClass('fa-angle-down').addClass('fa-angle-up');
				$('body').append(response);
				$('#popover').addClass('visible').css('display', 'block');
				$('body').append('<div class="backdrop"></div>');

				close_popover(element);
			},
			error: function() {
				alert(failure);
			}
		});
	})
}

function close_popover(element)
{
	$(element).unbind();
	$(element).on('touchend', function(){
		$('.popover').remove();
		$('body').find('.backdrop').remove();
		$('.fa-angle-up').removeClass('fa-angle-up').addClass('fa-angle-down');

		open_popover(element);
	});
}