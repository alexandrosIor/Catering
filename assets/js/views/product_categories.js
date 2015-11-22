$(document).ready(function() {
		
/* editables */
	$.fn.editable.defaults.mode = 'inline';
	
	/* θα περνω τις κατηγοριες με ajax call */
	var source = [{'value': 1, 'text': 'Ποτά'}, {'value': 2, 'text': 'Ορεκτικά'}];
	
	$('.category a').editable({
			url: '#',
			pk: 1,
			type: 'select',
			source: function() {return source;},
	});

	$('#product_categories td a').editable({
				url: '#',
				type: 'text',
				pk: 1,
				name: 'username',
				title: 'Enter username'
	});

	// Datatables
	$('#product_categories').DataTable();
		
});

