<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php if(!isset($pmHandle)) : ?>
		<h3><?php echo t('Select Payment Method'); ?></h3>

		<ul id="ccm-block-type-list-installed" class="item-select-list ccm-block-type-sortable-list">
			<?php if (count($methods) > 0) :	            
			            foreach($methods as $method) : ?>
							<li><a href="<?php echo $view->url('checkout/payments/form/'.$method['pmHandle']); ?>"><?php echo $method['pmName']; ?></a></li>
					<?php endforeach; ?>
			<?php else : ?>
				<p>No payment method is enabled. Please enable a payment method on the dashboard section.</p>
			<?php endif; ?>
		</ul>

<?php else : ?>
	<?php extract($sets); ?>
	<?php Loader::packageElement("cart/cart_summary", 'ds_shoppingcart', array('cart'=>$cart)); ?>
	<form method="post" action="<?php echo $formAction; ?>">
		<h3><?php echo $method['pmName']; ?></h3>
		<?php $pkg_handle = ($method['pkgID']) ? $pmHandle : $view->c->pkgHandle; ?>
		<?php Loader::packageElement("payments/".$pmHandle."/checkout_form", $pkg_handle, array('sets'=>$sets)); ?>
		<input type="hidden" name="pmHandle" value="<?php echo $pmHandle; ?>" />
		<input type="submit" value="<?php echo t('Submit'); ?>" />
	</form>
<?php endif; ?>

<div class="pull-left"><a href="<?php echo $view->url('checkout/billing'); ?>" class="btn btn-default"><?php echo t('back to Billing Information'); ?></a></div>
