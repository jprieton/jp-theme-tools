<?php

namespace jptt\core;

defined('ABSPATH') or die('No direct script access allowed');

class Upload {

	/**
	 * Handle upload images
	 * @param string $field
	 * @return int|\WP_Error
	 */
	public function handle_upload_images($field = 'file') {
		$overrides = array(
				'test_form' => false,
				'mimes' => array(
						'jpg'  => 'image/jpg',
						'jpeg' => 'image/jpeg',
						'gif'  => 'image/gif',
						'png'  => 'image/png'
		));

		$image_data = wp_handle_upload($_FILES[$field], $overrides);

		if (isset($image_data['error']) || isset($image_data['upload_error_handler'])) {
			return new \jptt\core\Error('upload_error', $image_data['error']);
		}

		$image_string = file_get_contents($image_data['file']);

		$image = imagecreatefromstring($image_string);

		$orig_w = imagesx($image);
		$orig_h = imagesy($image);

		$icr = image_resize_dimensions($orig_w, $orig_h, $a = 1000, $b = 1000);

		if (!$icr) {
			$icr = array(
					$orig_w,
					$orig_h,
					0,
					0,
					$orig_w,
					$orig_h,
					$orig_w,
					$orig_h,
			);
		}

		$thumb = imagecreatetruecolor($icr[4], $icr[5]);
		try {
			imagecopyresampled($thumb, $image, $icr[0], $icr[1], $icr[2], $icr[3], $icr[4], $icr[5], $icr[6], $icr[7]);

			switch ($image_data['type']) {
				case 'image/bmp': imagewbmp($thumb, $image_data['file']);
					break;
				case 'image/gif': imagegif($thumb, $image_data['file']);
					break;
				case 'image/jpg': imagejpeg($thumb, $image_data['file']);
					break;
				case 'image/png': imagepng($thumb, $image_data['file']);
					break;
			}
		} catch (Exception $e) {
						return new \jptt\core\Error('upload_error', 'Hubo un error al subir la imagen.');
		}

		$post_title = preg_replace('/\.[^.]+$/', '', basename($image_data['file']));

		$pub_id = 1;
		$__type = explode('/', $image_data['type']);
		$_new_filename = 'pub' . $pub_id . '-' . substr(md5(date('dmYhis')), 0, 12) . '.' . end($__type);
		$__url = explode('/', $image_data['url']);
		$_old_filename = end($__url);

		rename($image_data['file'], str_replace($_old_filename, $_new_filename, $image_data['file']));
		$image_data['url'] = str_replace($_old_filename, $_new_filename, $image_data['url']);
		$image_data['file'] = str_replace($_old_filename, $_new_filename, $image_data['file']);

		$attachment = array(
				'post_mime_type' => $image_data['type'],
				'post_title'     => $post_title,
				'post_content'   => '',
				'post_status'    => 'inherit',
				'guid'           => $image_data['url']
		);

		if (!function_exists('wp_generate_attachment_metadata')) {
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		}
		$wp_upload_dir = wp_upload_dir();
		$filename = str_replace($wp_upload_dir['baseurl'] . '/', '', $image_data['url']);

		$attachment_id = wp_insert_attachment($attachment, $filename);
		$attach_data = wp_generate_attachment_metadata($attachment_id, $image_data['file']);
		wp_update_attachment_metadata($attachment_id, $attach_data);

		return $attachment_id;
	}

}
