<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel"><?=$modal_title?></h4>
</div>
<div class="modal-body">
	<div class="tabs-left" role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-pills" role="tablist">
			<li role="presentation" class="active"><a href="#all" role="tab" data-toggle="tab">Όλα</a></li>
<?php foreach ($order_products_categorized as $key => $category){?>
			<li role="presentation"><a href="#<?=preg_replace('/\s+/', '', $key)?>" role="tab" data-toggle="tab"><?=$key?></a></li>
<?php }?>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
<?php foreach ($order_products_categorized as $key => $products){?>
			<div role="tabpanel" class="tab-pane fade in" id="<?=preg_replace('/\s+/', '', $key)?>">
				<table class="table order-details">
					<thead>
						<tr>
							<th>ποσότητα</th>
							<th>όνομα</th>
							<th>σχόλια</th>
							<th>κατάσταση</th>
						</tr>
					</thead>
					<tbody>
<?php 	foreach ($products as $key => $product){?>
						<tr>
							<td> <span class="quantity"><?=$product->quantity?>x</span></td>
							<td> <span class="name"><?=$product->product_info->name?></span></td>
							<td> 
								<a href="#" title="Σχόλια" data-toggle="popover" data-placement="bottom" data-content="<?=$product->comments?>">
									<span class="comments"><?=isset($product->comments) ? '<i class="fa fa-comment fa-lg"></i>' : ''?></span>
								</a>
							</td>
							<td>
								<div class="ios-switch switch-md">
									<input type="checkbox" name="status" class="js-switch compact-menu-check status" data-order_product_record_id="<?=$product->record_id?>" <?=($product->deleted_at) ? 'checked="true"' : ''?>>
								</div>
							</td>
						</tr>
	<?php }?>
					</tbody>
				</table>
			</div>
<?php }?>
			<div role="tabpanel" class="tab-pane fade active in" id="all">
				<table class="table order-details">
					<thead>
						<tr>
							<th>ποσότητα</th>
							<th>όνομα</th>
							<th>σχόλια</th>
							<th>κατάσταση</th>
						</tr>
					</thead>
					<tbody>
<?php 	foreach ($order_products as $key => $product){?>
						<tr>
							<td> <span class="quantity"><?=$product->quantity?>x</span></td>
							<td> <span class="name"><?=$product->product_info->name?></span></td>
							<td> 
								<a href="#" title="Σχόλια" data-toggle="popover" data-placement="bottom" data-content="<?=$product->comments?>">
									<span class="comments"><?=isset($product->comments) ? '<i class="fa fa-comment fa-lg"></i>' : ''?></span>
								</a>
							</td>
							<td>
								<div class="ios-switch switch-md">
									<input type="checkbox" class="js-switch compact-menu-check status" data-order_product_record_id="<?=$product->record_id?>" <?=($product->deleted_at) ? 'checked="true"' : ''?>>
								</div>
							</td>
						</tr>
	<?php }?>
						<tr>
							<td colspan="4">
								<div class="btn btn-success pull-right complete-all" data-order_record_id="<?=$product->order_record_id?>">ολοκλήρωση όλων</div>							
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default print"><i class="fa fa-print fa-lg m-r-xs"></i>Εκτύπωση</button>
</div>

<script>
	$(function(){
		/* initialize popover to show order product comments */
		$('[data-toggle="popover"]').popover();

		/* store all switchery elements in array */
		var switchery = [];
		$('.status').each(function(){
			switchery.push(new Switchery(this));
			$(this).on('change', function(){
				change_order_product_status($(this).data('order_product_record_id'));
			});
		});
		
		//TODO: να δημιουργηθει σωστο printing template
		$('.print').on('click', function(){
			$('div.active').printArea();
		});
		
		/* Set all product as completed */
		$('.complete-all').on('click', function(){
			
			$('#all .status').each(function(){
				if (!$(this).is(':checked'))
				{
					change_order_product_status($(this).data('order_product_record_id'));
				}
			});

			$(switchery).each(function(){
				var temp_var = $(this)[0].element;
				if (!$(temp_var).is(':checked'))
				{
					setSwitchery(this, true);
				}
			});
		});

	});
</script>