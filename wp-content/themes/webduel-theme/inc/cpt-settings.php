<?php 
//Example from Codex page : http://codex.wordpress.org/Function_Reference/add_submenu_page
//Add this in your functions.php file, or use it in your plugin
class CptSettingsWebduel { 
   function __construct(){ 
    add_action('admin_menu', array($this, 'ourPluginSettingsLink'));
    add_action('admin_init', array($this, 'settings')); 
    }

    function settings(){ 
        add_settings_section('banner_first_section', null, null, 'banner-settings' );
        // for background color 
        add_settings_field('top_navbar_background_color', 'Top Banner Background Color', array($this, 'stylingHTML'), 'banner-settings','banner_first_section'); 
        register_setting('bannerSettings', 'top_navbar_background_color', array('sanitize_callback'=> 'sanitize_text_field', 'default'=> '#000000')); 

        // for font colour 
        add_settings_field('top_navbar_font_color', 'Top Banner Font Color', array($this, 'fontColorHTML'), 'banner-settings','banner_first_section'); 
        register_setting('bannerSettings', 'top_navbar_font_color', array('sanitize_callback'=> 'sanitize_text_field', 'default'=> '#000000')); 
    }
    // BACKGROUND COLOUR HTML 
    function stylingHTML(){ 
        ?>
            <select name="top_navbar_background_color" >
                <option value="#000000" <?php selected(get_option('top_navbar_background_color'),"#000000" ); ?>> Black</option>
                <option value="#474747" <?php selected(get_option('top_navbar_background_color'),"#474747" );?>> Dark Grey</option>
                <option value="#e60023" <?php selected(get_option('top_navbar_background_color'),"#e60023" );?>>Red</option>
                <option value="#061e55" <?php selected(get_option('top_navbar_background_color'),"#061e55" );?>> Blue</option>
            </select>
        <?php 
    }

    // font colour html
    function fontColorHTML(){ 
        ?>
            <select name="top_navbar_font_color" >
                <option value="#ffffff" <?php selected(get_option('top_navbar_font_color'),"#ffffff" ); ?>> White</option>
                <option value="#000000" <?php selected(get_option('top_navbar_font_color'),"#000000" );?>> Black</option>
                <option value="#474747" <?php selected(get_option('top_navbar_font_color'),"#474747" );?>>Dark Grey</option>
            </select>
        <?php 
    }
    function ourPluginSettingsLink() {
        add_submenu_page( 'edit.php?post_type=banners', 'Banner Settings', 'Banner Settings', 'manage_options', 'banner-settings', array($this, 'bannerSettings') ); 
      }
      
      function bannerSettings() {
       ?> 
       <div class="wrap">
           <h1>Banner Settings</h1>
           <form method="post" action="options.php">
                <?php 
                settings_fields('bannerSettings'); 
                do_settings_sections('banner-settings');
                submit_button();  
                ?>
           </form>
       </div>
       <?php 
      }
}



$cptSettingsWebduel = new CptSettingsWebduel(); 