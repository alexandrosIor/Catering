$(document).ready(function() {
		
	/* Datatables */
	$('#store-tables').DataTable({
		'responsive': true,
		'ajax': '/store_tables/datatable_store_tables_data',
		'initComplete': function(settings, json) {
			events();
		}
	});

});

/* Save new store table */
function save_store_table(element)
{
	$.ajax({
		type: 'POST',
		url: '/store_tables/ajax_save_store_table',
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

/* Change store table status enable or disable it without deleting */
function change_status(element)
{
	var store_table_record_id = element.parent().parent().siblings(":first").text();
	var status = 'unchecked';
	if ($(element).is(':checked'))
	{
		status = 'checked';
	}

	$.ajax({
		type: 'POST',
		url: '/store_tables/ajax_change_status',
		async: false,
		data: {'store_table_record_id' : store_table_record_id, 'status' : status},
		success: function(data) {		

		},
		error: function() {
			alert('failure');
		}
	});
}

/* Permanently delete user */
function delete_store_table(element)
{
	var store_table_record_id = element.parent().siblings(":first").text();
	swal({   
		title: "Είστε σίγουροι?",   
		text: "Το τραπέζι θα διαγραφή μόνιμα.",   
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
				url: '/store_tables/ajax_delete_store_table',
				async: false,
				data: {'store_table_record_id' : store_table_record_id},
				success: function(data) {		
					element.parent().parent().remove();
					swal({   
						title: "Διεγράφη!",   
						text: "Το τραπέζι διεγράφη επιτυχώς.",   
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
				text: "Η διαγραφή του τραπεζιού ακυρώθηκέ.",   
				type: "error",     
				confirmButtonColor: "#22BAA0"
			});  
		} 
	});
}

/* Initialize all needed event */
function events()
{
	/* Editables */
	$.fn.editable.defaults.mode = 'inline';

	/* Update store table info via editable */
	$('#store-tables td a').each(function(){
		var store_table_record_id = $(this).parent().siblings(":first").text();
		var name = $(this).data('column_name');
		$(this).editable({
			url: '/store_tables/update_store_table',
			type: 'text',
			pk: store_table_record_id,
			name: name
		});
	});

	/* Status checkbox, type switchery */
	var n = Array.prototype.slice.call(document.querySelectorAll(".js-switch"));
	n.forEach(function(e) {
		if(!$(e).next().hasClass('switchery'))
		{
			new Switchery(e, {
			color: "#449d44"
			});
		}
	});

	/* Change user status event */
	$('.js-switch').each(function(){
		$(this).on('change', function(){
			change_status($(this));
		});
	});

	/* table delete event */
	$('.delete-store-table').each(function(){
		$(this).on('click', function(){
			delete_store_table($(this));
		});
	});

	/* To initialize events and plugins when datatable updates */
	$(this).on( 'draw.dt', function () {
		events();
	} );
}