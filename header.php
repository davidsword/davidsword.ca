<?php

defined('ABSPATH') || exit;
global $swrdbs;
$theme = wp_get_theme();

?><!DOCTYPE html>
<html lang="en">
<head>

<!--

v<?php echo $theme->get( 'Version' ); ?>

👋🏻 Why hello there!

👀 Interested in my source code?
🎉 I'm flattered!
✋🏻 Let me save you some trouble:

👷🏻‍ This is a custom frankentheme for myself built off of github.com/davidsword/sword-base
👥 I share the code on github anyone wants to fork or see how I did somthing
🤷🏼‍ it's not really intended to be used as-is for anyone but me, but its forkable
✅ The code is tidy, HTML5 & CSS3 (unprocessed at wp-content/themes/davidsword-2018/style.less)
✅ Google PageSpeed was 87/72.
   https://developers.google.com/speed/pagespeed/insights/?url=https%3A%2F%2Fdavidsword.ca
✅ GtMetrix Pagespeed is 91% (0.5s load, 166KB weight, 28 Requests)
   https://gtmetrix.com/reports/davidsword.ca/u6t6vPtS/retest
✅ YSlow is 74%

🌷 Have a great rest of your day!

-->

<!-- synced with WPPusher -->
<!-- github.com/davidsword/davidsword.ca-2018 -->
<!-- v<?php echo $swrdbs['theme_varient'] ?> -->

<title><?php wp_title() ?></title>

<!-- #### META #### -->
<meta charset="utf-8">
<meta name="author" content="<?php echo get_bloginfo('name') ?>" />
<meta name="robots" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- #### WORDPRESS wp_head #### -->
<?php wp_head() ?>

<!-- #### /WORDPRESS wp_head #### -->

<!-- #### TWITTER CARDS #### -->
<meta name="twitter:card" content="summary_large_image">
<?php
$username = swrdbs_return_twitteruser_from_url();
if (!empty($swrdbs['twitterurl']) && !empty($username)) :
?>
<meta name="twitter:site" content="<?php echo $username[3] ?>">
<meta name="twitter:creator" content="<?php echo $username[3] ?>">
<?php endif ?>

<!-- #### ENABLE RESPONSIVE #### -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />

<?php
if (isset($swrdbs['province']) && !empty(($swrdbs['province'].$swrdbs['city'].$swrdbs['longitude'].$swrdbs['longitude']))) :
	$return .= "<!-- #### GEOLOCATION #### -->";
	if (!empty($swrdbs['province']))
		$return .= "<meta name='geo.region' content='{$swrdbs['province']}' />\n";
	if (!empty($swrdbs['city']))
		$return .= "<meta name='geo.placename' content='{$swrdbs['city']}' />\n";
	if (!empty($swrdbs['longitude']))
		$return .= "<meta name='geo.position' content='{$swrdbs['longitude']};{$swrdbs['latitude']}' />\n".
		"<meta name='ICBM' content='{$swrdbs['longitude']}, {$swrdbs['latitude']}' />";
endif;
?>



<!-- #### FEED #### -->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed for Posts" href="<?php bloginfo('rss2_url'); ?>" />
<?php /*<link rel="alternate" type="application/atom+xml" title="Atom 0.3 - <?php bloginfo('name'); ?> " href="<?php bloginfo('atom_url'); ?>" />*/ ?>

</head>
<body <?php body_class() ?>>

	<?php do_action('body_open'); ?>

	<div id='trigger'></div>

	<?php
	//swrdbs_make_card()
	?>
	<header id='head'>
		<h1><a href='<?php bloginfo('url') ?>'><?php echo bloginfo('name') ?></a></h1>
		<nav id='main'>
			<input id="hamburger" type="checkbox" />
			<label for="hamburger" id="hamburger-icon"></label>
			<ul><?php wp_nav_menu('container=&items_wrap=%3$s&title_li=&theme_location=main-nav'); ?> </ul>
			<a href='https://github.com/davidsword' target='_Blank' class='icon icon_git'></a>
			<a href='#' title="🌗😎🌗 DARK MODE!" class='icon icon_darkmode'></a>
		</nav>
	</header>
