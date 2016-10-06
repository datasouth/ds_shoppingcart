<?php 
namespace Concrete\Package\DsShoppingcart\Controller\SinglePage\Dashboard\Shoppingcart\Payments;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\Config\ConfigStore;
use \Concrete\Package\DsShoppingcart\Src\Payments\PaymentMethods;
use Page;
use Loader;

defined('C5_EXECUTE') or die('Access Denied.');

class PaymentDetails extends DashboardPageController {

    public function view($pmId='',$response='') {
        if($pmId) {
            $payment = new ConfigStore();
            $pkgID   = $this->c->pkgID;
            $res     = PaymentMethods::getByID($pmId);
            $configs = $payment->getListByPackage($pkgID);

            $values = array();
            foreach($configs as $keys) {
                $values[$keys] = $this->getConfigValue($keys, $pkgID);
            }

            $this->set("method", $res);
            $this->set("response", $response);
            $this->set("values", $values);
        }
    }

    public function save() {
        
        if($this->isPost()) {
            //update the method specific fields
            $post       = $this->post();
            $controller = PaymentMethods::loadController($post['handle']);
            $controller->save($post);

            //update the required fields
            $db = Loader::db();
            $db->Execute("UPDATE DsPaymentMethods SET `pmName` = ?, `pmIsEnabled` = ? WHERE `pmId` = ?", array($post['required_name'], $post['required_enabled'], $post['payment_id']));

            $this->redirect('dashboard/shoppingcart/payments/payment_details/'.$post['payment_id'].'/1');
        }
    }

    public function getConfigValue($key='', $pkgID='') {
        if(!empty($key) && !empty($pkgID)) {
            $db  = Loader::db();
            $res = $db->getOne("SELECT cfValue FROM ConfigStore WHERE cfKey = ? AND pkgID = ?", array($key, $pkgID));
            return $res;
        } 
    }
 
}