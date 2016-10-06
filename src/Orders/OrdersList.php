<?php
namespace Concrete\Package\DsShoppingcart\Src\Orders;
use Loader;
use \Concrete\Core\Legacy\DatabaseItemList;

defined('C5_EXECUTE') or die('Access Denied.');

class OrdersList extends DatabaseItemList {
    protected $autoSortColumns = array('oDate','oStatus');
	protected $sortBy = 'oId';
	protected $sortByDirection = 'desc';
	protected $cnvID;

	public function __construct() {
		$this->setQuery('SELECT o.oId FROM DsOrders o');
	}

	public function filterByUser($uID) {
		$this->filter('oUserId', $uID);
	}

	public function filterByOrderStatus($status) {
		$this->filter('oStatus', $status);
	}
	
	public function filterByKeywords($keywords) {
		$this->addToQuery('left join DsBillingInformation b on b.biId = o.oBillingId left join DsShippingInformation s on s.siId = o.oShippingId');

		$db = Loader::db();
		$qk = $db->quote('%' . $keywords . '%');
		$this->filter(false, "(o.oStatus like $qk or b.biName like $qk or s.siName like $qk)");	
	}
	
	public function get($num = 0, $offset = 0) {
		$r = parent::get($num, $offset);
		$orders = array();
		foreach($r as $row) {
			$orders[] = Order::getByID($row['oId']);	
		}
		return $orders;
	}

}
