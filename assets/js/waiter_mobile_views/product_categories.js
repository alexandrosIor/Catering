$(function(){

	$('.categories li').each(function(){
		$(this).on('touchend', function(){
			if ( $('.subcategories').is($(this).children()) )
			{
				return false;
			}
			else
			{
				window.location.href = '/orders/product_category_prodducts/' + $(this).data('product_category_record_id');
			}
		});
	});

})