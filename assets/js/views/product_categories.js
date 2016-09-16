
$(document).ready(function() {

	/* Datatables*/
	$('#product_categories').DataTable({
		'responsive': true,
		'ajax': '/catalogue/datatable_product_categories_data'
	});

	/* to init events and plugins when datatable updates */
	$(this).on( 'draw.dt', function () {
		events();
	} );

});

/* save new product category */
function save_category(element)
{
	$.ajax({
		type: 'POST',
		url: '/catalogue/ajax_save_product_category',
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

/* get available product categories */
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

/* change product_category status enable or disable without deleting it*/
function change_status(element)
{
	var product_category_record_id = element.parent().parent().siblings(":first").text();
	var status = 'unchecked';
	if ($(element).is(':checked'))
	{
		status = 'checked';
	}

	$.ajax({
		type: 'POST',
		url: '/catalogue/ajax_change_status',
		async: false,
		data: {'product_category_record_id' : product_category_record_id, 'status' : status},
		success: function(data) {		

		},
		error: function() {
			alert('failure');
		}
	});
}

/* permanently delete product_category*/
function delete_product_category(element)
{
	var product_category_record_id = element.parent().siblings(":first").text();
	swal({   
		title: "Είστε σίγουροι?",   
		text: "Η κατηγορία θα διαγραφή μόνιμα, και από όλες τις υποκατηγορίες της θα αφαιρεθεί η γονική κατηγορία.",   
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
				url: '/catalogue/ajax_delete_product_category',
				async: false,
				data: {'product_category_record_id' : product_category_record_id},
				success: function(data) {		
					element.parent().parent().remove();
					swal({   
						title: "Διεγράφη!",   
						text: "Η κατηγορίας διεγράφη επιτυχώς.",   
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
				text: "Η διαγραφή κατηγορίας ακυρώθηκέ.",   
				type: "error",     
				confirmButtonColor: "#22BAA0"
			});  
		} 
	});
}

/* initialize all needed event */
function events()
{
	/* editables */
	$.fn.editable.defaults.mode = 'inline';

	/* update product_category data via editable */
	$('a.category').each(function(){
		var product_category_record_id = $(this).parent().siblings(":first").text();
		var name = $(this).data('column_name');
		$(this).editable({
			url: '/catalogue/update_product_category',
			pk: product_category_record_id,
			type: 'select',
			name: name,
			source: function() {return get_product_categories();},
		});
	});

	/* update product_category  parent via editable */
	$('#product_categories td a').each(function(){
		var product_category_record_id = $(this).parent().siblings(":first").text();
		var name = $(this).data('column_name');
		$(this).editable({
			url: '/catalogue/update_product_category',
			type: 'text',
			pk: product_category_record_id,
			name: name
		});
	});
	
	/* status checkbox type switchery */
	var n = Array.prototype.slice.call(document.querySelectorAll(".js-switch"));
	n.forEach(function(e) {
		if(!$(e).next().hasClass('switchery'))
		{
			new Switchery(e, {
			color: "#449d44"
			});
		}
	});

	/* change product_category status event */
	$(document).on('change','.js-switch', function(e){
		e.stopImmediatePropagation(e);
		change_status($(this));
	});

	/* product_category delete event */
	$(document).on('click','.delete-product-category', function(e){
		e.stopImmediatePropagation(e);
		delete_product($(this));
	});
}