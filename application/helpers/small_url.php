<?php
function generateSmallUrl(){
	return base_convert(time(), 10, 36);
}

?>
