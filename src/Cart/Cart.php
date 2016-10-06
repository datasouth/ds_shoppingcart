<?php
namespace Concrete\Package\DsShoppingcart\Src\Cart;

use Core;
use Loader;
use Page;
use Session;

defined('C5_EXECUTE') or die('Access Denied.');

class Cart {

	public static function getCart() {
		$res = array();
		$session_user = Session::get('TempUser');
		if(!empty($session_user)) {
			$db  = Loader::db();
			$res = $db->getAll("SELECT * FROM DsShoppingCart WHERE scUserid = ?", array($session_user));
		}
		return $res;		
	}

	public static function insert($prodId='') {
		if(!empty($prodId)) {
			$db     = Loader::db();    		
    		$userId = Session::get('TempUser');
    		$date   = Loader::helper('date'); 

    		//check if product exist on the cart			
			$res = $db->getRow("SELECT scId, scQuantity FROM DsShoppingCart WHERE scUserid = ? AND scProductId = ?", array($userId, $prodId));
			if(!empty($res['scId'])) { //update the row
				$data = array(				    
				    'scQuantity' => $res['scQuantity'] + 1,
				);
				$db->update('DsShoppingCart', $data, array('scProductId' => $prodId, 'scUserId' => $userId));
			}else { //insert new row
			  $prod = Page::getByID($prodId);  
			  $data = array(
		        $userId,
		        $prodId,
		        1,
		        $prod->getCollectionAttributeValue('ds_product_price'),
		        $date->getLocalDateTime('now', 'Y-m-d G:i:s')
		      );

		      $db->Execute('INSERT INTO DsShoppingCart (scUserId, scProductId, scQuantity, scPrice, scLastUpdate) VALUES  (?,?,?,?,?)', $data);
			}
		}
		return $prodId;

	}

	public static function update($post=array()) {
		$db   = Loader::db();	
		$date = Loader::helper('date');

		foreach($post as $key => $prod) {			
			$id = explode('_', $key); //format: prod_ID
			$q  = $prod['quantity'];
			$dt = $date->getLocalDateTime('now', 'Y-m-d G:i:s');
			$db->Execute("UPDATE DsShoppingCart SET scQuantity = ?, scLastUpdate = ? WHERE scId=?", array($q, $dt, $id[1]));
		}
		return 1;		
	}

	public static function remove($rowId='') {
		if(!empty($rowId)) {
			$db = Loader::db();
    		return $db->Execute('DELETE FROM DsShoppingCart WHERE scId=?', array($rowId));
		}
	}

	public static function clear() {
		$db     = Loader::db();
		$userId = Session::get('TempUser');
		$db->Execute('DELETE FROM DsShoppingCart WHERE scUserId=?', array($userId));
	}

	public static function clearCart() {
		$db = Loader::db();
    	$db->Execute('DELETE FROM DsShoppingCart WHERE scLastUpdate < CURDATE() - INTERVAL 1 DAY');
    	Session::set('cartItems','0');
    	Session::set('grandTotal','0');
	}

}