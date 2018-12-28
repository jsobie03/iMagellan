<?php
	function nothingToSeeHere($header, $message, $linktext = '', $linkpath = '', $optclass = '')
	{
		echo "<div class='header $optclass'>
					<h2>$header</h2>
				</div>
				<div class='content $optclass'>
					<p>$message</p>
					<a href='$linkpath'>$linktext</a>
				</div>";

	}
?>
