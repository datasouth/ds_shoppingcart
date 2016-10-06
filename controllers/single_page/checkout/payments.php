<?php
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage\Checkout;

use \Concrete\Core\Page\Controller\PageController;
use \Concrete\Package\DsShoppingcart\Src\Payments\PaymentMethods;
use \Concrete\Package\DsShoppingcart\Src\Orders\Order;
use \Concrete\Package\DsShoppingcart\Src\Cart\Cart;
use Loader;
use Session;

defined('C5_EXECUTE') or die("Access Denied.");

class Payments extends PageController {	

    protected $session_user;
    protected $session_orderId;

    public function on_start() {       
        $this->session_user    = Session::get('TempUser');
        $this->session_orderId = Session::get('orderId');
        if(empty($this->session_user) || empty($this->session_orderId)) {
            $this->redirect('/checkout');
        }
    }

    public function view() {
    	$methods = PaymentMethods::getEnabled();
        $this->set('methods',$methods);
    }

    public function form($pmHandle='') {
    	if(!empty($pmHandle)) {
            $this->session_user = Session::get('TempUser');
            $cart               = Cart::getCart();
            $controller         = PaymentMethods::loadController($pmHandle);
            $method             = PaymentMethods::getByHandle($pmHandle);

    		$controller->checkoutForm();
    		$sets = $controller->getSets();

    		//update the order's payment method
    		Order::setPaymentMethod($method['pmId'], $this->session_orderId);

            $this->set('cart', $cart);
    		$this->set('sets', !empty($sets) ? $sets : array());
            $this->set('pmHandle',$pmHandle);
            $this->set('method', $method);
        }
    }

    public function submit() {
    	if($this->isPost()) {   
    		$data       = $this->post();		
    		$controller = PaymentMethods::loadController($data['pmHandle']);
    		$controller->submit();

    		//clear cart
    		Cart::clear();

    		$this->redirect('thank_you');
    	}
    }

}



