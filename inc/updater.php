<?php
/**
 * Mises à jour du thème en un clic depuis le tableau de bord.
 *
 * Le thème lit un petit fichier update.json publié sur GitHub (dépôt public) :
 *   {"version": "1.4.6", "package": "https://github.com/…/releases/download/v1.4.6/daveprocode.zip", …}
 * Quand la version publiée est plus récente que la version installée, WordPress affiche
 * « Mise à jour disponible » dans Tableau de bord > Mises à jour et dans Apparence > Thèmes.
 *
 * @package DaveProcode
 */

defined( 'ABSPATH' ) || exit;

/** Identifiant du thème = nom de son dossier (daveprocode). */
function dp_theme_slug() {
	return basename( DP_DIR );
}

/** Adresse du fichier update.json (réglage « Dépôt GitHub du thème », ou constante DP_UPDATE_URL). */
function dp_update_url() {
	if ( defined( 'DP_UPDATE_URL' ) && DP_UPDATE_URL ) {
		return DP_UPDATE_URL;
	}
	$repo = trim( (string) dp_setting( 'update_repo' ), " /\t\n" );
	if ( ! preg_match( '#^[A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+$#', $repo ) ) {
		return '';
	}
	return 'https://raw.githubusercontent.com/' . $repo . '/main/update.json';
}

/**
 * Informations de la dernière version publiée (mises en cache 6 h).
 *
 * @param bool $force Ignorer le cache.
 * @return array|null
 */
function dp_update_info( $force = false ) {
	$url = dp_update_url();
	if ( ! $url ) {
		return null;
	}
	$cached = get_site_transient( 'dp_update_info' );
	if ( ! $force && false !== $cached ) {
		return is_array( $cached ) ? $cached : null;
	}
	$res  = wp_remote_get( add_query_arg( 't', time(), $url ), array( 'timeout' => 10, 'headers' => array( 'Accept' => 'application/json' ) ) );
	$data = null;
	if ( ! is_wp_error( $res ) && 200 === (int) wp_remote_retrieve_response_code( $res ) ) {
		$json = json_decode( wp_remote_retrieve_body( $res ), true );
		if ( is_array( $json ) && ! empty( $json['version'] ) && ! empty( $json['package'] ) && 0 === strpos( $json['package'], 'http' ) ) {
			$data = array(
				'version'      => sanitize_text_field( $json['version'] ),
				'package'      => esc_url_raw( $json['package'] ),
				'url'          => esc_url_raw( isset( $json['url'] ) ? $json['url'] : '' ),
				'requires'     => sanitize_text_field( isset( $json['requires'] ) ? $json['requires'] : '' ),
				'requires_php' => sanitize_text_field( isset( $json['requires_php'] ) ? $json['requires_php'] : '' ),
				'notes'        => sanitize_text_field( isset( $json['notes'] ) ? $json['notes'] : '' ),
			);
		}
	}
	// En cas d'échec, on réessaie dans 1 h pour ne pas ralentir l'administration.
	set_site_transient( 'dp_update_info', $data ? $data : 0, $data ? 6 * HOUR_IN_SECONDS : HOUR_IN_SECONDS );
	return $data;
}

/** Signale la nouvelle version à WordPress. */
add_filter( 'pre_set_site_transient_update_themes', function ( $transient ) {
	if ( ! is_object( $transient ) || empty( $transient->checked ) ) {
		return $transient;
	}
	$force = is_admin() && isset( $_GET['force-check'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$info  = dp_update_info( $force );
	if ( ! $info ) {
		return $transient;
	}
	$slug = dp_theme_slug();
	$item = array(
		'theme'        => $slug,
		'new_version'  => $info['version'],
		'url'          => $info['url'],
		'package'      => $info['package'],
		'requires'     => $info['requires'],
		'requires_php' => $info['requires_php'],
	);
	if ( version_compare( $info['version'], DP_VERSION, '>' ) ) {
		$transient->response[ $slug ] = $item;
		unset( $transient->no_update[ $slug ] );
	} else {
		$transient->no_update[ $slug ] = $item;
		unset( $transient->response[ $slug ] );
	}
	return $transient;
} );

/** Le zip est toujours installé dans le dossier actuel du thème, même s'il porte un autre nom. */
add_filter( 'upgrader_source_selection', function ( $source, $remote_source, $upgrader, $hook_extra = array() ) {
	if ( empty( $hook_extra['theme'] ) || dp_theme_slug() !== $hook_extra['theme'] ) {
		return $source;
	}
	global $wp_filesystem;
	$wanted = trailingslashit( $remote_source ) . dp_theme_slug() . '/';
	if ( untrailingslashit( $source ) === untrailingslashit( $wanted ) || ! $wp_filesystem ) {
		return $source;
	}
	return $wp_filesystem->move( $source, $wanted, true ) ? $wanted : $source;
}, 10, 4 );

/** Vide le cache après une mise à jour du thème. */
add_action( 'upgrader_process_complete', function ( $upgrader, $extra ) {
	if ( isset( $extra['type'] ) && 'theme' === $extra['type'] ) {
		delete_site_transient( 'dp_update_info' );
	}
}, 10, 2 );

/** Petit encadré d'état affiché dans Apparence > Installation Dave Procode. */
function dp_update_status_html() {
	$url = dp_update_url();
	if ( ! $url ) {
		return '<p class="description">Renseignez le dépôt GitHub du thème (ex. <code>votre-compte/daveprocode-theme</code>) pour recevoir les mises à jour en un clic.</p>';
	}
	$info = dp_update_info();
	$out  = '<p>Version installée : <strong>' . esc_html( DP_VERSION ) . '</strong>';
	if ( $info ) {
		$out .= ' · Dernière version publiée : <strong>' . esc_html( $info['version'] ) . '</strong>';
		if ( version_compare( $info['version'], DP_VERSION, '>' ) ) {
			$out .= ' — <a href="' . esc_url( admin_url( 'update-core.php?force-check=1' ) ) . '">mettre à jour maintenant</a>';
		} else {
			$out .= ' — le thème est à jour.';
		}
	} else {
		$out .= ' · Le fichier de mise à jour est injoignable pour le moment.';
	}
	return $out . ' <a href="' . esc_url( admin_url( 'update-core.php?force-check=1' ) ) . '">Vérifier maintenant</a></p>';
}
