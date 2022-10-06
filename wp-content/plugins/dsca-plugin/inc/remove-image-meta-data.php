<?php
// @see https://docs.wpvip.com/how-tos/strip-image-metadata/

add_filter( 'wp_handle_upload', function ( array $upload ):array {
	if ( ! in_array( $upload['type'], array( 'image/jpeg', 'image/png', 'image/gif' ), true ) )
		return $upload;
	try {
		dsca_strip_metadata_from_image( $upload['file'] );
	} catch ( \GmagickException $e ) {
		// Do nothing.
	}
	return $upload;
} );

function dsca_strip_metadata_from_image( string $file, ?string $output = null ) {
	$image = new \Gmagick( $file );

	try {
		$profile = $image->getimageprofile( 'icc' );
	} catch ( \GmagickException $exception ) {
		// Raises an exception if no profile is found.
	}

	$image->stripimage();

	if ( ! empty( $profile ) )
		$image->setimageprofile( 'icc', $profile );

	if ( empty( $output ) )
		$output = $file;

	$image->writeimage( $output, true );
	$image->destroy();
}
