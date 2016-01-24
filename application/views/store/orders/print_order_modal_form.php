<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel"><?=$modal_title?></h4>
</div>
<div class="modal-body">
	<div class="table-responsive">
		<ul class="list-unstyled">
			<li>Σερβιτόρος: <?=$order->user_info->lastname . ' ' . $order->user_info->firstname?></li>
			<li>Τραπέζι: <?=$order->store_table_info->caption?></li>
			<li>Ωρα παραγγελίας: <?=substr($order->start_date, 10)?></li>
		</ul>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Όνομα</th>
					<th>Ποσότητα</th>
					<th>Κόστος</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($order->order_products as $key => $product){?>
				<tr>
					<th scope="row"><?=$key+1?></th>
					<td><?=$product->product_info->name?></td>
					<td>x<?=$product->quantity?></td>
					<td><?=$product->quantity * $product->product_info->price?> €</td>
				</tr>
<?php }?>
				<tr>
					<th colspan="3">ΣΥΝΟΛΙΚΟ ΚΟΣΤΟΣ</th>
					<th><?=$order->total_price?> €</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-success btn-group-justified print"><i class="fa fa-print fa-lg fa-fw"></i>Εκτύπωση</button>   
</div>

<script>
	$('.print').on('click', function(){
		$('.modal-body').printArea();
	});
</script>