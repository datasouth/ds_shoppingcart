<?php  

namespace Concrete\Package\DsShoppingcart\Controller\SinglePage;
use \Concrete\Core\Page\Controller\PageController;
use Loader;

defined('C5_EXECUTE') or die("Access Denied.");

class ProductList extends PageController {	
	
    public function view() {
    	$c      = \Page::getCurrentPage();    	
    	$pageID = $c->getCollectionID();

    	$list   = new \Concrete\Core\Page\PageList();    	
    	$list->filterByParentID($pageID);

    	$pages  = $list->getResults();

    	$this->set('products', $pages);
    }
    
}