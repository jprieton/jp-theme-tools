<?php

namespace jptt;

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 * @property Config $config
 * @property Input $input
 * @property Instagram $instagram
 *
 */
class jptt {

	public $config;
	public $input;
	public $instagram;

	public function __construct() {
		$this->config = new Config();
		$this->input = new Input();
		$this->$instagram = new Instagram();
	}

}
