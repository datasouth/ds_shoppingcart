<?php 
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage\Dashboard\Shoppingcart;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Package\DsShoppingcart\Src\Payments\PaymentMethods;
use Page;
use Loader;

defined('C5_EXECUTE') or die('Access Denied.');

class Payments extends DashboardPageController {

    public function view($response=false) {	
        $methods = PaymentMethods::getList();
        //$pending = PaymentMethods::getPendingList();

        $this->set('methods',$methods);
        //$this->set('pending',$pending);

        if($response) {        	
            $this->set('successMessage',t('Success!')); 
        } 
    }

    public function status($enabled=0,$id='') {
    	if($id) {
    		$db   = Loader::db(); 
    		$stat = $enabled ? 1 : 0;
            $db->Execute("UPDATE DsPaymentMethods SET `pmIsEnabled` = ? WHERE `pmId` = ?", array($stat, $id));
            $this->redirect('dashboard/shoppingcart/payments/1');
    	}
    }

    public function install($handle='') {
    	if($handle) {
    		$pkg  = $this->c->pkgID;
    		$th   = Loader::helper('text');
    		$name = $th->unhandle($handle);
    		$id   = PaymentMethods::add($handle, $name, 0, $pkg);
    		$this->redirect('dashboard/shoppingcart/payments/1');
    	}
    }
 
}