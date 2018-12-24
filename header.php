<?php
/**
 * Header
 *
 * @package davidsword-2018
 */

defined( 'ABSPATH' ) || exit;

?><!DOCTYPE html>
<html lang="en">
<head>

<!--

👋🏻 Why hello there!

v<?php echo wp_get_theme()->get( 'Version' ); ?> - synced with WPPusher
https://github.com/davidsword/davidsword.ca-2018

✅ The code is tidy, HTML5 & CSS3 (unprocessed at wp-content/themes/davidsword-2018/style.less)
✅ Google PageSpeed was 87/72. https://developers.google.com/speed/pagespeed/insights/?url=https%3A%2F%2Fdavidsword.ca
✅ GtMetrix Pagespeed is 91% (0.5s load, 166KB weight, 28 Requests) https://gtmetrix.com/reports/davidsword.ca/u6t6vPtS/retest
✅ YSlow is 74%
❌ securityheaders.com could use some work. it's on the list.

🌷 Have a great rest of your day!

-->

<title><?php wp_title(); ?></title>

<!-- #### META #### -->
<meta charset="utf-8">
<meta name="author" content="<?php echo get_bloginfo( 'name' ); ?>" />
<meta name="robots" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- #### WordPress wp_head #### -->
<?php wp_head(); ?>

<!-- #### /WordPress wp_head #### -->

<!-- #### ENABLE RESPONSIVE #### -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />

<!-- #### FEED #### -->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed for Posts" href="<?php bloginfo( 'rss2_url' ); ?>" />

</head>
<body <?php body_class(); ?>>

	<?php do_action( 'body_open' ); ?>

	<div id='trigger'></div>

	<header id='head'>
		<h1><a href='<?php bloginfo( 'url' ); ?>'><?php echo bloginfo( 'name' ); ?></a></h1>
		<nav id='main'>
			<input id="hamburger" type="checkbox" />
			<label for="hamburger" id="hamburger-icon"></label>
			<ul><?php wp_nav_menu( 'container=&items_wrap=%3$s&title_li=&theme_location=main-nav' ); ?> </ul>
			<a href='https://github.com/davidsword' target='_Blank' class='icon icon_git'></a>
			<a href='#' title="🌗😎🌗 DARK MODE!" class='icon icon_darkmode'></a>
		</nav>
	</header>
