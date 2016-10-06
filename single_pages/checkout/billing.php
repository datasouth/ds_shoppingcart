<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Loader::helper('form');
$GLOBALS['grandTotal'] = '';
?>

<?php Loader::packageElement("cart/cart_summary", 'ds_shoppingcart', array('cart'=>$res)); ?>

<form action="<?php  echo $view->url('/checkout/billing/confirm'); ?>" method="post" class="form-horizontal">
<input type="hidden" name="grandtotal" value="<?php echo $GLOBALS['grandTotal']; ?>" />
				<br />
					<h2><?php echo t('Billing Information'); ?></h2>

	        <div class="form-group">

	            <?php
	            	echo $form->label('billing[contact]',t("Contact Name"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('billing[contact]',$billing[0]['biName'],array('required'=>'required', 'placeholder' => 'Name'));
								echo "</div>";
	            ?>
	        </div>

	        <div class="form-group">
	        	<?php
	            	echo $form->label('billing[email]',t("Email"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->email('billing[email]',$billing[0]['biEmail'], array('required'=>'required', 'placeholder' => 'Email'));
								echo "</div>";
	            ?>
	            </div>

	        <div class="form-group">
	        	<?php
	            	echo $form->label('billing[phone]',t("Phone"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('billing[phone]',$billing[0]['biPhone'], array('placeholder' => 'Phone'));
								echo "</div>";
	            ?>

	        </div>
	        <div class="form-group">
	        	<?php
	            	echo $form->label('billing[address]',t("Address"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->textarea('billing[address]',$billing[0]['biAddress1'], array('placeholder' => 'Address'));
								echo "</div>";
	            ?>
	        </div>
	        <div class="form-group">
	        	<?php
	            	echo $form->label('billing[zip]',t("Zip Code"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('billing[zip]',$billing[0]['biZip'], array('placeholder' => 'Zip Code'));
								echo "</div>";
	            ?>
	        </div>
	        <div class="form-group">
	        		<?php
	            	echo $form->label('billing[country]',t("Country"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->select('billing[country]',  Loader::helper('lists/countries')->getCountries(), $billing[0]['biCountry']);
								echo "</div>";
		            ?>
	        </div>
            <div class="form-group">
                <?php
	            	echo $form->label('billing[state]',t("State"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('billing[state]',$billing[0]['biState'], array('placeholder' => 'State'));
								echo "</div>";
	            ?>
            </div>
            <div class="form-group">
                <?php
	            	echo $form->label('billing[city]',t("City"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('billing[city]',$billing[0]['biCity'], array('placeholder' => 'City'));
								echo "</div>";
	            ?>
            </div>


            <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <div class="checkbox">
				        <label>
				          <input type="checkbox" name="same_details" value="1" class="same_details" /> <?php echo t('Same with shipping details?'); ?>
				        </label>
				      </div>
				    </div>
				  </div>




            	<div class="shipping">
            		<br />
            	<h2>Shipping Information</h2>

	            <div class="form-group">
	            <?php
	            	echo $form->label('shipping[contact]',t("Contact Name"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('shipping[contact]',$billing[1]['siName'],array('required'=>'required', 'placeholder' => 'Name'));
								echo "</div>";
	            ?>
	        </div>

	        <div class="form-group">
	        	<?php
	            	echo $form->label('shipping[email]',t("Email"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->email('shipping[email]',$billing[1]['siEmail'], array('required'=>'required', 'placeholder' => 'Email'));
								echo "</div>";
	            ?>
	            </div>

	        <div class="form-group">
	        	<?php
	            	echo $form->label('shipping[phone]',t("Phone"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('shipping[phone]',$billing[1]['siPhone'], array('placeholder' => 'Phone'));
								echo "</div>";
	            ?>

	        </div>
	        <div class="form-group">
	        	<?php
	            	echo $form->label('shipping[address]',t("Address"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->textarea('shipping[address]',$billing[1]['siAddress1'], array('placeholder' => 'Address'));
								echo "</div>";
	            ?>
	        </div>
	        <div class="form-group">
	        	<?php
	            	echo $form->label('shipping[zip]',t("Zip Code"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('shipping[zip]',$billing[1]['siZip'], array('placeholder' => 'Zip Code'));
								echo "</div>";
	            ?>
	        </div>
	        <div class="form-group">
	        		<?php
	            	echo $form->label('shipping[country]',t("Country"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->select('shipping[country]',  Loader::helper('lists/countries')->getCountries(), $billing[1]['siCountry']);
								echo "</div>";
		            ?>
	        </div>
            <div class="form-group">
                <?php
	            	echo $form->label('shipping[state]',t("State"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('shipping[state]',$billing[1]['siState'], array('placeholder' => 'State'));
								echo "</div>";
	            ?>
            </div>
            <div class="form-group">
                <?php
	            	echo $form->label('shipping[city]',t("City"), array('class' => 'col-sm-2'));
	            	echo "<div class='col-sm-10'>";
								echo $form->text('shipping[city]',$billing[1]['siCity'], array('placeholder' => 'City'));
								echo "</div>";
	            ?>
            </div>
            </div>
	 </div>
		<div class="col-sm-offset-2 col-sm-10">
			<br />
			<div class="pull-left"><a href="<?php echo $view->url('shopping_cart'); ?>" class="btn btn-default"><?php echo t('back to cart'); ?></a></div>
			<div class="pull-right"><input type="submit" name="Submit" value="Submit" class="yourcommerce_submit" /></div>
		</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('.same_details').click(function() {
        if($(this).is(':checked'))
            $('.shipping').find('input, textarea, button, select').attr("disabled", true);
        else
            $('.shipping').find('input, textarea, button, select').attr("disabled", false);
    });
});
</script>