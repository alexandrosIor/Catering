<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
	<div class="panel panel-purple order-panel" data-order_record_id="<?=$order->record_id?>">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span><i class="fa fa-th-large fa-lg m-r-xs"></i><span class="text-md"><?=$order->store_table_info->caption?></span></span>
			</h3>
			<div class="panel-control pull-right">
				<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Expand/Collapse" class="panel-collapse"><i class="fa fa-expand fa-fw"></i></a>
				<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Remove" class="panel-remove"><i class="fa fa-times fa-lg"></i></a>
			</div>
			<span class="order-timer pull-right m-r-sm"><?=$order->elapsed_time?></span>
		</div>
		<div class="panel-body order-summary">
			<div class="waiter-name pull-left"><i class="fa fa-user fa-fw"></i><?=$order->user_info->lastname . ' ' .  $order->user_info->firstname?></div>
			<div class="order-total-cost pull-right"><?=$order->total_price?> €</i></div>
		</div>
		<a href="/orders/order_modal_form/<?=$order->record_id?>" class="view-order btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-search fa-lg fa-fw"></i>προβολή</a>
	</div>
</div>