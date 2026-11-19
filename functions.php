<?php
/**
 * Thème enfant Dave Procode (parent : Kadence).
 *
 * @package daveprocode
 */

defined( 'ABSPATH' ) || exit;

define( 'DP_VERSION', '1.4.5' );
define( 'DP_DIR', get_stylesheet_directory() );
define( 'DP_URI', get_stylesheet_directory_uri() );

/**
 * Coordonnées et réseaux : modifiables dans Apparence > Installation Dave Procode.
 */
function dp_settings() {
	$defaults = array(
		'phone'     => '+221 77 723 40 86',
		'whatsapp'  => '221777234086',
		'email'     => 'contact@daveprocode.com',
		'notify'    => 'contact@daveprocode.com',
		'address'   => 'Castor 1, villa n°6, rue DD 78, Dakar, Sénégal',
		'hours'     => 'Lundi – vendredi, 9 h – 18 h',
		'facebook'  => 'https://www.facebook.com/profile.php?id=100090052973249',
		'instagram' => 'https://www.instagram.com/daveprocode/',
		'linkedin'  => 'https://www.linkedin.com/company/102593163',
		'youtube'   => 'https://youtube.com/@daveprocode',
		'tagline'   => 'Solutions digitales à Dakar : sites web, applications web et mobiles, marketing digital.',
		'announce'  => 'Devis gratuit sous 48 h ouvrées — parlons de votre projet',
		// E-mails des formulaires (vide = adresse « notify »).
		'from_name'     => 'Dave Procode',
		'from_email'    => '',
		'to_devis'      => '',
		'to_formation'  => '',
		'to_contact'    => '',
		'to_ventures'   => '',
		'to_carriere'   => '',
		'to_newsletter' => '',
		// Envoi SMTP (recommandé avec une adresse pro).
		'smtp_on'     => '',
		'smtp_host'   => '',
		'smtp_port'   => '465',
		'smtp_secure' => 'ssl',
		'smtp_user'   => '',
		'smtp_pass'   => '',
		// Mises à jour du thème : dépôt GitHub public qui publie update.json.
		'update_repo' => 'daveprojet/daveprocode-theme',
	);
	$saved = get_option( 'dp_settings', array() );
	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

function dp_setting( $key ) {
	$s = dp_settings();
	return isset( $s[ $key ] ) ? $s[ $key ] : '';
}

require DP_DIR . '/inc/content-types.php';
require DP_DIR . '/inc/forms.php';
require DP_DIR . '/inc/shortcodes.php';
require DP_DIR . '/inc/footer.php';
require DP_DIR . '/inc/patterns.php';
require DP_DIR . '/inc/tweaks.php';
require DP_DIR . '/inc/setup.php';
require DP_DIR . '/inc/seo-yoast.php';
require DP_DIR . '/inc/updater.php';

/**
 * Styles et police.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'dp-site', DP_URI . '/assets/css/site.css', array( 'kadence-global' ), DP_VERSION );
	wp_enqueue_style( 'dp-icons', DP_URI . '/assets/css/icons.css', array( 'dp-site' ), DP_VERSION );
	wp_enqueue_script( 'dp-site', DP_URI . '/assets/js/site.js', array(), DP_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}, 20 );

add_action( 'wp_head', function () {
	echo '<link rel="preload" href="' . esc_url( DP_URI . '/assets/fonts/archivo-latin.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
}, 1 );

/* Même rendu dans l'éditeur de blocs. */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'assets/css/site.css', 'assets/css/icons.css' ) );
} );

/**
 * Barre d'annonce au-dessus de l'en-tête (texte modifiable dans Apparence > Installation Dave Procode).
 */
add_action( 'kadence_before_header', function () {
	$text = dp_setting( 'announce' );
	if ( ! $text ) {
		return;
	}
	$page = get_page_by_path( 'services' );
	$url  = $page ? get_permalink( $page ) . '#devis' : home_url( '/contact/' );
	echo '<div class="dp-announce">' . esc_html( $text ) . ' · <a href="' . esc_url( $url ) . '">Demander un devis</a></div>';
} );

/**
 * Encadré d'appel à l'action à la fin de chaque article.
 */
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$page = get_page_by_path( 'services' );
	$url  = $page ? get_permalink( $page ) . '#devis' : home_url( '/contact/' );
	return $content . '<div class="dp-post-cta"><div><h3>Un projet en tête ?</h3><p>Sites web, applications, marketing digital : parlons-en, le devis est gratuit.</p></div>'
		. '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '">Demander un devis</a></div></div>';
}, 20 );

/**
 * Classe « dp-page » sur les pages construites avec le thème.
 */
add_filter( 'body_class', function ( $classes ) {
	if ( is_singular() ) {
		$id = get_queried_object_id();
		// Pages créées par l'installation OU pages dont le code a été collé à la main.
		if ( get_post_meta( $id, '_dp_built', true ) || false !== strpos( (string) get_post_field( 'post_content', $id ), 'dp-section' ) ) {
			$classes[] = 'dp-page';
		}
	}
	return $classes;
} );
