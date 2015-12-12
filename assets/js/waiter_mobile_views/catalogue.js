// Add product comment modal 
$$('.add-comment').on('click', function () {
		myApp.prompt('', 'Σχόλια');
});

// Change product quantity
$('.fa-minus').each(function(){
	$(this).on('click', function(){
		quantity_change($(this).next(), '-');
	})
});

$('.fa-plus').each(function(){
	$(this).on('click', function(){
		quantity_change($(this).prev(), '+');
	})
	
});

// Append product description to popover element
$('.description').each(function(){
	$(this).on('click', function(){
		$('.my-popover .content-block').children().remove();
		$('.my-popover .content-block').append($(this).find('span').clone().removeClass('hidden'));
	});
});

// Add product to new order    !!πρεπει να αλλαξει το quantity change για να λειτουργει και μετα το append , επισης να δημιουργηθει η φορμα για το submit
$('.add-product').each(function(){
	var product = $(this).parent().parent().clone();
	$(this).on('click', function(){
		$('.order-product').append(product);
		product.find('*').removeAttr('style');
		$('.order-product .add-product').removeClass('add-product').addClass('remove-product');
		$('.order-product .fa-check').removeClass('fa-check').addClass('fa-times');

		$('.remove-product').each(function(){
			$(this).on('click', function(){
				$(this).parent().parent().remove();
			})
		})
	});
});

// Complete order modal
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

// Table select picker
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

function completed_order_radio_boxes()
{
	var radio_boxes = '<div class="list-block">\
							<label class="label-radio item-content">\
								<input type="radio" name="pay" value="later" checked="checked">\
								<div class="item-media"><i class="icon icon-form-radio"></i></div>\
								<div class="item-inner"><div class="item-title">Μετά</div></div>\
							</label>\
							<label class="label-radio item-content">\
								<input type="radio" name="pay" value="now">\
								<div class="item-media"><i class="icon icon-form-radio"></i></div>\
								<div class="item-inner"><div class="item-title">Τώρα</div></div>\
							</label>\
						</div>';
	return radio_boxes;
}

function quantity_change(element, action)
{
	var current_val = parseInt(element.text(), 10);
	if (action == '+')
	{
		current_val++;
	}
	else
	{
		if (current_val > 0) current_val--;
	}

	element.text(current_val);
}

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