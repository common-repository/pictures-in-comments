<?php
/*
Plugin Name: Pictures in Comments
Plugin URI: http://disuenosweb.es/blogitinerante/pictures-in-comments/
Description: Plugin para subir imágenes desde los comentarios
Author: Sebas MGC
Version: 0.1
Author URI: http://disuenosweb.es/equipo/sebas
*/

function PIC_writeForm(){

	include_once("config.php");

	// Comprobamos si el usuario está logueado
	if ( $authorized_to_users == "all" ||
		( $authorized_to_users == "reg" is_user_logged_in() ) ) {

		$plugin_path = plugins_url() . '/' . plugin_basename(dirname(__FILE__)) . '/';
		?>
		<iframe width="100%" id="pic_container" src="<?php echo $plugin_path; ?>form.php" frameborder="0">Tu navegador no soporta iframes... estás perdido. :D</iframe>
		<?
		
	}else{
		$url_base = $_SERVER['SERVER_NAME'];

		$url_fin = $_SERVER['REQUEST_URI'];

		$url_redirect = urlencode( "http://".$url_base.$url_fin."#respond" );
		
		$url_login = home_url( '/' )."wp-login.php?redirect_to=".$url_redirect."&reauth=1";
	
		?><p>Si haces login podrás añadir imágenes a los comentarios. <a href="<? echo $url_login; ?>" title="Ir a la página de login">Ir a la página de login</a></p><?
	
	}
}


// Añade formulario para imagen y acciones
add_action('comment_form', 'PIC_writeForm', 1);

?>
