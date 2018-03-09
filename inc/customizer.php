<?php
defined('ABSPATH') || exit;
 /**
  * Customizer
  *
  * An interface in wp-admin to set and define website variables including:
  * - Contact information
  * - Slideshow slides
  * - Social Media accounts
  *
  */


/*====================================================================================================================
     /* !LOAD CUSTOMIZER OPTIONS INTO MAIN $swrdbs GLOBAL VAR  */
/*------------------------------------------------------------------------------------------------------------------*/
$swrdbs['contact_details']  = array(
								'Street Address',
								'City',
								'Postal Code',
								'Province',
								'Country',
								'Email Address',
								'Phone Number',
								'Secondary Phone',
								'Fax',
								'Latitude', // lat always first.
								'Longitude',
								'Country-Province Code',
								'Google Map URL'
								);
$swrdbs['social_details']   = array(
								'Facebook URL',
								'Twitter URL',
								'Linkedin URL',
								'Google+ URL',
								'Pinterest URL',
								'Youtube URL',
								'Instagram URL'
								);
foreach ($swrdbs['contact_details'] as $contact_detail) {
  	$name = strtolower(sanitize_html_class($contact_detail));
	$swrdbs[$name] = get_theme_mod('swrdbs_contact_detail_setting_'.$name);
}
foreach ($swrdbs['social_details'] as $social_detail) {
  	$name = strtolower(sanitize_html_class($social_detail));
	$swrdbs[$name] = get_theme_mod('swrdbs_social_detail_setting_'.$name);
}

/**
 * Edit customizer UI
 *
 * Minor edits to the user interface of Customizer to make it simplier (in our opinion)
 *
 * @since 1.18
 *
 * @see `add_action( 'customize_controls_print_styles...` in functions.php
 *
 * @return HTML of some CSS edits for the wp-admin <head>
 */
function swrdbs_customizer_hide_some_stuff() {
	?>
	<style type='text/css'>
		#accordion-section-nav,#customize-info,
        #accordion-section-static_front_page { display: none !important; }
        #customize-theme-controls>ul>li h3 {
	        font-weight: bold !important;
	        text-decoration: underline;
        }
	</style>
	<?php
}

/**
 * Register Inputs of Customizer
 *
 * Register the inputs of Customizer, define type and grouping
 *
 * @since 1.18
 *
 * @see `add_action( 'customize_register'..` in functions.php
 */
function swrdbs_customize_register( $wp_customize ) {
	global $swrdbs;
	/* ****** CONTACT DETAILS ****** */
	$wp_customize->add_section( 'swrdbs_contact_details_section' , array(
		'title'      => 'Contact Details',
		'description'=> 'The following information will appear in your websites header, footer, andor
						 in the code (creating a digital business card third party websites can read to
						 better promote your websites contact info).',
		'priority'   => 21,
	) );
  	foreach ($swrdbs['contact_details'] as $k => $detail) {
  		$name = strtolower(sanitize_html_class($detail));
	    $wp_customize->add_setting('swrdbs_contact_detail_setting_'.$name, array(
	        'default'        => '',
	        'type'           => 'theme_mod',
	    ));
	    $wp_customize->add_control('swrdbs_contact_detail_control_'.$name, array(
	        'label'      => $detail,
	        'section'    => 'swrdbs_contact_details_section',
	        'settings'   => 'swrdbs_contact_detail_setting_'.$name,
	        'priority'   => $k,
	    ));
  	}
	/* ****** SOCIAL DETAILS ****** */
	$wp_customize->add_section( 'swrdbs_social_details_section' , array(
		'title'      => 'Social Media Links',
		'description'=> 'Enter the URL of your websites social media accounts here.',
		'priority'   => 21,
	) );
  	foreach ($swrdbs['social_details'] as $detail) {
  		$name = strtolower(sanitize_html_class($detail));
	    $wp_customize->add_setting('swrdbs_social_detail_setting_'.$name, array(
	        'default'        => '',
	        'type'           => 'theme_mod',
	    ));
	    $wp_customize->add_control('swrdbs_social_detail_control_'.$name, array(
	        'label'      => $detail,
	        'section'    => 'swrdbs_social_details_section',
	        'settings'   => 'swrdbs_social_detail_setting_'.$name,
	    ));
  	}

	/* ****** SLIDESHOW DETAILS ******
	$wp_customize->add_section( 'swrdbs_slideshow_section' , array(
		'title'      => 'Home Page Slideshow',
		'description'=> 'Use the feilds below to set up your home page\'s '.$swrdbs['slideshow_x'].'
						 slideshow panels. Always include <code>https://</code> when adding a "link to" URL. Slideshow images are <code>'.$swrdbs['slideshow_w'].' &times; '.$swrdbs['slideshow_h'].'</code>, if too big or small images will crop and scale automatically.<br /><br />',
		'priority'   => 22,
	) );
  	for ($i = 1; $i != ($swrdbs['slideshow_x']+1); $i++) {
  		// Caption
	    $wp_customize->add_setting('swrdbs_slideshow_slide_'.$i.'_title', array(
	        'default'        => '',
	        'type'           => 'theme_mod',
		    ));
		    $wp_customize->add_control('swrdbs_slideshow_control_slide_'.$i.'_title', array(
		        'label'      => 'SLIDESHOW IMAGE #'.$i.' Title ---------',
		        'section'    => 'swrdbs_slideshow_section',
		        'settings'   => 'swrdbs_slideshow_slide_'.$i.'_title',
		        'priority'   => $i.'_2'
		    ));
  		// Link To
	    $wp_customize->add_setting('swrdbs_slideshow_slide_'.$i.'_caption', array(
	        'default'        => '',
	        'type'           => 'theme_mod',
		    ));
		    $wp_customize->add_control('swrdbs_slideshow_control_slide_'.$i.'_caption', array(
		        'label'      => 'Caption',
		        'section'    => 'swrdbs_slideshow_section',
		        'settings'   => 'swrdbs_slideshow_slide_'.$i.'_caption',
		        'priority'   => $i.'_3'
		    ));
  		// Image Copyright
	    $wp_customize->add_setting('swrdbs_slideshow_slide_'.$i.'_cta', array(
	        'default'        => '',
	        'type'           => 'theme_mod',
	    ));
	    $wp_customize->add_control('swrdbs_slideshow_control_slide_'.$i.'_cta', array(
	        'label'      => 'Call to Action (button text)',
	        'section'    => 'swrdbs_slideshow_section',
	        'settings'   => 'swrdbs_slideshow_slide_'.$i.'_cta',
	        'priority'   => $i.'_4'
	    ));
  		// Image Copyright Link
	    $wp_customize->add_setting('swrdbs_slideshow_slide_'.$i.'_cta_link', array(
	        'default'        => '',
	        'type'           => 'theme_mod',
	    ));
	    $wp_customize->add_control('swrdbs_slideshow_control_slide_'.$i.'_cta_link', array(
	        'label'      => 'Link button to URL',
	        'section'    => 'swrdbs_slideshow_section',
	        'settings'   => 'swrdbs_slideshow_slide_'.$i.'_cta_link',
	        'priority'   => $i.'_5'
	    ));
	    // Image
	    $wp_customize->add_setting('swrdbs_slideshow_slide_'.$i.'_image', array(
	        'default'        => '',
	        'type'           => 'theme_mod',
		    ));
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
				$wp_customize,
				'swrdbs_slideshow_slide_'.$i.'_image',
				array(
					'label'      => 'image select',
					'section'    => 'swrdbs_slideshow_section',
					'settings'   => 'swrdbs_slideshow_slide_'.$i.'_image',
					'priority'   => $i.'_1'
				) )
			);

  	}
  	*/
}
?>
