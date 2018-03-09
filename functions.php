<?php
defined('ABSPATH') || exit;

// see README.MD for starter theme docs
// see README.TXT for theme doc

global $wp_customize, $post, $swrdbs;

// load resources
require('inc/helpers.php');
require('inc/customizer.php');

// things needed for davidsword.ca, carried over through every theme
// regardless of theme (concider it a lazy plugin)
include('inc/ds-cpts.php');
include('inc/ds-cpts-gutenberg/plugin.php'); // the "plugin" :joy:
include('inc/ds-helpers.php');




/* =====================================================================================================
   THEME CONFIGURE, visual and theme development side of things
/* ----------------------------------------------------------------------------------------------------- */

$swrdbs = [
	'theme_varient' => '2.0.0',
	'dev' => true,
	'dev_user_id' => 1,
	'hero_title' => true,
	'hero_w' => 1600,
	'hero_h' => 900,
	'js_plugins' => [
		'lightbox',
		'youtubebackground',
		'waypoints',
		'aos'
	],
	'plugins_required' => [ // "required", well, heavily suggested
		'sword-toolkit/sword-toolkit.php',
		'wordpress-seo/wp-seo.php', // Yoast SEO
		'login-lockdown/loginlockdown.php',
		'login-logo/login-logo.php',
		'broken-link-checker/broken-link-checker.php',
		'gravityforms/gravityforms.php',
		'divi-builder/divi-builder.php'
	],
	'plugins_blacklist' => [
		'google-analyticator/google-analyticator.php',
		'google-sitemap-generator/sitemap.php',
		'attachments/index.php',
		'all-in-one-event-calendar/all-in-one-event-calendar.php'
	],
];

// turn on errors ASAP, uses $swrdbs['dev'] boolean
swrdbs_errors();

// ADD WORDPRESS FEATURES
add_theme_support( 'custom-logo', [
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => ['site-title', 'site-description'],
]);

add_post_type_support( 'page', ['post-formats','excerpt'] );
add_image_size('slideshow',$swrdbs['hero_w'],$swrdbs['hero_h'],true);
//add_theme_support( 'post-formats', ['gallery'] );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails' , ['post' , 'page'] );
	add_theme_support( 'html5', ['comment-list','comment-form','search-form','gallery','caption'] );
	add_theme_support( 'align-wide' );
    add_theme_support( 'editor-color-palette',
        '#a156b4',
        '#d0a5db',
        '#eee',
        '#444'
    );
});

// wordpress overwrite width default settings
$content_width = '';

// REGISTER WORDPRESS FEATURES
register_nav_menu( 'main-nav', 'Main Navigation' );
//register_nav_menu( 'sec-nav',  'Secondary Navigation' );
//register_sidebars(2, ['name'=>'Foobar %d']);

// Add browser name to body class
add_filter('body_class','thematic_browser_class_names'); //@TODO decied if nessisary

// add shortcodes for swrdbs
add_shortcode('space','swrdbs_shortcode_space');
add_shortcode('clear','swrdbs_shortcode_clear');
add_shortcode('box','swrdbs_shortcode_box');
add_shortcode('email','swrdbs_return_email');
add_shortcode('phone','swrdbs_phone');
add_shortcode('iframe','swrdbs_iframe');
add_shortcode('todo', 'swrdbs_todoshortcode' );
add_shortcode('social','swrdbs_make_social');

// admin: load customizer interface
add_action( 'customize_register', 'swrdbs_customize_register' );
add_action( 'customize_controls_print_styles','swrdbs_customizer_hide_some_stuff');

// admin: header and notice for plugin checks
add_action('admin_head','swrdbs_modify_admin_header');
add_action('admin_notices','swrdbs_plugin_check');
// add_filter( 'mce_css', 'swrdbs_tinymce_css' );

// TOOLKIT CONFIGURE, not `$swrdbs` options because these can be used on any theme
if (class_exists('Sword_Toolkit')) {
	$swordToolkit = new Sword_Toolkit;
	$swordToolkit->config([ // will run on config
		'remove_blog' 			=> true,
		'remove_admin_bar' 		=> true,
		'remove_search' 		=> true,
		'remove_menu_pages'		=> ['plugins.php','widgets.php'],
		'remove_menu_sub_pages' => [
			'index.php' => 'my-sites.php',
			'options-general.php' => 'options-discussion.php',
			'options-general.php' => 'options-writing.php',
			'options-general.php' => 'options-reading.php',
			'options-general.php' => 'options-permalink.php',
			'options-general.php' => 'options-media.php',
			'options-general.php' => 'loginlockdown.php',
			'options-general.php' => 'attachments',
			'themes.php' => 'themes.php',
			'themes.php' => 'widgets.php',
			'tools.php' => 'tools.php'
		],
		'remove_jquery_migrate' => true,
		'remove_wp_head_junk' => true,
		'remove_rest_api' => true,
		'remove_emojis' => true,
		'redirect_if_attachment' => true,
	]);
}

/* =====================================================================================================
   PLUGINS CONFIGURE
/* ----------------------------------------------------------------------------------------------------- */

// GRAVITY FORM EDITS
add_filter("gform_confirmation_anchor", '__return_true');
add_action('wp_print_styles', function(){ wp_dequeue_style('gforms_css'); });
add_filter('gform_init_scripts_footer', '__return_true'); // push js to footer

// MONSTER INSIGHTS
add_action( 'wp_enqueue_scripts', 'swrdbs_move_monsterinsights', 99);
function swrdbs_move_monsterinsights() {
	wp_dequeue_script( 'monsterinsights-lite-frontend-script'); // get outta the header
	wp_enqueue_script(
		'monsterinsights-lite-frontend-script', // "monsterinsights-lite" for non-upgraded
		plugins_url().'/google-analytics-for-wordpress/assests/js/frontend.min.js',
		[], // no depends
		get_bloginfo('version'), // refresh cache once in a while
		true // move to footer
	);
}



/* =====================================================================================================
   MAIN HOOKS (most popular hooks)
   - wp_enqueue_scripts
   - body_class
   - the_content
   - get_footer
/* ----------------------------------------------------------------------------------------------------- */

/**
 * Enqueue scripts into Wordpress
 *
 * Load in various styles and scripts into wordpress. Run conditionals to reduce unneeded scripts
 *
 * @since 1.0.0
 *
 * @see `add_action( 'wp_enqueue_scripts'...`
 */
add_action( 'wp_enqueue_scripts', function () {
	global $swrdbs;

	/* jQUERY ---------------------------------- */
	wp_deregister_script( 'jquery');
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    wp_enqueue_script( 'jquery' );


	/* MAIN JS ---------------------------------- */
	$mainjs = ($swrdbs['dev']) ? 'main.js' : 'main.min.js';
	wp_register_script(
		'swrdbs_js',
		get_template_directory_uri() . '/assests/js/'.$mainjs,
		['jquery'],
		swrdbs_return_filemtime('/assests/js/'.$mainjs),
		true
	);
	wp_enqueue_script( 'swrdbs_js' );

	/* LIGHTBOX ---------------------------------- */
	//if ( has_post_format( 'gallery' ) ) {
	wp_register_script(
		'lightbox',
		get_template_directory_uri() . '/assests/js/jquery.lightbox.js',
		['jquery','swrdbs_js'],
		swrdbs_return_filemtime('/assests/js/jquery.lightbox.js'),
		true
	);
	wp_enqueue_script( 'lightbox');
	//}

	/* YOUTUBE BACKGROUND ---------------------------------- */
	if (swrdbs_has_hero_video()) {
		wp_register_script(
			'youtubebackground',
			get_template_directory_uri() . '/assests/js/jquery.youtubebackground.js',
			['jquery','swrdbs_js'],
			swrdbs_return_filemtime('/assests/js/jquery.youtubebackground.js'),
			true
		);
		wp_enqueue_script( 'youtubebackground' );
	}

	/* ANIMATE ON SCROLL ---------------------------------- */
	/*
	wp_register_script(
	   'aos',
	   get_template_directory_uri() . '/assests/js/jquery.aos.js',
	   ['jquery'],
	   swrdbs_return_filemtime('/assests/js/jquery.aos.js'),
	   true
	);
	wp_enqueue_script( 'aos');*/

	/* WAYPOINTS ---------------------------------- */
	wp_register_script(
		'waypoints',
		get_template_directory_uri() . '/assests/js/jquery.waypoints.js',
		['jquery','swrdbs_js'],
		swrdbs_return_filemtime('/assests/js/jquery.waypoints.js'),
		true
	);
	wp_enqueue_script( 'waypoints' );
});


/**
 *
 *
 */
add_action('body_class', function ($classes) {
	global $swrdbs, $post;
    if (empty($post->post_content) || strpos($post->post_content.' ', 'et_pb_section') === false) {
        $classes[] = 'divi_no';
    } else {
        $classes[] = 'divi_yes';
    }
	if (!is_front_page())
		$classes[] = 'inner_page';
	if ($swrdbs['dev'])
		$classes[] = 'swrdbsdev';
	$classes[] = (swrdbs_has_hero()) ? 'hero_yes' : 'hero_no';
	return $classes;
});


/**
 * Main modifier of the_content() output
 *
 * Default: add an inline featured images (reaches beyond @width)
 *
 * @since 1.0.0
 *
 * @see `functions.php` `add_action('the_content'...`
 *
 * @return string HTML $the_content with any conditional additions herin
 */
add_filter('the_content',function ($the_content) {
    global $swrdbs;

    return $the_content;
},999);

/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
add_action( 'get_footer', function () {
	global $swrdbs;

	/* MAIN CSS ---------------------------------- */
	if (!$swrdbs['dev']) {
		wp_register_style(
			'main',
			get_template_directory_uri() . '/style.css',
			[],
			swrdbs_return_filemtime('/style.css' )
		);
		wp_enqueue_style( 'main');
	}

	/* LIGHTBOX ---------------------------------- */
	//if ( has_post_format( 'gallery' ) ) {
	wp_register_style(
		'lightbox',
		get_template_directory_uri() . '/assests/js/jquery.lightbox.css',
		['main'],
		swrdbs_return_filemtime('/assests/js/jquery.lightbox.css'),
		true
	);
	wp_enqueue_style( 'lightbox');
	//}

	/* ANIMATE ON SCROLL ---------------------------------- */
	/*
	wp_register_style(
	   'aos',
	   get_template_directory_uri() . '/assests/js/jquery.aos.css',
	   ['main'],
	   swrdbs_return_filemtime('/assests/js/jquery.aos.css' )
	);
	wp_enqueue_style( 'aos');
	*/

	// GOOGLE FONT ----------------------------------
	/*
	if (isset($swrdbs['google_font']) && !empty($swrdbs['google_font'])) {
		wp_register_style('gfont',  $swrdbs['google_font'], '', '');
		wp_enqueue_style( 'gfont');
	}
	*/
} );


/* =====================================================================================================
   MAIN CONTENT FUNCTIONS main functions of the theme
   - swrdbs_make_card (business schema card)
   - swrdbs_make_hero (banner)
/* ----------------------------------------------------------------------------------------------------- */

/**
 * Make vcard
 *
 * Creates a vcard using schema.org, pulls vars from Customizer -> Contact Details
 *
 * @since 1.0.0
 *
 * @see _/customizer.php
 */
function swrdbs_make_card() {
	global $swrdbs;

	// if YOAST SEO is enabled, we don't need two schema entries
	if (defined( 'WPSEO_FILE' )) return;

	$return = "
	<div itemscope itemtype='https://schema.org/LocalBusiness' id='card'>

		<img itemprop='logo' alt=\"".get_bloginfo('name')."\" title=\"".get_bloginfo('name')."\" src='".get_site_icon_url()."' />
		<span itemprop='name'>".get_bloginfo('name')."</span>
		<div itemprop='address' itemscope itemtype='https://schema.org/PostalAddress'>";

			if (!empty($swrdbs['streetaddress']))
			$return .= "<span itemprop='streetAddress'>{$swrdbs['streetaddress']}</span>";

			if (isset($swrdbs['city']) && !empty($swrdbs['city']))
			$return .= "<span itemprop='addressLocality'>{$swrdbs['city']}</span>,
			<span itemprop='addressRegion'>{$swrdbs['province']}</span>";

			if (!empty($swrdbs['postalcode']))
				$return .= "<span itemprop='postalCode'>{$swrdbs['postalcode']}</span>";

		$return .= "
		</div>
		<span class='label'>Call:</span>
		<span itemprop='telephone'>";

		if (isset($swrdbs['phonenumber']))
			swrdbs_return_clean_phonenumber($swrdbs['phonenumber']);

		$return .= "</span><br />
		<span class='label'>Email:</span>
		<span class='email'>".swrdbs_return_email('','')."</span>";

		if (!empty($swrdbs['fax']))
			$return .= "<span itemprop='faxNumber'>{$swrdbs['fax']}</span>";

		$domaintext = str_replace( ['https://','https://','www.'],'',strtolower( rtrim(get_bloginfo('url'),"/") ) );
		$return .= "<span itemprop='url'><a href='".get_bloginfo('url')."'>".$domaintext."</a></span>";

		if (!empty($swrdbs['latitude']))
		$return .= "<div itemprop='geo' itemscope itemtype='https://schema.org/GeoCoordinates'>
			<meta itemprop='latitude' content='{$swrdbs['latitude']}' />
			<meta itemprop='longitude' content='{$swrdbs['longitude']}' />
		</div>";

		if (!empty($swrdbs['has_search']))
		$return .= '
		<form itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction">
			<meta itemprop="target" content="'.get_bloginfo('url').'/?s={search_term_string}"/>
			<input itemprop="query-input" type="text" name="search_term_string" required/>
			<input type="submit"/>
		</form>';

	$return .= swrdbs_make_social()."
	</div><!--/#card-->";

	return $return;
}


/**
 * Make Slideshow OR 'Featured Image' banner image(s)
 *
 * @since 1.0.0
 *
 * @see `swrdbs_make_scripts`
 * @return string HTML of banner or not
 */
function swrdbs_make_hero() {
    global $swrdbs, $wpdb;

	return;

    $nobanner = "<div id='nobanner'><!-- --></div>";

    // these special pages dont get anything
    if (is_archive() || is_search() || is_404()) {
    	echo $nobanner;
    	return;
    }

	// but normal pages with a hero selected will
    $pg 	= (is_home()) ? get_option('page_for_posts') : get_the_ID();
    $thispg = get_post($pg);
	$img 	= wp_get_attachment_image_src( get_post_thumbnail_id($thispg->ID), 'slideshow' );
	$video  = swrdbs_has_hero_video($thispg->ID);
	if ($video || (is_single() && isset($img[1])) || isset($img[1])) {

        echo "
        <div id='hero'>
			<div class='panel parallax' style='background-image:url({$img[0]});'>
	        <div class='panel_meta'>";
	    if ($swrdbs['hero_title']) {
	    	echo (!empty($thispg->post_title))   ? "<h1>{$thispg->post_title}</h1>" : '';
	        echo (!empty($thispg->post_excerpt)) ? "<h2>{$thispg->post_excerpt}</h2>" : '';
	    }
	    echo "
	        </div>
	        <div class='downarrow'><span class='icon'></span></div>
        </div>
        </div>";
	    if ($video) {
			add_action('wp_footer',function(){
				$video  = swrdbs_has_hero_video($thispg->ID);
				?>
				<script data-src='functions.php:swrdbs_make_hero()'>
				jQuery(window).load(function() {
					jQuery('#hero .panel').YTPlayer({
					    videoId: '<?= $video ?>',
					    width: jQuery(window).width(),
					    ratio: 16 / 9,
					    mute: true
					});
					jQuery( window ).resize(ytplayer_resize);
					ytplayer_resize();
					function ytplayer_resize() {
						if (jQuery( window ).width() < 680) {
							jQuery('.ytplayer-container').hide()
						} else {
							jQuery('.ytplayer-container').show()
						}
					}
				});
				</script>
				<?php
			});
	    }
    }
	// unless no hero is selected for the page
    else {
        echo $nobanner;
    }
}

/*fin*/
