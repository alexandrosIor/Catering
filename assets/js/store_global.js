$(function(){
	/* Load product categories */
	$('.store-new-order').on('click', function(){
			load_catalogue();
	});
})

/* Empty modal content on close */
$('#myModal').on('hidden.bs.modal', function () {
	$(this).data('bs.modal', null);
});

/* Check for empty inputs */
function form_empty(form)
{
	var error = false;
	
	$(form).find('input').each(function(){
		if ($(this).val().length < 1)
		{
			$(this).parent().addClass('has-error');
			$(this).on('click', function(){
				$(this).parent().removeClass('has-error');
			});
			error = true;
		}
		else if ($(this).attr('type') == 'email')
		{
			if (!is_valid_email($(this).val()))
			{
				$(this).parent().addClass('has-error');
				$(this).on('click', function(){
					$(this).parent().removeClass('has-error');
				});
				error = true;
			}
		}
	});

	return error;
}

/* Check for correct email format */
function is_valid_email(email) {
	var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
	return pattern.test(email);
};

/* Notification sound for new orders */
function notification_sound(sound)
{
	var notification = new Audio('assets/sounds/'+sound+'.mp3');
	notification.play();
}

/* Toastr notification messages */
function toastr_notification(type, title, message)
{
	Command: toastr[type](message, title);

	toastr.options = {
  		"closeButton": true,
  		"debug": false,
  		"newestOnTop": true,
  		"progressBar": false,
  		"positionClass": "toast-top-right",
  		"preventDuplicates": true,
  		"showDuration": "300",
  		"hideDuration": "0",
  		"timeOut": "0",
  		"extendedTimeOut": "0",
  		"showEasing": "swing",
  		"hideEasing": "linear",
  		"showMethod": "fadeIn",
  		"hideMethod": "fadeOut"
	}
}

/* Close shift alert popup */
$('.store_close-shift').on('click', function(){
	swal({   
		title: '<span class="close-shift-alert">Κλείσιμο βάρδιας</span>',   
		text: 'Εισάγετε το συνολικό ποσό του ταμείου σας:',   
		type: 'input',
		html: true,  
		showCancelButton: true,   
		closeOnConfirm: false,   
		animation: 'slide-from-top',   
		inputPlaceholder: 'Σύνολο',
		confirmButtonText: 'Καταχώρηση',   
		cancelButtonText: 'Ακύρωση',
		}, 
		function(inputValue){ 

			if (inputValue === false) return false;      
			if (inputValue === "") {     
				swal.showInputError("Παρακαλώ εισάγετε το ποσό του ταμείου σας!");     
				return false  
			}

			$.ajax({
				type: 'POST',
				url: '/logout/close_shift',
				async: false,
				data: {'turnover_delivered' : inputValue},
				dataType: 'json',
				success: function(data) {		
					swal({   
						title: "Η βάρδια έκλεισε!",   
						text: 'Το ταμείο σας: ' + data.turnover_delivered + '<br/>Σύνολο ταμείου: ' + data.turnover_calculated + '<br/>Διαφορα ταμείου: ' + data.turnover_diff,   
						type: "success",
						html: true, 
						showCancelButton: false,     
						confirmButtonText: "Κλείσιμο",   
						closeOnConfirm: false 
						}, 
						function(){
							window.location = '/logout'; 
						}
					);
				},
				error: function() {
					alert('failure');
				}
			});

		}
	);
});

/* Input mask to prevent from inserting invalid characters */
$('.sweet-alert input').mask('0ZZZ.ZZ',{
	translation: {
		'Z': {
			pattern: /[0-9]/, optional: true
		}
	}
});

/* Load product categories */
function load_catalogue()
{
	$.ajax({
		type: 'POST',
		url: '/store/ajax_load_catalogue',
		async: false,
		success: function(data) {		
			$('.catalogue-container').children().remove();
			$('.catalogue-container').append(data);
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Initialize quantity change events on elements */
function update_product_quantity()
{
	$('.sub-quantity').each(function(){
		$(this).unbind();
		$(this).on('click', function(){
			quantity_change($(this).next(), '-');
		});
	});	
	$('.add-quantity').each(function(){
		$(this).unbind();
		$(this).on('click', function(){
			quantity_change($(this).prev(), '+');
		});
	});
}

/* Product quantity change */
function quantity_change(element, action)
{
	var current_quantity = parseInt(element.text(), 10);
	var order_total_price = parseFloat($('.order-total-price').text(), 10);
	var order_product_price = parseFloat(element.parent().parent().find('.price').text(), 10);
	var new_price = 0;

	if (action == '+')
	{
		current_quantity++;
		new_price = order_total_price + order_product_price;
		if ($(element).closest('ul').hasClass('order'))
		{
			$('.order-total-price').text(new_price.toFixed(2));
		}
	}
	else
	{
		if (current_quantity > 1)
		{
			current_quantity--;
			new_price = order_total_price - order_product_price;
			if ($(element).closest('ul').hasClass('order'))
			{
				$('.order-total-price').text(new_price.toFixed(2));
			}
		}
	}

	$(element).text(current_quantity);
	$(element).closest('.product').find('input#quantity').val(current_quantity);
}

/* Opens a popover to add comments */
function comments_popover(elements)
{
	$(elements).each(function(){
		var product = $(this).closest('.product');
		var popover = $(this);

		$(popover).unbind();
		$(popover).on('click', function(){
			$(this).popover({
				placement:'top',
				trigger:'manual',
				html:true,
				content:'<form><textarea class="form-control" placeholder="Εισάγετε σχόλια">'+ $(product).find('input#comments').val() +'</textarea><div class="btn btn-success close-popover btn-group-justified">αποθήκευση</div></form>'
			});
			$(this).popover('toggle');
			$(this).next().find('textarea').on('change', function(){
				$(product).find('input#comments').val($(this).val());
			});
			$('.close-popover').on('click', function(){
				popover.popover('toggle');
			});
		});
	});
}

/* Add product to order */
function add_product(elements)
{
	$(elements).each(function(){
		$(this).on('click', function(){
			var order_product = $(this).parent().clone();
			$(order_product).find('.add-product').removeClass('btn-primary add-product').addClass('btn-danger remove-product').children(':first').removeClass('fa-plus').addClass('fa-minus');

			if($('.order .product[data-product_record_id="' + $(this).parent().data('product_record_id') + '"]').length == 0)
			{
				$('.order').append(order_product);
			}
			else
			{
				var new_quantity = parseInt($(this).parent().find('.quantity').text(), 10);
				var old_quantity = parseInt($('.order .product[data-product_record_id="' + $(this).parent().data('product_record_id') + '"]').find('.quantity').text(), 10);
				new_quantity = old_quantity + new_quantity;

				$('.order .product[data-product_record_id="' + $(this).parent().data('product_record_id') + '"]').find('.quantity').text(new_quantity);
				$('.order .product[data-product_record_id="' + $(this).parent().data('product_record_id') + '"]').find('input#quantity').val(new_quantity);
			}

			var quantity = parseInt($(order_product).find('.quantity').text(), 10);
			var price = parseFloat($(order_product).find('.price').text(), 10);
			var order_total_price = parseFloat($('.order-total-price').text(), 10);
			order_total_price = order_total_price + (quantity * price);

			$('.order-total-price').text(order_total_price.toFixed(2));

			/* events to be initialized on add new product to order */
			update_product_quantity();
			remove_product(order_product.find('.remove-product'));

			if ($('.store-table').val() != 0 && $('.waiter').val() != 0 && $('ul.order').has('li').length)
			{	
				$('.complete-order').removeAttr('disabled');
			}
			else
			{
				$('.complete-order').attr('disabled', 'true');
			}
		});
	});

	/* Initialize popover */
	comments_popover($('.product [data-toggle="popover"]'));
}

/* Remove product from order */
function remove_product(elements)
{
	$(elements).each(function(){
		$(this).unbind();
		$(this).on('click', function(){
			var quantity = parseInt($(this).parent().find('.quantity').text(), 10);
			var price = parseFloat($(this).find('.price').text(), 10);
			var order_total_price = parseFloat($('.order-total-price').text(), 10);
			order_total_price = order_total_price - (quantity * price);

			$('.order-total-price').text(order_total_price.toFixed(2));

			$(this).parent().remove();

			if ($('.store-table').val() != 0 && $('.waiter').val() != 0 && $('ul.order').has('li').length)
			{	
				$('.complete-order').removeAttr('disabled');
			}
			else
			{
				$('.complete-order').attr('disabled', 'true');
			}
		});
	});

	/* Initialize popover */
	comments_popover($('.product [data-toggle="popover"]'));
}

/* Submit new order */
function complete_order(form)
{
	$.ajax({
		type: 'POST',
		url: '/store/ajax_complete_order',
		async: false,
		data: form.serialize(),
		success: function(data) {		
			$('.cd-nav-container').removeClass('is-visible');
			$('.cd-overlay').removeClass('is-visible');
			$('.page-header-fixed').removeClass('navigation-visible');
			$('main.page-content').removeClass('scale-down');

			setTimeout(function(){location.reload()},500);
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Initialize all needed events at new order view */
function init_new_order_modal()
{
	add_product($('.add-product'));
	update_product_quantity();

	$('.waiter').on('change', function(){
		if ($(this).val() != 0 && $('.store-table').val() != 0 && $('ul.order').has('li').length)
		{	
			$('.complete-order').removeAttr('disabled');
		}
		else
		{
			$('.complete-order').attr('disabled', 'true');
		}
	});	
	$('.store-table').on('change', function(){
		if ($(this).val() != 0 && $('.waiter').val() != 0 && $('ul.order').has('li').length)
		{	
			$('.complete-order').removeAttr('disabled');
		}
		else
		{
			$('.complete-order').attr('disabled', 'true');
		}

	});

	$('.complete-order').on('click', function(e){
		e.preventDefault();
		complete_order($('form.new-order'));
	})
}