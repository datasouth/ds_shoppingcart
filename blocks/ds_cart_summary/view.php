<?php 
defined('C5_EXECUTE') or die('Access Denied.');
?>
 <ul class="nav navbar-nav list-unstyled">
	<li><a href="<?php echo $view->url('shopping_cart'); ?>"><i class="fa fa-gift"></i> <?php echo !empty($quantity) ? $quantity : ' 0'; ?> Items | £<?php echo !empty($total) ? $total : ' 0'; ?></a></li>
</ul>