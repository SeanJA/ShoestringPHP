<h3>Form Demo</h3>
<p>Basic form, will remember the content that you entered automagically (unless it is a password field)</p>
<h4>Posted Values</h4>
<pre>
<?php
	print_r($_POST);
?>
</pre>
<hr />

<h4>Form Code</h4>
<pre class="sh_php sh_sourceCode">
//new form helper
$f = new sForm();
//open the form
$f->open('/forms/basic/', 'post');

	//add a text field
	$f->label('first_name', 'First Name');
	$f->textField('first_name');

	//add a second text field
	$f->label('last_name', 'Last Name');
	$f->textField('last_name');

	//add a select box
	$f->label('gender', 'Gender');
	$f->selectBox('gender', array('Male', 'Female', 'Both'));

	//add a password box
	$f->label('password', 'Password');
	$f->password('password');

	//add a submit button
	$f->submit('save', 'Save');

//close the form
$f->close();
</pre>
<hr />

<?php
$f = new sForm();
$f->open('/forms/basic/', 'post');
?>
<div>
	<?php
		$f->label('first_name', 'First Name');
		$f->textField('first_name');
	?>
	<br />
	<?php
		$f->label('last_name', 'Last Name');
		$f->textField('last_name');
	?>
	<br />
	<?php
		$f->label('gender', 'Gender');
		$f->selectBox('gender', array('Male', 'Female', 'Both'));
	?>
	<br />
	<?php
		$f->label('password', 'Password');
		$f->password('password');
	?>
	<br />
	<?php
		$f->submit('save', 'Save');
	?>
</div>
<?php

$f->close();
?>
