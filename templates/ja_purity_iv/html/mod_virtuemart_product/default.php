<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
// add javascript for price and cart, need even for quantity buttons, so we need it almost anywhere
vmJsApi::jPrice();

$col = 1;
$pwidth = ' width' . floor (100 / $products_per_row);
if ($products_per_row > 1) {
	$float = "floatleft";
} else {
	$float = "center";
}
?>

<div class="vmgroup<?php echo $params->get ('moduleclass_sfx') ?>">
	<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
	<?php
}
	if ($display_style == "div") {
		?>
		<div class="vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> product-list product-cols-<?php echo ($products_per_row > 1)?$products_per_row:'1'; ?>">
			<?php foreach ($products as $product) { ?>
			<div class="vm-product-item" style="flex-basis: calc((100% - <?php echo (16*($products_per_row - 1)); ?>px)/<?php echo $products_per_row; ?>);">
				<div class="product-item-media">
					<?php
					if (!empty($product->images[0])) {
						$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage"', FALSE);
					} else {
						$image = '';
					}
					echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
					?>
				</div>

				<div class="product-item-content">
					<h3>
						<?php
					// Product title
					$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .$product->virtuemart_category_id); ?>
					<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
					</h3>

					<?php
					if ($show_price) {

						echo '<div class="product-price">';
						// 		echo $currency->priceDisplay($product->prices['salesPrice']);
						if (!empty($product->prices['salesPrice'])) {
							echo $currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
						}
						// 		if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
						if (!empty($product->prices['salesPriceWithDiscount'])) {
							echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
						}
						echo '</div>';

					}
					if ($show_addtocart) {
						echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
					}
					?>
				</div>
			</div>
			<?php } ?>
		</div>

		<?php
	} else {
		$last = count ($products) - 1;
		?>
		<ul class="vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> product-list product-cols-<?php echo ($products_per_row > 1)?$products_per_row:'1'; ?>">
			<?php foreach ($products as $product) : ?>
			<li class="vm-product-item" style="flex-basis: calc((100% - <?php echo (16*($products_per_row-1)); ?>px)/<?php echo $products_per_row; ?>);">
				<div class="product-item-media">
					<?php
					if (!empty($product->images[0])) {
						$image = $product->images[0]->displayMediaThumb ('class="item-image"', FALSE);
					} else {
						$image = '';
					}
					echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
					?>
				</div>

				<div class="product-item-content">
					<h3>
						<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .$product->virtuemart_category_id); ?>
						<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
					</h3>

					<?php
					// $product->prices is not set when show_prices in config is unchecked
					if ($show_price and  isset($product->prices)) {
						echo '<div class="item-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
						if ($product->prices['salesPriceWithDiscount'] > 0) {
							echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
						}
						echo '</div>';

					}

					if ($show_addtocart) {
						echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'position' => array('ontop', 'addtocart')));
					}
					?>
				</div>

			</li>
			<?php
		endforeach; ?>
		</ul>

		<?php
	}
	if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>