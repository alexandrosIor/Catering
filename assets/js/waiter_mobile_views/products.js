$(function(){

	$('.products li').each(function(){
		$(this).on('touchend', function(){
			modal_title($(this).find('span:first').html());
			add_product_modal($(this).data('product_record_id'));
		});
	});

	$('.close-modal').on('touchend', function(){
		close_modal($('#myModal'));
	});

})

function add_product_modal(product_record_id)
{	
	var modal = $('#myModal');

	$.ajax({
		type: 'POST',
		url: '/orders/ajax_add_product_modal/',
		async: false,
		data: {'product_record_id' : product_record_id},
		success: function(response) {
			$(modal).find('.content').append(response);
			$(modal).addClass('active').css('z-index','1040');
		},
		error: function() {
			alert(failure);
		}
	});
}