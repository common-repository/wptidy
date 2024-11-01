<?php
/*
Plugin Name: HTML-Tidy
Version: 1.0
Plugin URI: http://m0n5t3r.info/work/wordpress-plugins/wptidy/
Description: Clean and format the post using HTML Tidy
Author: m0n5t3r
Author URI: http://m0n5t3r.info/
*/

function wp_tidy($source)
{
	$config = array(
		'indent'						=> true,
		'output-xhtml'					=> true,
		'wrap'							=> 0,
		'word-2000'						=> true,
		'drop-font-tags'				=> true,
		'doctype'						=> 'strict',
		'drop-empty-paras'				=> true,
		'drop-proprietary-attributes'	=> true,
		'enclose-block-text'			=> true,
		'enclose-text'					=> true,
		'escape-cdata'					=> true,
		'logical-emphasis'				=> true,
		'indent-spaces'					=> 4,
		'break-before-br'				=> false,
		'force-output'					=> true,
		'show-body-only'				=> true,
		'quote-marks'					=> true,
		'quote-nbsp'					=> true,
		'literal-attributes'			=> true
		);

	// Get the original source
	$source = html_entity_decode(stripslashes($source));
	$source = preg_replace("|(<pre>\s*)?<code>(.+)</code>(?(1)\s*</pre>)|Use","'<pre><code>'.htmlentities('\\2').'</code></pre>'",$source);
	// Tidy
	$tidy = new tidy;
	$tidy->parseString($source, $config, "utf8");
	$tidy->cleanRepair();

	$newsrc = $tidy;

	return $newsrc;
}

remove_filter('the_content','wpautop');
remove_filter('comment_text','wpautop');

add_filter('the_content','wp_tidy',1);
add_filter('content_edit_pre','wp_tidy',1);

add_filter('comment_edit_pre','wp_tidy',1);
add_filter('comment_text','wp_tidy',1);
?>