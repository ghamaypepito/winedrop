<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/
if ( ! defined('ABSPATH')) exit;  // if direct access 

function social_share_button_number_short($number){

    $short_value = $number;

    if($number>1000000000000){
        $short_value = round(($number/1000000000000),1).'t+';
    }
    else if($number>1000000000){
        $short_value = round(($number/1000000000),1).'b+';
    }
    else if($number>1000000){
        $short_value = round(($number/1000000),1).'m+';
    }
    else if($number>1000){
        $short_value = round(($number/1000),1).'k+';
    }

    return $short_value;

}


function social_share_button_filter_buttons_before_extra($html){


    $social_share_button_settings = get_option( 'social_share_button_settings' );
    $display_total_count = $social_share_button_settings['display_total_count'];
    $count_format = $social_share_button_settings['count_format'];


   // var_dump('Hello');

	$social_share_button_tc_text = get_option('social_share_button_tc_text' ,'Total Share');
	$social_share_button_tc_themes = get_option('social_share_button_tc_themes');

	if($display_total_count == 'yes'){

		$share_count = get_post_meta( get_the_ID(), 'social_share_button_share_count', true );
		$total_count = 0;
		//var_dump($share_count);
		if(!empty($share_count)){
			foreach($share_count as $key=>$count){
				$total_count +=$count;
			}
		}


        if($count_format=='short'){


            $total_count = social_share_button_number_short($total_count);
        }


		$html.= '<span class="total-share '.$social_share_button_tc_themes.'">';
		$html.= '<i class="total-count-text">'.$social_share_button_tc_text.'</i> ';
		$html.= '<i class="total-count">'.$total_count.'</i> ';
		$html.= '</span>';


	}



	return $html;

}
add_filter('social_share_button_filter_buttons_before','social_share_button_filter_buttons_before_extra');







	
	
	function social_share_button_open_graph(){
		
		$data = '';
		
		if(is_singular()){
			
			$data.= '<meta property="og:title" content="'.get_the_title(get_the_ID()).'" />';
			$data.= '<meta property="og:url" content="'.get_permalink(get_the_ID()).'" />';
			
			if(has_post_thumbnail()){
				
				$team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
				$team_thumb_url = $team_thumb['0'];
				
				$data.= '<meta property="og:image" content="'.$team_thumb_url.'" />';
	
				}
								
			
			}
		

		
		echo $data;
		
		
		}
	add_action('wp_head','social_share_button_open_graph');








add_action('the_content', 'social_share_button_display_auto');

function social_share_button_display_auto($content){

    $related_post_settings = get_option('social_share_button_settings');

    $post_types_display = isset($related_post_settings['post_types_display']) ? $related_post_settings['post_types_display'] : array();

    $post_id = get_the_ID();
    $post_type = get_post_type($post_id);

    //var_dump($post_types_display);

    $posttype = $post_type;
    $enable = isset($post_types_display[$posttype]['enable']) ? $post_types_display[$posttype]['enable'] : 'no';

    //var_dump($enable);

    if($enable == 'yes'){

        $content_position = isset($post_types_display[$posttype]['content_position']) ? $post_types_display[$posttype]['content_position'] : array('');
        $paragraph_positions = isset($post_types_display[$posttype]['paragraph_positions']) ? $post_types_display[$posttype]['paragraph_positions'] : '';
        $headline_text = isset($post_types_display[$posttype]['headline_text']) ? $post_types_display[$posttype]['headline_text'] : '';

        $social_share_button_html  = do_shortcode('[social_share_button post_id="'.$post_id.'"  headline="'.$headline_text.'"]');

        $paragraph_positions = !empty($paragraph_positions) ? explode(',', $paragraph_positions) : array();


        //var_dump($paragraph_positions);

        $html = '';

        if( in_array('before', $content_position)){

            $html .= do_shortcode('[social_share_button post_id="'.get_the_id().'" headline="'.$headline_text.'"]');
        }


        if(!empty($paragraph_positions) && is_singular($post_type)){
            $split_by = "\n";
            $content_blocks = explode( $split_by, $content);
            $content_blocks = array_filter($content_blocks);
            $content_blocks_count = count($content_blocks);

            $positions = array();
            foreach ($paragraph_positions as $position){
                if(strpos($position, 'N') !== false){

                    $position = str_replace('N', $content_blocks_count, $position );
                    $position = eval("return ($position);");
                    $position = ($content_blocks_count == $position ) ? $position -1 : $position;

                    $positions[] = $position;
                }else{
                    $positions[] = $position;
                }
            }


            $content_html = '';

            $i = 1;
            foreach ($content_blocks as $content_block){

                if(in_array($i, $positions)){
                    $content_html .= $content_block.$social_share_button_html;
                }else{
                    $content_html .= $content_block;
                }

                $i++;
            }

            $html .= $content_html;

        }else{
            $html .= $content;
        }

        if( in_array('after', $content_position)){

            $html .= do_shortcode('[social_share_button post_id="'.get_the_id().'" headline="'.$headline_text.'"]');

        }

        return $html;

    }else{
        return $content;
    }


}










add_action('the_excerpt', 'social_share_button_display_on_excerpt');

function social_share_button_display_on_excerpt($excerpt){

    $related_post_settings = get_option('social_share_button_settings');

    $post_types_display = isset($related_post_settings['post_types_display']) ? $related_post_settings['post_types_display'] : array();

    global $post;
    $posttype = isset($post->post_type) ? $post->post_type : '';
    $enable = isset($post_types_display[$posttype]['enable']) ? $post_types_display[$posttype]['enable'] : 'no';

    if($enable == 'yes'){

        $excerpt_position = isset($post_types_display[$posttype]['excerpt_position']) ? $post_types_display[$posttype]['excerpt_position'] : array();
        $headline_text = isset($post_types_display[$posttype]['headline_text']) ? $post_types_display[$posttype]['headline_text'] : '';


        $html = '';

        if( in_array('before', $excerpt_position)){

            $html .= do_shortcode('[social_share_button post_id="'.get_the_id().'"  headline="'.$headline_text.'"]');
        }
        $html .= $excerpt;

        if( in_array('after', $excerpt_position)){

            $html .= do_shortcode('[social_share_button post_id="'.get_the_id().'"  headline="'.$headline_text.'"]');

        }


        return $html;

    }else{
        return $excerpt;
    }


}





















function social_share_button_ajax_update_count(){
		$current_site_id = sanitize_text_field($_POST['site_id']);
		$post_id = (int)sanitize_text_field($_POST['post_id']);
		
		$social_share_button_sites = get_option( 'social_share_button_sites' );
		$share_count = get_post_meta( $post_id, 'social_share_button_share_count', true );


		do_action('social_share_button_update_count', $post_id, $current_site_id);

		foreach($social_share_button_sites as $site_key=>$site_info){
				$site_id = $site_info['id'];
				if($current_site_id == $site_id){
						$social_share_button_share_count[$site_id] = (int)$share_count[$site_id]+1;

					}
				else{
						$social_share_button_share_count[$site_id] = (int)$share_count[$site_id];
					}
			}


		// update count
		update_post_meta( $post_id, 'social_share_button_share_count', $social_share_button_share_count );

		
		die();
	}



add_action('wp_ajax_social_share_button_ajax_update_count', 'social_share_button_ajax_update_count');
add_action('wp_ajax_nopriv_social_share_button_ajax_update_count', 'social_share_button_ajax_update_count');
	

