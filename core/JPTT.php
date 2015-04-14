<?php

defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * @property JPTT_Input $input
 * @property JPTT_Error $error
 * @property JPTT_loader $load
 */
class JPTT {

	public function __construct() {
		include_once JPTT_PLUGIN_PATH . 'core/JPTT_Input.php';
		$this->input = new JPTT_Input();

		include_once JPTT_PLUGIN_PATH . 'core/JPTT_Error.php';
		$this->error = new JPTT_Error();

		include_once JPTT_PLUGIN_PATH . 'core/JPTT_Loader.php';
		$this->load = new JPTT_Loader();
	}

	public function theme_init($config = array()) {
		if (!empty($config['modules']) && is_array($config['modules'])) {
			foreach ($config['modules'] as $module) {
				$this->load->module($module);
			}
		}
	}

	public function plugin_init($config = array()) {

	}

}
