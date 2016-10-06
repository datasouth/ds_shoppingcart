<?php  

namespace Concrete\Package\DsShoppingcart\Controller\SinglePage\Checkout;

use \Concrete\Core\Page\Controller\PageController;
use \Concrete\Package\DsShoppingcart\Src\Cart\Cart;
use \Concrete\Package\DsShoppingcart\Src\Orders\Order;
use \Concrete\Package\DsShoppingcart\Src\Orders\Billing as BillingModel;
use Loader;
use Session;


defined('C5_EXECUTE') or die("Access Denied.");

class Billing extends PageController {	

    protected $session_user;

    public function on_start() {       
        $this->session_user = Session::get('TempUser');
        if(empty($this->session_user)) {
            $this->redirect('/checkout');
        }
    }
	
    public function view() {
    	$db      = Loader::db();          
        $res     = Cart::getCart();
        $billing = BillingModel::get();

        $this->set('res', $res);
        $this->set('billing',$billing);        
    }  

    public function confirm() {
    	 if ($this->isPost()) {
            $bill          = BillingModel::insert($this->post()); 
            $session_order = Session::get('orderId')  ;     

            if($bill) {
                //initialize the order
                $order =  array(
                    $this->session_user,
                    $bill['billing_id'],
                    $bill['shipping_id'],
                    'Pending',
                    $bill['grandTotal'],
                    date('Y-m-d H:i:s')
                );

                if(!empty($session_order)) {
                    Order::clear($session_order);
                }

                $orderId = Order::insert($order);
                $cart    = Cart::getCart();

                foreach($cart as $prod) {
                    $p = array(
                            $orderId,
                            $prod['scProductId'],
                            $prod['scQuantity'],
                            $prod['scPrice']
                        );
                    Order::insertProductOrder($p);
                }

                Session::set('orderId',$orderId);

                $this->redirect('checkout/payments');
            }else {
                $this->redirect('shopping_cart');
            }
        }
            
    }
    
}
