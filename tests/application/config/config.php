<?php

/**
 * Configuration Variables
 */
$config['development_environment'] = true;
/**
 * The base url of your project
 *
 * always preceeded by http:// or https:// or ...
 */
$config['base_url'] = 'http://localhost/shoestring/';
/**
 * The index file for your project (with the trailing slash)
 *
 * either 'index.php/' or '' if you are using rewrite
 */
$config['index_file'] = 'index.php/';
/**
 * The characters that we want to allow in our uri
 */
$config['allowed_uri_characters'] = 'a-z 0-9~%.:_/-';
/**
 * The character encoding you are using on your site
 */
$config['char_encoding'] = 'utf-8';
/**
 * The default page that people will see when they arrive at your site
 */
$config['default_location'] = 'urls/index';
/**
 * The prefix (if any) that you have put on your helpers
 */
$config['helper_prefix'] = '';
/*
 * The helpers that will always be loadded are right here in this array
 * Use the full name of the helper if it is your own, or just the prefix if it is built in
 */
$config['auto_load']['helpers'] = array('html', 'url', 'form','debug');