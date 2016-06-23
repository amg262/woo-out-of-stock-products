<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
/**
* Script styles to run jQuery on pages
*/
add_action( 'wp_enqueue_scripts', 'outofstock_setup_scripts' );
//add_action( 'wp_enqueue_scripts', 'oss_styles' );

function outofstock_setup_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
}

	/**
	* Enqueue scripts
	*/
	//add_action('wp_footer','outofstock_scripts',5);

	function outofstock_scripts() { ?>

	<?php $outofstock_image_url = get_option('outofstock_image_url'); ?>

	<?php if ( isset( $outofstock_image_url ) ) { ?>

		<script type="text/javascript">

			jQuery(document).ready(function($){

				$(".outofstock a img").each(function() {

				});

		  	});

		</script>

		<?php } ?>

	<?php }

	function oss_styles() { ?>

		<style type="text/css">
		.outofstock .images a, 
			.products .outofstock a {
			    position:relative;
			    display:block;
			}
			.outofstock .images a:before, 
			.products .outofstock a:before {
			    content: " ";
			    height: 100%;
			    position: absolute;
			    width: 100%;
			    display: inherit !important;
			}
		</style>
	<?php }

	/**
	* Enqueue styles
	*/
	add_action('wp_footer','outofstock_styles',10);

	function outofstock_styles() { ?>
		<?php $rows = get_option('rows');
		//var_dump($rows); ?>
	<?php $outofstock_image_url = get_option('outofstock_image_url'); ?>

	<?php if (get_option('outofstock_image_url')) { ?>

		<style type="text/css">

			.outofstock .images a, 
			.products .outofstock a {
			    position:relative;
			    display:block;
			}
			.outofstock .images a:before, 
			.products .outofstock a:before {
			    content: " ";
			    height: 100%;
			    position: absolute;
			    width: 100%;
			    display: inherit !important;
			}

			<?php $background_image = "background-image: url(" . esc_url( $outofstock_image_url ) . ");" ?>

				.outofstock .images a:before {
				<?php echo $background_image; ?>
				background-color: transparent;
				background-repeat: no-repeat;
				background-position: center top;
				display: inherit !important; 
    			opacity: .8;
    			z-index: 1 !important;
    			float: none;
    			clear: both;
			}

			.products .outofstock a:before {
				<?php echo $background_image; ?>
				background-color: transparent;
				background-repeat: no-repeat;
				background-position: center top;
				display: inherit !important;
    			opacity: .8;
    			z-index: 1 !important;
    			float: none;
    			clear: both;
			}
			.products .outofstock .button:before {
				background:none !important;
				display: inherit !important;
				}
			.outofstock .images .thumbnails a:before {
				background:none !important;
				display: inherit !important;
			}

			</style>

		<?php } else {
			$outofstock_image_url = plugins_url('assets/sign-pin.png', dirname(__FILE__));
			if ($rows > 0):

				for ($i=0; $i<$rows; $i++) { ?>
					<?php $curr = get_option('selector_'.$i);
					var_dump($curr);
					//echo $curr; ?>
			<style type="text/css">
				.outofstock .images a, 
				.products .outofstock a {
				    position:relative;
				    display:block;
				}
				.outofstock .images a:before, 
				.products .outofstock a:before {
				    content: " ";
				    height: 100%;
				    position: absolute;
				    width: 100%;
				    display: inherit !important;
				}
			<?php $background_image = "background-image: url(" . $outofstock_image_url . ");" ?>

				.outofstock .images a:before {
				<?php echo $background_image; ?>
				background-color: transparent;
				background-repeat: no-repeat;
				background-position: center top;
				display: inherit !important; 
    			opacity: .8;
    			z-index: 1 !important;
			}

			.products .outofstock a:before {
				<?php echo $background_image; ?>
				background-color: transparent;
				background-repeat: no-repeat;
				background-position: center top;
				display: inherit !important;
    			opacity: .8;
    			z-index: 1 !important;
			}
			.products .outofstock .button:before {
				background:none !important;
				display: inherit !important;
				}
			.outofstock .images .thumbnails a:before {
				background:none !important;
				display: inherit !important;
			}

			</style>
			<?php }
			endif;
		 }
	}
