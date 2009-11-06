<ul>
	<?php
	foreach($links as $link=>$text) {
		?>
	<li>
			<?php href($link, $text);
	?>
	</li>
		<?php
	}
?>
</ul>