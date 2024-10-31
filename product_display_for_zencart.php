<?php  
/*
Plugin Name: Product Display for Zen Cart
Plugin URI:  https://www.thatsoftwareguy.com/wp_product_display_for_zencart.html
Description: Shows off a product from your Zen Cart based store on your blog.
Version:     1.0
Author:      That Software Guy 
Author URI:  https://www.thatsoftwareguy.com 
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zc_product_display
Domain Path: /languages
*/

function zc_product_display_shortcode($atts = [], $content = null, $tag = '')
{
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $id =  $atts['id']; 

    $zcpd_settings = get_option('zcpd_settings'); 
    $url = $zcpd_settings['zcpd_url'];
    $result = file_get_contents($url . "/wppd_zencart/index.php?id=".$id); 
    $data = json_decode($result, true); 

    // Escape data 
    $data['name'] = wp_kses_post($data['name']); 
    $data['price'] = wp_kses_post($data['price']); 
    $data['link'] = esc_url($data['link']); 
    $data['image'] = wp_kses_post($data['image']); 
    $data['description'] = wp_kses_post($data['description']); 

    // start output
    $o = '';
 
    // start box
    $o .= '<div class="zc_product_display-box">';
 
    $o .= '<div id="prod-left">' . '<a href="' . $data['link'] . '">' . $data['image'] . '</a>' . '</div>'; 
    $o .= '<div id="prod-right">' . '<a href="' .  $data['link'] . '">' . $data['name'] . '</a>' . '<br />' . $data['price'] . '</div>';  
    $o .= '<div class="prod-clear"></div>'; 
    $o .= '<div id="prod-desc">' . $data['description'] . '</div>';  

    // enclosing tags
    if (!is_null($content)) {
        // secure output by executing the_content filter hook on $content
        $o .= apply_filters('the_content', $content);
 
        // run shortcode parser recursively
        $o .= do_shortcode($content);
    }
 
    // end box
    $o .= '</div>';
 
    // return output
    return $o;
}
 
function zc_product_display_shortcodes_init()
{
    wp_register_style('zc_product_display', plugins_url('style.css',__FILE__ ));
    wp_enqueue_style('zc_product_display');

    add_shortcode('zc_product_display', 'zc_product_display_shortcode');
}
 
add_action('init', 'zc_product_display_shortcodes_init');

add_action( 'admin_menu', 'zcpd_add_admin_menu' );
add_action( 'admin_init', 'zcpd_settings_init' );


function zcpd_add_admin_menu(  ) { 

    add_options_page( 'Product Display for Zen Cart', 'Product Display for Zen Cart', 'manage_options', 'zen_cart_product_display_', 'zcpd_options_page' );

}


function zcpd_settings_init(  ) { 

    register_setting( 'zcpd_pluginPage', 'zcpd_settings' );

    add_settings_section(
        'zcpd_pluginPage_section', 
        __( 'Settings', 'wordpress' ), 
        'zcpd_settings_section_callback', 
        'zcpd_pluginPage'
    );

    $args = array('size' => '80'); 
    add_settings_field( 
        'zcpd_url', 
        __( 'Your Zen Cart URL', 'wordpress' ), 
        'zcpd_url_render', 
        'zcpd_pluginPage', 
        'zcpd_pluginPage_section', 
        $args 
    );


}


function zcpd_url_render($args) { 

    $options = get_option( 'zcpd_settings' );
    ?>
    <input type='text' name='zcpd_settings[zcpd_url]' value='<?php echo $options['zcpd_url']; ?>'
    <?php 
     if (is_array($args) && sizeof($args) > 0) {
        foreach ($args as $key => $value) { 
             echo $key . "=" . $value . " "; 
        }
     }
    ?>>
    <?php

}


function zcpd_settings_section_callback(  ) { 

    echo __( 'Settings required by this plugin', 'wordpress' );

}


function zcpd_options_page(  ) { 

    ?>
    <form action='options.php' method='post'>

        <h2>Product Display for Zen Cart</h2>

        <?php
        settings_fields( 'zcpd_pluginPage' );
        do_settings_sections( 'zcpd_pluginPage' );
        submit_button();
        ?>

    </form>
    <?php

}
