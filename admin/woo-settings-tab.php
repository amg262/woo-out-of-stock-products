<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
require_once('class-woo-reset.php')

/**
 * Create the section beneath the products tab
 **/
add_filter( 'woocommerce_get_sections_products', 'outofstock_2_add_section' );

function outofstock_2_add_section( $sections ) {
	
	$sections['outofstock'] = __( 'Out of Stock / Image Overay', 'woo-outofstock' );
	return $sections;
	
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_products', 'outofstock_2_all_settings', 10, 2 );

function outofstock_2_all_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/

	if (isset($_POST['reset_wos_options'])) {
        $reset = new WosReset();
        $reset->get_wos_options();
    }
	if ( $current_section == 'outofstock' ) {
		submit_button();
		submit_button( 'Delete', 'delete button-primary', 'reset_wos_options' );
		$settings_outofstock = array();

		$p = plugins_url('assets/', dirname(__FILE__));
		$arr = array();
		$sel = array();
		$nums = array();

		$classes = array();
		$native_classes = array(
			'has-post-thumbnail','downloadable','virtual','shipping-taxable',
			'purchasable','product-type-variable','has-children','instock','outofstock'
		);
		array_push($arr, 'banner-diagnoal.png');
		array_push($arr, 'sign-pin.png');
		array_push($arr, 'sold-out-banner.png');
		array_push($arr, 'sold-out-stamp.png');
		array_push($arr, 'stamp-semi-diagonal.png');
		array_push($arr, 'banner-diagnoal.png');

		for ($i=0; $i<=10; $i++) {
			array_push($nums, $i);
		}
		//var_dump($arr);

		/*foreach ($arr as $var) {
			$text = $p . $var;
			echo '<br>'.$text;
		}*/

		$rows = 0;
		$rows = get_option('outofstock_2_rows');
		$sec = get_option('outofstock_sec');
		

		//var_dump($rows);

		/*
		* LOOP FOR GETTIGN ALL PRODUCT CATEGORIES
		*/
		$taxonomy     = 'product_cat';
		$orderby      = 'name';  
		$show_count   = 0;      // 1 for yes, 0 for no
		$pad_counts   = 0;      // 1 for yes, 0 for no
		$hierarchical = 1;      // 1 for yes, 0 for no  
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$all_categories = get_categories( $args );

		foreach ($all_categories as $cat) {

			if($cat->category_parent == 0) {
			    $category_id = $cat->term_id;
			    array_push($sel, $cat->slug);
			    //echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';

			    $args2 = array(
			            'taxonomy'     => $taxonomy,
			            'child_of'     => 0,
			            'parent'       => $category_id,
			            'orderby'      => $orderby,
			            'show_count'   => $show_count,
			            'pad_counts'   => $pad_counts,
			            'hierarchical' => $hierarchical,
			            'title_li'     => $title,
			            'hide_empty'   => $empty
			    );
			    $sub_cats = get_categories( $args2 );
			    if($sub_cats) {
			        foreach($sub_cats as $sub_category) {
			            //echo   ;
			            //array_push($sel, strtolower($sub_category->name));
			            array_push($sel, $sub_category->slug);
			        }   
			    }
			}       
		}

		/*
		* LOOP FOR GETTIGN ALL PRODUCTS
		*/
		$args = array( 
                'post_type' => 'product', 
                'orderby' => 'id', 
                'order' => 'ASC',
                //'product_cat' => 'My Product Category',
                'post_status' => 'publish');
		$posts = query_posts($args);

		foreach ($posts as $prod) {
			array_push($sel, 'post-'.$prod->ID);
		}

		/**
		* LOOP FOR ADDING NATIVE CLASSES
		*/
		foreach ($native_classes as $class) {
			array_push($sel, $class);
		}
		//var_dump($sel);
		/*
		* LOOP FOR building all selecter classes for overlays
		*/
		$count = 0;
		foreach ($sel as $class) {
			//array_push($classes, array('id' => $count, 'value' => $class));
			//array_push($classes, array('id' => $count, 'class' => $class));
			array_push($classes, $class);
			//'opt_'.$i      => __( $arr[$i], 'woocommerce' )
			$count++;
		}

		//set_option('')
		//var_dump($classes);
		update_option( 'outofstock_2_classes', $classes );
		$c = get_option('selector_classes');
		//var_dump($c);
		//echo $c[1];

		//var_dump($posts);
		//$arr = array('instock','outofstock');

		// Add Title to the Settings
		$settings_outofstock[] = array( 'name' => __( 'Woo Out of Stock Settings', 'woo-outofstock' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure Woo Out of Stock Products', 'woo-outofstock' ), 'id' => '' );
		// Add first checkbox option
		/*$settings_outofstock[] = array(
			'name'     => __( 'Disable Overlay', 'woo-outofstock' ),
			'desc_tip' => __( '', 'woo-outofstock' ),
			'id'       => 'disable_outofstock_2_overlay',
			'type'     => 'checkbox',
			//'css'      => 'min-width:300px;',
			'desc'     => __( '<small>&nbsp;Check this to <b>DISABLE</b> the out of stock overlay</small>', 'woo-outofstock' )
		);*/
		// Add second text field option
		$settings_outofstock[] = array(
			'name'     => __( 'License Key', 'woo-outofstock' ),
			//'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
			'id'       => 'outofstock_2_license_key',
			'type'     => 'text',
			'desc'     => __( '&nbsp;<button class="button button-primary"><a id="submit" style="color:#FFF;">Save</a></button>', 'woo-outofstock' ),
			//'placeholder' => 'center top',
			'css'    => 'max-width:500px; width:550px;'
		);



		$settings_outofstock[] = array(
			'name'     => __( 'No. of Rows', 'woo-outofstock' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
			'id'       => 'outofstock_2_rows',
			'type'     => 'select',
			'class'    => 'wc-enhanced-select',
			'default' => 0,
			'desc'     => __( '&nbsp;', 'woo-outofstock' ),
			//'desc'     => __( '&nbps;<button class="button button-primary"><a id="submit" style="color:#FFF;">Add Row</a></button><hr style="float:left;width:90%;border: 1px solid #000;margin-top: 35px;margin-bottom:15px;">', 'woo-outofstock' ),
			//'placeholder' => 'center top',
			'css'    => 'max-width:70px;width:100%; text-align:center;',
			'options' => __( $nums, 'woo-outofstock')
		);

		//$settings_outofstock[] = array(submit_button("Save"));

		$settings_outofstock[] = array(
			'name'     => __( 'Woo Secs', 'woo-outofstock' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
			'id'       => 'outofstock_sec',
			'type'     => 'hidden',
			'desc'     => __( '', 'woo-outofstock' ),
			'placeholder' => '',
			'class'    => ''
		);
	

		if ($rows > 0):

			for ($i = 0; $i < $rows; $i++) {
				//echo '<hr>';

			$settings_outofstock[] = array(
				'title'    => __( 'Selector Class', 'woocommerce' ),
				'desc'     => __( 'This option lets you limit which countries you are willing to sell to.', 'woocommerce' ),
				'id'       => 'outofstock_2_selector_'.$i,
				'default'  => __('', 'woo-outofstock'),
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'css'      => 'min-width: 350px;',
				'desc_tip' =>  true,
				//'options'  => array(
				//	'opt_'.$i      => __( $arr[$i], 'woocommerce' ),
				//)
				'options' => __( $classes, 'woo-outofstock')
			);
			/*$settings_outofstock[] = array(
				'name'     => __( 'Backgroound Size', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_size_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => '100% 100%',
				'default' => '100% 100%',
				'class'    => ''
			);*/


			$settings_outofstock[] = array(
				'name'     => __( 'Background Position', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_position_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => 'center top',
				'default' => 'center top',
				'class'    => ''
			);
			$settings_outofstock[] = array(
				'name'     => __( 'Background Color', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_color_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'default' => 'transparent',
				'class'    => ''
			);

			$settings_outofstock[] = array(
				'name'     => __( 'Background Repeat', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_repeat_'.$i,
				'type'     => 'text',
				//'default' => 'no-repeat',
				'autoload' => false,
				///'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => 'no-repeat',
				'default' => 'no-repeat',
				'class'    => ''
			);

			$settings_outofstock[] = array(
				'name'     => __( 'Image Opacity', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_image_opacity_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => '.8',
				'default' => '.8',
				'class'    => ''
			);
			

			
			$settings_outofstock[] = array(
				'name'     => __( 'Overlay Image URL', 'woo-outofstock' ),
				'desc_tip' => __( 'This will be the URL of the image you are using for the Out of Stock overlay. Make sure it is a <b>PNG</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_image_url_'.$i,
				'default' => plugins_url('assets/sign-pin.png', dirname(__FILE__)),
				'type'     => 'text',
				'desc'     => __( '&nbsp;Make sure your image is a <b>PNG!</b><hr style="float:left;width:90%;border: 1px dotted #CCC;margin-top: 35px;margin-bottom:15px;">', 'woo-outofstock' ),
				'class'    => 'overlay-input',
				'css' => 'max-width:700px;width:100%;'
			);
			//submit_button("Save Row");
			//echo '<br><hr><br>';
			
		}
		endif; ?>
		<?php
		$settings_outofstock[] = array( 'type' => 'sectionend', 'id' => 'outofstock_2' );
		
		return $settings_outofstock;
	
	/**
	 * If not, return the standard settings
	 **/
	} else {
		return $settings;
	}
}

?>