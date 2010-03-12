<?php $f = new sForm(); ?>
<?php $f->open('/users/login', 'post'); ?>
<div>
	<?php $f->label('username', 'Username'); ?>
	<?php $f->textField('username',array('value'=>$this->post('username'))); ?>
	<br />
	<?php $f->label('password', 'Password'); ?>
	<?php $f->password('password'); ?>
	<br />
	<?php $f->submit('Login'); ?>
</div>
<?php $f->close(); ?>