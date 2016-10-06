<?php
defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>

<?php if ( $c->isEditMode() && $controller->isBlockEmpty()) { ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.')?></div>
<?php } else { ?>

<div class="ccm-block-page-list-wrapper default-shop-view">

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
        <div class="ccm-block-page-list-header">
            <h5><?php echo h($pageListTitle)?></h5>
        </div>
    <?php endif; ?>

    <?php if (isset($rssUrl) && $rssUrl): ?>
        <a href="<?php echo $rssUrl ?>" target="_blank" class="ccm-block-page-list-rss-feed"><i class="fa fa-rss"></i></a>
    <?php endif; ?>

    <div class="ccm-block-page-list-pages">

    <?php

    $includeEntryText = false;
    if ($includeName || $includeDescription || $useButtonForLink) {
        $includeEntryText = true;
    }

    foreach ($pages as $page):

		// Prepare data for each page being listed...
        $buttonClasses = 'ccm-block-page-list-read-more';
        $entryClasses = 'ccm-block-page-list-page-entry';
		$title = $th->entities($page->getCollectionName());
		$url = ($page->getCollectionPointerExternalLink() != '') ? $page->getCollectionPointerExternalLink() : $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);
        $thumbnail = false;

            $thumbnail = $page->getAttribute('ds_product_image');

        if (is_object($thumbnail) && $includeEntryText) {
            $entryClasses = 'ccm-block-page-list-page-entry-horizontal';
        }

        $date = $dh->formatDateTime($page->getCollectionDatePublic(), true);


		//Other useful page data...


		//$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();

		//$original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

		/* CUSTOM ATTRIBUTE EXAMPLES:
		 * $example_value = $page->getAttribute('example_attribute_handle');
		 *
		 * HOW TO USE IMAGE ATTRIBUTES:
		 * 1) Uncomment the "$ih = Loader::helper('image');" line up top.
		 * 2) Put in some code here like the following 2 lines:
		 *      $img = $page->getAttribute('example_image_attribute_handle');
		 *      $thumb = $ih->getThumbnail($img, 64, 9999, false);
		 *    (Replace "64" with max width, "9999" with max height. The "9999" effectively means "no maximum size" for that particular dimension.)
		 *    (Change the last argument from false to true if you want thumbnails cropped.)
		 * 3) Output the image tag below like this:
		 *		<img src="<?php echo $thumb->src ?>" width="<?php echo $thumb->width ?>" height="<?php echo $thumb->height ?>" alt="" />
		 *
		 * ~OR~ IF YOU DO NOT WANT IMAGES TO BE RESIZED:
		 * 1) Put in some code here like the following 2 lines:
		 * 	    $img_src = $img->getRelativePath();
		 *      $img_width = $img->getAttribute('width');
		 *      $img_height = $img->getAttribute('height');
		 * 2) Output the image tag below like this:
		 * 	    <img src="<?php echo $img_src ?>" width="<?php echo $img_width ?>" height="<?php echo $img_height ?>" alt="" />
		 */

		/* End data preparation. */

		/* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>


        <div class="<?php echo $entryClasses?> shoplist">
        <div class="row">
        <div class="col-xs-4 col-sm-3 col-md-2">
        <span class="youcommerce_imageholder">
        <?php if (is_object($thumbnail)){ ?>

            <a href="<?php echo $url; ?>">

            <img src="<?php echo $thumbnail->getRelativePath(); ?>">
                    </a>
            <?php }else{ ?>
            <a href="<?php echo $url; ?>"><img src="<?php  echo $view->getThemePath()?>/img/placeholder_img.png"></a>

            <?php } ?>
            </span>
        </div>
        <?php if ($includeEntryText): ?>
            <div class="col-xs-8 col-sm-9 col-md-10">



            <div class="ccm-block-page-list-page-entry-text">


                <div class="row">
                <div class="col-sm-9">

                    <div class="shopdetail">
                <?php if ($includeName): ?>
                <div class="ccm-block-page-list-title">
                    <?php if ($useButtonForLink) { ?>
                        <?php echo $title; ?>
                    <?php } else { ?>
                        <a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo $title ?></a>
                    <?php } ?>
                </div>
                <?php endif; ?>

                <?php if ($includeDate): ?>
                    <div class="ccm-block-page-list-date"><?php echo $date?></div>
                <?php endif; ?>

                <?php if ($includeDescription): ?>
                    <div class="ccm-block-page-list-description">
                        <?php echo $description ?>
                    </div>
                <?php endif; ?>

                <?php if ($useButtonForLink): ?>
                <div class="ccm-block-page-list-page-entry-read-more">
                    <a href="<?php echo $url?>" class="<?php echo $buttonClasses?>"><?php echo $buttonLinkText?></a>
                </div>
                <?php endif; ?>


        <?php endif; ?>
        <!--new for shopping cart-->
        </div>

                </div>
                <div class="col-sm-3">

                    <div class="cartdetails">
        <?php if ($showProductPrice): ?>
            <div class="youcommerce_price">&pound;<?php echo number_format($page->getAttribute('ds_product_price'), 2, '.', ''); ?></div>
            <div class="clearfix"></div>
        <?php endif; ?>
        <?php if ($showProductPrice): ?>
            <div class="youcommerce_sku">SKU: <strong><?php echo $page->getAttribute('ds_product_sku'); ?></strong></div>
            <div class="clearfix"></div>
        <?php endif; ?>
        <?php if ($showBuyButton): ?>
            <div><a href="<?php echo $view->url('/shopping_cart/add/'.$page->getCollectionID()); ?>" class="youommerce_btn">Buy</a></div>
        <?php endif; ?>


        </div>

                </div>
            </div>




        </div>





</div>

        </div></div>
        <div class="clearfix"></div>
	<?php endforeach; ?>

    </div>

    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage)?></div>
    <?php endif;?>

</div><!-- end .ccm-block-page-list -->


<?php if ($showPagination): ?>
    <?php echo $pagination;?>
<?php endif; ?>

<?php } ?>
