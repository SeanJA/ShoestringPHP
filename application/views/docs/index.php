To begin your quest... select a file to investigate:
<ul>
<?php foreach($files as $file){ ?>
	<li>
		<?php href('docs/display/'.$file, $file); ?>
	</li>
<?php }?>
</ul>
