<?php
/**
 * SeaFood Company Framework: theme variables storage
 *
 * @package	seafood_company
 * @since	seafood_company 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('seafood_company_storage_get')) {
	function seafood_company_storage_get($var_name, $default='') {
		global $SEAFOOD_COMPANY_STORAGE;
		return isset($SEAFOOD_COMPANY_STORAGE[$var_name]) ? $SEAFOOD_COMPANY_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('seafood_company_storage_set')) {
	function seafood_company_storage_set($var_name, $value) {
		global $SEAFOOD_COMPANY_STORAGE;
		$SEAFOOD_COMPANY_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('seafood_company_storage_empty')) {
	function seafood_company_storage_empty($var_name, $key='', $key2='') {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($SEAFOOD_COMPANY_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($SEAFOOD_COMPANY_STORAGE[$var_name][$key]);
		else
			return empty($SEAFOOD_COMPANY_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('seafood_company_storage_isset')) {
	function seafood_company_storage_isset($var_name, $key='', $key2='') {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($SEAFOOD_COMPANY_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($SEAFOOD_COMPANY_STORAGE[$var_name][$key]);
		else
			return isset($SEAFOOD_COMPANY_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('seafood_company_storage_inc')) {
	function seafood_company_storage_inc($var_name, $value=1) {
		global $SEAFOOD_COMPANY_STORAGE;
		if (empty($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = 0;
		$SEAFOOD_COMPANY_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('seafood_company_storage_concat')) {
	function seafood_company_storage_concat($var_name, $value) {
		global $SEAFOOD_COMPANY_STORAGE;
		if (empty($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = '';
		$SEAFOOD_COMPANY_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('seafood_company_storage_get_array')) {
	function seafood_company_storage_get_array($var_name, $key, $key2='', $default='') {
		global $SEAFOOD_COMPANY_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($SEAFOOD_COMPANY_STORAGE[$var_name][$key]) ? $SEAFOOD_COMPANY_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($SEAFOOD_COMPANY_STORAGE[$var_name][$key][$key2]) ? $SEAFOOD_COMPANY_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('seafood_company_storage_set_array')) {
	function seafood_company_storage_set_array($var_name, $key, $value) {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = array();
		if ($key==='')
			$SEAFOOD_COMPANY_STORAGE[$var_name][] = $value;
		else
			$SEAFOOD_COMPANY_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('seafood_company_storage_set_array2')) {
	function seafood_company_storage_set_array2($var_name, $key, $key2, $value) {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = array();
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name][$key])) $SEAFOOD_COMPANY_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$SEAFOOD_COMPANY_STORAGE[$var_name][$key][] = $value;
		else
			$SEAFOOD_COMPANY_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('seafood_company_storage_set_array_after')) {
	function seafood_company_storage_set_array_after($var_name, $after, $key, $value='') {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = array();
		if (is_array($key))
			seafood_company_array_insert_after($SEAFOOD_COMPANY_STORAGE[$var_name], $after, $key);
		else
			seafood_company_array_insert_after($SEAFOOD_COMPANY_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('seafood_company_storage_set_array_before')) {
	function seafood_company_storage_set_array_before($var_name, $before, $key, $value='') {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = array();
		if (is_array($key))
			seafood_company_array_insert_before($SEAFOOD_COMPANY_STORAGE[$var_name], $before, $key);
		else
			seafood_company_array_insert_before($SEAFOOD_COMPANY_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('seafood_company_storage_push_array')) {
	function seafood_company_storage_push_array($var_name, $key, $value) {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($SEAFOOD_COMPANY_STORAGE[$var_name], $value);
		else {
			if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name][$key])) $SEAFOOD_COMPANY_STORAGE[$var_name][$key] = array();
			array_push($SEAFOOD_COMPANY_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('seafood_company_storage_pop_array')) {
	function seafood_company_storage_pop_array($var_name, $key='', $defa='') {
		global $SEAFOOD_COMPANY_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($SEAFOOD_COMPANY_STORAGE[$var_name]) && is_array($SEAFOOD_COMPANY_STORAGE[$var_name]) && count($SEAFOOD_COMPANY_STORAGE[$var_name]) > 0) 
				$rez = array_pop($SEAFOOD_COMPANY_STORAGE[$var_name]);
		} else {
			if (isset($SEAFOOD_COMPANY_STORAGE[$var_name][$key]) && is_array($SEAFOOD_COMPANY_STORAGE[$var_name][$key]) && count($SEAFOOD_COMPANY_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($SEAFOOD_COMPANY_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('seafood_company_storage_inc_array')) {
	function seafood_company_storage_inc_array($var_name, $key, $value=1) {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = array();
		if (empty($SEAFOOD_COMPANY_STORAGE[$var_name][$key])) $SEAFOOD_COMPANY_STORAGE[$var_name][$key] = 0;
		$SEAFOOD_COMPANY_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('seafood_company_storage_concat_array')) {
	function seafood_company_storage_concat_array($var_name, $key, $value) {
		global $SEAFOOD_COMPANY_STORAGE;
		if (!isset($SEAFOOD_COMPANY_STORAGE[$var_name])) $SEAFOOD_COMPANY_STORAGE[$var_name] = array();
		if (empty($SEAFOOD_COMPANY_STORAGE[$var_name][$key])) $SEAFOOD_COMPANY_STORAGE[$var_name][$key] = '';
		$SEAFOOD_COMPANY_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('seafood_company_storage_call_obj_method')) {
	function seafood_company_storage_call_obj_method($var_name, $method, $param=null) {
		global $SEAFOOD_COMPANY_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($SEAFOOD_COMPANY_STORAGE[$var_name]) ? $SEAFOOD_COMPANY_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($SEAFOOD_COMPANY_STORAGE[$var_name]) ? $SEAFOOD_COMPANY_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('seafood_company_storage_get_obj_property')) {
	function seafood_company_storage_get_obj_property($var_name, $prop, $default='') {
		global $SEAFOOD_COMPANY_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($SEAFOOD_COMPANY_STORAGE[$var_name]->$prop) ? $SEAFOOD_COMPANY_STORAGE[$var_name]->$prop : $default;
	}
}
?>