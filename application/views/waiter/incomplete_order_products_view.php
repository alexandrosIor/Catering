<div class="navbar">
	<div class="navbar-inner">
		<div class="center my-popup-title"><i class="fa fa-th-large fa-fw"></i><?=$order->store_table_info->caption?></div>
		<div class="right"><a href="#" class="link close-popup"><i class="fa fa-times"></i></a></div>
	</div>
</div>
<div class="content-block">
	<div class="row incomplete-order">
		<div class="col-100">
<?php if ($order->end_date){?>
			<div class="pull-left">
				<a href="#" class="button button-fill order-payment <?=($order->payment_status == 'paid') ? 'disabled' : ''?>"> 
					ΕΞΟΦΛΗΣΗ : <span class="order-total-price"><?=$order->total_price?></span> <i class="fa fa-eur"></i>
				</a>
			</div>
			<div class="pull-right transfer-order" data-order_record_id="<?=$order->record_id?>">
				<a href="#" data-popover=".my-popover" class="link open-popover">
					<i class="fa fa-exchange fa-2x"></i>
				</a>
			</div>
<?php }else{?>
			<span class="total-price-label">Σύνολικό ποσό:</span> 
			<span class="order-total-price"><?=$order->total_price?></span> <i class="fa fa-eur"></i>
			<div class="pull-right transfer-order" data-order_record_id="<?=$order->record_id?>">
				<a href="#" data-popover=".my-popover" class="link open-popover">
					<i class="fa fa-exchange fa-2x"></i>
				</a>
			</div>
<?php }?>
		</div>
	</div>
	<div id="order-products">
		<div class="list-block">
			<ul class="products-list">
<?php foreach ($order_products as $key => $product){?>
				<li class="swipeout product" data-order_product_record_id="<?=$product->record_id?>">
					<div class="swipeout-content item-content">
						<div class="item-inner">
							<div class="item-title">
	<?php if ($product->deleted_at){?>
								<i class="fa fa-check completed-product-mark"></i>
	<?php }?>
								<?=$product->product_info->name?>
								<em><?=substr($product->product_info->short_description, 0, 10)?></em>
							</div>
	<?php if ($product->product_info->description){?>
							<div class="right description">
								<a href="#" data-popover=".my-popover" class="link open-popover"><i class="fa fa-info-circle fa-lg"></i></a>
								<span class="hidden"><?=$product->product_info->description?></span>
							</div>
	<?php }
	if ($product->comments){?>
							<div class="right comments"><i class="fa fa-comment"></i></div>
	<?php }?>
							<div class="right product-price"><?=$product->product_info->price?> €</div>
						</div>
					</div>
	<?php if (!$product->deleted_at){?>
					<div class="swipeout-actions-left update-product">
						<a href="#" class="action1 bg-gray">
							<i class="fa fa-minus"></i>
							<div class="product-quantity"><?=$product->quantity?></div>
							<i class="fa fa-plus"></i>
						</a>    
						<a href="#" class="action2 bg-orange">
							<div href="#" class="add-comment">Σχόλια</div>
							<span class="hidden"><?=$product->comments?></span>
						</a>
						<a href="#" class="action3 bg-red remove-product" data-product_record_id="<?=$product->record_id?>" data-comments="" data-quantity="1" data-order_record_id="">
							<i class="fa fa-times fa-lg"></i>
						</a>
					</div>
					<div class="swipeout-actions-right">
						<a href="#" class="bg-green serve-product" data-product_record_id="<?=$product->record_id?>"><i class="fa fa-check fa-lg"></i></a>
					</div>
	<?php }?>
				</li>
<?php }?>
			</ul>
		</div>
	</div>
</div>