<?php
/**
adapted from a program copyrighted by an individual
who distributed with a copyleft license
*/

$url = $_POST['url'];

$html = file_get_contents($url);

$title = "/<title>(.*?)<\/title>/";
// find title
preg_match($title, $html, $match);
$url_title = trim($match[1]);
if (empty($url_title)) $url_title = "(untitled)";

$fetched["title"] = $url_title;

// get description
$meta_tags = get_meta_tags($url);
if (!empty($meta_tags['description'])) {
	$fetched["description"] = $meta_tags['description'];
}

$regex = "/^(http:\/\/[^\/]+).*/";
// find base url
preg_match($regex, $url, $result);
$icon_path = $result[1] . "/favicon.ico";
$doc = @fopen($icon_path, "r");

if(strpos($doc, "Resource id") !== false) { 
	// image exists
	$fetched['favicon'] = $icon_path;
}

exit(json_encode($fetched));
