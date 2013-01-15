<?php
/*
Name: Example Box
Author: Tim Milligan
Version: 1.0
Description: This is the description.
Class: example_box
*/

// This function dynamically loads the asset handler class if it's required.
function __autoload($class_name) {
	$filename = dirname(__FILE__) . '/' . strtolower($class_name) . '.php';
	
	if(file_exists($filename))
		include_once($filename);
}

class example_box extends thesis_box {
    
	public function translate() {
		$this->name = __('Example Box', 'example');
	}
	
	public function construct() { 
		global $vzm_ah;
		if(is_admin()) {
			if(!isset($vzm_ah)) { // Check if the Asset Handler has already been created once, no point in creating the same asset handler multiple times.
				$vzm_ah = new vzm_asset_handler;
			}
			
			// The following lines are for testing purposes and will display the various transients on the admin pages
			/*
			$transients = array(
				'skins' => 'thesis_skins_update',
				'boxes' => 'thesis_boxes_update',
				'packages' => 'thesis_packages_update',
				'thesis' => 'thesis_core_update');
				
			foreach ($transients as $key => $transient) {
				if ($var = get_transient($transient)) {
					//delete_transient($transient);
					echo $key . "\n";
					print_r($var);
				}
			}
			*/

		}
	}
	
}
