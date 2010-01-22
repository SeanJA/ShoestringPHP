<div id="documentation">
<?php foreach ($methods as $method){ ?>
	<span id="doc_<?php echo sEscape::html($method['id'])?>"></span>
	<div class="method_name">
		<?php echo sEscape::html($method['method_name']); ?>
		<?php if($loggedIn){ ?>
		- <em><?php href('docs/update/'.$method['id'], 'Update'); ?></em> - <em><?php href('docs/delete/'.$method['id'], 'Delete'); ?></em>
		<?php } ?>
	</div>
	<div class="comment">
		<?php echo sEscape::html($method['comments']); ?>
	</div>
	<pre class="sh_php">
<?php echo sEscape::html($method['example']); ?>
	</pre>

	<hr />
<?php } ?>
</div>