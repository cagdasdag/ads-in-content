<?php

namespace AIC_Admin;

/**
 * The code used in the admin.
 */
class Admin
{
    private $plugin_slug;
    private $version;
    private $option_name;
    private $settings;
    private $settings_group;

    public function __construct($plugin_slug, $version, $option_name)
    {
        $this->plugin_slug = $plugin_slug;
        $this->version = $version;
        $this->option_name = $option_name;
        $this->settings = get_option($this->option_name);
        $this->settings_group = $this->option_name . '_group';
    }

    /**
     * Generate settings fields by passing an array of data (see the render method).
     *
     * @param array $field_args The array that helps build the settings fields
     * @param array $settings The settings array from the options table
     *
     * @return string The settings fields' HTML to be output in the view
     */
    private function aic_custom_settings_fields($field_args, $settings)
    {
        $output = '
            <div class="aic_fields_wrapper">
                <div class="aic_ad_list">';
            if (isset($settings['aic_ad_title'])) {
                foreach ($settings['aic_ad_title'] as $key => $value) {
                    $output .= '
                        <div class="aic_field">
                            <div class="aic_field_title"><h3>' . $value . '</h3></div>
                            <div class="aic_field_body">
                                <div class="aic_field_body_title">
                                    <span>' . __('Ad Title', 'ads-in-content') . '</span>
                                    <input type="text" name="' . $this->option_name . '[aic_ad_title][' . $key . ']" value="' . $value . '" required>
                                </div>
                                <div class="aic_field_body_code">
                                    <span>' . __('Ad Code', 'ads-in-content') . '</span>
                                    <textarea id="" name="' . $this->option_name . '[aic_ad_code][' . $key . ']" rows="10" required>' . $settings['aic_ad_code'][$key] . '</textarea>
                                </div>
                                <a href="javascript:void(0)" class="button delete_ad">' . __('Delete', 'ads-in-content') . '</a>
                            </div>
                        </div>
                    ';
                }
            }

        $output .= '
                </div>            
                <script id="aic_field_template" type="text/template">
                    <div class="aic_field">
                        <div class="aic_field_title"><h3>' . __('New Ad', 'ads-in-content') . '</h3></div>
                        <div class="aic_field_body">
                            <div class="aic_field_body_title">
                                <span>' . __('Ad Title', 'ads-in-content') . '</span>
                                <input type="text" name="' . $this->option_name . '[aic_ad_title][%id%]" required>
                            </div>
                            <div class="aic_field_body_code">
                                <span>' . __('Ad Code', 'ads-in-content') . '</span>
                                <textarea id="" name="' . $this->option_name . '[aic_ad_code][%id%]" rows="10" required></textarea>
                            </div>
                        </div>
                    </div>
                </script>
                    
                <a href="javascript:void(0)" class="aic_new_add">' . __('Add New Ad', 'ads-in-content') . '</a>
            </div>
            ';

        return $output;
    }

    public function aic_adblock_notice() {
        ?>
        <style>
            @keyframes fadein{
                0% { opacity:0; }
                66% { opacity:0; }
                100% { opacity:1; }
            }

            @-webkit-keyframes fadein{
                0% { opacity:0; }
                66% { opacity:0; }
                100% { opacity:1; }
            }
            #aic-adblock-notice {
                animation: 2s ease 0s normal forwards 1 fadein;
            }
        </style>
        <div id="aic-adblock-notice" class="notice notice-error">
            <h2>Ads In Content</h2>
            <p>It seems like your AdBlocker is conflicting with the plugin. Or you may be getting this error because of Gutenberg is not active in your website. </p>
            <p>Please make sure that Gutenberg is active and that the AdBlocker is closed.</p>
        </div>
        <?php
    }

    public function aic_assets()
    {
        if( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) { 
            if ( function_exists( 'register_block_type' ) ) {
                wp_enqueue_script($this->plugin_slug . '-adblocker-removal', plugin_dir_url(__FILE__) . 'js/aic-adblocker-removal.js', ['jquery'], $this->version, true);
            }
        }
    }

    public function aic_register_settings()
    {
        register_setting($this->settings_group, $this->option_name);
    }

    public function aic_render_block($attributes)
    {
        $adCode = $this->settings['aic_ad_code'][$attributes['adKey']];
        $html = '<div class="aic_element" style="margin-top:5px; margin-bottom:5px;">' . $adCode . '</div>';

        return $html;
    }

    public function aic_get_current_count()
    {
        echo intval(get_option('aic_block_count'));
        wp_die();
    }

    public function aic_count_increase()
    {
        $count = intval(get_option('aic_block_count')) + 1;
        update_option('aic_block_count', $count);
    }

    public function aic_register_block()
    {
        wp_register_script(
            'ads-in-content-block',
            plugins_url('block.build.js', __FILE__),
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components')
        );

        if ( function_exists( 'register_block_type' ) ) {
            register_block_type('aic/block', array(
                'editor_script' => 'ads-in-content-block',
                'render_callback' => [$this, 'aic_render_block']
            ));
        }

        wp_localize_script('ads-in-content-block', 'ad_list', $this->settings);
    }

    public function aic_add_menus()
    {
        $plugin_name = Info::get_plugin_title();
        add_submenu_page(
            'options-general.php',
            $plugin_name,
            $plugin_name,
            'manage_options',
            $this->plugin_slug,
            [$this, 'aic_render']
        );
    }

    /**
     * Render the view using MVC pattern.
     */
    public function aic_render()
    {
        if (!get_option('aic_block_count')) {
            update_option('aic_block_count', 0);
        }


        wp_localize_script($this->plugin_slug, 'aic_block_count', array('ajax_url' => admin_url('admin-ajax.php')));

        $cssCode = wp_remote_get(plugin_dir_url(__FILE__) . 'css/aic-admin.css');
        $jsCode = wp_remote_get(plugin_dir_url(__FILE__) . 'js/aic-admin.js');
        echo '<style>'.$cssCode['body'].'</style>';
        echo '<script> var aic_block_count = {ajax_url: "'.admin_url('admin-ajax.php').'"}; '.$jsCode['body'].'</script>';


        // Generate the settings fields
        $field_args = [
            [
                'label' => 'aic_ad_title',
                'slug' => 'aic_ad_title',
                'type' => 'text'
            ],
            [
                'label' => 'aic_ad_code',
                'slug' => 'aic_ad_code',
                'type' => 'textarea'
            ]
        ];

        // Model
        $settings = $this->settings;

        // Controller
        $fields = $this->aic_custom_settings_fields($field_args, $settings);
        $settings_group = $this->settings_group;
        $heading = Info::get_plugin_title();
        $submit_text = esc_attr__('Submit', 'ads-in-content');

        // View
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/view.php';
    }
}
