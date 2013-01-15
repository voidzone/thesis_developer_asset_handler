<?php
if(!count($_POST)) die("Hacking Attempt...");
$data = unserialize(stripslashes($_POST['data']));
$types = array('skins', 'boxes', 'packages');

$files = array(
	'boxes' => array(
		'ewpfi' => array('version' => '1.3', 'url' => 'http://voidzonemedia.com/files/ewpfi.zip'),
		'vzm_copyright' => array('version' => '1.3', 'url' => 'http://voidzonemedia.com/files/vzm_copyright.zip')
	)
);
$return_data = array();

foreach($types as $type) {
	if(isset($files[$type]) && is_array($files[$type])) {
		foreach($files[$type] as $name => $file_data){
			if(array_key_exists($name, $data[$type]) && ($data[$type][$name] < $file_data['version']) ) {
				$return_data[$type][$name] = $file_data;
			}
		}
	}
}

if(!empty($return_data))
	echo serialize($return_data);