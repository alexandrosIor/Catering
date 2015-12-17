/* Add product comment modal */
$$('.add-comment').each(function(){
	var comments = $(this).parent().siblings('.add-product');

	$(this).on('touchend', function () {
		myApp.prompt('', 'Σχόλια', function(value){
			$(comments).data('comments', value);
		});
	});
});

/* increase product quantity event*/
$('.fa-minus').each(function(){
	$(this).on('touchend', function(){
		quantity_change($(this).next(), '-');
	})
});

/* decrease product quantity event*/
$('.fa-plus').each(function(){
	$(this).on('touchend', function(){
		quantity_change($(this).prev(), '+');
	})
	
});

/* Append product description to popover element */
$('.description').each(function(){
	$(this).on('touchend', function(){
		$('.my-popover .content-block').children().remove();
		$('.my-popover .content-block').append($(this).find('span').clone().removeClass('hidden'));
	});
});

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
	/* select table picker event */
	select_table('#table-picker', order_record_id);

	/* complete order button event */
	complete_order();

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
	var current_val = parseInt(element.text(), 10);
	if (action == '+')
	{
		current_val++;
	}
	else
	{
		if (current_val > 1) current_val--;
	}

	element.text(current_val);
	element.parent().siblings('.add-product').data('quantity', current_val);
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

	$.ajax({
		type: 'POST',
		url: '/orders/ajax_delete_order_product',
		data: {'order_product_record_id' : order_product.data('order_product_record_id')},
		async: false,
		success: function(response) {		
			order_product.remove();
			$('.order-total-price').text(order_total_price - order_product_price);
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