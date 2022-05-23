<?php
/**
 * SeaFood Company Framework: strings manipulations
 *
 * @package	seafood_company
 * @since	seafood_company 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'SEAFOOD_COMPANY_MULTIBYTE' ) ) define( 'SEAFOOD_COMPANY_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('seafood_company_strlen')) {
	function seafood_company_strlen($text) {
		return SEAFOOD_COMPANY_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('seafood_company_strpos')) {
	function seafood_company_strpos($text, $char, $from=0) {
		return SEAFOOD_COMPANY_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('seafood_company_strrpos')) {
	function seafood_company_strrpos($text, $char, $from=0) {
		return SEAFOOD_COMPANY_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('seafood_company_substr')) {
	function seafood_company_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = seafood_company_strlen($text)-$from;
		}
		return SEAFOOD_COMPANY_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('seafood_company_strtolower')) {
	function seafood_company_strtolower($text) {
		return SEAFOOD_COMPANY_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('seafood_company_strtoupper')) {
	function seafood_company_strtoupper($text) {
		return SEAFOOD_COMPANY_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('seafood_company_strtoproper')) {
	function seafood_company_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<seafood_company_strlen($text); $i++) {
			$ch = seafood_company_substr($text, $i, 1);
			$rez .= seafood_company_strpos(' .,:;?!()[]{}+=', $last)!==false ? seafood_company_strtoupper($ch) : seafood_company_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('seafood_company_strrepeat')) {
	function seafood_company_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('seafood_company_strshort')) {
	function seafood_company_strshort($str, $maxlength, $add='...') {
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0) 
			return '';
		if ($maxlength >= seafood_company_strlen($str)) 
			return strip_tags($str);
		$str = seafood_company_substr(strip_tags($str), 0, $maxlength - seafood_company_strlen($add));
		$ch = seafood_company_substr($str, $maxlength - seafood_company_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = seafood_company_strlen($str) - 1; $i > 0; $i--)
				if (seafood_company_substr($str, $i, 1) == ' ') break;
			$str = trim(seafood_company_substr($str, 0, $i));
		}
		if (!empty($str) && seafood_company_strpos(',.:;-', seafood_company_substr($str, -1))!==false) $str = seafood_company_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('seafood_company_strclear')) {
	function seafood_company_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (seafood_company_substr($text, 0, seafood_company_strlen($open))==$open) {
					$pos = seafood_company_strpos($text, '>');
					if ($pos!==false) $text = seafood_company_substr($text, $pos+1);
				}
				if (seafood_company_substr($text, -seafood_company_strlen($close))==$close) $text = seafood_company_substr($text, 0, seafood_company_strlen($text) - seafood_company_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('seafood_company_get_slug')) {
	function seafood_company_get_slug($title) {
		return seafood_company_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('seafood_company_strmacros')) {
	function seafood_company_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('seafood_company_unserialize')) {
	function seafood_company_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			return $data;
		} else
			return $str;
	}
}
?>