<?php
/**
 * Plugin Name: PayGate PayWeb3 plugin for WP eCommerce
 * Plugin URI: https://github.com/PayGate/PayWeb_WP_eCommerce
 * Description: Accept payments for WP eCommerce using PayGate's PayWeb3 service
 * Version: 1.0.4
 * Author: PayGate (Pty) Ltd
 * Author URI: https://www.paygate.co.za/
 * Developer: App Inlet (Pty) Ltd
 * Developer URI: https://www.appinlet.com/
 *
 * Copyright: © 2018 PayGate (Pty) Ltd.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

function paygate_activation()
{
    /**
     * Filters the path of the file to create.
     *
     * @since 1.0.3
     *
     * @param string $file Path to the file to create.
     */
    $plugin_dir  = plugin_dir_path( __FILE__ ) . 'library/paygate.php';
    $plugin_path = plugin_dir_path( __FILE__ );
    $r           = 'wp-e-commerce-gateway-paygate/';
    $plugin_path = str_replace( $r, '', $plugin_path );
    $theme_dir   = $plugin_path . 'wp-e-commerce/wpsc-merchants/paygate.php';
    if ( !copy( $plugin_dir, $theme_dir ) ) {
        echo "failed to copy $plugin_dir to $theme_dir...\n";
    }

    /**
     * Auto updates from GIT
     *
     * @since 1.0.4
     *
     */

    require_once 'library/updater.class.php';

    if ( is_admin() ) {
        // note the use of is_admin() to double check that this is happening in the admin

        $config = array(
            'slug'               => plugin_basename( __FILE__ ),
            'proper_folder_name' => 'wp-e-commerce-gateway-paygate',
            'api_url'            => 'https://api.github.com/repos/PayGate/PayWeb_WP_eCommerce',
            'raw_url'            => 'https://raw.github.com/PayGate/PayWeb_WP_eCommerce/master',
            'github_url'         => 'https://github.com/PayGate/PayWeb_WP_eCommerce',
            'zip_url'            => 'https://github.com/PayGate/PayWeb_WP_eCommerce/archive/master.zip',
            'homepage'           => 'https://github.com/PayGate/PayWeb_WP_eCommerce',
            'sslverify'          => true,
            'requires'           => '4.0',
            'tested'             => '4.9.8',
            'readme'             => 'README.md',
            'access_token'       => '',
        );

        new WP_GitHub_Updater( $config );

    }
}

register_activation_hook( __FILE__, 'paygate_activation' );

function paygate_deactivation()
{
    /**
     * Filters the path of the file to delete.
     *
     * @since 1.0.3
     *
     * @param string $file Path to the file to delete.
     */
    $plugin_path = plugin_dir_path( __FILE__ );
    $r           = 'wp-e-commerce-gateway-paygate/';
    $plugin_path = str_replace( $r, '', $plugin_path );
    $theme_dir   = $plugin_path . 'wp-e-commerce/wpsc-merchants/paygate.php';
    $delete      = apply_filters( 'paygate_deactivation', $theme_dir );
    if ( !empty( $delete ) ) {
        @unlink( $delete );
    }
}

register_deactivation_hook( __FILE__, 'paygate_deactivation' );
