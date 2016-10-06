<?php 
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage\Dashboard;
use \Concrete\Core\Page\Controller\PageController;
use Loader;

defined('C5_EXECUTE') or die("Access Denied.");

class Shoppingcart extends PageController {

    public function view() {
       $this->redirect('/dashboard/shoppingcart/orders');
    }

}