<?php
/**
 * Kadence\GiveWP\Component class
 *
 * @package kadence
 */

namespace Kadence\Give;

use Kadence\Component_Interface;
use Kadence\Kadence_CSS;
use function Kadence\kadence;
use function add_action;
use function have_posts;
use function the_post;
use function is_search;
use function get_template_part;
use function get_post_type;

/**
 * Class for adding Woocommerce plugin support.
 */
class Component implements Component_Interface {
	/**
	 * Associative array of Google Fonts to load.
	 *
	 * Do not access this property directly, instead use the `get_google_fonts()` method.
	 *
	 * @var array
	 */
	protected static $google_fonts = array();
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'give';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'wp_print_styles', array( $this, 'override_iframe_template_styles' ), 10 );
		add_action( 'wp_print_styles', array( $this, 'add_iframe_fonts' ), 20 );
	}
	/**
	 * Registers or enqueues google fonts.
	 */
	public function add_iframe_fonts() {
		// Enqueue Google Fonts.
		$google_fonts = apply_filters( 'kadence_theme_givewp_google_fonts_array', self::$google_fonts );
		if ( empty( $google_fonts ) ) {
			return '';
		}
		$link    = '';
		$sub_add = array();
		$subsets = kadence()->option( 'google_subsets' );
		foreach ( $google_fonts as $key => $gfont_values ) {
			if ( ! empty( $link ) ) {
				$link .= '%7C'; // Append a new font to the string.
			}
			$link .= $gfont_values['fontfamily'];
			if ( ! empty( $gfont_values['fontvariants'] ) ) {
				$link .= ':';
				$link .= implode( ',', $gfont_values['fontvariants'] );
			}
			if ( ! empty( $gfont_values['fontsubsets'] ) && is_array( $gfont_values['fontsubsets'] ) ) {
				foreach ( $gfont_values['fontsubsets'] as $subkey ) {
					if ( ! empty( $subkey ) && ! isset( $sub_add[ $subkey ] ) ) {
						$sub_add[] = $subkey;
					}
				}
			}
		}
		$args = array(
			'family' => $link,
		);
		if ( ! empty( $subsets ) ) {
			$available = array( 'latin-ext', 'cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'vietnamese', 'arabic', 'khmer', 'chinese', 'chinese-simplified', 'tamil', 'bengali', 'devanagari', 'hebrew', 'korean', 'thai', 'telugu' );
			foreach ( $subsets as $key => $enabled ) {
				if ( $enabled && in_array( $key, $available, true ) ) {
					if ( 'chinese' === $key ) {
						$key = 'chinese-traditional';
					}
					if ( ! isset( $sub_add[ $key ] ) ) {
						$sub_add[] = $key;
					}
				}
			}
			if ( $sub_add ) {
				$args['subset'] = implode( ',', $sub_add );
			}
		}
		if ( apply_filters( 'kadence_givewp_display_swap_google_fonts', true ) ) {
			$args['display'] = 'swap';
		}
		$font_url = add_query_arg( apply_filters( 'kadence_theme_givewp_google_fonts_query_args', $args ), 'https://fonts.googleapis.com/css' );
		if ( ! empty( $font_url ) ) {
			wp_enqueue_style( 'kadence-givewp-iframe-fonts', $font_url, 'give-sequoia-template-css' ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		}
	}
	/**
	 * Add basic theme styling to iframe.
	 */
	public function override_iframe_template_styles() {
		$css                    = new Kadence_CSS();
		$media_query            = array();
		$media_query['mobile']  = apply_filters( 'kadence_mobile_media_query', '(max-width: 767px)' );
		$media_query['tablet']  = apply_filters( 'kadence_tablet_media_query', '(max-width: 1024px)' );
		$media_query['desktop'] = apply_filters( 'kadence_tablet_media_query', '(min-width: 1025px)' );
		// Globals.
		$css->set_selector( ':root' );
		$css->add_property( '--global-palette1', kadence()->palette_option( 'palette1' ) );
		$css->add_property( '--global-palette2', kadence()->palette_option( 'palette2' ) );
		$css->add_property( '--global-palette3', kadence()->palette_option( 'palette3' ) );
		$css->add_property( '--global-palette4', kadence()->palette_option( 'palette4' ) );
		$css->add_property( '--global-palette5', kadence()->palette_option( 'palette5' ) );
		$css->add_property( '--global-palette6', kadence()->palette_option( 'palette6' ) );
		$css->add_property( '--global-palette7', kadence()->palette_option( 'palette7' ) );
		$css->add_property( '--global-palette8', kadence()->palette_option( 'palette8' ) );
		$css->add_property( '--global-palette9', kadence()->palette_option( 'palette9' ) );
		$css->add_property( '--global-palette-highlight', $css->render_color( kadence()->sub_option( 'link_color', 'highlight' ) ) );
		$css->add_property( '--global-palette-highlight-alt', $css->render_color( kadence()->sub_option( 'link_color', 'highlight-alt' ) ) );
		$css->add_property( '--global-palette-highlight-alt2', $css->render_color( kadence()->sub_option( 'link_color', 'highlight-alt2' ) ) );
		$css->add_property( '--global-palette-btn-bg', $css->render_color( kadence()->sub_option( 'buttons_background', 'color' ) ) );
		$css->add_property( '--global-palette-btn-bg-hover', $css->render_color( kadence()->sub_option( 'buttons_background', 'hover' ) ) );
		$css->add_property( '--global-palette-btn', $css->render_color( kadence()->sub_option( 'buttons_color', 'color' ) ) );
		$css->add_property( '--global-palette-btn-hover', $css->render_color( kadence()->sub_option( 'buttons_color', 'hover' ) ) );
		$css->add_property( '--global-body-font-family', $css->render_font_family( kadence()->option( 'base_font' ), '' ) );
		$css->add_property( '--global-heading-font-family', $css->render_font_family( kadence()->option( 'heading_font' ) ) );
		$css->add_property( '--global-fallback-font', apply_filters( 'kadence_theme_global_typography_fallback', 'sans-serif' ) );

		$css->set_selector( 'body' );
		$css->add_property( 'margin', '10px' );
		$css->add_property( 'font-family', 'var( --global-body-font-family )' );
		$css->add_property( 'color', 'var(--global-palette4 )' );

		$css->set_selector( '.give-embed-form, .give-embed-receipt' );
		$css->add_property( 'color', 'var(--global-palette5 )' );
		$css->add_property( 'background-color', 'var(--global-palette9 )' );
		$css->add_property( 'box-shadow', '0px 15px 25px -10px rgb(0 0 0 / 5%)' );
		$css->add_property( 'border-radius', '.25rem' );
		$css->add_property( 'border', '1px solid var( --global-palette7 )' );

		$css->set_selector( 'body.give-form-templates .give-form-navigator' );
		$css->add_property( 'border', '1px solid transparent' );
		$css->add_property( 'background', 'var(--global-palette8 )' );

		$css->set_selector( 'body.give-form-templates .give-form-navigator.nav-visible' );
		$css->add_property( 'border', '1px solid var( --global-palette7 )' );

		$css->set_selector(
			'body.give-form-templates,
			body.give-form-templates .give-btn,
			body.give-form-templates .choose-amount .give-donation-amount .give-amount-top,
			body.give-form-templates #give-recurring-form .form-row input[type=email],
			body.give-form-templates #give-recurring-form .form-row input[type=password],
			body.give-form-templates #give-recurring-form .form-row input[type=tel],
			body.give-form-templates #give-recurring-form .form-row input[type=text],
			body.give-form-templates #give-recurring-form .form-row input[type=url],
			body.give-form-templates #give-recurring-form .form-row textarea, .give-input-field-wrapper,
			body.give-form-templates .give-square-cc-fields,
			body.give-form-templates .give-stripe-cc-field,
			body.give-form-templates .give-stripe-single-cc-field-wrap,
			body.give-form-templates form.give-form .form-row input[type=email],
			body.give-form-templates form.give-form .form-row input[type=password],
			body.give-form-templates form.give-form .form-row input[type=tel],
			body.give-form-templates form.give-form .form-row input[type=text],
			body.give-form-templates form.give-form .form-row input[type=url],
			body.give-form-templates form.give-form .form-row textarea,
			body.give-form-templates form[id*=give-form] .form-row input[type=email],
			body.give-form-templates form[id*=give-form] .form-row input[type=email].required,
			body.give-form-templates form[id*=give-form] .form-row input[type=password],
			body.give-form-templates form[id*=give-form] .form-row input[type=password].required,
			body.give-form-templates form[id*=give-form] .form-row input[type=tel],
			body.give-form-templates form[id*=give-form] .form-row input[type=tel].required,
			body.give-form-templates form[id*=give-form] .form-row input[type=text],
			body.give-form-templates form[id*=give-form] .form-row input[type=text].required,
			body.give-form-templates form[id*=give-form] .form-row input[type=url],
			body.give-form-templates form[id*=give-form] .form-row input[type=url].required,
			body.give-form-templates form[id*=give-form] .form-row textarea,
			body.give-form-templates form[id*=give-form] .form-row textarea.required'
		);
		$css->add_property( 'font-family', 'var( --global-body-font-family )' );

		$css->set_selector( '.advance-btn, .download-btn, .give-submit' );
		$css->add_property( 'text-transform', 'uppercase' );
		$css->add_property( 'font-weight', '600' );
		$css->add_property( 'font-size', '16px' );
		$css->add_property( 'padding', '14px 30px !important' );
		self::$google_fonts = $css->fonts_output();
		wp_add_inline_style( 'give-sequoia-template-css', $css->css_output() );
	}
}
