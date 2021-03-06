<div class="content-block">
<?php foreach ($orders as $order){?>
	<div class="chip incomplete-order" data-order_record_id="<?=$order->record_id?>" data-order_table_caption="<?=$order->store_table_info->caption?>">
<?php if($order->end_date){?>
		<div class="chip-media bg-teal"><i class="f7-icons sm">money_euro</i></div>
<?php }
	else{?>
		<div class="chip-media bg-purple"><i class="f7-icons sm">timer</i></div>
<?php }?>
		<div class="chip-label">
			<span class="table-caption"><?=$order->store_table_info->caption?></span>
			<span class="order-timer"><?=$order->elapsed_time?></span>
		</div>
<?php if(!$order->end_date){?>
		<a href="#" class="chip-delete <?=($order->all_order_products_completed()) ? '' : 'hidden' ?>"><i class="f7-icons lg">arrow_right_fill</i></a>
<?php }?>
	</div>
<?php }?>
</div>