<div class="content">
	<div class="content-padded">
		<ul class="table-view categories">
<?php foreach ($categories as $key => $category){?>
			<li class="table-view-cell" data-product_category_record_id="<?=$category->record_id?>">
				<span><?=$category->name?></span>
	<?php if ($category->children()){?>
				<ul class="table-view subcategories">
		<?php foreach ($category->children() as $key => $subcategory){?>
					<li class="table-view-cell" data-product_category_record_id="<?=$subcategory->record_id?>">
						<span class="small"><?=$subcategory->name?></span>
						<span class="pull-right"><i class="fa fa-angle-down"></i></span>
					</li>
		<?php }?>
				</ul>
	<?php } else {?>
				<span class="pull-right"><i class="fa fa-angle-down"></i></span>
	<?php }?>
			</li>
<?php }?>
		</ul>
	</div>
</div>