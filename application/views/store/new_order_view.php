<div class="panel-body catalogue">
	<div class="col-md-6">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php foreach ($categories as $key => $category){?>
			<div class="panel panel-default">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$category->record_id?>" aria-expanded="false" aria-controls="collapse-<?=$category->record_id?>">
				<div class="panel-heading" role="tab" id="heading<?=$category->record_id?>">
					<h4 class="panel-title">
						<?=$category->name?>
						<span class="badge badge-success pull-right"><?=count($category->products)?></span>
					</h4>
					
				</div></a>
				<div id="collapse-<?=$category->record_id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?=$category->record_id?>">
					<div class="panel-body">
						<ul class="list-unstyled">
	<?php foreach ($category->products as $key => $product){?>
							<li class="product" data-product_record_id="<?=$product->record_id?>">
								<span><?=$product->name?></span>
								<span class="description"><em class="text-primary"><?=$product->short_description?></em></span>
								<span class="add-product pull-right btn btn-primary btn-addon m-b-sm btn-rounded btn-sm"><i class="fa fa-plus"></i><span class="price"><?=$product->price?></span> €</span>
								<span class="add-comment pull-right">
									<a href="#" data-toggle="popover">
										<i class="fa fa-comment fa-fw fa-lg"></i>
									</a>
								</span>
								<div class="pull-right quantity-container">
									<span class="sub-quantity"><i class="fa fa-minus"></i></span>
									<span class="quantity"> 1 </span>
									<span class="add-quantity"><i class="fa fa-plus"></i></span>
								</div>
								<input type="hidden" id="product-record-id" name="order_product[<?=$product->record_id?>][product_record_id]" value="<?=$product->record_id?>"/>
								<input type="hidden" id="comments" name="order_product[<?=$product->record_id?>][comments]" value=""/>
								<input type="hidden" id="quantity" name="order_product[<?=$product->record_id?>][quantity]" value="1"/>
							</li>
	<?php }?>
						</ul>
					</div>
				</div>
			</div>
<?php }?>
		</div>
	</div>
	<div class="col-md-6">
		<form class="new-order">
			<div class="col-md-4">
				<select class="form-control waiter" name="user_record_id">
					<option value="0">Επιλέξτε σερβιτόρο</option>
<?php foreach ($active_waiters as $key => $waiter){?>
					<option value="<?=$waiter->record_id?>"><?=$waiter->lastname . ' ' . $waiter->firstname?></option>
<?php }?>
				</select>
			</div>
			<div class="col-md-4">
				<select class="form-control store-table" name="store_table_record_id">
					<option value="0">Επιλέξτε τραπέζι</option>
<?php foreach ($store_tables as $key => $table){?>
					<option value="<?=$table->record_id?>"><?=$table->caption?></option>
<?php }?>
				</select>
			</div>			
			<div class="col-md-4">
				<button class="btn btn-success complete-order" disabled="true">Ολοκλήρωση (<span class="order-total-price">0</span> €)</button>
			</div>
			<div class="col-md-12 m-t-md">
				<ul class="list-unstyled order"></ul>
			</div>
		</form>
	</div>
</div>

<script>
	init_new_order_modal();
</script>