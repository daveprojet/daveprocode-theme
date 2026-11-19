<?php
/**
 * Types de contenu : Réalisations (public) et Messages reçus (privé).
 *
 * @package daveprocode
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {

	register_post_type( 'realisation', array(
		'labels'       => array(
			'name'               => 'Réalisations',
			'singular_name'      => 'Réalisation',
			'add_new'            => 'Ajouter',
			'add_new_item'       => 'Ajouter une réalisation',
			'edit_item'          => 'Modifier la réalisation',
			'new_item'           => 'Nouvelle réalisation',
			'view_item'          => 'Voir la réalisation',
			'search_items'       => 'Rechercher',
			'not_found'          => 'Aucune réalisation',
			'all_items'          => 'Toutes les réalisations',
			'menu_name'          => 'Réalisations',
		),
		'public'       => true,
		'has_archive'  => 'realisations',
		'rewrite'      => array( 'slug' => 'realisations', 'with_front' => false ),
		'menu_icon'    => 'dashicons-portfolio',
		'menu_position'=> 21,
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'template'     => array(
			array( 'core/pattern', array( 'slug' => 'daveprocode/fiche-realisation' ) ),
		),
	) );

	register_taxonomy( 'type_projet', 'realisation', array(
		'labels'            => array(
			'name'          => 'Types de projet',
			'singular_name' => 'Type de projet',
			'menu_name'     => 'Types de projet',
			'add_new_item'  => 'Ajouter un type',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'realisations/type', 'with_front' => false ),
	) );

	register_post_type( 'dp_message', array(
		'labels'          => array(
			'name'          => 'Messages reçus',
			'singular_name' => 'Message',
			'menu_name'     => 'Messages reçus',
			'all_items'     => 'Tous les messages',
			'edit_item'     => 'Message',
			'not_found'     => 'Aucun message pour le moment',
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-email-alt',
		'menu_position'   => 22,
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

/* Colonnes de la liste des messages. */
add_filter( 'manage_dp_message_posts_columns', function ( $cols ) {
	return array(
		'cb'      => $cols['cb'],
		'title'   => 'Expéditeur',
		'dp_type' => 'Formulaire',
		'dp_mail' => 'Contact',
		'date'    => 'Date',
	);
} );
add_action( 'manage_dp_message_posts_custom_column', function ( $col, $post_id ) {
	if ( 'dp_type' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_dp_form_label', true ) );
	}
	if ( 'dp_mail' === $col ) {
		$mail  = get_post_meta( $post_id, '_dp_email', true );
		$phone = get_post_meta( $post_id, '_dp_phone', true );
		if ( $mail ) {
			echo '<a href="mailto:' . esc_attr( $mail ) . '">' . esc_html( $mail ) . '</a><br>';
		}
		echo esc_html( $phone );
	}
}, 10, 2 );
