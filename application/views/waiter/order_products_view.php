<div class="row current-order">
	<div class="col-60">
		<div class="list-block">
			<ul>
				<li>
					<div class="item-content">
						<div class="item-inner">
							<div class="item-input">
								<input type="text" placeholder="Επιλέξτε τραπέζι" style="font-size:14px;height:26px" readonly id="table-picker" value="<?=isset($table->caption) ? $table->caption : ''?>">
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="col-40">
		<a href="#" class="button button-fill confirm-order" disabled="true"><span class="order-total-price"><?=$order_total_price?></span> €</a>
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
							<a href="#" data-popover=".my-popover" class="link open-popover"><i class="f7-icons md">info</i></a>
							<span class="hidden"><?=$product->product_info->description?></span>
						</div>
	<?php }
	if ($product->comments){?>
						<div class="right comments"><i class="f7-icons md">chat</i></div>
	<?php }?>
						<div class="right product-price"><?=$product->product_info->price?> €</div>
					</div>
				</div>
				<div class="swipeout-actions-left update-product">
					<a href="#" class="action1 bg-gray" style="padding: 0 10px">
						<i class="f7-icons sm sub-q">delete</i>
						<div class="product-quantity"><?=$product->quantity?></div>
						<i class="f7-icons sm add-q">add</i>
					</a>	
					<a href="#" class="action2 bg-orange">
						<div href="#" class="add-comment">Σχόλια</div>
						<span class="hidden"><?=$product->comments?></span>
					</a>
					<a href="#" class="action3 bg-red remove-product" data-product_record_id="<?=$product->record_id?>" data-comments="" data-quantity="1" data-order_record_id="">
						<i class="f7-icons md rm-prod">close</i>
					</a>
				</div>
			</li>
<?php }?>
		</ul>
	</div>
</div>
