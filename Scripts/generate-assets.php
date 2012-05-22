<?php

$cssBundles = array(
	"Bootstrap" => "Public/less/bootstrap.less",
	"Bootstrap-Responsive" => "Public/less/responsive.less"
);

$path = getcwd();

$assets = 'Assets:
  Bundles:
    CSS:';
foreach ($cssBundles as $name => $file) {
	$content = file_get_contents($path . "/Resources/" . $file);
	preg_match_all('/@import.*"(.+)"/', $content, $matches);
	foreach ($matches[1] as $key => $match) {
		$content = str_replace($matches[0][$key], "- " . dirname($file) . "/" . $match, $content);
	}
	$content = str_replace("/*", "#", $content);
	$content = str_replace(" */", "#", $content);
	$content = str_replace(" *", "#", $content);
	$content = str_replace("//", "#", $content);
	$assets.= prependText("\n" . $name . ":", 6) . "\n";
	$assets.= prependText($content, 8);

}

function prependText($text, $spaces = 2) {
	$lines = explode("\n", $text);
	foreach ($lines as $key => $line) {
		$lines[$key] = str_repeat(" ", $spaces) . $line;
	}
	return implode("\n", $lines);
}

file_put_contents("Configuration/Settings.yaml", $assets);

?>