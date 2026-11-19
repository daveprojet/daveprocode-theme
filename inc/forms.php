<?php
/**
 * Formulaires natifs : [dp_form type="devis|ventures|carriere|attente|contact|newsletter"].
 * Chaque envoi est enregistré dans « Messages reçus » ET envoyé par e-mail.
 * Anti-spam : champ piège, délai minimum, limite d'envois par adresse IP.
 *
 * @package daveprocode
 */

defined( 'ABSPATH' ) || exit;

function dp_forms() {
	$budget = array( 'Moins de 300 000 FCFA', '300 000 – 1 000 000 FCFA', '1 000 000 – 3 000 000 FCFA', 'Plus de 3 000 000 FCFA', 'Je ne sais pas encore' );
	return array(
		'devis'      => array(
			'label'  => 'Demande de devis',
			'submit' => 'Envoyer ma demande',
			'ok'     => 'Merci ! Votre demande est bien reçue. Nous revenons vers vous sous 48 h ouvrées.',
			'fields' => array(
				array( 'name' => 'nom', 'label' => 'Nom complet', 'type' => 'text', 'req' => true, 'half' => true ),
				array( 'name' => 'entreprise', 'label' => 'Entreprise', 'type' => 'text', 'half' => true ),
				array( 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'req' => true, 'half' => true ),
				array( 'name' => 'telephone', 'label' => 'Téléphone / WhatsApp', 'type' => 'tel', 'req' => true, 'half' => true ),
				array( 'name' => 'projet', 'label' => 'Type de projet', 'type' => 'select', 'req' => true, 'half' => true, 'options' => array( 'Site vitrine', 'Site e-commerce', 'Application web ou mobile', 'Plateforme métier', 'UI/UX design', 'Logo et charte graphique', 'Référencement SEO', 'Formation', 'Autre' ) ),
				array( 'name' => 'budget', 'label' => 'Budget indicatif', 'type' => 'select', 'half' => true, 'options' => $budget ),
				array( 'name' => 'message', 'label' => 'Décrivez votre projet', 'type' => 'textarea', 'req' => true ),
			),
		),
		'ventures'   => array(
			'label'  => 'Proposition de projet (Ventures)',
			'submit' => 'Proposer mon projet',
			'ok'     => 'Merci ! Nous étudions votre projet et vous répondons sous 7 jours.',
			'fields' => array(
				array( 'name' => 'nom', 'label' => 'Nom complet', 'type' => 'text', 'req' => true, 'half' => true ),
				array( 'name' => 'organisation', 'label' => 'Organisation', 'type' => 'text', 'half' => true ),
				array( 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'req' => true, 'half' => true ),
				array( 'name' => 'telephone', 'label' => 'Téléphone / WhatsApp', 'type' => 'tel', 'req' => true, 'half' => true ),
				array( 'name' => 'secteur', 'label' => 'Secteur', 'type' => 'text', 'req' => true, 'half' => true ),
				array( 'name' => 'stade', 'label' => 'Stade du projet', 'type' => 'select', 'req' => true, 'half' => true, 'options' => array( 'Idée', 'Prototype', 'Premiers clients', 'Entreprise établie' ) ),
				array( 'name' => 'formule', 'label' => 'Formule souhaitée', 'type' => 'select', 'req' => true, 'options' => array( 'Co-création (associé technique)', 'Partenariat à la commission', 'Investissement dans un produit Dave Procode', 'Je ne sais pas encore' ) ),
				array( 'name' => 'message', 'label' => 'Quel problème votre projet résout-il ?', 'type' => 'textarea', 'req' => true ),
			),
		),
		'carriere'   => array(
			'label'  => 'Candidature',
			'submit' => 'Envoyer ma candidature',
			'ok'     => 'Merci pour votre candidature ! Nous la lisons attentivement et revenons vers vous si votre profil correspond.',
			'fields' => array(
				array( 'name' => 'nom', 'label' => 'Nom complet', 'type' => 'text', 'req' => true, 'half' => true ),
				array( 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'req' => true, 'half' => true ),
				array( 'name' => 'telephone', 'label' => 'Téléphone', 'type' => 'tel', 'req' => true, 'half' => true ),
				array( 'name' => 'poste', 'label' => 'Poste visé', 'type' => 'select', 'req' => true, 'half' => true, 'options' => array( 'Développement', 'Design UI/UX', 'Commercial', 'Communication', 'Stage', 'Candidature spontanée' ) ),
				array( 'name' => 'lien', 'label' => 'Lien vers votre CV ou portfolio (Drive, LinkedIn, GitHub…)', 'type' => 'url', 'req' => true ),
				array( 'name' => 'message', 'label' => 'Quelques mots sur vous', 'type' => 'textarea' ),
			),
		),
		'attente'    => array(
			'label'  => 'Liste d\'attente – gestion de prêts et tontines',
			'submit' => 'Rejoindre la liste d\'attente',
			'ok'     => 'C\'est noté ! Vous serez parmi les premiers informés du lancement.',
			'fields' => array(
				array( 'name' => 'nom', 'label' => 'Nom complet', 'type' => 'text', 'req' => true, 'half' => true ),
				array( 'name' => 'telephone', 'label' => 'Téléphone / WhatsApp', 'type' => 'tel', 'req' => true, 'half' => true ),
				array( 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'half' => true ),
				array( 'name' => 'activite', 'label' => 'Votre activité', 'type' => 'select', 'req' => true, 'half' => true, 'options' => array( 'Prêt d\'argent', 'Vente à crédit (commerce)', 'Tontine', 'Plusieurs de ces activités' ) ),
				array( 'name' => 'clients', 'label' => 'Nombre de clients ou de membres', 'type' => 'select', 'options' => array( 'Moins de 20', '20 à 100', '100 à 500', 'Plus de 500' ) ),
			),
		),
		'formation'  => array(
			'label'  => 'Inscription à une formation',
			'submit' => 'Envoyer mon inscription',
			'ok'     => 'Merci ! Votre demande d\'inscription est bien reçue. Nous vous contactons sous 48 h pour l\'entretien de positionnement et les prochaines dates.',
			'fields' => array(
				array( 'type' => 'section', 'label' => '1. Vos coordonnées' ),
				array( 'name' => 'nom', 'label' => 'Nom complet', 'type' => 'text', 'req' => true, 'half' => true ),
				array( 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'req' => true, 'half' => true ),
				array( 'name' => 'telephone', 'label' => 'Téléphone / WhatsApp', 'type' => 'tel', 'req' => true, 'half' => true ),
				array( 'name' => 'ville', 'label' => 'Ville', 'type' => 'text', 'half' => true ),
				array( 'type' => 'section', 'label' => '2. Votre formation' ),
				array( 'name' => 'formation', 'label' => 'Formation choisie', 'type' => 'select', 'req' => true, 'options' => array( 'Développement web et no-code', 'Infographie et design graphique', 'UI/UX design', 'Bureautique (Word, Excel, PowerPoint)', 'Formation sur mesure pour mon entreprise' ) ),
				array( 'name' => 'format', 'label' => 'Format souhaité', 'type' => 'select', 'req' => true, 'half' => true, 'options' => array( 'Présentiel à Dakar', 'En ligne (classes virtuelles)', 'En entreprise (intra)' ) ),
				array( 'name' => 'niveau', 'label' => 'Votre niveau actuel', 'type' => 'select', 'half' => true, 'options' => array( 'Débutant', 'Intermédiaire', 'Avancé' ) ),
				array( 'name' => 'disponibilite', 'label' => 'Disponibilités', 'type' => 'select', 'half' => true, 'options' => array( 'En semaine, le matin', 'En semaine, l\'après-midi', 'En semaine, le soir', 'Le week-end' ) ),
				array( 'name' => 'statut', 'label' => 'Vous êtes', 'type' => 'select', 'half' => true, 'options' => array( 'Étudiant(e)', 'Salarié(e)', 'Entrepreneur(e)', 'En recherche d\'emploi', 'Entreprise / organisation' ) ),
				array( 'type' => 'section', 'label' => '3. Vos objectifs' ),
				array( 'name' => 'message', 'label' => 'Qu\'attendez-vous de cette formation ?', 'type' => 'textarea' ),
				array( 'name' => 'source', 'label' => 'Comment nous avez-vous connus ?', 'type' => 'select', 'options' => array( 'Réseaux sociaux', 'Bouche-à-oreille', 'Recherche Google', 'WhatsApp', 'Autre' ) ),
			),
		),
		'contact'    => array(
			'label'  => 'Contact',
			'submit' => 'Envoyer le message',
			'ok'     => 'Merci ! Votre message est bien reçu. Réponse sous 48 h ouvrées.',
			'fields' => array(
				array( 'name' => 'nom', 'label' => 'Nom complet', 'type' => 'text', 'req' => true, 'half' => true ),
				array( 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'req' => true, 'half' => true ),
				array( 'name' => 'telephone', 'label' => 'Téléphone / WhatsApp', 'type' => 'tel', 'half' => true ),
				array( 'name' => 'sujet', 'label' => 'Votre demande concerne', 'type' => 'select', 'req' => true, 'half' => true, 'options' => array( 'Un site ou une application', 'Un produit (Bricolibe, CademyLab…)', 'Un partenariat ou un investissement', 'Rejoindre l\'équipe', 'Autre' ) ),
				array( 'name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'req' => true ),
			),
		),
		'newsletter' => array(
			'label'  => 'Inscription newsletter',
			'submit' => 'Je m\'inscris',
			'ok'     => 'Inscription confirmée. À bientôt dans votre boîte mail !',
			'inline' => true,
			'fields' => array(
				array( 'name' => 'email', 'label' => 'Votre e-mail', 'type' => 'email', 'req' => true ),
			),
		),
	);
}

/**
 * Jeton anti-robot : horodatage signé.
 */
function dp_form_token() {
	$t = time();
	return $t . '.' . substr( wp_hash( 'dp_form_' . $t ), 0, 12 );
}

function dp_form_token_ok( $token ) {
	$parts = explode( '.', (string) $token );
	if ( 2 !== count( $parts ) ) {
		return false;
	}
	list( $t, $h ) = $parts;
	if ( ! hash_equals( substr( wp_hash( 'dp_form_' . $t ), 0, 12 ), $h ) ) {
		return false;
	}
	return ( time() - (int) $t ) >= 3; // Un humain met plus de 3 secondes.
}

/**
 * Affichage.
 */
function dp_render_form( $type ) {
	$forms = dp_forms();
	if ( ! isset( $forms[ $type ] ) ) {
		return '';
	}
	$form   = $forms[ $type ];
	$inline = ! empty( $form['inline'] );
	$id     = 'dp-form-' . $type;
	$out    = '<div class="dp-form-wrap" id="' . esc_attr( $id ) . '">';

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$status = isset( $_GET['dp_sent'] ) ? sanitize_key( wp_unslash( $_GET['dp_sent'] ) ) : '';
	if ( $status === $type ) {
		return $out . '<div class="dp-notice dp-notice--ok" role="status">' . esc_html( $form['ok'] ) . '</div></div>';
	}
	if ( $status === $type . '-err' ) {
		$out .= '<div class="dp-notice dp-notice--err" role="alert">L\'envoi n\'a pas abouti. Vérifiez les champs obligatoires ou écrivez-nous à ' . esc_html( dp_setting( 'email' ) ) . '.</div>';
	}

	$out .= '<form class="dp-form' . ( $inline ? ' dp-form--inline' : '' ) . '" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	$out .= '<input type="hidden" name="action" value="dp_form">';
	$out .= '<input type="hidden" name="dp_type" value="' . esc_attr( $type ) . '">';
	$out .= '<input type="hidden" name="dp_token" value="' . esc_attr( dp_form_token() ) . '">';
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
	$host = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : wp_parse_url( home_url(), PHP_URL_HOST );
	$back = remove_query_arg( 'dp_sent', ( is_ssl() ? 'https://' : 'http://' ) . $host . $uri );
	$out .= '<input type="hidden" name="dp_back" value="' . esc_url( $back ) . '">';
	$out .= '<div class="dp-form__hp" aria-hidden="true"><label>Ne pas remplir<input type="text" name="dp_site" tabindex="-1" autocomplete="off"></label></div>';

	$open_row = false;
	// Préselection depuis l'adresse (?formation=developpement-web…).
	$preset = isset( $_GET['formation'] ) ? sanitize_title( wp_unslash( $_GET['formation'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	foreach ( $form['fields'] as $f ) {
		if ( 'section' === $f['type'] ) {
			if ( $open_row ) {
				$out     .= '</div>';
				$open_row = false;
			}
			$out .= '<div class="dp-form__section">' . esc_html( $f['label'] ) . '</div>';
			continue;
		}
		$fid  = $id . '-' . $f['name'];
		$req  = ! empty( $f['req'] );
		$half = ! empty( $f['half'] ) && ! $inline;
		if ( $half && ! $open_row ) {
			$out     .= '<div class="dp-form__row">';
			$open_row = true;
		} elseif ( ! $half && $open_row ) {
			$out     .= '</div>';
			$open_row = false;
		}
		$label = esc_html( $f['label'] ) . ( $req ? ' <span aria-hidden="true">*</span>' : '' );
		$attr  = 'id="' . esc_attr( $fid ) . '" name="dp[' . esc_attr( $f['name'] ) . ']"' . ( $req ? ' required' : '' );
		$out  .= '<div class="dp-form__field">';
		if ( $inline ) {
			$out .= '<label class="screen-reader-text" for="' . esc_attr( $fid ) . '">' . $label . '</label>';
		} else {
			$out .= '<label for="' . esc_attr( $fid ) . '">' . $label . '</label>';
		}
		switch ( $f['type'] ) {
			case 'textarea':
				$out .= '<textarea ' . $attr . ' rows="5"></textarea>';
				break;
			case 'select':
				$out .= '<select ' . $attr . '><option value="">Choisir…</option>';
				foreach ( $f['options'] as $o ) {
					$sel  = ( $preset && 0 === strpos( sanitize_title( $o ), $preset ) ) ? ' selected' : '';
					$out .= '<option' . $sel . '>' . esc_html( $o ) . '</option>';
				}
				$out .= '</select>';
				break;
			default:
				$auto = array( 'email' => 'email', 'tel' => 'tel', 'url' => 'url' );
				$ph   = $inline ? ' placeholder="' . esc_attr( $f['label'] ) . '"' : '';
				$ac   = 'nom' === $f['name'] ? ' autocomplete="name"' : ( isset( $auto[ $f['type'] ] ) ? ' autocomplete="' . $auto[ $f['type'] ] . '"' : '' );
				$out .= '<input type="' . esc_attr( $f['type'] ) . '" ' . $attr . $ph . $ac . '>';
		}
		$out .= '</div>';
	}
	if ( $open_row ) {
		$out .= '</div>';
	}
	if ( $inline ) {
		$out .= '<button type="submit">' . esc_html( $form['submit'] ) . '</button>';
	}

	$privacy = get_privacy_policy_url();
	$consent = 'J\'accepte que Dave Procode utilise ces informations pour répondre à ma demande'
		. ( $privacy ? ' (<a href="' . esc_url( $privacy ) . '" target="_blank" rel="noopener">politique de confidentialité</a>)' : '' ) . '.';
	$out .= '<div class="dp-form__consent"><input type="checkbox" id="' . esc_attr( $id ) . '-ok" name="dp_consent" value="1" required><label for="' . esc_attr( $id ) . '-ok">' . $consent . '</label></div>';
	if ( ! $inline ) {
		$out .= '<button type="submit">' . esc_html( $form['submit'] ) . '</button>';
	}
	$out .= '</form></div>';
	return $out;
}

/**
 * Traitement.
 */
function dp_handle_form() {
	// phpcs:disable WordPress.Security.NonceVerification.Missing -- formulaires publics, protégés par jeton signé + piège + limite IP.
	$type  = isset( $_POST['dp_type'] ) ? sanitize_key( wp_unslash( $_POST['dp_type'] ) ) : '';
	$back  = isset( $_POST['dp_back'] ) ? esc_url_raw( wp_unslash( $_POST['dp_back'] ) ) : home_url( '/' );
	$back  = wp_validate_redirect( $back, home_url( '/' ) );
	$forms = dp_forms();

	if ( ! isset( $forms[ $type ] ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
	$fail = function () use ( $back, $type ) {
		wp_safe_redirect( add_query_arg( 'dp_sent', $type . '-err', $back ) . '#dp-form-' . $type );
		exit;
	};
	$done = function () use ( $back, $type ) {
		wp_safe_redirect( add_query_arg( 'dp_sent', $type, $back ) . '#dp-form-' . $type );
		exit;
	};

	// Robots : on fait semblant que tout va bien.
	if ( ! empty( $_POST['dp_site'] ) || ! dp_form_token_ok( isset( $_POST['dp_token'] ) ? sanitize_text_field( wp_unslash( $_POST['dp_token'] ) ) : '' ) ) {
		$done();
	}
	if ( empty( $_POST['dp_consent'] ) ) {
		$fail();
	}

	// 5 envois maximum par heure et par IP.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0';
	$key = 'dp_rl_' . md5( $ip );
	$n   = (int) get_transient( $key );
	if ( $n >= 5 ) {
		$fail();
	}
	set_transient( $key, $n + 1, HOUR_IN_SECONDS );

	$raw    = isset( $_POST['dp'] ) && is_array( $_POST['dp'] ) ? wp_unslash( $_POST['dp'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$values = array();
	foreach ( $forms[ $type ]['fields'] as $f ) {
		if ( 'section' === $f['type'] ) {
			continue;
		}
		$v = isset( $raw[ $f['name'] ] ) ? $raw[ $f['name'] ] : '';
		switch ( $f['type'] ) {
			case 'email':
				$v = sanitize_email( $v );
				if ( $v && ! is_email( $v ) ) {
					$fail();
				}
				break;
			case 'url':
				$v = esc_url_raw( $v );
				break;
			case 'textarea':
				$v = sanitize_textarea_field( $v );
				break;
			case 'select':
				$v = sanitize_text_field( $v );
				if ( $v && ! in_array( $v, $f['options'], true ) ) {
					$v = '';
				}
				break;
			default:
				$v = sanitize_text_field( $v );
		}
		if ( ! empty( $f['req'] ) && '' === $v ) {
			$fail();
		}
		$values[ $f['name'] ] = array( 'label' => $f['label'], 'value' => mb_substr( $v, 0, 5000 ) );
	}
	// phpcs:enable

	$label = $forms[ $type ]['label'];
	$name  = isset( $values['nom'] ) ? $values['nom']['value'] : ( isset( $values['email'] ) ? $values['email']['value'] : 'Anonyme' );
	$email = isset( $values['email'] ) ? $values['email']['value'] : '';
	$phone = isset( $values['telephone'] ) ? $values['telephone']['value'] : '';

	$body = '';
	foreach ( $values as $v ) {
		if ( '' !== $v['value'] ) {
			$body .= $v['label'] . " :\n" . $v['value'] . "\n\n";
		}
	}
	$body .= 'Page : ' . $back . "\n";

	// 1. Enregistrement (rien n'est perdu même si l'e-mail échoue).
	$post_id = wp_insert_post( array(
		'post_type'    => 'dp_message',
		'post_status'  => 'private',
		'post_title'   => $name . ' — ' . $label,
		'post_content' => $body,
	) );
	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_dp_form', $type );
		update_post_meta( $post_id, '_dp_form_label', $label );
		update_post_meta( $post_id, '_dp_email', $email );
		update_post_meta( $post_id, '_dp_phone', $phone );
	}

	// 2. Notification (destinataire propre à chaque formulaire, sinon adresse générale).
	$to = dp_form_recipients( $type );
	$headers = array();
	if ( $email ) {
		$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	}
	wp_mail( $to, '[Site] ' . $label . ' — ' . $name, $body, $headers );

	// 3. Accusé de réception.
	if ( $email && 'newsletter' !== $type ) {
		$msg = "Bonjour,\n\nNous avons bien reçu votre message (" . $label . ").\n" . $forms[ $type ]['ok'] . "\n\nL'équipe Dave Procode\n" . dp_setting( 'phone' ) . ' · ' . home_url( '/' );
		wp_mail( $email, 'Nous avons bien reçu votre message — Dave Procode', $msg, array( 'Reply-To: Dave Procode <' . dp_setting( 'email' ) . '>' ) );
	}

	$done();
}
add_action( 'admin_post_nopriv_dp_form', 'dp_handle_form' );
add_action( 'admin_post_dp_form', 'dp_handle_form' );

/**
 * Destinataires d'un formulaire : réglage du formulaire, sinon adresse générale, sinon e-mail admin.
 * Plusieurs adresses possibles, séparées par des virgules.
 */
function dp_form_recipients( $type ) {
	$list = dp_setting( 'to_' . $type );
	if ( ! $list ) {
		$list = dp_setting( 'notify' );
	}
	$emails = array_filter( array_map( 'sanitize_email', array_map( 'trim', explode( ',', (string) $list ) ) ), 'is_email' );
	return $emails ? $emails : array( get_option( 'admin_email' ) );
}

/* Expéditeur des e-mails (adresse pro). */
add_filter( 'wp_mail_from', function ( $from ) {
	$custom = dp_setting( 'from_email' );
	return ( $custom && is_email( $custom ) ) ? $custom : $from;
} );
add_filter( 'wp_mail_from_name', function ( $name ) {
	$custom = dp_setting( 'from_name' );
	return $custom ? $custom : $name;
} );

/* Envoi SMTP avec votre messagerie pro (Apparence > Installation Dave Procode). */
add_action( 'phpmailer_init', function ( $mailer ) {
	if ( ! dp_setting( 'smtp_on' ) || ! dp_setting( 'smtp_host' ) ) {
		return;
	}
	$mailer->isSMTP();
	$mailer->Host       = dp_setting( 'smtp_host' );
	$mailer->Port       = (int) dp_setting( 'smtp_port' );
	$mailer->SMTPAuth   = (bool) dp_setting( 'smtp_user' );
	$mailer->Username   = dp_setting( 'smtp_user' );
	$mailer->Password   = dp_setting( 'smtp_pass' );
	$secure             = dp_setting( 'smtp_secure' );
	$mailer->SMTPSecure = in_array( $secure, array( 'ssl', 'tls' ), true ) ? $secure : '';
	$from = dp_setting( 'from_email' ) ? dp_setting( 'from_email' ) : dp_setting( 'smtp_user' );
	if ( $from && is_email( $from ) ) {
		$mailer->setFrom( $from, dp_setting( 'from_name' ) ? dp_setting( 'from_name' ) : get_bloginfo( 'name' ), false );
	}
} );

add_shortcode( 'dp_form', function ( $atts ) {
	$atts = shortcode_atts( array( 'type' => 'contact' ), $atts, 'dp_form' );
	return dp_render_form( sanitize_key( $atts['type'] ) );
} );
