/* Add comment on product modal */
add_comment_element_event();

/* Update product quantity events */
update_product_quantity_events();

/* Show product description in a popover */
show_product_description_event();

/* Load order products in order details tab */
$$('#order-tab').on('show', function () {
	var order_record_id = $('.products-list').data('order_record_id');
	order_products(order_record_id);

	/* Remove products that have been added for order*/
	$('.remove-product').each(function(){
		$(this).on('touchend', function(){

			var order_product = $(this).parent().parent();

			myApp.modal({
				title:  'Αφαίρεση προϊόντος',
				buttons: [
				{
					text: 'Ακύρωση',
					onClick: function() {

					}
				},
				{
					text: 'Αφαιρεση',
					onClick: function() {
						delete_product(order_product);
					}
				}
				]
			});

		});
	});

	/* Select table picker event */
	select_table('#table-picker', order_record_id);

	/* Complete order button event */
	complete_order();

	/* Update product quantity events */
	update_product_quantity_events();

	/* Show product description in a popover */
	show_product_description_event();

	/* Add comment on product modal */
	add_comment_element_event();

});

/* Add product to current order */
$('.add-product').each(function(){
	var product = $(this);
	$(product).on('touchend', function(){
		$(product).find('i').removeClass('fa-check').addClass('loader');

		var product_data = {
			'order_record_id' : $('.products-list').data('order_record_id'),
			'product_record_id' : $(product).data('product_record_id'),
			'quantity' : $(product).data('quantity'),
			'comments' : $(product).data('comments'),
		};

		$.ajax({
			type: 'POST',
			url: '/orders/ajax_add_product_for_order',
			data: product_data,
			async: false,
			success: function(response) {		
				$(product).find('i').removeClass('loader').addClass('fa-check');
				$('.products-list').data('order_record_id', response);
				$('.order-tab-link').removeAttr('disabled');
				close_swipe($('.product'));
			},
			error: function() {
				alert('failure');
			}
		});
	});
});

/* Add comment on product modal */
function add_comment_element_event()
{	
	$('.add-comment').each(function(){
		var order_product = $(this).parent().siblings('.action3');
		var product_comments = $(this).next();
		var order_product_record_id = $(this).parent().next().data('product_record_id');
		var element = $(this);

		/* Unbind previous event */
		element.unbind();

		element.on('touchend', function () {
			myApp.prompt('', 'Σχόλια', function(value){
				order_product.data('comments', value);

				if (element.parent().parent().hasClass('update-product'))
				{
					$.ajax({
						type: 'POST',
						url: '/orders/ajax_update_order_product',
						data: {'order_product_record_id': order_product_record_id, 'comments': value},
						async: false,
						success: function() {		
							product_comments.text(value);
						},
						error: function() {
							alert('failure');
						}
					});
				}
			});

			$('.modal-text-input').val(product_comments.text());
		});
	});
}

/* Show product description in a popover */
function show_product_description_event()
{
	/* Append product description to popover element */
	$('.description').each(function(){

		/* Unbind previous event */
		$(this).unbind();
		$(this).on('touchend', function(){
			$('.my-popover .content-block').children().remove();
			$('.my-popover .content-block').append($(this).find('span').clone().removeClass('hidden'));
		});
	});
}

/* Update product quantity events */
function update_product_quantity_events()
{
	/* increase product quantity event*/
	$('.fa-minus').each(function(){

		/* Unbind previous event */
		$(this).unbind();
		$(this).on('touchend', function(){
			quantity_change($(this).next(), '-');
		})
	});

	/* decrease product quantity event*/
	$('.fa-plus').each(function(){

		/* Unbind previous event */
		$(this).unbind();
		$(this).on('touchend', function(){
			quantity_change($(this).prev(), '+');
		})
	});
}

/* Complete order modal */
function complete_order()
{
	$('.complete-order').on('click', function () {
		var complete_order_btn = $(this);
		myApp.modal({
			title:  'Εξόφληση',
			text: '<div>Σύνολο: <span class="total-cost">' + complete_order_btn.text() + '<i class="fa fa-eur"></i></span></div>',
			buttons: [
			{
				text: 'αργοτερα',
				onClick: function() {
					custom_notification('Επιλέξατε εξόφληση αργότερα','κλεισιμο');
				}
			},
			{
				text: 'εξοφληση',
				onClick: function() {
					myApp.modal({
						title:  'Επιβεβαίωση εξόφλησης',
						buttons: [
						{
							text: 'ακυρωση',
							onClick: function() {}
						},
						{
							text: 'εξοφληση',
							onClick: function() {
								custom_notification('Η παραγγελία εξοφλήθη','κλεισιμο');
								//εδω function η οποια θα κανει ολοκληρωση παραγγελιας ωστε αυτην να εμφανιζεται στο καταστημα
								complete_order_btn.attr('disabled', true);
							}
						},
						]
					})
				}
			}
			]
		})
	});
}

/* Product quantity change */
function quantity_change(element, action)
{
	var current_quantity = parseInt(element.text(), 10);
	var order_product_record_id = element.parent().parent().find('.action3').data('product_record_id');
	var order_total_price = parseFloat($('.order-total-price').text(), 10);
	var order_product_price = parseFloat(element.parent().parent().parent().find('.product-price').text(), 10);

	if (action == '+')
	{
		current_quantity++;
		$('.order-total-price').text(order_total_price + order_product_price);
	}
	else
	{
		current_quantity--;
		$('.order-total-price').text(order_total_price - order_product_price);
	}

	if (element.parent().parent().hasClass('update-product') && current_quantity > 0)
	{
		$.ajax({
			type: 'POST',
			url: '/orders/ajax_update_order_product',
			data: {'order_product_record_id': order_product_record_id, 'quantity': current_quantity},
			async: false,
			success: function() {		
				element.text(current_quantity);
			},
			error: function() {
				alert('failure');
			}
		});
	}
	else
	{
		if (current_quantity > 0) element.text(current_quantity);
		element.parent().siblings('.add-product').data('quantity', current_quantity);
	}
}

/* Get tables list */
function get_tables()
{
	var tables;
	$.ajax({
		type: 'POST',
		url: '/store_tables/ajax_get_tables_for_waiter',
		async: false,
		success: function(response) {		
			tables = JSON.parse(response);
		},
		error: function() {
			alert('failure');
		}
	});
	
	return tables;
}

/* Close product swipe actions */
function close_swipe(element)
{
	element.removeClass('swipeout-opened');
	element.find('.swipeout-content').removeAttr('style');
	element.find('.swipeout-action-left').removeClass('swipeout-actions-opened');
	element.find('a').removeAttr('style');
}

/* Load order products */
function order_products(order_record_id)
{
	$.ajax({
		type: 'POST',
		url: '/orders/ajax_order_products',
		data: {'order_record_id' : order_record_id},
		async: false,
		success: function(response) {		
			$('#order-products').html(response);
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Remove product from current order */
function delete_product(order_product)
{	
	var order_total_price = parseFloat($('.order-total-price').text(), 10);
	var order_product_price = parseFloat(order_product.find('.product-price').text(), 10);
	var order_product_quantity = parseInt(order_product.find('.product-quantity').text(), 10)

	$.ajax({
		type: 'POST',
		url: '/orders/ajax_delete_order_product',
		data: {'order_product_record_id' : order_product.data('order_product_record_id')},
		async: false,
		success: function(response) {		
			order_product.remove();
			$('.order-total-price').text(order_total_price - (order_product_quantity * order_product_price));
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Table select picker */
function select_table(picker, order_record_id)
{
	var order_table_caption = 0;
	var picker = myApp.picker({
		input: picker,
		cols: [
			{
				textAlign: 'center',
				rotateEffect: true,
				values: get_tables(),
				onChange: function (){
					order_table_caption = picker.cols[0].value;
					/* Unbind previous event */
					$('.close-picker').unbind();
					$('.close-picker').on('touchend', function(){
						save_order_table(order_table_caption, order_record_id);
					});
				}
			}
		]
	});
}

/* Save order table in current order */
function save_order_table(order_table_caption, order_record_id)
{
	$.ajax({
		type: 'POST',
		url: '/orders/ajax_save_order_table',
		data: {'order_table_caption' : order_table_caption, 'order_record_id' : order_record_id},
		async: false,
		success: function(response) {		
			$('.complete-order').removeAttr('disabled');
		},
		error: function() {
			alert('failure');
		}
	});
}