<p><h3><?php echo $method['pmName']; ?></h3></p>

<form method="post" action="<?php echo $view->url('/dashboard/shoppingcart/payments/payment_details/save'); ?>">

	<div class="form-group">
		<?php 
			echo $form->hidden('payment_id',$method['pmId']); 
			echo $form->hidden('handle',$method['pmHandle']);
			echo $form->label('required_enabled',t("Enabled"));
			echo $form->select('required_enabled',array(0=>'No',1=>'Yes'),$method['pmIsEnabled']); 
		?>
	</div>
	<div class="form-group">
		<?php 
			echo $form->label('required_name',t("Method Name"));
			echo $form->text('required_name',$method['pmName']);
		?>
	</div>

	<!--load the edit_form.php from the payment method -->
	<?php $pkg_handle = ($method['pkgID']) ? $method['pmHandle'] : $view->c->pkgHandle; ?>
	<?php Loader::packageElement("payments/".$method['pmHandle']."/edit_form", $pkg_handle, array('method' => $method, 'form' => $form, 'values' => $values)); ?>

	<p><a href="<?php echo $view->url('dashboard/shoppingcart/payments'); ?>" class="btn btn-primary pull-left"><?php echo t('Back to Payment Methods'); ?></a></p>

	<div class="btn-group pull-right">
       <button class="pull-right btn btn-success" type="submit"><?php echo t('Save Settings'); ?></button>
    </div>

</form>


