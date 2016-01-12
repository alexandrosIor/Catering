$(function(){

	init();

	/* Load waiter orders on page back */
	myApp.onPageBack('catalogue', function (){
		init();
	});

})

/* Initialize element events */
function init()
{
	load_incomplete_waiter_orders($('#incomplete-orders'));
	set_timer($('.order-timer'));
	incomplete_order_details($('.incomplete-order'));

	$('#unpaid-orders').on('show', function () {
		load_unpaid_waiter_orders($('#unpaid-orders'));
		set_timer($('.order-timer'));
		incomplete_order_details($('.incomplete-order'));
	});

	$('.chip-delete').on('click', function (e) {
		e.preventDefault();
		var chip = $(this).parents('.chip');
		myApp.confirm('Η παραγγελία θα αφαιρεθεί από την λίστα!', function () {
			chip.remove();
			order_served(chip.data('order_record_id'))
		});
	});	
}

/* Open a popup with order products details */
function incomplete_order_details(incomplete_orders)
{
	incomplete_orders.each(function(){

		var order_record_id = $(this).data('order_record_id');

		$(this).children().first().on('click', function(){
			order_products_popup(order_record_id);
		});
	});
}

/* Set the order as served */
function order_served(order_record_id)
{
	$.ajax({
		type: 'POST',
		url: '/waiter/ajax_order_served',
		data: {'order_record_id': order_record_id},
		async: false,
		success: function(data) {		
			console.log('done');
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Set the timer at order panels */
function set_timer(timer)
{
	Date.prototype.addSeconds= function(h){
		this.setSeconds(this.getSeconds()+h);
		return this;
	}

	$(timer).each(function(){
		var date = new Date().addSeconds(-$(this).text()) / 1000;

		$(this).countid({
			clock: true,
			dateTime: date,
			dateTplRemaining: "%M:%S",
			dateTplElapsed: "%M:%S",
			complete: function( el ){
				
			}
		});
	});
}

/* Load all incomplete waiter orders */
function load_incomplete_waiter_orders(container)
{
	$(container).children().remove();

	$.ajax({
		type: 'POST',
		url: '/waiter/ajax_load_incomplete_orders',
		async: false,
		success: function(data) {		
			$(container).append(data);
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Load all unpaid waiter orders */
function load_unpaid_waiter_orders(container)
{
	$(container).children().remove();

	$.ajax({
		type: 'POST',
		url: '/waiter/ajax_load_unpaid_orders',
		async: false,
		success: function(data) {		
			$(container).append(data);
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Open order products in popup */
function order_products_popup(order_record_id)
{
	$.ajax({
		type: 'POST',
		url: '/waiter/ajax_get_order',
		data: {'order_record_id' : order_record_id},
		async: false,
		success: function(data) {
			myApp.popup($('.my-popup'));
			$('.my-popup').children().remove();
			$('.my-popup').append(data);

			order_product_events_init();
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Order product event initialize */
function order_product_events_init()
{
	/* Remove products from the order */
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

	/* Update product quantity events */
	update_product_quantity_events();

	/* Show product description in a popover */
	show_product_description_event();

	/* Add comment on product modal */
	add_comment_element_event();
}

/* Update product quantity events */
function update_product_quantity_events()
{
	/* Increase product quantity event*/
	$('.fa-minus').each(function(){

		/* Unbind previous event */
		$(this).unbind();
		$(this).on('touchend', function(){
			quantity_change($(this).next(), '-');
		})
	});

	/* Decrease product quantity event*/
	$('.fa-plus').each(function(){

		/* Unbind previous event */
		$(this).unbind();
		$(this).on('touchend', function(){
			quantity_change($(this).prev(), '+');
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
			url: '/waiter_new_order/ajax_update_order_product',
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

/* Remove product from current order */
function delete_product(order_product)
{	
	var order_total_price = parseFloat($('.order-total-price').text(), 10);
	var order_product_price = parseFloat(order_product.find('.product-price').text(), 10);
	var order_product_quantity = parseInt(order_product.find('.product-quantity').text(), 10)

	$.ajax({
		type: 'POST',
		url: '/waiter_new_order/ajax_delete_order_product',
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
						url: '/waiter_new_order/ajax_update_order_product',
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