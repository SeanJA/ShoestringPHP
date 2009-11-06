<?php

/**
 * Check if an array is an associative array or not
 * @param array $array
 * @return boolean
 */
function array_is_associative (array $array) {
	if ( is_array($array) && ! empty($array) ) {
		for ( $iterator = count($array) - 1; $iterator; $iterator-- ) {
			if ( ! array_key_exists($iterator, $array) ) {
				return true;
			}
		}
		return ! array_key_exists(0, $array);
	}
	return false;
}

?>
