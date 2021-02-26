<?php
/**
 * Gtfo Again
 *
 * @wordpress-plugin
 * Plugin Name:       Gtfo again
 * Plugin URI:        https://rafalotech.com/plugins/wp/gtfo
 * Description:       Handles gtfo functions
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rafalo tech
 * Author URI:        https://rafalotech.com
 * Text Domain:       gtfo
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *  
 * @package           PluginPackage
 *
 * @author            Rafalo tech
 * @copyright         2021 Rafalo tech
 * @license           GPL-2.0-or-later
 */

class gtfo {
    function __construct() {
        add_action( 'gform_after_submission_2', [$this, 'login'], 10, 2 );
    }

    /**
     * Manages login functions
     * 
     * After successfull login, user redirects to admin panel
     *
     * @return void
     */
    public function login() {
        $user = get_user_by( 'email', isset( $_POST['input_2'] ) ? $_POST['input_2'] : '' );

        if ($user === false){
            wp_redirect( site_url() );
            exit;
        }

        $cred = [
            'user_login'    => $user->user_login,
            'user_password' => isset( $_POST['input_4'] ) ? $_POST['input_4'] : '',
            'remember'      => true,
        ];

        $logged = wp_signon( $cred );

        if ( ! is_wp_error( $logged ) ) {
            wp_redirect( admin_url() );
            exit;
        } else {
            wp_redirect( site_url() );
            exit;
        }

    }

    public function email_confirmation() {

    }

    public static function instance() {
        $created = false;

        if ( ! $created ) {
            $created = new self();
        }
    }
}

function create() {
    gtfo::instance();
}

create();
