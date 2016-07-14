<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

class WosReset {

	public $arr_2, $rows;

	public function __construct() {
		$arr_2 = array();
		$rows = get_option('outofstock_2_max_rows');
	}

	public function get_wos_options() {
		$arr_2 = array();
		$rows = get_option('outofstock_2_max_rows');
		for ($k=0; $k<$rows; $k++) {
			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_color_'.$k,
								   'value'=> get_option('outofstock_2_background_color_'.$k)));

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_position_'.$k,
								   'value'=> get_option('outofstock_2_background_position_'.$k)));
					array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_repeat_'.$k,
								   'value'=> get_option('outofstock_2_background_repeat_'.$k)));
			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_size_'.$k,
								   'value'=> get_option('outofstock_2_background_size_'.$k)));

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_image_opacity_'.$k,
								   'value'=> get_option('outofstock_2_image_opacity_'.$k)));
			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_image_url_'.$k,
								   'value'=> get_option('outofstock_2_image_url_'.$k)));

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_selector_'.$k,
								   'value'=> get_option('outofstock_2_selector_'.$k)));

			$aaa = get_option('outofstock_2_classes');
			$var = get_option('outofstock_2_selector_'.$k);
			$cla = $aaa[intval($var)];

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_class_'.$k,
								   'value'=> $cla));

		

		}

		foreach ($arr_2 as $value) {//for ($p = 0; $p <= count($arr_2); $p++ ) {

			$id = $value['id'];

			$option = $value['option'];
			$value = $value['value'];

			delete_option($option);
		}
		delete_option('outofstock_2_classes');
		delete_option('outofstock_2_license_key');
		delete_option('outofstock_2_rows');
		delete_option('outofstock_2_max_rows');
		delete_option('outofstock_sec');
		
	}

}

//$reset = new WosReset();
//$reset->get_wos_options();