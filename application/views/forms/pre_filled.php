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
$f->open('/forms/pre-filled/', 'post');

	//text field prefilled with 'First'
	$f->label('first_name', 'First Name');
	$f->textField('first_name', array('value'=>'First'));

	//text field prefilled with 'Last'
	$f->label('last_name', 'Last Name');
	$f->textField('last_name', array('value'=>'Last'));

	//select box pre selected 'Both'
	//notice that it is not an associative array,
	//but we can refer to the selected element using a string
	$f->label('gender', 'Gender');
	$f->selectBox('gender', array('Male', 'Female', 'Both'), 'Both');

	//a password box, they do not get prefilled (ever)
	$f->label('password', 'Password');
	$f->password('password');

	//save button
	$f->submit('save', 'Save');

//close the form
$f->close();

</pre>
<hr />

<?php
$f = new sForm();
$f->open('/forms/pre-filled/', 'post');
?>
<div>
	<?php
		$f->label('first_name', 'First Name');
		$f->textField('first_name', array('value'=>'First'));
	?>
	<br />
	<?php
		$f->label('last_name', 'Last Name');
		$f->textField('last_name', array('value'=>'Last'));
	?>
	<br />
	<?php
		$f->label('gender', 'Gender');
		$f->selectBox('gender', array('Male', 'Female', 'Both'), 'Both');
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
