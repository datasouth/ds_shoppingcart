<?php
namespace Concrete\Package\DsShoppingcart\Job;

use \Concrete\Core\Job\Job as AbstractJob;
use \Concrete\Package\DsShoppingcart\Src\Cart\Cart;

defined('C5_EXECUTE') or die("Access Denied.");

class ClearCart extends AbstractJob
{

    public function getJobName()
    {
        return t("Clear Cart");
    }

    public function getJobDescription()
    {
        return t("Clears the cart database for old data!");
    }

    public function run()
    {
        Cart::clearCart();

        return t('Sucessfully cleared shopping cart!');
    }
}