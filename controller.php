<?php 

namespace Concrete\Package\DsShoppingcart;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Package\Package;
use Loader; 
use \Concrete\Core\Page\Theme\Theme; 
use PageTemplate;
use PageType;
use Concrete\Core\Page\Type\PublishTarget\Type\Type as PublishTargetType;
use CollectionAttributeKey;
use \Concrete\Core\User\Group\Group as Group;
use \Concrete\Core\Permission\Access\Entity\GroupEntity as GroupPermissionAccessEntity;
use \Concrete\Core\Permission\Access\Access as PermissionAccess;
use \Concrete\Core\Permission\Key\Key as PagePermissionKey;
use \Concrete\Core\Page\Type\Type as CollectionType;
use \Concrete\Core\Block\BlockType\BlockType;
use \Concrete\Core\Page\Single as SinglePage;
use \Concrete\Core\Attribute\Type as AttributeType;
use \Concrete\Core\Job\Job;

use \Concrete\Core\Attribute\Key\Category as AttributeKeyCategory;
use \Concrete\Package\DsShoppingcart\Src\Payments\PaymentMethods;
use AttributeSet;


class Controller extends Package
{

    protected $pkgHandle = 'ds_shoppingcart';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '0.9.1';
    //protected $pkgAllowsFullContentSwap = true;

    public function getPackageDescription()
    {
        return t('simple shopping cart that uses the default features of Concrete5.');
    }

    public function getPackageName()
    {
        return t('DS Shopping Cart');
    }

    public function install()
    {
        Loader::model('single_page');

        $pkg = parent::install();       
        
        $this->addBlockTypes($pkg);
        $this->addAttributes($pkg);
        $this->addSinglePages($pkg); 
        $this->addJobs($pkg); 

        //add the default payment gateway
         PaymentMethods::add('email_order', t('Email Order Method'), 0);

    }

    public function uninstall() {
        parent::uninstall();
    }

    private function addBlockTypes($pkg) {
        BlockType::installBlockTypeFromPackage('ds_buy_button', $pkg);
        BlockType::installBlockTypeFromPackage('product_list', $pkg);  
        BlockType::installBlockTypeFromPackage('ds_cart_summary', $pkg);
    }

    private function addAttributes($pkg) {
        //first create the Product set:
        $eaku = AttributeKeyCategory::getByHandle('collection');
        $eaku->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_SINGLE);
        $set = $eaku->addSet('product',t('Product'),$pkg, 0);
        $asID = $set->asID; 

        //adds the Product attritubes
        $dsProdName = CollectionAttributeKey::getByHandle('ds_product_name');
        if (!$dsProdName instanceof CollectionAttributeKey) {
             $dsProdName = CollectionAttributeKey::add("text", array(
                'akHandle' => 'ds_product_name',
                'asID'     => $asID,
                'akName'   => t('Product Name')), $pkg);
        }

        $dsProdSku = CollectionAttributeKey::getByHandle('ds_product_sku');
        if (!$dsProdSku instanceof CollectionAttributeKey) {
             $dsProdSku = CollectionAttributeKey::add("text", array(
                'akHandle' => 'ds_product_sku',
                'asID'     => $asID,
                'akName'   => t('Product SKU')), $pkg);
        }

        $dsProdImage = CollectionAttributeKey::getByHandle('ds_product_image');
        if (!$dsProdImage instanceof CollectionAttributeKey) {
             $dsProdImage = CollectionAttributeKey::add("image_file", array(
                'akHandle' => 'ds_product_image',
                'asID'     => $asID,
                'akName'   => t('Product Image')), $pkg);
        }

        $dsProdPrice = CollectionAttributeKey::getByHandle('ds_product_price');
        if (!$dsProdPrice instanceof CollectionAttributeKey) {
             $dsProdPrice = CollectionAttributeKey::add("text", array(
                'akHandle' => 'ds_product_price',
                'asID'     => $asID,
                'akName'   => t('Product Price')), $pkg);
        }

        $dsProdManu = CollectionAttributeKey::getByHandle('ds_product_manufacturer');
        if (!$dsProdManu instanceof CollectionAttributeKey) {
             $dsProdManu = CollectionAttributeKey::add("text", array(
                'akHandle' => 'ds_product_manufacturer',
                'asID'     => $asID,
                'akName'   => t('Product Manufacturer')), $pkg);
        }

        $dsProdDesc = CollectionAttributeKey::getByHandle('ds_product_description');
        if (!$dsProdDesc instanceof CollectionAttributeKey) {
             $dsProdDesc = CollectionAttributeKey::add("textarea", array(
                'akHandle' => 'ds_product_description',
                'asID'     => $asID,
                'akName'   => t('Product Description')), $pkg);
        }
    }

    private function addSinglePages($pkg) {
        //adds a single page and it's attributes
        $sp = SinglePage::add('/shopping_cart',$pkg);           
        $sp->setAttribute("exclude_nav", 1);

        //adds a single page and it's attributes
        $sp = SinglePage::add('/thank_you',$pkg);           
        $sp->setAttribute("exclude_nav", 1);
       
        //Product List single page
        $sp_prod_list = SinglePage::add('/product_list',$pkg); 
        $sp_prod_list->setAttribute("exclude_nav", 0); 

        //Checkout  
        $sp_checkout = SinglePage::add('/checkout',$pkg); 
        $sp_checkout->setAttribute("exclude_nav", 1); 

        $sp_billing = SinglePage::add('/checkout/billing',$pkg); 
        $sp_billing->setAttribute("exclude_nav", 1); 

        $sp_shipping = SinglePage::add('/checkout/shipping',$pkg); 
        $sp_shipping->setAttribute("exclude_nav", 1); 

        $sp_payments = SinglePage::add('/checkout/payments',$pkg); 
        $sp_payments->setAttribute("exclude_nav", 1);  

        $p = SinglePage::add('/dashboard/shoppingcart', $pkg);
        if (is_object($p)) {
            $p->update(array('cName' => t('Shoppingcart'), 'cDescription' => 'Shoppingcart Plugin'));
        }

        $p = SinglePage::add('/dashboard/shoppingcart/orders', $pkg);
        if (is_object($p)) {
            $p->update(array('cName' => t('Orders'), 'cDescription' => 'Orders Management Page'));
        }

        $p = SinglePage::add('/dashboard/shoppingcart/orders/order_details', $pkg);
        $p->setAttribute("exclude_nav", 1);  
        if (is_object($p)) {
            $p->update(array('cName' => t('Orders Details'), 'cDescription' => 'Order Details Page'));
        }

        $p = SinglePage::add('/dashboard/shoppingcart/payments', $pkg);
        if (is_object($p)) {
            $p->update(array('cName' => t('Payment Methods'), 'cDescription' => 'Payment Methods'));
        }

        $p = SinglePage::add('/dashboard/shoppingcart/payments/payment_details', $pkg);
        $p->setAttribute("exclude_nav", 1);  
        if (is_object($p)) {
            $p->update(array('cName' => t('Payment Details'), 'cDescription' => 'Payment Details Page'));
        }

         $p = SinglePage::add('/dashboard/shoppingcart/products', $pkg);
        if (is_object($p)) {
            $p->update(array('cName' => t('Product List'), 'cDescription' => 'Product List Page'));
        }
    }

    public function addJobs($pkg) {
        $job = Job::installByPackage('clear_cart', $pkg);
        $job->setSchedule(1, 'days', 1);
    }

}