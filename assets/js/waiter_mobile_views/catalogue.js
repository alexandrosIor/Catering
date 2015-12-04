$$('.add-comment').on('click', function () {
		myApp.prompt('', 'Σχόλια');
});

$('.fa-minus').each(function(){
	// - quantity
});

$('.fa-plus').each(function(){
	// + quantity
});

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

var pickerDevice = myApp.picker({
	input: '#picker-device',
	cols: [
		{
			textAlign: 'center',
			rotateEffect: true,
			values: ['Τραπέζι 1', 'Τραπέζι 2', 'Τραπέζι 3', 'Τραπέζι 4', 'Τραπέζι 5', 'Τραπέζι 6'	],
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