<?php defined('ABSPATH') || exit; global $swrdbs; ?><!DOCTYPE html>
<html lang="en">
<head>

<!-- github.com/davidsword/davidsword.ca-2018 -->
<!-- v<?php echo $swrdbs['theme_varient'] ?> -->

<title><?php wp_title() ?></title>

<!-- #### META #### -->
<meta charset="utf-8">
<meta name="author" content="<?= get_bloginfo('name') ?>" />
<meta name="robots" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- #### WORDPRESS ENQUEUE'D & PLUGINS #### -->
<?php wp_head() ?>

<!-- #### TWITTER CARDS #### -->
<meta name="twitter:card" content="summary_large_image">
<?php
$username = swrdbs_return_twitteruser_from_url();
if (!empty($swrdbs['twitterurl']) && !empty($username)) :
?>
<meta name="twitter:site" content="<?= $username[3] ?>">
<meta name="twitter:creator" content="<?= $username[3] ?>">
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

<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500" rel="stylesheet">


<!-- #### FEED #### -->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed for Posts" href="<?php bloginfo('rss2_url'); ?>" />
<?php /*<link rel="alternate" type="application/atom+xml" title="Atom 0.3 - <?php bloginfo('name'); ?> " href="<?php bloginfo('atom_url'); ?>" />*/ ?>

<?php
if ($swrdbs['dev']) {
	swrdbs_less();
} ?>

</head>
<body <?php body_class() ?>>

	<?php do_action('body_open'); ?>

	<div id='trigger'></div>

	<?php
	//swrdbs_make_card()
	?>
	<header id='head'>
		<h1><a style='background-image: url(<?= swrdbs_get_logo(); ?>)' href='<?php bloginfo('url') ?>'><?= bloginfo('name') ?></a></h1>
		<nav id='main'>
			<input id="hamburger" type="checkbox" />
			<label for="hamburger" id="hamburger-icon"></label>
			<ul><?php wp_nav_menu('container=&items_wrap=%3$s&title_li=&theme_location=main-nav'); ?> </ul>
			<a href='https://github.com/davidsword' target='_Blank' class='icon icon_git'></a>
		</nav>
	</header>

	<?php
	if ( function_exists('yoast_breadcrumb') ) {
		//if (is_single() || wp_get_post_parent_id(get_the_ID()))

		//if (is_post_type_archive('images'))
			//yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	}
	?>

	<?= swrdbs_make_hero() ?>
