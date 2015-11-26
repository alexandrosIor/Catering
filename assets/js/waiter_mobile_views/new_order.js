$(function(){

	$('.categories li').each(function(){
		$(this).on('touchend', function(){
			if ( $('.subcategories').is($(this).children()) )
			{
				return false;
			}
			else
			{
				modal_title($(this).find('span:first').html());
				open_products_modal($(this).data('product_category_record_id'));
			}
		});
	});

	$('.close-modal').on('touchend', function(){
		close_modal($('#myModal'));
	});

})

function open_products_modal(product_category_record_id)
{	
	var modal = $('#myModal');

	$.ajax({
		type: 'POST',
		url: '/orders/ajax_products_modal/',
		async: false,
		data: {'product_category_record_id' : product_category_record_id},
		success: function(response) {
			$(modal).find('.content').append(response);
			$(modal).addClass('active').css('z-index','1040');
		},
		error: function() {
			alert(failure);
		}
	});
}