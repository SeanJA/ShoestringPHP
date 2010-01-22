<?php docType('xhtml1_strict')?>

<html>
<head>

	<?php charset('utf-8')?>

	<title><?php if(isset($title)){echo $title.' - ';} ?>ShoestringPHP</title>

	<?php css('style.css')?>

	<?php js('http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js'); ?>

	<?php js('sh_main.js'); ?>

	<?php js('sh_php.js'); ?>

	<?php css('sh_style.css'); ?>

</head>
<body onload="sh_highlightDocument();">
	<div id="header">
		<div id="headercontent">
			<h1>ShoestringPHP</h1>
			<ul id="menu">
				<li class="left noborder">
					<?php href('docs/index', 'Documentation'); ?>
				</li>
				<li class="right noborder">
				<?php if($loggedIn){ ?>
					<?php href('users/logout', 'Logout'); ?>
				<?php } else {?>
					<?php href('users/login', 'Login'); ?>
				<?php }	?>
				</li>
			</ul>
		</div>
	</div>
	<div id="page">
	<h3>
		<?php if(isset($header)){echo sEscape::html($header);} else{ echo 'ShoestringPHP'; } ?>
	</h3>
	<?php echo isset($message) ? '<p class="message">'.sEscape::html($message).'</p>' : ''; ?>
	<?php echo isset($error) ? '<p class="error">'.sEscape::html($error).'</p>' : ''; ?>
	<?php
	if(!empty($errors)){
		foreach($errors as $error){
			echo '<p class="error">'.sEscape::html($error).'</p>';
		}
	}
	?>