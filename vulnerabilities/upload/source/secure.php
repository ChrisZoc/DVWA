<?php

if( isset( $_POST['Upload'] ) ) {
	$file = $_FILES['uploaded'] ?? null;
	$valid_upload = is_array( $file ) &&
		isset( $file['tmp_name'], $file['size'], $file['error'] ) &&
		$file['error'] === UPLOAD_ERR_OK &&
		$file['size'] > 0 && $file['size'] < 100000 &&
		is_uploaded_file( $file['tmp_name'] );

	$image_info = $valid_upload ? getimagesize( $file['tmp_name'] ) : false;
	$mime = $image_info['mime'] ?? '';
	$extension = $mime === 'image/jpeg' ? 'jpg' : ( $mime === 'image/png' ? 'png' : '' );

	if( $extension === '' ) {
		$html .= '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
	} else {
		$image = $mime === 'image/jpeg'
			? imagecreatefromjpeg( $file['tmp_name'] )
			: imagecreatefrompng( $file['tmp_name'] );
		$target_path = DVWA_WEB_PAGE_TO_ROOT . 'hackable/uploads/';
		$target_file = bin2hex( random_bytes( 16 ) ) . '.' . $extension;
		$destination = getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file;
		$saved = $image !== false && ( $mime === 'image/jpeg'
			? imagejpeg( $image, $destination, 90 )
			: imagepng( $image, $destination, 9 ) );

		if( $image !== false ) {
			imagedestroy( $image );
		}

		if( $saved ) {
			$html .= "<pre><a href='{$target_path}{$target_file}'>{$target_file}</a> successfully uploaded!</pre>";
		} else {
			$html .= '<pre>Your image was not uploaded.</pre>';
		}
	}
}

?>
