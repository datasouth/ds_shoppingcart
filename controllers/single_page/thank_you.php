<?php  
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage;

use \Concrete\Core\Page\Controller\PageController;
use Session;

defined('C5_EXECUTE') or die("Access Denied.");

class ThankYou extends PageController {
	public function view() {
		Session::remove('TempUser');
		Session::remove('orderId');
	}
}