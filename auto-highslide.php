<?php
/*
Plugin Name: Auto Highslide
Plugin URI: http://showfom.com/auto-hishslide-wordpress-plugin/
Description: This plugin automatically add HighSlide Image Effect in your blog and You don't Need To Change Anything! If you want to use other effect of HighSlide , please use <a href="http://wordpress.org/extend/plugins/highslide4wp/">HighSlide4WP</a> with <a href="http://wordpress.org/extend/plugins/add-highslide/">Add Highslide</a>.
Author: Showfom 
Author URI: http://showfom.com
Version: 1.0
Put in /wp-content/plugins/ of your Wordpress installation
*/
/* Add HighSlide Image Code */
add_filter('the_content', 'addhighslideclass_replace');
function addhighslideclass_replace ($content)
{   global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 class="highslide-image" onclick="return hs.expand(this);"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
/* Add HighSlide */
function highslide_head() {
	if( ! wp_script_is( 'highslide', 'done' ) ) {
		return;
	}

	$base = plugins_url( 'highslide/graphics/', __FILE__ );

	echo <<<EOF
		<script type="text/javascript">
			hs.graphicsDir = "$base";
			hs.outlineType = "rounded-white";
			hs.outlineWhileAnimating = true;
			hs.showCredits = false;
		</script>
EOF;

}
add_action('wp_head', 'highslide_head', 11 );

/**
 * Add highslide.js file
 */
function highslide_scripts() {
	wp_register_script( 'highslide', plugins_url( 'highslide/highslide-with-html.packed.js', __FILE__ ), null, 1 );
	wp_enqueue_script( 'highslide' );
}
add_action( 'wp_enqueue_scripts', 'highslide_scripts' );

/**
 * Add highslide css file.
 */
function highslide_styles() {
	wp_register_style( 'highslide', plugins_url( 'highslide/highslide.css', __FILE__ ), null, 1 );
	wp_enqueue_style( 'highslide' );
}
add_action( 'wp_print_styles', 'highslide_styles' );
