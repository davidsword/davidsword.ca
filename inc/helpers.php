<?php
defined('ABSPATH') || exit;
 /**
  * ASSISTANTS.PHP
  *
  * Functions herein generally remained unchanged for use of this starter theme.
  * These functions are helpers and serve various tasks in manipulating content,
  * wp-admin, sripts and more.
  */

/**
 * Return an image on any `Page`, `Post`, or custom post type
 *
 * When you're on a page, home page, single post, etc and need an image for somthing like opengraph or a thumbnail
 * this function will return whatever it can by
 * - looking for a "Featured Image"
 * - looking for images attached to the post
 * - looking for images within the post_content
 * - if everything else fails it will attach the FAVICON of the site
 *
 * @since 1.0.0
 *
 * @see `$swrdbs['favicon']` in functions.php
 *
 * @return string $image contains url of an image for the current page
 */
function swrdbs_return_a_image($default_image = '', $default_ID = '') {
	global $post, $swrdbs;

	if (empty($default_ID))
		$default_ID = get_the_ID();

	if (empty($default_image))
		$default_image = $swrdbs['favicon']."?ref_id=".$default_ID;

	$ftr = wp_get_attachment_image_src( get_post_thumbnail_id( $default_ID ), 'medium' );
	preg_match_all('/\!\[(.+?)\]\((.+?)\)/i',$post->post_content, $result);

	// featured image
	if (isset($ftr[2]))
		$image = $ftr[0];
	// an image from post_content
	elseif (isset($result[2][0]))
		$image = $result[2][0];
	// default image
	else
		$image = $default_image;

	return $image;
}

/**
 * Attach stylesheet to TinyMCE
 *
 * @since 1.0.0
 *
 * @see `add_filter( 'mce_css'...` in functions.php
 *
 * @return URL to TinyMCE's independent stylesheet
 */
if ( ! function_exists('swrdbs_tinymce_css') ) {
	function swrdbs_tinymce_css($wp) {
		$wp .= ',' . get_bloginfo('stylesheet_directory').'/_/tinymce.css';
		return $wp;
	}
}

/**
 * Modify /wp-admin/'s header
 *
 * - add favicon
 * - remove small /wp-admin/ elements like TinyMCE's word counter, extra formating options (unused) etc.
 * - move post_excerpt ABOVE post_content for match back-and-front ends
 * - add a HOME icon into /wp-admin/ > Pages to clearly denote which page is page_on_front
 *
 * @since 1.0.0
 *
 * @see `add_action('admin_head'...` in functions.php
 *
 * @return URL to TinyMCE's independent stylesheet
 */
function swrdbs_modify_admin_header(){
	global $current_screen, $swrdbs;
	?>

	<!-- START: ADMIN EDITS, via `/_/assistants.php` -->
	<style type='text/css'>
		#postexcerpt.postbox > .inside > p { display:none !important }
		#wp-word-count, .autosave-info, #screen-meta-links, #misc-publishing-actions, #edit-slug-box { opacity: 0.3 }
		#wp-word-count:hover, .autosave-info:hover, #misc-publishing-actions:hover, #screen-meta-links:hover, #edit-slug-box:hover { opacity: 1 }
		#postexcerpt h3 em { font-weight: normal; font-size: 0.8em; color: #ccc; font-style: normal; }
		#postexcerpt textarea { font-size: 1.3em; padding: 10px 15px; height: 5.5em; }

		/* always show excerpt .. its always used in this theme */
		#postexcerpt { display: block !important; }
		label[for=postexcerpt-hide] { display: none !important; }
	</style>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			/* add home icon to PAGE list ---------------------------------- */
			if (jQuery('tr#post-<?= get_option('page_on_front') ?>').length > 0) {
				jQuery('tr#post-<?= get_option('page_on_front') ?> td.post-title strong').prepend('<div class="dashicons dashicons-admin-home" style="opacity:0.3;font-size:20px !important;margin-right:15px;"></div>')
			}

			/* remove h and address from tinymce dropdown ---------------------------------- */
			setTimeout(function() {
				jQuery('#mce_39, #mce_44, #mce_45, #mce_46').remove()
			}, 5000);
			if (jQuery('#postexcerpt').length > 0) {
				if (!jQuery('#postexcerpt').hasClass('MOVED_postexcerpt')) {
					jQuery('#postexcerpt').addClass('MOVED_postexcerpt')
					jQuery('#titlediv').after(jQuery('#postexcerpt').detach())
					jQuery('#postexcerpt h3.hndle').append(' <em class="description">A captivating large-text introduction to the page..</em>')
				}
			}

			/* Edit metabox header title for simplicity ---------------------------------- */
			if (jQuery('#wpseo_meta h3.hndle span').length > 0) {
				jQuery('#wpseo_meta h3.hndle span').text('Basic Search Engine Optimization')
			}

			if (jQuery('#postimagediv').length > 0) {
				jQuery('#postimagediv h3').after('<p style="padding: 5px 10px 0 10px;" class="small description"><code><?= $swrdbs['hero_w'] ?> &times; <?= $swrdbs['hero_h']?></code>, if too big or small images will crop and scale automatically.</p>')
			}

			if (jQuery('#pageparentdiv').length > 0) {
				jQuery('#pageparentdiv .inside p:last-child').remove()
			}

		});
	</script>
	<!-- END: ADMIN EDITS, via `/_/assistants.php` -->

	<?php
}


/**
 * Shortcode functino for [space]
 *
 * add <div class='spave'></div> where [space] is used
 *
 * @since 1.0.0
 *
 * @see `add_shortcode('space'..` in functions.php
 *
 * @return html below
 */
function swrdbs_shortcode_space() {
	return "<div class='space'><!-- --></div>";
}

/**
 * Shortcode functino for [clear]
 *
 * add <div class='clear'></div> where [clear] is used
 *
 * @since 1.0.0
 *
 * @see `add_shortcode('clear'..` in functions.php
 *
 * @return html below
 */
function swrdbs_shortcode_clear() {
	return "<div class='clear'><!-- --></div>";
}

/**
 * Shortcode functino for [box]
 *
 * puts [box]...[/box] in <div class='box'>...</div>
 *
 * @since 1.0.0
 *
 * @see `add_shortcode('box'..` in functions.php
 *
 * @param array $atts nothing, ignore it
 * @param string $content content to put in <div>
 * @return html content in <div>
 */
function swrdbs_shortcode_box($atts, $content="") {
	return "<div class='box'>{$content}</div>";
}

/**
 * list pages in <option> tags
 *
 * Retrieves all pages for use in <select> tags <option></option> value is the page ID
 *
 * @since 1.0.0
 *
 * @param string $preselect should be the value (page) id of any pre-selected values.
 * @return html string of pages in individual <option></option> tags
 */
function swrdbs_return_list_pages($preselect,$choplng = 20) {
	$return = '';
	$pages = get_pages('');
	foreach ($pages as $page) {
		$presel = ($page->ID == $preselect) ? " selected='selected'" : '';
		$ischild = ( !empty($page->post_parent) ) ? " &nbsp;&nbsp;&nbsp;&nbsp; " : '';
		$return .= "<option value='{$page->ID}'{$presel}>{$ischild}".swrdbs_return_chopstring($page->post_title,$choplng)."</option>\n";
	}

	return $return;
}

/**
 * list images in <option> tags
 *
 * Retrieves all images for use in <select> tags <option></option> value is the attachment ID
 *
 * @since 1.0.0
 *
 * @param string $preselect should be the value (attachment) id of any pre-selected values.
 * @return html string of images in individual <option></option> tags
 */
function swrdbs_return_list_images($preselect,$choplng = 20) {
	$pages = get_posts('post_type=attachment&numberposts=-1');
	foreach ($pages as $page) {
		$presel = ($page->ID == $preselect) ? " selected='selected'" : '';
		echo "<option value='{$page->ID}'{$presel}>".swrdbs_return_chopstring($page->post_title,$choplng)."</option>\n";
	}
}

/**
 * Get First Line of text
 *
 * Will return the first line of a series of lines. Used in tandom w/ the [accordian] shortcode
 *
 * @since 1.0.0
 *
 * @param string $content html text to retrieve first line
 * @return string first line of $content
 */
function swrdbs_return_first_line($content) {
	$line = explode("\n", $content);
	if (strip_tags($line[0]) != '' && strip_tags($line[0]) != ' ') return $line[0];
	if (strip_tags($line[1]) != '') return $line[1];
	if (strip_tags($line[2]) != '') return $line[2];
	if (strip_tags($line[3]) != '') return $line[3];
}

/**
 * Replace middle of string with "..." shortening
 *
 * As above this function is called when a string is too long and needs to be cut
 * Cutting middle as this is mainly used in listing IMAGES, this was the EXT will
 * show.
 *
 * @since 1.0.0
 *
 * @param string $string text to be striped (always keep out HTML unless you want headaches)
 * @param int $choplen number of characters that will be chop when greater than
 * @param string $cut html to put in the chopped section, typically "..."
 * @return string $string of cut html if $string was > $choplen
 */
function swrdbs_return_chopstring($string,$choplen = 20,$cut = '...') {
	if (strlen($string) > $choplen) {
		$ashortertitle = strip_tags($string);

		$first = substr_replace($ashortertitle, '', (floor($choplen/2)), strlen($ashortertitle));
		$second = substr_replace($ashortertitle, '', 0, (strlen($ashortertitle)-(floor($choplen/2))));
		$newstring = $first.$cut.$second;

		// if the cut only cut 1 letter.. we don't want to bother. at least 4 had to be cut.
		return (strlen($newstring) > (strlen($string))) ? $string : $newstring;
	} else {
		return $string;
	}
}

/**
 * Generate an encrypted email
 *
 * handler for [email] shortcode
 * `[email]` will return CUSTOMIZER email address encrypted
 * `[email]value[/email]` will return encrypted email value between.
 * both method use `swrdbs_return_jshidden_email()`
 *
 * @since 1.0.0
 *
 * @see `add_shortcode('email'..` in functions.php
 *
 * @param  string $email a valid email ie: "useranme@domain.tld"
 * @return string html of JS email "<script>...</script>"
 */
if (!function_exists('swrdbs_return_email')) {
	function swrdbs_return_email($atts = '', $val = '') {
		global $swrdbs;
		// if value in [email]foobar[/email]
		if (!empty($val))
			return swrdbs_return_jshidden_email($val);
		// if just [email] for placeholder of site/admin/website-options email
		else
			if (isset($swrdbs['emailaddress']))
				return swrdbs_return_jshidden_email($swrdbs['emailaddress']);
	}
}
/**
 * Encyrpt email address
 *
 * take the string of an email and encrypt it with js to prevent spambots
 *
 * @since 1.0.0
 *
 * @see `add_action( 'admin_menu' ...` in functions.php
 *
 * @param  string $email a valid email ie: "useranme@domain.tld"
 * @return string html of JS email "<script>...</script>"
 */
function swrdbs_return_jshidden_email($email) {
	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
	$key = str_shuffle($character_set);
	$cipher_text = '';
	$id = 'e'.rand(1,999999999);
	for ($i=0;$i<strlen($email);$i+=1)
		$cipher_text.= $key[strpos($character_set,$email[$i])];

	$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
	$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
	$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
	$script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")";
	$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
	return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
}

/**
 * Shortcode function for [phone]
 *
 * spit phone variable from customizer.php
 *
 * @since 1.0.0
 *
 * @see `add_shortcode('phone'...` in functions.php, or customizer.php
 *
 * @return string phone number, 555 phone number if none.
 */
function swrdbs_phone( $atts, $content="" ) {
	global $swrdbs;
	return (isset($swrdbs['phonenumber']) && !empty($swrdbs['phonenumber'])) ? $swrdbs['phonenumber'] : '+1 (555) 555-5555';
}


/**
 * Convert decrative phone numbers
 *
 * remove visual garbage from phone numbers
 *
 * @since 1.0.0
 */
function swrdbs_return_clean_phonenumber($phone) {
	return str_replace('--','-',str_replace( array('+',' ','(',')'), array('','-','','-'), $phone ));
	//return trim( str_replace( array('+1',''), array(''), $phone ) );
}


/**
 * Extract twitter handler from twitter URL
 *
 * @since 1.0.0
 *
 * @see $swrdbs['social_details'] and "twitterurl" in /_/customizer.php
 *
 * @return string twitter username, if twitter url exists.
 * @return boolen false when no URL is present
 */
function swrdbs_return_twitteruser_from_url() {
	global $swrdbs;
	if (!isset($swrdbs['twitterurl'])) return false;
	preg_match("|https?://(www\.)?twitter\.com/(#!/)?@?([^/]*)|", $swrdbs['twitterurl'], $username);
	if ($username && isset($username[3]))
		return $username[3];
	else
		return false;
}

/**
 *
 */
function swrdbs_return_youtube_video_from_url($youtube_url) {
	global $swrdbs;
	parse_str( parse_url( $youtube_url, PHP_URL_QUERY ), $output );
	// small change the ID was passed instead of full url
	return (isset($output['v']) && !empty($output['v'])) ? $output['v'] : $youtube_url;
}






/**
 * Make sure specific plugins are on or off
 *
 * Ugly code, but it does it's job this theme relies on some of these plugins, and/or insists on having them for enhanced and hardened Wordpress
 *
 * @since 1.0.0
 *
 * @return string notice of problems or nothing if okay
 */
function swrdbs_plugin_check() {
	global $swrdbs;

	return; // ignore this for now

	// only user id=1
	// yes this isn't perfect, but generally this will work for our sites 99% of the time
	$current_user = wp_get_current_user();
	if ( ( 1 == $current_user->ID) !== false) {
		$check_plugins = $swrdbs['plugins'];
		$notice = $text = '';
		foreach ($check_plugins as $yayornay => $plugins) {
			foreach ($plugins as $plugin) {

				$is_active_msg = ($yayornay == 'yay') ? "" : "active, but it should be <strong style='background:#f7d5d5;padding:0 5px;'>Deactivated</strong>";
				$is_not_active_msg = ($yayornay == 'yay') ? "deactivated, but should be <strong style='background: #d8eeda;padding:0 5px;'>Activated</strong>" : "";

				if ( is_plugin_active( $plugin ) ) {
					if (!empty($is_active_msg))
						$text .= "<li><code>{$plugin}</code> is {$is_active_msg}</li>";
				} else {
					if (!empty($is_not_active_msg))
						$text .= "<li><code>{$plugin}</code> is {$is_not_active_msg}</li>";
				}
			}
		}
		if (strpos( strip_tags($text), 'should be') !== false)
			echo "<div class='error'><ul><li style='font-weight:bold;'>Theme - Required Plugin Check</li>{$text}</ul></div>";
	}
}


/**
 * Get share counts
 *
 * @since 1.0.0
 *
 * @see `swrdbs_make_share()`
 *
 * @param $platform - which social site to call
 * @param $url - pre urlencoded URL of address to run counter on
 *
 * @return int of total shares for URL
 */
function swrdbs_return_social_count($platform,$url) {

	if ($platform == 'facebook') {
		$call  = swrdbs_parser("https://graph.facebook.com/fql?q=SELECT%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20=%20%22" .$url. "%22");
		$a = @json_decode($call);
		if (is_object($a) && isset($a->data[0]))
			$return = @$a->data[0]->total_count;
	}

	if ($platform == 'linkedin') {
		$call  = swrdbs_parser("https://www.linkedin.com/countserv/count/share?format=jsonp&url=".$url);
		@preg_match_all('/\"count\":(\d+),/', $call, $matches);
		if (is_array($matches) && isset($matches[1][0]))
			$return = @$matches[1][0];
	}

	if ($platform == 'google') {
		$call  = swrdbs_parser('https://plusone.google.com/u/0/_/+1/fastbutton?count=true&url='.$url);
		@preg_match_all('/{c: (.+\d) ,/', $call, $matches);
		if (is_array($matches) && isset($matches[1][0]))
			$return = @floor($matches[1][0]);
	}

	if ($platform == 'twitter') {
		$call  = swrdbs_parser("https://cdn.api.twitter.com/1/urls/count.json?url=".$url);
		$a = @json_decode($call);
		if (is_object($a) && isset($a->count))
			$return = @$a->count;
	}

	if ($platform == 'pinterest') {
		$call  = swrdbs_parser("https://api.pinterest.com/v1/urls/count.json?callback%20&url=".$url);
		$clean = str_replace( array("receiveCount(",")") , "", $call);
		$a = json_decode($clean);
		if (is_object($a) && isset($a->count))
			$return = $a->count;
	}

	if (isset($return) && $return != 0)
		return $return;

}




/**
 * Parse URL to data
 *
 * Namley used for SHARE_LINKS
 *
 * @since 1.0.0
 *
 * @see `swrdbs_make_share()`
 *
 * @param pre- urlencoded URL of address to run counter on
 *
 * @return int of total shares for URL
 */
function swrdbs_parser( $encUrl ) {
	$options = array(
		CURLOPT_URL 			=> $encUrl,
		CURLOPT_RETURNTRANSFER	=> true,
		CURLOPT_HEADER 			=> false,
		CURLOPT_FOLLOWLOCATION	=> true,
		CURLOPT_ENCODING	 	=> "",
		CURLOPT_AUTOREFERER 	=> true,
		CURLOPT_CONNECTTIMEOUT 	=> 5,
		CURLOPT_TIMEOUT 		=> 5,
		CURLOPT_MAXREDIRS 		=> 3,
		CURLOPT_SSL_VERIFYHOST 	=> 2,
		CURLOPT_SSL_VERIFYPEER 	=> true
	);
	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$content	= curl_exec( $ch );
	curl_close( $ch );
	return $content;
}




/**
 * Add Browser Class bodyclass
 *
 * Taken straight from thematic, this functions find the current browser based on $_SERVER user agent
 * This should be added directly into the core of Wordpress IMO, so, until then.
 *
 * @since 1.0.0
 *
 * @link themeshaper.com/thematic/
 * @author iandstewart
 *
 * @return string containing a browser name
 */
if (!class_exists('thematic_browser_class_names')) {
	function thematic_browser_class_names($classes) {
		$browser = $_SERVER[ 'HTTP_USER_AGENT' ];
		if ( preg_match( "/Chrome/", $browser ) ) {
			$classes[] = 'chrome';
			preg_match( "/Chrome\/(\d+)/si", $browser, $matches );
			$ch_version = 'ch' . $matches[1];
			$classes[] = $ch_version;
		} elseif ( preg_match( "/Safari/", $browser ) ) {
			$classes[] = 'safari';
			preg_match( "/Version\/(\d+)/si", $browser, $matches );
			$sf_version = 'sf' . $matches[1];
			$classes[] = $sf_version;
		} elseif ( preg_match( "/Opera/", $browser ) ) {
			$classes[] = 'opera';
			preg_match( "/Version\/(\d+)/si", $browser, $matches );
			$op_version = 'op' . $matches[1];
			$classes[] = $op_version;
		} elseif ( preg_match( "/MSIE/", $browser ) ) {
			$classes[] = 'msie';
			preg_match( "/MSIE (\d+)/si", $browser, $matches );
			$ie_version = 'ie' . $matches[1];
			$classes[] = $ie_version;
		} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
			$classes[] = 'firefox';
			preg_match( "/Firefox\/(\d+)/si", $browser, $matches );
			$ff_version = 'ff' . $matches[1];
			$classes[] = $ff_version;
		} else {
			$classes[] = 'unknown-browser';
		}
		return $classes;
	}
} // endif


/**
 * Shortcode [iframe url/src='https://' width='100%' height='450' style='border:0' ]
 *
 * Small function for iframe shortcode
 *
 * @since 1.0.0
 *
 * @return <iframe> html
 */
function swrdbs_iframe($atts) {
    $a = shortcode_atts( array(
        'url' => '',
        'src' => '',
        'height' => '450',
        'width' => '100%',
        'style' => 'border:0',
    ), $atts );
	return '<iframe src="'.$a['url'].$a['src'].'" width="'.$a['width'].'" height="'.$a['height'].'" frameborder="0" style="'.$a['style'].'"></iframe>';
}


/**
 *
 *
 */
function swrdbs_has_hero_video($thispageid = '') {
    global $swrdbs, $wpdb;

    if (empty($thispageid))
    	$thispageid = get_the_ID();

    $video = get_post_meta($thispageid,'video',true);
    $video = swrdbs_return_youtube_video_from_url($video);

    return (isset($video) && !empty($video)) ? $video : false;
}


/**
 * See if current page has a banner or not
 * @since 1.0.0
 */
function swrdbs_has_hero($thispageid = '') {
    global $swrdbs, $wpdb;

    if (empty($thispageid))
    	$thispageid = get_the_ID();

    $has_slideshow = false;
	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $thispageid), 'slideshow' );

    // show a featured image as a static banner..
    if ( (is_single() && isset($img[1])) || isset($img[1]))
        $has_slideshow = true;

    if (swrdbs_has_hero_video())
        $has_slideshow = true;

    return ($has_slideshow) ? true : false;
}


/*
 *
 *
 */
function swrdbs_todoshortcode( $atts, $content = false ) {
	$a = shortcode_atts( array(
		'note' => '',
		'colour' => 'light'
	), $atts );

	if (!$content)
		$content = $a['note'];

	return "<pre class='todo {$a['colour']}'>@TODO: {$content}</pre>";
}

/*
 *
 *
 */

function swrdbs_return_current_URL() {
	global $wp;
	return home_url(add_query_arg(array(),$wp->request));
}


/*
 *
 *
 */
function swrdbs_isPageSpeed() {
	$ck = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'google page speed');
	return ($ck === false) ? false : true;
}


/*
 *
 *
 */
add_action( 'add_meta_boxes', 'swrdbs_hero_video_register' );
add_action( 'save_post', 'swrdbs_hero_video_save' );
function swrdbs_hero_video_register() {
    add_meta_box( 'YTPlayer_sectionid', __( 'Youtube Background Video', 'YTPlayer_textdomain' ), 'swrdbs_hero_video_add', array('page','tour'), 'side'  );
}

/*
 *
 *
 */
function swrdbs_hero_video_add( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'YTPlayer_noncename' );
	$video = get_post_meta(get_the_ID(),'video',true);
	?>
	<label for='video'>Featured Youtube Video:</label>
	<input type="text" class='code' id='video' name="video" value="<?= $video ?>"  /><br />
	<p class='description'>
	  Enter the URL of a Youtube video video you wish to show as the background image on this page.
	  The video code can be found in the URL of a youtube video <code>https://www.youtube.com/watch?v=<span style='background:yellow'>e9MMjppMkio</span>&ftr=true</code>
	</p>
    <?php
}

/*
 *
 *
 */
function swrdbs_hero_video_save( $post_id ) {

	// verification & security
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	   return;
	if ( !isset($_POST['YTPlayer_noncename']) || !wp_verify_nonce( $_POST['YTPlayer_noncename'], plugin_basename( __FILE__ ) ) )
	   return;
	if ( 'page' == $_POST['post_type'] || 'post' == $_POST['post_type'] ) {
	   if ( !current_user_can( 'edit_page', $post_id ) )
	        return;
	} else {
	   if ( !current_user_can( 'edit_post', $post_id ) )
	        return;
	}
	// delete old if it exsists
	delete_post_meta($post_id,'video');
	// add new
	add_post_meta($post_id,'video',$_POST['video']);
}

/*
 *
 * since 1.1.0
 */

function swrdbs_return_filemtime($path) {
	return filemtime( get_template_directory( __FILE__ ) . $path );
}



/**
 * Make social links
 *
 * create social links from svg icons based on values entered into wp-admin customizer
 *
 * @since 1.0.0
 *
 * @see `<?= swrdbs_make_social() ?>` in `index.php`
 *
 * @return string HTML of social icons
 */
function swrdbs_make_social() {
	global $swrdbs;
		$return = '';
    	if (!empty($swrdbs['facebookurl'])) :
        	$return .= "<a itemprop='sameAs' href='{$swrdbs['facebookurl']}' target='_Blank' rel='nofollow' class='social_facebook'>{$swrdbs['name']} on Facebook</a>";
        endif;
    	if (!empty($swrdbs['twitterurl'])) :
        	$return .= "<a itemprop='sameAs' href='{$swrdbs['twitterurl']}' target='_Blank' rel='nofollow' class='social_twitter'>{$swrdbs['name']} on Twitter</a>";
        endif;
    	if (!empty($swrdbs['linkedinurl'])) :
        	$return .= "<a itemprop='sameAs' href='{$swrdbs['linkedinurl']}' target='_Blank' rel='nofollow' class='social_linkedin'>{$swrdbs['name']} on Linkedin</a>";
        endif;
    	if (!empty($swrdbs['googleurl'])) :
        	$return .= "<a itemprop='sameAs' href='{$swrdbs['googleurl']}' target='_Blank' rel='nofollow' class='social_google'>{$swrdbs['name']} on Google+</a>";
        endif;
    	if (!empty($swrdbs['pinteresturl'])) :
        	$return .= "<a itemprop='sameAs' href='{$swrdbs['pinteresturl']}' target='_Blank' rel='nofollow' class='social_pinterest'>{$swrdbs['name']} on Pinterest</a>";
        endif;
    	if (!empty($swrdbs['youtubeurl'])) :
        	$return .= "<a itemprop='sameAs' href='{$swrdbs['youtubeurl']}' target='_Blank' rel='nofollow' class='social_youtube'>{$swrdbs['name']} on Youtube</a>";
        endif;
    	if (!empty($swrdbs['instagramurl'])) :
        	$return .= "<a itemprop='sameAs' href='{$swrdbs['instagramurl']}' target='_Blank' rel='nofollow' class='social_instagram'>{$swrdbs['name']} on Instagram</a>";
        endif;
        return "<div class='social'>".$return."</div>";
}


/**
 * Make share buttons
 *
 * Simple and stylish 'share' buttons with counters
 *
 * @since 1.0.0
 *
 * @see `<?= swrdbs_make_share() ?>` index.php
 *
 * @return string HTML social share buttons
 */
function swrdbs_make_share() {

    $txt = urlencode(get_the_title()." - ".get_bloginfo('title')." - ".get_permalink());
    $url = urlencode(get_permalink());
    $img = urlencode(swrdbs_return_a_image());

    return "
	    <script>
		function open_window(url){
		    var wparams = 'toolbar=0,location=0,directories=0,status=0,menubar=0,';
		        wparams += 'scrollbars=0,resizable=0,width=420,height=350';
		    window.open(url, '_blank', wparams);
		    window.focus();
		}
	    </script>
        <div class='share_links'>
            <ul>
            	<li class='share_facebook'>
                    <a href='#' onclick=\"open_window('https://www.facebook.com/sharer/sharer.php?u={$url}'); return false;\" rel='nofollow'>
                    	<span class='icon'></span>
                    	<span class='name'>Facebook</span>
                    	<span class='counter'>".swrdbs_share_links_getcount('facebook',$url)."</span>
                    </a>
                </li>
                <li class='share_twitter'>
                    <a href='#' onclick=\"open_window('https://twitter.com/intent/tweet?text=&amp;url={$url}&amp;counturl={$url}&amp;related=".swrdbs_return_twitteruser_from_url()."&amp;via=".swrdbs_return_twitteruser_from_url()."'); return false;\" rel='nofollow'>
                    	<span class='icon'></span>
                    	<span class='name'>Twitter</span>
                    	<span class='counter'>".swrdbs_share_links_getcount('twitter',$url)."</span>
                    </a>
                </li>
                <li class='share_google'>
                    <a href='#' onclick=\"open_window('https://plus.google.com/share?url={$url}'); return false;\" rel='nofollow'>
                    	<span class='icon'></span>
                    	<span class='name'>Google+</span>
                    	<span class='counter'>".swrdbs_share_links_getcount('google',$url)."</span>
                    </a>
                </li>
                <li class='share_pinterest'>
                    <a href='#' onclick=\"open_window('https://www.pinterest.com/pin/create/button/?url={$url}&media={$img}&description={$txt}'); return false;\" rel='nofollow'>
                    	<span class='icon'></span>
                    	<span class='name'>Pinterest</span>
                    	<span class='counter'>".swrdbs_share_links_getcount('pinterest',$url)."</span>
                    </a>
                </li>
                <li class='share_linkedin'>
                    <a href='#' onclick=\"open_window('https://www.linkedin.com/shareArticle?mini=true&amp;ro=true&amp;trk=EasySocialShareButtons&amp;title=&amp;url={$url}'); return false;\" rel='nofollow'>
                    	<span class='icon'></span>
                    	<span class='name'>LinkedIn</span>
                    	<span class='counter'>".swrdbs_share_links_getcount('linkedin',$url)."</span>
                    </a>
                </li>
            </ul>
        </div><!-- /share_links -->\n";
}



/**
 *
 * since 1.1.0
 */

function swrdbs_get_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	return $logo[0];
}


function swrdbs_errors() {
	global $swrdbs;
	if (!is_admin() && $swrdbs['dev']) {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		ini_set('display_startup_errors',1);
	}
}


function swrdbs_less() {
	?>
	<!-- #### LESSCSS #### -->
	<link rel="stylesheet/less" type="text/css" href="<?= get_template_directory_uri() . '/assests/css/main.less?v='.time(); ?>" />
	<script type="text/javascript">less = { env: 'development' };</script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.1/less.min.js"></script>
	<?php
}

?>
