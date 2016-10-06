<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $th = Loader::helper('text'); ?>
<div class="col col-sm-12"><h3><?php echo t('Installed'); ?></h3></div>

<div class="col col-sm-12">

	<?php if (count($methods) > 0) {	            
	            foreach($methods as $mt) {
	            	$status = $mt['pmIsEnabled'] ? 0 : 1;
	             ?>
					
					<div class="media-row">
					    <div class="pull-left"><h5><?php echo $mt['pmName']; ?></h5></div>
					    <div class="pull-right">	
					        <a href="<?php echo $view->url('dashboard/shoppingcart/payments/status/'.$status.'/'.$mt['pmId']); ?>" class="btn btn-default btn-sm status <?php if(!$status) echo 'active'; ?>"><i class="fa fa-check"></i></a>					        					        
					    	<a href="<?php echo $view->url('dashboard/shoppingcart/payments/payment_details/'.$mt['pmId']); ?>" class="btn btn-sm btn-default"><?php echo t('Details'); ?></a>
					    </div>
					    
					</div>
	<?php 
	        	}
	    	}?>

</div>

<!--<p class="col col-sm-12"><br/></p>
<div class="col col-sm-12"><h3><?php echo t('Awaiting Installation'); ?></h3></div>

<div class="col col-sm-12">
	<?php if (count($pending) > 0) {	            
	            foreach($pending as $pHandle) {
	             ?>
					<div class="media-row">
					    <div class="pull-left"><h4><?php echo preg_replace('/(?<!\ )[A-Z]/', ' $0', $pHandle); ?></h4></div>
					    <div class="pull-right">
					        <a href="<?php echo $view->url('dashboard/shoppingcart/payments/install/'.$th->uncamelcase($pHandle)); ?>" class="btn btn-sm btn-default"><?php echo t('Install'); ?></a>					        			        					        
					    </div>
					    
					</div>
	<?php 
	        	}
	    	}?>
</div>	-->
<?php  if (isset($successMessage)): ?><script type="text/javascript">$(document).ready(function () {
            ConcreteAlert.notify({'message': '', 'title': '<?php  echo $successMessage ?>'});
        });</script>
<?php  endif; ?>   




