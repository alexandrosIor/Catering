$(function(){

	init();

	/* Load waiter orders on page back , reinitialize all events*/
	myApp.onPageBack('catalogue', function (){
		$('body').find('*').off();
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

/* */
function order_payment(order_record_id, total_price)
{
	var table_caption = $('.my-popup-title span').text();
	modal = myApp.modal({
		title: 'Εξώφληση παραγγελίας',
		text: 'Συνολικό ποσό: ' + total_price,
		buttons: [
		{
			text: 'Ακύρωση',
			onClick: function() {
				$('.order-payment').removeAttr('disabled');
			}
		},
		{
			text: 'Εξώφληση',
			bold: true,
			onClick: function () {
				$.ajax({
					type: 'POST',
					url: '/waiter/ajax_order_payment',
					data: {'order_record_id': order_record_id},
					async: false,
					success: function(data) {
						myApp.alert('Η παραγγελία εξοφλήθη!');	
						$('.incomplete-order[data-order_table_caption="'+table_caption+'"]').remove();
						var unpaid_orders = parseInt($('.unpaid-orders').text());
						$('.unpaid-orders').text(unpaid_orders - 1);
						init();
					},
					error: function() {
						alert('failure');
					}
				});
			}
		},
		]
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
			$('.order-payment').on('click', function(){
				order_payment(order_record_id, $(this).find('.order-total-price').text());
				$(this).attr('disabled', true);
			});
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
						delete_order_product(order_product);
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

	/* Set product status served */
	serve_product_event();

	/* Get waiter with active shift */
	active_waiter();
}

/* Set product status served before */
function serve_product_event()
{
	$('.serve-product').each(function(){
		var product = $(this);
		var order_product_record_id = product.data('product_record_id');
		var table_caption = $('.my-popup-title span').text();

		product.on('click', function(){
			$.ajax({
				type: 'POST',
				url: '/waiter/ajax_order_product_status',
				data: {'order_product_record_id' : order_product_record_id, 'status' : 'served'},
				async: false,
				success: function(data) {		
					product.parent().parent().find('.item-title').prepend('<i class="f7-icons md completed-product-mark">check</i>');
					close_swipe(product.parent().parent());
					product.removeClass('bg-green').addClass('bg-red');
					product.find('i.f7-icons').html('undo');

					product.unbind();
					product.on('click', function(){
						unserve_product_event(product);
					});

					if (data)
					{
						$('.incomplete-order[data-order_table_caption="'+table_caption+'"] .chip-delete').removeClass('hidden');
					}
				},
				error: function() {
					alert('failure');
				}
			});
		});
	});
}

/* Set product status as unserved , only available as undo action after setting a product served */
function unserve_product_event(product)
{
	var order_product_record_id = product.data('product_record_id');
	var table_caption = $('.my-popup-title span').text();

	$.ajax({
		type: 'POST',
		url: '/waiter/ajax_order_product_status',
		data: {'order_product_record_id' : order_product_record_id, 'status' : 'unserved'},
		async: false,
		success: function() {		
			product.parent().parent().find('i.completed-product-mark').remove();
			close_swipe(product.parent().parent());
			product.removeClass('bg-red').addClass('bg-green');
			product.find('i.f7-icons').html('check');

			product.unbind();
			serve_product_event();

			if (!$('.incomplete-order[data-order_table_caption="'+table_caption+'"] .chip-delete').hasClass('hidden'))
			{
				$('.incomplete-order[data-order_table_caption="'+table_caption+'"] .chip-delete').addClass('hidden');
			}
		},
		error: function() {
			alert('failure');
		}
	});
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
	var new_price = 0;

	if (action == '+')
	{
		current_quantity++;
		new_price = order_total_price + order_product_price;
		$('.order-total-price').text(new_price.toFixed(2));
	}
	else
	{
		if (current_quantity > 1)
		{
			current_quantity--;
			new_price = order_total_price - order_product_price;
			$('.order-total-price').text(new_price.toFixed(2));
		}
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
function delete_order_product(order_product)
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
			order_total_price = order_total_price - (order_product_quantity * order_product_price);
			$('.order-total-price').text(order_total_price);

			if (order_total_price === 0)
			{
				init();
			}
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

/* Show product description in a popover */
function active_waiter()
{
	/* Unbind previous event */
	$('.transfer-order').unbind();
	$('.transfer-order').on('click', function(){

		var order_record_id = $(this).data('order_record_id');

		$.ajax({
			type: 'POST',
			url: '/waiter/ajax_active_waiters',
			async: false,
			success: function(data){		
				$('.my-popover .content-block').children().remove();
				$('.my-popover .content-block').append(data);

				$('.transfer').each(function(){
					$(this).on('click', function(){
						transfer_order(order_record_id, $(this).data('user_record_id'));
					});
				});
			},
			error: function() {
				alert('failure');
			}
		});
		$('.modal-overlay').on('click', function(){
			myApp.closeModal($('.my-popover'));
		});

	});
}

/* Transfer the given order to the given waiter */
function transfer_order(order_record_id, user_record_id)
{
	modal = myApp.modal({
		title: 'Μεταφορά παραγγελίας!',
		buttons: [
		{
			text: 'Ακυρωση'
		},
		{
			text: 'Μεταφορα',
			onClick: function () {
				$.ajax({
					type: 'POST',
					url: '/waiter/ajax_transfer_order',
					data: {'order_record_id' : order_record_id, 'user_record_id' : user_record_id},
					async: false,
					success: function(data){		
						$('.incomplete-order[data-order_record_id="' + order_record_id + '"]').remove();
						$('.modal-overlay').removeClass('modal-overlay-visible');
						$('.my-popover').css('display', 'none');
						init();
					},
					error: function() {
						alert('failure');
					}
				});
			}
		},
		]
	});
}

function close_swipe(element)
{
	element.removeClass('swipeout-opened');
	element.find('.swipeout-content').removeAttr('style');
	element.find('.swipeout-action-left').removeClass('swipeout-actions-opened');
	element.find('a').removeAttr('style');
}