<?php
$f = new sForm();
if(!isset($file)){
	$file = $this->post('file');
}
?>
<?php $f->open('docs/create', 'post'); ?>
	<div>
		<?php $f->label('method_name', 'Method Name:'); ?>
		<?php $f->textField('method_name', array('value'=>$this->post('method_name'), 'class'=>'wide')); ?> <br />

		<?php $f->label('file', 'File:'); ?>
		<?php $f->textField('file',  array('value'=>$file, 'class'=>'wide')); ?> <br />

		<?php $f->label('comments', 'Comments:'); ?>
		<?php $f->textArea('comments', '5x60', $this->post('comments')); ?> <br />

		<?php $f->label('example', 'Example:'); ?>
		<?php $f->textArea('example', '5x60', $this->post('example')); ?> <br />

		<?php $f->submit('Submit'); ?>
	</div>
<?php $f->close(); ?>
