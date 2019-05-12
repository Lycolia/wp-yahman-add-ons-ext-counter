<?php
/*
  Plugin Name: YAHMAN Add-ons PV widget extend
  Description: YAHMAN Add-ons page-view widget extend
  Version: 0.0.1
  Author: Lycolia
  License: GNU General Public License v3 or later
*/
class YAHMAN_PV_Widget_Ext extends WP_Widget {

	public function __construct() {
		parent::__construct(
      'yahman_pv_wid_ext',// Base ID
			'YAHMAN Add-ons PV widget extend', // Name
			array( 'description' => 'YAHMAN Add-ons page-view widget extend.' ) // Args
		);
	}

	/**
	 * display widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
    # get counter value
    $yahman_addons_count = get_option('yahman_addons_count');

    # put header
    echo $args['before_widget'];
    # put title
    echo '<h3 class="widget_title sw_title">カウンター</h3>';

    $i = 1;

    echo '<p class="ta_r">';
    $count_string = (string)$yahman_addons_count['pv']['all'];
    $count_length = strlen($count_string);
    $wp_content_url = content_url();
      
    # configure image width
    $img_width = 45 * $count_length;
    # create canvas
    $base_img = imagecreatetruecolor($img_width, 100);
    # fill canvas with purple
    imagefill($base_img, 0, 0, imagecolorallocate($base_img, 255, 0, 255));
    # set transparent color
    imagecolortransparent($base_img, imagecolorallocate($base_img, 255, 0, 255));
      
    # get png
    for ($idx = 0; $idx < 10; $idx++) {
      $counter_imgs[$idx] = imagecreatefrompng("./wp-content/plugins/yahman-add-ons-pv-ext/assets/". $idx . ".png");
    }
      
    # join png
    for ($idx = 0; $idx < $count_length; $idx++) {
        # dstImg, srcImg, dstX, dstY, srcX1, srcY1, srcX2, srcY2
      imagecopy($base_img, $counter_imgs[$count_string[$idx]], 45 * $idx, 0, 0, 0, 45, 100);
    }
      
    # destory png
    for ($idx = 0; $idx < 10; $idx++) {
      imagedestroy($counter_imgs[$idx]);
    }
      
    # output png
    ob_start();
    imagepng($base_img);
    imagedestroy($base_img);
    $img = ob_get_clean(); 
    $enc_img = base64_encode($img);
    echo "<img src=\"data:image/png;base64,{$enc_img}\" width=\"{$img_width}\" height=\"100\">";        echo '</p>';

    # put footer
    echo $args['after_widget'];
  }

	/**
	 * 管理用のオプションのフォームを出力
	 *
	 * @param array $instance ウィジェットオプション
	 */
	public function form( $instance ) {
		// TODO: そのうち作る
	}

	/**
	 * ウィジェットオプションの保存処理
	 *
	 * @param array $new_instance 新しいオプション
	 * @param array $old_instance 以前のオプション
	 */
	public function update( $new_instance, $old_instance ) {
		// TODO: そのうち作る
	}
}

# Plugin Register

function myplugin_register_widgets() {
	register_widget( 'YAHMAN_PV_Widget_Ext' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );