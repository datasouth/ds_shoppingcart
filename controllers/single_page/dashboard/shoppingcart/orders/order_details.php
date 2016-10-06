<?php 
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage\Dashboard\Shoppingcart\Orders;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Package\DsShoppingcart\Src\Orders\Order;
use \Concrete\Package\DsShoppingcart\Src\Payments\PaymentMethods;
use Page;
use Loader;

defined('C5_EXECUTE') or die('Access Denied.');

class OrderDetails extends DashboardPageController {

    public function view($orderId='',$response=false) {
    	if(!empty($orderId)) {

            $res   = Order::getOrderDetails($orderId);
            $prods = Order::getOrderProducts($orderId);
            $pay   = PaymentMethods::getByID($res['oPaymentId']);

            $this->set('details',$res);
            $this->set('res',$prods);  
            $this->set('order_id',$orderId);
            $this->set('payment', $pay);

            if($response) {
                $this->set('successMessage','Successfully updated Order!'); 
            }   
            
        }   
    }

    public function update() {
        if ($this->isPost()) {                      
            $post = $this->post();
            Order::updateStatus($post['order_status'],$post['order_id']);            
            $this->redirect('dashboard/shoppingcart/orders/order_details/'.$post['order_id'].'/1');
        }
    }
 
}