<?php
/***************************************
 * User Table
 ***************************************/
/**
 * Want to call the users table something else? Rename it here!
 */
$config['users']['table'] = 'users';
/**
 * How are the user passwords going to be encrypted
 */
$config['users']['encryption'] = 'md5';
/**
 * Define your users table
 * You should be editing the second column
 * the first column is the description used by the sUser class
 */
$config['users']['fields'] = array(
	//required
	'id'             => 'id',
	'username'       => 'username',
	'password'       => 'password',
	//(optional example fields)
	'join_date'      => 'join_date',
	'last_activity'	 => 'last_activity',
	'level'	         => 'level',
	'active'         => 'active',
	'logins'         => 'logins',
);
/**
 * Define the name for your users session
 * For more security it could be a random string
 */
$config['users']['session_name'] = md5('something');