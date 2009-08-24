
<?php $f = new sForm(); ?>


<?php $f->open('/edit/', 'post'); ?>
<div>
<?php $f->label('username', 'Username');?><span id="username"><?php echo sEscape::html($editUser['username']) ?></span><br />
<?php $f->label('password', 'Password'); $f->password('password');?> <br />
<?php $f->label('password2', 'Password Confirmation'); $f->password('password2');?> <br />
<?php
if($user->level == 'admin'){
	$f->label('level', 'Level'); $f->selectBox('level', $levels, $editUser['level']); echo "<br />";
} ?>
<?php $f->submit('Save'); ?>
</div>
<?php
$f->close();
?>
