<?php
/**
 * Generate a timestamp in base 36 to be used as a smallUrl
 * @return string
 */
function generateSmallUrl(){
	return base_convert(time(), 10, 36);
}

?>
