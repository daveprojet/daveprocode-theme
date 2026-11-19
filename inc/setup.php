<?php
/**
 * Apparence > Installation Dave Procode : coordonnées, import en un clic, annulation.
 *
 * @package daveprocode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pages créées ou mises à jour par l'installation.
 * mode « create »  : page nouvelle (mise à jour si elle existe déjà à cette adresse).
 * mode « replace » : page existante dont le contenu est remplacé (l'ancien est sauvegardé).
 */
function dp_pages_definition() {
	return array(
		array( 'slug' => 'accueil', 'title' => 'Accueil', 'mode' => 'create',
			'seo' => array( 'Dave Procode – Solutions digitales à Dakar : sites web, applications, marketing', 'Sites web, applications web et mobiles, marketing digital, design et SEO : Dave Procode accompagne entrepreneurs et entreprises à Dakar. Devis gratuit.' ) ),
		array( 'slug' => 'services', 'title' => 'Nos services', 'mode' => 'create',
			'seo' => array( 'Nos services digitaux à Dakar – Dave Procode', 'Création de sites web, applications web et mobiles, marketing digital, UI/UX, identité visuelle, SEO, formations et maintenance.' ) ),
		array( 'slug' => 'creation-de-sites-web', 'title' => 'Création de sites web', 'mode' => 'replace',
			'seo' => array( 'Création de sites web à Dakar : vitrine, e-commerce – Dave Procode', 'Sites vitrines, boutiques en ligne avec paiement Mobile Money, portfolios et blogs : rapides, élégants et bien référencés. Devis gratuit.' ) ),
		array( 'slug' => 'creation-dapplications', 'title' => 'Développement d\'applications web et mobiles', 'mode' => 'replace',
			'seo' => array( 'Développement d\'applications web et mobiles à Dakar – Dave Procode', 'Applications web, Android et iOS, plateformes métier, paiement Mobile Money. Devis gratuit sous 48 h.' ) ),
		array( 'slug' => 'marketing-digital', 'title' => 'Marketing digital', 'mode' => 'create',
			'seo' => array( 'Marketing digital à Dakar : community management et publicité – Dave Procode', 'Community management, publicités sponsorisées, création de contenus et stratégie pour développer votre visibilité.' ) ),
		array( 'slug' => 'maquette-dapplications', 'title' => 'UI/UX design', 'mode' => 'replace',
			'seo' => array( 'UI/UX design à Dakar : maquettes et prototypes – Dave Procode', 'Maquettes Figma, prototypes cliquables et tests utilisateurs pour vos sites et applications, avant le développement.' ) ),
		array( 'slug' => 'logo-et-charte-graphique', 'title' => 'Logo et charte graphique', 'mode' => 'replace',
			'seo' => array( 'Création de logo et charte graphique à Dakar – Dave Procode', 'Logo, charte graphique, cartes de visite et supports : une identité visuelle forte et cohérente pour votre marque.' ) ),
		array( 'slug' => 'referencement-seo-a-dakar', 'title' => 'Référencement SEO', 'mode' => 'replace',
			'seo' => array( 'Référencement SEO à Dakar – Dave Procode', 'Audit SEO, optimisation technique, contenus et référencement local pour être trouvé sur Google par vos clients.' ) ),
		array( 'slug' => 'formations-informatiques', 'title' => 'Formations informatiques', 'mode' => 'replace',
			'seo' => array( 'Formations informatiques à Dakar : web, design, UI/UX, bureautique – Dave Procode', 'Développement web et no-code, infographie, UI/UX design et bureautique : formations pratiques en présentiel à Dakar ou en ligne. Inscription en ligne.' ) ),
		array( 'slug' => 'portfolio', 'title' => 'Portfolio', 'mode' => 'create',
			'seo' => array( 'Portfolio – Nos réalisations : sites, applications, identités de marque – Dave Procode', 'Découvrez les sites web, applications, identités visuelles et campagnes réalisés par Dave Procode pour ses clients.' ) ),
		array( 'slug' => 'nos-projets', 'title' => 'Nos projets', 'mode' => 'create',
			'seo' => array( 'Nos projets – Dave Procode', 'En plus de nos services, nous lançons nos propres projets digitaux, comme Bricolibe.' ) ),
		array( 'slug' => 'bricolibe', 'parent' => 'nos-projets', 'title' => 'Bricolibe', 'mode' => 'create',
			'seo' => array( 'Bricolibe – Trouvez un artisan qualifié à Dakar, au juste prix', 'Électricité, plomberie et autres travaux : des artisans vérifiés, aux tarifs fixés avant l\'intervention.' ) ),
		array( 'slug' => 'ventures', 'title' => 'Ventures', 'mode' => 'create',
			'seo' => array( 'Ventures – Co-créez votre projet digital avec Dave Procode', 'Vous avez le marché, nous avons la technologie : co-création, partenariat à la commission ou investissement.' ) ),
		array( 'slug' => 'a-propos', 'title' => 'Qui sommes-nous', 'mode' => 'replace',
			'seo' => array( 'Qui sommes-nous – Dave Procode, solutions digitales à Dakar', 'Née à Dakar en 2023, Dave Procode accompagne entrepreneurs et entreprises dans leurs projets numériques. Notre histoire, notre vision.' ) ),
		array( 'slug' => 'carrieres', 'title' => 'Carrières', 'mode' => 'create',
			'seo' => array( 'Carrières – Rejoignez Dave Procode à Dakar', 'Développeurs, designers, marketeurs, commerciaux : rejoignez une équipe qui construit.' ) ),
		array( 'slug' => 'contact', 'title' => 'Contact', 'mode' => 'replace',
			'seo' => array( 'Contact – Dave Procode, Dakar', 'Un site, une application, une campagne ? Écrivez-nous : réponse sous 48 h ouvrées. WhatsApp +221 77 723 40 86.' ) ),
		array( 'slug' => 'mentions-legales', 'title' => 'Mentions légales', 'mode' => 'create', 'legal' => true ),
		array( 'slug' => 'politique-de-confidentialite', 'title' => 'Politique de confidentialité', 'mode' => 'replace', 'legal' => true ),
	);
}

/* ------------------------------------------------------------------ Menu admin */

add_action( 'admin_menu', function () {
	add_theme_page( 'Installation Dave Procode', 'Installation Dave Procode', 'manage_options', 'dp-setup', 'dp_setup_page' );
} );

add_action( 'after_switch_theme', function ( $old_name = '', $old_theme = null ) {
	update_option( 'dp_show_welcome', 1 );
	if ( $old_theme instanceof WP_Theme ) {
		update_option( 'dp_previous_theme', $old_theme->get_stylesheet() );
	}
}, 10, 2 );

add_action( 'admin_notices', function () {
	if ( ! get_option( 'dp_show_welcome' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_dp-setup' === $screen->id ) {
		return;
	}
	echo '<div class="notice notice-info"><p><strong>Thème Dave Procode activé.</strong> Dernière étape : <a href="' . esc_url( admin_url( 'themes.php?page=dp-setup' ) ) . '">lancer l\'installation du contenu</a>.</p></div>';
} );

/* ------------------------------------------------------------------ Actions */

add_action( 'admin_post_dp_save_settings', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Accès refusé.' );
	}
	check_admin_referer( 'dp_save_settings' );
	$in    = isset( $_POST['dp'] ) && is_array( $_POST['dp'] ) ? wp_unslash( $_POST['dp'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$clean = get_option( 'dp_settings', array() );
	if ( ! is_array( $clean ) ) {
		$clean = array();
	}
	foreach ( array_keys( dp_settings() ) as $k ) {
		if ( 'smtp_on' === $k ) {
			if ( isset( $in['_mailform'] ) ) {
				$clean[ $k ] = empty( $in['smtp_on'] ) ? '' : '1';
			}
			continue;
		}
		if ( ! isset( $in[ $k ] ) ) {
			continue;
		}
		$v = $in[ $k ];
		if ( in_array( $k, array( 'facebook', 'instagram', 'linkedin', 'youtube' ), true ) ) {
			$clean[ $k ] = esc_url_raw( $v );
		} elseif ( in_array( $k, array( 'email', 'from_email' ), true ) ) {
			$clean[ $k ] = sanitize_email( $v );
		} elseif ( 'notify' === $k || 0 === strpos( $k, 'to_' ) ) {
			$list        = array_filter( array_map( 'sanitize_email', array_map( 'trim', explode( ',', $v ) ) ), 'is_email' );
			$clean[ $k ] = implode( ', ', $list );
		} elseif ( 'whatsapp' === $k ) {
			$clean[ $k ] = preg_replace( '/\D/', '', $v );
		} elseif ( 'smtp_pass' === $k ) {
			if ( '' !== trim( $v ) ) {
				$clean[ $k ] = trim( $v ); // Conservé tel quel (caractères spéciaux possibles).
			}
		} else {
			$clean[ $k ] = sanitize_text_field( $v );
		}
	}
	update_option( 'dp_settings', $clean, false );
	delete_site_transient( 'dp_update_info' );
	delete_site_transient( 'update_themes' );
	wp_safe_redirect( admin_url( 'themes.php?page=dp-setup&dp_msg=saved' ) );
	exit;
} );

add_action( 'admin_post_dp_test_mail', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Accès refusé.' );
	}
	check_admin_referer( 'dp_test_mail' );
	$to   = dp_form_recipients( 'contact' );
	$ok   = wp_mail( $to, 'Test d\'envoi — site Dave Procode', "Bonjour,\n\nCet e-mail confirme que les formulaires du site peuvent vous écrire.\n\nDestinataire(s) : " . implode( ', ', $to ) . "\nEnvoi SMTP : " . ( dp_setting( 'smtp_on' ) ? 'activé (' . dp_setting( 'smtp_host' ) . ')' : 'désactivé' ) );
	wp_safe_redirect( admin_url( 'themes.php?page=dp-setup&dp_msg=' . ( $ok ? 'mailok' : 'mailko' ) ) );
	exit;
} );

add_action( 'admin_post_dp_install', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Accès refusé.' );
	}
	check_admin_referer( 'dp_install' );
	$report = dp_run_install();
	set_transient( 'dp_install_report', $report, 10 * MINUTE_IN_SECONDS );
	delete_option( 'dp_show_welcome' );
	wp_safe_redirect( admin_url( 'themes.php?page=dp-setup&dp_msg=installed' ) );
	exit;
} );

add_action( 'admin_post_dp_design', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Accès refusé.' );
	}
	check_admin_referer( 'dp_design' );
	$n = dp_import_media();
	dp_configure_kadence( array() );
	$blog = get_page_by_path( 'blog' );
	dp_build_menu( array(), $blog ? $blog->ID : (int) get_option( 'page_for_posts' ) );
	flush_rewrite_rules( false );
	set_transient( 'dp_install_report', array(
		$n . ' images ajoutées à la médiathèque.',
		'Couleurs, logo seul, en-tête collant et bouton « Nous contacter » appliqués.',
		'Menu principal créé avec les pages qui existent déjà (relancez ce bouton après avoir créé de nouvelles pages).',
		'Aucune page n\'a été modifiée.',
	), 10 * MINUTE_IN_SECONDS );
	delete_option( 'dp_show_welcome' );
	wp_safe_redirect( admin_url( 'themes.php?page=dp-setup&dp_msg=installed' ) );
	exit;
} );

add_action( 'admin_post_dp_rollback', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Accès refusé.' );
	}
	check_admin_referer( 'dp_rollback' );
	dp_run_rollback();
	wp_safe_redirect( admin_url( 'themes.php?page=dp-setup&dp_msg=rolledback' ) );
	exit;
} );

/* ------------------------------------------------------------------ Images */

function dp_photos() {
	return array(
		'bureau'       => 'Bureau Dave Procode avec le logo sur le mur',
		'facade'       => 'Enseigne Dave Procode sur la façade d\'un immeuble',
		'enseigne'     => 'Enseigne lumineuse Dave Procode',
		'cartes'       => 'Cartes de visite Dave Procode',
		'motif'        => 'Motif graphique Dave Procode imprimé',
		'sites-web'    => 'Ordinateur portable affichant du code HTML',
		'applications' => 'Développement d\'applications sur ordinateur portable',
		'marketing'    => 'Smartphone et icônes de réseaux sociaux',
		'design'       => 'Conception graphique sur ordinateur portable',
		'creatif'      => 'Poste de travail créatif avec palette de couleurs',
		'equipe'       => 'Équipe en réunion devant un écran de présentation',
		'reparation'   => 'Technicien réparant un équipement électronique',
		'blog-uiux'    => 'UI et UX Design',
		'blog-charte'  => 'Charte graphique',
		'blog-logo'    => 'Exemple de logo',
		'blog-palette' => 'Exemple de palette de couleurs',
		'case-site'    => 'Page d\'accueil du site Dave Procode',
		// Photos libres de droits (Pexels, licence gratuite pour usage commercial).
		'px-dev-femmes' => 'Deux développeuses travaillant sur un ordinateur portable',
		'px-dev-mains'  => 'Développeuse codant sur un ordinateur portable',
		'px-dev-homme'  => 'Développeur travaillant sur son ordinateur au bureau',
		'px-serveur'    => 'Ingénieure dans une salle de serveurs',
		'px-design'     => 'Designers travaillant ensemble sur un écran',
		'px-atelier'    => 'Atelier de travail en équipe devant un tableau',
		'px-marketing'  => 'Équipe marketing en réunion',
		'px-social'     => 'Smartphone affichant une publication sur les réseaux sociaux',
		'px-creatrice'  => 'Créatrice de contenu travaillant sur son ordinateur',
		'px-formateur'  => 'Formateur présentant un cours à des apprenants',
		'px-professeur' => 'Formateur expliquant au tableau',
		'px-etudiants'  => 'Étudiants travaillant ensemble avec leurs ordinateurs',
		'px-etudiante'  => 'Étudiante souriante avec ses livres',
		'px-promo'      => 'Promotion d\'apprenants célébrant leur réussite',
		'px-equipe'     => 'Équipe souriante autour d\'un ordinateur',
		'px-reunion'    => 'Réunion de travail en salle de conférence',
		'px-conseil'    => 'Entretien de conseil avec une cliente',
		'px-sourire'    => 'Professionnelle souriante devant son ordinateur',
		'px-portrait'   => 'Professionnel souriant au bureau',
		'px-accord'     => 'Poignée de main entre partenaires',
		'px-studio'     => 'Poste de travail de designer graphique',
		'px-binome'     => 'Deux collègues en réunion de travail',
	);
}

/**
 * Copie les images du thème dans la médiathèque (une seule fois) pour qu'elles soient remplaçables.
 */
function dp_import_media() {
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$media = get_option( 'dp_media', array() );
	if ( ! is_array( $media ) ) {
		$media = array();
	}
	$count = 0;
	foreach ( dp_photos() as $key => $alt ) {
		if ( ! empty( $media[ $key ] ) && get_post( $media[ $key ] ) ) {
			continue;
		}
		$file = DP_DIR . '/assets/img/photos/' . $key . '.webp';
		if ( ! file_exists( $file ) ) {
			continue;
		}
		$upload = wp_upload_bits( 'dave-procode-' . $key . '.webp', null, file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( ! empty( $upload['error'] ) ) {
			continue;
		}
		$id = wp_insert_attachment( array(
			'post_mime_type' => 'image/webp',
			'post_title'     => $alt,
			'post_status'    => 'inherit',
		), $upload['file'] );
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		$meta = wp_generate_attachment_metadata( $id, $upload['file'] );
		if ( $meta ) {
			wp_update_attachment_metadata( $id, $meta );
		}
		update_post_meta( $id, '_wp_attachment_image_alt', $alt );
		$media[ $key ] = $id;
		$count++;
	}
	update_option( 'dp_media', $media, false );
	return $count;
}

/**
 * Articles de l'ancien blog : créés seulement s'ils n'existent pas déjà (aucun doublon).
 */
function dp_import_posts( &$log ) {
	$report = array();
	$media  = get_option( 'dp_media', array() );
	foreach ( glob( DP_DIR . '/content/posts/*.html' ) as $file ) {
		$raw = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( ! preg_match( '/^<!-- meta: (.*?) -->\n/', $raw, $m ) ) {
			continue;
		}
		$meta = json_decode( $m[1], true );
		$body = dp_fill_placeholders( substr( $raw, strlen( $m[0] ) ) );
		$existing = get_page_by_path( $meta['slug'], OBJECT, 'post' );
		if ( $existing ) {
			if ( ! has_post_thumbnail( $existing->ID ) && ! empty( $media[ $meta['thumb'] ] ) ) {
				set_post_thumbnail( $existing->ID, (int) $media[ $meta['thumb'] ] );
			}
			$report[] = 'Article déjà présent, conservé tel quel : ' . $meta['title'];
			continue;
		}
		$cat = term_exists( 'graphisme-design', 'category' );
		if ( ! $cat ) {
			$cat = wp_insert_term( 'Graphisme & Design', 'category', array( 'slug' => 'graphisme-design' ) );
		}
		$cat_id = is_array( $cat ) ? (int) $cat['term_id'] : (int) $cat;
		$id = wp_insert_post( array(
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'post_title'    => $meta['title'],
			'post_name'     => $meta['slug'],
			'post_content'  => wp_slash( $body ),
			'post_excerpt'  => $meta['excerpt'],
			'post_date'     => str_replace( 'T', ' ', $meta['date'] ),
			'post_category' => $cat_id ? array( $cat_id ) : array(),
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			if ( ! empty( $media[ $meta['thumb'] ] ) ) {
				set_post_thumbnail( $id, (int) $media[ $meta['thumb'] ] );
			}
			$log['created'][] = $id;
			$report[]         = 'Article ajouté : ' . $meta['title'];
		}
	}
	return $report;
}

/**
 * Réalisations d'exemple : publiées pour les projets du groupe, brouillons pour les clients (à compléter).
 */
function dp_import_realisations( &$log ) {
	$report = array();
	$media  = get_option( 'dp_media', array() );
	foreach ( glob( DP_DIR . '/content/realisations/*.html' ) as $file ) {
		$raw = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( ! preg_match( '/^<!-- meta: (.*?) -->\n/', $raw, $m ) ) {
			continue;
		}
		$meta = json_decode( $m[1], true );
		if ( get_page_by_path( $meta['slug'], OBJECT, 'realisation' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'realisation',
			'post_status'  => $meta['status'],
			'post_title'   => $meta['title'],
			'post_name'    => $meta['slug'],
			'post_excerpt' => $meta['excerpt'],
			'post_content' => wp_slash( dp_fill_placeholders( substr( $raw, strlen( $m[0] ) ) ) ),
		) );
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_dp_client', $meta['client'] );
		update_post_meta( $id, '_dp_year', $meta['year'] );
		if ( ! empty( $meta['url'] ) ) {
			update_post_meta( $id, '_dp_url', esc_url_raw( dp_fill_placeholders( $meta['url'] ) ) );
		}
		$term_ids = array();
		foreach ( $meta['types'] as $name ) {
			$t = term_exists( $name, 'type_projet' );
			if ( ! $t ) {
				$t = wp_insert_term( $name, 'type_projet' );
			}
			if ( ! is_wp_error( $t ) ) {
				$term_ids[] = (int) ( is_array( $t ) ? $t['term_id'] : $t );
			}
		}
		wp_set_object_terms( $id, $term_ids, 'type_projet' );
		if ( ! empty( $media[ $meta['thumb'] ] ) ) {
			set_post_thumbnail( $id, (int) $media[ $meta['thumb'] ] );
		}
		$log['created'][] = $id;
		$report[]         = ( 'publish' === $meta['status'] ? 'Réalisation publiée : ' : 'Réalisation en brouillon (à compléter) : ' ) . $meta['title'];
	}
	return $report;
}

/* ------------------------------------------------------------------ Installation */

function dp_read_content( $slug ) {
	$file = DP_DIR . '/content/' . $slug . '.html';
	if ( ! file_exists( $file ) ) {
		return '';
	}
	return dp_fill_placeholders( file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
}

function dp_run_install() {
	$log = get_option( 'dp_install_log' );
	if ( ! is_array( $log ) ) {
		$log = array(
			'created'  => array(),
			'replaced' => array(),
			'drafted'  => array(),
			'options'  => array(
				'show_on_front'               => get_option( 'show_on_front' ),
				'page_on_front'               => get_option( 'page_on_front' ),
				'page_for_posts'              => get_option( 'page_for_posts' ),
				'wp_page_for_privacy_policy'  => get_option( 'wp_page_for_privacy_policy' ),
				'kadence_global_palette'      => get_option( 'kadence_global_palette' ),
			),
			'menus'    => array(),
			'locations'=> get_theme_mod( 'nav_menu_locations' ),
		);
	}
	$report = array();

	// Enregistre les types de contenu avant de créer les pages (adresses propres).
	flush_rewrite_rules( false );

	$imported = dp_import_media();
	$report[] = $imported ? $imported . ' images ajoutées à la médiathèque.' : 'Images déjà présentes dans la médiathèque.';

	$ids = array();
	foreach ( dp_pages_definition() as $def ) {
		$path     = isset( $def['parent'] ) ? $def['parent'] . '/' . $def['slug'] : $def['slug'];
		$existing = get_page_by_path( $path, OBJECT, 'page' );
		$content  = dp_read_content( $def['slug'] );
		$parent   = isset( $def['parent'] ) && isset( $ids[ $def['parent'] ] ) ? $ids[ $def['parent'] ] : 0;
		$args     = array(
			'post_type'    => 'page',
			'post_title'   => $def['title'],
			'post_name'    => $def['slug'],
			'post_content' => wp_slash( $content ),
			'post_status'  => 'publish',
			'post_parent'  => $parent,
		);

		if ( $existing && 'trash' !== $existing->post_status ) {
			$id = $existing->ID;
			$already_ours = get_post_meta( $id, '_dp_built', true );
			if ( ! $already_ours && ! isset( $log['replaced'][ $id ] ) && ! in_array( $id, $log['created'], true ) ) {
				$log['replaced'][ $id ] = array(
					'title'   => $existing->post_title,
					'content' => $existing->post_content,
					'status'  => $existing->post_status,
					'seo'     => array(
						get_post_meta( $id, '_yoast_wpseo_title', true ),
						get_post_meta( $id, '_yoast_wpseo_metadesc', true ),
					),
				);
			}
			$args['ID'] = $id;
			wp_update_post( $args );
			$report[] = 'Page mise à jour : ' . $def['title'] . ( $already_ours ? '' : ' (ancien contenu sauvegardé)' );
		} else {
			$id = wp_insert_post( $args );
			if ( is_wp_error( $id ) || ! $id ) {
				$report[] = 'ERREUR à la création de : ' . $def['title'];
				continue;
			}
			$log['created'][] = $id;
			$report[]         = 'Page créée : ' . $def['title'];
		}
		$ids[ $def['slug'] ] = $id;

		update_post_meta( $id, '_dp_built', 1 );
		update_post_meta( $id, '_kad_post_title', 'hide' );
		update_post_meta( $id, '_kad_post_layout', empty( $def['legal'] ) ? 'fullwidth' : 'narrow' );
		update_post_meta( $id, '_kad_post_content_style', 'unboxed' );
		update_post_meta( $id, '_kad_post_vertical_padding', 'hide' );
		if ( ! empty( $def['seo'] ) ) {
			update_post_meta( $id, '_yoast_wpseo_title', $def['seo'][0] );
			update_post_meta( $id, '_yoast_wpseo_metadesc', $def['seo'][1] );
		}
	}

	// Page « Actualités » (articles).
	$blog = get_page_by_path( 'blog' );
	if ( ! $blog ) {
		$blog_id          = wp_insert_post( array( 'post_type' => 'page', 'post_title' => 'Blog', 'post_name' => 'blog', 'post_status' => 'publish' ) );
		$log['created'][] = $blog_id;
		$report[]         = 'Page créée : Actualités (/blog/)';
	} else {
		$blog_id = $blog->ID;
		if ( 'publish' !== $blog->post_status ) {
			wp_update_post( array( 'ID' => $blog_id, 'post_status' => 'publish' ) );
		}
	}

	// Lecture : page d'accueil statique + page des articles.
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['accueil'] );
	update_option( 'page_for_posts', $blog_id );
	if ( isset( $ids['politique-de-confidentialite'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $ids['politique-de-confidentialite'] );
	}
	$report[] = 'Page d\'accueil et page Blog définies.';

	// Pages d'une version précédente du thème devenues inutiles.
	foreach ( array( 'studio', 'solutions/cademylab', 'solutions/gestion-prets-tontines', 'solutions/bricolibe', 'solutions' ) as $obsolete ) {
		$p = get_page_by_path( $obsolete );
		if ( $p && get_post_meta( $p->ID, '_dp_built', true ) ) {
			wp_trash_post( $p->ID );
		}
	}

	// Anciennes pages remplacées : brouillon + redirection 301.
	foreach ( array( 'agence-de-communication-a-dakar', 'cartes-de-visites-dakar' ) as $old ) {
		$p = get_page_by_path( $old );
		if ( $p && 'publish' === $p->post_status ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
			$log['drafted'][] = $p->ID;
			$report[]         = 'Ancienne page passée en brouillon (redirigée en 301) : ' . $p->post_title;
		}
	}

	// Articles du blog et réalisations.
	$report = array_merge( $report, dp_import_posts( $log ), dp_import_realisations( $log ) );

	// Types de projet par défaut.
	foreach ( array( 'Site web', 'Application', 'UI/UX design', 'Identité visuelle', 'Marketing digital' ) as $term ) {
		if ( ! term_exists( $term, 'type_projet' ) ) {
			wp_insert_term( $term, 'type_projet' );
		}
	}

	// Menu principal.
	$menu_id = dp_build_menu( $ids, $blog_id );
	if ( $menu_id ) {
		$log['menus'] = array( $menu_id );
		$report[]     = 'Menu principal créé et placé dans l\'en-tête (ordinateur et mobile).';
	}

	// Réglages Kadence (en-tête, palette, pied de page, logo).
	dp_configure_kadence( $ids );
	$report[] = 'Kadence configuré : palette Dave Procode, en-tête collant, bouton « Nous contacter », pied de page.';

	update_option( 'dp_install_log', $log, false );
	flush_rewrite_rules( false );
	$report[] = 'Installation terminée.';
	return $report;
}

function dp_build_menu( $ids, $blog_id ) {
	$name = 'Menu principal (Dave Procode)';
	$old  = wp_get_nav_menu_object( $name );
	if ( $old ) {
		wp_delete_nav_menu( $old->term_id );
	}
	$menu_id = wp_create_nav_menu( $name );
	if ( is_wp_error( $menu_id ) ) {
		return 0;
	}
	$add = function ( $title, $page_id = 0, $url = '', $parent = 0, $classes = '' ) use ( $menu_id ) {
		if ( ! $page_id && '' === $url ) {
			return 0; // Page absente : on n'ajoute pas de lien cassé.
		}
		$item = array(
			'menu-item-title'     => $title,
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $parent,
			'menu-item-classes'   => $classes,
		);
		if ( $page_id ) {
			$item['menu-item-type']      = 'post_type';
			$item['menu-item-object']    = 'page';
			$item['menu-item-object-id'] = $page_id;
		} else {
			$item['menu-item-type'] = 'custom';
			$item['menu-item-url']  = $url;
		}
		return wp_update_nav_menu_item( $menu_id, 0, $item );
	};
	$page = function ( $slug ) {
		$p = get_page_by_path( $slug );
		return ( $p && 'publish' === $p->post_status ) ? $p->ID : 0;
	};
	foreach ( array( 'services', 'nos-projets', 'a-propos', 'ventures', 'carrieres', 'contact' ) as $k ) {
		if ( empty( $ids[ $k ] ) ) {
			$ids[ $k ] = $page( $k );
		}
	}
	if ( empty( $ids['bricolibe'] ) ) {
		$ids['bricolibe'] = $page( 'nos-projets/bricolibe' );
	}

	$srv = $add( 'Services', $ids['services'] );
	$services = array(
		'creation-de-sites-web'     => 'Création de sites web',
		'creation-dapplications'    => 'Applications web et mobiles',
		'marketing-digital'         => 'Marketing digital',
		'maquette-dapplications'    => 'UI/UX design',
		'logo-et-charte-graphique'  => 'Logo et charte graphique',
		'referencement-seo-a-dakar' => 'Référencement SEO',
		'formations-informatiques'  => 'Formations',
	);
	foreach ( $services as $slug => $label ) {
		$pid = $page( $slug );
		if ( $pid ) {
			$add( $label, $pid, '', $srv );
		}
	}
	$pf = $page( 'portfolio' );
	if ( $pf ) {
		$add( 'Portfolio', $pf );
	}

	$prj = $add( 'Nos projets', $ids['nos-projets'] );
	$add( 'Bricolibe', $ids['bricolibe'], '', $prj );

	$grp = $add( 'Le Groupe', $ids['a-propos'] );
	$add( 'Qui sommes-nous', $ids['a-propos'], '', $grp );
	$add( 'Ventures', $ids['ventures'], '', $grp );
	$add( 'Carrières', $ids['carrieres'], '', $grp );
	$add( 'Blog', $blog_id );
	$add( 'Contact', $ids['contact'], '', 0, 'dp-menu-contact' );

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	$locations['mobile']  = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
	return $menu_id;
}

function dp_configure_kadence( $ids ) {
	foreach ( array( 'contact', 'mentions-legales', 'politique-de-confidentialite' ) as $k ) {
		if ( empty( $ids[ $k ] ) ) {
			$p         = get_page_by_path( $k );
			$ids[ $k ] = $p ? $p->ID : 0;
		}
	}
	// Palette globale (modifiable ensuite dans Personnaliser > Couleurs).
	// Couleurs de la charte graphique 2025.
	$colors  = array( '#0D7AD3', '#C65A10', '#001730', '#19354F', '#3D4B5C', '#627083', '#DFE7F0', '#EEF6FD', '#FFFFFF', '#FFFFFF', '#13612E', '#2A92D8', '#B82105', '#DD7D52', '#F4C0A6' );
	$names   = array( 'Bleu Dave Procode', 'Orange Dave Procode', 'Bleu nuit', 'Bleu ardoise', 'Texte', 'Texte discret', 'Bordure', 'Bleu très clair', 'Blanc', 'Complément', 'Succès', 'Bleu secondaire', 'Alerte', 'Orange secondaire', 'Pêche' );
	$palette = array();
	foreach ( $colors as $i => $c ) {
		$palette[] = array( 'color' => $c, 'slug' => 'palette' . ( $i + 1 ), 'name' => $names[ $i ] );
	}
	update_option( 'kadence_global_palette', wp_json_encode( array(
		'palette'        => $palette,
		'second-palette' => $palette,
		'third-palette'  => $palette,
		'active'         => 'palette',
	) ) );

	// En-tête : logo à gauche, menu + bouton à droite, collant.
	$items = get_theme_mod( 'header_desktop_items' );
	if ( ! is_array( $items ) || empty( $items['main'] ) ) {
		$items = array(
			'top'    => array( 'top_left' => array(), 'top_left_center' => array(), 'top_center' => array(), 'top_right_center' => array(), 'top_right' => array() ),
			'main'   => array( 'main_left' => array( 'logo' ), 'main_left_center' => array(), 'main_center' => array(), 'main_right_center' => array(), 'main_right' => array( 'navigation', 'button' ) ),
			'bottom' => array( 'bottom_left' => array(), 'bottom_left_center' => array(), 'bottom_center' => array(), 'bottom_right_center' => array(), 'bottom_right' => array() ),
		);
	} elseif ( ! in_array( 'button', $items['main']['main_right'], true ) ) {
		$items['main']['main_right'][] = 'button';
	}
	set_theme_mod( 'header_desktop_items', $items );
	set_theme_mod( 'header_button_label', 'Nous contacter' );
	set_theme_mod( 'header_button_link', $ids['contact'] ? get_permalink( $ids['contact'] ) : home_url( '/contact/' ) );
	set_theme_mod( 'header_sticky', 'main' );
	set_theme_mod( 'header_main_height', array( 'size' => array( 'mobile' => 72, 'tablet' => 80, 'desktop' => 92 ), 'unit' => array( 'mobile' => 'px', 'tablet' => 'px', 'desktop' => 'px' ) ) );
	// Logo seul (le nom est déjà dans le logo).
	set_theme_mod( 'logo_layout', array(
		'include' => array( 'mobile' => 'logo', 'tablet' => 'logo', 'desktop' => 'logo' ),
		'layout'  => array( 'mobile' => 'standard', 'tablet' => 'standard', 'desktop' => 'standard' ),
	) );
	set_theme_mod( 'logo_width', array( 'size' => array( 'mobile' => 64, 'tablet' => 72, 'desktop' => 84 ), 'unit' => array( 'mobile' => 'px', 'tablet' => 'px', 'desktop' => 'px' ) ) );
	set_theme_mod( 'content_width', array( 'size' => 1200, 'unit' => 'px' ) );

	// Blog : grille de 3 colonnes avec images.
	set_theme_mod( 'post_archive_columns', '3' );
	set_theme_mod( 'post_archive_layout', 'normal' );

	// Pied de page.
	$legal = $ids['mentions-legales'] ? get_permalink( $ids['mentions-legales'] ) : home_url( '/mentions-legales/' );
	$priv  = $ids['politique-de-confidentialite'] ? get_permalink( $ids['politique-de-confidentialite'] ) : home_url( '/politique-de-confidentialite/' );
	set_theme_mod( 'footer_html_content', '{copyright} {year} {site-title} · Solutions digitales à Dakar · <a href="' . esc_url( $legal ) . '">Mentions légales</a> · <a href="' . esc_url( $priv ) . '">Confidentialité</a>' );

	// Reprendre le logo de l'ancien thème (les réglages de logo sont propres à chaque thème).
	if ( ! get_theme_mod( 'custom_logo' ) ) {
		$candidates = array_filter( array( get_option( 'dp_previous_theme' ), 'astra', 'kadence' ) );
		foreach ( $candidates as $slug ) {
			$mods = get_option( 'theme_mods_' . $slug );
			if ( is_array( $mods ) && ! empty( $mods['custom_logo'] ) ) {
				set_theme_mod( 'custom_logo', (int) $mods['custom_logo'] );
				break;
			}
		}
	}
}

/* ------------------------------------------------------------------ Annulation */

function dp_run_rollback() {
	$log = get_option( 'dp_install_log' );
	if ( ! is_array( $log ) ) {
		return;
	}
	foreach ( $log['replaced'] as $id => $old ) {
		wp_update_post( array(
			'ID'           => (int) $id,
			'post_title'   => $old['title'],
			'post_content' => wp_slash( $old['content'] ),
			'post_status'  => $old['status'],
		) );
		delete_post_meta( $id, '_dp_built' );
		if ( isset( $old['seo'] ) ) {
			update_post_meta( $id, '_yoast_wpseo_title', $old['seo'][0] );
			update_post_meta( $id, '_yoast_wpseo_metadesc', $old['seo'][1] );
		}
		foreach ( array( '_kad_post_title', '_kad_post_layout', '_kad_post_content_style', '_kad_post_vertical_padding' ) as $m ) {
			delete_post_meta( $id, $m );
		}
	}
	foreach ( $log['created'] as $id ) {
		wp_trash_post( (int) $id );
	}
	foreach ( $log['drafted'] as $id ) {
		wp_update_post( array( 'ID' => (int) $id, 'post_status' => 'publish' ) );
	}
	foreach ( $log['menus'] as $menu ) {
		wp_delete_nav_menu( (int) $menu );
	}
	foreach ( $log['options'] as $k => $v ) {
		if ( false === $v || null === $v ) {
			delete_option( $k );
		} else {
			update_option( $k, $v );
		}
	}
	set_theme_mod( 'nav_menu_locations', is_array( $log['locations'] ) ? $log['locations'] : array() );
	delete_option( 'dp_install_log' );
	flush_rewrite_rules( false );
}

/* ------------------------------------------------------------------ Écran */

function dp_setup_page() {
	$s         = dp_settings();
	$installed = is_array( get_option( 'dp_install_log' ) );
	$parent    = wp_get_theme()->parent();
	$msg       = isset( $_GET['dp_msg'] ) ? sanitize_key( wp_unslash( $_GET['dp_msg'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$report    = get_transient( 'dp_install_report' );
	$fields    = array(
		'phone'     => 'Téléphone affiché',
		'whatsapp'  => 'Numéro WhatsApp (chiffres, avec indicatif : 221…)',
		'email'     => 'E-mail affiché',
		'notify'    => 'E-mail qui reçoit les formulaires',
		'address'   => 'Adresse',
		'hours'     => 'Horaires',
		'tagline'   => 'Signature (pied de page)',
		'announce'  => 'Barre d\'annonce (vide = masquée)',
		'facebook'  => 'Facebook',
		'instagram' => 'Instagram',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
	);
	?>
	<div class="wrap">
		<h1>Installation Dave Procode</h1>

		<?php if ( 'saved' === $msg ) : ?>
			<div class="notice notice-success"><p>Coordonnées enregistrées. Elles s'appliquent partout sur le site (contact, pied de page, formulaires).</p></div>
		<?php elseif ( 'installed' === $msg ) : ?>
			<div class="notice notice-success"><p><strong>Installation terminée.</strong> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">Voir le site</a></p>
			<?php if ( is_array( $report ) ) : ?><ul style="list-style:disc;margin-left:20px"><?php foreach ( $report as $line ) : ?><li><?php echo esc_html( $line ); ?></li><?php endforeach; ?></ul><?php endif; ?>
			</div>
		<?php elseif ( 'mailok' === $msg ) : ?>
			<div class="notice notice-success"><p>E-mail de test envoyé à : <?php echo esc_html( implode( ', ', dp_form_recipients( 'contact' ) ) ); ?>. Vérifiez la boîte de réception (et les spams).</p></div>
		<?php elseif ( 'mailko' === $msg ) : ?>
			<div class="notice notice-error"><p>L'e-mail de test n'a pas pu partir. Activez l'envoi SMTP ci-dessous avec les paramètres de votre messagerie pro, puis réessayez.</p></div>
		<?php elseif ( 'seo' === $msg ) : ?>
			<div class="notice notice-success"><p><strong>Réglages Yoast appliqués.</strong> Le rapport détaillé est dans la carte « Optimisation Yoast SEO » ci-dessous.</p></div>
		<?php elseif ( 'rolledback' === $msg ) : ?>
			<div class="notice notice-warning"><p>Installation annulée : les anciennes pages, la page d'accueil et les menus ont été restaurés. Les pages créées sont dans la corbeille.</p></div>
		<?php endif; ?>

		<div class="card" id="dp-updates" style="max-width:1152px;padding:16px 24px;margin-top:16px">
			<h2 style="margin-top:0">Mises à jour du thème</h2>
			<?php echo dp_update_status_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
				<input type="hidden" name="action" value="dp_save_settings">
				<?php wp_nonce_field( 'dp_save_settings' ); ?>
				<label for="dp-update_repo"><strong>Dépôt GitHub du thème</strong></label>
				<input type="text" class="regular-text" id="dp-update_repo" name="dp[update_repo]" value="<?php echo esc_attr( $s['update_repo'] ); ?>" placeholder="votre-compte/daveprocode-theme">
				<?php submit_button( 'Enregistrer', 'secondary', 'submit', false ); ?>
			</form>
			<p class="description">Quand une nouvelle version est publiée, elle apparaît dans Tableau de bord &gt; Mises à jour : cliquez sur « Mettre à jour », comme pour une extension. Vos pages, réglages Yoast et messages ne sont jamais modifiés par une mise à jour.</p>
		</div>

		<?php if ( $installed && function_exists( 'dp_seo_card' ) ) { dp_seo_card(); } ?>

		<div style="display:grid;grid-template-columns:minmax(0,1.2fr) minmax(0,1fr);gap:24px;max-width:1200px;margin-top:16px">
			<div class="card" style="max-width:none;padding:20px 24px">
				<h2>1. Vérifications</h2>
				<ul>
					<li><?php echo $parent && 'kadence' === $parent->get_template() ? '<span class="dashicons dashicons-yes-alt" style="color:#0f8a5f"></span>' : '<span class="dashicons dashicons-dismiss" style="color:#b82105"></span>'; ?> Thème parent Kadence installé</li>
					<li><?php echo defined( 'WPSEO_VERSION' ) ? '<span class="dashicons dashicons-yes-alt" style="color:#0f8a5f"></span> Yoast SEO actif : titres et descriptions remplis automatiquement' : '<span class="dashicons dashicons-info" style="color:#0a6cc9"></span> Yoast SEO non détecté (facultatif)'; ?></li>
					<li><?php echo get_theme_mod( 'custom_logo' ) ? '<span class="dashicons dashicons-yes-alt" style="color:#0f8a5f"></span> Logo défini' : '<span class="dashicons dashicons-info" style="color:#0a6cc9"></span> Logo : ajoutez-le dans Apparence > Personnaliser > En-tête > Logo'; ?></li>
				</ul>

				<h2 style="margin-top:28px">2. Installer le contenu</h2>
				<p>Crée les pages (Accueil, Services, Marketing digital, Nos projets, Bricolibe, Ventures, Carrières, pages légales), met à jour Qui sommes-nous, Contact et Applications, crée le menu et configure Kadence.</p>
				<ul style="list-style:disc;margin-left:20px">
					<li>Vos pages Création de sites web, UI/UX, Logo, SEO et Formations sont <strong>conservées</strong> et reliées au menu Services.</li>
					<li>« À propos », « Contact » et « Création d'applications » reçoivent le nouveau contenu ; <strong>l'ancien est sauvegardé</strong> et restaurable.</li>
					<li>Vos articles de blog ne sont pas touchés.</li>
				</ul>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'dp_install' ); ?>
					<input type="hidden" name="action" value="dp_install">
					<p><label><input type="checkbox" required> J'ai fait une sauvegarde du site (recommandé : UpdraftPlus)</label></p>
					<?php submit_button( $installed ? 'Réinstaller le contenu (écrase les pages Dave Procode)' : 'Installer le contenu', 'primary large', 'submit', false ); ?>
				</form>

				<h2 style="margin-top:28px">Ou : appliquer seulement le design</h2>
				<p>Pour coller vous-même le code de chaque page : règle les couleurs, le logo, l'en-tête et le menu, et ajoute les images à la médiathèque, <strong>sans créer ni modifier aucune page</strong>.</p>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'dp_design' ); ?>
					<input type="hidden" name="action" value="dp_design">
					<?php submit_button( 'Appliquer seulement le design', 'secondary', 'submit', false ); ?>
				</form>

				<?php if ( $installed ) : ?>
					<h2 style="margin-top:28px">Annuler l'installation</h2>
					<p>Restaure les anciennes pages, l'ancienne page d'accueil et les anciens menus. Les pages créées partent à la corbeille.</p>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('Annuler l\'installation et restaurer l\'ancien contenu ?');">
						<?php wp_nonce_field( 'dp_rollback' ); ?>
						<input type="hidden" name="action" value="dp_rollback">
						<?php submit_button( 'Annuler l\'installation', 'secondary', 'submit', false ); ?>
					</form>
				<?php endif; ?>

				<h2 style="margin-top:28px">3. Après l'installation</h2>
				<ol style="margin-left:20px">
					<li>Compléter les <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">mentions légales</a> (NINEA, RCCM, hébergeur).</li>
					<li>Ajouter vos travaux clients dans <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=realisation' ) ); ?>">Réalisations</a> (titre, image mise en avant, type de projet, client et année) : ils s'affichent automatiquement sur la page Portfolio.</li>
					<li>Lire les messages des formulaires dans <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=dp_message' ) ); ?>">Messages reçus</a>.</li>
					<li>Créer une nouvelle page produit : Pages > Ajouter > Compositions > Dave Procode > « Fiche produit complète ».</li>
				</ol>
			</div>

			<div class="card" style="max-width:none;padding:20px 24px">
				<h2>Coordonnées et réseaux</h2>
				<p>Utilisées dans la page Contact, le pied de page, les boutons WhatsApp et les formulaires.</p>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'dp_save_settings' ); ?>
					<input type="hidden" name="action" value="dp_save_settings">
					<table class="form-table" role="presentation">
						<?php foreach ( $fields as $key => $label ) : ?>
							<tr>
								<th scope="row"><label for="dp-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
								<td><input class="regular-text" id="dp-<?php echo esc_attr( $key ); ?>" name="dp[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $s[ $key ] ); ?>"></td>
							</tr>
						<?php endforeach; ?>
					</table>
					<?php submit_button( 'Enregistrer les coordonnées' ); ?>
				</form>
				<p class="description">Astuce : enregistrez vos coordonnées <em>avant</em> d'installer le contenu, pour que les liens WhatsApp des pages utilisent le bon numéro.</p>
			</div>

			<div class="card" style="max-width:none;padding:20px 24px;grid-column:1 / -1">
				<h2>E-mails des formulaires</h2>
				<p>Chaque formulaire peut écrire à une adresse différente (plusieurs adresses possibles, séparées par des virgules). Laissez vide pour utiliser l'adresse générale « E-mail qui reçoit les formulaires ». Tous les messages restent aussi consultables dans <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=dp_message' ) ); ?>">Messages reçus</a>.</p>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'dp_save_settings' ); ?>
					<input type="hidden" name="action" value="dp_save_settings">
					<input type="hidden" name="dp[_mailform]" value="1">
					<table class="form-table" role="presentation">
						<?php
						$mail_fields = array(
							'to_devis'      => 'Demandes de devis',
							'to_formation'  => 'Inscriptions aux formations',
							'to_contact'    => 'Formulaire de contact',
							'to_ventures'   => 'Propositions de projets (Ventures)',
							'to_carriere'   => 'Candidatures',
							'to_newsletter' => 'Inscriptions newsletter',
							'from_name'     => 'Nom de l\'expéditeur',
							'from_email'    => 'Adresse d\'expédition (votre e-mail pro, ex. contact@daveprocode.com)',
						);
						foreach ( $mail_fields as $key => $label ) :
							?>
							<tr>
								<th scope="row"><label for="dp-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
								<td><input class="regular-text" id="dp-<?php echo esc_attr( $key ); ?>" name="dp[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $s[ $key ] ); ?>" placeholder="<?php echo 0 === strpos( $key, 'to_' ) ? esc_attr( $s['notify'] ) : ''; ?>"></td>
							</tr>
						<?php endforeach; ?>
					</table>
					<h3>Envoi SMTP (recommandé)</h3>
					<p>Avec une adresse pro (hébergeur, Zoho, Google Workspace, Microsoft 365…), activez le SMTP pour que les e-mails arrivent à coup sûr et ne tombent pas en spam. Les paramètres sont fournis par votre messagerie (ex. hôte <code>mail.daveprocode.com</code>, port 465 SSL ou 587 TLS).</p>
					<table class="form-table" role="presentation">
						<tr><th scope="row">Activer le SMTP</th><td><label><input type="checkbox" name="dp[smtp_on]" value="1" <?php checked( $s['smtp_on'], '1' ); ?>> Envoyer les e-mails via ma messagerie pro</label></td></tr>
						<tr><th scope="row"><label for="dp-smtp_host">Serveur SMTP (hôte)</label></th><td><input class="regular-text" id="dp-smtp_host" name="dp[smtp_host]" value="<?php echo esc_attr( $s['smtp_host'] ); ?>" placeholder="mail.daveprocode.com"></td></tr>
						<tr><th scope="row"><label for="dp-smtp_port">Port</label></th><td><input class="small-text" id="dp-smtp_port" name="dp[smtp_port]" value="<?php echo esc_attr( $s['smtp_port'] ); ?>"></td></tr>
						<tr><th scope="row"><label for="dp-smtp_secure">Chiffrement</label></th><td><select id="dp-smtp_secure" name="dp[smtp_secure]"><option value="ssl" <?php selected( $s['smtp_secure'], 'ssl' ); ?>>SSL (port 465)</option><option value="tls" <?php selected( $s['smtp_secure'], 'tls' ); ?>>TLS (port 587)</option><option value="none" <?php selected( $s['smtp_secure'], 'none' ); ?>>Aucun</option></select></td></tr>
						<tr><th scope="row"><label for="dp-smtp_user">Identifiant (adresse e-mail)</label></th><td><input class="regular-text" id="dp-smtp_user" name="dp[smtp_user]" value="<?php echo esc_attr( $s['smtp_user'] ); ?>" autocomplete="off"></td></tr>
						<tr><th scope="row"><label for="dp-smtp_pass">Mot de passe</label></th><td><input type="password" class="regular-text" id="dp-smtp_pass" name="dp[smtp_pass]" value="" autocomplete="new-password" placeholder="<?php echo $s['smtp_pass'] ? '•••••••• (enregistré — laisser vide pour le conserver)' : ''; ?>"></td></tr>
					</table>
					<?php submit_button( 'Enregistrer les réglages e-mail' ); ?>
				</form>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'dp_test_mail' ); ?>
					<input type="hidden" name="action" value="dp_test_mail">
					<?php submit_button( 'Envoyer un e-mail de test', 'secondary', 'submit', false ); ?>
				</form>
			</div>
		</div>
	</div>
	<?php
}
