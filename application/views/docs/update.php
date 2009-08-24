<p> <?php href('docs/display/'.$doc['file'].'#doc_'.$doc['id'], 'View'); ?> </p>
<?php
$f = new sForm();
?>
<?php $f->open('docs/update/'.$doc['id'], 'post'); ?>
	<div>
		<?php $f->label('method_name', 'Method Name:'); ?>
		<?php $f->textField('method_name', array('value'=>$doc['method_name'], 'class'=>'wide')); ?> <br />

		<?php $f->label('file', 'File:'); ?>
		<?php $f->textField('file',  array('value'=>$doc['file'], 'class'=>'wide')); ?> <br />

		<?php $f->label('comments', 'Comments:'); ?>
		<?php $f->textArea('comments', '5x60', $doc['comments']); ?> <br />

		<?php $f->label('example', 'Example:'); ?>
		<?php $f->textArea('example', '5x60', $doc['example']); ?> <br />

		<?php $f->submit('Submit'); ?>
	</div>
<?php $f->close(); ?>