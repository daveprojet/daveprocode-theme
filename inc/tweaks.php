<?php
/**
 * Performance, sécurité, SEO local et redirections.
 *
 * @package daveprocode
 */

defined( 'ABSPATH' ) || exit;

/* Masquer la version de WordPress. */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/* Retirer les scripts emoji (inutiles, ~15 Ko). */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/* Pas d'énumération des comptes par ?author=1. */
add_action( 'template_redirect', function () {
	if ( ! is_admin() && isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );

/* Données structurées Organization + LocalBusiness sur la page d'accueil. */
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}
	$s    = dp_settings();
	$logo = get_theme_mod( 'custom_logo' ) ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '';
	$data = array(
		'@context'    => 'https://schema.org',
		'@type'       => array( 'Organization', 'LocalBusiness' ),
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'description' => 'Entreprise de solutions digitales à Dakar : création de sites web, applications web et mobiles, marketing digital, design et SEO.',
		'email'       => $s['email'],
		'telephone'   => $s['phone'],
		'foundingDate'=> '2023-02',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Castor 1, villa n°6, rue DD 78',
			'addressLocality' => 'Dakar',
			'addressCountry'  => 'SN',
		),
		'sameAs'      => array_values( array_filter( array( $s['facebook'], $s['instagram'], $s['linkedin'], $s['youtube'] ) ) ),
	);
	if ( $logo ) {
		$data['logo']  = $logo;
		$data['image'] = $logo;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}, 20 );

/* Redirections 301 des anciennes adresses (seulement si la page n'existe plus en ligne). */
add_action( 'template_redirect', function () {
	if ( ! is_404() ) {
		return;
	}
	$map  = array(
		'agence-de-communication-a-dakar' => '/services/',
		'cartes-de-visites-dakar'         => '/logo-et-charte-graphique/',
		'formations'                      => '/formations-informatiques/',
		'studio'                          => '/services/',
		'solutions'                       => '/nos-projets/',
		'solutions/bricolibe'             => '/nos-projets/bricolibe/',
		'creation-dapplications'          => '/applications-web-et-mobiles/',
		'agence-digitale'                 => '/',
	);
	$path = trim( (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '', PHP_URL_PATH ), '/' );
	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( $map[ $path ] ), 301 );
		exit;
	}
} );
