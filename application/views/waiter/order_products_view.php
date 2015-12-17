<div class="row current-order">
	<div class="col-50">
		<div class="list-block">
			<ul>
				<li>
					<div class="item-content">
						<div class="item-inner">
							<div class="item-input">
								<input type="text" placeholder="Επιλέξτε τραπέζι" readonly id="table-picker">
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="col-50">
		<a href="#" class="button button-fill complete-order" disabled="true"><span class="order-total-price"><?=$order_total_price?></span> <i class="fa fa-eur"></i></a>
	</div>
</div>

<div id="order-products">
	<div class="list-block">
		<ul class="products-list" data-order_record_id="">
<?php foreach ($order_products as $key => $product){?>
			<li class="swipeout product" data-order_product_record_id="<?=$product->record_id?>">
				<div class="swipeout-content item-content">
					<div class="item-inner">
						<div class="item-title">
							<?=$product->product_info->name?>
							<em><?=substr($product->product_info->short_description, 0, 10)?></em>
						</div>
	<?php if ($product->product_info->description){?>
						<div class="right description">
							<a href="#" data-popover=".my-popover" class="link open-popover"><i class="fa fa-info-circle fa-lg"></i></a>
							<span class="hidden"><?=$product->product_info->description?></span>
						</div>
	<?php }?>
						<div class="right product-price"><?=$product->product_info->price?> €</div>
					</div>
				</div>
				<div class="swipeout-actions-left">
					<a href="#" class="action1 bg-gray">
						<i class="fa fa-minus"></i>
						<div class="product-quantity"><?=$product->quantity?></div>
						<i class="fa fa-plus"></i>
					</a>	
					<a href="#" class="action2 bg-orange">
						<div href="#" class="add-comment">Σχόλια</div>
					</a>
					<a href="#" class="action3 bg-red remove-product" data-product_record_id="<?=$product->record_id?>" data-comments="" data-quantity="1" data-order_record_id="">
						<i class="fa fa-times fa-lg"></i>
					</a>
				</div>
			</li>
<?php }?>
		</ul>
	</div>
</div>
