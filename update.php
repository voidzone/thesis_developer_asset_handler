<?php
/*
Name: Thesis Developer Update Repository
Author: Tim Milligan
Version: 1.3
Configuration:
Replace the items in the $files array with arrays of your skins, boxes, and packages.
*/
if(!count($_POST) || !isset($_POST['wp'])) die("Hacking Attempt...");
$data = unserialize(stripslashes($_POST['data']));
$types = array('skins', 'boxes', 'packages');

$files = array();
if(isset($data['thesis']) && version_compare($data['thesis'], '2.1', '>=')) { // Thesis 2.1 assets
	$files = array(
		'boxes' => array(
			'ewpfi' => array('version' => '2.1', 'url' => 'http://voidzonemedia.com/files/2_1/ewpfi.zip'),
			'vzm_copyright' => array('version' => '2.1', 'url' => 'http://voidzonemedia.com/files/2_1/vzm_copyright.zip')
		)
	);
} else { // Thesis 2.0 assets
	$files = array(
		'boxes' => array(
			'ewpfi' => array('version' => '1.3', 'url' => 'http://voidzonemedia.com/files/2_0/ewpfi.zip'),
			'vzm_copyright' => array('version' => '1.3', 'url' => 'http://voidzonemedia.com/files/2_0/vzm_copyright.zip')
		),
		'packages' => array(
			'vzm_example_package' => array('version' => '1.0', 'url' => 'http://voidzonemedia.com/files/2_0/vzm_example_package.zip')
		)
	);
}

$return_data = array();

foreach($types as $type) {
	if(isset($files[$type]) && is_array($files[$type])) {
		foreach($files[$type] as $name => $file_data){
			if(array_key_exists($name, $data[$type]) && version_compare($data[$type][$name], $file_data['version'], '<') ) {
				$return_data[$type][$name] = $file_data;
			}
		}
	}
}

if(!empty($return_data))
	echo serialize($return_data);