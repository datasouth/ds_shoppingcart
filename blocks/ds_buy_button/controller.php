<?php 
namespace Concrete\Package\DsShoppingcart\Block\DsBuyButton;

use \Concrete\Core\Block\BlockController;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController {

    protected $btInterfaceWidth = '400';
    protected $btInterfaceHeight = '200';

    function __construct($obj = null) {
        parent::__construct($obj);
    }

    public function getBlockTypeDescription() {
        return t('Buy Button');
    }

    public function getBlockTypeName() {
        return t('Buy Button');
    }

    public function view() {        
        $page = \Page::getCurrentPage();
        $this->set('pageId',$page->getCollectionID());
    }

}