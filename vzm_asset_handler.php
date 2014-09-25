<?php
/*
Name: Thesis Developer Asset Handler
Author: Tim Milligan
Version: 1.4.1
Configuration:
Change $from (ln 56) to point to your update file, see update.php for example
Change the 'vzm' prefix on the class name (ln 12) and the CALLOUT_TRANSIENT (ln 13) to your own
Rename the file to match your class name
*/

class vzm_asset_handler {
	const CALLOUT_TRANSIENT = 'vzm_callout';
	
	public function __construct() {
		if (is_dir(WP_CONTENT_DIR . '/thesis'))
			add_action('thesis_updates', array($this, 'get_updates'), 1);
		add_action('upgrader_process_complete', array($this, 'reset_transients'));
	}
	
	public function get_updates() {
		global $thesis;
		
		//delete_transient(self::CALLOUT_TRANSIENT); //uncommenting this line will force an update check, for testing purposes only
		if (get_transient(self::CALLOUT_TRANSIENT))
			return;
		
		set_transient(self::CALLOUT_TRANSIENT, time(), 60*60*24);
		
		$objects = array(
			'skins' => thesis_skins::get_items(),
			'boxes' => thesis_user_boxes::get_items(),
			'packages' => thesis_user_packages::get_items()
		);
		
		$transients = array(
			'skins' => 'thesis_skins_update',
			'boxes' => 'thesis_boxes_update',
			'packages' => 'thesis_packages_update'
		);
		
		$all = array();
		
		foreach ($objects as $object => $array)
			if (is_array($array) && !empty($array))
				foreach ($array as $class => $data)
					$all[$object][$class] = $data['version'];
		
		foreach ($transients as $key => $transient)
			if (get_transient($transient))
				unset($all[$key]);
		
		if (empty($all))
			return;
		
		$all['thesis'] = $thesis->version;
		
		$from = 'http://voidzonemedia.com/files/update.php';
		$post_args = array(
			'body' => array(
				'data' => serialize($all),
				'wp' => $GLOBALS['wp_version'],
				'php' => phpversion(),
				'user-agent' => "WordPress/{$GLOBALS['wp_version']};" . home_url()
			)
		);
		
		$post = wp_remote_post($from, $post_args);

		if (is_wp_error($post) || empty($post['body']))
			return;
		
		$returned = @unserialize($post['body']);

		if (!is_array($returned))
			return;

		foreach ($returned as $type => $data) // will only return the data that we need to update
			if (in_array("thesis_{$type}_update", $transients))
				set_transient("thesis_{$type}_update", $returned[$type], 60*60*24);
	}
	
	public function reset_transients() {
		foreach (array('skins', 'boxes', 'packages') as $tr)
			delete_transient("thesis_{$tr}_update");
		delete_transient(self::CALLOUT_TRANSIENT);
		wp_cache_flush();
	}
}
?>