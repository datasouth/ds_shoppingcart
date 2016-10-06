<?php  
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage;

use CollectionAttributeKey;
use Session;
use Loader;
use User;

use \Concrete\Core\Page\Single as SinglePage;
use \Concrete\Core\Page\Controller\PageController;
use \Concrete\Package\DsShoppingcart\Src\Cart\Cart;

defined('C5_EXECUTE') or die("Access Denied.");

class ShoppingCart extends PageController {

	protected $session_user;

	public function on_start() {			
		$this->session_user = Session::get('TempUser');
		if(empty($this->session_user)) {
			Session::set('TempUser', time());
			$this->session_user = Session::get('TempUser');
		}
	}
	
    public function view($response='') {
    	$db  = Loader::db();				
		$res = Cart::getCart();

		$this->set('res', $res);
		$this->set('response',$response);
    }

    public function add($prodId = false) {
    	if($prodId) {
    		Cart::insert($prodId);    		
    	}
    	$this->redirect('/shopping_cart');
    }

    public function update() {
    	if($this->isPost()) {
            Cart::update($this->post());
    		$this->redirect('shopping_cart/1');
    	}
    }

    public function remove($rowId = false) {
    	if($rowId) {
            Cart::remove($rowId);    		
      		$this->redirect('/shopping_cart');
    	}
    }
       
}