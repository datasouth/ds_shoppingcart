<?php
namespace Concrete\Package\DsShoppingcart\Src\Orders;

use Core;
use Loader;
use Page;
use Session;

defined('C5_EXECUTE') or die('Access Denied.');

class Billing {

	public static function get() {
		$res = array();
		$session_user = Session::get('TempUser');
		if(!empty($session_user)) {
			$db   = Loader::db();
			$bill = $db->getAll("SELECT * FROM DsBillingInformation WHERE biUserId = ?", array($session_user));
			$ship = $db->getAll("SELECT * FROM DsShippingInformation WHERE siUserId = ?", array($session_user));
			$res  = array_merge($bill,$ship);
		}
		return $res;
	}

	public static function insert($post=array()) {
		$temp = array();
		if($post) {
			$session_user = Session::get('TempUser');
			$db           = Loader::db(); 

			//check if user billing and shipping info exist
			$existBilling  = $db->getOne("SELECT biId FROM DsBillingInformation WHERE biUserId = ?", array($session_user));
			$existShipping = $db->getOne("SELECT siId FROM DsShippingInformation WHERE siUserId = ?", array($session_user));

			$billing = array(
                $session_user,
                $post['billing']['contact'],
                $post['billing']['email'],
                $post['billing']['phone'],
                $post['billing']['address'],
                $post['billing']['city'],
                $post['billing']['state'],
                $post['billing']['country'],
                $post['billing']['zip']
            );

			if($existBilling) { //update
				$temp['billing_id'] = $existBilling;
				$billing[]          = $existBilling;
				$db->Execute("UPDATE DsBillingInformation SET biUserId=?, biName=?, biEmail=? ,biPhone=? ,biAddress1=?, biCity=?, biState=?, biCountry=?, biZip=? WHERE biId=?", $billing);
			}else { //insert
				
	            $db->Execute('INSERT INTO DsBillingInformation (biUserId,biName,biEmail,biPhone,biAddress1,biCity,biState,biCountry,biZip) VALUES  (?,?,?,?,?,?,?,?,?)', $billing);
            	$temp['billing_id']  = $db->Insert_ID();
			}
			
            if($post['same_details'] == 1) {
                $shipping = $billing;
            }else {
                $shipping = array(
                    $session_user,
                    $post['shipping']['contact'],
                    $post['shipping']['email'],
                    $post['shipping']['phone'],
                    $post['shipping']['address'],
                    $post['shipping']['city'],
                    $post['shipping']['state'],
                    $post['shipping']['country'],
                    $post['shipping']['zip']
                );
            }

            if($existShipping) { //update
				$temp['shipping_id'] = $existShipping;
				if(!$post['same_details'])
					$shipping[] = $existBilling;				
				$db->Execute("UPDATE DsShippingInformation SET siUserId=?, siName=?, siEmail=? ,siPhone=? ,siAddress1=?, siCity=?, siState=?, siCountry=?, siZip=? WHERE siId=?", $shipping);
			}else { //insert
				
	            $db->Execute('INSERT INTO DsShippingInformation (siUserId,siName,siEmail,siPhone,siAddress1,siCity,siState,siCountry,siZip) VALUES  (?,?,?,?,?,?,?,?,?)', $shipping);
            	$temp['shipping_id']  = $db->Insert_ID();
			}

            $temp['grandTotal']  = $post['grandtotal'];
		}
		return $temp;
	}

}