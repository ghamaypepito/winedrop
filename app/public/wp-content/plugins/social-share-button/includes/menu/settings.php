<?php	


if ( ! defined('ABSPATH')) exit; // if direct access 






if(!empty($_POST['ssb_hidden'])) {

    $nonce = $_POST['_wpnonce'];
    if(wp_verify_nonce( $nonce, 'ssb_nonce' ) && $_POST['ssb_hidden'] == 'Y') {
        //if($_POST['ssb_hidden'] == 'Y') {
        //Form data sent


        $social_share_button_settings = stripslashes_deep($_POST['social_share_button_settings']);
        update_option('social_share_button_settings', $social_share_button_settings);



    }


}











$ssb_settings_tab = array();


$ssb_settings_tab[] = array(
    'id' => 'options',
    'title' => __('<i class="fas fa-laptop-code"></i> Options','social-share-button'),
    'priority' => 1,
    'active' => true,
);

$ssb_settings_tab[] = array(
    'id' => 'style',
    'title' => __('<i class="fas fa-palette"></i> Style','social-share-button'),
    'priority' => 2,
    'active' => false,
);

$ssb_settings_tab[] = array(
    'id' => 'display',
    'title' => __('<i class="fas fa-qrcode"></i> Display','social-share-button'),
    'priority' => 3,
    'active' => false,
);

$ssb_settings_tab[] = array(
    'id' => 'shortcode',
    'title' => __('<i class="far fa-file-code"></i> Shortcode','social-share-button'),
    'priority' => 4,
    'active' => false,
);

$ssb_settings_tab[] = array(
    'id' => 'custom_scripts',
    'title' => __('<i class="fas fa-code"></i> Custom Scripts','social-share-button'),
    'priority' => 4,
    'active' => false,
);

$ssb_settings_tab[] = array(
    'id' => 'help_support',
    'title' => __('<i class="far fa-question-circle"></i> Help & Support','social-share-button'),
    'priority' => 5,
    'active' => false,
);




$ssb_settings_tabs = apply_filters('ssb_settings_tabs', $ssb_settings_tab);


$tabs_sorted = array();
foreach ($ssb_settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $ssb_settings_tabs);


?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".sprintf(__('%s - Settings', 'social-share-button'), 'Social Share Button' )."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	    <input type="hidden" name="ssb_hidden" value="Y">



            <div class="settings-tabs vertical">
                <ul class="tab-navs">
                    <?php
                    foreach ($ssb_settings_tabs as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        ?>
                        <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                foreach ($ssb_settings_tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];


                    ?>

                    <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                        <?php
                        do_action('ssb_settings_tabs_content_'.$id, $tab);
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear clearfix"></div>





            <p class="submit">
                <?php wp_nonce_field( 'ssb_nonce' ); ?>
                <input class="button button-primary" type="submit" name="Submit" value="<?php echo __('Save Changes', 'social-share-button' ) ?>" />
            </p>
		</form>


</div> <!-- end wrap -->
