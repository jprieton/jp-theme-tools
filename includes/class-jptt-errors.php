<?php

class JPTT_Errors extends WP_Error {

	public function __construct($code = '', $message = '', $data = '') {
		parent::__construct($code, $message, $data);
	}

	public function method_rejected($method = null) {
		$code = 'method_rejected';
		$message = 'Método no adimitido';
		$this->add($code, $message);
		$this->add('action', $method);
	}

	public function user_not_logged($method = null) {
		$code = 'user_not_logged';
		$message = 'Debes iniciar sesión para ejecutar esta acción';
		$this->add($code, $message);
		$this->add('action', $method);
	}

	public function user_logged_in($method = null) {
		$code = 'user_logged_in';
		$message = 'Ya has iniciado sesion';
		$this->add($code, $message);
		$this->add('action', $method);
	}

}
