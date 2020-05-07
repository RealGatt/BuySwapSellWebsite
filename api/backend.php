<?php


function replace_links( $text )
{
	$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
	$ret = ' ' . $text;

	// Replace Links with https://
	$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);

	// Replace Links without https://
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
	// Replace Email Addresses
	$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
	$ret = substr($ret, 1);

	return $ret;
}

function str_contains($haystack, $needle, $ignoreCase = false) {
	if ($ignoreCase) {
		$haystack = strtolower($haystack);
		$needle   = strtolower($needle);
	}
	$needlePos = strpos($haystack, $needle);
	return ($needlePos === false ? false : ($needlePos+1));
}

function startsWith($haystack, $needle) {
	// search backwards starting from haystack length characters from the end
	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function str_replace_first($from, $to, $subject)
{
	$from = '/'.preg_quote($from, '/').'/';

	return preg_replace($from, $to, $subject, 1);
}

function strip_unsafe($string, $img=false)
{
	// Unsafe HTML tags that members may abuse
	$unsafe=array(
	'/<iframe(.*?)<\/iframe>/is',
	'/<title(.*?)<\/title>/is',
	'/<pre(.*?)<\/pre>/is',
	'/<frame(.*?)<\/frame>/is',
	'/<frameset(.*?)<\/frameset>/is',
	'/<object(.*?)<\/object>/is',
	'/<script(.*?)<\/script>/is',
	'/<embed(.*?)<\/embed>/is',
	'/<applet(.*?)<\/applet>/is',
	'/<meta(.*?)>/is',
	'/<!doctype(.*?)>/is',
	'/<link(.*?)>/is',
	'/<body(.*?)>/is',
	'/<\/body>/is',
	'/<head(.*?)>/is',
	'/<\/head>/is',
	'/onload="(.*?)"/is',
	'/onunload="(.*?)"/is',
	'/onclick="(.*?)"/is',
	'/onhover="(.*?)"/is',
	'/onkeyup="(.*?)"/is',
	'/onkeydown="(.*?)"/is',
	'/onkeypress="(.*?)"/is',
	'/onclick="(.*?)"/is',
	'/<html(.*?)>/is',
	'/<\/html>/is');

	// Remove graphic too if the user wants
	if ($img==true)
	{
		$unsafe[]='/<img(.*?)>/is';
	}

	// Remove these tags and all parameters within them
	$string=preg_replace($unsafe, "", $string);

	return $string;
}

function clean($val){
	$val = strip_tags($val);
	$val = str_replace("+", "=", $val);
	$val = str_replace("'", "", $val);
	$val = str_replace('"', "", $val);
	return $val;
}
