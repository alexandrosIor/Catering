<div class="content-block">
<?php foreach ($orders as $order){?>
	<div class="chip incomplete-order" data-order_record_id="<?=$order->record_id?>" data-order_table_caption="<?=$order->store_table_info->caption?>">
<?php if($order->end_date){?>
		<div class="chip-media bg-teal"><i class="fa fa-money"></i></div>
<?php }
	else{?>
		<div class="chip-media bg-purple"><i class="fa fa-hourglass"></i></div>
<?php }?>
		<div class="chip-label">
			<span class="table-caption"><?=$order->store_table_info->caption?></span>
			<i class="fa fa-clock-o fa-fw"></i><span class="order-timer"><?=$order->elapsed_time?></span>
		</div>
<?php if(!$order->end_date){?>
		<a href="#" class="chip-delete <?=($order->all_order_products_completed()) ? '' : 'hidden' ?>"><i class="fa fa-arrow-circle-right fa-lg"></i></a>
<?php }?>
	</div>
<?php }?>
</div>