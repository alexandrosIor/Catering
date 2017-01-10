$(document).ready(function() {
 
	/* initialize DataTable */
	var table = $('#shift-orders').DataTable({
		'responsive': true,
		'ajax': '/shifts/datatable_shift_details_data/' + $('#shift-orders').data('shift_record_id'),
		'initComplete': function(settings, json) {
			//events();
		}
	});

});