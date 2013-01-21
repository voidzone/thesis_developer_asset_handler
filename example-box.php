<?php
/*
Name: Example Box
Author: Tim Milligan
Version: 1.0
Description: This is the description.
Class: example_box
*/

class example_box extends thesis_box {
    
	public function translate() {
		$this->name = __('Example Box', 'example');
	}
	
	public function construct() { 
		global $vzm_ah;
		if(is_admin()) {
			if(!isset($vzm_ah)) { // Check if the Asset Handler has already been created once, no point in creating the same asset handler multiple times.
				// Load the asset handler class if it hasn't been already.
				if(!class_exists('vzm_asset_handler'))
					require_once( dirname(__FILE__) . '/vzm_asset_handler.php');
					
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
