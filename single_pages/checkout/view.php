<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
if(!empty($prod)) {
	$prodId    = $prod->getCollectionID();
	$prodImage = ($prod->getAttribute('ds_product_image')) ? $prod->getAttribute('ds_product_image')->getVersion()->getRelativePath() : ''; 
	$prodName  = $prod->getCollectionAttributeValue('ds_product_name');
	$prodPrice = $prod->getCollectionAttributeValue('ds_product_price');
	$prodDescription = $prod->getCollectionAttributeValue('ds_product_description');
}
?>

<div><img class="ccm-output-thumbnail" alt="" src="<?php echo $prodImage; ?>" width="300" ></div>
<p><h1><?php echo $prodName; ?></h1></p>

<div>$<?php echo number_format($prodPrice, 2, '.', '');?></div>

<p><?php echo $prodDescription; ?></p>

<p><a href="/shopping_cart/add/<?php echo $prodId; ?>" class="btn btn-default">add to cart</a></p>