<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
defined('C5_EXECUTE') or die("Access Denied.");
$valt = Loader::helper('validation/token');
$th = Loader::helper('text');
$ip = Loader::helper('validation/ip'); ?>
<div class="ccm-dashboard-content-full">

    <div data-search-element="wrapper">
        <form role="form" data-search-form="logs" action="<?php echo $controller->action('view')?>" class="form-inline ccm-search-fields">
            <div class="ccm-search-fields-row">
                <div class="form-group">
                    <?php echo $form->label('keywords', t('Search'))?>
                    <div class="ccm-search-field-content">
                        <div class="ccm-search-main-lookup-field">
                            <i class="fa fa-search"></i>
                            <?php echo $form->search('cmpOrderKeywords', array('placeholder' => t('Keywords')))?>
                            <button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php echo t('Search')?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ccm-search-fields-row">
                <div class="form-group">
                    <?php echo $form->label('cmpOrderFilter', t('Filter By Status'))?>
                    <div class="ccm-search-field-content">
                        <?php echo $form->select('cmpOrderFilter', $cmpFilterTypes, $cmpOrderFilter) ?>
                    </div>
                </div>
            </div>

            <div class="ccm-search-fields-submit">
            <button type="submit" class="btn btn-primary pull-right"><?php echo t('Search')?></button>
            </div>

        </form>

    </div>

    <div data-search-element="results">
        <div class="table-responsive">
            <table id="ccm-orders" class="ccm-search-results-table table-hover">
                <thead>
                <tr>
                    <th class="<?php echo $list->getSearchResultsClass('oDate')?>"><a href="<?php echo $list->getSortByURL('oDate', 'desc')?>"><?php echo t('Date')?></a></th>                    
                    <th class="<?php echo $list->getSearchResultsClass('oStatus')?>"><a href="<?php echo $list->getSortByURL('oStatus', 'desc')?>"><?php echo t('Status')?></a></th>
                    <th><span><?php echo t('Name')?></span></th>
                    <th><span><?php echo t('Email')?></span></th>
                    <th><span><?php echo t('Total')?></span></th>
                </tr>
                </thead>
                <tbody>
               		<?php if (count($orders) > 0) {
	                    $dh = Core::make('date');
	                    foreach($orders as $ord) {
	                     ?>
	                    	<tr style="cursor:pointer" data-order-id="<?php echo $ord->getOrderId(); ?>">
		                    	<td><?php echo $dh->formatDateTime(strtotime($ord->getOrderDate())); ?></td>
		                    	<td><?php echo $ord->getOrderStatus(); ?></td>
		                    	<td><?php echo $ord->biName; ?></td>
		                    	<td><?php echo $ord->biEmail; ?></td>
		                    	<td align="right"><?php echo $ord->getOrderTotal(); ?></td>
	                    	</tr>
	                    <?php 
	                	}
                	}?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Body Pane -->
    <?php echo $list->displayPagingV2()?>

    <script type="text/javascript">
        $(document).ready(function() {

		    $('#ccm-orders tr').click(function() {
		    	var orderId = $(this).attr('data-order-id');
		        var href = '<?php echo $view->url("/dashboard/shoppingcart/orders/order_details/"); ?>' + '/' + orderId;
		        if(href) {
		            window.location = href;
		        }
		    });

		});
    </script>

</div>
