<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

if($social_share_button_count_format=='short'){


    $share_count_value = social_share_button_number_short($share_count_value);
}


$html_popup_buttons.= '<a target="_blank" href="'.$url.'" post-id="'.get_the_ID().'" class="share-button share-button-'.get_the_ID().' '.$site_info['id'].'" id="'.$site_info['id'].'" >';

$html_popup_buttons.= '<span class="button-icon">'.$site_info['icon'].'</i>
</span>';
$html_popup_buttons.= '<span class="button-name">'.$site_info['title'].'</span>';
$html_popup_buttons.= '<span class="button-count">'.$share_count_value.'</span>';				

$html_popup_buttons.= '</a>';