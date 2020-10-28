<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_social_share_button_shortcodes{
	
    public function __construct(){
		
		add_shortcode( 'social_share_button', array( $this, 'social_share_button_display' ) );
		
		//add_filter('the_content',array( $this, 'social_share_button_display' ));
   		}
		
		

	public function social_share_button_display($atts, $content = null ) {

        $atts = shortcode_atts(
            array(
                'themes' => 'theme1',
                ), $atts);

        $html = '';

        $social_share_button_settings = get_option( 'social_share_button_settings' );
        $theme = $social_share_button_settings['theme'];
        $custom_css = $social_share_button_settings['custom_css'];
        $themes = $theme;


        //$themes = $_GET['themes'];


        $class_social_share_button_functions = new class_social_share_button_functions();
        $social_share_button_themes_dir = $class_social_share_button_functions->social_share_button_themes_dir();
        $social_share_button_themes_url = $class_social_share_button_functions->social_share_button_themes_url();

        ob_start();

        echo '<link  rel="stylesheet"  href="'.$social_share_button_themes_url[$themes].'/style.css" >';

        include $social_share_button_themes_dir[$themes].'/index.php';

        echo $html;


        ?>
        <style type="text/css"><?php echo $custom_css; ?></style>
        <?php

        return ob_get_clean();




    }
		
	
			
}

new class_social_share_button_shortcodes();