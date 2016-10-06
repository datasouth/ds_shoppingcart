<?php
defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
$fr = Loader::helper('form');
$ih = Loader::helper('image');
?>
<form action="<?php echo $view->url('shopping_cart/update'); ?>" method="post">
<table border="0" cellspacing="0" cellpadding="0" class="table table-striped">
<tbody>
	<thead>
		<th></th>
		<th></th>
		<th><?php echo t('Name'); ?></th>
		<th><?php echo t('Quantity'); ?></th>
		<th><?php echo t('Price'); ?></th>
	</thead>
	<tbody>

	<?php
		if(!empty($res)) {

			$grandTotal = $ctr = 0;

			foreach($res as $row) {
				$prod   = \Page::getByID($row['scProductId']);
				$URL    = $nh->getCollectionURL($prod);

				$subTotal  = 0;
				$rowId     = $row['scId'];
				$prodName  = $prod->getCollectionAttributeValue('ds_product_name');
				$prodImage = $prod->getAttribute('ds_product_image');				
				$quantity  = $row['scQuantity'];
				$price     = (is_numeric($row['scPrice'])) ? number_format($row['scPrice'], 2, '.', '') : $row['scPrice'];
				$subTotal  = $price * $quantity;

				$grandTotal += $subTotal;
				$ctr += $quantity;

	?>
			<tr >
				<td style="vertical-align:middle;"><a class="btn btn-xs btn-default" href="<?php echo $view->url('/shopping_cart/remove/'.$rowId); ?>"><?php echo t('delete'); ?></a></td>
				<td><a href="<?php echo $view->url($URL); ?>"> <?php
				if($prodImage){
					echo $ih->outputThumbnail($prod->getAttribute('ds_product_image'),120,120);
				}else{
					echo '<img class="ccm-output-thumbnail" alt="" src="'.$view->getThemePath().'"/img/placeholder_img.png"; width="90" height="90">';
				}
				
				?></a></td>
				<td style="vertical-align:middle;"><a href="<?php echo $view->url($URL); ?>"><?php echo $prodName; ?></a></td>
				<td style="vertical-align:middle;">
					<?php echo $fr->text('prod_'.$row['scId'].'[quantity]', $quantity, array('style' => 'width:20%;min-width:40px;')); ?>
				</td>
				<td style="vertical-align:middle;"><?php echo number_format($price, 2, '.', '');?></td>
			</tr>
	<?php
			}
		}

		//set session variables
		\Session::set('grandTotal', $grandTotal);
		\Session::set('cartItems', $ctr);
	?>

			<tr>
				<td colspan="4" align="right"><?php echo t('Order Total'); ?>:</td>
				<td><?php echo number_format($grandTotal, 2, '.', ''); ?></td>
			</tr>

	</tbody>
</table>
<p align="right">
	<button type="submit" class="btn btn-default"><a><?php echo t('Update')?></a></button>
	<a href="<?php echo $view->url('checkout/billing'); ?>" class="btn btn-default"><?php echo t('Checkout'); ?></a>
</p>
</form>
<?php  if (!empty($response)): ?><script type="text/javascript">$(document).ready(function () {
            ConcreteAlert.notify({'message': '', 'title': '<?php  echo t("Sucessfully updated cart!") ?>'});
        });</script>
<?php  endif; ?>

  <?php
  $a = new Area('Main');
  $a->display($c);
?>