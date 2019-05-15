<?php
/**
 * Plugin Name: Magnific Slider Form
 * Plugin URI: http://zone-ofgenius.com
 * Description: Content form inside the http://zone-ofgenius.com site. Add this shortcode [hbms-form redirect_url='' is_test={1,0}] to display the content.
 * Version: 1.0
 * Author: Kevin Ngaleu
 * Author URI: http://zone-ofgenius.com
 * License: A "Slug" license name e.g. GPL2
 */
 
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Start writing code after this line!

require_once("vendor/autoload.php");


if( !defined('ABSPATH') ){	die(); }

define('__HBMS_ROOT__', dirname( __FILE__ ));


function get_assets_style() {
	
	wp_enqueue_style( 'bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' );
	wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css' );
	wp_enqueue_style( 'custom-css', plugins_url('/assets/form.css', __FILE__) ); 
}

function get_assets_script() {	
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js', array(), null, true );
	wp_enqueue_script( 'jquery-easin', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'custom-js', plugins_url('/assets/form.js', __FILE__), array('jquery'), null, true );
}

/*
 *
 * [hbms-form redirect_url='' is_test={1,0}]
 *
 */

function build_content_shortcode($attrs){
	
	if( is_array($attrs) ) extract($attrs);	
	
	$redirect_url = ( isset($redirect_url) )? $redirect_url : '';
	$is_test = ( isset($is_test) ) ? $is_test : false;	
	
	ob_start();
	
	require_once __HBMS_ROOT__.'/templates/home.php';
	
	$content = ob_get_clean();
	
	return $content;
}

add_action('wp_enqueue_scripts', 'get_assets_style');
add_action('wp_enqueue_scripts', 'get_assets_script');
add_shortcode('multistep-slider', 'build_content_shortcode');

if(isset($_GET['FNAME'])) {
	// Put form varialble in session
	$_SESSION['form-data'] = $_GET;
	require_once('core/mailerlite.php');
}

include_once plugin_dir_path( __FILE__ ).'/core/hbms-plugin.class.php';

new HBMS_Plugin();
?>

<?php
	if(isset($_SESSION['slider-form-error']) && $_SESSION['slider-form-error'] != '') {
		$_SESSION['slider-form-error'] = '';
?>
	<script>
		document.getElementsByTagName('aside').innerHTML = 'JOJO'
		alert('Some Error Occured, Please try again.')
	</script>
<?php
	}
?>