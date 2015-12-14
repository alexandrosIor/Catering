$(document).ready(function() {
		
	$('#shifts tfoot th:not(:last)').each( function (i) {
		var title = $(this).text();
		$(this).html( '<input class="form-control" type="text" placeholder="'+title+'" />' );
	} );
 
	/* initialize DataTable */
	var table = $('#shifts').DataTable({
		'responsive': true,
		'ajax': '/shifts/datatable_shifts_data',
		'initComplete': function(settings, json) {
			//events();
			add_search_fields(table);
		}
	});

 	//add_search_fields(table);

});

/* apply search fields on data Table */
function add_search_fields(table)
{
	/* remove default search field */
	$('.dataTables_filter').remove();

	table.columns().every( function () {
		var that = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function ()
		{
			if ( that.search() !== this.value )
			{
				that.search( this.value ).draw();
			}
		});
	});

}