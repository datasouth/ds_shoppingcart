<?php
namespace Concrete\Package\DsShoppingcart\Src\Payments;

use Core;
use Loader;
use Package;
use Controller;
use View;
use \Concrete\Core\Config\ConfigStore;

defined('C5_EXECUTE') or die('Access Denied.');

class PaymentMethods extends Controller {	

	public static function add($handle, $name, $enabled = 0, $pkg = false) {
		$pkgID = 0;
		if (is_object($pkg)) {
			$pkgID = $pkg->getPackageID();
		}
		$db = Loader::db();
		$pm = self::getByHandle($handle);
		if(!isset($pm['pmId'])) {
			$db->Execute('insert into DsPaymentMethods (pmHandle, pmName, pmIsEnabled, pkgID) values (?, ?, ?, ?)', array($handle, $name, $enabled, $pkgID));
			$pm['pmId'] = $db->Insert_ID();	
		}

		return $pm;
		
	}

	public static function getList($col='*') {
		$db  = Loader::db();
		$res = $db->getAll("SELECT {$col} FROM DsPaymentMethods");
		return $res;
	}

	public static function getEnabled($col='*') {
		$db  = Loader::db();
		$res = $db->getAll("SELECT {$col} FROM DsPaymentMethods WHERE pmIsEnabled = 1");
		return $res;
	}

	/*public static function getPendingList() {
		$db = Loader::db();
		$paymentMethods = self::getList('pmHandle');		
		
		$th    = Loader::helper('text');
		$avail = array();		
		$directories = self::mapSrcDirectories($dh);
		if (!empty($directories)) {			
			foreach($directories as $paymentMethodHandle) {
				$temp = self::getByHandle($th->uncamelcase($paymentMethodHandle[0]));
				if (empty($temp)) {
					$avail[] = $paymentMethodHandle[0];
				}
			}
		}
		return $avail;
	}

	public static function mapSrcDirectories() {
		$dh           = Loader::helper('file');
		$directories  = array();
		$packages_dir = DIR_BASE .REL_DIR_PACKAGES;
		$packages     = $dh->getDirectoryContents($packages_dir);

		if(!empty($packages)) {
			foreach($packages as $package) {
				$sub_dir = $packages_dir .'/'. $package . '/src/Payments/PaymentMethods';
				if(is_dir($sub_dir)) {
					$directories[] = $dh->getDirectoryContents($sub_dir);					
				}
			}
		}
		return $directories;
	}*/



	public static function getByHandle($pmHandle){
        $db = Loader::db();
        $pm = $db->GetRow("SELECT * FROM DsPaymentMethods WHERE pmHandle=?",$pmHandle);
        return $pm;
    }

    public static function getByID($pmId){
        $db = Loader::db();
        $pm = $db->GetRow("SELECT * FROM DsPaymentMethods WHERE pmId=?",$pmId);
        return $pm;
    }

	public static function setConfig($key='',$value='',$pkgId='') {
		$config = new ConfigStore();
		$config->set($key, $value, $pkgId);
		
	}

	public static function getConfig($pkgId='') {
		if(!empty($pkgId)) {
			$db = Loader::db();
			$r  = array();
			if (!$db) {
				return;
			}

			$res = $db->getAll("SELECT * FROM ConfigStore WHERE pkgID = ?", array($pkgId));
			foreach($res as $c_row) {
				$r[$c_row['cfKey']] = $c_row['cfValue'];
			}
			return $r;
			
		}else
			return false;
		
	}

	public static function loadController($handle='') {
        //load the method controller
        $th  = Loader::helper('text');
        $row = self::getByHandle($handle);
        $pkg = ($row['pkgID']) ? $th->camelcase($row['pmHandle']) : 'DsShoppingcart';
        
        $handle     = $th->camelcase($handle);
        $namespace  = "\\Concrete\\Package\\".$pkg."\\Src\\Payments\\PaymentMethods\\".$handle;        
        $className  = "Controller";
        $namespace  = $namespace.'\\'.$className;
        $controller = new $namespace();
        return $controller;
    }

    public static function remove($handle='') {
    	$db = Loader::db();
        $db->query('DELETE FROM DsPaymentMethods WHERE pmHandle = ?', array($handle));  
    }

    public function renderCheckoutForm($pmHandle='', $pkgHandle='', $args=array()) {
    	//Loader::packageElement("payments/".$pmHandle."/edit_form", $pkgHandle, $args));
    }

}