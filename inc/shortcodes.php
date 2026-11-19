<?php
/**
 * Codes courts : [dp_contact], [dp_realisations], [dp_produits].
 *
 * @package daveprocode
 */

defined( 'ABSPATH' ) || exit;

/* Bloc coordonnées (lit les réglages : une seule source à mettre à jour). */
add_shortcode( 'dp_contact', function () {
	$s     = dp_settings();
	$tel   = preg_replace( '/[^0-9+]/', '', $s['phone'] );
	$out   = '<ul class="dp-checks dp-contact-list">';
	$out  .= '<li><strong>Téléphone :</strong> <a href="tel:' . esc_attr( $tel ) . '">' . esc_html( $s['phone'] ) . '</a></li>';
	$out  .= '<li><strong>WhatsApp :</strong> <a href="https://wa.me/' . esc_attr( $s['whatsapp'] ) . '" target="_blank" rel="noopener">Écrire sur WhatsApp</a></li>';
	$out  .= '<li><strong>E-mail :</strong> <a href="mailto:' . esc_attr( $s['email'] ) . '">' . esc_html( $s['email'] ) . '</a></li>';
	$out  .= '<li><strong>Adresse :</strong> ' . esc_html( $s['address'] ) . '</li>';
	if ( $s['hours'] ) {
		$out .= '<li><strong>Horaires :</strong> ' . esc_html( $s['hours'] ) . '</li>';
	}
	return $out . '</ul>';
} );

/* Grille des réalisations (type de contenu « Réalisation »). */
add_shortcode( 'dp_realisations', function ( $atts ) {
	$atts = shortcode_atts( array( 'count' => 6 ), $atts, 'dp_realisations' );
	$q    = new WP_Query( array(
		'post_type'      => 'realisation',
		'posts_per_page' => (int) $atts['count'],
		'no_found_rows'  => true,
	) );
	if ( ! $q->have_posts() ) {
		if ( current_user_can( 'edit_posts' ) ) {
			return '<div class="dp-empty"><p>Visible par vous seul : aucune réalisation publiée pour le moment. Ajoutez-en dans <a href="' . esc_url( admin_url( 'post-new.php?post_type=realisation' ) ) . '">Réalisations &gt; Ajouter</a>, elles apparaîtront ici automatiquement.</p></div>';
		}
		$devis = get_page_by_path( 'services' );
		$url   = $devis ? get_permalink( $devis ) . '#devis' : home_url( '/contact/' );
		return '<div class="dp-empty dp-empty--cta"><div><h3>Votre projet pourrait être le prochain.</h3><p>Sites, applications, campagnes : parlons de ce que nous pouvons construire ensemble.</p></div>'
			. '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '">Demander un devis</a></div></div>';
	}
	$out = '<div class="dp-realisations">';
	while ( $q->have_posts() ) {
		$q->the_post();
		$terms = get_the_terms( get_the_ID(), 'type_projet' );
		$out  .= '<article class="dp-card">';
		if ( has_post_thumbnail() ) {
			$out .= '<a href="' . esc_url( get_permalink() ) . '">' . get_the_post_thumbnail( null, 'medium_large', array( 'loading' => 'lazy' ) ) . '</a>';
		}
		if ( $terms && ! is_wp_error( $terms ) ) {
			$out .= '<p class="dp-badge">' . esc_html( $terms[0]->name ) . '</p>';
		}
		$out .= '<h3><a href="' . esc_url( get_permalink() ) . '" style="color:inherit;text-decoration:none">' . esc_html( get_the_title() ) . '</a></h3>';
		$out .= '<p>' . esc_html( get_the_excerpt() ) . '</p>';
		$out .= '<p class="dp-link-arrow"><a href="' . esc_url( get_permalink() ) . '">Voir le projet</a></p>';
		$out .= '</article>';
	}
	wp_reset_postdata();
	return $out . '</div>';
} );

/* ------------------------------------------------------------------ Portfolio */

/* Champs d'une réalisation : client, année, lien. */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'dp_case', 'Informations du projet', function ( $post ) {
		wp_nonce_field( 'dp_case', 'dp_case_nonce' );
		$fields = array( '_dp_client' => 'Client', '_dp_year' => 'Année', '_dp_url' => 'Lien (site en ligne, application…)' );
		foreach ( $fields as $key => $label ) {
			echo '<p><label for="' . esc_attr( $key ) . '"><strong>' . esc_html( $label ) . '</strong></label><br><input type="text" style="width:100%" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( get_post_meta( $post->ID, $key, true ) ) . '"></p>';
		}
		echo '<p class="description">Image à la une = vignette du portfolio. Extrait = phrase de résultat affichée sur la carte. Type de projet = filtre du portfolio.</p>';
	}, 'realisation', 'side' );
} );
add_action( 'save_post_realisation', function ( $post_id ) {
	if ( ! isset( $_POST['dp_case_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dp_case_nonce'] ) ), 'dp_case' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array( '_dp_client', '_dp_year', '_dp_url' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, '_dp_url' === $key ? esc_url_raw( wp_unslash( $_POST[ $key ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
} );

/* [dp_portfolio] : grille filtrable des réalisations publiées. */
add_shortcode( 'dp_portfolio', function ( $atts ) {
	$atts = shortcode_atts( array( 'count' => 24, 'filters' => 'yes' ), $atts, 'dp_portfolio' );
	$q    = new WP_Query( array( 'post_type' => 'realisation', 'posts_per_page' => (int) $atts['count'], 'no_found_rows' => true ) );
	$devis = get_page_by_path( 'services' );
	$devis = $devis ? get_permalink( $devis ) . '#devis' : home_url( '/contact/' );
	$cards = '';
	$used  = array();
	$i     = 0;
	while ( $q->have_posts() ) {
		$q->the_post();
		$terms = get_the_terms( get_the_ID(), 'type_projet' );
		$slugs = array();
		$names = array();
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $t ) {
				$slugs[]           = $t->slug;
				$names[]           = $t->name;
				$used[ $t->slug ] = $t->name;
			}
		}
		$client = get_post_meta( get_the_ID(), '_dp_client', true );
		$year   = get_post_meta( get_the_ID(), '_dp_year', true );
		$img    = has_post_thumbnail() ? get_the_post_thumbnail( null, 'large', array( 'loading' => 'lazy' ) ) : '<img src="' . esc_url( DP_URI . '/assets/img/photos/px-equipe.webp' ) . '" alt="" loading="lazy">';
		$cards .= '<article class="dp-pf-card' . ( 0 === $i ? ' dp-pf-card--big' : '' ) . '" data-types="' . esc_attr( implode( ' ', $slugs ) ) . '">'
			. '<a class="dp-pf-card__img" href="' . esc_url( get_permalink() ) . '">' . $img . ( $names ? '<span class="dp-pf-card__type">' . esc_html( implode( ' · ', $names ) ) . '</span>' : '' ) . '</a>'
			. '<div class="dp-pf-card__body">'
			. ( $client ? '<span class="dp-pf-card__client">' . esc_html( $client . ( $year ? ' · ' . $year : '' ) ) . '</span>' : '' )
			. '<h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>'
			. '<p>' . esc_html( get_the_excerpt() ) . '</p>'
			. '<a class="dp-pf-card__more" href="' . esc_url( get_permalink() ) . '">Voir le projet</a>'
			. '</div></article>';
		$i++;
	}
	wp_reset_postdata();
	// Carte finale : votre projet (occupe la place restante de la dernière ligne).
	$cells  = $i + ( $i > 0 ? 1 : 0 );
	$span   = 3 - ( $cells % 3 );
	$cards .= '<article class="dp-pf-card dp-pf-card--cta dp-pf-span-' . $span . '" data-types=""' . esc_attr( implode( ' ', array_keys( $used ) ) ) . '" style="background:linear-gradient(150deg,#072642,#001730);border:0">'
		. '<div class="dp-pf-card__body" style="justify-content:center;min-height:320px">'
		. '<span class="dp-pf-card__client" style="color:#f0a070">Votre entreprise</span>'
		. '<h3 style="color:#fff">Votre projet pourrait être le prochain</h3>'
		. '<p style="color:#c3d2e4">Site web, application, identité de marque : parlons-en, le devis est gratuit.</p>'
		. '<div class="wp-block-button" style="margin-top:12px"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $devis ) . '">Demander un devis</a></div>'
		. '</div></article>';
	$filters = '';
	if ( 'yes' === $atts['filters'] && $used ) {
		$filters = '<div class="dp-pf-filters" role="group" aria-label="Filtrer les réalisations"><button type="button" class="is-active" data-filter="*">Tous les projets</button>';
		foreach ( $used as $slug => $name ) {
			$filters .= '<button type="button" data-filter="' . esc_attr( $slug ) . '">' . esc_html( $name ) . '</button>';
		}
		$filters .= '</div>';
	}
	if ( current_user_can( 'edit_posts' ) && ! $i ) {
		$filters = '<div class="dp-empty" style="margin-bottom:24px"><p>Visible par vous seul : publiez vos projets dans <a href="' . esc_url( admin_url( 'edit.php?post_type=realisation' ) ) . '">Réalisations</a> (des brouillons sont prêts à compléter).</p></div>' . $filters;
	}
	return '<div class="dp-pf">' . $filters . '<div class="dp-pf-grid">' . $cards . '</div></div>';
} );

/* L'ancienne archive /realisations/ renvoie vers la page Portfolio. */
add_action( 'template_redirect', function () {
	if ( is_post_type_archive( 'realisation' ) ) {
		$p = get_page_by_path( 'portfolio' );
		if ( $p && 'publish' === $p->post_status ) {
			wp_safe_redirect( get_permalink( $p ), 301 );
			exit;
		}
	}
} );
