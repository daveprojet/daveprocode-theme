<?php
/**
 * Optimisation Yoast SEO en un clic.
 *
 * Remplit les champs Yoast (requête cible, titre SEO, méta-description) des pages du site
 * et applique les petites modifications de texte décrites dans content/seo-yoast.json.
 * Une modification n'est faite que si l'ancien texte est retrouvé à l'identique : les passages
 * que vous avez retouchés vous-même sont laissés tels quels et signalés dans le rapport.
 * WordPress enregistre une révision de chaque page avant modification.
 *
 * @package DaveProcode
 */

defined( 'ABSPATH' ) || exit;

/** Données : pages, champs Yoast et modifications. */
function dp_seo_data() {
	$file = DP_DIR . '/content/seo-yoast.json';
	if ( ! file_exists( $file ) ) {
		return array();
	}
	$data = json_decode( (string) file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	return isset( $data['pages'] ) ? $data['pages'] : array();
}

/** Texte comparable : sans balises, entités décodées, espaces normalisés. */
function dp_seo_norm( $html ) {
	$text = html_entity_decode( wp_strip_all_tags( (string) $html ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$text = str_replace( array( "\xC2\xA0", "\xE2\x80\xAF" ), ' ', $text );
	return trim( preg_replace( '/\s+/u', ' ', $text ) );
}

/**
 * Applique une modification au contenu.
 *
 * @return string Statut : done | already | missing.
 */
function dp_seo_apply_edit( &$content, $e ) {
	$type = $e['type'];

	if ( 'h' === $type || 'p' === $type ) {
		$tag = ( 'h' === $type ) ? 'h[2-4]' : 'p';
		if ( ! preg_match_all( '#(<(?:' . $tag . ')\b[^>]*>)(.*?)(</(?:' . $tag . ')>)#s', $content, $m, PREG_OFFSET_CAPTURE ) ) {
			return 'missing';
		}
		$old = dp_seo_norm( $e['old'] );
		$new = dp_seo_norm( $e['new'] );
		foreach ( $m[2] as $inner ) {
			if ( dp_seo_norm( $inner[0] ) === $old ) {
				$content = substr_replace( $content, $e['new'], $inner[1], strlen( $inner[0] ) );
				return 'done';
			}
		}
		foreach ( $m[2] as $inner ) {
			if ( dp_seo_norm( $inner[0] ) === $new ) {
				return 'already';
			}
		}
		return 'missing';
	}

	if ( 'alt' === $type ) {
		$new_attr = 'alt="' . esc_attr( $e['new'] ) . '"';
		$variants = array_unique( array( 'alt="' . $e['old'] . '"', 'alt="' . esc_attr( $e['old'] ) . '"', 'alt="' . str_replace( "'", '&#8217;', $e['old'] ) . '"' ) );
		$nth      = isset( $e['nth'] ) ? (int) $e['nth'] : 1;
		foreach ( $variants as $old_attr ) {
			$pos = -1;
			for ( $i = 0; $i < $nth; $i++ ) {
				$pos = strpos( $content, $old_attr, $pos + 1 );
				if ( false === $pos ) {
					break;
				}
			}
			if ( false !== $pos && $pos >= 0 ) {
				$content = substr_replace( $content, $new_attr, $pos, strlen( $old_attr ) );
				return 'done';
			}
		}
		if ( false !== strpos( $content, $new_attr ) || false !== strpos( $content, 'alt="' . $e['new'] . '"' ) ) {
			return 'already';
		}
		return 'missing';
	}

	if ( 'caption' === $type ) {
		$pos = strpos( $content, 'alt="' . $e['img'] . '"' );
		if ( false === $pos ) {
			$pos = strpos( $content, 'alt="' . esc_attr( $e['img'] ) . '"' );
		}
		if ( false === $pos ) {
			return 'missing';
		}
		$end = strpos( $content, '</figure>', $pos );
		if ( false === $end ) {
			return 'missing';
		}
		if ( false !== strpos( substr( $content, $pos, $end - $pos ), '<figcaption' ) ) {
			return 'already';
		}
		$content = substr_replace( $content, '<figcaption class="wp-element-caption">' . $e['new'] . '</figcaption>', $end, 0 );
		return 'done';
	}

	if ( 'after' === $type ) {
		$probe = mb_substr( dp_seo_norm( $e['new'] ), 0, 60 );
		if ( false !== mb_strpos( dp_seo_norm( $content ), $probe ) ) {
			return 'already';
		}
		if ( ! preg_match_all( '#<p\b[^>]*>(.*?)</p>\s*<!-- /wp:paragraph -->#s', $content, $m, PREG_OFFSET_CAPTURE ) ) {
			return 'missing';
		}
		$old = dp_seo_norm( $e['old'] );
		foreach ( $m[0] as $k => $whole ) {
			if ( dp_seo_norm( $m[1][ $k ][0] ) === $old ) {
				$block   = "\n\n<!-- wp:paragraph -->\n<p>" . $e['new'] . "</p>\n<!-- /wp:paragraph -->";
				$content = substr_replace( $content, $block, $whole[1] + strlen( $whole[0] ), 0 );
				return 'done';
			}
		}
		return 'missing';
	}

	return 'missing';
}

/** Lance l'optimisation sur toutes les pages et renvoie le rapport. */
function dp_seo_run() {
	$report = array();
	foreach ( dp_seo_data() as $page ) {
		$post = null;
		foreach ( $page['paths'] as $path ) {
			$post = get_page_by_path( $path, OBJECT, $page['type'] );
			if ( $post ) {
				break;
			}
		}
		$line = array( 'name' => $page['name'], 'found' => (bool) $post, 'done' => 0, 'already' => 0, 'missing' => array(), 'link' => '' );
		if ( ! $post ) {
			$report[] = $line;
			continue;
		}
		$line['link'] = get_edit_post_link( $post->ID, 'raw' );

		// Champs Yoast (enregistrés avant la mise à jour de la page, pour que Yoast les reprenne).
		update_post_meta( $post->ID, '_yoast_wpseo_focuskw', wp_slash( $page['kw'] ) );
		update_post_meta( $post->ID, '_yoast_wpseo_title', wp_slash( $page['title'] ) );
		update_post_meta( $post->ID, '_yoast_wpseo_metadesc', wp_slash( $page['desc'] ) );

		// Modifications déjà traitées lors d'un passage précédent : jamais refaites (relance sans risque).
		$treated = (array) get_post_meta( $post->ID, '_dp_seo_treated', true );
		$content = $post->post_content;
		foreach ( $page['edits'] as $k => $edit ) {
			if ( in_array( $k, $treated, true ) ) {
				$line['already']++;
				continue;
			}
			$status = dp_seo_apply_edit( $content, $edit );
			if ( 'missing' === $status ) {
				$line['missing'][] = isset( $edit['old'] ) ? $edit['old'] : $edit['img'];
			} else {
				$line[ $status ]++;
				$treated[] = $k;
			}
		}
		update_post_meta( $post->ID, '_dp_seo_treated', array_values( array_unique( $treated ) ) );
		// Toujours mettre à jour la page : Yoast actualise ainsi ses données à partir des nouveaux champs.
		wp_update_post( array( 'ID' => $post->ID, 'post_content' => wp_slash( $content ) ) );
		$report[] = $line;
	}
	update_option( 'dp_seo_report', array( 'time' => current_time( 'mysql' ), 'pages' => $report ), false );
	return $report;
}

add_action( 'admin_post_dp_apply_yoast', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Action non autorisée.', 'daveprocode' ) );
	}
	check_admin_referer( 'dp_apply_yoast' );
	dp_seo_run();
	wp_safe_redirect( admin_url( 'themes.php?page=dp-setup&dp_msg=seo#dp-seo' ) );
	exit;
} );

/** Carte affichée sur la page Apparence > Installation Dave Procode. */
function dp_seo_card() {
	$data   = dp_seo_data();
	$report = get_option( 'dp_seo_report' );
	$edits  = 0;
	foreach ( $data as $p ) {
		$edits += count( $p['edits'] );
	}
	?>
	<div class="card" id="dp-seo" style="max-width:1152px;padding:20px 24px;margin-top:16px;border-left:4px solid #0d7ad3">
		<h2>Optimisation Yoast SEO</h2>
		<p>Remplit les champs Yoast (requête cible, titre SEO, méta-description) de <strong><?php echo (int) count( $data ); ?> pages</strong> et applique <strong><?php echo (int) $edits; ?> petites modifications de texte</strong> (titres, paragraphes, textes d'images), comme dans le document « Champs Yoast SEO ».</p>
		<ul style="list-style:disc;margin-left:20px">
			<li>Une modification n'est faite que si l'ancien texte est retrouvé à l'identique : vos retouches personnelles ne sont jamais écrasées, elles sont listées dans le rapport.</li>
			<li>WordPress garde une révision de chaque page : tout reste annulable depuis l'historique des révisions.</li>
			<li>Vous pouvez relancer sans risque : ce qui est déjà fait est ignoré.</li>
		</ul>
		<?php if ( ! defined( 'WPSEO_VERSION' ) ) : ?>
			<p style="color:#b32d2e"><strong>Yoast SEO n'est pas activé.</strong> Activez-le avant de lancer l'optimisation.</p>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('Appliquer les réglages Yoast et les modifications de texte aux pages du site ?');">
			<input type="hidden" name="action" value="dp_apply_yoast">
			<?php wp_nonce_field( 'dp_apply_yoast' ); ?>
			<?php submit_button( 'Appliquer les réglages Yoast', 'primary', 'submit', false ); ?>
		</form>
		<?php if ( is_array( $report ) && ! empty( $report['pages'] ) ) : ?>
			<h3 style="margin-top:22px">Dernier rapport (<?php echo esc_html( $report['time'] ); ?>)</h3>
			<table class="widefat striped">
				<thead><tr><th>Page</th><th>Faites</th><th>Déjà faites</th><th>À faire à la main</th></tr></thead>
				<tbody>
				<?php foreach ( $report['pages'] as $line ) : ?>
					<tr>
						<td><?php echo $line['link'] ? '<a href="' . esc_url( $line['link'] ) . '">' . esc_html( $line['name'] ) . '</a>' : esc_html( $line['name'] ); ?></td>
						<?php if ( ! $line['found'] ) : ?>
							<td colspan="3"><em>Page introuvable (adresse modifiée ou page supprimée).</em></td>
						<?php else : ?>
							<td><?php echo (int) $line['done']; ?></td>
							<td><?php echo (int) $line['already']; ?></td>
							<td><?php echo $line['missing'] ? esc_html( implode( ' · ', array_map( function ( $t ) { return '« ' . wp_trim_words( $t, 8, '…' ) . ' »'; }, $line['missing'] ) ) ) : '—'; ?></td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p>Pour les textes « à faire à la main », reportez-vous à la fiche de la page dans le document Word. Ouvrez ensuite chaque page une fois et cliquez sur « Mettre à jour » pour que les pastilles Yoast de la liste des pages se rafraîchissent.</p>
		<?php endif; ?>
	</div>
	<?php
}
