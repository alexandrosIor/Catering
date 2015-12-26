$(document).ready(function() {
		
	/* Datatables */
	$('#users').DataTable({
		'responsive': true,
		'ajax': '/users/datatable_users_data',
		'initComplete': function(settings, json) {
			events();
		}
	});

});

/* save new user */
function save_user(form)
{
	$.ajax({
		type: 'POST',
		url: '/users/ajax_save_user',
		async: false,
		data: form.serialize(),
		success: function(data) {		
			$('#myModal').modal('hide');
			form[0].reset();
			location.reload();
		},
		error: function() {
			alert('failure');
		}
	});
}

/* get available user roles */
function get_user_roles()
{	var roles;
	$.ajax({
		type: 'POST',
		url: '/users/editable_user_roles_data',
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

/* change user status enable or disable him without deleting */
function change_status(element)
{
	var user_record_id = element.parent().parent().siblings(":first").text();
	var status = 'unchecked';
	if ($(element).is(':checked'))
	{
		status = 'checked';
	}

	$.ajax({
		type: 'POST',
		url: '/users/ajax_change_status',
		async: false,
		data: {'user_record_id' : user_record_id, 'status' : status},
		success: function(data) {		

		},
		error: function() {
			alert('failure');
		}
	});
}

/* permanently delete user */
function delete_user(element)
{
	var user_record_id = element.parent().siblings(":first").text();
	swal({   
		title: "Είστε σίγουροι?",   
		text: "Ο χρήστης θα διαγραφή μόνιμα.",   
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
				url: '/users/ajax_delete_user',
				async: false,
				data: {'user_record_id' : user_record_id},
				success: function(data) {		
					element.parent().parent().remove();
					swal({   
						title: "Διεγράφη!",   
						text: "Ο χρήστης διεγράφη επιτυχώς.",   
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
				text: "Η διαγραφή του χρήστη ακυρώθηκέ.",   
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

	/* update user role data via editable */
	$('a.role').each(function(){
		var user_record_id = $(this).parent().siblings(":first").text();
		var name = $(this).data('column_name');
		$(this).editable({
			url: '/users/update_user',
			pk: user_record_id,
			type: 'select',
			name: name,
			source: function() {return get_user_roles();},
		});
	});

	/* update user info via editable */
	$('#users td a').each(function(){
		var user_record_id = $(this).parent().siblings(":first").text();
		var name = $(this).data('column_name');
		$(this).editable({
			url: '/users/update_user',
			type: 'text',
			pk: user_record_id,
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

	/* change user status event */
	$('.js-switch').each(function(){
		$(this).on('change', function(){
			change_status($(this));
		});
	});

	/* user delete event */
	$('.delete-user').each(function(){
		$(this).on('click', function(){
			delete_user($(this));
		});
	});

	/* to init events and plugins when datatable updates */
	$(this).on( 'draw.dt', function () {
		events();
	} );
}