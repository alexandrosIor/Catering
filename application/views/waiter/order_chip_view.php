<div class="content-block">
<?php foreach ($orders as $order){?>
	<div class="chip incomplete-order" data-order_record_id="<?=$order->record_id?>">
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
		<a href="#" class="chip-delete"></a>
	</div>
<?php }?>
</div>