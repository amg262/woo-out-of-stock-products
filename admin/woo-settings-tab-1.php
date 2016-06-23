<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


/**
 * Create the section beneath the products tab
 **/
add_filter( 'woocommerce_get_sections_products', 'overlay_1_add_section' );

function overlay_1_add_section( $sections ) {
	
	$sections['overlay_1'] = __( 'Out of Stock', 'woo-overlay_1' );
	return $sections;
	
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_products', 'overlay_1_all_settings', 10, 2 );

function overlay_1_all_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'overlay_1' ) {
		$settings_overlay_1 = array();

		$p = plugins_url('assets/', dirname(__FILE__));
		$arr = array();
		array_push($arr, 'banner-diagnoal.png');
		array_push($arr, 'sign-pin.png');
		array_push($arr, 'sold-out-banner.png');
		array_push($arr, 'sold-out-stamp.png');
		array_push($arr, 'stamp-semi-diagonal.png');
		array_push($arr, 'banner-diagnoal.png');
		var_dump($arr);

		foreach ($arr as $var) {
			$text = $p . $var;
			echo '<br>'.$text;
		}
		// Add Title to the Settings
		$settings_overlay_1[] = array( 'name' => __( 'Woo Out of Stock Settings', 'woo-overlay_1' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure Woo Out of Stock Products', 'woo-overlay_1' ), 'id' => 'overlay_1' );
		// Add first checkbox option
		/*$settings_overlay_1[] = array(
			'name'     => __( 'Disable Overlay', 'woo-overlay_1' ),
			'desc_tip' => __( '', 'woo-overlay_1' ),
			'id'       => 'disable_overlay_1_overlay',
			'type'     => 'checkbox',
			//'css'      => 'min-width:300px;',
			'desc'     => __( '<small>&nbsp;Check this to <b>DISABLE</b> the out of stock overlay</small>', 'woo-overlay_1' )
		);*/
		// Add second text field option
		$settings_overlay_1[] = array(
			'name'     => __( 'Backgroound Size', 'woo-overlay_1' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-overlay_1' ),
			'id'       => 'overlay_1_image_position',
			'type'     => 'text',
			'desc'     => __( '', 'woo-overlay_1' ),
			'placeholder' => 'center top',
			'class'    => ''
		);


		$settings_overlay_1[] = array(
			'name'     => __( 'Background Position', 'woo-overlay_1' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-overlay_1' ),
			'id'       => 'overlay_1_image_position',
			'type'     => 'text',
			'desc'     => __( '', 'woo-overlay_1' ),
			'placeholder' => 'center top',
			'class'    => ''
		);
		$settings_overlay_1[] = array(
			'name'     => __( 'Background Color', 'woo-overlay_1' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-overlay_1' ),
			'id'       => 'overlay_1_image_position',
			'type'     => 'text',
			'desc'     => __( '', 'woo-overlay_1' ),
			'placeholder' => 'center top',
			'class'    => ''
		);

		$settings_overlay_1[] = array(
			'name'     => __( 'Background Repeat', 'woo-overlay_1' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-overlay_1' ),
			'id'       => 'overlay_1_image_position',
			'type'     => 'text',
			'default' => 'center top',
			'autoload' => false,
			///'desc'     => __( '', 'woo-overlay_1' ),
			'placeholder' => 'center top',
			'class'    => ''
		);

		$settings_overlay_1[] = array(
			'name'     => __( 'Image Opacity', 'woo-overlay_1' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-overlay_1' ),
			'id'       => 'overlay_1_image_opacity',
			'type'     => 'text',
			'desc'     => __( '', 'woo-overlay_1' ),
			'placeholder' => '.8',
			'class'    => ''
		);
		

		
		$settings_overlay_1[] = array(
			'name'     => __( 'Overlay Image URL', 'woo-overlay_1' ),
			'desc_tip' => __( 'This will be the URL of the image you are using for the Out of Stock overlay. Make sure it is a <b>PNG</b>', 'woo-overlay_1' ),
			'id'       => 'overlay_1_image_url',
			'type'     => 'text',
			'desc'     => __( '&nbsp;Make sure your image is a <b>PNG!</b>', 'woo-overlay_1' ),
			'class'    => 'overlay-input'
		);

		$settings_overlay_1[] = array(
			'name'     => __( 'Overlay Image URL', 'woo-overlay_1' ),
			'desc_tip' => __( 'This will be the URL of the image you are using for the Out of Stock overlay. Make sure it is a <b>PNG</b>', 'woo-overlay_1' ),
			'id'       => 'overlay_1_image_url',
			'type'     => 'submit',
			'desc'     => __( '&nbsp;Make sure your image is a <b>PNG!</b>', 'woo-overlay_1' ),
			'class'    => 'button-secondary delete'
		);

		$settings_overlay_1[] = array('<input class="" id="asdf" name="asdf" type="submit" value="Delete Alt Tags"  />');

		$settings_overlay_1[] = array( 'type' => 'sectionend', 'id' => 'overlay_1' );
		return $settings_overlay_1;
	
	/**
	 * If not, return the standard settings
	 **/
	} else {
		return $settings;
	}
}

?>