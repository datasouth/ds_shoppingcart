<?php
namespace Concrete\Package\DsShoppingcart\Src\Orders;

use Database;
use Session;
use Loader;
use Core;

defined('C5_EXECUTE') or die('Access Denied.');

class Order {

    public static function getByID($orderId) {
        $db = Database::get();
        $r = $db->Execute("
                SELECT orders.*,billing.biName,billing.biEmail FROM DsOrders AS orders 
                LEFT JOIN DsBillingInformation AS billing ON orders.oBillingId = billing.biId
                WHERE orders.oId = ?", array($orderId));
        if ($r) {
            $row = $r->FetchRow();
            $obj = new static();
            $obj = array_to_object($obj, $row);

            return $obj;
        }
    }

    public static function getOrderDetails($orderId) {
        $db  = Loader::db(); 
        $res = $db->getRow("SELECT oId, oStatus, oTotal, oPaymentId ,oDate, biName, biEmail, biPhone, biAddress1, biCity, biState, biCountry, biZip, siName, siEmail, siPhone, siAddress1, siCity, siState, siCountry, siZip
                        FROM DsOrders AS O 
                        LEFT JOIN DsShippingInformation AS S ON O.oShippingId = S.siId
                        LEFT JOIN DsBillingInformation AS B ON O.oBillingId = B.biId
                        WHERE O.oId = ?", array($orderId));
        return $res;
    }

    public static function insert($order=array()) {
        if(!empty($order)) {
            $db = Loader::db();
            //insert into orders
            $db->Execute('INSERT INTO DsOrders (oUserId, oBillingId, oShippingId, oStatus, oTotal, oDate) VALUES  (?,?,?,?,?,?)', $order);
            return $db->Insert_ID();
        }
       
        return $details;
    }

    public static function insertProductOrder($prod=array()) {
        if(!empty($prod)) {
            $db = Loader::db();
            $db->Execute('INSERT INTO DsOrderProducts (opOrderId, opProductId, opQuantity, opPrice) VALUES  (?,?,?,?)', $prod);
        }
        return $prod;
    }

    public static function updateStatus($value='', $orderId='') {
        $db = Loader::db();
        $db->Execute("UPDATE DsOrders SET `oStatus` = ? WHERE `oId` = ?", array($value, $orderId));
    }

    public static function setPaymentMethod($paymentId='', $orderId='') {
        if(!empty($paymentId) && !empty($orderId)) {
            $db = Loader::db();
            return $db->Execute("UPDATE DsOrders SET oPaymentId=? WHERE oId=?", array($paymentId, $orderId));
        }
    }

    public static function clear($orderId='') {
        $db = Loader::db();
        $db->Execute('DELETE FROM DsOrderProducts WHERE opOrderId = ?', $orderId);
        $db->Execute('DELETE FROM DsOrders WHERE oId = ?', $orderId);
    }

    public static function getOrderProducts($orderId='') {
        $db      = Loader::db();
        $orderId = empty($orderId) ? Session::get('orderId') : $orderId;
        $prods   = $db->getAll("SELECT * FROM DsOrderProducts WHERE opOrderId = ?", array($orderId));
        return $prods;
    }

    public function getOrderId() {
        return $this->oId;
    }

    public function getOrderDate() {
        return $this->oDate;
    }

    public function getOrderUserId() {
        return $this->oUserId;
    }
    
    public function getOrderUBillingId() {
        return $this->oBillingId;
    }
    
    public function getOrderShippingId() {
        return $this->oShippingId;
    }
    
    public function getOrderPaymentId() {
        return $this->oPaymentId;
    }
    
    public function getOrderStatus() {
        return $this->oStatus;
    }
    
    public function getOrderTotal() {
        return number_format((float)$this->oTotal, 2, '.', '');
    }

}
