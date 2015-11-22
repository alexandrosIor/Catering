$(document).ready(function() {
		
	/* Datatables*/
	$('#products').DataTable({
		'responsive': true,
		'ajax': '/catalogue/datatable_products_data',
		'initComplete': function(settings, json) {
			/* editables */
			$.fn.editable.defaults.mode = 'inline';

			/* update product data via editable */
			$('a.category').each(function(){
				var product_category_record_id = $(this).parent().siblings(":first").text();
				var name = $(this).data('column_name');
				$(this).editable({
					url: '/catalogue/update_product',
					pk: product_category_record_id,
					type: 'select',
					name: name,
					source: function() {return get_product_categories();},
				});
			});

			/* update product category via editable */
			$('#products td a').each(function(){
				var product_category_record_id = $(this).parent().siblings(":first").text();
				var name = $(this).data('column_name');
				$(this).editable({
					url: '/catalogue/update_product',
					type: 'text',
					pk: product_category_record_id,
					name: name
				});
			});

			/* status checkbox type switchery */
			var n = Array.prototype.slice.call(document.querySelectorAll(".js-switch"));
			n.forEach(function(e) {
				new Switchery(e, {
				color: "#449d44"
				});
			});

			/* change product status event */
			$('.js-switch').each(function(){
				$(this).on('change', function(){
					change_status($(this));
				});
			});

			/* product delete event */
			$('.delete-product').each(function(){
				$(this).on('click', function(){
					delete_product($(this));
				});
			});
		}
	});

});

function save_product(element)
{
	$.ajax({
		type: 'POST',
		url: '/catalogue/ajax_save_product',
		async: false,
		data: element.serialize(),
		success: function(data) {		
			$('#myModal').modal('hide');
			element[0].reset();
			location.reload();
		},
		error: function() {
			alert('failure');
		}
	});
}

function get_product_categories()
{	var categories;
	$.ajax({
		type: 'POST',
		url: '/catalogue/editable_product_categories_data',
		async: false,
		success: function(response) {		
			categories = JSON.parse(response);
		},
		error: function() {
			alert('failure');
		}
	});
	return categories;
}

function change_status(element)
{
	var product_record_id = element.parent().parent().siblings(":first").text();
	var status = 'unchecked';
	if ($(element).is(':checked'))
	{
		status = 'checked';
	}

	$.ajax({
		type: 'POST',
		url: '/catalogue/ajax_change_status',
		async: false,
		data: {'product_record_id' : product_record_id, 'status' : status},
		success: function(data) {		

		},
		error: function() {
			alert('failure');
		}
	});
}

function delete_product(element)
{
	var product_record_id = element.parent().siblings(":first").text();
	swal({   
		title: "Είστε σίγουροι?",   
		text: "Το προϊόν θα διαγραφή μόνιμα.",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",  
		confirmButtonText: "Διαγραφή",   
		cancelButtonText: "Ακύρωση",   
		closeOnConfirm: false,   
		closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) { 
			$.ajax({
				type: 'POST',
				url: '/catalogue/ajax_delete_product',
				async: false,
				data: {'product_record_id' : product_record_id},
				success: function(data) {		
					element.parent().parent().remove();
					swal({   
						title: "Διεγράφη!",   
						text: "Το προϊόν διεγράφη επιτυχώς.",   
						type: "success",     
						confirmButtonColor: "#22BAA0"
					});
				},
				error: function() {
					alert('failure');
				}
			});    
		} 
		else {
			swal({   
				title: "Ακύρωση!",   
				text: "Η διαγραφή του προϊόντος ακυρώθηκέ.",   
				type: "error",     
				confirmButtonColor: "#22BAA0"
			});  
		} 
	});
}