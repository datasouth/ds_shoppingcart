<?php 
namespace Concrete\Package\DsShoppingcart\Block\DsCartSummary;

use \Concrete\Core\Block\BlockController;
use Session;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController {

    protected $btInterfaceWidth = '400';
    protected $btInterfaceHeight = '200';

    function __construct($obj = null) {
        parent::__construct($obj);
    }

    public function getBlockTypeDescription() {
        return t('Cart Summary');
    }

    public function getBlockTypeName() {
        return t('Cart Summary');
    }

    public function view() {        
        $this->set('quantity', Session::get('cartItems'));
        $this->set('total', Session::get('grandTotal'));
    }

}