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

/* Add product to new order */
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
				console.log(response);
				close_swipe($('.product'));
			},
			error: function() {
				alert('failure');
			}
		});
	});
});

/* Complete order modal */
$$('.complete-order').on('click', function () {
	  myApp.modal({
		title:  'Εξόφληση',
		text: '<div>Σύνολο: <span class="total-cost">72.60<i class="fa fa-eur"></i></span></div>', //θα παιρνω το συνολικο ποσο απο καποιο element
		buttons: [
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
						}
					},
					]
				})
			}
		},
		{
			text: 'αργοτερα',
			onClick: function() {
				custom_notification('Επιλέξατε εξόφληση αργότερα','κλεισιμο');
			}
		},
		]
	})
});

/* Table select picker */
var pickerDevice = myApp.picker({
	input: '#picker-device',
	cols: [
		{
			textAlign: 'center',
			rotateEffect: true,
			values: get_tables(),
			onChange: function (picker, country) {
				console.log(pickerDevice.cols[0].value);
			}
		}
	]
});
var col = pickerDevice.cols[0];
console.log(col.value);

/* product quantity change */
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

/* get tables list */
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

/* close product swipe actions */
function close_swipe(element)
{
	element.removeClass('swipeout-opened');
	element.find('.swipeout-content').removeAttr('style');
	element.find('.swipeout-action-left').removeClass('swipeout-actions-opened');
	element.find('a').removeAttr('style');
}