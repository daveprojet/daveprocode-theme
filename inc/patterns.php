<?php
/**
 * Compositions de blocs réutilisables (onglet « Compositions » > Dave Procode dans l'éditeur).
 *
 * @package daveprocode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remplace les variables {{...}} par les réglages du site.
 */
function dp_fill_placeholders( $html ) {
	$s       = dp_settings();
	$archive = get_post_type_archive_link( 'realisation' );
	$media   = get_option( 'dp_media', array() );

	// Logos fournis avec le thème : {{logo:fichier.svg}}
	$html = preg_replace_callback(
		'/\{\{logo:([a-z0-9.\-]+)\}\}/',
		function ( $m ) {
			return esc_url( DP_URI . '/assets/img/logos/' . $m[1] );
		},
		$html
	);
	// Images : {{img:cle}} = adresse, {{imgid:cle}} = identifiant dans la médiathèque.
	$html = preg_replace_callback( '/\{\{img(id)?:([a-z0-9-]+)\}\}/', function ( $m ) use ( $media ) {
		$key = $m[2];
		$id  = isset( $media[ $key ] ) ? (int) $media[ $key ] : 0;
		if ( $id && ! wp_get_attachment_url( $id ) ) {
			$id = 0;
		}
		if ( ! empty( $m[1] ) ) {
			return (string) $id;
		}
		return $id ? wp_get_attachment_url( $id ) : DP_URI . '/assets/img/photos/' . $key . '.webp';
	}, $html );
	// Image non importée : on retire la référence à l'identifiant (le bloc reste valide).
	$html = str_replace( array( '"id":0,', ' class="wp-image-0"' ), '', $html );

	return strtr( $html, array(
		'{{url}}'          => untrailingslashit( home_url() ),
		'{{whatsapp}}'     => $s['whatsapp'],
		'{{email}}'        => $s['email'],
		'{{phone}}'        => $s['phone'],
		'{{tel}}'          => preg_replace( '/[^0-9+]/', '', $s['phone'] ),
		'{{address}}'      => $s['address'],
		'{{hours}}'        => $s['hours'],
		'{{realisations}}' => home_url( '/portfolio/' ),
	) );
}

add_action( 'init', function () {
	register_block_pattern_category( 'daveprocode', array( 'label' => 'Dave Procode' ) );

	foreach ( glob( DP_DIR . '/content/patterns/*.html' ) as $file ) {
		$raw = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		preg_match( '/<!-- title: (.*?) -->/', $raw, $t );
		preg_match( '/<!-- description: (.*?) -->/', $raw, $d );
		$content = preg_replace( '/^<!-- (title|description): .*? -->\n/m', '', $raw );
		register_block_pattern( 'daveprocode/' . basename( $file, '.html' ), array(
			'title'       => isset( $t[1] ) ? $t[1] : basename( $file, '.html' ),
			'description' => isset( $d[1] ) ? $d[1] : '',
			'categories'  => array( 'daveprocode' ),
			'content'     => dp_fill_placeholders( $content ),
		) );
	}
}, 20 );
