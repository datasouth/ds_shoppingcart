<?php 
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage\Dashboard\Shoppingcart;
use Concrete\Package\DsShoppingcart\Src\Orders\OrdersList;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Page;

defined('C5_EXECUTE') or die('Access Denied.');

class Orders extends DashboardPageController {

    public function view() {
        $list = new OrdersList();
        
        $list->setItemsPerPage(5);

        $cmpFilterTypes = array(
            'all'        => t('** Show All'),
            'Pending'    => t('Pending'),            
            'Processing' => t('Processing'),
            'Verified'   => t('Verified'),
            'Completed'  => t('Completed'),
            'Cancelled'  => t('Cancelled'),
        );

        if (isset($_REQUEST['cmpOrderKeywords']) && !empty($_REQUEST['cmpOrderKeywords'])) {
            $list->filterByKeywords($_REQUEST['cmpOrderKeywords']);            
        }

        if (isset($_REQUEST['cmpOrderFilter']) && $_REQUEST['cmpOrderFilter'] != 'all') {        	
            $list->filterByOrderStatus($_REQUEST['cmpOrderFilter']);
        }
        
        $orders = $list->getPage();
        $this->set('list', $list);
        $this->set('orders',$orders);
        $this->set('cmpFilterTypes', $cmpFilterTypes);
       
    }
 
}