<div class="content">
	<div class="content-padded">
		<ul class="table-view products">
<?php foreach ($products as $key => $product){?>
			<li class="table-view-cell" data-product_record_id="<?=$product->record_id?>">
				<span><i class="fa fa-plus-circle" style="color:#22BAA0"></i></span>
				<span><?=$product->name?></span>
				<em class="small"> <?=$product->description?></em>
				<span class="pull-right"><?=$product->price?> €</span>
			</li>
<?php }?>
		</ul>
	</div>
</div>