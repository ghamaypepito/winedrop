<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



$html_button.= '<a target="_blank" href="'.$url.'" post-id="'.get_the_ID().'" class="share-button share-button-'.get_the_ID().' '.$site_info['id'].'" id="'.$site_info['id'].'" >';

$html_button.= '<span class="button-icon">'.$site_info['icon'].'</span>';
$html_button.= '<span class="button-name">'.$site_info['title'].'</span>';


if($social_share_button_count_format=='short'){


    $share_count_value = social_share_button_number_short($share_count_value);
	}


$html_button.= '<span class="button-count">'.$share_count_value.'</span>';

$html_button.= '</a>';