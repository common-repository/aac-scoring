<?php
/*
Plugin Name: 	AAC Scoring
Plugin URI: 	https://www.wordpress.org/plugins/aac-scoring/
Description: 	Improve Pagespeed/SEMRush/GTMetrix and other Scoring Algorithms for the Twentyfourteen and other themes
Version: 	2.3.6.1
Author: Edward L. Haletky
Author URI:	http://www.astroarch.com
License:	GPL2
License URI:	https://www.gnu.org/licenses/gpl-2.0.html
Domain Path:	
Text Domain:	aac_scoring
*/

// BEGIN SERVICE FUNCTIONS
// service functions for embedding styles
function aac_scoring_minify_css($css) {
	// Remove comments
	$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
	// Remove space after colons
	$css = str_replace(': ', ':', $css);
	// Remove whitespace
	$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
	// Remove extraneous spaces
	$css = str_replace(', ', ',', $css);
	$css = str_replace(' {', '{', $css);
	$css = str_replace('{ ', '{', $css);
	$css = str_replace('; ', ';', $css);
	return $css;
}

function aac_scoring_add_style($cname,$ur,$fix=0,$dur="") {
	if ($fix != 3) { $cname.='-css'; }
	#wp_cache_delete($cname,'style');
	$str=wp_cache_get($cname,'style');
	if ($str === false) {
		if ($fix!=3) {
			$str=file_get_contents($ur);
		} else {
			$str=$ur; // passed in as arg not file
		}
		if ($fix==1) {
			// now fix all paths for background images
			$str=str_replace('url\(images/pattern','url('.get_template_directory_uri().'/images/pattern',$str);
		}

		// special cases
		if ($cname == 'responsive-lightbox-fancybox-style-css') {
			$str=str_replace('src=\'fancy','src=\''.plugins_url().'/responsive-lightbox/assets/fancybox/fancy',$str);
			$str=str_replace("url('fancy","url('".plugins_url().'/responsive-lightbox/assets/fancybox/fancy',$str);
			$str=str_replace('src=\'blank','src=\''.plugins_url().'/responsive-lightbox/assets/fancybox/blank',$str);
			$str=str_replace("url('blank","url('".plugins_url().'/responsive-lightbox/assets/fancybox/blank',$str);
		}
		if ($cname == 'ts_fab_css-style-css') {
			$str=str_replace('url(../images','url('.plugins_url().'/fancier-author-box/images',$str);
			
		}
		// End Special Cases

		if ($fix==2) {
			$dur=str_replace(ABSPATH,'/',$dur);
			$str=str_replace('../fonts',$dur.'/fonts',$str);
		}
		$str=aac_scoring_minify_css($str);
		wp_cache_set($cname,$str,'style',14200);
	}
	echo '<style id="'.$cname.'" type="text/css">'.$str.'</style>';
}

function aac_scoring_add_font_style($font) {
	$cname=$font.'-style-scoring';
	$ur = plugin_dir_path(__FILE__).$font.'-style.css';
	aac_scoring_add_style($cname,$ur);
}
// END SERVICE FUNCTIONS

// Improves Render Blocking Javascript/CSS in above-the-fold content
$aac_deps=array();
$aac_enq=array();
function aac_scoring_dequeue_fonts() {
	global $wp_styles, $aac_deps, $aac_enq;

	$theme = strtolower(get_template());

	// Support for Child Theme Configurator plugin
	if (defined('CHLD_THM_CFG_OPTIONS')) {
		$parnt_deps=$wp_styles->registered['chld_thm_cfg_parent']->deps;
		wp_dequeue_style('chld_thm_cfg_parent');
		foreach ($parnt_deps as $deps) {
			if ($deps != 'genericons') {
				$aac_deps[$deps]=$wp_styles->registered[$deps]->src;
			}
			wp_dequeue_style($deps);
		}
	}

	// Style theme Deps
	// $deps=$wp_styles->registered[ $theme.'-style' ]->deps;
	// foreach ($deps as $deps) {
	// 	if ($deps != 'genericons') {
	// 		$aac_deps[$deps]=$wp_styles->registered[ $deps ]->src;
	// 	}
	// 	wp_dequeue_style($deps);
	// }

	// dequeue the theme-style
	wp_dequeue_style( $theme.'-style'); 

	// Remove Open Sans  and other Font added by theme
	// wp_dequeue_style( 'open-sans' );
	wp_deregister_style('open-sans');
	wp_register_style( 'open-sans', false );


	// just a little protection, needs to be twentyfourteen stylesheets
	if ( $theme == 'twentyfourteen' ) {
		// remove these fonts for less round trips
		// Remove Lato Font
		wp_dequeue_style( 'twentyfourteen-lato' );

		// remove twentyfourteen remote styles in favor of embeds
		wp_dequeue_style( 'twentyfourteen-ie' );

		// support for fourteen-colors
		if (function_exists('fourteen_colors_print_output')) {
			remove_action( 'wp_head', 'fourteen_colors_print_output' );
		}
	}

	// What about any 'Style Inline'

	// substitute FontAwesome for Genericons if available
	if( class_exists( 'IconFonts' ) ) {
		// support icon-fonts plugin
		$settings = get_option( 'icon_fonts_settings' );
		if (isset($settings["font-awesome"])) {
			wp_dequeue_style( 'genericons' );
			$aac_enq['FontAwesome']=$wp_styles->registered[ 'font-awesome-font' ]->src;
			wp_dequeue_style( 'font-awesome-font' );
		}
	}

	// support for font-awesome-4-menus
	// DO this last as it is more modern than Icon-Fonts
	if( class_exists( 'FontAwesomeFour' ) ) {
		wp_dequeue_style( 'genericons' );
		wp_dequeue_style( 'font-awesome-four' );
		$aac_enq['FontAwesome']=$wp_styles->registered[ 'font-awesome-four' ]->src;
	}
	if( class_exists( 'WPColumna' ) ) {
		$aac_enq['wp-columna']=$wp_styles->registered[ 'wp-columna' ]->src;
		wp_dequeue_style( 'wp-columna' );
	}

	// support for wp-bootstrap-tabs embed
	if (defined('BOOTSTRAPTABS_PLUGIN_BASENAME')) {
		$aac_enq['bootstraptabs_bootstrap']=$wp_styles->registered[ 'bootstraptabs_bootstrap' ]->src;
		wp_dequeue_style( 'bootstraptabs_bootstrap' );
	}

	// support tabby-responsive-tabs embed
	// tabby-print is a yes, tabby is optional but no way to set
	if (function_exists('cc_tabby_plugin_version')) {
		$aac_enq['tabby']=$wp_styles->registered[ 'tabby' ]->src;
		wp_dequeue_style( 'tabby' );
		wp_deregister_style('tabby');
	}
	
	// responsive lightbox
	if (defined('RESPONSIVE_LIGHTBOX_PATH')) {
		$settings = get_option( 'responsive_lightbox_settings' );
		if (strcasecmp($settings['script'],'fancybox') == 0) {
			$aac_enq['responsive-lightbox-fancybox']=$wp_styles->registered[ 'responsive-lightbox-fancybox' ]->src;
			wp_dequeue_style('responsive-lightbox-fancybox');
		}
	}

	// support for fancier author box
	if (function_exists('ts_fab_get_display_settings')) {
		$aac_enq['ts_fab_css']=$wp_styles->registered[ 'ts_fab_css' ]->src;
		wp_dequeue_style( 'ts_fab_css' );
	}

	// search for open-sans in any 'font' named CSS
	$search_text='font';
	$keys=array_keys($wp_styles->registered);
	$fonts=array_filter($keys, function($el) use ($search_text) {
        	return ( strpos($el, $search_text) !== false ); 
	});
	foreach ($fonts as $font) {
		if (stristr($wp_styles->registered[$font]->src,'open+sans') !== false) {
			wp_dequeue_style( $font );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'aac_scoring_dequeue_fonts', 100 );

// Remove Open Sans Font added by WP embed
function aac_embed_scripts() {
	wp_dequeue_style( 'open-sans' );
}
add_action('enqueue_embed_scripts','aac_embed_scripts');

// Security AND Performance
function aac_plugins_loaded() {
        // Disable W3TC footer comment for all users
        if (defined('W3TC')) {
                add_filter( 'w3tc_can_print_comment', function( $w3tc_setting ) { return false; }, 10, 1 );
        }
	if (function_exists('cc_tabby_css')) {
		remove_action('wp_print_styles', 'cc_tabby_css', 30);
		add_action( 'wp_enqueue_scripts', 'cc_tabby_css' );
	}
}
add_action('plugins_loaded','aac_plugins_loaded');

// Support for Simple-Custom-CSS plugin embed -- all themes
function aac_sccss_unregister_style() {
	if (defined('SCCSS_FILE')) {
                wp_dequeue_style('sccss_style');
                wp_dequeue_script('sccss_register_style');
        }
}
add_action('wp_head', 'aac_sccss_unregister_style', 1);

// Improves Render Blocking Javascript/CSS in above-the-fold content
// By embedding styles 
function aac_scoring_embed_css_above_the_fold() {
	global $wp_styles, $aac_deps, $aac_enq;

	// Support for Theme Dependencies - Usually on Parent
	$hp=ABSPATH;
	foreach ($aac_deps as $key => $deps) {
		$ur=$hp.wp_make_link_relative($deps);
		aac_scoring_add_style($key.'-style',$ur, 1);
	}

	// Parent/Child Theme Code
	$theme = strtolower(get_template());
	$pt=get_template_directory();
	$ct=get_stylesheet_directory();
	if ($pt != $ct) {
		$ur=$pt.'/style.css';
		aac_scoring_add_style($theme.'-parent-style',$ur, 1);
		$ur=$ct.'/style.css';
		aac_scoring_add_style($theme.'-style',$ur, 1);
	} else {
		$ur=$pt.'/style.css';
		aac_scoring_add_style($theme.'-style',$ur, 1);
	}

	// Support for Theme Mods done Inline 'After'
	$tmi=$wp_styles->registered[$theme.'-style']->extra;
        aac_scoring_add_style($theme.'-style',$tmi['after'][0],3);

	// This is for Twentyfourteen Theme Only
	if ( $theme == 'twentyfourteen' ) {
		// twentyfourteen-style -- above
		// fourteen-colors
		if (function_exists('fourteen_colors_print_output')) {
        		aac_scoring_add_style('fourteen-colors',get_theme_mod( 'fourteen_colors_css', '/* Fourteen Colors is not yet configured. */' ),3);
		}

		// twentyfourteen-style-ie
		echo "\n<!--[if lt IE 9]>
<link rel='stylesheet' id='twentyfourteen-ie-css'  href='".get_template_directory_uri()."/css/ie.css' type='text/css' media='all' />\n
<![endif]-->\n";
	}

	// Support for Simple-Custom-CSS plugin embed -- all themes
	if (defined('SCCSS_FILE')) {
		$options     = get_option('sccss_settings');
		$raw_content = isset($options['sccss-content']) ? $options['sccss-content'] : '';
		$content     = wp_kses( $raw_content, array( '\'', '\"' ) );
		$content     = str_replace( '&gt;', '>', $content );
        	aac_scoring_add_style('sccss-style',$content,3);
	}

	// Support for Everything Else
	foreach ($aac_enq as $key => $enq) {
		$ur=$hp.wp_make_link_relative($enq);
		if ($key == "FontAwesome") {
			$dur=dirname(dirname($enq));
			aac_scoring_add_style($key.'-style',$ur,2,$dur);
			aac_scoring_add_font_style('fa');
		} else {
			aac_scoring_add_style($key.'-style',$ur,1);
		}
	}
}
add_action('wp_head','aac_scoring_embed_css_above_the_fold',2);

// Now the stuff that works on all themes
//

// Improves SEMRush Score -- on all themes
function aac_scoring_the_title($title) {
	if (is_front_page()) {
		$title=str_replace('h1','h2',$title);
	}
	return $title;
}
add_action('the_title','aac_scoring_the_title');

// Remove wp-json declarations that appear many times and cause scoring to 
// be swayed
function aac_scoring_remove_json_api () {

	// Remove the REST API lines from the HTML Header
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

	// Remove the REST API endpoint.
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );

	// Turn off oEmbed auto discovery.
	add_filter( 'embed_oembed_discover', '__return_false' );

	// Don't filter oEmbed results.
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

	// Remove oEmbed discovery links.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	// Remove the Link header for the WP REST API
	// [link] => <http://www.example.com/wp-json/>; rel="https://api.w.org/"
	remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
}
add_action( 'after_setup_theme', 'aac_scoring_remove_json_api' );

// Security, Remove pingback_url
// works with in .htaccess and mod_substitute:
// AddOutputFilterByType SUBSTITUTE text/html
// Substitute "s/<link rel=\"pingback\" href=\"\">//"
function aac_scoring_remove_pingback_url( $output, $show ) {
	if ( $show == 'pingback_url' ) $output = '';
	return $output;
}
add_filter( 'bloginfo_url', 'aac_scoring_remove_pingback_url', 10, 2 );

// Ensure all before_title/after_title items for widgets use <h2> not <h1>
function aac_scoring_dynamic_sidebar_params($params) {
	$j=0;
	foreach ($params as $param) {
		$params[$j]['before_title']='<h2 class="widget-title">';
		$params[$j]['after_title']='</h2>';
		$j++;
	}
	return $params;
}
add_filter('dynamic_sidebar_params','aac_scoring_dynamic_sidebar_params');

function aac_scoring_options() {
	include_once(dirname(__FILE__)."/why.php");
}

function aac_scoring_admin() {
	// Talk about what we are really doing, why, and the benefit
	// = documentation
	add_options_page( "AAC Scoring", "AAC Scoring", 'manage_options', 'aac-scoring-options', 'aac_scoring_options');
}
add_action ('admin_menu', 'aac_scoring_admin');

?>
