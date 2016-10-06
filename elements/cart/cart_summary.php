<div class="col col-sm-12">
	<table border="0" class="table" cellspacing="0" cellpadding="0">
		<tbody><tr>
			<th> </th>
			<th><?php echo t('Name'); ?></th>
			<th><?php echo t('Quantity'); ?></th>
			<th><?php echo t('Price'); ?></th>
			
		</tr>

			<?php
				if(!empty($cart)) {
					$ih = Loader::helper('image');
					$grandTotal = 0;

					foreach($cart as $row) {

						$prod   = \Page::getByID($row['scProductId']);

						$subTotal  = 0;				
						$rowId     = $row['scId'];
						$prodName  = $prod->getCollectionAttributeValue('ds_product_name');
						$prodImage = $prod->getAttribute('ds_product_image');						
						$quantity  = $row['scQuantity'];
						$price     = (is_numeric($row['scPrice'])) ? number_format($row['scPrice'], 2, '.', '') : $row['scPrice']; 
						$subTotal  = $price * $quantity;

						$grandTotal += $subTotal;



			?>
					<tr>
						<td>
							<?php
							if($prodImage){
								echo $ih->outputThumbnail($prod->getAttribute('ds_product_image'),120,120);
							}else{
								echo '<img class="ccm-output-thumbnail" alt="" src="'.$view->getThemePath().'"/img/placeholder_img.png"; width="90" height="90">';
							}
							
							?>
						</td>
						<td><?php echo $prodName; ?></td>
						<td><?php echo $quantity; ?></td>
						<td><?php echo number_format($price, 2, '.', '');?></td>						
					</tr>	
			<?php
					}
				}
			?>

			<tr>
				<td colspan="3" align="right">Order Total:</td>
				<td><?php echo number_format($grandTotal, 2, '.', ''); ?></td>
			</tr>

		</tbody></table>
</div>
<?php $GLOBALS['grandTotal'] = $grandTotal; ?>