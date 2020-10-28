<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access

$nonce = isset($_GET['_wpnonce']) ? $_GET['_wpnonce'] : '';




?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br><?php echo "<h2>".social_share_button_plugin_name.' '.__('Migrate', 'social-share-button')."</h2>";?></div>

    <?php
    if(wp_verify_nonce( $nonce, 'nonce_social_share_button' )):
    ?>

    <div class="step-1">

        <?php


        $class_social_share_button_functions = new class_social_share_button_functions();
        $social_share_button_sites = $class_social_share_button_functions->social_share_button_sites();

        $social_share_button_display = array (
            0 =>
                array (
                    'location' => 'none',
                    'position' => 'after',
                    'posttype' => 'post',
                    'page_type' => 'single',
                ),
        );


        $social_share_button_total = get_option( 'social_share_button_total', '3' );
        $social_share_button_sites = get_option( 'social_share_button_sites', $social_share_button_sites );
        $social_share_button_theme = get_option( 'social_share_button_theme','theme1' );
        $social_share_button_more_display = get_option( 'social_share_button_more_display','yes' );
        $social_share_button_display_total_count = get_option( 'social_share_button_display_total_count','yes' );
        $social_share_button_display = get_option( 'social_share_button_display', $social_share_button_display );
        $social_share_button_count_format = get_option( 'social_share_button_count_format','short' );





        $i=0;
        foreach ($social_share_button_sites as $siteData){

            $title = !empty($siteData['title']) ? $siteData['title'] : '';
            $id = !empty($siteData['id']) ? $siteData['id'] : '';
            $share_url = !empty($siteData['share_url']) ? $siteData['share_url'] : '';
            $icon = !empty($siteData['icon']) ? $siteData['icon'] : '';
            $visible = !empty($siteData['visible']) ? $siteData['visible'] : '';


            if($id == 'google-plus'){
                continue;
            }


            $share_button_sites[$i]['title'] = $title;
            $share_button_sites[$i]['id'] = $id;
            $share_button_sites[$i]['share_url'] = $share_url;

            if($id == 'email'){
                $share_button_sites[$i]['icon'] = '<i class="far fa-envelope"></i>';
            }
            elseif($id == 'facebook'){
                $share_button_sites[$i]['icon'] = '<i class="fab fa-facebook-f"></i>';
            }
            elseif($id == 'linkedin'){
                $share_button_sites[$i]['icon'] = '<i class="fab fa-linkedin-in"></i>';
            }
            elseif($id == 'reddit'){
                $share_button_sites[$i]['icon'] = '<i class="fab fa-reddit-alien"></i>';
            }

            else{
                $share_button_sites[$i]['icon'] = '<i class="fab fa-'.$icon.'"></i>';
            }


            $share_button_sites[$i]['visible'] = $visible;


            $i++;

        }




        $social_share_button_settings['max_button_count'] = $social_share_button_total;
        $social_share_button_settings['display_more_button'] = $social_share_button_more_display;
        $social_share_button_settings['display_total_count'] = $social_share_button_display_total_count;
        $social_share_button_settings['count_format'] = $social_share_button_count_format;
        $social_share_button_settings['sharing_media'] = $share_button_sites;
        $social_share_button_settings['theme'] = $social_share_button_theme;

        $social_share_button_settings['custom_css'] = '';


        //var_dump($social_share_button_settings);


        update_option('social_share_button_settings',$social_share_button_settings);





        ?>


    </div>
    <div class="step-2">


        <p>Thanks for update!</p>




    <?php


    update_option('social_share_button_migrate_2_1_6','done');
    ?>

    </div>

    <?php
    endif;
    ?>
</div>