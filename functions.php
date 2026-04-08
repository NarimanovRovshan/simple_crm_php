<?php
function calculateDiscount($balance) {
	if ($balance > 10000) {
		return 10;
	} elseif ($balance > 5000) {
		return 5;
	} else {
		return 0;
	}
}
?>