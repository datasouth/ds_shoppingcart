<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div  class="col-md-8 col-sm-8 col-one">
<?php
$nh  = Core::make('helper/navigation');
$ctr = 1;
foreach($products as $prod) {

	$prodId    = $prod->getCollectionID();
	$prodImage = ($prod->getAttribute('ds_product_image')) ? $prod->getAttribute('ds_product_image')->getVersion()->getRelativePath() : ''; 
	$prodName  = $prod->getCollectionAttributeValue('ds_product_name');
	$prodPrice = $prod->getCollectionAttributeValue('ds_product_price');
    $prodLink  = $nh->getLinkToCollection($prod);
?>
            
                <div class="col-md-4 col-sm-4 col-one">
                    <div class="column-1">
                        <h1>
                            <a href="<?php echo $view->url($prodLink); ?>"><img src="<?php echo $prodImage; ?>" class="img-responsive img-icon"></a>
                        </h1>
                        <h4><?php echo $prodName; ?></h4>
                        <p>
                            $<?php echo number_format($prodPrice, 2, '.', ''); ?>
                        </p>
                        <a href="<?php echo $view->url($prodLink); ?>" class="btn btn-default"><?php echo t('view details'); ?></a>
                    </div>
                </div>

                <?php if($ctr == 3) {
                	echo '</div><div class="row">';
                	$ctr = 1;
                } ?>
           
<?php } //end foreach ?>
 </div>
 
 <div class="col-md-4 col-sm-4 col-one">

 </div>
       