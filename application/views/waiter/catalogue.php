
<div data-page="catalogue" class="page tabbar-labels-fixed">
	<div class="navbar">
		<div class="navbar-inner">
			<div class="left"><a href="index-2.html" class="back link icon-only"><i class="icon icon-back"></i></a></div>
			<div class="center">Νέα πραγγελία</div>
			<div class="right"><a href="#" class="link open-panel icon-only"><i class="icon icon-bars"></i></a></div>
		</div>
	</div>
	<div class="toolbar tabbar tabbar-labels">
		<div class="toolbar-inner">
			<a href="#tab-1" class="tab-link active"><i class="fa fa-list fa-lg"></i><span class="tabbar-label">Καταλογος</span></a>
			<a href="#tab-2" class="tab-link"><i class="fa fa-edit fa-lg"></i><span class="tabbar-label">Παραγγελια</span></a>
		</div>
	</div>

	<div class="page-content">
		<div class="tabs">
			<div id="tab-1" class="tab active">
				<div class="content-block">
					<div class="list-block accordion-list">
						<ul>
<?php foreach ($product_categories as $key => $product_category){?>
							<li class="accordion-item">
								<a href="#" class="item-link item-content">
									<div class="item-inner">
										<div class="item-title"><?=$product_category->name?></div>
									</div>
								</a>
								<div class="accordion-item-content">
									<div class="list-block">
										<ul class="products-list">
	<?php foreach ($product_category->products() as $key => $product){?>
											<li class="swipeout product">
												<div class="swipeout-content item-content">
													<div class="item-inner">
														<div class="item-title">
															<?=$product->name?>
															<em><?=$product->description?></em>
														</div>
														<div class="right product-price"><?=$product->price?> €</div>
													</div>
												</div>
												<div class="swipeout-actions-left">
													<a href="#" class="action1 bg-gray">
														<i class="fa fa-minus"></i>
														<div class="product-quantity"> 0 </div>
														<i class="fa fa-plus"></i>
													</a>	
													<a href="#" class="action2 bg-orange">
														<div href="#" class="add-comment">Σχόλια</div>
													</a>
													<a href="#" class="action3 bg-green add-product">
														<i class="fa fa-check"></i>
													</a>
												</div>
											</li>
	<?php }?>
										</ul>
									</div>
								</div>
							</li>
<?php }?>
						</ul>
					</div>
				</div>
			</div>
			<div id="tab-2" class="tab">
				<div class="content-block">
					
					<div class="row current-order">
						<div class="col-50">
							<div class="list-block">
								<ul>
									<li>
										<div class="item-content">
											<div class="item-inner">
												<div class="item-input">
													<input type="text" placeholder="Επιλέξτε τραπέζι" readonly id="picker-device">
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-50">
							<a href="#" class="button button-fill complete-order">72,60 <i class="fa fa-eur"></i></a>
						</div>
					</div>

					<div class="list-block accordion-list">
						<form>
							<ul class="order-product">
								
							</ul>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>