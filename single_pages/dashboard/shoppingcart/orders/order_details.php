<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $nh = Loader::helper('navigation'); ?>

<p><b>Billing Information</b></p>
<p>
	<?php echo $details['biName']; ?> <br/>
	<?php echo $details['biAddress1']; ?>, <?php echo $details['biCity']; ?> <?php echo $details['biState']; ?>  <br/>
	<?php echo $details['biCountry']; ?> <?php echo $details['biZip']; ?><br/>
</p>

<p><b>Shipping Information</b></p>
<p>
	<?php echo $details['siName']; ?> <br/>
	<?php echo $details['siAddress1']; ?>, <?php echo $details['siCity']; ?> <?php echo $details['siState']; ?>  <br/>
	<?php echo $details['siCountry']; ?> <?php echo $details['siZip']; ?><br/>
</p>


<div class="col col-sm-12">
	<table border="0" class="table" cellspacing="0" cellpadding="0">
		<tbody><tr>
			<th> </th>
			<th>Name</th>
			<th>Quantity</th>
			<th>Price</th>
			
		</tr>

			<?php
				if(!empty($res)) {
					$grandTotal = 0;

					foreach($res as $row) {

						$prod   = \Page::getByID($row['opProductId']);

						$subTotal  = 0;				
						$rowId     = $row['opId'];
						$prodName  = $prod->getCollectionAttributeValue('ds_product_name');
						$URL       = $nh->getCollectionURL($prod);						
						$prodImage = ($prod->getAttribute('ds_product_image')) ? $prod->getAttribute('ds_product_image')->getVersion()->getRelativePath() : ''; 
						$quantity  = $row['opQuantity'];
						$price     = (is_numeric($row['opPrice'])) ? number_format($row['opPrice'], 2, '.', '') : $row['opPrice']; 
						$subTotal  = $price * $quantity;

						$grandTotal += $subTotal;



			?>
					<tr>
						<td><a href="<?php echo $view->url($URL); ?>"><img class="ccm-output-thumbnail" alt="" src="<?php echo $prodImage?>" width="90" height="90"></a></td>
						<td><a href="<?php echo $view->url($URL); ?>"><?php echo $prodName; ?></a></td>
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

	<form method="post" action="<?php echo $view->url('/dashboard/shoppingcart/orders/order_details/update'); ?>">
	<p>
		<b>Date: </b> <?php echo $details['oDate']; ?> <br/>
		<b>Payment Method: </b> <?php echo $payment['pmName']; ?> <br/>
		<b>Status: </b> 
		<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
		<select name="order_status">
			<option <?php if($details['oStatus'] == 'Pending') echo 'selected="selected"'; ?>>Pending</option>
			<option <?php if($details['oStatus'] == 'Processing') echo 'selected="selected"'; ?>>Processing</option>
			<option <?php if($details['oStatus'] == 'Verified') echo 'selected="selected"'; ?>>Verified</option>
			<option <?php if($details['oStatus'] == 'Completed') echo 'selected="selected"'; ?>>Completed</option>
			<option <?php if($details['oStatus'] == 'Rejected') echo 'selected="selected"'; ?>>Rejected</option>
		</select>
		<input type="submit" value="update" />
	</p>
	</form>

	<p><a href="<?php echo $view->url('dashboard/shoppingcart/orders'); ?>" class="btn btn-primary pull-left">Back to Orders</a></p>
</div>
<?php  if (isset($successMessage)): ?><script type="text/javascript">$(document).ready(function () {
            ConcreteAlert.notify({'message': '', 'title': '<?php  echo $successMessage ?>'});
        });</script>
<?php  endif; ?>