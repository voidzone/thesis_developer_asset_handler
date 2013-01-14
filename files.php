<?php
$files = array(
	'boxes' => array(
		'ewpfi' => array('version' => '1.3', 'url' => 'http://voidzonemedia.com/files/ewpfi.zip'),
		'vzm_copyright' => array('version' => '1.3', 'url' => 'http://voidzonemedia.com/files/vzm_copyright.zip')
	)
);
//print_r($files);
echo serialize($files);