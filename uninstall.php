<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//Hey there guy.

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
/**
class Outofstock_Uninstall() {

	public $rows, $key, $count, $base, $options, $key_options, $active;


	public function delete_base_options() {
		$options = array('outofstock_2_classes', 'outofstock_2_licnse_key',
						 'outofstock_2_rows', 'outofstock_2', 'outofstock',
						  'outofstock_2', 'outofstock_2_uninstall', 'outofstock_image_url');

		if ($options) {

			foreach ($options as $opt) {
				delete_option( $opt );
			}

		}

	}

	public function delete_key_options() {
		$key_options = array('outofstock_2_selector_',
						 'outofstock_2_background_size_', 'outofstock_2_background_position_',
						 'outofstock_2_background_color_', 'outofstock_2_background_repeat_', 
						 'outofstock_2_image_opacity_', 'outofstock_2_image_url_');
		$rows = get_option('outofstock_2_rows');

		if ($rows) {

			for ($i=0; $i < $rows; $i++) {

				foreach ($key_options as $opt) {
					$str = $opt . $i;
					delete_option( $str );
				}

			}
		}
	}

}

if (is_admin())
$uninstall = new Outofstock_Uninstall();
//$uninstall->delete_base_options();
//$uninstall->delete_key_options;
