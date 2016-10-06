<?php 
namespace Concrete\Package\DsShoppingcart\Src\Payments\PaymentMethods\EmailOrder;

use Concrete\Package\DsShoppingcart\Src\Payments\PaymentMethods;
use Concrete\Package\DsShoppingcart\Src\Cart;
use Concrete\Package\DsShoppingcart\Src\Orders\Order;
use Concrete\Package\DsShoppingcart\Src\Orders\Billing;
use Concrete\Core\Config\ConfigStore;
use Session;
use Package;
use Page;
use Core;
use View;
use Loader;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends PaymentMethods {

	protected $methodHandle = 'email_order';
	
	public function save($data='') { 
		if($data) {
			$pkg = Package::getByHandle('ds_shoppingcart');
			parent::setConfig('PAYMENT_METHOD_EMAIL_ORDER_EMAIL_ADDRESS', $data['PAYMENT_METHOD_EMAIL_ORDER_EMAIL_ADDRESS'], $pkg->getPackageID());    
		}
		return true;
	}

	public function checkoutForm() {
		$this->set('formAction', View::url('checkout/payments/submit'));

		return;
	}

	public function submit() {
		$pkg    = Package::getByHandle('ds_shoppingcart');
		$config = parent::getConfig($pkg->getPackageID());
		$prods  = Order::getOrderProducts();
		$order  = Order::getOrderDetails(Session::get('orderId'));
        if(empty($config['PAYMENT_METHOD_EMAIL_ORDER_EMAIL_ADDRESS'])) {
            echo '<script type="text/javascript">alert("'.t('Please set the email receipient on the Payment method Dashboard for Email Order method!').'");</script>';
            $this->redirect('checkout/payments');
        }else {
            $this->sendEmailOrder($prods, $order, $config['PAYMENT_METHOD_EMAIL_ORDER_EMAIL_ADDRESS']);
        }
		
	}

	protected function sendEmailOrder($products, $order, $emailTo) {
        //email the order
            $body = '<html><body>
                    <div class="col col-sm-12">
                        <table border="0" class="table" cellspacing="0" cellpadding="0" width="100%">
                            <tbody><tr>                                 
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>                                
                            </tr>';

                                    if(!empty($products)) {
                                        $grandTotal = 0;

                                        foreach($products as $row) {

                                            $prod   = \Page::getByID($row['opProductId']);

                                            $subTotal  = 0;             
                                            $rowId     = $row['opId'];
                                            $prodName  = $prod->getCollectionAttributeValue('ds_product_name');
                                            $prodImage = ($prod->getAttribute('ds_product_image')) ? $prod->getAttribute('ds_product_image')->getVersion()->getRelativePath() : ''; 
                                            $quantity  = $row['opQuantity'];
                                            $price     = (is_numeric($row['opPrice'])) ? number_format($row['opPrice'], 2, '.', '') : $row['opPrice']; 
                                            $subTotal  = $price * $quantity;

                                            $grandTotal += $subTotal;
                                
                                            $body .= '<tr>                                            
                                                        <td>'.$prodName .'</td>
                                                        <td>'.$quantity .'</td>
                                                        <td>'.number_format($price, 2, '.', '').'</td>                        
                                                    </tr>';
                                        }
                                    }
                                $body .= '
                                <tr>
                                    <td colspan="3" align="right">Order Total:</td>
                                    <td>'.number_format($grandTotal, 2, '.', '').'</td>
                                </tr>

                            </tbody></table>
                    </div>
                    <div class="col col-sm-12">
                        <div class="col col-sm-6">
                                <div class="row"><h1>Billing Information</h1></div>
                                <div class="row">
                                    <div class="col col-sm-6">Contact Name</div>
                                    <div class="col col-sm-6">
                                       '.$order['biName'].'                             
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm-6">Email</div>
                                    <div class="col col-sm-6">
                                       '.$order['biEmail'].'                               
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm-6">Phone</div>
                                    <div class="col col-sm-6">
                                        '.$order['biPhone'].'                                 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm-6">Address</div>
                                    <div class="col col-sm-6">
                                       '.$order['biAddress1'].'                                 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm-6">Zip Code</div>
                                    <div class="col col-sm-6">
                                        '.$order['biZip'].'                              
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col col-sm-6">Country</div>
                                        <div class="col col-sm-6">
                                            '.$order['biCountry'].'                                 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-sm-6">State</div>
                                        <div class="col col-sm-6">
                                            '.$order['biState'].'  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-sm-6">City</div>
                                        <div class="col col-sm-6">
                                            '.$order['biCity'].'  
                                        </div>
                                    </div>
                                    
                         </div>

                        <div class="col col-sm-6 shipping">
                            <div class="row"><h1>Shipping Information</h1></div>
                            <div class="row">
                                <div class="col col-sm-6">Contact Name</div>
                                <div class="col col-sm-6">
                                   '.$order['siName'].'                               
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-sm-6">Email</div>
                                <div class="col col-sm-6">
                                    '.$order['siEmail'].'                                 
                                </div>
                            </div>
                             <div class="row">
                                    <div class="col col-sm-6">Phone</div>
                                    <div class="col col-sm-6">
                                         '.$order['siPhone'].'                                 
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col col-sm-6">Address</div>
                                <div class="col col-sm-6">
                                    '.$order['siAddress'].'                               
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-sm-6">Zip Code</div>
                                <div class="col col-sm-6">
                                     '.$order['siZip'].'                                
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col col-sm-6">Country</div>
                                    <div class="col col-sm-6">
                                         '.$order['siCountry'].'                                     
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm-6">State</div>
                                    <div class="col col-sm-6">
                                        '.$order['siState'].'   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm-6">City</div>
                                    <div class="col col-sm-6">
                                         '.$order['siCity'].'   
                                    </div>
                                </div>                              
                        </div>
                    </div></body></html>';

            $mh = Loader::helper('mail');
            $mh->from('noreply@concrete5.org');
            $mh->to($emailTo);
            $mh->setSubject('New Order');
            $mh->setBodyHTML($body);
            $mh->sendMail();
            
      
         return $grandTotal;
    }

}