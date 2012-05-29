<?php

$cssBundles = array(
	"Twitter.Bootstrap:Bootstrap" => "Public/Master/less/bootstrap.less",
	"Twitter.Bootstrap:Bootstrap-Responsive" => "Public/Master/less/responsive.less"
);

$path = getcwd();

$assets = 'Assets:
  Bundles:
    CSS:';

foreach ($cssBundles as $name => $file) {
	$content = file_get_contents($path . "/Resources/" . $file);
	preg_match_all('/@import.*"(.+)"/', $content, $matches);
	foreach ($matches[1] as $key => $match) {
		$content = str_replace($matches[0][$key], "- resource://Twitter.Bootstrap/" . dirname($file) . "/" . $match, $content);
	}
	$content = str_replace("/*", "#", $content);
	$content = str_replace(" */", "#", $content);
	$content = str_replace(" *", "#", $content);
	$content = str_replace("//", "#", $content);
	$content = str_replace("; #", ";\n#", $content);
	$content = str_replace(";\n", "\n", $content);
	$content = str_replace("resource:#", "resource://", $content);
	$assets.= prependText("\n'" . $name . "':", 6) . "\n";
	$assets.= prependText("Files:", 8) . "\n";
	$assets.= prependText($content, 10);
}

$assets.= "\n" . prependText("Js:", 4);
$jsFiles = scandir($path . "/Resources/Public/Master/js/");
foreach ($jsFiles as $file) {
	if(preg_match("/bootstrap-(.+)\.js/", $file, $match)){
		$name = ucfirst($match[1]);
		$path = "- resource://Twitter.Bootstrap/Public/Master/js/" . $file;
		$assets.= prependText("\n'Twitter.Bootstrap:" . $name . "':", 6) . "\n";
		$assets.= prependText("Files:", 8) . "\n";
		$assets.= prependText($path, 10) . "\n";
	}
}

function prependText($text, $spaces = 2) {
	$lines = explode("\n", $text);
	foreach ($lines as $key => $line) {
		$lines[$key] = str_repeat(" ", $spaces) . $line;
	}
	return implode("\n", $lines);
}

file_put_contents("Configuration/Assets.yaml", $assets);

?>